<?php get_header(); ?>
	
	<div id="header" style="background-image: url(<?php if(get_field('sitewide_background_image','options')) { echo get_field('sitewide_background_image','options');}?>)">
		
		
	<div id="navigation">

		<div id="navMobileMenu">
			<i class="fas fa-bars"></i>
		</div>

		<div id="nav-menu">
			<?php wp_nav_menu( array('menu' => 'Main Navigation' )); ?>
		</div>

	</div>

	<div id="logo">
			<a href="<?php bloginfo('wpurl');?>"><img src="<?php echo get_field('sitewide_logo_url','options');?>" alt="<?php wp_title(''); ?>"/></a>
		</div>	

		<h2><?php the_field('hero_title','options');?></h2>
		<h3><?php the_field('hero_tagline','options');?></h3>		
	</div>
	        
    <div class="entry">

    	<div class="container" style="text-align: center; margin: 50px auto;">	
        <h2>Error 404!</h2>
		
        <p>Sorry, The page you're looking for isn't here.</p>

        <?php //get_search_form();?>
     
        </div>  
 
	</div>
		        
    <div id="footer" style="background-image: url(<?php if(get_field('sitewide_background_image','options')) { echo get_field('sitewide_background_image','options');}?>)">

	<?php if(get_field('footer_logo','option')): ?>
		<div class="footer-logo"><img src="<?php the_field('footer_logo','option'); ?>" alt="<?php bloginfo('name');?>"></div>
	<?php endif; ?>

	<?php if(get_field('footer_text','option')): ?>
		<div class="footer-text"><?php the_field('footer_text','option'); ?></div>
	<?php endif; ?>
    </div>

	<div id="copyright">
		&copy; <?php echo date("Y");?> <?php bloginfo('name');?>. All Rights Reserved.
	</div>
	
<?php get_footer(); ?>