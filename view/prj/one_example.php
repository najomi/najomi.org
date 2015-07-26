<?=dview('example', $data)?>
<? if($data->link()): ?>
<?=cehr()?>
<div id="links">

	 <? if(is_array($data->link())): ?>
	  Источники: <br>
	 <? foreach($data->link() as $v):?>
	 <?=nice_link($v)?><br>
	 <?endforeach ?>
	 <? else: ?>
 Источник: <br>
	 <?=nice_link($data->link())?>

	 <? endif ?>
</div>
<? endif ?>

<? if($data->prop('author')): ?>
<?=cehr()?>
<div id="links">
	 Автор: <br>
	 <?=$data->prop('author')?>
</div>
<? endif ?>
