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

<div id='discourse-comments'></div>

<script type="text/javascript">
  DiscourseEmbed = { discourseUrl: 'https://forum.bubujka.org/',
  discourseEmbedUrl: 'http://najomi.org/<?=path()?>' };

  (function() {
    var d = document.createElement('script'); d.type = 'text/javascript'; d.async = true;
    d.src = DiscourseEmbed.discourseUrl + 'javascripts/embed.js';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(d);
  })();
</script>
