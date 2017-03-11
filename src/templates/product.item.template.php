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
<p>Przepraszamy, szczegóły opakowań w przygotowaniu.</p>
<div>
  <a href="<?php echo get_permalink(get_page_by_path('sklep')->ID); ?>">Powrót do listy produktów.</a>
</div>
