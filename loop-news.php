<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
    
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="post-<?php the_ID(); ?>-meta">Posted on: <?php the_time('F jS, Y') ?> | Posted in: <?php the_category(', ') ?><span><?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></span></p>
		</header>
		<div class="entry-content">
			<?php 
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
					the_post_thumbnail();
				}
			?>
			<?php the_excerpt(); ?>
			<a href="<?php the_permalink(); ?>" class="readMore">Read More</a>
		</div>
	</article>
    
<?php endwhile; // End the loop ?>
