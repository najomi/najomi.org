<?php
require_once 'vendor/autoload.php';
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
bu::lib('category');
bu::lib('models/example');
