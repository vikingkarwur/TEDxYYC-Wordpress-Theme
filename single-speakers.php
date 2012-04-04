<?php get_header(); ?>
		
		<?php while (have_posts()) : the_post(); ?>
			
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
				<header class="row">
			
					<h1 class="entry-title"><?php the_title(); ?></h1>
			
				</header>
				
				<div class="row">
				
					<aside class=" four columns speakerDetails">
						<div id="speakerImgWrapper">
							<?php 
								if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
									the_post_thumbnail('speaker_full');
								}
							?>
						</div>
						
						<?php 
						$speaker_twitterID = get_post_meta($post->ID, '_tedxyyc_speaker_twitterID_value', true);
						$speaker_email = get_post_meta($post->ID, '_tedxyyc_speaker_email_value', true);
						$speaker_website = get_post_meta($post->ID, '_tedxyyc_speaker_website_value', true);
						if ($speaker_twitterID) : ?>
    						<p><strong>Twitter:</strong> <a href="http://twitter.com/<?php echo $speaker_twitterID ?>"> <?php echo $speaker_twitterID ?></a><br />
						<?php endif; ?>
						<?php if ($speaker_email) : ?>		
							<strong>Email:</strong> <a href="mailto:<?php echo $speaker_email ?>"><?php echo $speaker_email ?></a><br />
						<?php endif; ?>
						<?php if ($speaker_website) : ?>
						<strong>Website:</strong> <a href="<?php echo $speaker_website ?>"><?php echo $speaker_website ?></a>
						<?php endif; ?>
						<?php if ($speaker_twitterID || $speaker_email || $speaker_website) : ?>
						</p>
						<?php endif; ?>
					
					</aside>
					
					<div class="eight columns entry-content">
				
						<?php the_content(); ?>
						
						<?php if (get_post_meta($post->ID, '_tedxyyc_speaker_tedtalk_value', true)) : ?>
						<div class="video_wrapper">
							<div class="video_container">
								<iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo get_post_meta($post->ID, '_tedxyyc_speaker_tedtalk_value', true) ?>" frameborder="0" allowfullscreen></iframe>
							</div>
						</div>
						<?php endif; ?>
					
					</div> <!-- entry-content -->
					
				</div> <!-- row -->
			
			</article>
		
		<?php endwhile; // End the loop ?>
	
<?php get_footer(); ?>
