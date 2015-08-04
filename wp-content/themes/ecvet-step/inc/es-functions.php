<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */


/**
 * Enqueue scripts and styles
 */
function ecvetstep_scripts() {
	
	//Getting Ready to load data from Theme Options Panel
	global $post, $wp_query, $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	/**
	 * Loads up main stylesheet.
	 */
	wp_enqueue_style( 'ecvetstep-style', get_stylesheet_uri() );		
	
	/**
	 * Loads up Color Scheme
	 */
	$color_scheme = $options['color_scheme'];
	if ( 'dark' == $color_scheme ) {
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/css/dark.css', array(), null );	
	}
	
	//Responsive Menu
	wp_register_script('ecvetstep-menu', get_template_directory_uri() . '/js/ecvetstep-menu.min.js', array('jquery'), '20140317', true);
	wp_register_script('ecvetstep-allmenu', get_template_directory_uri() . '/js/ecvetstep-allmenu.min.js', array('jquery'), '20140317', true);	
	
	/**
	 * Loads up Responsive stylesheet and Menu JS
	 */
	if ( empty ($options[ 'disable_responsive' ] ) ) {	
		wp_enqueue_style( 'ecvetstep-responsive', get_template_directory_uri() . '/css/responsive.css' );
		
		if ( !empty ($options ['enable_menus'] ) ) :
			wp_enqueue_script( 'ecvetstep-allmenu' );
		else :
			wp_enqueue_script( 'ecvetstep-menu' );
		endif;
		
		wp_enqueue_script( 'ecvetstep-fitvids', get_template_directory_uri() . '/js/ecvetstep.fitvids.min.js', array( 'jquery' ), '20140317', true );	
	}
	
	/**
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	/**
	 * Register JQuery circle all and JQuery set up as dependent on Jquery-cycle
	 */			
	wp_register_script( 'jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array( 'jquery' ), '20140317', true );
	
	
	if ( !empty ( $options[ 'social_custom_image' ][ 1 ] ) ) {
		wp_enqueue_script( 'ecvetstep-grey', get_template_directory_uri() . '/js/ecvetstep-grey.min.js', array( 'jquery' ), '20130114' );
	}
	
	/**
	 * Loads up ecvetstep-slider and jquery-cycle set up as dependent on ecvetstep-slider
	 */	
	$enableslider = $options[ 'enable_slider' ];	
	if ( ( $enableslider == 'enable-slider-allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'enable-slider-homepage' ) ) {	
		wp_enqueue_script( 'ecvetstep-slider', get_template_directory_uri() . '/js/ecvetstep-slider.js', array( 'jquery-cycle' ), '20140317', true );
	}	
	
	/**
	 * Browser Specific Enqueue Script
	 */		
	$ecvetstep_ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(preg_match('/(?i)msie [1-8]/',$ecvetstep_ua)) {
	 	wp_enqueue_script( 'selectivizr', get_template_directory_uri() . '/js/selectivizr.min.js', array( 'jquery' ), '20130114', false );		
		wp_enqueue_style( 'ecvetstep-iecss', get_template_directory_uri() . '/css/ie.css' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'ecvetstep_scripts' );


/**
 * Responsive Layout
 *
 * @get the data value of responsive layout from theme options
 * @display responsive meta tag 
 * @action wp_head
 */
function ecvetstep_responsive() {
	//delete_transient('ecvetstep_responsive');	
	
	if ( !$ecvetstep_responsive = get_transient( 'ecvetstep_responsive' ) ) {
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;

		if ( $options[ 'disable_responsive' ] == '0' ) {
			$ecvetstep_responsive = '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		}
		else {
			$ecvetstep_responsive = '<!-- Disable Responsive -->';
		}
		set_transient( 'ecvetstep_responsive', $ecvetstep_responsive, 86940 );										  
	}
	echo $ecvetstep_responsive;
} // ecvetstep_responsive
add_filter( 'wp_head', 'ecvetstep_responsive', 1 );


/**
 * Get the favicon Image from theme options
 *
 * @uses favicon 
 * @get the data value of image from theme options
 * @display favicon
 *
 * @uses default favicon if favicon field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function ecvetstep_favicon() {
	//delete_transient( 'ecvetstep_favicon' );	
	
	if( ( !$ecvetstep_favicon = get_transient( 'ecvetstep_favicon' ) ) ) {
		global $ecvetstep_options_settings;
   		$options = $ecvetstep_options_settings;
		
		echo '<!-- refreshing cache -->';
		if ( empty( $options[ 'remove_favicon' ] ) ) :
			// if not empty fav_icon on theme options
			if ( !empty( $options[ 'fav_icon' ] ) ) :
				$ecvetstep_favicon = '<link rel="shortcut icon" href="'.esc_url( $options[ 'fav_icon' ] ).'" type="image/x-icon" />'; 	
			else:
				// if empty fav_icon on theme options, display default fav icon
				$ecvetstep_favicon = '<link rel="shortcut icon" href="'. get_template_directory_uri() .'/images/favicon.ico" type="image/x-icon" />';
			endif;
		endif;
		
		set_transient( 'ecvetstep_favicon', $ecvetstep_favicon, 86940 );	
	}	
	echo $ecvetstep_favicon ;	
} // ecvetstep_favicon

//Load Favicon in Header Section
add_action('wp_head', 'ecvetstep_favicon');

//Load Favicon in Admin Section
add_action( 'admin_head', 'ecvetstep_favicon' );


if ( ! function_exists( 'ecvetstep_featured_image' ) ) :
/**
 * Template for Featured Header Image from theme options
 *
 * To override this in a child theme
 * simply create your own ecvetstep_featured_image(), and that function will be used instead.
 *
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_featured_image() {
	//delete_transient( 'ecvetstep_featured_image' );	
	
	// Getting Data from Theme Options Panel
	global $ecvetstep_options_settings, $ecvetstep_options_defaults;
   	$options = $ecvetstep_options_settings;
	$defaults = $ecvetstep_options_defaults;
	$enableheaderimage = $options[ 'enable_featured_header_image' ];
		
	if ( !$ecvetstep_featured_image = get_transient( 'ecvetstep_featured_image' ) ) {
		
		echo '<!-- refreshing cache -->';

		if ( !empty( $options[ 'featured_header_image' ] ) ) {
			// Header Image Link Target
			if ( !empty( $options[ 'featured_header_image_base' ] ) ) :
				$base = '_blank'; 	
			else:
				$base = '_self'; 	
			endif;
			
			// Header Image Title/Alt
			if ( !empty( $options[ 'featured_header_image_alt' ] ) ) :
				$title = $options[ 'featured_header_image_alt' ]; 	
			else:
				$title = ''; 	
			endif;
			
			// Header Image
			if ( !empty( $options[ 'featured_header_image' ] ) ) :
				$feat_image = '<img class="wp-post-image" src="'.esc_url( $options[ 'featured_header_image' ] ).'" />'; 	
			else:
				// if empty featured_header_image on theme options, display default
				$feat_image = '<img class="wp-post-image" src="'.esc_url( $defaults[ 'featured_header_image' ] ).'" />';
			endif;
			
			$ecvetstep_featured_image = '<div id="header-featured-image">';
				// Header Image Link 
				if ( !empty( $options[ 'featured_header_image_url' ] ) ) :
					$ecvetstep_featured_image .= '<a title="'.$title.'" href="'.$options[ 'featured_header_image_url' ] .'" target="'.$base.'"><img id="main-feat-img" class="wp-post-image" alt="'.$title.'" src="'.esc_url( $options[ 'featured_header_image' ] ).'" /></a>'; 	
				else:
					// if empty featured_header_image on theme options, display default
					$ecvetstep_featured_image .= '<img id="main-feat-img" class="wp-post-image" alt="'.$title.'" src="'.esc_url( $options[ 'featured_header_image' ] ).'" />';
				endif;
			$ecvetstep_featured_image .= '</div><!-- #header-featured-image -->';
		}
			
		set_transient( 'ecvetstep_featured_image', $ecvetstep_featured_image, 86940 );	
	}	
	
	echo $ecvetstep_featured_image;
	
} // ecvetstep_featured_image
endif;


if ( ! function_exists( 'ecvetstep_featured_page_post_image' ) ) :
/**
 * Template for Featured Header Image from Post and Page
 *
 * To override this in a child theme
 * simply create your own ecvetstep_featured_imaage_pagepost(), and that function will be used instead.
 *
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_featured_page_post_image() {

	global $post, $wp_query, $ecvetstep_options_settings, $ecvetstep_options_defaults;
   	$options = $ecvetstep_options_settings;
	$defaults = $ecvetstep_options_defaults; 
	$enableheaderimage =  $options[ 'enable_featured_header_image' ];
	$featured_image = $options['page_featured_image'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	//Individual Page/Post Image Setting
	$individual_featured_image = get_post_meta( $post->ID, 'ecvetstep-header-image', true ); 
	
	if ( is_home() || $individual_featured_image == 'disable' || ( $individual_featured_image == 'default' && $enableheaderimage == 'disable' ) || '' == get_the_post_thumbnail() ) {
		echo '<!-- Disable Header Image -->';
	}
	else {
		if ( $individual_featured_image == 'featured' || ( $individual_featured_image=='default' && $featured_image == 'featured' ) ) { 
			echo get_the_post_thumbnail($post->ID, 'featured', array('id' => 'main-feat-img'));
		} 
		elseif ( $individual_featured_image == 'slider' || ( $individual_featured_image=='default' && $featured_image == 'slider' ) ) {
			echo get_the_post_thumbnail($post->ID, 'slider', array('id' => 'main-feat-img'));
		}
		else { 
			echo get_the_post_thumbnail($post->ID, 'full', array('id' => 'main-feat-img'));
		}
	}		
	
} // ecvetstep_featured_page_post_image
endif;


if ( ! function_exists( 'ecvetstep_featured_overall_image' ) ) :
/**
 * Template for Featured Header Image from theme options
 *
 * To override this in a child theme
 * simply create your own ecvetstep_featured_pagepost_image(), and that function will be used instead.
 *
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_featured_overall_image() {

	global $post, $wp_query, $ecvetstep_options_settings, $ecvetstep_options_defaults;
   	$options = $ecvetstep_options_settings;
	$defaults = $ecvetstep_options_defaults; 
	$enableheaderimage =  $options[ 'enable_featured_header_image' ];
	$featured_image = $options['page_featured_image'];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if ( $enableheaderimage == 'excludehome'  ) {
		if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
			return false;
		}
		else {
			ecvetstep_featured_image();	
		}
	}
	elseif ( $enableheaderimage == 'allpage' || ( ( $enableheaderimage == 'homepage' || $enableheaderimage == 'postpage' ) && ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) ) ) {
		ecvetstep_featured_image();
	}
	elseif ( $enableheaderimage == 'postpage' ) {
		if ( is_page() || is_single() ) {
			ecvetstep_featured_page_post_image();
		}
		else {
			ecvetstep_featured_image();
		}
	}
	elseif ( $enableheaderimage == 'pagespostes' && ( is_page || is_single ) ) {
		ecvetstep_featured_page_post_image();
	}
	else {
		echo '<!-- Disable Header Image -->';
	}
	
} // ecvetstep_featured_overall_image
endif;
add_action( 'ecvetstep_after_hgroup_wrap', 'ecvetstep_featured_overall_image', 10 );


if ( ! function_exists( 'ecvetstep_content_image' ) ) :
/**
 * Template for Featured Image in Content
 *
 * To override this in a child theme
 * simply create your own ecvetstep_content_image(), and that function will be used instead.
 *
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_content_image() {
	global $post, $wp_query;
	
	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if( $post) {
 		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$individual_featured_image = get_post_meta( $parent,'ecvetstep-featured-image', true );
		} else {
			$individual_featured_image = get_post_meta( $page_id,'ecvetstep-featured-image', true ); 
		}
	}

	if( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
		$individual_featured_image='default';
	}
	
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	
	$featured_image = $options['featured_image'];
		
	if ( ( $individual_featured_image == 'disable' || '' == get_the_post_thumbnail() || ( $individual_featured_image=='default' && $featured_image == 'disable') ) ) {
		return false;
	}
	else { ?>
		<figure class="featured-image">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'ecvetstep' ), the_title_attribute( 'echo=0' ) ) ); ?>">
                <?php 
				if ( ( is_front_page() && $featured_image == 'featured' ) ||  $individual_featured_image == 'featured' || ( $individual_featured_image=='default' && $featured_image == 'featured' ) ) {
                     the_post_thumbnail( 'featured' );
                }	
				elseif ( ( is_front_page() && $featured_image == 'slider' ) || $individual_featured_image == 'slider' || ( $individual_featured_image=='default' && $featured_image == 'slider' ) ) {
					the_post_thumbnail( 'slider' );
				}
				else {
					the_post_thumbnail( 'full' );
				} ?>
			</a>
        </figure>
   	<?php
	}
}
endif; //ecvetstep_content_image


/**
 * Hooks the Custom Inline CSS to head section
 *
 * @since ECVET STEP One 1.0
 */
function ecvetstep_inline_css() {
	//delete_transient( 'ecvetstep_inline_css' );	
	
	if ( ( !$ecvetstep_inline_css = get_transient( 'ecvetstep_inline_css' ) ) ) {
		// Getting data from Theme Options
		global $ecvetstep_options_settings;
   		$options = $ecvetstep_options_settings;

		echo '<!-- refreshing cache -->' . "\n";
		if( !empty( $options[ 'custom_css' ] ) ) {
			
			$ecvetstep_inline_css	.= '<!-- '.get_bloginfo('name').' Custom CSS Styles -->' . "\n";
	        $ecvetstep_inline_css 	.= '<style type="text/css" media="screen">' . "\n";
			$ecvetstep_inline_css .=  $options['custom_css'] . "\n";
			$ecvetstep_inline_css 	.= '</style>' . "\n";
			
		}
			
	set_transient( 'ecvetstep_inline_css', $ecvetstep_inline_css, 86940 );
	}
	echo $ecvetstep_inline_css;
}
add_action('wp_head', 'ecvetstep_inline_css');


/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since ECVET STEP One 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ecvetstep_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'ecvetstep' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ecvetstep_wp_title', 10, 2 );


/**
 * Sets the post excerpt length to 30 words.
 *
 * function tied to the excerpt_length filter hook.
 * @uses filter excerpt_length
 */
function ecvetstep_excerpt_length( $length ) {
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;

	return $options[ 'excerpt_length' ];
}
add_filter( 'excerpt_length', 'ecvetstep_excerpt_length' );


/**
 * Change the defult excerpt length of 30 to whatever passed as value
 * 
 * @use excerpt(10) or excerpt (..)  if excerpt length needs only 10 or whatevere
 * @uses get_permalink, get_the_excerpt
 */
function ecvetstep_excerpt_desired( $num ) {
    $limit = $num+1;
    $excerpt = explode( ' ', get_the_excerpt(), $limit );
    array_pop( $excerpt );
    $excerpt = implode( " ",$excerpt )."<a href='" .get_permalink() ." '></a>";
    return $excerpt;
}


/**
 * Returns a "Continue Reading" link for excerpts
 */
function ecvetstep_continue_reading() {
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
    
	$more_tag_text = $options[ 'more_tag_text' ];
	return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' .  sprintf( __( '%s', 'ecvetstep' ) , $more_tag_text ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ecvetstep_continue_reading().
 *
 */
function ecvetstep_excerpt_more( $more ) {
	return ecvetstep_continue_reading();
}
add_filter( 'excerpt_more', 'ecvetstep_excerpt_more' );


/**
 * Adds Continue Reading link to post excerpts.
 *
 * function tied to the get_the_excerpt filter hook.
 */
function ecvetstep_custom_excerpt( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= ecvetstep_continue_reading();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'ecvetstep_custom_excerpt' );


/**
 * Replacing Continue Reading link to the_content more.
 *
 * function tied to the the_content_more_link filter hook.
 */
function ecvetstep_more_link( $more_link, $more_link_text ) {
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	
	$more_tag_text = $options[ 'more_tag_text' ];
	
	return str_replace( $more_link_text, $more_tag_text, $more_link );
}
add_filter( 'the_content_more_link', 'ecvetstep_more_link', 10, 2 );


/**
 * Redirect WordPress Feeds To FeedBurner
 */
function ecvetstep_rss_redirect() {	
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	
    if ($options['feed_url']) {
		$url = 'Location: '.$options['feed_url'];
		if ( is_feed() && !preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT']))
		{
			header($url);
			header('HTTP/1.1 302 Temporary Redirect');
		}
	}
}
add_action('template_redirect', 'ecvetstep_rss_redirect');


/**
 * Adds custom classes to the array of body classes.
 *
 * @since ECVET STEP One 1.0
 */
function ecvetstep_body_classes( $classes ) {
	global $post, $ecvetstep_options_settings;
	$options = $ecvetstep_options_settings;
	
	if ( is_page_template( 'page-blog.php') ) {
		$classes[] = 'page-blog';
	}
	
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	
	if ( $post) {
 		if ( is_attachment() ) { 
			$parent = $post->post_parent;
			$layout = get_post_meta( $parent, 'ecvetstep-sidebarlayout', true );
		} else {
			$layout = get_post_meta( $post->ID, 'ecvetstep-sidebarlayout', true ); 
		}
	}

	if ( empty( $layout ) || ( !is_page() && !is_single() ) ) {
		$layout='default';
	}
	
	$themeoption_layout = $options['sidebar_layout'];
	
	if( ( $layout == 'no-sidebar' || ( $layout=='default' && $themeoption_layout == 'no-sidebar') ) ) {
		$classes[] = 'no-sidebar';
	}
	elseif( ( $layout == 'left-sidebar' || ( $layout=='default' && $themeoption_layout == 'left-sidebar') ) ){
		$classes[] = 'left-sidebar';
	}
	elseif( ( $layout == 'right-sidebar' || ( $layout=='default' && $themeoption_layout == 'right-sidebar') ) ){
		$classes[] = 'right-sidebar';
	}	
	
	$current_content_layout = $options['content_layout'];
	if( $current_content_layout == 'full' ) {
		$classes[] = 'content-full';
	}
	elseif ( $current_content_layout == 'excerpt' ) {
		$classes[] = 'content-excerpt';
	}
	
	return $classes;
}
add_filter( 'body_class', 'ecvetstep_body_classes' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since ECVET STEP One 1.0
 */
function ecvetstep_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'ecvetstep_enhanced_image_navigation', 10, 2 );


/**
 * Shows Header Right Sidebar
 */
function ecvetstep_header_right() { 

	/* A sidebar in the Header Right 
	*/
	get_sidebar( 'header-right' ); 

}
add_action( 'ecvetstep_hgroup_wrap', 'ecvetstep_header_right', 15 );


/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since ECVET STEP One 1.0
 */
function ecvetstep_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'ecvetstep_page_menu_args' );


/**
 * Removes div from wp_page_menu() and replace with ul.
 *
 * @since ECVET STEP One 1.0 
 */
function ecvetstep_wp_page_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul class="'.$divclass.'">', $new_markup);
        return $new_markup; }

add_filter( 'wp_page_menu', 'ecvetstep_wp_page_menu' );


/**
 * Function to pass the slider effect parameters from php file to js file.
 */
function ecvetstep_pass_slider_value() {
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;

	$transition_effect = $options[ 'transition_effect' ];
	$transition_delay = $options[ 'transition_delay' ] * 1000;
	$transition_duration = $options[ 'transition_duration' ] * 1000;
	wp_localize_script( 
		'ecvetstep-slider',
		'js_value',
		array(
			'transition_effect' => $transition_effect,
			'transition_delay' => $transition_delay,
			'transition_duration' => $transition_duration
		)
	);
}// ecvetstep_pass_slider_value


if ( ! function_exists( 'ecvetstep_post_sliders' ) ) :
/**
 * Template for Featued Post Slider
 *
 * To override this in a child theme
 * simply create your own ecvetstep_post_sliders(), and that function will be used instead.
 *
 * @uses ecvetstep_header action to add it in the header
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_post_sliders() { 
	//delete_transient( 'ecvetstep_post_sliders' );
	
	global $post;
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;

	
	if( ( !$ecvetstep_post_sliders = get_transient( 'ecvetstep_post_sliders' ) ) && !empty( $options[ 'featured_slider' ] ) ) {
		echo '<!-- refreshing cache -->';
		
		$ecvetstep_post_sliders = '
		<div id="main-slider" class="container">
        	<section class="featured-slider">';
				$get_featured_posts = new WP_Query( array(
					'posts_per_page' => $options[ 'slider_qty' ],
					'post__in'		 => $options[ 'featured_slider' ],
					'orderby' 		 => 'post__in',
					'ignore_sticky_posts' => 1 // ignore sticky posts
				));
				$i=0; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
					$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
					$excerpt = get_the_excerpt();
					if ( $i == 1 ) { $classes = 'post postid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post postid-'.$post->ID.' hentry slides displaynone'; }
					$ecvetstep_post_sliders .= '
					<article class="'.$classes.'">
						<figure class="slider-image">
							<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">
								'. get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
							</a>	
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
								</h1>
							</header>';
							if( $excerpt !='') {
								$ecvetstep_post_sliders .= '<div class="entry-content">'. $excerpt.'</div>';
							}
							$ecvetstep_post_sliders .= '
						</div>
					</article><!-- .slides -->';				
				endwhile; wp_reset_query();
				$ecvetstep_post_sliders .= '
			</section>
        	<div id="slider-nav">
        		<a class="slide-previous">&lt;</a>
        		<a class="slide-next">&gt;</a>
        	</div>
        	<div id="controllers"></div>
  		</div><!-- #main-slider -->';
			
	set_transient( 'ecvetstep_post_sliders', $ecvetstep_post_sliders, 86940 );
	}
	echo $ecvetstep_post_sliders;	
} // ecvetstep_post_sliders	
endif;


if ( ! function_exists( 'ecvetstep_category_sliders' ) ) :
/**
 * Template for Featued Page Slider
 *
 * To override this in a child theme
 * simply create your own ecvetstep_category_sliders(), and that function will be used instead.
 *
 * @uses ecvetstep_header action to add it in the header
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_category_sliders() { 
	//delete_transient( 'ecvetstep_category_sliders' );
	
	global $post;
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;

	
	if( ( !$ecvetstep_category_sliders = get_transient( 'ecvetstep_category_sliders' ) ) && !empty( $options[ 'slider_category' ] ) ) {
		echo '<!-- refreshing cache -->';
		
		$ecvetstep_category_sliders = '
		<div id="main-slider" class="container">
        	<section class="featured-slider">';
				$get_featured_posts = new WP_Query( array(
					'posts_per_page'		=> $options[ 'slider_qty' ],
					'category__in'			=> $options[ 'slider_category' ],
					'ignore_sticky_posts' 	=> 1 // ignore sticky posts
				));
				$i=0; while ( $get_featured_posts->have_posts()) : $get_featured_posts->the_post(); $i++;
					$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
					$excerpt = get_the_excerpt();
					if ( $i == 1 ) { $classes = 'post pageid-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'post pageid-'.$post->ID.' hentry slides displaynone'; }
					$ecvetstep_category_sliders .= '
					<article class="'.$classes.'">
						<figure class="slider-image">
							<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">
								'. get_the_post_thumbnail( $post->ID, 'slider', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ), 'class'	=> 'pngfix' ) ).'
							</a>	
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Permalink to '.the_title('','',false).'" href="' . get_permalink() . '">'.the_title( '<span>','</span>', false ).'</a>
								</h1>
							</header>';
							if( $excerpt !='') {
								$ecvetstep_category_sliders .= '<div class="entry-content">'. $excerpt.'</div>';
							}
							$ecvetstep_category_sliders .= '
						</div>
					</article><!-- .slides -->';				
				endwhile; wp_reset_query();
				$ecvetstep_category_sliders .= '
			</section>
        	<div id="slider-nav">
        		<a class="slide-previous">&lt;</a>
        		<a class="slide-next">&gt;</a>
        	</div>
        	<div id="controllers"></div>
  		</div><!-- #main-slider -->';
			
	set_transient( 'ecvetstep_category_sliders', $ecvetstep_category_sliders, 86940 );
	}
	echo $ecvetstep_category_sliders;	
} // ecvetstep_category_sliders	
endif;


/**
 * Shows Default Slider Demo if there is not iteam in Featured Post Slider
 */
function ecvetstep_default_sliders() { 
	delete_transient( 'ecvetstep_default_sliders' );
	
	if ( !$ecvetstep_default_sliders = get_transient( 'ecvetstep_default_sliders' ) ) {
		echo '<!-- refreshing cache -->';	
		$ecvetstep_default_sliders = '
		<div id="main-slider" class="container">
			<section class="featured-slider">
			
				<article class="post hentry slides demo-image displayblock">
					<figure class="slider-image">
						<a title="Take the ECVET Step!" href="#">
							<img src="'. get_template_directory_uri() . '/images/fence-steps-big.jpg" class="wp-post-image" alt="Take the ECVET step" title="Take the ECVET step">
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a title="Take the ECVET step" href="#"><span>Take the ECVET step</span></a>
							</h1>
						</header>
						<div class="entry-content">
							<p>The ECVET Step is a step towards maturity.</p>
						</div>   
					</div>             
				</article><!-- .slides --> 		
				
				<article class="post hentry slides demo-image displaynone">
					<figure class="slider-image">
						<a title="Seto Ghumba" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/seto-ghumba-1280x600.jpg" class="wp-post-image" alt="Seto Ghumba" title="Seto Ghumba">
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a title="Seto Ghumba" href="#"><span>Seto Ghumba</span></a>
							</h1>
						</header>
						<div class="entry-content">
							<p>Situated western part in the outskirts of the ECVET valley, Seto Gumba also known as Druk Amitabh Mountain or White Monastery, is one of the most popular Buddhist monasteries of Nepal.</p>
						</div>   
					</div>             
				</article><!-- .slides --> 		
				
				<article class="post hentry slides demo-image displaynone">
					<figure class="slider-image">
						<a title="Nagarkot Himalayan Range" href="#">
							<img src="'. get_template_directory_uri() . '/images/demo/nagarkot-mountain-view1280x600.jpg" class="wp-post-image" alt="Nagarkot Himalayan Range" title="Nagarkot Himalayan Range">
						</a>
					</figure>
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a title="Nagarkot" href="#"><span>Nagarkot</span></a>
							</h1>
						</header>
						<div class="entry-content">
							<p>Nagarkot is renowned for its sunrise view of the Himalaya including Mount Everest as well as other snow-capped peaks of the Himalayan range of eastern Nepal.</p>
						</div>   
					</div>             
				</article><!-- .slides --> 
				
			</section>
			<div id="slider-nav">
				<a class="slide-previous">&lt;</a>
				<a class="slide-next">&gt;</a>
			</div>
			<div id="controllers"></div>
		</div><!-- #main-slider -->';
			
	set_transient( 'ecvetstep_default_sliders', $ecvetstep_default_sliders, 86940 );
	}
	echo $ecvetstep_default_sliders;	
} // ecvetstep_default_sliders	


/**
 * Shows Slider
 */
function ecvetstep_slider_display() {
	global $post, $wp_query, $ecvetstep_options_settings;;
   	$options = $ecvetstep_options_settings;

	// get data value from theme options
	$enableslider = $options[ 'enable_slider' ];
	$slidertype = $options[ 'select_slider_type' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if ( ( $enableslider == 'enable-slider-allpage' ) || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && $enableslider == 'enable-slider-homepage' ) ) :
		// This function passes the value of slider effect to js file 
		if ( function_exists( 'ecvetstep_pass_slider_value' ) ) : ecvetstep_pass_slider_value(); endif;
		// Select Slider
		if (  $slidertype == 'post-slider' && !empty( $options[ 'featured_slider' ] ) && function_exists( 'ecvetstep_post_sliders' ) ) {
			ecvetstep_post_sliders();
		}
		elseif (  $slidertype == 'category-slider' && !empty( $options[ 'slider_category' ] ) && function_exists( 'ecvetstep_category_sliders' ) ) {
			ecvetstep_category_sliders();
		}	
		else {
			ecvetstep_default_sliders();
		}
	endif;	
}
add_action( 'ecvetstep_before_main', 'ecvetstep_slider_display', 10 );


if ( ! function_exists( 'ecvetstep_homepage_headline' ) ) :
/**
 * Template for Homepage Headline
 *
 * To override this in a child theme
 * simply create your own ecvetstep_homepage_headline(), and that function will be used instead.
 *
 * @uses ecvetstep_before_main action to add it in the header
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_homepage_headline() { 
	//delete_transient( 'ecvetstep_homepage_headline' );
	
	global $post, $wp_query, $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	
	// Getting data from Theme Options
	$disable_headline = $options[ 'disable_homepage_headline' ];
	$disable_subheadline = $options[ 'disable_homepage_subheadline' ];
	$disable_button = $options[ 'disable_homepage_button' ];
	$homepage_headline = $options[ 'homepage_headline' ];
	$homepage_subheadline = $options[ 'homepage_subheadline' ];
	$homepage_headline_button = $options[ 'homepage_headline_button' ];
	$homepage_headline_url = $options[ 'homepage_headline_url' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	 if ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && ( empty( $disable_headline ) || empty( $disable_subheadline ) || empty( $disable_button ) ) ) { 	
		
		if ( !$ecvetstep_homepage_headline = get_transient( 'ecvetstep_homepage_headline' ) ) {
			
			echo '<!-- refreshing cache -->';	
			
			$ecvetstep_homepage_headline = '<div id="homepage-message" class="container"><div class="left-section">';
			
			if ( !empty ( $homepage_headline_url ) && $disable_button == "0" ) {
				$ecvetstep_homepage_headline .= '<div class="right-section"><a href="' . $homepage_headline_url . '" target="_blank">' . $homepage_headline_button . '</a></div><!-- .right-section -->';
			}

			if ( $disable_headline == "0" ) {
				$ecvetstep_homepage_headline .= '<h2>' . sprintf( __( '%s', 'ecvetstep' ) , $homepage_headline ) . '</h2>';
			}
			if ( $disable_subheadline == "0" ) {
				$ecvetstep_homepage_headline .= '<p>' . sprintf( __( '%s', 'ecvetstep' ) , $homepage_subheadline ) . '</p>';
			}			
			
			$ecvetstep_homepage_headline .= '</div><!-- .left-section -->';  

						
			$ecvetstep_homepage_headline .= '</div><!-- #homepage-message -->';
			
			set_transient( 'ecvetstep_homepage_headline', $ecvetstep_homepage_headline, 86940 );
		}
		echo $ecvetstep_homepage_headline;	
	 }
}
endif; // ecvetstep_homepage_featured_content

add_action( 'ecvetstep_before_main', 'ecvetstep_homepage_headline', 10 );

 
/**
 * Shows Default Featued Content
 *
 * @uses ecvetstep_before_main action to add it in the header
 */
function ecvetstep_default_featured_content() { 
	//delete_transient( 'ecvetstep_default_featured_content' );
	
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	$disable_homepage_featured = $options[ 'disable_homepage_featured' ];
	$headline = $options [ 'homepage_featured_headline' ];
	$layouts = $options [ 'homepage_featured_layout' ];
	
	if ( $disable_homepage_featured == "0" ) { 
		if ( !$ecvetstep_default_featured_content = get_transient( 'ecvetstep_default_featured_content' ) ) {					
			//Checking Layout 
			if ( $layouts == 'four-columns' ) {
				$classes = "layout-four";
			} 
			else { 
				$classes = "layout-three"; 
			}
			
			$ecvetstep_default_featured_content = '
			<section id="featured-post" class="' . $classes . '">
				<h1 id="feature-heading" class="entry-title">Popular Places</h1>
				<div class="featured-content-wrap">
					<article id="featured-post-1" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Spectacular Dhulikhel">
								<img title="Spectacular Dhulikhel" alt="Spectacular Dhulikhel" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/spectacular-dhulikhel-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Spectacular Dhulikhel" href="#">Spectacular Dhulikhel</a>
								</h1>
							</header>
							<div class="entry-content">
								The Mountains - A Tourist Paradise: The spectacular snowfed mountains seen from Dhuklikhel must be one of the finest panoramic views in the world.
							</div>
						</div><!-- .entry-container -->			
					</article>
	
					<article id="featured-post-2" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Swayambhunath">
								<img title="Swayambhunath" alt="Swayambhunath" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/swayambhunath-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Swayambhunath" href="#">Swayambhunath</a>
								</h1>
							</header>
							<div class="entry-content">
								Swayambhunath is an ancient religious site up in the hill around ECVET Valley. It is also known as the Monkey Temple as there are holy monkeys living in the temple. 
							</div>
						</div><!-- .entry-container -->			
					</article>
					
					<article id="featured-post-3" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Wood Art">
								<img title="Wood Art" alt="Wood Art" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/wood-art-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Wood Art" href="#">Wood Art</a>
								</h1>
							</header>
							<div class="entry-content">
								It is the traditional architecture in the ECVET valley in temples, palaces, monasteries and houses a perfected Neawri art form generally carved very artistically out of  Wood.
								
							</div>
						</div><!-- .entry-container -->			
					</article>
					
					<article id="featured-post-4" class="post hentry post-demo">
						<figure class="featured-homepage-image">
							<a href="#" title="Nepal Prayer Wheels">
								<img title="Nepal Prayer Wheels" alt="Nepal Prayer Wheels" class="wp-post-image" src="'.get_template_directory_uri() . '/images/demo/nepal-prayer-wheels-360x240.jpg" />
							</a>
						</figure>
						<div class="entry-container">
							<header class="entry-header">
								<h1 class="entry-title">
									<a title="Nepal Prayer Wheels" href="#">Nepal Prayer Wheels</a>
								</h1>
							</header>
							<div class="entry-content">
								A Prayer wheel is a cylindrical wheel on a spindle made from metal, wood, stone, leather or coarse cotton. The practitioner most often spins the wheel clockwise.
							</div>
						</div><!-- .entry-container -->			
					</article>
				</div><!-- .featured-content-wrap -->
			</section><!-- #featured-post -->';
		}
		echo $ecvetstep_default_featured_content;
	}
}


if ( ! function_exists( 'ecvetstep_homepage_featured_content' ) ) :
/**
 * Template for Homepage Featured Content
 *
 * To override this in a child theme
 * simply create your own ecvetstep_homepage_featured_content(), and that function will be used instead.
 *
 * @uses ecvetstep_before_main action to add it in the header
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_homepage_featured_content() { 
	//delete_transient( 'ecvetstep_homepage_featured_content' );
	
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	$disable_homepage_featured = $options[ 'disable_homepage_featured' ];
	$quantity = $options [ 'homepage_featured_qty' ];
	$headline = $options [ 'homepage_featured_headline' ];
	$layouts = $options [ 'homepage_featured_layout' ];
	
	if ( $disable_homepage_featured == "0" ) { 
		
		if ( !$ecvetstep_homepage_featured_content = get_transient( 'ecvetstep_homepage_featured_content' )  && ( !empty( $options[ 'homepage_featured_image' ] ) || !empty( $options[ 'homepage_featured_title' ] ) || !empty( $options[ 'homepage_featured_content' ] ) ) ) {
			
			echo '<!-- refreshing cache -->';	
			
			//Checking Layout 
			if ( $layouts == 'four-columns' ) {
				$classes = "layout-four";
			} 
			else { 
				$classes = "layout-three"; 
			}
			
			$ecvetstep_homepage_featured_content = '<section id="featured-post" class="' . $classes . '">';
			
			if ( !empty( $headline ) ) {
				$ecvetstep_homepage_featured_content .= '<h1 id="feature-heading" class="entry-title">' . sprintf( __( '%s', 'ecvetstep' ) , $headline ) . '</h1>';
			}
			
			$ecvetstep_homepage_featured_content .= '<div class="featured-content-wrap">';
			
				for ( $i = 1; $i <= $quantity; $i++ ) {
					
	
					if ( !empty ( $options[ 'homepage_featured_base' ][ $i ] ) ) {
						$target = '_blank';
					} else {
						$target = '_self';
					}
					
					//Checking Link
					if ( !empty ( $options[ 'homepage_featured_url' ][ $i ] ) ) {
						$link = $options[ 'homepage_featured_url' ][ $i ];
					} else {
						$link = '#';
					}
					
					//Checking Title
					if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) ) {
						$title = sprintf( __( '%s', 'ecvetstep' ) , $options[ 'homepage_featured_title' ][ $i ] );
					} else {
						$title = '';
					}			
					
	
					if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) || !empty ( $options[ 'homepage_featured_content' ][ $i ] ) || !empty ( $options[ 'homepage_featured_image' ][ $i ] ) ) {
						$ecvetstep_homepage_featured_content .= '
						<article id="featured-post-'.$i.'" class="post hentry">';
							if ( !empty ( $options[ 'homepage_featured_image' ][ $i ] ) ) {
								$ecvetstep_homepage_featured_content .= '
								<figure class="featured-homepage-image">
									<a title="'.$title.'" href="'.$link.'" target="'.$target.'">
										<img src="'.$options[ 'homepage_featured_image' ][ $i ].'" class="wp-post-image" alt="'.$title.'" title="'.$title.'">
									</a>
								</figure>';  
							}
							if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) || !empty ( $options[ 'homepage_featured_content' ][ $i ] ) ) {
								$ecvetstep_homepage_featured_content .= '
								<div class="entry-container">';
								
									if ( !empty ( $options[ 'homepage_featured_title' ][ $i ] ) ) { 
										$ecvetstep_homepage_featured_content .= '
										<header class="entry-header">
											<h1 class="entry-title">
												<a href="'.$link.'" title="'.$title.'" target="'.$target.'">'.$title.'</a>
											</h1>
										</header>';
									}
									if ( !empty ( $options[ 'homepage_featured_content' ][ $i ] ) ) { 
										$ecvetstep_homepage_featured_content .= '
										<div class="entry-content">
											' . sprintf( __( '%s', 'ecvetstep' ) , $options[ 'homepage_featured_content' ][ $i ] ) . '
										</div>';
									}
								$ecvetstep_homepage_featured_content .= '
								</div><!-- .entry-container -->';	
							}
						$ecvetstep_homepage_featured_content .= '			
						</article><!-- .slides -->'; 	
					}
			
				}
				
			$ecvetstep_homepage_featured_content .= '</div><!-- .featured-content-wrap -->';	
			
			$ecvetstep_homepage_featured_content .= '</section><!-- #featured-post -->';	
			
		}
		
		echo $ecvetstep_homepage_featured_content;
		
	}
 
}
endif; // ecvetstep_homepage_featured_content


/**
 * Homepage Featured Content
 *
 */
function ecvetstep_homepage_featured_display() { 
	global $post, $wp_query, $ecvetstep_options_settings;
	
	// Getting data from Theme Options
   	$options = $ecvetstep_options_settings;
	$disable_homepage_featured = $options[ 'disable_homepage_featured' ];
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	
	if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
		if  ( !empty( $options[ 'homepage_featured_image' ] ) || !empty( $options[ 'homepage_featured_title' ] ) || !empty( $options[ 'homepage_featured_content' ] ) ) {
			ecvetstep_homepage_featured_content();
		} else {
			ecvetstep_default_featured_content();
		}
	}
	
} // ecvetstep_homepage_featured_content	


if ( ! function_exists( 'ecvetstep_homepage_featured_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 */
function ecvetstep_homepage_featured_position() {
	// Getting data from Theme Options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
	$moveposition = $options[ 'move_posts_home' ];
	
	if ( empty( $moveposition ) ) { 
		add_action( 'ecvetstep_main', 'ecvetstep_homepage_featured_display', 10 );
	} else {
		add_action( 'ecvetstep_after_secondary', 'ecvetstep_homepage_featured_display', 10 );
	}
	
}
endif; // ecvetstep_homepage_featured_position
add_action( 'ecvetstep_before_main', 'ecvetstep_homepage_featured_position', 10 );


if ( ! function_exists( 'ecvetstep_content_sidebar_wrap_start' ) ) :
/**
 * Div ID content-sidebar-wrap start
 *
 */
function ecvetstep_content_sidebar_wrap_start() {
	echo '<div id="content-sidebar-wrap">';
}
endif; // ecvetstep_content_sidebar_wrap_start

add_action( 'ecvetstep_content_sidebar_start', 'ecvetstep_content_sidebar_wrap_start', 10 );


if ( ! function_exists( 'ecvetstep_content_sidebar_wrap_end' ) ) :
/**
 * Div ID content-sidebar-wrap end
 *
 */
function ecvetstep_content_sidebar_wrap_end() {
	echo '</div><!-- #content-sidebar-wrap -->';
}
endif; // ecvetstep_content_sidebar_wrap_end

add_action( 'ecvetstep_content_sidebar_end', 'ecvetstep_content_sidebar_wrap_end', 10 );


/**
 * Third Sidebar
 *
 * @Hooked in ecvetstep_content_sidebar_end
 * @since Catch Evolution 1.1
 */

function ecvetstep_third_sidebar() {
	get_sidebar( 'third' ); 
}  
add_action( 'ecvetstep_content_sidebar_end', 'ecvetstep_third_sidebar', 15 ); 



/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function ecvetstep_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-2' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;
		
	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;		

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
		case '4':
			$class = 'four';
			break;			
	}

	if ( $class )
		echo 'class="' . $class . '"';
}


if ( ! function_exists( 'ecvetstep_footer_content' ) ) :
/**
 * Template for Footer Content
 *
 * To override this in a child theme
 * simply create your own ecvetstep_footer_content(), and that function will be used instead.
 *
 * @uses ecvetstep_site_generator action to add it in the footer
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_footer_content() { 
	delete_transient( 'ecvetstep_footer_content' );	
	
	if ( ( !$ecvetstep_footer_content = get_transient( 'ecvetstep_footer_content' ) ) ) {
		echo '<!-- refreshing cache -->';
		
		// get the data value from theme options
		global $ecvetstep_options_settings;
   	 	$options = $ecvetstep_options_settings;
		
      	$ecvetstep_footer_content = '<div class="copyright"><a href="/copyright.html">Copyright &copy; 2014-2015 ECVET-STEP. Some Rights Reserved.</a><br/><br/>This project has been funded with support from the European Commission. This communication reflects the views only of the authors, and the Commission cannot be held responsible for any use which may be made of the information contained herein.</div><div class="powered"><img src="'. get_template_directory_uri() . '/images/EU_flag_LLP_EN-small.png"/></div>';

    	set_transient( 'ecvetstep_footer_content', $ecvetstep_footer_content, 86940 );
    }
	echo do_shortcode( $ecvetstep_footer_content );
}
endif;

add_action( 'ecvetstep_site_generator', 'ecvetstep_footer_content', 10 );


/**
 * Template for Badges
 *
 * @uses ecvetstep_after action to add it in the end of the page
 */
function ecvetstep_badges() { 
	delete_transient( 'ecvetstep_badges' );	
	if ( ( !$ecvetstep_badges = get_transient( 'ecvetstep_badges' ) ) ) {
		echo '<!-- refreshing cache -->';
		
		// get the data value from theme options
		global $ecvetstep_options_settings;
   	 	$options = $ecvetstep_options_settings;
		
		$ecvetstep_badges = '<div class="badges">';

		// HTML5 
		$ecvetstep_badges .= '<span class="badge"><a href="http://www.w3.org/html/logo/"><img src="' . get_template_directory_uri() . '/images/html5-badge-h-css3-device-multimedia-performance-semantics.png" width="261" height="64" alt="HTML5 Powered with CSS3 / Styling, Device Access, Multimedia, Performance &amp; Integration, and Semantics"></a></span>';

		// XHTML 1.1
		$ecvetstep_badges .= '<span class="badge"><a href="http://validator.w3.org/check?uri=referer"><img src="' . get_template_directory_uri() . '/images/valid-xhtml11-blue.png" width="88" height="31" alt="Valid XHTML 1.1" title="Valid XHTML 1.1"></a></span>';

		// wcag 2AA
		$ecvetstep_badges .= '<span class="badge"><a href="http://www.w3.org/WAI/WCAG1AA-Conformance" title="All effort has been paid for Double-A Conformance"><img src="' . get_template_directory_uri() . '/images/wcag2AA-blue.png" width="88" height="32" alt="Level Double-A conformance icon, W3C-WAI Web Content Accessibility Guidelines 1.0"></a></span>';

		$ecvetstep_badges .= '</div>';

    	set_transient( 'ecvetstep_badges', $ecvetstep_badges, 86940 );
    }
	echo do_shortcode( $ecvetstep_badges );
}
add_action( 'ecvetstep_after', 'ecvetstep_badges', 10 );



/**
 * Alter the query for the main loop in homepage
 * @uses pre_get_posts hook
 */
function ecvetstep_alter_home( $query ){
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;
		
    $cats = $options[ 'front_page_category' ];

    if ( $options[ 'exclude_slider_post'] != "0" && !empty( $options[ 'featured_slider' ] ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['post__not_in'] = $options[ 'featured_slider' ];
		}
	}
	if ( !in_array( '0', $cats ) ) {
		if( $query->is_main_query() && $query->is_home() ) {
			$query->query_vars['category__in'] = $options[ 'front_page_category' ];
		}
	}
}
add_action( 'pre_get_posts','ecvetstep_alter_home' );


if ( ! function_exists( 'ecvetstep_social_networks' ) ) :
/**
 * Template for Social Icons
 *
 * To override this in a child theme
 * simply create your own ecvetstep_social_networks(), and that function will be used instead.
 *
 * @@since ECVET STEP One 1.0
 */
function ecvetstep_social_networks() {
	//delete_transient( 'ecvetstep_social_networks' );
	
	// get the data value from theme options
	global $ecvetstep_options_settings;
   	$options = $ecvetstep_options_settings;

    $elements = array();

	$elements = array( 	$options[ 'social_facebook' ], 
						$options[ 'social_twitter' ],
						$options[ 'social_googleplus' ],
						$options[ 'social_linkedin' ],
						$options[ 'social_pinterest' ],
						$options[ 'social_youtube' ],
						$options[ 'social_vimeo' ],
						$options[ 'social_slideshare' ],
						$options[ 'social_foursquare' ],
						$options[ 'social_flickr' ],
						$options[ 'social_tumblr' ],
						$options[ 'social_deviantart' ],
						$options[ 'social_dribbble' ],
						$options[ 'social_myspace' ],
						$options[ 'social_wordpress' ],
						$options[ 'social_rss' ],
						$options[ 'social_delicious' ],
						$options[ 'social_lastfm' ],
						$options[ 'social_instagram' ],
						$options[ 'social_github' ],
						$options[ 'social_vkontakte' ],
						$options[ 'social_myworld' ],
						$options[ 'social_odnoklassniki' ],
						$options[ 'social_goodreads' ],
						$options[ 'social_skype' ],
						$options[ 'social_soundcloud' ]
					);
	$flag = 0;
	if( !empty( $elements ) ) {
		foreach( $elements as $option) {
			if( !empty( $option ) ) {
				$flag = 1;
			}
			else {
				$flag = 0;
			}
			if( $flag == 1 ) {
				break;
			}
		}
	}	
	
	if ( ( !$ecvetstep_social_networks = get_transient( 'ecvetstep_social_networks' ) ) && ( $flag == 1 || !empty ( $options[ 'social_custom_image' ] ) ) )  {
		echo '<!-- refreshing cache -->';
		
		$ecvetstep_social_networks .='
		<ul class="social-profile">';
	
			//facebook
			if ( !empty( $options[ 'social_facebook' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="facebook"><a href="'.esc_url( $options[ 'social_facebook' ] ).'" title="'.sprintf( esc_attr__( '%s on Facebook', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Facebook </a></li>';
			}
			//Twitter
			if ( !empty( $options[ 'social_twitter' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="twitter"><a href="'.esc_url( $options[ 'social_twitter' ] ).'" title="'.sprintf( esc_attr__( '%s on Twitter', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
			}
			//Google+
			if ( !empty( $options[ 'social_googleplus' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="google-plus"><a href="'.esc_url( $options[ 'social_googleplus' ] ).'" title="'.sprintf( esc_attr__( '%s on Google+', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Google+ </a></li>';
			}
			//Linkedin
			if ( !empty( $options[ 'social_linkedin' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="linkedin"><a href="'.esc_url( $options[ 'social_linkedin' ] ).'" title="'.sprintf( esc_attr__( '%s on Linkedin', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Linkedin </a></li>';
			}
			//Pinterest
			if ( !empty( $options[ 'social_pinterest' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="pinterest"><a href="'.esc_url( $options[ 'social_pinterest' ] ).'" title="'.sprintf( esc_attr__( '%s on Pinterest', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Twitter </a></li>';
			}				
			//Youtube
			if ( !empty( $options[ 'social_youtube' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="you-tube"><a href="'.esc_url( $options[ 'social_youtube' ] ).'" title="'.sprintf( esc_attr__( '%s on YouTube', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' YouTube </a></li>';
			}
			//Vimeo
			if ( !empty( $options[ 'social_vimeo' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="viemo"><a href="'.esc_url( $options[ 'social_vimeo' ] ).'" title="'.sprintf( esc_attr__( '%s on Vimeo', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Vimeo </a></li>';
			}				
			//Slideshare
			if ( !empty( $options[ 'social_slideshare' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="slideshare"><a href="'.esc_url( $options[ 'social_slideshare' ] ).'" title="'.sprintf( esc_attr__( '%s on Slideshare', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Slideshare </a></li>';
			}				
			//Foursquare
			if ( !empty( $options[ 'social_foursquare' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="foursquare"><a href="'.esc_url( $options[ 'social_foursquare' ] ).'" title="'.sprintf( esc_attr__( '%s on Foursquare', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' foursquare </a></li>';
			}
			//Flickr
			if ( !empty( $options[ 'social_flickr' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="flickr"><a href="'.esc_url( $options[ 'social_flickr' ] ).'" title="'.sprintf( esc_attr__( '%s on Flickr', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Flickr </a></li>';
			}
			//Tumblr
			if ( !empty( $options[ 'social_tumblr' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="tumblr"><a href="'.esc_url( $options[ 'social_tumblr' ] ).'" title="'.sprintf( esc_attr__( '%s on Tumblr', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Tumblr </a></li>';
			}
			//deviantART
			if ( !empty( $options[ 'social_deviantart' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="deviantart"><a href="'.esc_url( $options[ 'social_deviantart' ] ).'" title="'.sprintf( esc_attr__( '%s on deviantART', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' deviantART </a></li>';
			}
			//Dribbble
			if ( !empty( $options[ 'social_dribbble' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="dribbble"><a href="'.esc_url( $options[ 'social_dribbble' ] ).'" title="'.sprintf( esc_attr__( '%s on Dribbble', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Dribbble </a></li>';
			}
			//MySpace
			if ( !empty( $options[ 'social_myspace' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="myspace"><a href="'.esc_url( $options[ 'social_myspace' ] ).'" title="'.sprintf( esc_attr__( '%s on MySpace', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' MySpace </a></li>';
			}
			//WordPress
			if ( !empty( $options[ 'social_wordpress' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="wordpress"><a href="'.esc_url( $options[ 'social_wordpress' ] ).'" title="'.sprintf( esc_attr__( '%s on WordPress', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' WordPress </a></li>';
			}				
			//RSS
			if ( !empty( $options[ 'social_rss' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="rss"><a href="'.esc_url( $options[ 'social_rss' ] ).'" title="'.sprintf( esc_attr__( '%s on RSS', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' RSS </a></li>';
			}
			//Delicious
			if ( !empty( $options[ 'social_delicious' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="delicious"><a href="'.esc_url( $options[ 'social_delicious' ] ).'" title="'.sprintf( esc_attr__( '%s on Delicious', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Delicious </a></li>';
			}				
			//Last.fm
			if ( !empty( $options[ 'social_lastfm' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="lastfm"><a href="'.esc_url( $options[ 'social_lastfm' ] ).'" title="'.sprintf( esc_attr__( '%s on Last.fm', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Last.fm </a></li>';
			}				
			//Instagram
			if ( !empty( $options[ 'social_instagram' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="instagram"><a href="'.esc_url( $options[ 'social_instagram' ] ).'" title="'.sprintf( esc_attr__( '%s on Instagram', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' Instagram </a></li>';
			}
			//GitHub
			if ( !empty( $options[ 'social_github' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="github"><a href="'.esc_url( $options[ 'social_github' ] ).'" title="'.sprintf( esc_attr__( '%s on GitHub', 'ecvetstep' ),get_bloginfo('name') ).'" target="_blank">'.get_bloginfo( 'name' ).' GitHub </a></li>';
			}	
			//Vkontakte
			if ( !empty( $options[ 'social_vkontakte' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="vkontakte"><a href="'.esc_url( $options[ 'social_vkontakte' ] ).'" title="'.sprintf( esc_attr__( '%s on Vkontakte', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Vkontakte </a></li>';
			}				
			//My World
			if ( !empty( $options[ 'social_myworld' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="myworld"><a href="'.esc_url( $options[ 'social_myworld' ] ).'" title="'.sprintf( esc_attr__( '%s on My World', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' My World </a></li>';
			}				
			//Odnoklassniki
			if ( !empty( $options[ 'social_odnoklassniki' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="odnoklassniki"><a href="'.esc_url( $options[ 'social_odnoklassniki' ] ).'" title="'.sprintf( esc_attr__( '%s on Odnoklassniki', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Odnoklassniki </a></li>';
			}
			//Goodreads
			if ( !empty( $options[ 'social_goodreads' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="goodreads"><a href="'.esc_url( $options[ 'social_goodreads' ] ).'" title="'.sprintf( esc_attr__( '%s on Goodreads', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Goodreads </a></li>';
			}
			//Skype
			if ( !empty( $options[ 'social_skype' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="skype"><a href="'.esc_attr( $options[ 'social_skype' ] ).'" title="'.sprintf( esc_attr__( '%s on Skype', 'ecvetstep' ),get_bloginfo( 'name' ) ).'">'.get_bloginfo( 'name' ).' Skype </a></li>';
			}
			//Soundcloud
			if ( !empty( $options[ 'social_soundcloud' ] ) ) {
				$ecvetstep_social_networks .=
					'<li class="soundcloud"><a href="'.esc_url( $options[ 'social_soundcloud' ] ).'" title="'.sprintf( esc_attr__( '%s on Soundcloud', 'ecvetstep' ),get_bloginfo( 'name' ) ).'" target="_blank">'.get_bloginfo( 'name' ).' Soundcloud </a></li>';
			}
			
			$ecvetstep_social_networks .='
		</ul>';
		
		set_transient( 'ecvetstep_social_networks', $ecvetstep_social_networks, 86940 );	 
	}
	echo $ecvetstep_social_networks;
}
endif; // ecvetstep_social_networks


/**
 * Site Verification and Header Code from the Theme Option
 *
 * If user sets the code we're going to display meta verification
 * @get the data value from theme options
 * @uses wp_head action to add the code in the header
 * @uses set_transient and delete_transient API for cache
 */
function ecvetstep_webmaster() {
	//delete_transient( 'ecvetstep_webmaster' );	
	
	if ( ( !$ecvetstep_webmaster = get_transient( 'ecvetstep_webmaster' ) ) ) {

		// get the data value from theme options
		global $ecvetstep_options_settings;
   		$options = $ecvetstep_options_settings;
		echo '<!-- refreshing cache -->';	
		
		$ecvetstep_webmaster = '';
		//google
		if ( !empty( $options['google_verification'] ) ) {
			$ecvetstep_webmaster .= '<meta name="google-site-verification" content="' .  $options['google_verification'] . '" />' . "\n";
		}
		//bing
		if ( !empty( $options['bing_verification'] ) ) {
			$ecvetstep_webmaster .= '<meta name="msvalidate.01" content="' .  $options['bing_verification']  . '" />' . "\n";
		}
		//yahoo
		 if ( !empty( $options['yahoo_verification'] ) ) {
			$ecvetstep_webmaster .= '<meta name="y_key" content="' .  $options['yahoo_verification']  . '" />' . "\n";
		}
		//site stats, analytics header code
		if ( !empty( $options['analytic_header'] ) ) {
			$ecvetstep_webmaster =  $options[ 'analytic_header' ] ;
		}
			
		set_transient( 'ecvetstep_webmaster', $ecvetstep_webmaster, 86940 );
	}
	echo $ecvetstep_webmaster;
}
add_action('wp_head', 'ecvetstep_webmaster');


/**
 * This function loads the Footer Code such as Add this code from the Theme Option
 *
 * @get the data value from theme options
 * @load on the footer ONLY
 * @uses wp_footer action to add the code in the footer
 * @uses set_transient and delete_transient
 */
function ecvetstep_footercode() {
	//delete_transient( 'ecvetstep_footercode' );	
	
	if ( ( !$ecvetstep_footercode = get_transient( 'ecvetstep_footercode' ) ) ) {

		// get the data value from theme options
		global $ecvetstep_options_settings;
   		$options = $ecvetstep_options_settings;
		echo '<!-- refreshing cache -->';	
		
		//site stats, analytics header code
		if ( !empty( $options['analytic_footer'] ) ) {
			$ecvetstep_footercode =  $options[ 'analytic_footer' ] ;
		}
			
		set_transient( 'ecvetstep_footercode', $ecvetstep_footercode, 86940 );
	}
	echo $ecvetstep_footercode;
}
add_action('wp_footer', 'ecvetstep_footercode');


/**
 * Adds in post and Page ID when viewing lists of posts and pages
 * This will help the admin to add the post ID in featured slider
 * 
 * @param mixed $post_columns
 * @return post columns
 */
function ecvetstep_post_id_column( $post_columns ) {
	$beginning = array_slice( $post_columns, 0 ,1 );
	$beginning[ 'postid' ] = __( 'ID', 'ecvetstep'  );
	$ending = array_slice( $post_columns, 1 );
	$post_columns = array_merge( $beginning, $ending );
	return $post_columns;
}
add_filter( 'manage_posts_columns', 'ecvetstep_post_id_column' );

function ecvetstep_posts_id_column( $col, $val ) {
	if( $col == 'postid' ) echo $val;
}
add_action( 'manage_posts_custom_column', 'ecvetstep_posts_id_column', 10, 2 );

function ecvetstep_posts_id_column_css() {
	echo '<style type="text/css">#postid { width: 40px; }</style>';
}
add_action( 'admin_head-edit.php', 'ecvetstep_posts_id_column_css' );


if ( ! function_exists( 'ecvetstep_menu_alter' ) ) :
/**
* Add default navigation menu to nav menu
* Used while viewing on smaller screen
*/
function ecvetstep_menu_alter( $items, $args ) {
	$items .= '<li class="default-menu"><a href="' . esc_url( home_url( '/' ) ) . '" title="Menu">'.__( 'Menu', 'ecvetstep' ).'</a></li>';
	return $items;
}
endif; // ecvetstep_menu_alter
add_filter( 'wp_nav_menu_items', 'ecvetstep_menu_alter', 10, 2 );


if ( ! function_exists( 'ecvetstep_pagemenu_alter' ) ) :
/**
 * Add default navigation menu to page menu
 * Used while viewing on smaller screen
 */
function ecvetstep_pagemenu_alter( $output ) {
	$output .= '<li class="default-menu"><a href="' . esc_url( home_url( '/' ) ) . '" title="Menu">'.__( 'Menu', 'ecvetstep' ).'</a></li>';
	return $output;
}
endif; // ecvetstep_pagemenu_alter
add_filter( 'wp_list_pages', 'ecvetstep_pagemenu_alter' );


if ( ! function_exists( 'ecvetstep_pagemenu_filter' ) ) :
/**
 * @uses wp_page_menu filter hook
 */
function ecvetstep_pagemenu_filter( $text ) {
	$replace = array(
		'current_page_item'     => 'current-menu-item'
	);

	$text = str_replace( array_keys( $replace ), $replace, $text );
  	return $text;
	
}
endif; // ecvetstep_pagemenu_filter
add_filter('wp_page_menu', 'ecvetstep_pagemenu_filter');


/**
 * Shows Header Top Sidebar
 */
function ecvetstep_header_top() { 

	/* A sidebar in the Header Top 
	*/
	get_sidebar( 'header-top' ); 

}
add_action( 'ecvetstep_before_hgroup_wrap', 'ecvetstep_header_top', 10 );


/**
 * Get the Web Clip Icon Image from theme options
 *
 * @uses web_clip and remove_web_clip 
 * @get the data value of image from theme options
 * @display webclip icons
 *
 * @uses default Web Click Icon if web_clip field on theme options is empty
 *
 * @uses set_transient and delete_transient 
 */
function ecvetstep_web_clip() {
	//delete_transient( 'ecvetstep_web_clip' );	
	
	if( ( !$ecvetstep_web_clip = get_transient( 'ecvetstep_web_clip' ) ) ) {
		
		// get the data value from theme options
		global $ecvetstep_options_settings;
   		$options = $ecvetstep_options_settings;
		
		echo '<!-- refreshing cache -->';
		if ( empty( $options[ 'remove_web_clip' ] ) ) :
			// if not empty web_clip on theme options
			if ( !empty( $options[ 'web_clip' ] ) ) :
				$ecvetstep_web_clip = '<link rel="apple-touch-icon-precomposed" href="'.esc_url( $options[ 'web_clip' ] ).'" />'; 	
			else:
				// if empty web_clip on theme options, display default webclip icon
				$ecvetstep_web_clip = '<link rel="apple-touch-icon-precomposed" href="'. get_template_directory_uri() .'/images/apple-touch-icon.png" />';
			endif;
		endif;
		
		set_transient( 'ecvetstep_web_clip', $ecvetstep_web_clip, 86940 );	
	}	
	echo $ecvetstep_web_clip ;	
} // ecvetstep_web_clip

//Load webclip icon in Header Section
add_action( 'wp_head', 'ecvetstep_web_clip' );


if ( ! function_exists( 'ecvetstep_breadcrumb_display' ) ) :
/**
 * Display breadcrumb on header
 */
function ecvetstep_breadcrumb_display() {
	global $post, $wp_query;
	
	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts'); 

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
		return false;
	}
	else {
		if ( function_exists( 'bcn_display_list' ) ) {
			echo 
			'<div class="breadcrumb container">
				<ul>';
					bcn_display_list();
					echo '	
				</ul>
				<div class="row-end"></div>
			</div> <!-- .breadcrumb -->';	
		}
	}
	
} // ecvetstep_breadcrumb_display
endif;

// Load  breadcrumb in ecvetstep_after_hgroup_wrap hook
add_action( 'ecvetstep_after_hgroup_wrap', 'ecvetstep_breadcrumb_display', 30 );