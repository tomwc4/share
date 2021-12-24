<?php 
/*
Template Name: Portfolio
*/
get_header();
$count_posts = wp_count_posts( 'work-entries' )->publish;
$categories = get_terms('work_taxonomy');
?>

 <!-- Start Hero -->
 <section class="hero centered" data-scroll-index="0">
        <div class="title-single-page centered mid-title">
            <div class="title text-center">
                <h2>Design &amp; Dev Projects</h2>
                <h3>Portfolio</h3>
                
                <div class="mt-30">
                    [ <span class="red"><?php echo $count_posts;?></span> ] Entries Listed
                </div>
            </div>
        </div>

    </section>
    <!-- End Hero -->

    <!-- Project Start -->
    <section id="project-page" class="project-section parallax-scrl" data-scroll-index="3">

        <div class="container">
            <div class="row">  

            <div class="project-sort">
                <b>Sort by: </b>
                <a class="project-filter active" data-category="all">All</a>
                <?php foreach($categories as $term):?>
                    <a class="project-filter" data-category="<?php echo $term->slug;?>"><?php echo $term->name;?></a>
                <?php endforeach;?>            
            </div>
            
            <?php echo do_shortcode('[ajax_load_more archive="true" post_type="work-entries" max_pages="3" posts_per_page="12" container_type="div"]'); ?>

            </div>
            
        </div>
    </section>
    <!-- End Projects -->

    <div class="between">
        <div class="line-between"></div>
    </div>

<?php get_footer(); ?>