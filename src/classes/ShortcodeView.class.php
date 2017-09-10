<?php

class qbWpListsShortcodeView
{
    public function render($templateId, $datas, $datasExtras)
    {
        $this->datas = $datas;
        $this->datasExtras = $datasExtras;
        include qbWpListsFindTemplate($templateId);
    }

    public function image($imageUrl, $alt = '')
    {
        echo '<img src="', QBWPLISTS_URL, 'public/images/loading.png" class="qbc-item-image" data-src="', $imageUrl, '" alt=""/>';
    }

    public function externalLink($link, $label = false)
    {
        if (!$label) {
            $label = $link;
        }

        echo '<a target="_blank" href="http://', $link, '">',  $label, '</a>';
    }

    public function topLink($label)
    {
        echo '<a href="#page-top">', $label, '</a>';
    }

    public function formatDate($stringDate)
    {
        echo date('d.m.Y', strtotime($item->$id));
    }
}
