<!DOCTYPE html>

<html <?php language_attributes(); ?> class="css3transitions">
 
<head>

    <meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>" />

    <!-- Responsive Meta -->
    <?php if(codeless_get_mod('responsive_bool')): ?> <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5"> <?php endif; ?>

    <!-- Pingback URL -->
    <link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

	<!--[if lt IE 9]>

	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

	<![endif]-->

    <?php
    
    //Generated css from options
    include('/home/colorado420/www/www/wp-content/themes/specular/includes/register/register_styles.php'); 
    
    // Loaded all others styles and scripts.
    
    // If Codeless Framework plugin active, add tracking codes and analytics codes (plugin territory)
    if( function_exists( 'codeless_show_extra_coding_functions' ) )
        codeless_show_extra_coding_functions();

    // Loaded all others styles and scripts.
    wp_head(); 

    ?>

</head>

<!-- End of Header -->

<body  <?php body_class(); ?>>

<?php if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} ?>

<?php if(codeless_get_mod('show_search')): ?>
    <div class="search_bar"><div class="container"><?php get_search_form() ?></div></div>
<?php endif; ?>

<?php if(codeless_get_mod('extra_navigation')): ?>
    <div class="extra_navigation <?php echo esc_attr(codeless_get_mod('extra_navigation_position')) ?>">
        <a href="#" class="close"></a>
        <div class="content"><?php dynamic_sidebar( "Extra Side Navigation" ); ?></div>
    </div>
<?php endif; ?>

<?php codeless_hook_viewport_before(); ?>

<div class="viewport">

<!-- Used for boxed layout -->
<?php if(codeless_get_mod('site_layout') == 'boxed'): ?>
<!-- Boxed Layout Wrapper -->
<div class="boxed_layout">
<?php endif; ?>

    <?php codeless_hook_wrapper_before(); ?>
    
    <?php if( (int) codeless_get_post_id() != 0 && redux_post_meta('cl_redata',(int) codeless_get_post_id(), 'post_style') != 'fullscreen' ): ?>
    <div class="top_wrapper">
    <?php endif; ?>

    <?php get_template_part('includes/view/sliders_output'); ?>

<!-- .header -->