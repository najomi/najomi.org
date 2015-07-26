<?php
require_once 'load.php';

def_printfer('h1', "<h1>%s</h1>\n");
h1('Hello, ');
h1('World!');
// <h1>Hello, </h1>
// <h1>World!</h1>

def_printfer('puts', "%s\n");
puts("text");
// text

//////////////////////////////////////////////////

def_sprintfer('a', "<a href='%s'>%s</a>");
def_sprintfer('img', "<img src='%s'>");

def('def_tag',function($name){
		def_sprintfer($name, "<{$name}>%s</{$name}>\n");
	});

foreach(array('p','div','html','head','body','title', 'h1') as $tag)
	def_tag($tag);

echo html(head(title('Hello, World!')).
          body(div(h1('Hello, World!')).
	       div(p("This is a page about world!").
	           a("http://world.com", img("http://world.com/logo.jpg")))));
/*
  <html><head><title>Hello, World!</title>
  </head>
  <body><div><h1>Hello, World!</h1>
  </div>
  <div><p>This is a page about world!</p>
  <a href='http://world.com'><img src='http://world.com/logo.jpg'></a></div>
  </body>
*/

//////////////////////////////////////////////////

def('say', function ($what, $what2){
		printf("ME: %s, %s\n", $what, $what2);
	});
say('one','two');
// ME: one, two

def('say', function ($what, $what2){
		printf("ME>>: %s, %s\n", $what, $what2);
	});
say('one','two');
// ME>>: one, two

def_wrapper('say', function($call){
		foreach($call->args as $k=>$v)
			$call->args[$k] = strtoupper($v);
		$call();
	});
say('one','two');
// ME>>: ONE, TWO

def_wrapper('say', function($call){
		foreach($call->args as $k=>$v)
			$call->args[$k] = '_'.$v.'_';
		$call();
	});
say('one', 'two');
// ME>>: _ONE_, _TWO_

undef_wrapper('say');
say('one', 'two');
// ME>>: ONE, TWO

undef_wrapper('say');
say('one', 'two');
// ME>>: one, two

undef_wrapper('say');
say('one', 'two');
//ME: one, two

//////////////////////////////////////////////////

def_memo('sum', function($one, $two){
		echo "Summing: {$one} - {$two} \n";
		return $one+$two;
	});

puts('Result: '.sum(1, 2));
puts('Result: '.sum(1, 2));
puts('Result: '.sum(2, 2));
// Summing: 1 - 2
// Result: 3
// Result: 3
// Summing: 2 - 2
// Result: 4

///////////////////////////////////

def_converter('id','object',function($i){
		return (object)$i;
	});

print_R(id_to_object(13));
/*
  stdClass Object
  (
  [scalar] => 13
  )
*/

print_R(ids_to_objects(array(2,3)));
/*
  Array
  (
  [0] => stdClass Object
  (
  [scalar] => 2
  )

  [1] => stdClass Object
  (
  [scalar] => 3
  )

  )
*/

def('bark', function(){ puts("Bark!");});
bark();
// Bark!

def('bark', function(){ puts("Bark-bark!");});
bark();
// Bark-bark!

def('bark', function(){ puts("Miaoooo!");});
bark();
// Miaoooo!

undef('bark');
bark();
// Bark-bark!

undef('bark');
bark();
// Bark!

//////////////////////////////////////////////////

def('say_one', function(){
		puts("Me: one");
	});

say_one();
// Me: one

def('say_two', function(){
		puts("Me: two");
	});
say_two();
// Me: two

def_alias('say_one', 'say_two');
say_two();
// Me: one


////////////////////////////////////////

def_printfer('test_let', "calling outside let \n");

test_let();
// calling outside let

deflet(function(){
		def_printfer('test_let', "calling inside let \n");
		test_let();
		// calling inside let
	});

test_let();
// calling outside let


////////////////////////////////////////
# using namespace
def('foo\bar\hello',function(){ echo "Hello, World!\n";});
foo\bar\hello();
// Hello, World!

////////////////////////////////////////
# Testing def_return
def_return('user_name', 'waserd');
puts(user_name());
// waserd

