<?php

function list_books_by_taxonomy($atts) {
	$atts = shortcode_atts(array(
		'author' => '',
		'genre' => ''
	), $atts, 'list_books');

	$query_args = array(
		'post_type' => 'book',
		'posts_per_page' => -1,
	);

	$tax_query = array('relation' => 'AND');

	if (!empty($atts['author'])) {
		$tax_query[] = array(
			'taxonomy' => 'author',
			'field' => 'slug',
			'terms' => $atts['author']
		);
	}

	if (!empty($atts['genre'])) {
		$tax_query[] = array(
			'taxonomy' => 'genre',
			'field' => 'slug',
			'terms' => $atts['genre']
		);
	}

	if (count($tax_query) > 1) {
		$query_args['tax_query'] = $tax_query;
	}

	$query = new WP_Query($query_args);
	$output = '<ul class="book-list">';

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$output .= '<li>' . get_the_title() . '</li>';
		}
		wp_reset_postdata();
	} else {
		$output .= '<li>No books found.</li>';
	}

	$output .= '</ul>';

	return $output;
}
add_shortcode('list_books', 'list_books_by_taxonomy');
