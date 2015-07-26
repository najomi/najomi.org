<?php
def_md('sum', 5, function($a, $b){
		echo '.';
		return $a+$b;
	});
echo sum(1,2)."\n";
echo sum(1,2)."\n";
flush_md();
echo sum(1,2)."\n";
echo sum(1,2)."\n";
?>
---
.3
3
.3
3