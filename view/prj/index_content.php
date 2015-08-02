<div id='info'>
  <div class="col-xs-6 pull-right">
    <div id='quote'>
      The book contains almost 500 examples of good and bad code. I’ve included so
      many examples because, personally, I learn best from examples. I think other
      programmers learn best that way too.
      <div id='author'>Steve McConnell, Code Complete 2nd edition</div>
    </div>
  </div>
  <div class="clearfix"></div>

  Этот сайт создаётся с идеей собрать как можно больше
  различных примеров по использованию консольных утилит и
  языков программирования.
  <br>
  <br>
  
  <div class="alert alert-info">
    <div class="alert-body">
      <p>
        Исходный код этого сайта и все его данные можно забрать с github:

        <ul>
          <li>
            <a href='https://github.com/najomi/data'>https://github.com/najomi/data</a>
          </li>
          <li>
            <a href='https://github.com/najomi/najomi.org'> https://github.com/najomi/najomi.org</a>
          </li>
        </ul>
      </p>
    </div>
  </div>
  <br>

</div>
<div id='subdirs'>
  <ul>
    <? foreach($data as $v):?>
    <li><a href='<?=$v->getHref()?>'><?=$v->getName()?></a></li>
<? endforeach ?>
</ul>
</div>

<div class='category-links'>
  Интересные материалы:
  <ul>
    <? foreach(unyaml('data/links.yaml') as $v): ?>
    <li>
      <? if(is_array($v)): ?>
      <a href='<?=car($v)?>'><?=car($v)?></a> <?=cdr($v)?>
      <? else: ?>
      <a href='<?=$v?>'><?=$v?></a>
      <? endif ?>
    </li>
    <? endforeach ?>
  </ul>
</div>
