<?=bu::view('path_block')?>
<? if($data->getInfo()):?>
<div class='category_info'>
  <?=$data->getInfo()?>
</div>
<? endif ?>

<? if ($data->getSubDirs()):?>
<div id="subdirs">
	 <?
	 $sub_dirs = $data->getSubDirs();
if(count($sub_dirs) > 20){
	$groups = group_by(function($k, $v){ return strtolower(first_letter($v->getName())); },
			   $data->getSubDirs());
	ksort($groups);
	$columns = group_by_column($groups, 3);
	echo "<table><tr>";
	foreach($columns as $groups){
		echo "<td width='230px' style='vertical-align: top'>";
		foreach($groups as $letter => $group){
			echo "<h2>".strtoupper($letter)."</h2>";
			echo "<ul>";
			foreach($group as $v)
				echo "<li><a href='".$v->getHref()."'>".$v->getName()."</a></li>";
			echo "</ul>";
		}
		echo "</td>";
	}
	echo "</tr></table>";
}else{
	echo "<ul>";
	foreach($sub_dirs as $v)
		echo "<li><a href='".$v->getHref()."'>".$v->getName()."</a></li>";
	echo "</ul>";
}
?>
  </ul>

</div>

<? endif;?>


<? if($data->getUsage()):?>
<?=map_dview('example', $data->getUsage(), '<hr>')?>
<?=view('links-block',array('links'=>$data->getLinks(), 'title'=>'Источник', 'titles'=>'Источники'))?>
<?=view('links-block',array('links'=>$data->getAuthors(), 'title'=>'Автор', 'titles'=>'Авторы'))?>
<? else: ?>
<div class='no_examples'>
  <p>

Пока в этом разделе нет ни одного примера, но
вы можете помочь наполнить его - напишите для этого мне письмо на
<a href='mailto:zendzirou@gmail.com'>zendzirou@gmail.com</a>.
  </p>
  <p>




</div>
<? endif; ?>
<? if($data->meta('links')): ?>
<?=cehr()?>
<div class='category-links'>
	 <br>
	 Ссылки по теме:
	 <ul>
	<? foreach($data->meta('links') as $v): ?>
	<? if(!is_array($v)): ?>
	 <li> <?=nice_link($v)?> </li>
	<? elseif(count($v) == 1): ?>
	 <li> <?=nice_link(car($v))?> </li>
	<? else: ?>
	 <li> <?=nice_link(car($v))?> - <?=cdr($v)?> </li>
	<? endif ?>
	<? endforeach ?>
	 </ul>
</div>
<? endif ?>


