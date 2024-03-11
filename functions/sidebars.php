<?php
function sidebarsInit() {
	register_sidebar(
		array(
			'name' => "Blog Sidebar",
			'id' => 'blog-sidebar',
			'description' => "Add widgets here.",
			'before_widget' => '<div id="%1$s" class="card mb-4 %2$s">',
			'after_widget' => '</div>',
		)
	);

	register_sidebar(
		array(
			'name' => "Books Sidebar",
			'id' => 'books-sidebar',
			'description' => "Add widgets.",
			'before_widget' => '<div id="%1$s" class="card mb-4 %2$s">',
			'after_widget' => '</div>',
		)
	);
}


add_action('widgets_init', 'sidebarsInit');
