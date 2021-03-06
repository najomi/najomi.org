<?php
function sortByName($collection) {
  $return = [];
  $tmp    = [];

  foreach ($collection as $k => $v) {
    $tmp[$k] = $v->name();
  }

  asort($tmp);

  foreach ($tmp as $k => $v) {
    $return[] = $collection[$k];
  }

  return $return;
}

class Category {
  public $_meta;

  public $parent;

  private $_path = '';

  /**
   * Создаём из пути объект-категории
   */

  public function __construct($path) {
    if (!is_category_exists($path)) {
      throw new Exception("Path not exists $path");
    }

    $this->_path = $path;
    $parent_path = preg_replace('@/[^/]+$@', '', $path);

    if ($parent_path != $path && $parent_path) {
      $this->parent = new Category($parent_path);
    }
  }

  /**
   * Получить объекты подкаталогов
   */
  public function categories() {
    return self::getSub($this->_path);
  }

  public function examples() {
    return array_map(function ($pth) {
      return new Example(str_replace(data_directory() . '/', '', $pth));
    }, ordered_exampls($this->_path));
  }

  public function getAuthors() {
    $us     = $this->examples();
    $return = [];

    foreach ($us as $v) {
      if ($v->prop('author')) {
        $return[$v->id()] = $v->prop('author');
      }
    }

    return $return;
  }

  public function getHref() {
    return '/' . $this->_path;
  }

  public function getInfo() {
    return $this->meta('info');
  }

  public function getKeywords() {
    return $this->keywords();
    $key_file = data_directory() . '/' . $this->_path . '/keywords';

    if (file_exists($key_file)) {
      return trim(file_get_contents($key_file));
    }

    $name       = $this->name();
    $keywords[] = $name . ' примеры';
    $keywords[] = $name . ' usage';
    $keywords[] = $name . ' example';
    return implode(', ', $keywords);
  }

  public function getLinks() {
    $us     = $this->examples();
    $return = [];

    foreach ($us as $v) {
      if ($v->link()) {
        $return[$v->id()] = $v->link();
      }
    }

    return $return;
  }

  /**
   * Вернуть отсортированный список объектов-подкаталогов по пути
   */
  public static function getSub($path = '') {
    if ($path) {
      $path .= '/';
    }

    $dirs = glob(data_directory() . '/' . $path . '*', GLOB_ONLYDIR);

    if (!$dirs) {
      return [];
    }

    return sortByName(array_map(function ($pth) {
      return new Category(str_replace(data_directory() . '/', '', $pth));
    }, $dirs));
  }

  public function getTitle() {
    return ($this->meta('title') ? $this->meta('title') : sprintf("Примеры: %s\n", $this->name()));
  }

  public function keywords() {
    $parent_kw = $this->parent ? $this->parent->keywords() : [];
    $this_kw   = [$this->name() . ' примеры',
      $this->name() . ' usage',
      $this->name() . ' example'];
    $meta_kw = (array) $this->meta('keywords');
    $return  = array_merge($parent_kw, $this_kw, $meta_kw);
    array_unique($return);
    return $return;
  }

  public function meta($key = null) {
    if (is_null($this->_meta)) {
      $pth = data($this->_path . '/meta.yaml');

      if (file_exists($pth)) {
        $this->_meta = unyaml($pth);
      }
    }

    if (is_null($key)) {
      return $this->_meta;
    }

    if (isset($this->_meta[$key])) {
      return $this->_meta[$key];
    }
  }

  /**
   * Получить название категории
   */
  public function name() {
    return ($this->meta('name') ? $this->meta('name') : basename($this->_path));
  }

  public function syntax() {
    if ($this->meta('ft')) {
      return $this->meta('ft');
    } elseif ($this->parent) {
      return $this->parent->syntax();
    }

    return 'txt';
  }
}
