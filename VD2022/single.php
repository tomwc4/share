<?php get_header();
$category = get_the_category(); 
$firstCategory = $category[0]->cat_name; ?>

 <!-- Start Hero -->
 <section class="hero centered" data-scroll-index="0">
        <div class="title-single-page centered mid-title">
            <div class="title text-center">
                <h3><?php echo $firstCategory;?></h3>
                <h2><?php the_title();?></h2>
                <?php /* <p class="mt-20"><?php the_tags('<b>Tagged Under:</b> ', ', ', '<br />'); ?></p> */ ?>
                <p class="mt-10"><a href="/blog">&laquo; View All Blogs</a></p>
            </div>
        </div>
    </section>
<!-- End Hero -->

<div class="blog-entry">
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

<div class="col-lg-12 text-center">
    <div class="mt-20">
    <a class="btn-main" href="/blog">All News Entries</a>
    </div>
 </div>

<div class="between">
    <div class="line-between"></div>
</div>

<?php get_footer(); ?>