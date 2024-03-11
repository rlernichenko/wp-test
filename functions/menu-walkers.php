<?php
class Bootstrap_Walker_Nav_Menu extends Walker_Nav_Menu {

	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'nav-item';

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$output .= '<li' . $class_names .'>';

		$atts = array();
		$atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
		$atts['target'] = !empty($item->target)     ? $item->target     : '';
		$atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
		$atts['href']   = !empty($item->url)        ? $item->url        : '';
		$atts['class']  = 'nav-link';

		if (in_array('current-menu-item', $item->classes) ||
		    in_array('current_page_item', $item->classes)) {
			$atts['class'] .= ' active';
		}

		$atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

		$attributes = '';
		foreach($atts as $attr => $value) {
			if (!empty($value)) {
				$value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters('the_title', $item->title, $item->ID);
		$title = apply_filters('nav_menu_item_title', $title, $item, $args);

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}
