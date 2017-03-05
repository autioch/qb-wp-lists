<form class="qbc-key-form" method="get">
    <select name="qbc-key" class="qbc-key">
        <option value="-1">Wybierz...</option>
        <?php
        $translations = '';
        foreach ($this->itemList as $item) {
            $selected = '';
            if ($this->selectedKey == $item->optionkey) {
                $selected = ' selected="selected"';
                $translations = $this->fieldArrayToValues($item, array('breed_pl', 'breed_en', 'breed_de'));
            }
            ?>
            <option value="<?php echo $item->optionkey ?>" <?php echo $selected ?> >
                <?php echo $item->optionvalue ?>
            </option>
        <?php } ?>
    </select>
    <button type="submit" class="js-plain-search">Szukaj</button>
</form>
<?php
if (strlen($translations) > 0) {
    echo '<p><em>', $translations, '</em></p>';
}