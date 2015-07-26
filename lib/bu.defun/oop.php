<?php
require_once 'load.php';

def('defgeneric', function($name){
		Memo::$methods[$name] = array();
		def($name, function() use ($name){
				$args = func_get_args();
				foreach(Memo::$methods[$name] as $t){
					list($combinator, $fn) = $t;
					if(call_user_func_array($combinator, $args))
						return call_user_func_array($fn, $args);
				}
				throw new Exception("No method for $name!");
			});
	});

def('defomethod', function(){
		$args = func_get_args();
		$name = array_shift($args);
		$fn = array_pop($args);
		$combinator = function() use($args){
			$call_args = func_get_args();
			$i = -1;
			foreach($args as $arg){
				$i++;
				if($arg != get_class($call_args[$i]))
					return false;
			}
			return true;
		};
		Memo::$methods[$name][] = array($combinator, $fn);
	});

class Optionable{
	var $param = null;
	function __construct($nm){
		$this->param = $nm;
	}
}

class Drum extends Optionable{}
class Cymbal extends Optionable{}
class DrumStick extends Optionable{}

$drum = new Drum('<Drum #1>');
$cymbal1 = new Cymbal('<Cymbal #1>');
$cymbal2 = new Cymbal('<Cymbal #2>');
$stick1 = new DrumStick('<Stick #1>');
$stick2 = new DrumStick('<Stick #2>');

def("beater", function($name){
		return  function($o, $t) use($name){
			echo $name.": ".$o->param." with ".$t->param."\n";
		};});

defgeneric('beat');
defomethod('beat', 'Drum', 'DrumStick', beater('D-DS'));
defomethod('beat', 'Cymbal', 'DrumStick', beater('C-DS'));
defomethod('beat', 'DrumStick', 'Drum', beater('DS-D'));
defomethod('beat', 'DrumStick', 'DrumStick', beater('DS-DS'));

beat($drum, $stick1);
beat($drum, $stick2);
beat($cymbal1, $stick1);
beat($cymbal2, $stick2);
beat($stick1, $drum);
beat($stick1, $stick2);

/*
D-DS: <Drum #1> with <Stick #1>
D-DS: <Drum #1> with <Stick #2>
C-DS: <Cymbal #1> with <Stick #1>
C-DS: <Cymbal #2> with <Stick #2>
DS-D: <Stick #1> with <Drum #1>
DS-DS: <Stick #1> with <Stick #2>
*/
