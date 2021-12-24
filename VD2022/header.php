<!doctype html>
<html lang="en-US">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head profile="http://gmpg.org/xfn/11">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php wp_title();?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css?display=swap" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
        crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com/" crossorigin>
	<?php wp_head(); ?> 
</head>

<body <?php if(is_front_page()) { echo 'class="home"';}?>>
	
    <?php if(is_home() || is_front_page()):?>
    <div id="preloader">
        <div class="loader-logo text-center">
            <img src="<?php bloginfo('template_directory');?>/assets/img/loader-star.svg" alt="Page Loading">
            <p>Loading...</p>
        </div>
    </div>
    <?php endif;?>

    <!-- Start Header -->
    <header>
        <nav>
            <div class="logo">
                <a href="/"><img src="<?php bloginfo('template_directory');?>/assets/img/vector-defector-logo.svg" width="150" height="55" alt="VectorDefector"></a>
            </div>
            <div class="toggle-btn">
                <div class="burger-menu">
                    <span class="one"></span>
                    <span class="two"></span>
                    <span class="tre"></span>
                </div>
            </div>

            <div class="bg-nav"></div>

            <div class="menu-container">
                <div class="menu">
                    <div class="data">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="links text-center text-lg-left">
                                        <ul>
                                            <li><a class="menu-link active" href="/#" data-scroll-nav="0">Home</a></li>
                                            <li><a class="menu-link" href="/#about" data-scroll-nav="1">About</a></li>
                                            <li><a class="menu-link" href="/#services" data-scroll-nav="2">Services</a></li>
                                            <li><a class="menu-link" href="/web-design-portfolio" data-scroll-nav="3">Portfolio</a></li>
                                            <li><a class="menu-link" href="/blog" data-scroll-nav="5">News</a></li>
                                            <li><a class="menu-link" href="/connect" data-scroll-nav="7">Contact</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-4 offset-lg-2 centered text-right">
                                    <div class="address-menu">
                                        <h3>LOCATION</h3>
                                        <h4>Denver, Colorado</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </header>
<!-- End Header -->
