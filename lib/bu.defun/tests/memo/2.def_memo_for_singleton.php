<?php
// def_memo может использоваться вместе с объектами
class DB{
	static $count = 0;
	function __construct(){
		self::$count++;
	}
	function count(){
		echo self::$count;
	}
}

def_memo('db', function(){
		return new DB;
	});

db()->count();
db()->count();
db()->count();
---
111
