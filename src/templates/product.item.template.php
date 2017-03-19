<div style="float:right;width:20em;margin-left:2em">
  <img style="width:20em" src="<?php echo $this->datas[0]->image ?>" title="<?php echo $this->datas[0]->label ?>"/>
</div>
<p><?php echo $this->datas[0]->description ?></p>
<h4>Przykładowy skład mieszanki gazonowej <?php echo $this->datas[0]->label ?> z 2015 roku.</h4>
<ul style="list-style-type:none;margin:0">
  <?php $composition = explode("\n", $this->datas[0]->composition) ?>
  <?php  foreach ($composition as $composition__item): ?>
    <li><?php echo $composition__item ?></li>
  <?php endforeach; ?>
</ul>
<h4>Dostępne opakowania</h4>
<table class="product-item__boxes">
  <tr>
    <th>Rozmiar</th>
    <th>Waga (gramy)</th>
    <th>Cena brutto (zł)</th>
  </tr>
<?php foreach ($this->datasExtras as $box):?>
  <tr>
    <td><?php echo $box->package_label ?></td>
    <td><?php echo $box->package_weight ?></td>
    <td><?php echo $box->price ?></td>
  </tr>
<?php endforeach; ?>
</table>
<div style="margin:2em 0">
  <a href="<?php echo get_permalink(get_page_by_path('sklep-zamowienie')->ID); ?>?product_id=<?php echo $this->datas[0]->id ?>">Zamów <?php echo $this->datas[0]->label ?></a>
</div>
<div>
  <a href="<?php echo get_permalink(get_page_by_path('sklep')->ID); ?>">Wróć do listy traw.</a>
</div>
