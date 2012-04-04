<?php

////////////////////////
// General Theme Options
////////////////////////


// Red Button Shortcode!

function button_shortcode( $atts, $content = null ){
	extract( shortcode_atts( array(
      'link' => '',
      ), $atts ) );
 
      return '<a class="button" href="' . $link . '" title="' . $content . '">' . $content . '</a>';
 
}

add_shortcode('button', 'button_shortcode');

// Custom Images and Nav

function tedxyyc_setup(){
	
	// Custom image sizes
	// http://codex.wordpress.org/Post_Thumbnails
	add_image_size('video_thumb', 222, 122, true);
	add_image_size('video_full', 606, 9999, false);
	add_image_size('wide_thumb', 400, 200, true);
	add_image_size('speaker_full', 400, 400, false);
	add_image_size('committee_pic', 400, 400, false);
	add_image_size('sponsor_logo', 400, 400, true);
	
	// http://codex.wordpress.org/Function_Reference/register_nav_menus
	register_nav_menus(array(
		'footer_left' => __('Footer Left'),
		'footer_right' => __('Footer Right'),
		'footer_social' => __('Footer Social')
	));
}

add_action( 'after_setup_theme', 'tedxyyc_setup' );

// Custom Sidebar
// http://codex.wordpress.org/Function_Reference/register_sidebar

function tedxyyc_register_sidebars() {
  $sidebars = array( 'Page Sidebar', 'Blog Sidebar', 'Footer');

  foreach( $sidebars as $sidebar ) {
    register_sidebar(
      array(
        'id'=> 'roots-' . strtolower( $sidebar ),
        'name' => __( $sidebar, 'roots' ),
        'description' => __( $sidebar, 'roots' ),
        'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="container">',
        'after_widget' => '</div></article>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
      )
    );
  }
}

add_action('widgets_init', 'tedxyyc_register_sidebars');

// Add TED.com RSS feed
// http://wp.smashingmagazine.com/2011/05/10/new-wordpress-power-tips-for-template-developers-and-consultants/

function my_dashboard_widgets(){
	wp_add_dashboard_widget('dashboard_custom_feed', 'News from TED.com', 'dashboard_custom_feed_output');
}

function dashboard_custom_feed_output(){
	echo '<div class="rss-widget">';
	wp_widget_rss_output(array(
		'url' => 'http://feeds.feedburner.com/tedblog',
		'title' => 'News from TED.com',
		'items' => 3,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 1
	));
	echo "</div>";
}

add_action('wp_dashboard_setup', 'my_dashboard_widgets');

// Add TEDxYYC logo and redirect link
// http://wp.smashingmagazine.com/2011/12/07/10-tips-optimize-wordpress-theme/

function custom_admin_login(){
	echo '<style type="text/css">
	.login h1 a { background-image: url('. get_template_directory_uri() .'/img/logo-login.png);
	margin-bottom: 10px;}
	</style>
	<script>
		window.onload = function(){
			document.getElementById("login").getElementsByTagName("a")[0].href = "'. home_url() . '";document.getElementById("login").getElementsByTagName("a")[0].title = "Go to site";
		}
	</script>';
}

add_action('login_head', 'custom_admin_login');

// Reorder admin sidebar
// http://sumtips.com/2011/03/remove-reorder-menu-submenu-wordpress.html

function custom_menu_order($menu_ord){
	if (!$menu_ord) return true;
	return array(
		'index.php',
		'edit.php',
		'edit.php?post_type=tedxyyc_speaker',
		'edit.php?post_type=tedxyyc_committee',
		'edit.php?post_type=page',
		'upload.php',
		'edit-comments.php'
	);
}

add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');

// Change posts to blog posts
// http://wp.smashingmagazine.com/2011/05/10/new-wordpress-power-tips-for-template-developers-and-consultants/

function change_post_to_blogpost( $translated ) {
	$translated = str_ireplace(  'Post',  'Blog Post',  $translated );  // ireplace is PHP5 only
	return $translated;
}

add_filter('gettext', 'change_post_to_blogpost');
add_filter('ngettext', 'change_post_to_blogpost');

// Better excerpts by extending the length and changing the continue reading copy

function new_excerpt($charlength) {  
   $excerpt = get_the_excerpt();  
   $charlength++;  
   if(strlen($excerpt)>$charlength) {  
       $subex = substr($excerpt,0,$charlength-5);  
       $exwords = explode(" ",$subex);  
       $excut = -(strlen($exwords[count($exwords)-1]));  
       if($excut<0) {  
            echo substr($subex,0,$excut);  
       } else {  
            echo $subex;  
       }  
       echo " [&hellip;]";  
   } else {  
       echo $excerpt;  
   }  
}  

function custom_excerpt_more($more) {
	return ' [&hellip;]';
}

add_filter('excerpt_more', 'custom_excerpt_more');

/////////////////////////////////////
// Custom Post Types and Meta Fields
/////////////////////////////////////

// Javascipt required for repeatable text fields

function add_admin_scripts($hook) {
	global $post;
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
        if ( 'speakers' === $post->post_type || 'committee' === $post->post_type ) {     
            wp_enqueue_script(  'admin_custom_js', get_template_directory_uri().'/js/admin_custom.js' );
        }
    }
}

add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

// Register custom taxonomies

function create_year_taxonomy() {
	$labels_year = array(
    	'name' => __( 'Years Spoken' ),
    	'singular_name' => __( 'Year Spoken' ),
    	'search_items' =>  __( 'Search Years Spoken' ),
    	'all_items' => __( 'All Years Spoken' ),
    	'edit_item' => __( 'Edit Year Spoken' ),
    	'update_item' => __( 'Update Year Spoken' ),
    	'add_new_item' => __( 'Add New Year Spoken' ),
    	'new_item_name' => __( 'New Year Spoken' )
  	); 	

  	register_taxonomy('tedxyycYear','speakers',array(
    	'hierarchical' => false,
    	'labels' => $labels_year,
		'show_in_nav_menus' => true
  	));
}

add_action( 'init', 'create_year_taxonomy', 0 );

// Create custom post types

function create_post_types() {
	
	$labels_speakers = array(
		'name' => __( 'Speakers' ),
		'singular_name' => __( 'Speaker' ),
		'add_new_item' => __( 'Add New Speaker' ),
		'edit_item' => __( 'Edit Speaker' ),
		'new_item' => __( 'New Speaker' ),
		'view_item' => __( 'View Speaker' ),
		'search_items' => __( 'Search Speakers' ),
		'not_found' => __( 'No speakers found' ),
		'not_found_in_trash' => __( 'No speakers found in Trash' ),
	);
	
	$args_speakers = array(
		'labels' => $labels_speakers,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,		
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array(
			'title', 'editor', 'thumbnail', 'revisions'
		)
	); 	
	
	register_post_type( 'speakers' , $args_speakers );
	
	$labels_committee = array(
		'name' => __( 'Committee' ),
		'singular_name' => __( 'Committee' ),
		'add_new_item' => __( 'Add New Committee Member' ),
		'edit_item' => __( 'Edit Committee Member' ),
		'new_item' => __( 'New Committee Member' ),
		'view_item' => __( 'View Committee' ),
		'search_items' => __( 'Search Committee Members' ),
		'not_found' => __( 'No committee members found' ),
		'not_found_in_trash' => __( 'No committee members found in Trash' ),
	);
	
	$args_committee = array(
		'labels' => $labels_committee,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,		
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array(
			'title', 'thumbnail', 'revisions'
		)
	); 	
	
	register_post_type( 'committee' , $args_committee );
	
	$labels_videopick = array(
		'name' => __( 'Video Picks' ),
		'singular_name' => __( 'Video Pick' ),
		'add_new_item' => __( 'Add New Video Pick' ),
		'edit_item' => __( 'Edit Video Pick' ),
		'new_item' => __( 'New Video Pick' ),
		'view_item' => __( 'View Video Pick' ),
		'search_items' => __( 'Search Video Picks' ),
		'not_found' => __( 'No video picks found' ),
		'not_found_in_trash' => __( 'No video picks found in Trash' ),
	);
	
	$args_videopick = array(
		'labels' => $labels_videopick,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,		
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array(
			'title', 'editor', 'thumbnail', 'revisions'
		)
	); 	
	
	register_post_type( 'videopick' , $args_videopick );
	
	$labels_sponsors = array(
		'name' => __( 'Sponsors' ),
		'singular_name' => __( 'Sponsor' ),
		'add_new_item' => __( 'Add New Sponsor' ),
		'edit_item' => __( 'Edit Sponsor' ),
		'new_item' => __( 'New Sponsor' ),
		'view_item' => __( 'View Sponsor' ),
		'search_items' => __( 'Search Sponsors' ),
		'not_found' => __( 'No sponsors found' ),
		'not_found_in_trash' => __( 'No sponsors found in Trash' ),
	);
	
	$args_sponsors = array(
		'labels' => $labels_sponsors,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,		
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array(
			'title', 'thumbnail',
		)
	); 	
	
	register_post_type( 'sponsors' , $args_sponsors );
}

add_action( 'init', 'create_post_types' );

// Create fields for meta boxes

$prefix = "_tedxyyc_";

$speaker_details = array(
	array(
		'label' => 'First Name',
		'desc' => 'Please enter the speakers first name.',
		'name' => $prefix.'speaker_firstname',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'Last Name',
		'desc' => 'Please enter the speakers last name.',
		'name' => $prefix.'speaker_lastname',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'Job Position',
		'desc' => 'Please enter the speakers job position.',
		'name' => $prefix.'speaker_jobposition',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'Employer',
		'desc' => 'Please enter the speakers current employer.',
		'name' => $prefix.'speaker_employer',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'TEDx Talk Youtube ID',
		'desc' => 'Add the speakers TEDx talk youtube ID number here. <br />e.g. http://www.youtube.com/watch?v=<strong>HGiHU-agsGY</strong>',
		'name' => $prefix.'speaker_tedtalk',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'Twitter Username',
		'desc' => 'Please add the speakers Twitter username.',
		'name' => $prefix.'speaker_twitterID',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'Email Address',
		'desc' => 'Please add the speakers email address.',
		'name' => $prefix.'speaker_email',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'Personal Website',
		'desc' => 'Please add the speakers personal website.',
		'name' => $prefix.'speaker_website',
		'type' => 'text',
		'std' => ''
	)
);

$committee_details = array(
	array(
		'label' => 'Theme Keyword',
		'desc' => 'Please enter the conference theme keyword',
		'name' => $prefix.'committee_themekeyword',
		'type' => 'text',
		'std' => ''
	),
	array(
		'label' => 'Twitter',
		'desc' => 'Please add the committee members Twitter handle.',
		'name' => $prefix.'committee_weblinks',
		'type' => 'text',
		'std' => ''
	),
);

$videopick_details = array(
	array(
		'label' => 'Youtube ID',
		'desc' => 'Add the youtube id number here. <br />e.g. http://www.youtube.com/watch?v=<strong>HGiHU-agsGY</strong>',
		'name' => $prefix.'videopick_youtubeID',
		'type' => 'text',
		'std' => ''
	),
);	

$sponsor_details = array(
	array(
		'label' => 'Sponsor Website',
		'desc' => 'Add the sponsors website URL here.',
		'name' => $prefix.'sponsor_url',
		'type' => 'text',
		'std' => ''
	),
);

// Place fields in meta boxes

$meta_box_groups = array($speaker_details, $committee_details, $videopick_details, $sponsor_details );

function new_meta_box($post, $metabox) {	
	
	$meta_boxes_inputs = $metabox['args']['inputs'];

	foreach($meta_boxes_inputs as $meta_box) {
	
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
		if($meta_box_value == "") $meta_box_value = $meta_box['std'];
		
		echo'<div class="meta-field">';
		
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		
		echo'<p><strong>'.$meta_box['label'].'</strong></p>';
		
		if(isset($meta_box['type']) && $meta_box['type'] == 'text')  {			
			
			echo'<textarea rows="4" style="width:98%" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">'.$meta_box_value.'</textarea><br />';			
			echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['desc'].'</label></p><br />';			
		
		} else {
					
			echo '<span>Add a URL &nbsp; </span><a class="repeatable-add button" href="#">+</a> 
				  <ul id="'.$meta_box['name'].'-repeatable" class="custom_repeatable">';  
			$i = 0;  
			if ($meta_box_value) {  
		        foreach($meta_box_value as $row) {  
		            echo '<li><span class="sort hndle">|||</span>
		                        <input type="text" name="'.$meta_box['name'].'['.$i.']_value" id="'.$meta_box['name'].'_value" value="'.$row.'" size="30" placeholder="URL"/> 
		                        <a class="repeatable-remove button" href="#">-</a></li>';  
		            $i++;
		        }  
		    } else {  
		        echo '<li><span class="sort hndle">|||</span> 
		              	<input type="text" name="'.$meta_box['name'].'['.$i.']_value" id="'.$meta_box['name'].'_value" value="" size="30" /> 
		              	<a class="repeatable-remove button" href="#">-</a></li>';  
		    }  
		    echo '</ul> 
		          <span class="description">'.$meta_box['desc'].'</span>'; 
		}
		
		echo'</div>';
		
	} // end foreach
	
} // end meta boxes

// Assign meta boxes to each post type

function create_meta_box() {	
	global $speaker_details, $committee_details, $videopick_details, $sponsor_details;	
	
	if ( function_exists('add_meta_box') ) {
		add_meta_box(
			'speaker_details', // $id
			'Speaker Details', // $title
			'new_meta_box', // $callback
			'speakers', // $page
			'normal', // $context
			'high', // $priority
			array('inputs'=>$speaker_details)
		);
		add_meta_box(
			'committee_details', // $id
			'Committee Member Details', // $title
			'new_meta_box', // $callback
			'committee', // $page
			'normal', // $context
			'high', // $priority
			array('inputs'=>$committee_details)
		);
		add_meta_box(
			'videopick_details', // $id
			'Video Pick Details', // $title
			'new_meta_box', // $callback
			'videopick', // $page
			'normal', // $context
			'high', // $priority
			array('inputs'=>$videopick_details)
		);
		add_meta_box(
			'sponsor_details', // $id
			'Sponsor Details', // $title
			'new_meta_box', // $callback
			'sponsors', // $page
			'normal', // $context
			'high', // $priority
			array('inputs'=>$sponsor_details)
		);	
	}
}

// Save data and check for autosaves and existing data

function save_postdata( $post_id ) {
	global $post, $new_meta_boxes, $speaker_details, $committee_details, $videopick_details, $meta_box_groups;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if( defined('DOING_AJAX') && DOING_AJAX ) { //Prevents the metaboxes from being overwritten while quick editing.
		return $post_id;
	}

	if( ereg('/\edit\.php', $_SERVER['REQUEST_URI']) ) { //Detects if the save action is coming from a quick edit/batch edit.
		return $post_id;
	}
	
	foreach($meta_box_groups as $group) {
		foreach($group as $meta_box) {
	
			// Verify
			if(isset($_POST[$meta_box['name'].'_noncename'])){
				if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
					return $post_id;
				}
			}
	
			if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ))
					return $post_id;
			} else {
				if ( !current_user_can( 'edit_post', $post_id ))
					return $post_id;
			}
	
			$data = "";
			if(isset($_POST[$meta_box['name'].'_value'])){
				$data = $_POST[$meta_box['name'].'_value'];
			}
	
			if(get_post_meta($post_id, $meta_box['name'].'_value') == "") 
				add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
			elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
				update_post_meta($post_id, $meta_box['name'].'_value', $data);
			elseif($data == "" || $data == $meta_box['std'] )
				delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
			
		} // end foreach
	} // end foreach
} // end save_postdata

add_action('save_post', 'save_postdata');
add_action('admin_menu', 'create_meta_box');

?>