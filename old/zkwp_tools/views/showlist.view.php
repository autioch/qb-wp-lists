<h4><?php echo $this->extraParam ?></h4>
<table class="qbc-notable">
    <tbody>
        <?php foreach ($this->itemList as $item) { ?>
            <tr>
                <td class="is-short">
                    <?php
                    $this->formatDate($item, 'show_date');
                    if ($item->city) {
                        echo ', ', $item->city;
                    }
                    ?>
                </td>
                <td>
                    <a href="?qbc-key=<?php echo $item->id ?>"><?php echo $item->title ?></a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>