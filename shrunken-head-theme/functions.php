<?php
//#### THEME UTILITY FUNCTIONS #### //

function showCredits() {
	$my_theme = wp_get_theme();
	echo '*Credits* '.$my_theme->get( 'Name' ) . " " . $my_theme->get( 'Version' ).'. '.$my_theme->get('Description').' [for details, visit: '.$my_theme->get('AuthorURI').'] ';
}

// excerpt reloaded
function wp_the_excerpt_reloaded($args='') {
	parse_str($args);
	if(!isset($excerpt_length)) $excerpt_length = 120; // length of excerpt in words. -1 to display all excerpt/content
	if(!isset($allowedtags)) $allowedtags = '<a>'; // HTML tags allowed in excerpt, 'all' to allow all tags.
	if(!isset($filter_type)) $filter_type = 'none'; // format filter used => 'content', 'excerpt', 'content_rss', 'excerpt_rss', 'none'
	if(!isset($use_more_link)) $use_more_link = 1; // display
	if(!isset($more_link_text)) $more_link_text = "(more...)";
	if(!isset($force_more)) $force_more = 1;
	if(!isset($fakeit)) $fakeit = 1;
	if(!isset($fix_tags)) $fix_tags = 1;
	if(!isset($no_more)) $no_more = 0;
	if(!isset($more_tag)) $more_tag = 'div';
	if(!isset($more_link_title)) $more_link_title = 'Continue reading this entry';
	if(!isset($showdots)) $showdots = 1;

	return the_excerpt_reloaded($excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $fix_tags, $no_more, $more_tag, $more_link_title, $showdots);
}

function the_excerpt_reloaded($excerpt_length=120, $allowedtags='<a>', $filter_type='none', $use_more_link=true, $more_link_text="(more...)", $force_more=true, $fakeit=1, $fix_tags=true, $no_more=false, $more_tag='div', $more_link_title='Continue reading this entry', $showdots=true) {
	if(preg_match('%^content($|_rss)|^excerpt($|_rss)%', $filter_type)) {
		$filter_type = 'the_' . $filter_type;
	}
	echo get_the_excerpt_reloaded($excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $fix_tags, $no_more, $more_tag, $more_link_title, $showdots);
}

function get_the_excerpt_reloaded($excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $fix_tags, $no_more, $more_tag, $more_link_title, $showdots) {
	global $post;

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) { // and it doesn't match cookie
			if(is_feed()) { // if this runs in a feed
				$output = __('There is no excerpt because this is a protected post.');
			} else {
	            $output = get_the_password_form();
			}
		}
		return $output;
	}

	if($fakeit == 2) { // force content as excerpt
		$text = $post->post_content;
	} elseif($fakeit == 1) { // content as excerpt, if no excerpt
		$text = (empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { // excerpt no matter what
		$text = $post->post_excerpt;
	}

	if($excerpt_length < 0) {
		$output = $text;
	} else {
		if(!$no_more && strpos($text, '<!--more-->')) {
		    $text = explode('<!--more-->', $text, 2);
			$l = count($text[0]);
			$more_link = 1;
		} else {
			$text = explode(' ', $text);
			if(count($text) > $excerpt_length) {
				$l = $excerpt_length;
				$ellipsis = 1;
			} else {
				$l = count($text);
				$more_link_text = '';
				$ellipsis = 0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . ' ';
	}

	if('all' != $allowedtags) {
		$output = strip_tags($output, $allowedtags);
	}

//	$output = str_replace(array("\r\n", "\r", "\n", "  "), " ", $output);

	$output = rtrim($output, "\s\n\t\r\0\x0B");
    $output = ($fix_tags) ? balanceTags($output, true) : $output;
	$output .= ($showdots && $ellipsis) ? '...' : '';
	$output = apply_filters($filter_type, $output);

	switch($more_tag) {
		case('div') :
			$tag = 'div';
		break;
		case('span') :
			$tag = 'span';
		break;
		case('p') :
			$tag = 'p';
		break;
		default :
			$tag = 'span';
	}

	if ($use_more_link && $more_link_text) {
		if($force_more) {
			$output .= ' <' . $tag . ' class="more-link"><a href="'. get_permalink($post->ID) . '#more-' . $post->ID .'" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		} else {
			$output .= ' <' . $tag . ' class="more-link"><a href="'. get_permalink($post->ID) . '" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		}
	}
	
	$output = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $output );

	return $output;
}


function timeAgo($dateObj) {
	
	if(!$dateObj) { exit; }
	
	$time = strtotime($dateObj);
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	
	$now = time();
	
	 $difference     = $now - $time;
	 $tense         = "ago";
	
	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	 $difference /= $lengths[$j];
	}
	
	$difference = round($difference);
	
	if($difference != 1) {
	 $periods[$j].= "s";
	}
	
	return "$difference $periods[$j] ago ";
}


function relativeTime($time){
	
	define("SECOND", 1);
	define("MINUTE", 60 * SECOND);
	define("HOUR", 60 * MINUTE);
	define("DAY", 24 * HOUR);
	define("MONTH", 30 * DAY);

    $delta = strtotime('+2 hours') - $time;
	
    if ($delta < 2 * MINUTE) {
        return "1 min";
    }
    if ($delta < 45 * MINUTE) {
        return floor($delta / MINUTE) . " mins";
    }
    if ($delta < 90 * MINUTE) {
        return "1 hr";
    }
    if ($delta < 24 * HOUR) {
        return floor($delta / HOUR) . " hrs";
    }
    if ($delta < 30 * DAY) {
        return floor($delta / DAY) . " d";
    }
    if ($delta < 12 * MONTH) {
        $months = floor($delta / DAY / 30);
        return $months <= 1 ? "1 mnth" : $months . " mths";
    } else {
        $years = floor($delta / DAY / 365);
        return $years <= 1 ? "1 yr" : $years . " yrs";
	}
}

//#### THEME SPECIFIC FUNCTIONS #### //

//remove new WP emoji scripts
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );	

//remove theme editor abilities
add_action('admin_menu', 'my_remove_menu_elements', 102);

function my_remove_menu_elements(){
	
	$user = wp_get_current_user();
	
	//posts 
	remove_menu_page('edit.php');
	//pages
	//remove_menu_page('edit.php?post_type=page');
	//comments
	remove_menu_page('edit-comments.php');
	//theme editor
	remove_submenu_page( 'themes.php', 'theme-editor.php' );
	//css editor
	remove_submenu_page( 'themes.php', 'themes.php?page=editcss' );
	//customizer
	remove_submenu_page('themes.php','customize.php');
	
	if(!$user->has_cap('promote_user')) {
		//tools
		remove_menu_page('tools.php');
		//settings
		remove_menu_page('options-general.php');
	}
}

//custom sidebars
if ( function_exists('register_sidebars') ) {
	
register_sidebars(1,
		array(
			'name' => 'Sidebar',
			'id' => 'sidebar',
			'description' => 'Put Widgets Here',
			'before_widget' => '<div class="sidebarEntry">',
			'after_widget' => '</div>', 
			'before_title' => '<h2>',
			'after_title' => '</h2>'
		)
	);

}

//add options to theme

add_action( 'after_setup_theme', 'themeSetup' );

function themeSetup(){
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'menus' );
	//add_theme_support( 'woocommerce' );
		
}

//allow upload of additional filetypes
add_filter('upload_mimes', 'my_upload_mimes');
add_filter('mime_types', 'my_upload_mimes');

function my_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['ico'] = 'image/x-icon';
	$existing_mimes['csv'] = 'text/csv';
	$existing_mimes['webp'] = 'image/webp';
	$existing_mimes['svg'] = 'image/svg+xml';
    return $existing_mimes;
} 

//custom dashboard
add_action('admin_menu','vd_register_menu');
add_action('load-index.php', 'vd_redirect_dashboard');

function vd_redirect_dashboard() {
	
	//$user = wp_get_current_user();

	//if( is_admin() ) {
		$screen = get_current_screen();
		//if( $screen->base == 'dashboard' && !$user->has_cap('manage_options')) {
			if($screen->base == 'dashboard') {
			wp_redirect( admin_url( 'index.php?page=simple-dashboard' ) );
			
		} 
	//}
}

function vd_register_menu() {
	add_dashboard_page( 'Dashboard', 'Dashboard', 'read', 'simple-dashboard','vd_create_dashboard');
} 

function vd_create_dashboard() {
	include_once('custom_dashboard.php');
}


add_action( 'wp_enqueue_scripts', 'vdThemeScripts' );
 
function vdThemeScripts() {
	//bootstrap
	wp_enqueue_style( 'vd-bootstrap-style', get_bloginfo('template_directory').'/css/bootstrap.min.css' );
	wp_enqueue_script( 'vd-theme-bootstrap', get_bloginfo('template_directory').'/js/bootstrap.min.js', array( 'jquery' ));
	//fonts
	wp_enqueue_style( 'vd-fontawesome-1', get_bloginfo('template_directory').'/css/fontawesome.min.css'  );
	wp_enqueue_style( 'vd-fontawesome-2', get_bloginfo('template_directory').'/css/brands.css'  );
	wp_enqueue_style( 'vd-fontawesome-3', get_bloginfo('template_directory').'/css/solid.css'  );
	wp_enqueue_style( 'vd-font-1', 'https://fonts.googleapis.com/css?family=Playfair+Display&display=swap');
	wp_enqueue_style( 'vd-font-2', 'https://fonts.googleapis.com/css?family=Lato&display=swap');

	wp_enqueue_style( 'vd-main-style', get_bloginfo('template_directory').'/style.min.css', array(), filemtime(__DIR__. '/style.min.css') ); //main style always coes last
	//scripts
	wp_enqueue_script( 'vd-main-script', get_bloginfo('template_directory').'/js/page.min.js', array( 'jquery' ), filemtime(__DIR__. '/js/page.min.js'));

} 


//add a custom post type
 
//menu_icon => http://melchoyce.github.io/dashicons/
 
//add_action( 'init', 'custom_posts' );

function custom_posts()  {
  //Services section
    $labels = array(
    'name' => _x('Services', 'post type general name'),
    'singular_name' => _x('Services', 'post type singular name'),
    'add_new' => _x('Add Service', 'show'),
    'add_new_item' => __('Add New Service'),
    'edit_item' => __('Edit Services'),
    'new_item' => __('New Service'),
    'view_item' => __('View Services'),
    'search_items' => __('Search Services'),
    'not_found' =>  __('No Services found'),
    'not_found_in_trash' => __('No Services found in Trash'), 
    'parent_item_colon' => ''
  );
     
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => false,
    'capability_type' => 'post',
	'exclude_from_search' => false,
    'hierarchical' => true,
    'menu_position' => 6,
    'supports' => array('title','editor','thumbnail','page-attributes')
  ); 
  
  //register_post_type('service',$args);
	
}

function outputIcon( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
		), $atts )
	);
	
	if($atts["type"] != '') {
		return '<i class="fa fa-'.$atts['type'].'"></i>';	
	}
	
}
add_shortcode( 'icon', 'outputIcon' );

function outputSocials( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
		), $atts )
	);
	 
    if( have_rows('social_links','options') ):

	$output = '<div class="socials">';
    
       while( have_rows('social_links','options') ) : the_row();
				
			if(get_sub_field('link') != "") {
			
				$output .= '<div id="social" class="socialBtn btnFade" onclick="goTo(\''.get_sub_field('link').'\',\'_blank\');" title="Follow '.get_bloginfo('name').' on '.get_sub_field('label').'">
            
				'.get_sub_field('icon').'</div>';
            }

         endwhile;

		$output .= '</div>';
	   endif;
	   
	   return $output;
	
}

add_shortcode( 'socials', 'outputSocials' );


function getCorrectFeaturedImage($pageID,$size) {
	global $wpdb;
	global $forceSiteRoot;
	global $path;
	
	$query_prefix = $wpdb->prefix;
	
	$featuredImg = $wpdb->get_results("SELECT ".$query_prefix."postmeta.post_id, ".$query_prefix."postmeta.meta_value, ".$query_prefix."posts.ID
								FROM ".$query_prefix."posts, ".$query_prefix."postmeta
								WHERE ".$query_prefix."postmeta.post_id = ".$pageID."
								AND ".$query_prefix."postmeta.meta_key = '_thumbnail_id'
								AND ".$query_prefix."posts.ID = ".$query_prefix."postmeta.post_id");
	
	$imgID = $featuredImg[0]->meta_value;
	 
	$latestPostImg = wp_get_attachment_image_src($imgID,$size);
	
	return $latestPostImg[0];
	
}

// ### Custom Featured Posts Widget ### //

//Custom Featured Post

class featured_widget extends WP_Widget {

	// constructor
	function featured_widget() {
	// Give widget name here
	parent::WP_Widget(false, $name = __('Fancy Featured Posts', 'wp_widget_plugin') );
	}

	function form($instance) {
	
		// Check values
		if($instance) {
			$title = esc_attr($instance['title']);
			$count = esc_attr($instance['count']);
		} else {
			$title = '';
			$count = '1';
		}
	
		echo '<p>
		<label for="'.$this->get_field_id('title').'">'._e('Title', 'wp_widget_plugin').'</label>
		<input class="widefat" id="'.$this->get_field_id('title').'" name="'. $this->get_field_name('title').'" type="text" value="'.$title.'" />
		</p>';
		
		echo '<p>
		<label for="'.$this->get_field_id('count').'">'._e('Entries to Show:', 'wp_widget_plugin').'</label>
		<input id="'.$this->get_field_id('count').'" name="'. $this->get_field_name('count').'" type="text" value="'.$count.'" />
		</p>';
	
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
		return $instance;
	}

	// display widget
	function widget($args, $instance) {
		
		global $wpdb;
		
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		echo $before_widget;
		
		// Display the widget
		echo '<div class="widget-title">';
		if ($title) {
			echo $before_title . $title . $after_title ;
		}
		echo '</div>';
		
		$getFeaturedPostData = $wpdb->get_results("SELECT ID, post_title, post_content, post_date FROM ".$wpdb->prefix."posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC LIMIT ".$count);
		
		//print_r($getFeaturedPostData); 
		
		if(count($getFeaturedPostData) > 0) {
			
			foreach($getFeaturedPostData as $key => $postObj) {
				
			echo '<div id="fancy_featured_posts" class="featuredSidebarEntry">';
			
			$authorID = get_the_author_meta('ID',$postObj->post_author);
			$link = get_permalink($postObj->ID);

			$imgSize = 'thumbnail';
			
			echo '<div class="blogPhoto">';

			echo '<a href="'.$link.'" title="Read More: '.$postObj->post_title.'">';
			
			if(getCorrectFeaturedImage($postObj->ID,$imgSize)){
				echo '<img src="'.getCorrectFeaturedImage($postObj->ID,$imgSize).'" alt="Read More: '.$postObj->post_title.'" class="btnFade" />';
			} else {
				$attachments = get_children( array('post_parent' => $postObj->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
				
				if(count($attachments) > 0) {
						echo '<img src="'.wp_get_attachment_image_src($attachments[0], $imgSize).'" alt="Read More: '.get_the_title().'" class="btnFade" />';	
					} else {
						echo '<img src="'.get_bloginfo('template_directory').'/images/default_80x80.jpg" class="btnFade"/>';	
					}
			}
			echo '</a>';
			echo '</div>';
			echo '<h3><a href="'.$link.'" title="Read More: '.$postObj->post_title.'">'.$postObj->post_title.'</a></h3>';
			//echo timeAgo($postObj->post_date);
			echo renderExcerpt($postObj,20);
			echo '</div>';
			  
			}
			   
		}
		
		echo $after_widget;
		}
}

//end custom widget class

// register widget
add_action('widgets_init', create_function('', 'return register_widget("featured_widget");'));

// ###	theme options page ##### ///

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Theme General Settings'),
            'menu_title'    => __('Theme Settings'),
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}


/* Theme Specific Custom */


?>