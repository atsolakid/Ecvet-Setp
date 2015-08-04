<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title( '&#124;', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.min.js"></script>
	<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 
/** 
 * ecvetstep_before hook
 */
do_action( 'ecvetstep_before' ); ?>

<div id="page" class="hfeed site">

	<?php 
    /** 
     * ecvetstep_before_header hook
     */
    do_action( 'ecvetstep_before_header' ); ?>
    
	<header id="masthead" role="banner">
    
    	<?php 
		/** 
		 * ecvetstep_before_hgroup_wrap hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * ecvetstep_header_top 10
		 */
		do_action( 'ecvetstep_before_hgroup_wrap' ); ?>
        
    	<div id="hgroup-wrap" class="container">
        
       		<?php 
			/** 
			 * ecvetstep_hgroup_wrap hook
			 *
			 * HOOKED_FUNCTION_NAME PRIORITY
			 *
			 * ecvetstep_header_image 10
			 * ecvetstep_header_right 15
			 */
			do_action( 'ecvetstep_hgroup_wrap' ); ?>
            
        </div><!-- #hgroup-wrap -->
        
        <?php 
		/** 
		 * ecvetstep_after_hgroup_wrap hook
		 *
		 * HOOKED_FUNCTION_NAME PRIORITY
		 *
		 * ecvetstep_featured_overall_image 10
		 * ecvetstep_secondary_menu 20
		 * ecvetstep_breadcrumb_display 30
		 */
		do_action( 'ecvetstep_after_hgroup_wrap' ); ?>
        
	</header><!-- #masthead .site-header -->
    
	<?php 
    /** 
     * ecvetstep_after_header hook
     */
    do_action( 'ecvetstep_after_header' ); ?> 
        
	<?php 
    /** 
     * ecvetstep_before_main hook
	 *
	 * HOOKED_FUNCTION_NAME PRIORITY
	 *
	 * ecvetstep_slider_display 10
	 * ecvetstep_homepage_headline 15
     */
    do_action( 'ecvetstep_before_main' ); ?>
    
    <div id="main" class="container">
    
		<?php 
        /** 
         * ecvetstep_main hook
         *
         * HOOKED_FUNCTION_NAME PRIORITY
         *
	 	 * ecvetstep_homepage_featured_display 10
         */
        do_action( 'ecvetstep_main' ); ?>
		
		<?php 
        /** 
         * ecvetstep_content_sidebar_start hook
         *
         * HOOKED_FUNCTION_NAME PRIORITY
         *
	 	 * ecvetstep_homepage_featured_display 10
         */
        do_action( 'ecvetstep_content_sidebar_start' ); ?>        