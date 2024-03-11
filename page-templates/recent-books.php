<?php
/* Template Name: Recent Books */

get_header();

$today = date('Y-m-d');
$last_month = date('Y-m-d', strtotime('-1 month'));
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = array(
	'post_type'      => 'book',
	'posts_per_page' => 4,
	'paged'          => $paged,
	'date_query'     => array(
		array(
			'after'     => $last_month,
			'before'    => $today,
			'inclusive' => true,
		),
	),
);

$query = new WP_Query($args);

?>
<!-- Page header with logo and tagline-->
<header class="py-5 bg-light border-bottom mb-4">
	<div class="container">
		<div class="text-center my-5">
			<h1 class="fw-bolder"><?php the_title();?></h1>
			<p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
		</div>
	</div>
</header>

<!-- Page content-->
<div class="container">
	<div class="row">

		<div class="col-lg-8">

			<?php if ($query->have_posts()) : ?>

				<div class="row">

				<?php $post_count = 0;?>
				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php if ($post_count % 2 == 0 && $post_count != 0) : ?>
						</div><div class="row">
					<?php endif; ?>

					<div class="col-lg-6">
						<?php get_template_part('loop');?>
					</div>

					<?php $post_count++;?>
				<?php endwhile; ?>
				</div>
				<!-- Pagination-->
				<?php displayCustomPagination($paged, $query->max_num_pages);?>
				<?php wp_reset_postdata();?>

			<?php else : ?>
				<p>No records.</p>
			<?php endif; ?>
		</div>

		<!-- Side widgets-->
		<?php if (is_active_sidebar('books-sidebar')) : ?>
			<div class="col-lg-4">
				<?php dynamic_sidebar('books-sidebar'); ?>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
