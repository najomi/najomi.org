<?php
function sf(){
	$args = func_get_args();
	return call_user_func_array('sprintf',$args);
}
function pf(){
	$args = func_get_args();
	return call_user_func_array('printf',$args);
}
function pr(){
	$args = func_get_args();
	return call_user_func_array('print_r',$args);
}
function ppr($val,$needReturn = false){
	$return = '<pre>';
	$return .= print_R($val,true);
	$return .= '</pre>';
	if($needReturn)
		return $return;
	else
		echo $return;
}
// stolen from rails
function h($str = ''){
    return htmlentities($str,ENT_COMPAT,'UTF-8');
}
