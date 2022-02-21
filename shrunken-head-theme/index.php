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
			<?php /* <a href="<?php bloginfo('wpurl');?>"><img src="<?php echo get_field('sitewide_logo_url','options');?>" alt="<?php wp_title(''); ?>"/></a> */ ?>
			<img src="<?php echo get_field('sitewide_logo_url','options');?>" alt="<?php wp_title(''); ?>" width="340" height="215"/>
		</div>	

		<h2><?php the_field('hero_title','options');?></h2>
		<h3><?php the_field('hero_tagline','options');?></h3>		
	</div>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
    <div class="entry">
		
	<?php the_content(); ?>
 
	</div>
		
	<?php endwhile; endif; ?>
	
<?php get_footer(); ?>