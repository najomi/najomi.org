<?php
class buLayout{
	protected static $_I = false;
	public static function getInstance(){
		return (self::$_I) ? self::$_I : self::$_I = new self;
	}
	protected $_data_def = array('title'=>'Hello, World!',
				     'keywords'=>'bubujka, php framework',
				     'content'=>'&nbsp;',
				     'description'=>'');
	protected $_data = array();
	public function __set($key,$value){
		$this->_data[$key] = $value;
	}

	public function clear(){
		$this->_data = array();
	}
	public $_layout_view = 'layout/default';
	public $_content_view = 'index_content';
	
	public function generate(){
		$data = array_merge($this->_data_def, $this->_data);
		$data['content'] = bu::view($this->_content_view, $data);
		echo bu::view($this->_layout_view,$data);
	}
}
?>
