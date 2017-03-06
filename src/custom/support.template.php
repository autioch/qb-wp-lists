<ol>
<?php
foreach ($this->datas as $id => $item) {
    ?>
  <li>
    <a href="<?php echo $item->link ?>" title="<?php echo $item->question ?>"><?php echo $item->question ?></a>
  </li>
<?php

}
?>
</ol>
