<a name="group-top" id="group-top"></a>
<ul class="qbc-list">
    <?php
    $group = '';
    foreach ($this->itemList as $item) {
        if ($item->group_name != $group) {
            $group = $item->group_name;
            echo '<li> <a href="#group-', $item->group_id, '">', $group, '</a> </li>';
        }
    }
    ?>
</ul>
<?php
$group = '';
foreach ($this->itemList as $item):
    if ($item->group_name != $group) {
        echo '<a name="group-', $item->group_id, '" id="group-', $item->group_id, '"></a>';
//            if ($group != '') {
//                $this->pageTopLink();
//            }
        $group = $item->group_name;
        echo '<h3 class="entry-title">', $group, '</h3><div class="zkwp-bottom"></div>';
    }
    ?>
    <div class="qbc-item">
        <?php $this->echoImage($item) ?>
        <h4>
            <?php
            echo $item->name;
            if ($item->nickname) {
                echo ' ', $item->nickname;
            }
            ?>
        </h4>

        <p>Rasa: <?php echo $item->breed_name ?>
            <?php
            $translations = $this->fieldArrayToValues($item, array('breed_pl', 'breed_en', 'breed_de'));
            if (strlen($translations) > 0) {
                echo ' ( <em> ', $translations, ' </em> )';
            }
            ?>
        </p>
        <p>Tytuły: </p>
        <ul>
            <?php
            $titles = explode("\n", $item->title);
            foreach ($titles as $title) {
                echo '<li>', $title, '</li>';
            }
            ?>
        </ul>
        <?php $this->echoField($item, 'owner', 'Właściciel: '); ?>

    </div>
    <?php
endforeach;
$this->echoDisclosure();
