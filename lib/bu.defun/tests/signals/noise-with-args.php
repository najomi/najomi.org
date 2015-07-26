<?php
catcher('warning', function($one, $two, $three){
	echo $one.$two.$three;
});
noise('warning', 1,2,3);
?>
---
123
