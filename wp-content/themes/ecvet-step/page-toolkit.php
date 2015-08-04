<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Toolkit Template
 *
   Template Name: Toolkit
 *
 * The template for the Toolkit
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */

get_header(); ?>

<div id="primary-alone" class="content-area">
	<div id="content" class="site-content" role="main">

	<?php while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'toolkit');
	 endwhile; ?>
	  
	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>
