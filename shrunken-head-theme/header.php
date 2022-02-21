<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com/" crossorigin>        
<?php $get_theme_settings = get_option('custom_theme_options');?>
<!-- <?php showCredits();?> -->
<title><?php wp_title(''); ?></title>
<?php wp_head(); ?>
<!-- custom theme styles -->
<style type="text/css">
<?php if(get_field('site_main_color','options')) {
	echo ".mainHighlight, a { color: ".get_field('site_main_color','options')."; }"."\n";
	echo ".menu li.current-menu-item a { border-bottom: 2px solid ".get_field('site_main_color','options')."; }"."\n";
	echo ".inputBtn:hover, .ytc_link a:hover, .mc4wp-form input[type='submit']:hover { background: #feeac9; color: ".get_field('site_main_color','options')."; }"."\n";
	echo '.inputBtn, .mc4wp-form input[type="submit"] {	color: '.get_field('site_main_color','options').'; border: 2px solid '.get_field('site_main_color','options').' !important; }';
	echo "#footer_cols { background-color: ".get_field('site_main_color','options')."; }"."\n";

}?>
<?php if(get_field('site_second_color','options') != '') {
	echo "#main-cta, #home-caption, a:hover, .alt-header { color: ".get_field('site_second_color','options')." !important; }"."\n";
	echo '.inputBtn, .mc4wp-form input[type="submit"]:hover { background: '.get_field('site_second_color','options').' !important; color: #fff !important;}'."\n";
	echo ".socialBtn { background-color: ".get_field('site_second_color','options')."; }"."\n";
	echo 'hr.wp-block-separator { background-color: '.get_field('site_second_color','options').';';
}?>
</style>
</head>

<body <?php if(is_front_page()) { echo ' class="home"';}?>>