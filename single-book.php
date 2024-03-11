<?php get_header(); ?>

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
		<!-- Blog entries-->
		<div class="col-lg-8">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" class="card mb-4">
					<a href="<?php the_permalink(); ?>">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail('post-thumbnail', ['class' => 'card-img-top']); ?>
						<?php else : ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.jpg" alt="placeholder" />
						<?php endif; ?>
					</a>
					<div class="card-body">
						<div class="small text-muted"><?php the_time(get_option('date_format')." в ".get_option('time_format')); ?></div>
						<h2 class="card-title h4"><?php the_title(); ?></h2>
						<p class="card-text"><?php the_content(''); ?></p>
					</div>
				</article>

			<?php endwhile; ?>

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
