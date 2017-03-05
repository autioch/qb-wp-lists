<a name="group-top" id="group-top"></a>
<ul class="zkwp-show-index">
    <?php
    $group = '';
    foreach ($this->itemList as $item):
        if ($item->group_name != $group) {
            $group = $item->group_name;
            echo '<li> <a href="#group-', $item->group_id, '">', $group, '</a> </li>';
        }
    endforeach;
    ?>
</ul>
<div class="zkwp-bottom"></div>
<div class="zkwp-tools-item-list">
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
        <div class="zkwp-tools-item">
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
                $translations = $this->fieldArrayToValues($item, ['breed_pl', 'breed_en', 'breed_de']);
                if (mb_strlen($translations) > 0) {
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
        <div class="zkwp-bottom"></div>
    <?php endforeach; ?>
</div>
<p class="zkwp-disclosure">
    Wszelkie informacje zawarte na tej stronie zostały podane przez 
    właścicieli psów. W celu aktualizacji danych prosimy o przesłanie informacji na adres 
    <a href="mailto:biuro@zkwp-koszalin.pl">biuro@zkwp-koszalin.pl</a>.
</p>