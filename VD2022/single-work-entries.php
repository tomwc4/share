<?php get_header(); 
$category = get_the_terms(get_the_ID(),'work_taxonomy'); 
$firstCategory = $category[0]->name;
$tags = get_the_terms(get_the_ID(),'work_tags'); 
$imgArgs = array(
    'post_parent'    => get_the_id(),
    'post_type'      => 'attachment',
    'numberposts'    => -1,
    'post_status'    => 'any',
    'post_mime_type' => 'image',
    'orderby'        => 'menu_order',
    'order'           => 'ASC'
);
$getAllImgs = get_posts($imgArgs);
if(count($getAllImgs) > 1):
    foreach($getAllImgs as $imgs):
        if(stristr($imgs->post_title,'widescreen') || stristr($imgs->post_title,'header')):
            $headerImg = wp_get_attachment_image_src($imgs->ID,'full');
        endif;
    endforeach;
endif;
?>

<!-- Start Hero -->
<div class="hero centered <?php if($headerImg): echo 'single'; else: echo 'no-header'; endif;?>" data-scroll-index="0">
        <div class="hero-bg">
            <div class="square-project-detail" <?php if($headerImg): ?>style="background-image: url('<?php echo $headerImg[0];?>');"<?php endif;?>></div>
            <div class="square-overlay"></div>
        </div>
        <div class="email-link title-anim">
            <a href="mailto:info@vectordefector.com?subject=Contact VectorDefector">info@vectordefector.com</a>
        </div>
    </div>
    <!-- End Hero -->

    <!-- Project Detail Start -->
    <section class="project-main parallax-scrl">
        <div class="project-detail">
            <div class="detail-title centered">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mid-title">
                            <div class="title text-center">
                                <h2><?php echo $firstCategory;?></h2>
                                <h3><?php the_title();?></h3>
                                
                                <p class="mt-20"><b class="red">Tagged Under:</b> <?php 
                                foreach($tags as $key => $tag):
                                    $csv = '';
                                    if($key+1 < count($tags)):
                                        $csv = ', ';
                                    endif;
                                    echo '<span>'.$tag->name.$csv.'</span>';
                                endforeach;
                                ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="project-subnav">

            <?php $next_post = get_next_post();
			if (!empty($next_post)): ?> 
			<div class="subnav next">
				<a href="<?php echo get_permalink($next_post->ID); ?>" alt="Previous Entry" title="Previous Entry"><i class="fa fa-chevron-left"></i></a>
			</div>
			<?php endif; ?>

            <?php $prev_post = get_previous_post();
			if (!empty($prev_post)): ?>
			<div class="subnav prev">
				<a href="<?php echo get_permalink($prev_post->ID); ?>" alt="Next Entry" title="Next Entry"><i class="fa fa-chevron-right"></i></a>
			</div>
			<?php endif; ?>
            </div>

            <div class="project-text">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="details">
                                <h3>Project Date</h3>
                                <p><?php the_date('F, Y'); ?></p>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="details">
                                <h3>Type of project</h3>
                                <?php the_field('project-services');?>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="details">
                                <h3>Description</h3>
                                <?php the_field('project-description');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Project Detail End -->

    <div class="project-main-img fades">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">

                <div class="project-gallery">
                
                <?php if($getAllImgs):
                    if(count($getAllImgs) == 1):

                        $latestPostImgThumb = wp_get_attachment_image_src($getAllImgs[0]->ID,'medium');
		                $latestPostImgLg = wp_get_attachment_image_src($getAllImgs[0]->ID,'full');

                        echo '<a href="'.$latestPostImgLg[0].'" class="colorbox" rel="imgGrp"><img src="'.$latestPostImgThumb[0].'" class="workEntryImg img-fluid" alt="'.$imgs->post_title.'"/></a>';
                    
                    else:			
                        foreach($getAllImgs as $imgs):

                        $latestPostImgThumb = wp_get_attachment_image_src($imgs->ID,'medium');
		                $latestPostImgLg = wp_get_attachment_image_src($imgs->ID,'full');

                        if(!stristr($imgs->post_title,'feature') && !stristr($imgs->post_title,'widescreen') && !stristr($imgs->post_title,'header')):
                            echo '<a href="'.$latestPostImgLg[0].'" class="colorbox" rel="imgGrp"><img src="'.$latestPostImgThumb[0].'" class="workEntryImg img-fluid" alt="'.$imgs->post_title.'"/></a>';
                        endif;

                        endforeach;

                    endif;
                endif; ?>
                </div>

                <div class="between">
                    <div class="line-between"></div>
                </div>

                <h2>Case Study</h2>

                <?php the_content();?>

                </div>

            </div>
        </div>
    </div>

    <div class="between">
        <div class="line-between"></div>
    </div>

    <div class="col-lg-12 text-center">
        <div class="mt-20">
        <a class="btn-main" href="/web-design-portfolio/">All Work Entries</a>
        </div>
    </div>

    <div class="between">
        <div class="line-between"></div>
    </div>

<?php get_footer(); ?>