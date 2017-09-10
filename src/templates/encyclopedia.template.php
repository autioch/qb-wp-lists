<ol>
<?php foreach ($this->datas as $id => $item) {
    ?>
  <li>
    <a href="<?php echo $item->link ?>" title="<?php echo $item->species ?>"><?php echo $item->species ?></a>
    <p><?php echo $item->description_short ?></p>
  </li>
  <?php
} ?>
</ol>
