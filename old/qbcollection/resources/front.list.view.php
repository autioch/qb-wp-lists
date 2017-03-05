<?php foreach ($this->itemList as $item) : ?>
    <div>    
        <?php foreach ($this->item as $field) : ?>
            <p><?php echo $field ?></p>
        <?php endforeach ?>
    </div>
<?php endforeach ?>

