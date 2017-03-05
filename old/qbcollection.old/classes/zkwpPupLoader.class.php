<?php

class zkwpPupLoader
{
    private $cacheDuration;
    private $cacheFile;
    private $data;
    private $divisionId;
    private $sourceEncoding;
    private $url;

    public function __construct(/* array $options = array() */) {
//        $default = array(
//            'cacheDuration' => 1800, /* 60s * 30 */
//            'cacheFile' => 'pup-cache',
//            'divisionId' => '09', /* Koszalin */
//            'sourceEncoding' => 'ISO-8859-2',
//            'url' => 'http://www.zkwp.pl/zg/index.php?n=szczenieta',
//        );
//        $options = array_replace($default, $options);

        $options = [
            'cacheDuration' => get_option('zkwp_pup_cache_duration', 30) * MINUTE_IN_SECONDS,
            'cacheFile' => get_option('zkwp_pup_cache', ZKWP_TOOLS_DIR . 'pup/resources/pup-cache'),
            'divisionId' => get_option('zkwp_pup_department', '09'),
            'sourceEncoding' => 'ISO-8859-2',
            'url' => 'http://www.zkwp.pl/zg/index.php?n=szczenieta',
        ];

        $this->cacheDuration = $options['cacheDuration'];
        $this->cacheFile = $options['cacheFile'];
        $this->divisionId = $options['divisionId'];
        $this->sourceEncoding = $options['sourceEncoding'];
        $this->url = $options['url'];
    }

    public function getData() {
        if ($this->resultsCached()) {
            return $this->getCacheData();
        }
        $this->getZKWPData();
        $this->parseToJson();
        $this->format();
        $this->setCacheData();

        return $this->data;
    }

    private function resultsCached() {
        if (file_exists($this->cacheFile)) {
            if ((time() - filemtime($this->cacheFile)) < $this->cacheDuration) {
                return true;
            }
        }

        return false;
    }

    private function getCacheData() {
        return file_get_contents($this->cacheFile);
    }

    private function setCacheData() {
        file_put_contents($this->cacheFile, $this->data);
    }

    private function getZKWPData() {
        $postData = ['szukajoddzial' => $this->divisionId];
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'timeout' => 10,
                'content' => http_build_query($postData),
            ],
        ];
        try {
            $this->data = file_get_contents($this->url, false, stream_context_create($options));
        } catch (Exception $e) {
            echo '<br/> ops...' . $e->getMessage();
            $this->data = '';

            return;
        }
        $this->data = iconv($this->sourceEncoding, 'UTF-8', $this->data);
    }

    private function parseToJson() {
        /* cut important part */
        $from = mb_strpos($this->data, '<td width=300 bgcolor=ffffff align=left>');
        $to = mb_strpos($this->data, '      </table>') - $from;
        $this->data = mb_substr($this->data, $from, $to);

        /* ZKWP "markup" is a terrible, terrible thing */
        $search = [
            "<td width=300 bgcolor=ffffff align=left>\n<font size=2 color=666666 face=Verdana, Arial, Helvetica, sans-serif>\n",
            "\n</td>\n<td  bgcolor=ffffff align=left>\n<font size=2 color=666666 face=Verdana, Arial, Helvetica, sans-serif> \n",
            "\n</td>\n<td width=80 bgcolor=ffffff align=left>\n<font size=2 color=666666 face=Verdana, Arial, Helvetica, sans-serif>",
            "\n</td>\n<td width=80 bgcolor=ffffff align=left>\n<font size=2  color=666666 face=Verdana, Arial, Helvetica, sans-serif>",
            ' target=_blank>e-mail</a>',
            "\":\"\n",
            '<a href=mailto:',
            '<a href=http://',
            ' target=_blank>www</a>',
        ];

        $replace = [
            '{"name":"',
            '","phone":"',
            '","website":"',
            '","email":"',
            '"},',
            '":""},',
        ];
        $this->data = str_replace($search, $replace, $this->data);
        $this->data = preg_replace('/(<\/?[^>]+>|\n)/', '', $this->data);
        /* format to valid json
         * in previous version, class was returning json for ajax call */
        $this->data = '[' . mb_substr(trim($this->data), 0, -1) . ']';
    }

    private function format() {
        $this->data = json_decode($this->data, true);
        ob_start();
        include ZKWP_TOOLS_DIR . 'views/pup.view.php';
        $this->data = ob_get_clean();
    }

    private function formatPhoneNumbers($phones) {
        $list = explode(';', $phones);
        foreach ($list as $p) {
            echo preg_replace('/(.{1,3})/', '$1&nbsp;', preg_replace('/[^0-9\+]/', '', $p)), ' ';
        }
    }

    private function formatEmailAddresses($emails) {
        $list = explode(';', $emails);
        foreach ($list as $e) {
            echo '<a class="zkwp-table-link" href="mailto:', trim($e), '">', trim($e), '</a> ';
        }
    }

    private function googleLink($query, $title, $image = true) {
        $href = 'https://www.google.com/search?q=' . $query . ($image ? '&tbm=isch' : '');
        ?>
        <a class="zkwp-google-link" target="_blank" title="<?php echo $title ?>" href="<?php echo $href ?>">
            <img src="<?php echo ZKWP_TOOLS_URL, 'public/images/google.png' ?>">
        </a>
        <?php
    }

    private function webLink($link) {
        ?>
        <a target="_blank" href="http://<?php echo $link ?>">
            <?php echo $link ?>
        </a>             
        <?php
    }
}
