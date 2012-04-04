<?php get_header(); ?>
		
		<h1><?php _e('Latest News', 'roots');?></h1>
		
		<div class="row">
		
			<div class="eight columns">
			
				<?php
					$args = array(			  		
						'post_type' => array('post', 'videopick'),
						'year' => '2012',
					);
					
					query_posts($args);
					
				?>
			
				<?php while (have_posts()) : the_post(); ?>
		    	<?php if ( 'videopick' == get_post_type()){ ?>
		    
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header>
								<h2><a href="<?php the_permalink(); ?>">Video Pick: <?php the_title(); ?></a></h2>
								<p class="post-<?php the_ID(); ?>-meta">Posted on: <?php the_time('F jS, Y') ?><span><?php //comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></span></p>
							</header>
							<div class="entry-content">
								<a href="<?php the_permalink(); ?>" class="readMore">
								<?php 
									if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
										the_post_thumbnail('video_full');
									}
								?>
								</a>
								<?php the_excerpt(); ?>
							</div>
						</article>
				
				<? } else { ?>
		    
		    		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p class="post-<?php the_ID(); ?>-meta">Posted on: <?php the_time('F jS, Y') ?> | Posted in: <?php the_category(', ') ?><span><?php //comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></span></p>
						</header>
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div>
					</article>
		    
		    	<?php } ?>
				<?php endwhile; // End the loop ?>
			
			</div> <!-- eight columns -->
			
			<aside id="sidebar" class="four columns" role="complementary">
				
				<div class="container">
					<?php dynamic_sidebar("Blog Sidebar"); ?>
				</div>
				
			</aside><!-- /#sidebar -->
		
		</div> <!-- row -->
	
<?php get_footer(); ?>
