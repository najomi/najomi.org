<?php

if (php_sapi_name() == 'cli-server') {
  if (preg_match('/\.(?:png|jpg|jpeg|gif|js|css)$/', $_SERVER['REQUEST_URI'])) {
    return false;
  }
}

require_once 'vendor/autoload.php';
ob_start();
require_once 'lib/prj/cache.php';
include 'base.php';
include 'boot/spyc.php'; #библиотека для парсинга конфигов
include 'boot/bu_core.php';
include 'boot/bu_cache.php';
include 'boot/bu.php'; #магический класс который управляет всем-всем
include 'boot/bu_route.php';
include 'boot/bu_loader.php';
include 'boot/bu_url.php';
include 'boot/bu_statistic.php';
include 'boot/bu_logger.php';

bu::timer('init', 'system');
bu::hook(['preload', 'blank']);

BuLoader::setHttpString(RAW_HTTP_STRING);

bu::timer('Aplication start.', 'system');
BuLoader::doIt();
bu::timer('Aplication end.', 'system');

bu::hook(['postload', 'blank']);

$content = ob_get_contents();
ob_end_clean();

if (http_host() == 'local.bubujka.org:3000') {
  is_need_cache(false);
}

if (is_need_cache()) {
  cache_it(query_path(), $content);
}

echo $content;
