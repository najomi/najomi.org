<?php
if(bu::config('rc/debugBar'))
    BuStatistic::printa();

$pages = bu::session('pages');
$pages['num_redirects'] = 0;
bu::session('pages',$pages);
