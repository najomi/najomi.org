<?php
$flash = bu::session('flash');
if(!is_array($flash))
    $flash = array();
foreach($flash as $k=>$v){
    
    if(!$v['valid'])
        unset($flash[$k]);
    else
        $flash[$k]['valid'] = false;
}

bu::session('flash',$flash);
