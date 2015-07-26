<?php
def_md('test_md', 5, function($a){
		echo '.';
		return $a."\n";
	});
echo test_md(1, "a b");
echo test_md(1, "a b");
?>
---
.1
1
