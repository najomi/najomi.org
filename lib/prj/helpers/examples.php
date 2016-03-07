<?php
def_accessor('data_directory', './data');

/**
 * Функция для получения пути внутри каталога с данными
 */
def('data', function ($pth) {
  return data_directory() . '/' . $pth;
});

def('main_categories', function () {
  return Category::getSub();
});

def('is_category_path', function ($v) {
  if (!$v) {
    return false;
  }

  $t = explode('/', $v);

  foreach ($t as $vv) {
    if (!preg_match('@^[a-z_0-9.-]+$@i', $vv)) {
      return false;
    }
  }

  return true;
});

def('is_example_path', function ($url) {
  if (!$url) {
    return false;
  }

  $t = explode('/', $url);

  if (!preg_match('/^[0-9]+$/', last($t)) &&
    !preg_match('/^[a-z0-9_.-]+\.(md|html)$/', last($t))) {
    return false;
  }

  if (!last($t)) {
    return false;
  }

  if (!is_category_path(implode('/', but_last($t)))) {
    return false;
  }

  return true;
});

def('is_category_exists', function ($path) {
  if (!is_category_path($path)) {
    throw new Exception('Path is not valid: ' . $path);
  }

  $path = data_directory() . '/' . $path;

  if (file_exists($path) && is_dir($path)) {
    return true;
  }

  return false;
});
def('is_example_exists', function ($path) {
  if (!is_example_path($path)) {
    throw new Exception('Path is not valid: ' . $path);
  }

  $path = data_directory() . '/' . $path;

  if (file_exists($path) && is_file($path)) {
    return true;
  }

  return false;
});

def('find_example', function ($path) {
  return new Example($path);
});

def('find_position', function ($id, $pth) {
  $i   = 0;
  $all = ordered_exampls($pth);

  foreach ($all as $v) {
    ++$i;
    $t = last(explode('/', $v));

    if ($t == $id) {
      return $i;
    }
  }
});

def('is_normal_link', function ($href) {
  return preg_match('@^https?:@', $href);
});

def('is_email_link', function ($href) {
  return preg_match('@^mailto:@', $href);
});

def('nice_link', function ($href) {
  if (is_normal_link($href)) {
    $name = parse_url($href, PHP_URL_HOST);
  } elseif (is_email_link($href)) {
    $name = str_replace('mailto:', '', $href);
  } elseif (is_man_link($href)) {
    return $href;
  } else {
    return $href;
  }

  return '<a href="' . $href . '">' . $name . '</a>';
});

def('count_examples', function () {
  return trim(`cd data; find * -type f -name '[0-9]*' | wc -l`);
});

def('ordered_exampls', function ($pth) {
  $PREFIX = './data/' . $pth . '/';
  $data   = glob($PREFIX . '[0-9]*');

  natsort($data);
  $data     = array_values($data);
  $meta_pth = $PREFIX . 'meta.yaml';

  if (file_exists($meta_pth)) {
    $meta = unyaml($meta_pth);

    if (isset($meta['order'])) {
      $t     = array_flip($data);
      $order = array_reverse($meta['order']);

      foreach ($order as $v) {
        unset($data[$t[$PREFIX . $v]]);
      }

      foreach ($order as $v) {
        array_unshift($data, $PREFIX . $v);
      }
    }
  }

  return array_values($data);
});
