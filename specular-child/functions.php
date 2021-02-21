<?php
function child_enqueue_scripts() {
	$parent_style = 'specular';
   	wp_enqueue_style( 'child-style',  get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array( $parent_style ) );
	//wp_enqueue_style('linea-icons', get_template_directory().'/linea_complete/', array( $parent_style ));
	//wp_enqueue_script('wistia-video', 'https://fast.wistia.net/static/iframe-api-v1.js', array( 'jquery' ));
	////fast.wistia.com/assets/external/E-v1.js
	//wp_enqueue_script('child-main-js', get_stylesheet_directory_uri().'/js/main.js', array( 'jquery' ));
	//google fonts
	//wp_enqueue_style( 'co420-google-fonts', '//fonts.googleapis.com/css?family=Monterrat|Great+Vibes|Raleway|Lato:300,300i,400,400i,900' );


}

add_action( 'wp_enqueue_scripts', 'child_enqueue_scripts', 15);

function parent_enqueue_scripts() {	
    wp_enqueue_style('specular', get_template_directory_uri() . '/style.css' );
	//replace old JS with child
	//wp_dequeue_script('main');
}

add_action( 'wp_enqueue_scripts', 'parent_enqueue_scripts', 25);


//### Custom Social Icon Script - Pulls data from Theme settings ## //

function outputSocialIcons($atts) {
	
	global $cl_redata;
	
	//usage [icon type="bars"]

	// Attributes
	extract( shortcode_atts(
		array(
		), $atts )
	);

	if($cl_redata['facebook']) {
		echo do_shortcode('[social_icons icon="facebook" link="'.$cl_redata['facebook'].'"]');				
	}
	
	if($cl_redata['twitter']) {
		echo do_shortcode('[social_icons icon="twitter" link="'.$cl_redata['twitter'].'"]');				
	}
	
	if($cl_redata['linkedin']) {
		echo do_shortcode('[social_icons icon="linkedin" link="'.$cl_redata['linkedin'].'"]');				
	}
	
	if($cl_redata['google']) {
		echo do_shortcode('[social_icons icon="google" link="'.$cl_redata['google'].'"]');				
	}
	
	if($cl_redata['instagram']) {
		echo do_shortcode('[social_icons icon="instagram" link="'.$cl_redata['instagram'].'"]');				
	}
	
	if($cl_redata['snapchat']) {
		echo do_shortcode('[social_icons icon="snapchat" link="'.$cl_redata['snapchat'].'"]');				
	}
	
	if($cl_redata['youtube']) {
		echo do_shortcode('[social_icons icon="youtube" link="'.$cl_redata['youtube'].'"]');				
	}
	
	if($cl_redata['foursquare']) {
		echo do_shortcode('[social_icons icon="foursquare" link="'.$cl_redata['foursquare'].'"]');				
	}
	
	if($cl_redata['flickr']) {
		echo do_shortcode('[social_icons icon="flickr" link="'.$cl_redata['flickr'].'"]');				
	}
	
	if($cl_redata['vimeo']) {
		echo do_shortcode('[social_icons icon="vimeo" link="'.$cl_redata['vimeo'].'"]');				
	}
	
	
}
add_shortcode( 'socialIcons', 'outputSocialIcons' );

function showSubNav($atts) {
	
	global $cl_redata;
	
	//usage [icon type="bars"]

	// Attributes
	extract( shortcode_atts(
		array(
		), $atts )
	);
	
	if($atts['value']) {
		echo '<div class="pageSubMenu">';
		wp_nav_menu( array('menu' => $atts['value'] ));
		echo '</div>';
	}
	
}


add_shortcode( 'showSubNav', 'showSubNav' );

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
	
	if($latestPostImg) {
		return $latestPostImg[0];
	}
	
}

//force rewrite to get rid of that "staff_trusted" slug
add_filter( 'register_post_type_args', 'co420_register_post_type_args', 10, 2 );

function co420_register_post_type_args( $args, $post_type ) {

    if ( 'staff' === $post_type ) {
        $args['rewrite']['slug'] = 'staff';
    }

    return $args;
}


// ## add extra fields to testimonials ### ///

if ( !function_exists( "co420_add_testimonial_metaboxes" ) ):
    function co420_add_testimonial_metaboxes($metaboxes) {

        $testimonial_options = array();

        $testimonial_options[] = array(
            //'title'         => __('General Settings', 'codeless-admin'),
            'icon_class'    => 'icon-large',
            'icon'          => 'el-icon-home',
            'fields'        => array(
                array(
                    'id' => 'staff_position',
                    'title' => __( 'Testimonial Position/Title', 'codeless' ),
                    'desc' => 'Write here the position for this testimonial post',
                    'type' => 'text'
                ),
				array(
                    'id' => 'staff_company_image',
                    'title' => __( 'Testimonial Company Logo', 'codeless' ),
                    'desc' => 'Upload a company logo',
                    'type' => 'media'
                ),
				array(
					'id' => 'staff_company_link',
					'type' => 'select',
					'title' => __('Show Link?', 'codeless-admin'),
					'subtitle' => __('Include a link to a company page or case study?', 'codeless-admin'),
					'options' => array('company' => 'Company URL', 'case-study' => 'Case Study page', 'off' => 'Off' ), //Must provide key => value pairs for select options
					'default' =>  'light'
				),
				 array(
                    'id' => 'staff_url',
                    'title' => __( 'Testimonial Company Link', 'codeless' ),
                    'desc' => 'Add a URL to a case study or company page',
                    'type' => 'text'
                ),
            ),
        );


        $metaboxes[] = array(
            'id'            => 'testimonial-options',
            'title'         => __( 'Testimonial Options', 'codeless' ),
            'post_types'    => array( 'testimonial'),
            'position'      => 'normal', // normal, advanced, side
            'priority'      => 'high', // high, core, default, low
            'sidebar'       => false, // enable/disable the sidebar in the normal/advanced positions
            'sections'      => $testimonial_options,
        );
        return $metaboxes;
    }
   
endif;

add_action('redux/metaboxes/cl_redata/boxes', 'co420_add_testimonial_metaboxes', 26);

//fix contact form 7 refill hanging
add_action('wp_enqueue_scripts', 'wpcf7_recaptcha_no_refill', 15, 0);

function wpcf7_recaptcha_no_refill() {
  $service = WPCF7_RECAPTCHA::get_instance();
	if ( ! $service->is_active() ) {
		return;
	}
  wp_add_inline_script('contact-form-7', 'wpcf7.cached = 0;', 'before' );
}


/**
 * WP hook that combines all google font HTTP calls into one URL from theme and plugins.
 */
add_action('wp_enqueue_scripts', 'combine_google_fonts', 99);
function combine_google_fonts(){
	global $wp_styles;

	// Check for any enqueued `fonts.googleapis.com` from themes or plugins
	if( isset( $wp_styles->queue ) ){

		$google_fonts_domain = '//fonts.googleapis.com/css';
		$enqueued_google_fonts = array();
		$families = array();			
		$subsets = array();
		$font_args = array();		

		// Collect all enqueued google fonts
		foreach( $wp_styles->queue as $key => $handle ){

			if ( ! isset( $wp_styles->registered[ $handle ] ) ) {
				continue;
			}

			$style_src = $wp_styles->registered[ $handle ]->src;

			if (strpos($style_src, 'fonts.googleapis.com/css') !== false) {
			$url = wp_parse_url( $style_src );

			if( is_string( $url['query'] ) ) {
				parse_str( $url['query'], $parsed_url );

				if( isset( $parsed_url['family'] ) ){

					// Collect all subsets
					if( isset( $parsed_url['subset'] ) ){
						$subsets[] = urlencode( trim( $parsed_url['subset'] ) );					 			
					}

					$font_families = explode( '|', $parsed_url['family'] );
					foreach( $font_families as $parsed_font ){

						$get_font = explode( ':', $parsed_font );

						// Extract the font data
						if( isset( $get_font[0] ) && !empty( $get_font[0] ) ){
							$family = $get_font[0];
							$weights = isset( $get_font[1] ) && !empty( $get_font[1] ) ? explode( ',', $get_font[1] ) : array();

							// Combine weights if family has been enqueued
							if( isset( $enqueued_google_fonts[ $family ] ) && $weights != $enqueued_google_fonts[ $family ]['weights'] ){
								$combined_weights = array_merge($weights, $enqueued_google_fonts[ $family ]['weights']);
								$enqueued_google_fonts[ $family ]['weights'] = array_unique( $combined_weights );
							}
							else {
								$enqueued_google_fonts[ $family ] = array(
									'handle'	=> $handle,
									'family'	=> $family,
									'weights'	=> $weights
								);

								// Remove enqueued google font style, so we would only have one HTTP request.
								wp_dequeue_style( $handle );
							}
						}
					}			        		
				}				        	
			}
		    }
		}

		// Start combining all enqueued google fonts
		if( count($enqueued_google_fonts) > 0 ){

			foreach( $enqueued_google_fonts as $family => $data ){
				// Collect all family and weights
			if( !empty( $data['weights'] ) ) {
				$families[] = $family .':'. implode(',', $data['weights']);
			}
			else {
				$families[] = $family;
			}
			}

			if( !empty( $families ) ){
				$font_args['family'] = implode('|', $families);

				if( !empty( $subsets ) ){
					$font_args['subset'] = implode(',', $subsets);
				}

				$src = add_query_arg( $font_args, $google_fonts_domain );

				// Enqueue google fonts into one URL request
				wp_enqueue_style(
					'fl-builder-google-fonts-'. md5( $src ), 
					$src,
					array()
				);

				// Clears data
				$enqueued_google_fonts = array();
			}
		}
	}
}
?>