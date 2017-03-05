<form class="qbcol-form" method="get">
    <select name="qbcol-key" class="qbcol-key">
        <option value="-1">Wybierz...</option>
        <?php foreach ($this->itemList as $item) : ?>
            <?php $selected = ($this->selectedKey == $item->optionkey) ? ' selected="selected"' : '' ?>
            <option value="<?php echo $item->optionkey ?>" <?php echo $selected ?> >
                <?php echo $item->optionvalue ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="qbcol-select-search">Szukaj</button>
</form>