<?php
/*
Template Name: About Page
*/
?>

<?php get_header(); ?>
	
	<?php get_template_part('loop', 'page'); ?>
	
	<?php
			$about_args = array(			  		
					'post_type' => 'committee',
					'orderby' => 'title',
					'order' => 'ASC',
				);
			$about_query = new WP_Query($about_args);
		?>
	
		<?php /* Start loop */ ?>
		<?php $i = 0; ?>
		<?php while ($about_query->have_posts()) : $about_query->the_post(); ?>
		<?php if ($i%3 == 0 && $i != 0) { echo '</ul>'; } ?>
		<?php if ($i%3 == 0) { echo '<ul class="row clearfix committeeRow">'; } ?>
			<li class="four columns member">
					<?php the_post_thumbnail('committee_pic', array(
						'alt' => ''.get_the_title().'',
						'title' => ''.get_the_title().'',
						'class' => 'committeeMember' 
					)); ?>
				
				<h3><?php the_title(); ?></h3>
				<?php if ( get_post_meta($post->ID, '_tedxyyc_committee_weblinks_value', true) ) : ?>
    				<p>Twitter: <a href="http://twitter.com/<?php echo get_post_meta($post->ID, '_tedxyyc_committee_weblinks_value', true) ?>">@<?php echo get_post_meta($post->ID, '_tedxyyc_committee_weblinks_value', true) ?></a></p>
				<?php endif; ?>
				
			</li>
		<?php
			$i++;
			endwhile; // End the loop
			echo '</ul>';
			?>
	
<?php get_footer(); ?>
