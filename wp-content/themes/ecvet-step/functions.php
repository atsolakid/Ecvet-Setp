<?php
/**
 * ECVET STEP One functions and definitions
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */


if ( ! function_exists( 'ecvetstep_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since ECVET STEP One 1.0
 */
function ecvetstep_setup() {
	
	global $content_width;
	/**
	 * Global content width.
	 */
	 if (!isset($content_width))
     	$content_width = 750;
				
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on ECVET STEP One, use a find and replace
	 * to change 'ecvetstep' to the name of your theme in all the template files
	 */
	// load_theme_textdomain( 'ecvetstep', get_template_directory() . '/languages' );	
	
	/**
	 * Add callback for custom TinyMCE editor stylesheets. (editor-style.css)
	 * @see http://codex.wordpress.org/Function_Reference/add_editor_style
	 */
	add_editor_style();	
	
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * Theme Options Defaults
	 */	
	require( get_template_directory() . '/inc/panel/es-theme-options-defaults.php' );	

	/**
	 * Custom Theme Options
	 */
	require( get_template_directory() . '/inc/panel/theme-options.php' );	
	
	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/es-functions.php' );	
	
	/**
	 * Metabox
	 */
	require( get_template_directory() . '/inc/es-metabox.php' );

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Register Sidebar and Widget.
	 */
	require( get_template_directory() . '/inc/es-widgets.php' );		
	
	/*
	 * This theme supports custom background color and image, and here
	 * 
	 */	
	if ( function_exists( 'get_custom_header') ) {
		//add_theme_support( 'custom-background' );
		add_theme_support( 'custom-background', array( 'wp-head-callback' => 'ecvetstep_background_callback' ) );
	} 

	/**
     * This feature enables custom-menus support for a theme.
     * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
     */		
	register_nav_menus(array(
		'primary' 	=> __( 'Primary Menu', 'ecvetstep' ),
	   	'secondary'	=> __( 'Secondary Menu', 'ecvetstep' )
	) );
	
	/**
	 * Custom Menus Functions.
	 */
	require( get_template_directory() . '/inc/es-menus.php' );	

	/**
	 * Add support for the Aside Post Formats
	 */
	// add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio') );
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio') );
	
	/**
     * This feature enables Jetpack plugin Infinite Scroll
     */		
    add_theme_support( 'infinite-scroll', array(
		'type'           => 'click',										
        'container'      => 'content',
        'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4' ),
        'footer'         => 'page'
    ) );
	
	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'slider', 1280, 350, true); //Featured Post Slider Image
	add_image_size( 'featured', 750, 290, true); //Featured Image
	add_image_size( 'small-featured', 360, 240, true); //Small Featured Image		

}
endif; // ecvetstep_setup
add_action( 'after_setup_theme', 'ecvetstep_setup' );


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

if ( ! function_exists( 'ecvetstep_background_callback' ) ) :
/**
 * Template for Custom Background
 *
 * To override this in a child theme
 * simply create your own ecvetstep_background_callback(), and that function will be used instead.
 */
function ecvetstep_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css">body { <?php echo trim( $style ); ?> }</style>
<?php
} 	
endif; // ecvetstep_background_callback
