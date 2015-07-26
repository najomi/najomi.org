<?php
bu::lib('helpers/shortcut');
bu::hook('session/init');

if (bu::isValidRequest()){
    bu::hook('session/pages');
    bu::hook('session/flash');
    bu::hook('session/last_post');
}

bu::hook('php_activerecord');

bu::lib('global');
bu::lib('yaml/sfYamlParser');

require_once 'lib/prj/helpers/load.php';
foreach(glob('lib/prj/helpers/*.php') as $v)
	require_once $v;

foreach(glob('lib/prj/models/*.php') as $v)
	require_once $v;
