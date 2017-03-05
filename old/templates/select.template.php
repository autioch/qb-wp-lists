<form class="qb-wp-lists-key-form" method="get">
    <select name="qb-wp-lists-key" class="qb-wp-lists-key">
        <option value="-1">Wybierz...</option>
        <?php
        $translations = '';
        foreach ($this->itemList as $item) {
            $selected = '';
            if ($this->selectedId == $item->optionkey) {
                $selected = ' selected="selected"';
                $translations = $this->fieldArrayToValues($item, ['breed_pl', 'breed_en', 'breed_de']);
            } ?>
            <option value="<?php echo $item->optionkey ?>" <?php echo $selected ?> >
                <?php echo $item->optionvalue ?>
            </option>
        <?php 
        } ?>
    </select>
    <button type="submit" class="js-plain-search">Szukaj</button>
</form>
<?php
if (mb_strlen($translations) > 0) {
            echo '<p><em>', $translations, '</em></p>';
        }
