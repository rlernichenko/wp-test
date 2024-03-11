<!-- Featured blog post-->
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
		<h2 class="card-title"><?php the_title(); ?></h2>
		<p class="card-text">
			<?php the_content(''); ?>
		</p>
		<a class="btn btn-primary" href="<?php the_permalink(); ?>">Read more →</a>
	</div>
</article>
