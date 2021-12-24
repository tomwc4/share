<?php /*
Template Name: Contact
*/
get_header();?>

 <!-- Start Hero -->
 <section class="hero centered" data-scroll-index="0">
        <div class="title-single-page centered mid-title">
            <div class="title text-center">                
                <h2>Get in Touch</h2>
                <h3>Contact<br>VectorDefector</h3>
            </div>
        </div>
    </section>
<!-- End Hero -->

<div class="page-entry">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-30">       
                <?php the_content();?>
            </div>
        </div>
    </div>
</div>

<div class="between">
    <div class="line-between"></div>
</div>

<?php get_footer(); ?>