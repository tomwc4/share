<?php get_header();?>

 <!-- Start Hero -->
 <section class="hero centered" data-scroll-index="0">
        <div class="title-single-page centered mid-title">
            <div class="title text-center">
                <h2><?php the_title();?></h2>
            </div>
        </div>
    </section>
<!-- End Hero -->

<div class="page-entry">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-30">       
                <?php if(getCorrectFeaturedImage(get_the_id(),'large')):?>                           
                <img class="img-fluid" src="<?php echo getCorrectFeaturedImage(get_the_id(),'large');?>" alt="<?php the_title();?>">
                <?php endif;?>
                <?php the_content();?>
            </div>
        </div>
    </div>
</div>

<div class="between">
    <div class="line-between"></div>
</div>

<?php get_footer(); ?>