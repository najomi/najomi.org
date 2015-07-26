<?php
$pages = bu::session('pages');
if(!$pages)
    $pages = array();
if(isset($pages['current']))
    $pages['previous'] = $pages['current'];
else
    $pages['previous'] = '/';

$pages['current'] = RAW_HTTP_STRING;

bu::session('pages',$pages);
