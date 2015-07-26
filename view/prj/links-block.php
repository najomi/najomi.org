<?
if($links){
	echo cehr();
	echo '<div id="links">';
	if(count($links) == 1)
		echo $title.": <br>";
	else
		echo $titles.": <br>";
	bu::lib('helpers/intervals');
	foreach ($links as $num=>$link){
		if(is_array($link)){
			foreach($link as $v)
				$t[$v][] = $num;
		}else{
			$t[$link][] = $num;
		}
	}

	$return = array();
	foreach ($t as $k=>$v){
		$link = nice_link($k);
		$return[] = '<li>'.implode(', ', make_intervals($v)).' - '.$link."</li>\n";
	}
	echo "<ul>".implode("\n",$return)."</ul>";
	echo '</div>';
}

