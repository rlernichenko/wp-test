<?php
class My_Custom_Search_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'my_custom_search',
			'Search',
			array('description' => __('A custom search form', 'textdomain'),)
		);
	}

	public function widget($args, $instance) {
		echo $args['before_widget'];

		if (!empty($args["widget_name"])) {
			echo '<div class="card-header">' . apply_filters('widget_title', $args["widget_name"]) . '</div>';
		}

		echo '<div class="card-body">';

		echo '<form role="search" method="get" action="' . esc_url(home_url('/')) . '">';
		echo '<div class="input-group">';
		echo '<input type="search" name="s" class="form-control" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search"/>';
		echo '<button class="btn btn-primary" type="submit">Go!</button>';
		echo '</div>';
		echo '</form>';

		echo '</div>';
		echo $args['after_widget'];
	}

	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<?php
	}
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

		return $instance;
	}
}




class My_Custom_Categories_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'my_custom_categories',
			'Categories',
			array('description' => __('A custom categories list', 'textdomain'),)
		);
	}

	public function widget($args, $instance) {
		echo $args['before_widget'];

		if (!empty($args["widget_name"])) {
			echo '<div class="card-header">' . apply_filters('widget_title', $args["widget_name"]) . '</div>';
		}

		echo '<div class="card-body">';
		echo '<div class="row">';
		echo '<div class="col-sm-6">';
		echo '<ul class="list-unstyled mb-0">';

		$categories = get_categories();
		$half = ceil(count($categories) / 2);
		$i = 0;
		foreach ($categories as $category) {
			if ($i == $half) break;
			echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name)
			     . '</a></li>';
			$i++;
		}

		echo '</ul>';
		echo '</div>';
		echo '<div class="col-sm-6">';
		echo '<ul class="list-unstyled mb-0">';

		for (; $i < count($categories) + 1; $i++) {
			if( isset($categories[$i]) ) {
				$category = $categories[$i];
				echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name)
				     . '</a></li>';
			}
		}

		echo '</ul>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo $args['after_widget'];
	}

	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<?php
	}
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

		return $instance;
	}
}




class Recent_Author_Books_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'recent_author_books',
			'Recent Author Books',
			array('description' => __('Displays the latest books by a specific author', 'textdomain'),)
		);
	}

	public function widget($args, $instance) {

		echo $args['before_widget'];

		if (!empty($args["widget_name"])) {
			echo '<div class="card-header">' . apply_filters('widget_title', $args["widget_name"]) . '</div>';
		}

		echo '<div class="card-body">';

		$author = !empty($instance['author']) ? $instance['author'] : '';

		$query_args = array(
			'post_type' => 'book',
			'posts_per_page' => 5,
			'tax_query' => array(
				array(
					'taxonomy' => 'author',
					'field'    => 'slug',
					'terms'    => $author
				)
			)
		);

		$query = new WP_Query($query_args);

		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		if ($query->have_posts()) {
			echo '<ul>';
			while ($query->have_posts()) {
				$query->the_post();
				echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
			}
			echo '</ul>';
			wp_reset_postdata();
		} else {
			echo '<p>No recent books found.</p>';
		}

		echo '</div>';

		echo $args['after_widget'];
	}

	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : '';
		$author = !empty($instance['author']) ? $instance['author'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('author')); ?>">Author Slug:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('author')); ?>" name="<?php echo esc_attr($this->get_field_name('author')); ?>" type="text" value="<?php echo esc_attr($author); ?>">
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['author'] = (!empty($new_instance['author'])) ? strip_tags($new_instance['author']) : '';

		return $instance;
	}
}




function my_register_custom_widget() {
	register_widget('My_Custom_Search_Widget');
	register_widget('My_Custom_Categories_Widget');
	register_widget('Recent_Author_Books_Widget');
}
add_action('widgets_init', 'my_register_custom_widget');
