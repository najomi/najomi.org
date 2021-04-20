<?php


function title_parts(){
    $arr = [];

    $path   = bu::path();
    $prefix = '/';
    $last   = $path[count($path) - 1];
    $last_i = count($path) - 1;

    foreach ($path as $k => $v) {
      $category_path = trim($prefix . $v, '/');

      if (is_category_path($category_path) && is_category_exists($category_path)) {
        $c = new Category($category_path);
        $arr[] = $c->name();
      }

      $prefix = $prefix . $v . '/';
    }
    return $arr;
}



if (!path()) {
  draw_page('Поваренная книга программиста',
    dview('index_content',
      main_categories()));
} elseif (is_category_path(path()) && is_category_exists(path())) {
  is_need_cache(true);

  $category = new Category(path());
  keywords($category->keywords());

  draw_page(
    $category->getTitle(),
    dview('one_category', $category));
} elseif (is_example_path(path()) && is_example_exists(path())) {
  is_need_cache(true);

  $example = new Example(path());
  keywords($example->keywords());


  draw_page(implode(' → ', title_parts()).' → '.$example->prop('desc'),
    view('path_block', ['id' => $example->id()]) .
    view('one_example', ['data' => $example, 'show_link' => true]));
} else {
  show_404();
}
