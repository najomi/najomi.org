<?php
$config = array('controllersCore'=>'/bin/core',
                'controllersPrj' =>'/bin/prj',
                'controllersHostDir' =>'/bin',
                'viewCore' =>'/view/core/',
                'viewPrj' =>'/view/prj/',
                'viewHostDir' =>'/view/',
                'snipCore' =>'/lib/core/',
                'snipPrj' =>'/lib/prj/',
                'snipHostDir' =>'/lib/',
                'hookCore' =>'/hook/core/',
                'hookPrj' =>'/hook/prj/',
                'hookHostDir' =>'/hook/',
                'actCore' =>'/act/core/',
                'actPrj' =>'/act/prj/',
                'actHostDir' =>'/act/',
                'configCore' =>'/etc/core',
                'configPrj' =>'/etc/prj',
                'configHostDir' =>'/etc',
                'staticCore' =>'/public/core',
                'staticPrj' =>'/public/prj',
                'staticHostDir' =>'/public',
                'cache'=> '/cache'
                );
foreach ($config as $k=>$v)
    $config[$k] = BASE_DIRECTORY.$v;
?>
