<?php
// Проверяем что аргументы нормально передаются в функцию
def('say', function($one, $two, $three){ 
	echo "{$one}-{$two}-{$three}"; 
});
say(1,2,3);
?>
---
1-2-3
