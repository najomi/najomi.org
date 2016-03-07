<?php

if (!path()) {
  draw_page('Поваренная книга программиста',
    dview('index_content',
      main_categories()));
} elseif (is_category_path(path()) && is_category_exists(path())) {
  if (Category::isValidPath(path())) {
    is_need_cache(true);

    $category = Category::get(path());
    keywords($category->keywords());

    draw_page(
      $category->getTitle(),
      dview('one_category', $category));
  } else {
    show_404();
  }
} elseif (is_example_path(path()) && is_example_exists(path())) {
  is_need_cache(true);

  function example_title($example) {
    $cats = [];

    foreach (bu::path() as $v) {
      if (preg_match('/^[0-9]+$/', $v)) {
        break;
      }

      $cats[] = Category::get($v)->name();
    }

    return 'Пример: ' . implode('/', $cats) . ' #' . $example->id();
  }

  $example = new Example(path());
  keywords($example->keywords());
  draw_page($example->prop('desc'),
    view('path_block', ['id' => $example->id()]) .
    view('one_example', ['data' => $example,
      'show_link'                 => true]));
} else {
  show_404();
}
