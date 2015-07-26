<?php
if(!path()){
	draw_page('Поваренная книга программиста',
		  dview('index_content',
			main_categories()));
}elseif(is_category_path(path())){
	if(Category::isValidPath(path())){
		is_need_cache(true);

		$category = Category::get(path());
		keywords($category->keywords());

		draw_page($category->getTitle(),
			  dview('one_category', $category));
	}else{
		show_404();
	}
}elseif(is_example_path(path())){
	if(is_example_exists(path())){
		is_need_cache(true);

		function example_title($example){
			$cats = array();
			foreach(bu::path() as $v){
				if(preg_match('/^[0-9]+$/', $v))
					break;
				$cats[] = Category::get($v)->name();
			}
			return 'Пример: '.implode('/', $cats). ' #'.$example->id();
		}

		$example = find_example(path());
		keywords($example->keywords());
		draw_page($example->prop('desc'),
			  view('path_block', array('id'=>$example->id())).
			  view('one_example', array('data'=>$example,
						    'show_link'=>true)));
	}else{
		show_404();
	}
}else{
	show_404();
}
