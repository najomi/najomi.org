<div id="navigation">
	 <a href='/'>/</a> &rarr;
<?php
$path   = bu::path();
$prefix = '/';
$last   = $path[count($path) - 1];
$last_i = count($path) - 1;

foreach ($path as $k => $v) {
  $category_path = trim($prefix . $v, '/');

  if (is_category_path($category_path) && is_category_exists($category_path)) {
    $c = Category::get($category_path);

    if ($k == $last_i) {
      echo '<b>' . $c->getName() . '</b>' . "\n";
    } else {
      echo '<a href="' . $prefix . $v . '">' . $c->getName() . '</a> &rarr;' . "\n";
    }
  } elseif (is_example_path($category_path) && is_example_exists($category_path)) {
    echo '<b>пример #' . $id . '</b>' . "\n";
  }

  $prefix = $prefix . $v . '/';
}

?>
</div>
