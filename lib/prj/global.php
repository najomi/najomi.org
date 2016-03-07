<?php
function cache_exists($file) {
  if (file_exists('cache/' . cache_key($file))) {
    return true;
  }
}

function cache_key($file) {
  return md5($file);
}

function read_cache($file) {
  return unserialize(file_get_contents('cache/' . cache_key($file)));
}

function write_cache($file, $data) {
  return file_put_contents('cache/' . cache_key($file), serialize($data));
}

function fix_comments($mix) {
  if (is_string($mix)) {
    return str_replace('\\#', '#', $mix);
  }

  if (is_array($mix)) {
    foreach ($mix as $k => $v) {
      $mix[$k] = fix_comments($v);
    }
  }

  return $mix;
}

function unyaml($file) {
  static $yaml = false;

  if (!$yaml) {
    $yaml = new sfYamlParser();
  }

  $data = $yaml->parse(file_get_contents($file));
  $data = fix_comments($data);
  return $data;
}
