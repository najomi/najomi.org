<?php
function first_letter($str){
	return mb_substr($str, 0, 1, 'utf8');
}

function group_by($fn, $array){
	$r = array();
	foreach($array as $k=>$v){
		$r[$fn($k, $v)][] = $v;
	}
	return $r;
}

function car($a){
	return reset($a);
}

function cdr($a){
	return end($a);
}


function group_by_column($groups, $columns){
	$return = array();
	$line = array();
	$total = 0;
	foreach($groups as $k=>$v){
		$c = count($v);
		$line[] = array($k, $c);
		$total += $c;
	}

	$optimal = floor($total / $columns);
	$col = 1;
	$col_sum = array();
	foreach($line as $v){
		$return[$col][car($v)] = $groups[car($v)];
		if(isset($col_sum[$col]))
			$col_sum[$col] += cdr($v);
		else
			$col_sum[$col] = cdr($v);
		if(($col_sum[$col] >= $optimal) and $col != $columns)
			$col++;
	}
	return $return;
}

function new_location($pth){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /$pth/".implode('/', bu::args()));
}

function is_man_link($str){
	if(first(explode(' ', $str)) == 'man')
		return true;
}

function first($a){
	return reset($a);
}

def('last', function($a){
		return end($a);
	});

def('but_last', function($a){
		$a = array_reverse($a);
		array_shift($a);
		return array_reverse($a);
	});

def('w', function($str){
		return explode(' ', $str);
	});

def_alias('array_map', 'map');

def('http_host', function(){
		return $_SERVER['HTTP_HOST'];
	});

def('pp', function($v){
		echo '<pre>'.print_R($v,true).'</pre>';
	});