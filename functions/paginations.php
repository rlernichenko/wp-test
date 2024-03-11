<?php

function displayPagination() {
	?>
	<nav aria-label="Pagination">
		<hr class="my-0" />
		<?php
		$args = array(
			'prev_next' => true,
			'prev_text' => __('Newer'),
			'next_text' => __('Older'),
			'type'      => 'array',
			'end_size'  => 3,
			'mid_size'  => 3
		);
		$links = paginate_links($args);

		if ($links) :
			?>
			<ul class="pagination justify-content-center my-4">
				<?php
				foreach ($links as $link) {

					$link = str_replace('<a', '<a class="page-link"', $link);
					$link = str_replace('<span', '<span class="page-link"', $link);

					if (strpos($link, 'current') !== false) {
						echo "<li class='page-item active' aria-current='page'>$link</li>";
					} else {
						echo "<li class='page-item'>$link</li>";
					}
				}
				?>
			</ul>
		<?php endif; ?>
	</nav>
	<?php
}


function displayCustomPagination($paged = '', $max_page = '') {
	if (!$paged) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);
	}

	if (!$max_page) {
		global $wp_query;
		$max_page = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
	}

	$big  = 999999999; // need an unlikely integer

	$links = paginate_links(array(
		'base'       => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format'     => '?paged=%#%',
		'current'    => max(1, $paged),
		'total'      => $max_page,
		'mid_size'   => 1,
		'prev_text'  => __('Newer'),
		'next_text'  => __('Older'),
		'type'      => 'array',
	));

	if ($links) :
		?>
		<ul class="pagination justify-content-center my-4">
			<?php
			foreach ($links as $link) {

				$link = str_replace('<a', '<a class="page-link"', $link);
				$link = str_replace('<span', '<span class="page-link"', $link);

				if (strpos($link, 'current') !== false) {
					echo "<li class='page-item active' aria-current='page'>$link</li>";
				} else {
					echo "<li class='page-item'>$link</li>";
				}
			}
			?>
		</ul>
	<?php endif;
}
