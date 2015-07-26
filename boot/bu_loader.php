<?php
class BuLoader{
	private static $httpString = false;
	private function __construct(){ }

	public static function setHttpString($val){
		self::$httpString = $val;
	}
	private static function prepareHttpString(){
		BuRoute::setHttpString(self::$httpString);
		$httpString = BuRoute::doIt();
		self::$httpString = $httpString;
	}

	private static function runController($url){
		bu::lib(sf('%s_application',$url->getBinType()));
		$class_name = sf('%sApplication',ucfirst($url->getBinType()));
		$app = new $class_name();
		$app->runController($url);
	}

	public static function DoIt(){
		self::prepareHttpString();
		try{
			$url = new BuUrl2(self::$httpString);
			bu::setBuUrlInstance($url);
			self::runController($url);
		}catch(Exception $e){
			$msg = 'Ошибка на сайте';
			if(bu::config('rc/debug'))
				$msg = get_class($e).': '.$e->getMessage();
			$layout = bu::layout('panic');
			$content = $msg;
			if(bu::config('rc/debug')){
				$content .= sprintf('<br><b>%s</b><br>',get_class($e));
				$content .= "<pre>";
				foreach (array_reverse($e->getTrace()) as $v)
					if(isset($v['line']))
						$content .= $v['line'].' '.$v['file']."\n";
				$content .= "</pre>";
			}
			$layout->content = $content;
			$layout->generate();
		}
	}
}
