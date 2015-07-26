<?php

class Example{
	var $pth, $file_id, $category;
	function __construct($pth){
		if(!is_example_path($pth) or
		   !is_example_exists($pth))
			throw new Exception("Example $pth not exists");
		$this->pth = $pth;
		$this->file_id = last(explode('/', $pth));

		$category_path = implode('/', but_last(explode('/', $pth)));

		$this->id = find_position($this->file_id, $category_path);
		$this->category = Category::get($category_path);
	}

	function keywords(){
		return $this->category->keywords();
	}

	function file_id(){
		return $this->file_id;
	}

	function id(){
		return $this->id;
	}

	function url(){
		return '/'.$this->pth;
	}

	function desc(){
		return $this->prop('desc');
	}

	function ft(){
		if($this->prop('ft'))
			return $this->prop('ft');
		if($this->category->syntax())
			return $this->category->syntax();
		return false;
	}

	function link(){
		return $this->prop('link');
	}
	function prop($v){
		$props = $this->props();
		if(isset($props[$v]))
			return $props[$v];
	}

	function props(){
		return unyaml('data/'.$this->pth);
	}

	function code(){
		return $this->prop('code');
	}
	function out(){
		return $this->prop('out');
	}
}
