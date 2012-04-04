<?php get_header(); ?>
		
		<?php while (have_posts()) : the_post(); ?>
			
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
				<header class="row">
			
					<h1 class="entry-title"><?php the_title(); ?></h1>
			
				</header>
				
				<div class="row">
					
					<div class="eight columns entry-content">
				
						<?php the_content(); ?>
					
						<footer>
							<p class="post-<?php the_ID(); ?>-meta">Posted on: <?php the_time('F jS, Y') ?> | Posted in: <?php the_category(', ') ?></p>
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
