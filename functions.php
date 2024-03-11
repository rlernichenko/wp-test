<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once get_template_directory() . '/functions/menu-walkers.php';
require_once get_template_directory() . '/functions/widgets.php';
require_once get_template_directory() . '/functions/post-types.php';
require_once get_template_directory() . '/functions/taxonomies.php';
require_once get_template_directory() . '/functions/shortcodes.php';
require_once get_template_directory() . '/functions/sidebars.php';
require_once get_template_directory() . '/functions/paginations.php';


if (!defined('_S_VERSION')) {
	define('_S_VERSION', '0.0.1');
}


function themeInstall() {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	register_nav_menus(
		array(
			'header' => "Header",
			'footer' => "Footer",
		)
	);
}
add_action('after_setup_theme', 'themeInstall');


function registerAssets() {
	wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION);

	wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/lib/js/bootstrap.bundle.min.js', array(), _S_VERSION, true);
	wp_enqueue_script('rating', get_template_directory_uri() . '/assets/js/rating.js', array(), _S_VERSION, true);
	wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array(), _S_VERSION, true);

//	wp_deregister_script('jquery');
//	wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'registerAssets');




function rate_book() {
	//todo add nonce

	$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
	$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

	if ($post_id && $rating) {
		$current_rating = get_post_meta($post_id, 'book_rating', true);
		$current_rating = $current_rating ? intval($current_rating) : 0;

		$current_votes = get_post_meta($post_id, 'book_votes', true);
		$current_votes = $current_votes ? intval($current_votes) : 0;

		$new_rating = $current_rating + $rating;
		$new_votes = $current_votes + 1;

		update_post_meta($post_id, 'book_rating', $new_rating);
		update_post_meta($post_id, 'book_votes', $new_votes);

		$average_rating = $new_votes ? round($new_rating / $new_votes, 1) : 0;

		wp_send_json_success(array('new_rating' => $new_rating, 'average_rating' => $average_rating, 'votes' => $new_votes));
	} else {
		wp_send_json_error(array('message' => 'Invalid post ID or rating.'));
	}
}
add_action('wp_ajax_rate_book', 'rate_book');
add_action('wp_ajax_nopriv_rate_book', 'rate_book');


function displayRating() {
	$post_id = get_the_ID();

	$current_rating = get_post_meta($post_id, 'book_rating', true);
	$current_rating = $current_rating ? intval($current_rating) : 0;

	$current_votes = get_post_meta($post_id, 'book_votes', true);
	$current_votes = $current_votes ? intval($current_votes) : 0;

	$average_rating = $current_votes ? round($current_rating / $current_votes, 1) : 0;

	echo '<div class="count-rating" data-id="'.intval($post_id).'">'.$average_rating.'</div>';

	echo '<div class="star-rating" data-id="' . esc_attr($post_id) . '">';

	for ($i = 1; $i <= 5; $i++) {
		$fill = ($i <= $average_rating) ? '#ffc107' : '#dddddd';

		echo '<svg width="24" height="24" viewBox="0 0 24 24" class="star star-'.$i.'" data-rating="'.$i.'">';
		echo '<path fill="' . $fill . '" stroke-linecap="round" stroke-linejoin="round" d="m12.000294 3c-.295467 0-.547924.144247-.738305.3203583-.190382.1761114-.343146.3914518-.484391.6329031-.282491.4829027-.52208 1.0811934-.755884 1.6916483-.2338032.6104551-.4579287 1.2305158-.671897 1.7248562s-.4613278.8587294-.5215014.9044262c-.0601731.0456972-.4684937.1803248-.9844072.2402688-.5159134.0599445-1.151661.0890511-1.7793551.1328315-.6276939.0437807-1.2448612.1008602-1.7715422.2324552-.2633406.0657977-.5075138.1484086-.7265864.2832436-.2190724.1348352-.4282438.339182-.5195482.6329031-.091305.2937207-.036955.5923797.064455.8360567.1014098.243679.2517023.458902.4277484.673925.3520922.430046.8195815.856464 1.302777 1.277526.4831956.421062.9816051.835882 1.365279 1.201344.3836738.365463.6371935.723049.6601779.796989.022985.07394.018943.521497-.08594 1.052886-.1048832.531387-.2736156 1.171339-.4277483 1.808851-.1541328.637515-.2948853 1.268061-.3379017 1.832295-.021508.282116-.021784.549266.033204.808708.054988.259444.1789443.533418.4179825.714947.2390382.181531.5262657.218897.7793223.193387.2530567-.0255.4941172-.106312.744165-.214874.5000952-.21712 1.032069-.554203 1.5645039-.904427.5324345-.350224 1.0626305-.714091 1.5137215-.982562.451093-.268472.857293-.410215.931671-.410215.07437 0 .480579.141743.931672.410215.451091.268471.981287.632338 1.51372.982562.532436.350224 1.06441.687307 1.564505.904427.250049.108559.491109.189365.744165.214874.253057.0255.540284-.01186.779322-.193387.239039-.181529.362995-.455503.417983-.714947.05499-.259442.05471-.526592.0332-.808708-.04302-.564234-.18377-1.19478-.337902-1.832295-.154132-.637512-.322864-1.277464-.427748-1.808851-.104879-.531389-.108929-.978947-.08594-1.052886.02298-.07394.276505-.431526.660179-.796989.383673-.365462.882084-.780282 1.365278-1.201344.483196-.421062.950685-.84748 1.302778-1.277526.176046-.215023.326337-.430246.427748-.673925.101413-.243677.155755-.542336.06445-.8360567-.091303-.2937211-.300468-.4980679-.51954-.6329031-.219072-.134835-.463246-.2174458-.726587-.2832436-.52668-.1315956-1.143848-.1886745-1.771542-.2324552-.627693-.0437807-1.263442-.0728874-1.779355-.1328315-.515913-.059944-.924232-.1945719-.984407-.2402688-.060173-.0456967-.307534-.4100858-.521501-.9044262-.213969-.4943404-.438094-1.1144011-.671897-1.7248562-.233805-.6104549-.473394-1.2087456-.755885-1.6916483-.141245-.2414513-.294008-.4567917-.484391-.6329031-.190381-.1761113-.442837-.3203584-.738305-.3203583z"></path>';
		echo '</svg>';
	}

	echo '</div>';
}
