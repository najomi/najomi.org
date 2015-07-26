<?php
function write_log($file, $txt){
	$f = fopen('log/'.$file, 'a+');
	fwrite($f, date('c')." ".$txt."\n");
	fclose($f);
}


def('path', function(){
		return implode('/', bu::path());
	});

def_alias('bu::path', 'pth');

def_alias('bu::view', 'view');
def('dview', function($pth, $data){
		return view($pth, array('data'=>$data));
	});

def('map_dview', function($tpl, $array, $separator = ''){
                return implode($separator,
                               map(function($v) use($tpl){
                                               return dview($tpl, $v);
                                       },
                                       $array));
        });
def_sprintfer('cehr', '<div style="cehr"><center>-----------</center></div>');