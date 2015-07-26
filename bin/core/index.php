<?php
$title = sf('%s %s',bu::lang('framework/name'),' смотрит на тебя =_+!');
$layout->title = $title;
$layout->content = bu::view('index_content');
