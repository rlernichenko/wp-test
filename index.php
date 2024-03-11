<?php get_header(); ?>

<!-- Page header with logo and tagline-->
<header class="py-5 bg-light border-bottom mb-4">
	<div class="container">
		<div class="text-center my-5">
			<h1 class="fw-bolder">Posts List</h1>
			<p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
		</div>
	</div>
</header>

<!-- Page content-->
<div class="container">
	<div class="row">
		<!-- Blog entries-->
		<div class="col-lg-8">

			<?php
			$sticky = get_option('sticky_posts');
			if ($sticky) {
				$sticky = array_slice($sticky, -1);
				$featured_query = new WP_Query(array('post__in' => $sticky));

				if ($featured_query->have_posts()) :
					while ($featured_query->have_posts()) : $featured_query->the_post();
						get_template_part('featured', 'loop');
					endwhile;
				endif;
				wp_reset_postdata();
			}
			?>


			<?php if (have_posts()) : ?>

				<div class="row">

				<?php $post_count = 0;?>
				<?php while (have_posts()) : the_post(); ?>
					<?php if (!is_sticky()) : ?>

						<?php if ($post_count % 2 == 0 && $post_count != 0) : ?>
							</div><div class="row">
						<?php endif; ?>

						<div class="col-lg-6">
							<?php get_template_part('loop');?>
						</div>

						<?php $post_count++;?>
					<?php endif; ?>
				<?php endwhile; ?>

				</div>

			<?php else : ?>
				<p>No records.</p>
			<?php endif; ?>


			<!-- Pagination-->
			<?php displayPagination();?>
		</div>


		<!-- Side widgets-->
		<?php if (is_active_sidebar('blog-sidebar')) : ?>
			<div class="col-lg-4">
				<?php dynamic_sidebar('blog-sidebar'); ?>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
