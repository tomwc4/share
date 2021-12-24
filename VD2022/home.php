<?php get_header(); ?>

 <!-- Start Hero -->
 <section class="hero centered" data-scroll-index="0">
        <div class="title-single-page centered mid-title">
            <div class="title text-center">
                <h2>VectorDefector</h2>
                <h3>Blog</h3>                
            </div>
        </div>
    </section>
<!-- End Hero -->

<!-- Blog Start -->
<section data-scroll-index="4">

        <div class="container">
            <div class="row mt-40">
            <?php echo do_shortcode('[ajax_load_more archive="true" post_type="post" max_pages="1" posts_per_page="4" container_type="div"]'); ?>
            </div>
        </div>
    </section>
<!-- End Blog entries -->

<div class="between">
    <div class="line-between"></div>
</div>

<?php get_footer(); ?>