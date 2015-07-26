<?php
def_md('test_md', 5, function($a){
		echo '.';
		return $a."\n";
	});
echo test_md(1, str_repeat("a", 300));
echo test_md(1, str_repeat("a", 500));
?>
---
.1
.1
