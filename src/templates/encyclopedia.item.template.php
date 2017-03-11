<h3 class="qb-wp-lists__subtitle"><?php echo $this->datas[0]->label_latin ?></h3>
<p><?php echo $this->datas[0]->description_short ?></p>
<h4>Charakterystyka</h4>
<p><?php echo $this->datas[0]->description ?></p>
<h4>Wykorzystanie</h4>
<p><?php echo $this->datas[0]->usage ?></p>
<h4>Źródło</h4>
<p><?php echo $this->datas[0]->source ?></p>

<div>
  <a href="<?php echo get_permalink(get_page_by_path('encyklopedia-traw')->ID); ?>">Powrót do listy traw.</a>
</div>
