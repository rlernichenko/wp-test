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
			    <?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>
				<h1>Author's posts <?php echo $curauth->nickname; ?></h1>
				<div class="media">
					<div class="media-left">
						<?php echo get_avatar($curauth->ID, 64, '', $curauth->nickname, array('class' => 'media-object')); ?>
					</div>
				<div class="media-body">
					<h4 class="media-heading"><?php echo $curauth->display_name; ?></h4>
					<?php if ($curauth->user_url) echo '<a href="'.$curauth->user_url.'">'.$curauth->user_url.'</a>'; ?>
					<?php if ($curauth->description) echo '<p>'.$curauth->description.'</p>'; ?>
				</div>
				</div>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part('loop'); ?>
				<?php endwhile;
				else: echo '<p>No records.</p>'; endif; ?>
				<?php pagination(); ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
