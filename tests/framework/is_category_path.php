<?php
function test_path($v){
	echo is_category_path($v) ? 't' : 'f';
}
$correct = array('foo/bar/baz',
		 '_foo/_bar/_baz',
                 'c',
		 'Foo/Bar/Baz',
		 'Foo/Bar2/Baz',
		 'www/robots.txt',
		 'common-lisp/equality',
		 'Foo');
$incorrect = array('',
		   '_foo/_bar/_baz/1');

array_map('test_path', $correct);
array_map('test_path', $incorrect);
---
ttttttttff
