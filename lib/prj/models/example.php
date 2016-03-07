<?php

class Example {
  public $category;

  private $file_id;

  private $pth;

  public function __construct($pth) {
    if (!is_example_path($pth) || !is_example_exists($pth)) {
      throw new Exception("Example $pth not exists");
    }

    $this->pth     = $pth;
    $this->file_id = last(explode('/', $pth));

    $category_path = implode('/', but_last(explode('/', $pth)));

    $this->id       = find_position($this->file_id, $category_path);
    $this->category = Category::get($category_path);
  }

  public function code() {
    return $this->prop('code');
  }

  public function desc() {
    return $this->prop('desc');
  }

  public function file_id() {
    return $this->file_id;
  }

  public function ft() {
    if ($this->prop('ft')) {
      return $this->prop('ft');
    }

    if ($this->category->syntax()) {
      return $this->category->syntax();
    }

    return false;
  }

  public function id() {
    return $this->id;
  }

  public function keywords() {
    return $this->category->keywords();
  }

  public function link() {
    return $this->prop('link');
  }

  public function out() {
    return $this->prop('out');
  }

  public function prop($v) {
    $props = $this->props();

    if (isset($props[$v])) {
      return $props[$v];
    }
  }

  public function props() {
    return unyaml(data_directory() . '/' . $this->pth);
  }

  public function url() {
    return '/' . $this->pth;
  }
}
