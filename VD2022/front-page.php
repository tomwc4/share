<?php get_header();

//$homeID = 2383;
$homeID = get_option('page_on_front');
?>

<!-- Start Hero -->
    <section class="hero centered" data-scroll-index="0">
        <div class="hero-bg">
            <div class="square"></div>
            <div class="square-overlay"></div>
        </div>
        <div class="email-link title-anim">
            <a href="mailto:info@vectordefector.com?subject=Contact VectorDefector">info@vectordefector.com</a>
        </div>
        <div class="social title-anim">
            <ul>
            <li><a href="https://facebook.com/vectordefector" rel="noopener" target="_blank" aria-label="Visit on Facebook"><i class="fab fa-facebook" aria-hidden="true"></i> </a></li>
            <li><a href="https://behance.net/vectordefector" aria-label="Visit on Behance" rel="noopener" target="_blank"><i class="fab fa-behance" aria-hidden="true"></i></a></li>
            <li><a href="https://wordpress.org" aria-label="Wordpress Developer" rel="noopener" target="_blank"><i class="fab fa-wordpress" aria-hidden="true"></i></a></li>
            <li><a href="https://github.com/tomwc4/share" aria-label="Visit on Github" rel="noopener" target="_blank"><i class="fab fa-github" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <div class="container between">
            <div class="row">
                <div class="col-lg-6">
                    <div>
                        <div class="hero-title text-left">
                            <h3 class="title-anim">EST. 2004</h3>
                            <h1 class="title-anim">Masterfully Crafted Designs</h1>
                            <div class="mt-20"></div>
                            <p class="title-anim">We are a boutique digital agency based in Denver, Colorado specializing in
                                visual experiences and one-of-kind brands.</p>
                            <div class="mt-40 title-anim">
                                <a class="btn-main" href="#" data-scroll-nav="1">Read More &raquo;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <!-- Start About -->
    <section id="about" class="about parallax-scrl" data-scroll-index="1">
        <div class="right-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-lg-2">
                    <div class="about-text">
                        <div class="title text-left">
                            <h2>History &</h2>
                            <h3>Mission</h3>
                        </div>
                        <div class="about-inner mt-30">
                            <?php if(get_field('mission_statement',$homeID)):
                                the_field('mission_statement',$homeID);                            
                            endif; ?>  
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="about-img line-img">
                        <div class="about-overlay"></div>
                        <img class="img-fluid lazy" data-lazy="<?php bloginfo('template_directory');?>/assets/img/2.jpg" width="540" height="548" alt="Denver, Colorado">
                    </div>
                </div>
            </div>
        </div>

    </section>

    <div class="between">
        <div class="line-between"></div>
    </div>

    <!-- Start Service -->
    <section id="service" class="service parallax-scrl" data-scroll-index="2">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="title text-left">
                        <h2>Areas of Expertise</h2>
                        <h3>Services</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mt-30">
                    <div class="service-item bg-main">
                        <div class="service-icon text-center">
                            <img data-lazy="<?php bloginfo('template_directory');?>/assets/img/icons/service-icons-branding.svg" class="lazy" width="220" height="220" alt="Branding & Design">
                        </div>
                        <div class="service-text">
                            <h3>BRANDING &amp; DESIGN</h3>
                            <p>With 20 years of experience in illustration and graphic design, we can guide you in the process of establishing a marketing presence that truly expresses your company’s essential vibe.</p>
                            <div class="service-line"></div>
                            <ul class="service-list">
                                <li>Brand Development</li>
                                <li>UI/UX</li>
                                <li>Illustration &amp; Logo Design</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-50">
                    <div class="service-item bg-second">
                        <div class="service-icon text-center">
                            <img data-lazy="<?php bloginfo('template_directory');?>/assets/img/icons/service-icons-web-design.svg" class="lazy" width="220" height="220" alt="Web Design & Development">
                        </div>
                        <div class="service-text">
                            <h3>WEB DEVELOPMENT</h3>
                            <p>Projects we design and build are made with the intention of fusing function with style: website design that is the peak of professional plus function that is built to last, expand and evolve gracefully.</p>
                            <div class="service-line"></div>
                            <ul class="service-list">
                                <li>Website Design &amp; Development</li>
                                <li>SEO &amp; Architecture</li>
                                <li>Custom &amp; E-Commerce</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-30">
                    <div class="service-item bg-main">
                        <div class="service-icon text-center">
                            <img data-lazy="<?php bloginfo('template_directory');?>/assets/img/icons/service-icons-experience.svg" class="lazy" width="220" height="220" alt="SEO & Consulting">
                        </div>
                        <div class="service-text">
                            <h3>SEO & CONSULTING</h3>
                            <p>More than ever, the design, user experience and flow of your online presense needs to be on point. We have experience, know-how, and toolsets necessary to streamline your digital marketing. </p>
                            <div class="service-line"></div>
                            <ul class="service-list">
                                <li>IT & Hosting Resources</li>
                                <li>Web Security</li>
                                <li>Search Engine Optimization</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Service -->

    <div class="between">
        <div class="line-between"></div>
    </div>

    <!-- Project Start -->
    <section id="project" class="project-section parallax-scrl" data-scroll-index="3">
        <div class="left-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-30">
                    <div class="title">
                        <h2>Featured</h2>
                        <h3>Projects</h3>
                    </div>
                </div>
            </div>
            <div class="row mt-40">
            <?php if( have_rows('featured_projects',$homeID) ): 
                    $projectCt = 1;
                    while( have_rows('featured_projects',$homeID) ) : the_row(); 
                    
                    $projectImg = get_sub_field('cover_image',$homeID);
                    $projectID = get_sub_field('project_id',$homeID);
                    $title = get_the_title($projectID); 
                    $category = get_the_terms($projectID,'work_taxonomy'); 
                    $firstCategory = $category[0]->name;            
                    $addClass = '';   
                    if($projectCt % 2 == 0):
                        $addClass = 'mt-60-lg';
                    endif;  
                ?>
                <!-- Project <?php echo $title;?> -->
                <div class="col-md-12 col-lg-6 <?php echo $addClass;?>">
                    <a href="<?php the_permalink($projectID);?>" alt="Project: <?php echo $title;?>" title="Project: <?php echo $title;?>">
                        <div class="project-content">
                            <div class="img-project">
                                <img class="lazy" data-lazy="<?php echo $projectImg;?>" alt="<?php echo $title;?>">
                            </div>
                            <div class="detail-project">
                                <p><span class="number"><?php echo sprintf("%02d", $projectCt);?></span> <span class="strip"></span> <?php echo $firstCategory;?></p>
                                <h3 class="reveal-text"><?php echo $title;?></h3>
                            </div>
                        </div>
                    </a>
                </div>
            <?php $projectCt++;
        endwhile; endif;?>

                <div class="col-lg-12 text-center">
                    <div class="mt-20">
                        <a class="btn-main" href="/web-design-portfolio/">All Projects</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Projects -->

    <div class="between">
        <div class="line-between"></div>
    </div>

    <!-- Start Team -->
    <section id="team" class="team parallax-scrl" data-scroll-index="4">
    <div class="team-text-bg"></div>
        <div class="container">

            <div class="row">
                <div class="col-lg-6 order-lg-1 mt-10">
                    <div class="title text-left">
                        <h2>Founder & Creative Director</h2>
                        <h3>Tom Benway</h3>
                    </div>

                    <div class="about-inner mt-30">
                        <?php if(get_field('home_about',$homeID)):
                            the_field('home_about',$homeID);                            
                        endif; ?>                           
                    </div>
                </div>

                <div class="col-lg-6 order-lg-2 centered">
                    <div class="team-item text-center">
                        <div class="team-img">
                            <img class="img-fluid lazy" data-lazy="<?php bloginfo('template_directory');?>/assets/img/tom-benway.webp" width="500" height="750" alt="Founder & Creative Director: Tom Benway">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Team -->

    <div class="col-lg-12 text-center">
        <div class="mt-20">
            <a class="btn-main" href="/connect">Let's Connect &raquo;</a>
        </div>
    </div>

    <div class="between">
        <div class="line-between"></div>
    </div>

    <!-- Start News -->
    <section id="news" class="news parallax-scrl" data-scroll-index="5">
        <div class="left-bg"></div>
        <div class="about-text-bg"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mid-title">
                    <div class="title text-center">
                        <h2>Recent</h2>
                        <h3>News</h3>
                    </div>
                </div>
                <div class="news-wrap col-lg-12 mt-50">
                    <?php query_posts('orderby=date&cat=402&posts_per_page=3');?>
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <div class="col-sm-6 col-md-4 news-item">
                            <div class="news-img">
                                <a href="<?php the_permalink();?>"><img class="img-fluid lazy" data-lazy="<?php echo getCorrectFeaturedImage(get_the_id(),'medium');?>" width="340" height="340" alt="<?php the_title(); ?>"></a>
                            </div>
                            <div class="news-text">
                                <h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                <p><?php $excerpt = get_the_excerpt(); echo htmlspecialchars($excerpt);?></p> 
                            </div>
                        </div>
                        <?php endwhile; endif; ?> 
                </div>
            </div>

            <div class="col-lg-12 text-center">
                 <div class="mt-20">
                    <a class="btn-main" href="/blog">All News Entries</a>
                 </div>
            </div>

        </div>
    </section>
    <!-- End News -->

    <div class="between">
        <div class="line-between"></div>
    </div>

    <?php /*
    <!-- Start Testimonial -->
    <section id="client" class="testimonial fades" data-scroll-index="6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mid-title">
                    <div class="title text-center">
                        <h2>Testimonials &</h2>
                        <h3>Quotes</h3>
                    </div>
                </div>
                <div class="col-lg-10 offset-lg-1 mt-20 fades">
                    <div class="quot-left">
                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                    </div>
                    <div class="quot-right">
                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                    </div>
                    <div class="testimonial">
                        <div class="owl-carousel owl-theme">
                            <div class="item-testi-slide">

                                <div class="testimonial-item text-center">
                                    <p>" We have partnered with 8chDesign GmbH since 2011, when they first designed our
                                        corporate stationery. Their work ethic is very professional, reliable, and
                                        timely. 8chDesign GmbH always goes the extra mile and thus comes highly
                                        recommended. "</p>
                                    <div class="author">
                                        <p class="author-text">Nattasha, Aloka CEO</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="line-testi"></div>
        </div>
    </section>
    <!-- End Testimonial -->

    */?>

    <!-- Start Client -->
    <div class="client mid-title fades">
        <div class="container">

            <div class="partner">
                <div class="owl-carousel owl-theme">

                <?php if( have_rows('home_clients',$homeID) ):

                    $clientCt = 1;

                    while( have_rows('home_clients',$homeID) ) : the_row(); ?>

                    <div class="item-partner">
                        <div class="row">
                            <div class="col-lg-12">
                            <?php $imgField = get_sub_field('client_logo',$homeID);?>
                                <img data-src="<?php echo $imgField['url'];?>" class="owl-lazy" width="<?php echo $imgField['width'];?>" height="<?php echo $imgField['height'];?>" alt="<?php echo $imgField['title'];?>">
                            </div>
                        </div>
                    </div>

                   <?php 
                        $clientCt++;
                     endwhile;
                  endif; ?>

                </div>
            </div>
        </div>
    </div>
    <!-- End Client -->

    <div class="between">
        <div class="line-between"></div>
    </div>

    <?php get_footer(); ?>