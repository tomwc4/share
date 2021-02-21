<?php
 global $cl_redata;
 /**
 * Shortcode attributes
 * @var $atts
 * @var $testimon
 * Shortcode class
 * @var  WPBakeryShortCode_Single_Testionial
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


		$output = ''; 

        $output = '<div class="wpb_content_element">';

        if(!isset($testimon))

        $testimon = 0;          

        $query_post = array('posts_per_page'=> 9999, 'post_type'=> 'testimonial', 'p' => $testimon );                          

        $loop = new WP_Query($query_post);

        if($loop->have_posts()){

            while($loop->have_posts()){

                $loop->the_post();  

                            $output .= '<div class="single_testimonial">';
							
							$output .= '<p class="content">'.get_the_content().'</p>';
							
							$output .= '<p><img src="'.esc_url(codeless_image_by_id(get_post_thumbnail_id(), 'thumbnail', 'url')).'" alt=""></p>';

                            //$output .= '<div class="param">';

                            $output .= '<h5>'.esc_html(get_the_title()).'</h5>';
							
							$output .= '<span class="position"> '.esc_attr($cl_redata['staff_position']).'</span>';
							
							if($cl_redata['staff_company_image']) {
								$output .= '<p><img src="'.$cl_redata['staff_company_image']['url'].'"></p>';
							}
							
							if($cl_redata['staff_company_link'] == 'company') {
								$output .= '<p><a href="'.$cl_redata['staff_url'].'" target="_blank">View company</a></p>';
							}
							
							if($cl_redata['staff_company_link'] == 'case-study') {
								$output .= '<p><a href="'.$cl_redata['staff_url'].'" class="btn-bt rounded transparent">View case study</a></p>';
							}
							
							
                            //$output .= '</div>';

                            $output .= '</dd></dl></div>';
            }

        }

        wp_reset_query();

        $output .= '</div>';

        echo $output;

?>