<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
    
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="post-<?php the_ID(); ?>-meta">Posted on: <?php the_time('F jS, Y') ?> | Posted in: <?php the_category(', ') ?><span><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></span></p>
		</header>
		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>
	</article>
    
<?php endwhile; // End the loop ?>
