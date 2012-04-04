<?php get_header(); ?>
		
		<?php while (have_posts()) : the_post(); ?>
			
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
				<header class="row">
			
					<h1 class="entry-title"><?php the_title(); ?></h1>
			
				</header>
				
				<div class="row">
					
					<div class="eight columns entry-content">
				
						<div class="video_wrapper">
							<div class="video_container">
								<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo get_post_meta($post->ID, '_tedxyyc_videopick_youtubeID_value', true) ?>" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
				
						<?php the_content(); ?>
					
						<footer>
							<p class="post-<?php the_ID(); ?>-meta">Posted on: <?php the_time('F jS, Y') ?></p>
						</footer>
				
						<?php //comments_template(); ?>
					
					</div> <!-- entry-content -->
					
					<aside id="sidebar" class="four columns" role="complementary">
				
						<div class="container">
							<?php dynamic_sidebar("Blog Sidebar"); ?>
						</div>
						
					</aside><!-- /#sidebar -->
					
				</div> <!-- row -->
			
			</article>
		
		<?php endwhile; // End the loop ?>
	
<?php get_footer(); ?>


