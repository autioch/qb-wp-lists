<?php

class qbWpListsShortcodeView
{
    public function render($view, $datas, $datasExtras = [])
    {
        global $wpdb;
        $this->datas = $datas;
        $this->datasExtras = $datasExtras;
        include qbWpListsFindTemplate($view);
    }

    public function fieldArrayToValues($item, $fields, $implode = ', ')
    {
        $result = [];
        foreach ($fields as $f) {
            if ($item->$f) {
                if ($f == 'email') {
                    $result[] = '<a href="mailto:' . $item->$f . '">' . $item->$f . '</a>';
                } else {
                    if ($f == 'website') {
                        $result[] = '<a href="http://' . $item->$f . '">' . $item->$f . '</a>';
                    } else {
                        $result[] = $item->$f;
                    }
                }
            }
        }

        return implode($implode, $result);
    }

    public function echoImage($item)
    {
        if ($item->image) {
            echo '<img src="', QBWPLISTS_URL, 'public/images/loading.png" class="qbc-item-image" data-src="', $item->image, '" alt=""/>';
        }
    }

    public function echoField($item, $id, $label = false)
    {
        if ($item->$id) {
            if ($label) {
                echo '<p>', $label;
            }
            echo $item->$id;
            if ($label) {
                echo '</p>';
            }
        }
    }

    public function echoChapterLink($item, $id, $title)
    {
        $check = $id . '_check';
        if ($item->$check && $item->$id) {
            echo '<li> <a href="#chapter-', $id, '">', $title, '</a> </li>';
        }
    }

    public function echoChapter($item, $id, $title)
    {
        $check = $id . '_check';
        if ($item->$check && $item->$id) {
            echo '<a name="chapter-', $id, '" id="chapter-', $id, '"></a>';
            echo '<h4>', $title, '</h4>';
            echo '<p>', $item->$id, '</p>';
            echo '<div></div>';
        }
    }

    public function echoList($string, $delimiter = ', ')
    {
        $list = explode($delimiter, $string);
        echo '<ul>';
        foreach ($list as $item) {
            echo '<li>', $item, '</li>';
        }
        echo '</ul>';
    }

    public function hasFields($item, $fields = [])
    {
        foreach ($fields as $f) {
            if (mb_strlen($item->$f) > 0) {
                return true;
            }
        }

        return false;
    }

    public function webLink($link)
    {
        ?><a target="_blank" href="http://<?php echo $link ?>"><?php echo $link ?></a><?php
    }

    public function pageTopLink()
    {
        echo '<p><a href="#page-top">Powrót na górę</a></p>';
    }

    public function formatDate($item, $id, $label = false)
    {
        if ($item->$id) {
            if ($label) {
                echo '<p>', $label;
            }
            echo date('d.m.Y', strtotime($item->$id));
            if ($label) {
                echo '</p>';
            }
        }
    }
}
