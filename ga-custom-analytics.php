<?php 
//add custom analytics dimensions	
    global $post;
	    if(is_home() || is_front_page()):
				$pageType = 'home';
			elseif(is_archive()):
				$pageType = 'category';
			else:
				$pageType = get_post_type($post->ID);
			endif;

			//yoast keyphrase
			$focuskw = WPSEO_Meta::get_value( 'focuskw', $post->ID );
			
			//categories
			$main_category = '';
				
			if(class_exists('WPSEO_Primary_Term')):
				// Show Primary category by Yoast if it is enabled & set
				$get_wpseo_primary_term = new WPSEO_Primary_Term( 'category', $post->ID );
				$wpseo_primary_term = get_term($get_wpseo_primary_term->get_primary_term(), 'category');
				if(!is_wp_error($wpseo_primary_term)):
					$main_category = $wpseo_primary_term->slug;
				endif;
			else:
				//just pull first category
				$categories = get_the_category($post->ID);
				if(!empty($categories)) {
					$topics = array();
					foreach($categories as $key => $cat) {
						$topics[] = $cat->slug;
					}
					$main_category = $topics[0];
				}
		endif;

//custom analytics dimensions
echo "\n<!-- Add custom GA dimensions -->
<script>
window.dataLayer = window.dataLayer || [];
window.dataLayer.push({
'event' : 'ga_custom_dimensions',
'page_type' : '".$pageType."',
'category' : '".$main_category."',
'focus_keyphrase' : '".$focuskw."'
});
</script>";

?>