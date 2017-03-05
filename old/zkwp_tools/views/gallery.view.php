<?php
$year = '';
foreach ($this->itemList as $item) {
    if ($item->year != $year) {
        $year = $item->year;
        echo '<h3 class="entry-title">', $item->year, '</h3><div class="zkwp-bottom"></div>';
    }
    ?>
    <div class="qbc-item">
        <?php if ($item->thumbnail): ?> 
            <img src="http://zkwp-koszalin.pl/galeria/<?php echo $item->location ?>/thumbnail.jpg" class="qbc-item-image" alt=""/>
        <?php endif ?>
        <h4 class="entry-preview">
            <?php if ($item->outside): ?>
                <a target="_blank" href="<?php echo $item->location ?>"><?php echo $item->name ?></a>
            <?php else: ?>
                <a target="_blank" href="http://zkwp-koszalin.pl/galeria/<?php echo $item->location ?>"><?php echo $item->name ?></a>
            <?php endif; ?>
        </h4>
        <p class="entry-date">
            <?php
            if ($item->city) {
                echo $item->city, ', ';
            }
            echo date("d.m.Y", strtotime($item->event_date))
            ?>
        </p>
        <?php if ($item->description): ?>
            <p><?php echo $item->description ?></p>
        <?php endif ?>
    </div>       
    <?php
}
