<div>
<?php
foreach ($this->datas as $id => $item) {
    ?>
    <div style="float:left;width:48%;margin:1%">
      <div style="float:left; width: 10em">
        <a href="<?php echo $item->link ?>" title="<?php echo $item->label ?>">
          <img style="width:10em" src="<?php echo $item->image ?>" title="<?php echo $item->label ?>"/>
        </a>
      </div>
      <div style="float:left;width:calc(100% - 12em);margin-left:1em">
        <h4 style="margin-top:0"><?php echo $item->label ?></h4>
        <p><?php echo $item->description_short ?></p>
        <ul style="list-style-type:none;margin:0;padding:0">
          <li>
            <a href="<?php echo $item->link ?>" title="<?php echo $item->label ?>">Dowiedz się więcej</a>
          </li>
          <li>
            <a href="<?php echo get_permalink(get_page_by_path('sklep-zamowienie')->ID); ?>?product_id=<?php echo $item->id ?>">Zamów</a>
          </li>
        </ul>
      </div>
    </div>
<?php
}
?>
</div>
<div style="clear:both"></div>
