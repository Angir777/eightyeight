<!DOCTYPE html>
<html class="no-js" lang="<?php language_attributes(); ?>">
	<head>
		<title>
            <?php 
                if (is_front_page()) {
                    // Strona główna
                    echo bloginfo('name');
                } else {
                    // Podstrony
                    echo get_the_title(); echo ' · '; echo bloginfo('name'); 
                }
            ?>
        </title>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="format-detection" content="telephone=no">
	    <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="robots" content="index, follow">
        <meta name="googlebot" content="index, follow">
        <meta name="theme-color" content="#fff">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/icomoon/style.css">

        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/aos.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css">
	
        <?php wp_head(); ?>
    </head>
<body>
    <div class="site-wrap">
        <?php get_template_part('parts/header/header'); ?>