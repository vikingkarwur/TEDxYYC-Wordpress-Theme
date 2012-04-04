<?php
/*
Template Name: Event Details Page
*/
?>

<?php get_header(); ?>
	
	<?php get_template_part('loop', 'page'); ?>
	
	<?php
			$details_args = array(			  		
					'post_type' => 'sponsors',
					'orderby' => 'title',
					'order' => 'ASC',
					'posts_per_page' => -1,
				);
			$details_query = new WP_Query($details_args);
		?>
	
		<?php /* Start loop */ ?>
		<?php $i = 0; ?>
		<?php while ($details_query->have_posts()) : $details_query->the_post(); ?>
		<?php if ($i%3 == 0 && $i != 0) { echo '</ul>'; } ?>
		<?php if ($i%3 == 0) { echo '<ul class="row clearfix">'; } ?>
			<li class="four columns">
				<a href="<?php echo get_post_meta($post->ID, '_tedxyyc_sponsor_url_value', true) ?>" target="_blank" title="<?php the_title(); ?>">
					<?php the_post_thumbnail('sponsor_logo', array(
						'alt' => ''.get_the_title().'',
						'title' => ''.get_the_title().'' 
					)); ?>
				</a>
			</li>
		<?php
			$i++;
			endwhile; // End the loop
			echo '</ul>';
			?>
	
<?php get_footer(); ?>
