<?php
/**
 * The Footer widget areas.
 *
 * @package ECVET STEP Themes
 * @subpackage Catch_Evolution_Pro
 * @since Catch Evolution 1.0
 */
?>

<?php 
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	$themeoption_layout = $options['sidebar_layout'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();	
	
	// Post /Page /General Layout
	if ( $post) {
		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent, 'ecvetstep-sidebarlayout', true );
			$sidebaroptions = get_post_meta( $parent, 'ecvetstep-sidebar-options', true );
			
		} else {
			$layout = get_post_meta( $post->ID, 'ecvetstep-sidebarlayout', true ); 
			$sidebaroptions = get_post_meta( $post->ID, 'ecvetstep-sidebar-options', true ); 
		}
	}
	else {
		$sidebaroptions = '';
	}

	if ( $layout == 'three-columns' || ( $layout=='default' && $themeoption_layout == 'three-columns' ) || is_page_template( 'page-three-columns.php' ) || $layout == 'three-columns-sidebar' || ( $layout=='default' && $themeoption_layout == 'three-columns-sidebar' ) || is_page_template( 'page-three-columns-sidebar.php' ) ) : ?>
    
        <div id="third" class="widget-area sidebar-three-columns" role="complementary">
			<?php 
			/** 
			 * catchevolution_before_third hook
			 */
			do_action( 'ecvetstep_before_third' );         
        
			if ( is_active_sidebar( 'ecvetstep_third' ) ) :
				dynamic_sidebar( 'ecvetstep_third' ); 
			endif; 
			
			/** 
			 * catchevolution_after_third hook
			 */
			do_action( 'ecvetstep_after_third' ); ?>  
                        
        </div><!-- #sidebar-third-column .widget-area -->
    	
	<?php endif; ?>			