<?php

class BuUrl2{
	private static $_dirs = array('bin/core','bin/prj','bin/:host');
	private static $_tree = array();
	private static $_treeBuilded = false;

	private $_bin_file = false;
	private $_bin_type = 'plain';

	private $_args = array();

	private $_url = '';
	public function __construct($url){
		self::_buildControllersTree();
		$this->_url = $url;
		$this->parseUrl($url);
	}
	public function getBinFile(){
		return $this->_bin_file;
	}
	public function getBinType(){
		return $this->_bin_type;
	}
	public function getBinUrl(){
		$t = $this->getPath();
		$a = $this->getVars();
		return implode('/',array_diff($t,$a));
	}
	public function getPath(){
		$array = explode('/',$this->_url);
		$returnArray = array();
		foreach ($array as $v)
			if (trim($v))
				$returnArray[] = $v;
		return $returnArray;
	}
	public function getVars(){
		return array_reverse($this->_args);
	}
	private function _select($array){
		$this->_bin_type = $array['type'];
		$this->_bin_file = $array['file'];
	}
	public static function debug(){
		ppr(self::$_tree);
	}
	private function parseUrl($url){
		if (substr($url,-1)=='/') 
			$url = substr ($url, 0, -1);

		if (!$url){
			if(isset(self::$_tree['/index'])){
				$this->_select(self::$_tree['/index']);
				return;
			}else{
				throw new Exception('No controllers exists!');
			}
		}	
		if(isset(self::$_tree[$url.'/index'])){
			$this->_select(self::$_tree[$url.'/index']);
			return;
		}
		if(isset(self::$_tree[$url])){
			$this->_select(self::$_tree[$url]);
			return;
		}
		
		$stripUrl = '';
		if (preg_match('/(.*)\/([^\/]+)/',$url,$match)){
			$stripUrl = $match[1];
			$this->_args[]=$match[2];
		}
		return $this->parseUrl($stripUrl);
	}
	private static function _buildControllersTree(){
		if(self::$_treeBuilded)
			return;
		foreach(self::$_dirs as $v)
			self::_applyTreeFromDirectory($v);
		self::$_treeBuilded = true;
	}
	private static function _recursiveReadDir($dir, $prefix = ''){
		if(!file_exists($dir)) 
			return ;
		$d = dir($dir);
		$return = array();

		while (false !== ($entry = $d->read())) {
			if (self::_isValidEntryName($entry)){
				if(is_dir($dir.'/'.$entry)){
					$tmp = self::_recursiveReadDir($dir.'/'.$entry,$prefix.'/'.$entry);
					$return = array_merge($return,$tmp);
				}
				if (is_file($dir.'/'.$entry)){
					$fileName = self::_extractKeyFromFileName($entry);
					$key = $prefix.'/'.$fileName;
					if(isset($return[$key]))
						throw new Exception(sf('Name collision with key=%s',$key));
					$type = self::_extractTypeFromFileName($entry);
					$return[$key] = array(
						'file'=>$dir.'/'.$entry,
						'type'=>$type);
				}
			}
		}
		$d->close();
		return $return;
	}
	private static function _applyTreeFromDirectory($dir, $prefix= ''){
		$new_tree = self::_recursiveReadDir($dir,$prefix);
		if(!is_array($new_tree))
			$new_tree = array();
		self::$_tree = array_merge(self::$_tree, $new_tree);
	}
	private static function _isValidEntryName($entry){
		$firstChar = substr($entry, 0, 1);
		if ($entry != '.' and $entry != '..' and $firstChar != '.')
			return true;
	}

	static function _extractTypeFromFileName($file){
		if(preg_match('/_(.+)\.php/i',$file))
			return 'plain';
		else
			return 'layout';
	}
	static function _extractKeyFromFileName($file){
		preg_match('/_?(.+)\.php/i',$file,$match);
		return $match[1];
	}
}


