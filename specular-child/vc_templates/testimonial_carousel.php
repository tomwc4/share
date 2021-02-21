<?php
global $cl_redata;
/**
 * Shortcode attributes
 * @var $atts
 * @var $test_cat
 * @var $duration
 * Shortcode class
 * @var  WPBakeryShortCode_Testimoniual_Carousel
 */
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

        $output = ''; 

        $output = '<div class="wpb_content_element testimonial_carousel_element">';

        $output .= '<div class="pagination"><a href="#" class="prev"><i class="icon-chevron-left"></i></a><a href="#" class="next"><i class="icon-chevron-right"></i></a></div>';

        $output .= '<section class="row testimonial_carousel" data-duration="1000">';      

        if((int) $test_cat == 0)
            $query_post = array('posts_per_page'=> 9999, 'post_type'=> 'testimonial' );                          
        else{
            $query_post = array('posts_per_page'=> 9999, 
                                'post_type'=> 'testimonial',
                                'tax_query' => array(   array(  'taxonomy'  => 'testimonial_entries', 
                                                                                    'field'     => 'id', 
                                                                                    'terms'     => (int) $test_cat,  
                                                                                    'operator'  => 'IN')) );
        }
        $loop = new WP_Query($query_post);

        if($loop->have_posts()){

            while($loop->have_posts()){

                $loop->the_post();  

                            $output .= '<div class="item">';

							$output .= '<p class="content">'.get_the_content().'</p>';
							
                            $output .= '<div class="param">';

                            $output .= '<h5>'.esc_html(get_the_title()).'</h5>';
							
							$output .= '<span class="position"> '.esc_attr($cl_redata['staff_position']).'</span>';
							
							if($cl_redata['staff_company_image']) {
								$output .= '<p><a href="'.$cl_redata['staff_url'].'" target="_blank"><img src="'.$cl_redata['staff_company_image']['url'].'"></a></p>';
							}
							$output .= '</div>';
							
                            $output .= '</div>';
							
            }

        }

        wp_reset_query();

            $output .= '</section>';

        $output .= '</div>';

        echo $output;

?>