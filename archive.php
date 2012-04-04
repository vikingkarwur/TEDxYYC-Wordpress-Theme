<?php get_header(); ?>
	
	<div class="row">
		<div class="eight columns">
		
		<h1>
            <?php
              $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
              if ($term) {
                echo $term->name;
              } elseif (is_day()) {
                printf(__('Daily Archives: %s', 'roots'), get_the_date());
              } elseif (is_month()) {
                printf(__('Monthly Archives: %s', 'roots'), get_the_date('F Y'));
              } elseif (is_year()) {
                printf(__('Yearly Archives: %s', 'roots'), get_the_date('Y'));
              } elseif (is_author()) {
                global $post;
                $author_id = $post->post_author;
                printf(__('Author Archives: %s', 'roots'), get_the_author_meta('user_nicename', $author_id));
              } else {
                single_cat_title();
              }
            ?>
          </h1>
		
		<?php get_template_part('loop', 'category'); ?>
		
		</div>
		
		<aside id="sidebar" class="four columns" role="complementary">
			
			<div class="container">
				<?php dynamic_sidebar("Blog Sidebar"); ?>
			</div>
			
		</aside><!-- /#sidebar -->
		
	</div>
	
<?php get_footer(); ?>