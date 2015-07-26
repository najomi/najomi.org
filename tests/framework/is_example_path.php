<?php
function test_path($v){
	echo is_example_path($v) ? 't' : 'f';
}
$correct = array('foo/bar/baz/1',
		 '_foo/_bar/_baz/100',
		 'Foo/Bar/Baz/200',
		 'Foo/Bar2/Baz/300',
		 'www/robots.txt/9000',
		 'common-lisp/equality/2',
		 'Foo/4');
$incorrect = array('',
		   '_foo/0',
		   '_foo/1a',
		   '_foo/bar');

array_map('test_path', $correct);
array_map('test_path', $incorrect);
---
tttttttffff