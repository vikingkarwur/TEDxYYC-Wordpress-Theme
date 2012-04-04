<?php get_header(); ?>

	<div class="row">
		<div class="eight columns">
		
		<?php get_template_part('loop', 'page'); ?>
		
		</div>
          
      	<aside id="sidebar" class="four columns" role="complementary">
      	
      		<?php echo 'page.php' ?>
			
			<div class="container">
				<?php dynamic_sidebar("Page Sidebar"); ?>
			</div>
			
		</aside><!-- /#sidebar -->
		
	</div>
	
<?php get_footer(); ?>
