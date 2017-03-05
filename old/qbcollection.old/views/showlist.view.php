<h4><?php echo $this->extraParam ?></h4>
<?php foreach ($this->itemList as $item) { ?>
    <p class="zkwp-show">
        <span class="zkwp-show-date"><?php $this->formatDate($item, 'show_date') ?></span>
        <?php if ($item->city): ?>
            <span class="zkwp-show-city"><?php echo $item->city ?></span>
        <?php endif; ?>
        <span class="zkwp-show-title">
            <a href="?zkwp-tools-key=<?php echo $item->id ?>"><?php echo $item->title ?></a>
        </span>
    </p>
    <?php
}
