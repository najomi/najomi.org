<?php
// При оборачивании функций с помощью def_wrapper - их можно всегда можно
// развернуть обратно
$wrapper = function($call){
	$call->args[0]++;
	echo ">";
	$call();
};
def('say', function($i){ echo $i."\n"; });
say(1);
def_wrapper('say', $wrapper);
say(1);
def_wrapper('say', $wrapper);
say(1);
undef_wrapper('say');
say(1);
undef_wrapper('say');
say(1);
?>
---
1
>2
>>3
>2
1

