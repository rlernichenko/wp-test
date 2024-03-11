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

<section>
	<div class="container">
		<div class="row">
			<div>
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<h1><?php the_title(); ?></h1>
						<?php the_content(); ?>
					</article>
				<?php endwhile; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
