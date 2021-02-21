<?php
global $cl_redata;
get_header();


get_template_part('includes/view/page_header'); ?>
 
<section id="content">
	 <div class="row-fluid row-dynamic-el" style=" margin-bottom:100px;">
      <div class="container">
        <div class="row-fluid">
          
            <div class="span12 not_found">
                <img src="https://www.420websitedesign.com/wp-content/uploads/2019/05/404-custom.jpg" alt="Error 404" title="Error 404">
				<p>Just kidding! This page has probably just been deleted or moved. <br>
				Try searching our site - or <a href="https://www.420websitedesign.com/contact-us/">Contact Us</a>.</p>
                <div class="search_field">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
                             
      </div>
    </div>
</section>
	
<?php get_footer(); ?>