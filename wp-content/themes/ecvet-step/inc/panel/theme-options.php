<?php
/**
 * ECVET STEP One Theme Options
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */
add_action( 'admin_init', 'ecvetstep_register_settings' );
add_action( 'admin_menu', 'ecvetstep_options_menu' );


/**
 * Enqueue admin script and styles
 *
 * @uses wp_register_script, wp_enqueue_script and wp_enqueue_style
 * @Calling jquery, jquery-ui-tabs,jquery-cookie, jquery-ui-sortable, jquery-ui-draggable, media-upload, thickbox, farbtastic, colorpicker
 */
function ecvetstep_admin_scripts() {
	//jQuery Cookie
	wp_register_script( 'jquery-cookie', get_template_directory_uri() . '/inc/panel/js/jquery.cookie.min.js', array( 'jquery' ), '1.0', true );
	
	wp_enqueue_script( 'ecvetstep_admin', get_template_directory_uri().'/inc/panel/js/admin.min.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-cookie', 'jquery-ui-sortable', 'jquery-ui-draggable' ) );
	wp_enqueue_script( 'ecvetstep_upload', get_template_directory_uri().'/inc/panel/js/add_image_scripts.js', array( 'jquery','media-upload','thickbox' ) );
	
	wp_enqueue_script( 'ecvetstep_color', get_template_directory_uri().'/inc/panel/js/color_picker.min.js', array( 'farbtastic' ) );
	
	wp_enqueue_style( 'ecvetstep_admin_style', get_template_directory_uri().'/inc/panel/admin.css', array( 'farbtastic', 'thickbox'), '1.0', 'screen' );

}
add_action('admin_print_styles-appearance_page_theme_options', 'ecvetstep_admin_scripts');


/*
 * Create a function for Theme Options Page
 *
 * @uses add_menu_page
 * @add action admin_menu 
 */
function ecvetstep_options_menu() {

	add_theme_page( 
        __( 'Theme Options', 'ecvetstep' ),           // Name of page
        __( 'Theme Options', 'ecvetstep' ),           // Label in menu
        'edit_theme_options',                           // Capability required
        'theme_options',                                // Menu slug, used to uniquely identify the page
        'ecvetstep_theme_options_do_page'             // Function that renders the options page
    );	

}


/* 
 * Admin Social Links
 * use facebook and twitter scripts
 */
function ecvetstep_admin_social() { ?>
<!-- Start Social scripts -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=276203972392824";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<!-- End Social scripts -->
<?php
}
add_action('admin_print_styles-appearance_page_theme_options','ecvetstep_admin_social');


/*
 * Register options and validation callbacks
 *
 * @uses register_setting
 * @action admin_init
 */
function ecvetstep_register_settings() {
	register_setting( 'ecvetstep_options', 'ecvetstep_options', 'ecvetstep_theme_options_validate' );
}


/*
 * Render ECVET STEP One Theme Options page
 *
 * @uses settings_fields, get_option, bloginfo
 * @Settings Updated
 */
function ecvetstep_theme_options_do_page() {
	if (!isset($_REQUEST['settings-updated']))
		$_REQUEST['settings-updated'] = false;
	?>
    
	<div id="catchthemes" class="wrap">
    	
    	<form method="post" action="options.php">
			<?php
                settings_fields( 'ecvetstep_options' );
                global $ecvetstep_options_settings;
                $options = $ecvetstep_options_settings;				
            ?>   
            <?php if (false !== $_REQUEST['settings-updated']) : ?>
            	<div class="updated fade"><p><strong><?php _e('Options Saved', 'ecvetstep'); ?></strong></p></div>
            <?php endif; ?>            
            
 
            
            <div id="ecvetstep_ad_tabs">
                <ul class="tabNavigation" id="mainNav">
                    <li><a href="#themeoptions"><?php _e( 'Theme Options', 'ecvetstep' );?></a></li>
                    <li><a href="#homepagesettings"><?php _e( 'Homepage Settings', 'ecvetstep' );?></a></li>
                    <li><a href="#slidersettings"><?php _e( 'Featured Slider', 'ecvetstep' );?></a></li>
                    <li><a href="#sociallinks"><?php _e( 'Social Links', 'ecvetstep' );?></a></li>
                    <?php if ( current_user_can( 'unfiltered_html' ) ) : ?>
                    	<li><a href="#webmaster"><?php _e( 'Tools', 'ecvetstep' );?></a></li>
                   	<?php endif; ?>
                </ul><!-- .tabsNavigation #mainNav -->
                   
                   
                <!-- Option for Design Settings -->
                <div id="themeoptions">     
                
                	<div id="responsive-design" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Responsive Design', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Responsive Design?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[disable_responsive]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[disable_responsive]" value="1" <?php checked( '1', $options['disable_responsive'] ); ?> /> <?php _e('Check to disable', 'ecvetstep'); ?>
                                </div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                        			<?php _e( 'Enable Secondary Menu in Mobile Devices?', 'ecvetstep' ); ?>
                              	</div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[enable_menus]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[enable_menus]" value="1" <?php checked( '1', $options['enable_menus'] ); ?> /> <?php _e('Check to enable', 'ecvetstep'); ?>
                              	</div>
                           	</div><!-- .row -->                            
                            <div class="row">
                      			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content --> 
                    </div><!-- .option-container --> 
                       
                  	<div id="fav-icons" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Favicon', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Favicon?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[remove_favicon]'>
                                    <input type="checkbox" id="favicon" name="ecvetstep_options[remove_favicon]" value="1" <?php checked( '1', $options['remove_favicon'] ); ?> /> <?php _e('Check to disable', 'ecvetstep'); ?>
                                </div>
                          	</div><!-- .row -->
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Fav Icon URL:', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<?php if ( !empty ( $options[ 'fav_icon' ] ) ) { ?>
                                        <input class="upload-url" size="65" type="text" name="ecvetstep_options[fav_icon]" value="<?php echo esc_url( $options [ 'fav_icon' ] ); ?>" /> <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Change Fav Icon','ecvetstep' );?>" />
                                    <?php } else { ?>
                                        <input class="upload-url" size="65" type="text" name="ecvetstep_options[fav_icon]" value="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" alt="fav" /> <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Upload Fav Icon','ecvetstep' );?>" />
                                    <?php }  ?> 
                                </div>
                          	</div><!-- .row -->                            
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Preview', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">                        
                        			<?php 
										if ( !empty( $options[ 'fav_icon' ] ) ) { 
											echo '<img src="'.esc_url( $options[ 'fav_icon' ] ).'" alt="fav" />';
										} else {
											echo '<img src="'. get_template_directory_uri().'/images/favicon.ico" alt="fav" />';
										}
									?>
                              	</div>
                            </div><!-- .row -->
                            <div class="row">
                      			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                          	</div><!-- .row -->      
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                              
                    <div id="webclip-icon" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Web Clip Icon Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Web Clip Icon?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                        			<input type='hidden' value='0' name='ecvetstep_options[remove_web_clip]'>
                        			<input type="checkbox" id="favicon" name="ecvetstep_options[remove_web_clip]" value="1" <?php checked( '1', $options['remove_web_clip'] ); ?> /> <?php _e('Check to disable', 'ecvetstep'); ?>
                              	</div>
                         	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Web Clip Icon URL:', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                        			<?php if ( !empty ( $options[ 'web_clip' ] ) ) { ?>
                                        <input class="upload-url" size="65" type="text" name="ecvetstep_options[web_clip]" value="<?php echo esc_url( $options [ 'web_clip' ] ); ?>" class="upload" />
                                    <?php } else { ?>
                                        <input size="65" type="text" name="ecvetstep_options[web_clip]" value="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png" alt="fav" />
                                    <?php }  ?> 
                                    <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Change Web Clip Icon','ecvetstep' );?>" />
                              	</div>
                         	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Preview', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">    
									<?php 
									if ( !empty( $options[ 'web_clip' ] ) ) { 
										echo '<img src="'.esc_url( $options[ 'web_clip' ] ).'" alt="Web Clip Icon" />';
									} else {
										echo '<img src="'. get_template_directory_uri().'/images/apple-touch-icon.png" alt="Web Clip Icon" />';
									}
									?>
                              	</div>
                         	</div><!-- .row -->
                            <div class="row">
                             	<?php esc_attr_e( 'Note: Web Clip Icon for Apple devices. Recommended Size - Width 144px and Height 144px height, which will support High Resolution Devices like iPad Retina.', 'ecvetstep' ); ?>
                           	</div><!-- .row -->
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->                    
                                        
                    <div id="header-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Header Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Custom Header: Logo & Site Details', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<a class="button" href="<?php echo admin_url('themes.php?page=custom-header'); ?>"><?php _e('Click Here to Add/Replace Header Logo & Site Details', 'ecvetstep'); ?></a>
                           		</div>
                         	</div><!-- .row -->         
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Header Right Sidebar?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[disable_header_right_sidebar]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[disable_header_right_sidebar]" value="1" <?php checked( '1', $options['disable_header_right_sidebar'] ); ?> /> <?php _e('Check to Disable', 'catchthemes'); ?>
                           		</div>
                         	</div><!-- .row -->                              
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Header Right Sidebar', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<a class="button" href="<?php echo esc_url( admin_url( 'widgets.php' ) ) ; ?>" title="<?php esc_attr_e( 'Widgets', 'ecvetstep' ); ?>"><?php _e( 'Click Here to Add/Replace Widgets', 'ecvetstep' );?></a>
                           		</div>
                         	</div><!-- .row -->
                          	<div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                           	</div><!-- .row -->  
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                                       
                    <div id="header-featured-image" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Header Featured Image Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Enable Featured Header Image', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">
                                	<label title="enable-header-homepage">
                                    <input type="radio" name="ecvetstep_options[enable_featured_header_image]" id="enable-header-homepage" <?php checked($options['enable_featured_header_image'], 'homepage'); ?> value="homepage"  />
                                    <?php _e( 'Homepage', 'ecvetstep' ); ?>
                                    </label>
                                    
                                    <label title="enable-header-homepage">
                                    <input type="radio" name="ecvetstep_options[enable_featured_header_image]" id="enable-header-exclude-homepage" <?php checked($options['enable_featured_header_image'], 'excludehome'); ?> value="excludehome"  />
                                    <?php _e( 'Excluding Homepage', 'ecvetstep' ); ?>
                                    </label>                                            
          
                                    <label title="enable-header-allpage">
                                    <input type="radio" name="ecvetstep_options[enable_featured_header_image]" id="enable-header-allpage" <?php checked($options['enable_featured_header_image'], 'allpage'); ?> value="allpage"  />
                                     <?php _e( 'Entire Site', 'ecvetstep' ); ?>
                                    </label>
                                    
                                    <label title="enable-header-postpage">
                                    <input type="radio" name="ecvetstep_options[enable_featured_header_image]" id="enable-header-postpage" <?php checked($options['enable_featured_header_image'], 'postpage'); ?> value="postpage"  />
                                     <?php _e( 'Entire Site, Page/Post Featured Image', 'ecvetstep' ); ?>
                                    </label> 
                                    
                                    <label title="enable-header-pagespostes">
                                    <input type="radio" name="ecvetstep_options[enable_featured_header_image]" id="enable-header-pagespostes" <?php checked($options['enable_featured_header_image'], 'pagespostes'); ?> value="pagespostes"  />
                                     <?php _e( 'Pages & Posts', 'ecvetstep' ); ?>
                                    </label> 
                                    
                                    <label title="disable-header">
                                    <input type="radio" name="ecvetstep_options[enable_featured_header_image]" id="disable-header" <?php checked($options['enable_featured_header_image'], 'disable'); ?> value="disable" />
                                     <?php _e( 'Disable', 'ecvetstep' ); ?>
                                    </label> 
                                </div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Page/Post Featured Image Size', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">
                                	<label title="featured-image"><input type="radio" name="ecvetstep_options[page_featured_image]" id="image-full" <?php checked($options['page_featured_image'], 'full'); ?> value="full"  />
									<?php _e( 'Full Image', 'ecvetstep' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="ecvetstep_options[page_featured_image]" id="content-image-slider" <?php checked($options['page_featured_image'], 'slider'); ?> value="slider"  />
                                    <?php _e( 'Slider Image', 'ecvetstep' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="ecvetstep_options[page_featured_image]" id="image-featured" <?php checked($options['page_featured_image'], 'featured'); ?> value="featured"  />
                                    <?php _e( 'Featured Image', 'ecvetstep' ); ?>
                                    </label>
                            	</div>
                          	</div><!-- .row -->                        
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Featured Header Image URL', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input class="upload-url" size="65" type="text" name="ecvetstep_options[featured_header_image]" value="<?php echo esc_url( $options [ 'featured_header_image' ] ); ?>" /> <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php esc_attr_e( 'Change Image','ecvetstep' );?>" />
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Featured Header Image Alt/Title Tag', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input class="upload-url" size="65" type="text" name="ecvetstep_options[featured_header_image_alt]" value="<?php echo esc_attr( $options [ 'featured_header_image_alt' ] ); ?>" />
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Featured Header Image Link URL', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type="text" size="65" name="ecvetstep_options[featured_header_image_url]" value="<?php echo esc_url( $options [ 'featured_header_image_url' ] ); ?>" />
                              	</div>
                          	</div><!-- .row -->                            
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Target. Open Link in New Window?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type="hidden" value="0" name="ecvetstep_options[featured_header_image_base]"> 
                                    <input type="checkbox" id="header-image-base" name="ecvetstep_options[featured_header_image_base]" value="1" <?php checked( '1', $options['featured_header_image_base'] ); ?> /> <?php _e('Check to open in new window', 'catchthemes'); ?>
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">
                            	<div class="col col-1">
                                	<?php if( $options[ 'reset_featured_image' ] == "1" ) { $options[ 'reset_featured_image' ] = "0"; } ?>
                                	<?php _e( 'Reset Header Featured Image Options?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type='hidden' value='0' name='ecvetstep_options[reset_featured_image]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[reset_featured_image]" value="1" <?php checked( '1', $options['reset_featured_image'] ); ?> /> <?php _e('Check to reset', 'ecvetstep'); ?>
                              	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row --> 
						</div><!-- .option-content --> 
                 	</div><!-- .option-container -->    
                    
                    <div id="content-featured-image" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Content Featured Image Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Content Featured Image Size', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">
                                    <label title="featured-image"><input type="radio" name="ecvetstep_options[featured_image]" id="image-featured" <?php checked($options['featured_image'], 'featured'); ?> value="featured"  />
                                    <?php _e( 'Featured Image', 'ecvetstep' ); ?>
                                    </label>  
                                    
                                    <label title="featured-image"><input type="radio" name="ecvetstep_options[featured_image]" id="image-full" <?php checked($options['featured_image'], 'full'); ?> value="full"  />
                                    <?php _e( 'Full Image', 'ecvetstep' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="ecvetstep_options[featured_image]" id="content-image-slider" <?php checked($options['featured_image'], 'slider'); ?> value="slider"  />
                                    <?php _e( 'Slider Image', 'ecvetstep' ); ?>
                                    </label>   
                                    
                                    <label title="featured-image"><input type="radio" name="ecvetstep_options[featured_image]" id="disable-image-slider" <?php checked($options['featured_image'], 'disable'); ?> value="disable"  />
                                    <?php _e( 'Disable Image', 'ecvetstep' ); ?>
                                   	</label>
                               	</div>
                            </div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->   
                  
					<div id="layout-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Layout Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Sidebar Layout Options', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">
                                    <label title="right-sidebar" class="box first"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/right-sidebar.png" alt="Right Sidebar" /><br />
                                    <input type="radio" name="ecvetstep_options[sidebar_layout]" id="right-sidebar" <?php checked($options['sidebar_layout'], 'right-sidebar'); ?> value="right-sidebar"  />
                                    <?php _e( 'Right Sidebar', 'ecvetstep' ); ?>
                                    </label>  
                                    
                                    <label title="left-Sidebar" class="box"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/left-sidebar.png" alt="Left Sidebar" /><br />
                                    <input type="radio" name="ecvetstep_options[sidebar_layout]" id="left-sidebar" <?php checked($options['sidebar_layout'], 'left-sidebar'); ?> value="left-sidebar"  />
                                    <?php _e( 'Left Sidebar', 'ecvetstep' ); ?>
                                    </label>   
                                    
                                    <label title="no-sidebar" class="box"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/no-sidebar.png" alt="No Sidebar" /><br />
                                    <input type="radio" name="ecvetstep_options[sidebar_layout]" id="no-sidebar" <?php checked($options['sidebar_layout'], 'no-sidebar'); ?> value="no-sidebar"  />
                                    <?php _e( 'No Sidebar', 'ecvetstep' ); ?>
                                    </label>
                              	</div>
                            </div><!-- .row -->                                             
                         	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Content Layout', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">                                                                                                         
                                    <label title="content-full"><input type="radio" name="ecvetstep_options[content_layout]" id="content-full" <?php checked($options['content_layout'], 'full'); ?> value="full"  />
                                    <?php _e( 'Full Content Display', 'ecvetstep' ); ?>
                                    </label>   
                                    
                                    <label title="content-excerpt"><input type="radio" name="ecvetstep_options[content_layout]" id="content-excerpt" <?php checked($options['content_layout'], 'excerpt'); ?> value="excerpt"  />
                                    <?php _e( 'Excerpt/Blog Display', 'ecvetstep' ); ?>
                                    </label>                                    
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                            	<div class="col col-header">
                                	<?php if( $options[ 'reset_layout' ] == "1" ) { $options[ 'reset_layout' ] = "0"; } ?>
                                	<?php _e( 'Reset Layout?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-options">         
                                	<input type='hidden' value='0' name='ecvetstep_options[reset_layout]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[reset_layout]" value="1" <?php checked( '1', $options['reset_layout'] ); ?> /> <?php _e('Check to reset', 'ecvetstep'); ?>
                              	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->                             
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->                                               
                                        
                    <div id="color-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Color Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-header">
                        			<?php _e( 'Default Color Scheme', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">
                                    <label title="color-light" class="box first"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/light.png" alt="color-light" /><br />
                                    <input type="radio" name="ecvetstep_options[color_scheme]" id="color-light" <?php checked($options['color_scheme'], 'light'); ?> value="light"  />
                                    <?php _e( 'Light', 'ecvetstep' ); ?>
                                    </label>
                                    <label title="color-dark" class="box"><img src="<?php echo get_template_directory_uri(); ?>/inc/panel/images/dark.png" alt="color-dark" /><br />
                                    <input type="radio" name="ecvetstep_options[color_scheme]" id="color-dark" <?php checked($options['color_scheme'], 'dark'); ?> value="dark"  />
                                    <?php _e( 'Dark', 'ecvetstep' ); ?>
                                    </label>    
                              	</div>
                          	</div><!-- .row -->   
                            <div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Custom Background Color:', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">                           
									<a class="button" href="<?php echo admin_url('themes.php?page=custom-background'); ?>">
										<?php _e( 'Click Here to change Background Color/Image', 'ecvetstep' ); ?>
                                    </a>
                             	</div>
                          	</div><!-- .row -->                                  
                          	<div class="row">
                           		<div class="col col-1">
                                	 <?php _e( 'Custom Header: ', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">                           
									<a class="button" href="<?php echo admin_url('themes.php?page=custom-header'); ?>">
										<?php _e( 'Click Here to change Site Title and Tagline Color', 'ecvetstep' ); ?>
                                    </a>
                              	</div>
                          	</div><!-- .row -->                                                                                                                                   
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->                          
                    	</div><!-- .option-content -->
                 	</div><!-- .option-container -->                                      
 
                    <div id="search-settings" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Search Text Settings', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Default Display Text in Search', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<input type="text" size="45" name="ecvetstep_options[search_display_text]" value="<?php echo esc_attr( $options[ 'search_display_text'] ); ?>" />
                             	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                                        
                    <div id="excerpt-more-tag" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Excerpt / More Tag Settings', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                       		<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'More Tag Text', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<input type="text" size="45" name="ecvetstep_options[more_tag_text]" value="<?php echo esc_attr( $options[ 'more_tag_text' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Excerpt length(words)', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<input type="text" size="3" name="ecvetstep_options[excerpt_length]" value="<?php echo intval( $options[ 'excerpt_length' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->                           
                            <div class="row">
                            	<div class="col col-1">
                                	<?php if( $options[ 'reset_moretag' ] == "1" ) { $options[ 'reset_moretag' ] = "0"; } ?>
                                	<?php _e( 'Reset Excerpt?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">         
                                	<input type='hidden' value='0' name='ecvetstep_options[reset_moretag]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[reset_moretag]" value="1" <?php checked( '1', $options['reset_moretag'] ); ?> /> <?php _e('Check to reset', 'ecvetstep'); ?>
                              	</div>
                          	</div><!-- .row -->                                                         
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                    
                    <div id="feed-redirect" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Feed Redirect', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Feed Redirect URL', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">  
                                	<input type="text" size="70" name="ecvetstep_options[feed_url]" value="<?php echo esc_attr( $options[ 'feed_url' ] ); ?>" /> <?php _e( 'Add in the Feedburner URL', 'ecvetstep' ); ?>
                             	</div>
                          	</div><!-- .row --> 
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                    
                    <div id="custom-css" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Custom CSS', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside"> 
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Enter your custom CSS styles.', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2"> 
                                	<textarea name="ecvetstep_options[custom_css]" id="custom-css" cols="80" rows="10"><?php echo esc_attr( $options[ 'custom_css' ] ); ?></textarea>
                            	</div>
                          	</div><!-- .row --> 
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'CSS Tutorial from W3Schools.', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2"> 
                                	<a class="button" href="<?php echo esc_url( __( 'http://www.w3schools.com/css/default.asp','ecvetstep' ) ); ?>" title="<?php esc_attr_e( 'CSS Tutorial', 'ecvetstep' ); ?>" target="_blank"><?php _e( 'Click Here to Read', 'ecvetstep' );?></a>
                            	</div>
                          	</div><!-- .row -->                            
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                                       
                </div><!-- #themeoptions -->  

				<!-- Options for Homepage Settings -->
                <div id="homepagesettings">                    
                
                    <div is="homepage-headline-options" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Homepage Headline Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Homepage Headline Text', 'ecvetstep' ); ?>
                                    <p><small><?php _e( 'The appropriate length for Headine is around 10 words.', 'ecvetstep' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<textarea class="textarea input-bg" name="ecvetstep_options[homepage_headline]" cols="70" rows="3"><?php echo esc_textarea( $options[ 'homepage_headline' ] ); ?></textarea>
                             	</div>
                          	</div><!-- .row -->        
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Homepage Subheadline Headline', 'ecvetstep' ); ?>
                                    <p><small><?php _e( 'The appropriate length for Headine is around 15 words.', 'ecvetstep' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<textarea class="textarea input-bg" name="ecvetstep_options[homepage_subheadline]" cols="70" rows="3"><?php echo esc_textarea( $options[ 'homepage_subheadline' ] ); ?></textarea>
                             	</div>
                          	</div><!-- .row -->                                
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Homepage Headline Button Text', 'ecvetstep' ); ?>
                                    <p><small><?php _e( 'The appropriate length for Headine is around 3 words.', 'ecvetstep' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<input type="text" size="45" name="ecvetstep_options[homepage_headline_button]" value="<?php echo esc_attr( $options[ 'homepage_headline_button' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Headine Link', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" size="70" name="ecvetstep_options[homepage_headline_url]" value="<?php echo esc_url( $options[ 'homepage_headline_url' ] ); ?>" />
                             	</div>
                          	</div><!-- .row -->                            
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Homepage Headline?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[disable_homepage_headline]'>
                                    <input type="checkbox" id="homepage-headline" name="ecvetstep_options[disable_homepage_headline]" value="1" <?php checked( '1', $options['disable_homepage_headline'] ); ?> /> <?php _e( 'Check to disable', 'ecvetstep'); ?>
                             	</div>
                          	</div><!-- .row -->                   
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Homepage Subheadline?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[disable_homepage_subheadline]'>
                                    <input type="checkbox" id="homepage-subheadline" name="ecvetstep_options[disable_homepage_subheadline]" value="1" <?php checked( '1', $options['disable_homepage_subheadline'] ); ?> /> <?php _e( 'Check to disable', 'ecvetstep'); ?>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Homepage Button?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[disable_homepage_button]'>
                                    <input type="checkbox" id="homepage-botton" name="ecvetstep_options[disable_homepage_button]" value="1" <?php checked( '1', $options['disable_homepage_button'] ); ?> /> <?php _e( 'Check to disable', 'ecvetstep'); ?>
                             	</div>
                          	</div><!-- .row -->                                             
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->   
                    
                    <div is="homepage-featured-content" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Homepage Featured Content Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Disable Homepage Featured Content?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[disable_homepage_featured]'>
                                    <input type="checkbox" id="favicon" name="ecvetstep_options[disable_homepage_featured]" value="1" <?php checked( '1', $options['disable_homepage_featured'] ); ?> /> <?php _e( 'Check to disable', 'ecvetstep'); ?>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Headline', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" size="65" name="ecvetstep_options[homepage_featured_headline]" value="<?php echo esc_attr( $options[ 'homepage_featured_headline' ] ); ?>" /> <?php _e( 'Leave empty if you want to remove headline', 'ecvetstep' ); ?>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Number of Featured Content', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" size="2" name="ecvetstep_options[homepage_featured_qty]" value="<?php echo intval( $options[ 'homepage_featured_qty' ] ); ?>" size="2" />
                             	</div>
                          	</div><!-- .row -->
                            <div class="row">                            
                            	<div class="col col-header">
                        			<?php _e( 'Featured Content Layout', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">  
                                	<label title="three-columns" class="box first">
                                    <input type="radio" name="ecvetstep_options[homepage_featured_layout]" id="three-columns" <?php checked($options['homepage_featured_layout'], 'three-columns'); ?> value="three-columns"  />
                                    <?php _e( '3 Columns', 'ecvetstep' ); ?>
                                    </label>
                                    
                                    <label title="four-columns" class="box">
                                    <input type="radio" name="ecvetstep_options[homepage_featured_layout]" id="four-columns" <?php checked($options['homepage_featured_layout'], 'four-columns'); ?> value="four-columns"  />
                                    <?php _e( '4 Columns', 'ecvetstep' ); ?>
                                    </label>	                        
           						
                                </div>
                          	</div><!-- .row -->
                           
							<?php for ( $i = 1; $i <= $options[ 'homepage_featured_qty' ]; $i++ ): ?> 
                                <div class="repeat-content-wrap">
                                    <h2 class="title"><?php printf( esc_attr__( 'Featured Content #%s', 'ecvetstep' ), $i ); ?></h2>
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Image', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input class="upload-url" size="70" type="text" name="ecvetstep_options[homepage_featured_image][<?php echo $i; ?>]" value="<?php if( array_key_exists( 'homepage_featured_image', $options ) && array_key_exists( $i, $options[ 'homepage_featured_image' ] ) ) echo esc_url( $options[ 'homepage_featured_image' ][ $i ] ); ?>" />
                                            <input id="st_upload_button" class="st_upload_button button" name="wsl-image-add" type="button" value="<?php if( array_key_exists( 'homepage_featured_image', $options ) && array_key_exists( $i, $options[ 'homepage_featured_image' ] ) ) { esc_attr_e( 'Change Image','ecvetstep' ); } else { esc_attr_e( 'Add Image','ecvetstep' ); } ?>" />
                                        </div>
                                    </div><!-- .row -->
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Link URL', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type="text" size="70" name="ecvetstep_options[homepage_featured_url][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'homepage_featured_url', $options ) && array_key_exists( $i, $options[ 'homepage_featured_url' ] ) ) echo esc_url( $options[ 'homepage_featured_url' ][ $i ] ); ?>" /> <?php _e( 'Add in the Target URL for the content', 'ecvetstep' ); ?>
                                        </div>
                                    </div><!-- .row -->                                   
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Target. Open Link in New Window?', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type='hidden' value='0' name='ecvetstep_options[homepage_featured_base][<?php echo absint( $i ); ?>]'>
                                            <input type="checkbox" name="ecvetstep_options[homepage_featured_base][<?php echo absint( $i ); ?>]" value="1" <?php if( array_key_exists( 'homepage_featured_base', $options ) && array_key_exists( $i, $options[ 'homepage_featured_base' ] ) ) checked( '1', $options[ 'homepage_featured_base' ][ $i ] ); ?> /> <?php _e( 'Check to open in new window', 'ecvetstep' ); ?>
                                        </div>
                                    </div><!-- .row -->                
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Title', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type="text" size="70" name="ecvetstep_options[homepage_featured_title][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'homepage_featured_title', $options ) && array_key_exists( $i, $options[ 'homepage_featured_title' ] ) ) echo esc_attr( $options[ 'homepage_featured_title' ][ $i ] ); ?>" /> <?php _e( 'Leave empty if you want to remove title', 'ecvetstep' ); ?>
                                        </div>
                                    </div><!-- .row -->                                  
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Content', 'ecvetstep' ); ?>
                                             <p><small><?php _e( 'The appropriate length for Content is around 10 words.', 'ecvetstep' ); ?></small></p>
                                        </div>
                                        <div class="col col-2">
                                            <textarea class="textarea input-bg" name="ecvetstep_options[homepage_featured_content][<?php echo absint( $i ); ?>]" cols="70" rows="3"><?php if( array_key_exists( 'homepage_featured_content', $options ) && array_key_exists( $i, $options[ 'homepage_featured_content' ] ) ) echo esc_html( $options[ 'homepage_featured_content' ][ $i ] ); ?></textarea>
                                        </div>
                                    </div><!-- .row --> 
                                </div><!-- .repeat-content-wrap -->                           
                            <?php endfor; ?>    
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'catchthemes' ); ?>" />
                          	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->                                     
                
                    <div id="homepage-settings" class="option-container">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Homepage / Frontpage Settings', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Enable Latest Posts?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[enable_posts_home]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[enable_posts_home]" value="1" <?php checked( '1', $options['enable_posts_home'] ); ?> /> <?php _e( 'Check to Enable', 'ecvetstep'); ?>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Add Page instead of Latest Posts', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<a class="button" href="<?php echo esc_url( admin_url( 'options-reading.php' ) ) ; ?>" title="<?php esc_attr_e( 'Click Here to Set Static Front Page Instead of Latest Posts', 'ecvetstep' ); ?>" target="_blank"><?php _e( 'Click Here to Set Static Front Page Instead of Latest Posts', 'ecvetstep' );?></a>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Homepage posts categories:', 'ecvetstep' ); ?>
                                    <p><small><?php _e( 'Only posts that belong to the categories selected here will be displayed on the front page.', 'ecvetstep' ); ?></small></p>
                                </div>
                                <div class="col col-2">
                                	<select name="ecvetstep_options[front_page_category][]" id="frontpage_posts_cats" multiple="multiple" class="select-multiple">
                                        <option value="0" <?php if ( empty( $options['front_page_category'] ) ) { echo 'selected="selected"'; } ?>><?php _e( '--Disabled--', 'ecvetstep' ); ?></option>
                                        <?php /* Get the list of categories */  
                                            $categories = get_categories();
                                            if( empty( $options[ 'front_page_category' ] ) ) {
                                                $options[ 'front_page_category' ] = array();
                                            }
                                            foreach ( $categories as $category) :
                                        ?>
                                        <option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $options['front_page_category'] ) ) {echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
                                        <?php endforeach; ?>
                                    </select><br />
                                    <span class="description"><?php _e( 'You may select multiple categories by holding down the CTRL key.', 'ecvetstep' ); ?></span>
                             	</div>
                          	</div><!-- .row -->                            
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Move above Homepage Featured Content?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[move_posts_home]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[move_posts_home]" value="1" <?php checked( '1', $options['move_posts_home'] ); ?> /> <?php _e( 'Check to Move', 'ecvetstep'); ?>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                            </div><!-- .row --> 
                        </div><!-- .option-content -->
                  	</div><!-- .option-container -->          
            	</div><!-- #homepagesettings -->       
                
                <!-- Options for Slider Settings -->
                <div id="slidersettings">
           			<div class="option-container">
                		<h3 class="option-toggle"><a href="#"><?php _e( 'Slider Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                            <div class="row">                            
                            	<div class="col col-header">
                        			<?php _e( 'Select Slider Type', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">
                                    <label title="post-slider">
                                    <input type="radio" name="ecvetstep_options[select_slider_type]" id="post-slider" <?php checked($options['select_slider_type'], 'post-slider'); ?> value="post-slider"  />
                                    <?php _e( 'Post Slider', 'ecvetstep' ); ?>
                                    </label>
                                    
                                    <label title="category-slider">
                                    <input type="radio" name="ecvetstep_options[select_slider_type]" id="category-slider" <?php checked($options['select_slider_type'], 'category-slider'); ?> value="category-slider"  />
                                    <?php _e( 'Category Slider', 'ecvetstep' ); ?>
                                    </label>
                              	</div>
                          	</div><!-- .row -->
                            <div class="row">                            
                            	<div class="col col-header">
                        			<?php _e( 'Enable Slider', 'ecvetstep' ); ?>
                               	</div>
                                <div class="col col-options">                          
                                    <label title="enable-slider-homepager">
                                    <input type="radio" name="ecvetstep_options[enable_slider]" id="enable-slider-homepage" <?php checked($options['enable_slider'], 'enable-slider-homepage'); ?> value="enable-slider-homepage"  />
                                    <?php _e( 'Homepage', 'ecvetstep' ); ?>
                                    </label>
                                    <label title="enable-slider-allpage">
                                    <input type="radio" name="ecvetstep_options[enable_slider]" id="enable-slider-allpage" <?php checked($options['enable_slider'], 'enable-slider-allpage'); ?> value="enable-slider-allpage"  />
                                     <?php _e( 'Entire Site', 'ecvetstep' ); ?>
                                    </label>
                                    <label title="disable-slider">
                                    <input type="radio" name="ecvetstep_options[enable_slider]" id="disable-slider" <?php checked($options['enable_slider'], 'disable-slider'); ?> value="disable-slider"  />
                                     <?php _e( 'Disable', 'ecvetstep' ); ?>
                                    </label>                                
                              	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Number of Slides', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" name="ecvetstep_options[slider_qty]" value="<?php echo intval( $options[ 'slider_qty' ] ); ?>" size="2" />
                             	</div>
                          	</div><!-- .row -->                            
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Transition Effect:', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<select id="ecvetstep_cycle_style" name="ecvetstep_options[transition_effect]">
                                        <option value="fade" <?php selected('fade', $options['transition_effect']); ?>><?php _e( 'fade', 'ecvetstep' ); ?></option>
                                        <option value="wipe" <?php selected('wipe', $options['transition_effect']); ?>><?php _e( 'wipe', 'ecvetstep' ); ?></option>
                                        <option value="scrollUp" <?php selected('scrollUp', $options['transition_effect']); ?>><?php _e( 'scrollUp', 'ecvetstep' ); ?></option>
                                        <option value="scrollDown" <?php selected('scrollDown', $options['transition_effect']); ?>><?php _e( 'scrollDown', 'ecvetstep' ); ?></option>
                                        <option value="scrollLeft" <?php selected('scrollLeft', $options['transition_effect']); ?>><?php _e( 'scrollLeft', 'ecvetstep' ); ?></option>
                                        <option value="scrollRight" <?php selected('scrollRight', $options['transition_effect']); ?>><?php _e( 'scrollRight', 'ecvetstep' ); ?></option>
                                        <option value="blindX" <?php selected('blindX', $options['transition_effect']); ?>><?php _e( 'blindX', 'ecvetstep' ); ?></option>
                                        <option value="blindY" <?php selected('blindY', $options['transition_effect']); ?>><?php _e( 'blindY', 'ecvetstep' ); ?></option>
                                        <option value="blindZ" <?php selected('blindZ', $options['transition_effect']); ?>><?php _e( 'blindZ', 'ecvetstep' ); ?></option>
                                        <option value="cover" <?php selected('cover', $options['transition_effect']); ?>><?php _e( 'cover', 'ecvetstep' ); ?></option>
                                        <option value="shuffle" <?php selected('shuffle', $options['transition_effect']); ?>><?php _e( 'shuffle', 'ecvetstep' ); ?></option>
                                    </select>
                             	</div>
                          	</div><!-- .row -->
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Transition Delay', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" name="ecvetstep_options[transition_delay]" value="<?php echo $options[ 'transition_delay' ]; ?>" size="2" />
                         			<span class="description"><?php _e( 'second(s)', 'ecvetstep' ); ?></span>
                             	</div>
                          	</div><!-- .row -->  
                         	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Transition Length', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type="text" name="ecvetstep_options[transition_duration]" value="<?php echo $options[ 'transition_duration' ]; ?>" size="2" />
                                 	<span class="description"><?php _e( 'second(s)', 'ecvetstep' ); ?></span>
                             	</div>
                          	</div><!-- .row -->                                 
                    		<div class="row">
        						<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                          	</div><!-- .row --> 
                        </div><!-- .option-content -->
            		</div><!-- .option-container --> 
              
            
            		<div id="featured-post-slider" class="option-container post-slider">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Featured Post Slider Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                        	<div class="row">
                            	<div class="col col-1">
                                	<?php _e( 'Exclude Slider post from Homepage posts?', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                	<input type='hidden' value='0' name='ecvetstep_options[exclude_slider_post]'>
                                    <input type="checkbox" id="headerlogo" name="ecvetstep_options[exclude_slider_post]" value="1" <?php checked( '1', $options['exclude_slider_post'] ); ?> /> <?php _e('Check to exclude', 'ecvetstep'); ?>
                             	</div>
                          	</div><!-- .row --> 
                            <?php for ( $i = 1; $i <= $options[ 'slider_qty' ]; $i++ ): ?>
                                <div class="repeat-content-wrap">
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php printf( esc_attr__( 'Featured Post Slider #%s', 'ecvetstep' ), $i ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type="text" name="ecvetstep_options[featured_slider][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'featured_slider', $options ) && array_key_exists( $i, $options[ 'featured_slider' ] ) ) echo absint( $options[ 'featured_slider' ][ $i ] ); ?>" />
                                        <a href="<?php bloginfo ( 'url' );?>/wp-admin/post.php?post=<?php if( array_key_exists ( 'featured_slider', $options ) && array_key_exists ( $i, $options[ 'featured_slider' ] ) ) echo absint( $options[ 'featured_slider' ][ $i ] ); ?>&action=edit" class="button" title="<?php esc_attr_e('Click Here To Edit'); ?>" target="_blank"><?php _e( 'Click Here To Edit', 'ecvetstep' ); ?></a>
                                        </div>
                                    </div><!-- .row -->
                                </div><!-- .repeat-content-wrap -->  
                         	<?php endfor; ?>
                            <div class="row">
                           		<p><?php _e( 'Note: Here You can put your Post IDs which displays on Homepage as slider.', 'ecvetstep' ); ?>
                            </div><!-- .row --> 
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                           	</div><!-- .row -->      
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                    
            		<div id="featured-page-slider" class="option-container page-slider">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Featured Page Slider Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                            <?php for ( $i = 1; $i <= $options[ 'slider_qty' ]; $i++ ): ?>
                                <div class="repeat-content-wrap">
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php printf( esc_attr__( 'Featured Page Slider #%s', 'ecvetstep' ), $i ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type="text" name="ecvetstep_options[featured_slider_page][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'featured_slider_page', $options ) && array_key_exists( $i, $options[ 'featured_slider_page' ] ) ) echo absint( $options[ 'featured_slider_page' ][ $i ] ); ?>" />
                                        <a href="<?php bloginfo ( 'url' );?>/wp-admin/post.php?post=<?php if( array_key_exists ( 'featured_slider_page', $options ) && array_key_exists ( $i, $options[ 'featured_slider_page' ] ) ) echo absint( $options[ 'featured_slider_page' ][ $i ] ); ?>&action=edit" class="button" title="<?php esc_attr_e('Click Here To Edit'); ?>" target="_blank"><?php _e( 'Click Here To Edit', 'ecvetstep' ); ?></a>
                                        </div>
                                    </div><!-- .row -->
                                </div><!-- .repeat-content-wrap -->  
                         	<?php endfor; ?>
                            <div class="row">
                           		<?php _e( 'Note: Here You can put your Page IDs which displays on Homepage as slider.', 'ecvetstep' ); ?>
                            </div><!-- .row --> 
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                           	</div><!-- .row -->       
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->   
                    
                    <div id="featured-category-slider" class="option-container category-slider">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Featured Category Slider Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Select Slider Categories', 'ecvetstep' ); ?>
                                    <p><small><?php _e( 'Use this only is you want to display posts from Specific Categories in Featured Slider', 'ecvetstep' ); ?></small></p>
                                </div>
                                <div class="col col-2">	
                                    <select name="ecvetstep_options[slider_category][]" id="frontpage_posts_cats" multiple="multiple" class="select-multiple">
                                        <option value="0" <?php if ( empty( $options['slider_category'] ) ) { selected( true, true ); } ?>><?php _e( '--Disabled--', 'ecvetstep' ); ?></option>
                                        <?php /* Get the list of categories */ 
                                            if( empty( $options[ 'slider_category' ] ) ) {
                                                $options[ 'slider_category' ] = array();
                                            }
                                            $categories = get_categories();
                                            foreach ( $categories as $category) :
                                        ?>
                                        <option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $options['slider_category'] ) ) {echo 'selected="selected"';}?>><?php echo $category->cat_name; ?></option>
                                        <?php endforeach; ?>
                                    </select><br />
                                    <span class="description"><?php _e( 'You may select multiple categories by holding down the CTRL key.', 'ecvetstep' ); ?></span>
                               	</div>
                            </div><!-- .row --> 
                            <div class="row">
                                <?php _e( 'Note: Here you can select the categories from which latest posts will display on Featured Slider.', 'ecvetstep' ); ?>
                            </div><!-- .row --> 
                            <div class="row">
                                <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                            </div><!-- .row -->    
                        </div><!-- .option-content -->
                	</div><!-- .option-container -->                       
                    
            		<div id="featured-image-slider" class="option-container image-slider">
                        <h3 class="option-toggle"><a href="#"><?php _e( 'Featured Image Slider Options', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                             <?php for ( $i = 1; $i <= $options[ 'slider_qty' ]; $i++ ): ?>
                                <div class="repeat-content-wrap">
                                	<h2 class="title"><?php printf( esc_attr__( 'Featured Image Slider #%s', 'ecvetstep' ), $i ); ?></h2>
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Image', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input size="70" type="text" class="upload-url" name="ecvetstep_options[featured_image_slider_image][<?php echo $i; ?>]" value="<?php if( array_key_exists( 'featured_image_slider_image', $options ) && array_key_exists( $i, $options[ 'featured_image_slider_image' ] ) ) echo esc_url( $options[ 'featured_image_slider_image' ][ $i ] ); ?>" />
                                          	<input id="st_upload_button" class="st_upload_button button" name="upload_button" type="button" value="<?php esc_attr_e( 'Upload','ecvetstep' ); ?>" />
                                        </div>
                                    </div><!-- .row -->
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Link URL', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input size="70" type="text" name="ecvetstep_options[featured_image_slider_link][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'featured_image_slider_link', $options ) && array_key_exists( $i, $options[ 'featured_image_slider_link' ] ) ) echo esc_url( $options[ 'featured_image_slider_link' ][ $i ] ); ?>" />
                                        </div>
                                    </div><!-- .row -->  
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Target. Open Link in New Window?', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input type='hidden' value='0' name='ecvetstep_options[featured_image_slider_base][<?php echo absint( $i ); ?>]'>
                                            <input type="checkbox" name="ecvetstep_options[featured_image_slider_base][<?php echo absint( $i ); ?>]" value="1" <?php if( array_key_exists( 'featured_image_slider_base', $options ) && array_key_exists( $i, $options[ 'featured_image_slider_base' ] ) ) checked( '1', $options[ 'featured_image_slider_base' ][ $i ] ); ?> /> <?php _e( 'Check to open in new window', 'ecvetstep' ); ?>
                                        </div>
                                    </div><!-- .row -->
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Title', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <input size="70" type="text" name="ecvetstep_options[featured_image_slider_title][<?php echo absint( $i ); ?>]" value="<?php if( array_key_exists( 'featured_image_slider_title', $options ) && array_key_exists( $i, $options[ 'featured_image_slider_title' ] ) ) echo esc_attr( $options[ 'featured_image_slider_title' ][ $i ] ); ?>" />
                                        </div>
                                    </div><!-- .row --> 
                                    <div class="row">
                                        <div class="col col-1">
                                            <?php _e( 'Content', 'ecvetstep' ); ?>
                                        </div>
                                        <div class="col col-2">
                                            <textarea name="ecvetstep_options[featured_image_slider_content][<?php echo absint( $i ); ?>]" cols="70" rows="3"><?php if( array_key_exists( 'featured_image_slider_content', $options ) && array_key_exists( $i, $options[ 'featured_image_slider_content' ] ) ) echo esc_html( $options[ 'featured_image_slider_content' ][ $i ] ); ?></textarea>
                                        </div>
                                    </div><!-- .row -->                                                                                                             
                                </div><!-- .repeat-content-wrap -->  
                         	<?php endfor; ?>
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                           	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container --> 
                                   
				</div><!-- #slidersettings -->
                
  
              	<!-- Options for Social Links -->
                <div id="sociallinks">
           			<div class="option-container">
                		<h3 class="option-toggle"><a href="#"><?php _e( 'Predefine Social Icons', 'ecvetstep' ); ?></a></h3>
                        <div class="option-content inside">
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Facebook', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_facebook]" value="<?php echo esc_url( $options[ 'social_facebook' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Twitter', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_twitter]" value="<?php echo esc_url( $options[ 'social_twitter'] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                    
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Google+', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_googleplus]" value="<?php echo esc_url( $options[ 'social_googleplus'] ); ?>" />
                                </div>
                            </div><!-- .row -->  
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Pinterest', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_pinterest]" value="<?php echo esc_url( $options[ 'social_pinterest'] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Youtube', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_youtube]" value="<?php echo esc_url( $options[ 'social_youtube' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Vimeo', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_vimeo]" value="<?php echo esc_url( $options[ 'social_vimeo' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                                                    
							<div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Linkedin', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_linkedin]" value="<?php echo esc_url( $options[ 'social_linkedin'] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Slideshare', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_slideshare]" value="<?php echo esc_url( $options[ 'social_slideshare'] ); ?>" />
                                </div>
                            </div><!-- .row -->                            
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Foursquare', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_foursquare]" value="<?php echo esc_url( $options[ 'social_foursquare' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Flickr', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_flickr]" value="<?php echo esc_url( $options[ 'social_flickr' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                   
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Tumblr', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_tumblr]" value="<?php echo esc_url( $options[ 'social_tumblr' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'deviantART', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_deviantart]" value="<?php echo esc_url( $options[ 'social_deviantart' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                                  
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Dribbble', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_dribbble]" value="<?php echo esc_url( $options[ 'social_dribbble' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'MySpace', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_myspace]" value="<?php echo esc_url( $options[ 'social_myspace' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                             
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'WordPress', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_wordpress]" value="<?php echo esc_url( $options[ 'social_wordpress' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'RSS', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_rss]" value="<?php echo esc_url( $options[ 'social_rss' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                     
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Delicious', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_delicious]" value="<?php echo esc_url( $options[ 'social_delicious' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Last.fm', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_lastfm]" value="<?php echo esc_url( $options[ 'social_lastfm' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                                                 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Instagram', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_instagram]" value="<?php echo esc_url( $options[ 'social_instagram' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'GitHub', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_github]" value="<?php echo esc_url( $options[ 'social_github' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                                    
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Vkontakte', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_vkontakte]" value="<?php echo esc_url( $options[ 'social_vkontakte'] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'My World', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_myworld]" value="<?php echo esc_url( $options[ 'social_myworld' ] ); ?>" />
                                </div>
                            </div><!-- .row -->                            
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Odnoklassniki', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_odnoklassniki]" value="<?php echo esc_url( $options[ 'social_odnoklassniki' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Goodreads', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_goodreads]" value="<?php echo esc_url( $options[ 'social_goodreads' ] ); ?>" />
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Skype', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_skype]" value="<?php echo esc_attr( $options[ 'social_skype' ] ); ?>" />
                                </div>
                            </div><!-- .row --> 
                            <div class="row">
                                <div class="col col-1">
                                    <?php _e( 'Soundcloud', 'ecvetstep' ); ?>
                                </div>
                                <div class="col col-2">
                                    <input type="text" size="45" name="ecvetstep_options[social_soundcloud]" value="<?php echo esc_url( $options[ 'social_soundcloud' ] ); ?>" />
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                            	<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                           	</div><!-- .row -->
                        </div><!-- .option-content -->
                    </div><!-- .option-container -->    
                                                    
				</div><!-- #sociallinks -->
                
          		<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>
                    <!-- Options for Webmaster Tools -->
                    <div id="webmaster">               
                        <div id="header-footer-codes" class="option-container">
                            <h3 class="option-toggle"><a href="#"><?php _e( 'Header and Footer Codes', 'ecvetstep' ); ?></a></h3>
                            <div class="option-content inside">
                                <div class="row">
                                    <div class="col col-1">
                                        <?php _e( 'Code to display on Header', 'ecvetstep' ); ?>
                                    </div>
                                    <div class="col col-2">
                                         <textarea name="ecvetstep_options[analytic_header]" id="analytics" rows="7" cols="70" ><?php echo esc_html( $options[ 'analytic_header' ] ); ?></textarea><br /><span class="description"><?php _e('Note: Note: Here you can put scripts from Google, Facebook, Twitter, Add This etc. which will load on Header', 'ecvetstep' ); ?></span>
                                    </div>
                                </div><!-- .row -->                                                    
                                <div class="row">
                                    <div class="col col-1">
                                        <?php _e('Code to display on Footer', 'ecvetstep' ); ?>
                                    </div>
                                    <div class="col col-2">
                                         <textarea name="ecvetstep_options[analytic_footer]" id="analytics" rows="7" cols="70" ><?php echo esc_html( $options[ 'analytic_footer' ] ); ?></textarea><br /><span class="description"><?php _e( 'Note: Here you can put scripts from Google, Facebook, Twitter, Add This etc. which will load on footer', 'ecvetstep' ); ?></span>
                                    </div>
                                </div><!-- .row -->
                                <div class="row">
                                    <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'ecvetstep' ); ?>" />
                                </div><!-- .row --> 
                            </div><!-- .option-content -->
                        </div><!-- .option-container -->  
                    </div><!-- #webmaster -->
                <?php endif; ?>

            </div><!-- #ecvetstep_ad_tabs -->
		</form>
	</div><!-- .wrap -->
<?php
}


/**
 * Validate content options
 * @param array $options
 * @uses esc_url_raw, absint, esc_textarea, sanitize_text_field, ecvetstep_invalidate_caches
 * @return array
 */
function ecvetstep_theme_options_validate( $options ) {
	global $ecvetstep_options_settings, $ecvetstep_options_defaults;
    $input_validated = $ecvetstep_options_settings;	
	
	$defaults = $ecvetstep_options_defaults;
	
    $input = array();
    $input = $options;
	
	// Data Validation for Resonsive Design	
	if ( isset( $input['disable_responsive'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'disable_responsive' ] = $input[ 'disable_responsive' ];
	}

	if ( isset( $input['enable_menus'] ) ) { 
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'enable_menus' ] = $input[ 'enable_menus' ];
	}	
	
	// Data Validation for Favicon		
	if ( isset( $input[ 'fav_icon' ] ) ) {
		$input_validated[ 'fav_icon' ] = esc_url_raw( $input[ 'fav_icon' ] );
	}
	if ( isset( $input['remove_favicon'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'remove_favicon' ] = $input[ 'remove_favicon' ];
	}
	
	// Data Validation for web clip icon
	if ( isset( $input[ 'web_clip' ] ) ) {
		$input_validated[ 'web_clip' ] = esc_url_raw( $input[ 'web_clip' ] );
	}
	if ( isset( $input['remove_web_clip'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'remove_web_clip' ] = $input[ 'remove_web_clip' ];
	}	
	
	// Data Validation for Homepage Headline Message 
	if( isset( $input[ 'homepage_headline' ] ) ) {
		$input_validated['homepage_headline'] =  sanitize_text_field( $input[ 'homepage_headline' ] ) ? $input [ 'homepage_headline' ] : $defaults[ 'homepage_headline' ];
	}
	if( isset( $input[ 'homepage_subheadline' ] ) ) {
		$input_validated['homepage_subheadline'] =  sanitize_text_field( $input[ 'homepage_subheadline' ] ) ? $input [ 'homepage_subheadline' ] : $defaults[ 'homepage_subheadline' ];
	}	
	if( isset( $input[ 'homepage_headline_button' ] ) ) {
		$input_validated['homepage_headline_button'] =  sanitize_text_field( $input[ 'homepage_headline_button' ] ) ? $input [ 'homepage_headline_button' ] : $defaults[ 'homepage_headline_button' ];
	}		
	if( isset( $input[ 'homepage_headline_url' ] ) ) {
		$input_validated['homepage_headline_url'] =  esc_url_raw( $input[ 'homepage_headline_url' ] ) ? $input [ 'homepage_headline_url' ] : $defaults[ 'homepage_headline_url' ];
	}	
	if ( isset( $input[ 'disable_homepage_headline' ] ) ) {
		$input_validated[ 'disable_homepage_headline' ] = $input[ 'disable_homepage_headline' ];
	}
	if ( isset( $input[ 'disable_homepage_subheadline' ] ) ) {
		$input_validated[ 'disable_homepage_subheadline' ] = $input[ 'disable_homepage_subheadline' ];
	}
	if ( isset( $input[ 'disable_homepage_button' ] ) ) {
		$input_validated[ 'disable_homepage_button' ] = $input[ 'disable_homepage_button' ];
	}	
	
	// Data Validation for Header Sidebar	
	if ( isset( $input[ 'disable_header_right_sidebar' ] ) ) {
		$input_validated[ 'disable_header_right_sidebar' ] = $input[ 'disable_header_right_sidebar' ];
	}	
	
	// Data validation for Large Header Image
	if ( isset( $input[ 'enable_featured_header_image' ] ) ) {
		$input_validated[ 'enable_featured_header_image' ] = $input[ 'enable_featured_header_image' ];
	}	 	
	if ( isset( $input['page_featured_image'] ) ) {
		$input_validated[ 'page_featured_image' ] = $input[ 'page_featured_image' ];
	}	
	if ( isset( $input[ 'featured_header_image' ] ) ) {
		$input_validated[ 'featured_header_image' ] = esc_url_raw( $input[ 'featured_header_image' ] ) ? $input [ 'featured_header_image' ] : $defaults[ 'featured_header_image' ];
	}	
	if ( isset( $input[ 'featured_header_image_alt' ] ) ) {
		$input_validated[ 'featured_header_image_alt' ] = sanitize_text_field( $input[ 'featured_header_image_alt' ] );
	}	
	if ( isset( $input[ 'featured_header_image_url' ] ) ) {
		$input_validated[ 'featured_header_image_url' ] = esc_url_raw( $input[ 'featured_header_image_url' ] );
	}	
	if ( isset( $input['featured_header_image_base'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'featured_header_image_base' ] = $input[ 'featured_header_image_base' ];
	}	
	
	if ( isset( $input['reset_featured_image'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'reset_featured_image' ] = $input[ 'reset_featured_image' ];
	}	

	//Reset Header Featured Image Options
	if( $input[ 'reset_featured_image' ] == 1 ) {
		$input_validated[ 'enable_featured_header_image' ] = $defaults[ 'enable_featured_header_image' ];
		$input_validated[ 'page_featured_image' ] = $defaults[ 'page_featured_image' ];
		$input_validated[ 'featured_header_image' ] = $defaults[ 'featured_header_image' ];
		$input_validated[ 'featured_header_image_alt' ] = $defaults[ 'featured_header_image_alt' ];
		$input_validated[ 'featured_header_image_url' ] = $defaults[ 'featured_header_image_url' ];
		$input_validated[ 'featured_header_image_base' ] = $defaults[ 'featured_header_image_base' ];
	}
	
	// data validation for Color Scheme
	if ( isset( $input['color_scheme'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'color_scheme' ] = $input[ 'color_scheme' ];
	}	
	
	// Data Validation for Custom CSS Style
	if ( isset( $input['custom_css'] ) ) {
		$input_validated['custom_css'] = wp_kses_stripslashes($input['custom_css']);
	}
	
	// Data Validation for Homepage Featured Content 
	if ( isset( $input[ 'disable_homepage_featured' ] ) ) {
		$input_validated[ 'disable_homepage_featured' ] = $input[ 'disable_homepage_featured' ];
	}	
	if( isset( $input[ 'homepage_featured_headline' ] ) ) {
		$input_validated['homepage_featured_headline'] =  sanitize_text_field( $input[ 'homepage_featured_headline' ] ) ? $input [ 'homepage_featured_headline' ] : $defaults[ 'homepage_featured_headline' ];
	}	
	if ( isset( $input[ 'homepage_featured_image' ] ) ) {
		$input_validated[ 'homepage_featured_image' ] = array();
	}
	if ( isset( $input[ 'homepage_featured_url' ] ) ) {
		$input_validated[ 'homepage_featured_url' ] = array();
	}
	if ( isset( $input[ 'homepage_featured_base' ] ) ) {
		$input_validated[ 'homepage_featured_base' ] = array();
	}	
	if ( isset( $input[ 'homepage_featured_title' ] ) ) {
		$input_validated[ 'homepage_featured_title' ] = array();
	}
	if ( isset( $input[ 'homepage_featured_content' ] ) ) {
		$input_validated[ 'homepage_featured_content' ] = array();
	}
	if( isset( $input[ 'homepage_featured_layout' ] ) ) {
		$input_validated[ 'homepage_featured_layout' ] = $input[ 'homepage_featured_layout' ];
	}	
	if ( isset( $input[ 'homepage_featured_qty' ] ) ) {
		$input_validated[ 'homepage_featured_qty' ] = absint( $input[ 'homepage_featured_qty' ] ) ? $input [ 'homepage_featured_qty' ] : $defaults[ 'homepage_featured_qty' ];
		for ( $i = 1; $i <= $input [ 'homepage_featured_qty' ]; $i++ ) {
			if ( !empty( $input[ 'homepage_featured_image' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_image' ][ $i ] = esc_url_raw($input[ 'homepage_featured_image' ][ $i ] );
			}
			if ( !empty( $input[ 'homepage_featured_url' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_url'][ $i ] = esc_url_raw($input[ 'homepage_featured_url'][ $i ]);
			}
			if ( !empty( $input[ 'homepage_featured_base' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_base'][ $i ] = $input[ 'homepage_featured_base'][ $i ];
			}
			if ( !empty( $input[ 'homepage_featured_title' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_title'][ $i ] = sanitize_text_field($input[ 'homepage_featured_title'][ $i ]);
			}
			if ( !empty( $input[ 'homepage_featured_content' ][ $i ] ) ) {
				$input_validated[ 'homepage_featured_content'][ $i ] = wp_kses_stripslashes($input[ 'homepage_featured_content'][ $i ]);
			}	
		}
	}	
	
	// Data Validation for Homepage
	if ( isset( $input[ 'enable_posts_home' ] ) ) {
		$input_validated[ 'enable_posts_home' ] = $input[ 'enable_posts_home' ];
	}	
	if ( isset( $input[ 'move_posts_home' ] ) ) {
		$input_validated[ 'move_posts_home' ] = $input[ 'move_posts_home' ];
	}		
	

    if ( isset( $input['exclude_slider_post'] ) ) {
        // Our checkbox value is either 0 or 1 
   		$input_validated[ 'exclude_slider_post' ] = $input[ 'exclude_slider_post' ];	
	
    }
	// Front page posts categories
    if( isset( $input['front_page_category' ] ) ) {
		$input_validated['front_page_category'] = $input['front_page_category'];
    }	

	// data validation for Slider Type
	if( isset( $input[ 'select_slider_type' ] ) ) {
		$input_validated[ 'select_slider_type' ] = $input[ 'select_slider_type' ];
	}
	// data validation for Enable Slider
	if( isset( $input[ 'enable_slider' ] ) ) {
		$input_validated[ 'enable_slider' ] = $input[ 'enable_slider' ];
	}	
    // data validation for number of slides
	if ( isset( $input[ 'slider_qty' ] ) ) {
		$input_validated[ 'slider_qty' ] = absint( $input[ 'slider_qty' ] ) ? $input [ 'slider_qty' ] : 4;
	}	
    // data validation for transition effect
    if( isset( $input[ 'transition_effect' ] ) ) {
        $input_validated['transition_effect'] = wp_filter_nohtml_kses( $input['transition_effect'] );
    }
    // data validation for transition delay
    if ( isset( $input[ 'transition_delay' ] ) && is_numeric( $input[ 'transition_delay' ] ) ) {
        $input_validated[ 'transition_delay' ] = $input[ 'transition_delay' ];
    }
    // data validation for transition length
    if ( isset( $input[ 'transition_duration' ] ) && is_numeric( $input[ 'transition_duration' ] ) ) {
        $input_validated[ 'transition_duration' ] = $input[ 'transition_duration' ];
    }	
	
	// data validation for Featured Post and Page Slider
	if ( isset( $input[ 'featured_slider' ] ) ) {
		$input_validated[ 'featured_slider' ] = array();
	}
	if ( isset( $input[ 'featured_slider_page' ] ) ) {
		$input_validated[ 'featured_slider_page' ] = array();
	}		
 	if ( isset( $input[ 'slider_qty' ] ) )	{	
		for ( $i = 1; $i <= $input [ 'slider_qty' ]; $i++ ) {
			if ( !empty( $input[ 'featured_slider' ][ $i ] ) && intval( $input[ 'featured_slider' ][ $i ] ) ) {
				$input_validated[ 'featured_slider' ][ $i ] = absint($input[ 'featured_slider' ][ $i ] );
			}
			if ( !empty( $input[ 'featured_slider_page' ][ $i ] ) && intval( $input[ 'featured_slider_page' ][ $i ] ) ) {
				$input_validated[ 'featured_slider_page' ][ $i ] = absint($input[ 'featured_slider_page' ][ $i ] );
			}			
		}
	}	
	
	//Featured Catgory Slider
	if ( isset( $input['slider_category'] ) ) {
		$input_validated[ 'slider_category' ] = $input[ 'slider_category' ];
	}		
	
	// data validation for Featured Image SLider 
	if ( isset( $input[ 'featured_image_slider_image' ] ) ) {
		$input_validated[ 'featured_image_slider_image' ] = array();
	}
	if ( isset( $input[ 'featured_image_slider_link' ] ) ) {
		$input_validated[ 'featured_image_slider_link' ] = array();
	}
	if ( isset( $input[ 'featured_image_slider_base' ] ) ) {
		$input_validated[ 'featured_image_slider_base' ] = array();
	}		
	if ( isset( $input[ 'featured_image_slider_title' ] ) ) {
		$input_validated[ 'featured_image_slider_title' ] = array();
	}
	if ( isset( $input[ 'featured_image_slider_content' ] ) ) {
		$input_validated[ 'featured_image_slider_content' ] = array();
	}	
 	if ( isset( $input[ 'slider_qty' ] ) )	{	
		for ( $i = 1; $i <= $input [ 'slider_qty' ]; $i++ ) {
			if ( !empty( $input[ 'featured_image_slider_image' ][ $i ] ) ) {
				$input_validated[ 'featured_image_slider_image' ][ $i ] = esc_url_raw($input[ 'featured_image_slider_image' ][ $i ] );
			}
			if ( !empty( $input[ 'featured_image_slider_link' ][ $i ] ) ) {
				$input_validated[ 'featured_image_slider_link'][ $i ] = esc_url_raw($input[ 'featured_image_slider_link'][ $i ]);
			}
			if ( !empty( $input[ 'featured_image_slider_base' ][ $i ] ) ) {
				$input_validated[ 'featured_image_slider_base'][ $i ] = $input[ 'featured_image_slider_base'][ $i ];
			}
			if ( !empty( $input[ 'featured_image_slider_title' ][ $i ] ) ) {
				$input_validated[ 'featured_image_slider_title'][ $i ] = sanitize_text_field($input[ 'featured_image_slider_title'][ $i ]);
			}
			if ( !empty( $input[ 'featured_image_slider_content' ][ $i ] ) ) {
				$input_validated[ 'featured_image_slider_content'][ $i ] = wp_kses_stripslashes($input[ 'featured_image_slider_content'][ $i ]);
			}			
		}
	}	
	
	// data validation for Social Icons
	if( isset( $input[ 'social_facebook' ] ) ) {
		$input_validated[ 'social_facebook' ] = esc_url_raw( $input[ 'social_facebook' ] );
	}
	if( isset( $input[ 'social_twitter' ] ) ) {
		$input_validated[ 'social_twitter' ] = esc_url_raw( $input[ 'social_twitter' ] );
	}
	if( isset( $input[ 'social_googleplus' ] ) ) {
		$input_validated[ 'social_googleplus' ] = esc_url_raw( $input[ 'social_googleplus' ] );
	}
	if( isset( $input[ 'social_pinterest' ] ) ) {
		$input_validated[ 'social_pinterest' ] = esc_url_raw( $input[ 'social_pinterest' ] );
	}	
	if( isset( $input[ 'social_youtube' ] ) ) {
		$input_validated[ 'social_youtube' ] = esc_url_raw( $input[ 'social_youtube' ] );
	}
	if( isset( $input[ 'social_vimeo' ] ) ) {
		$input_validated[ 'social_vimeo' ] = esc_url_raw( $input[ 'social_vimeo' ] );
	}	
	if( isset( $input[ 'social_linkedin' ] ) ) {
		$input_validated[ 'social_linkedin' ] = esc_url_raw( $input[ 'social_linkedin' ] );
	}
	if( isset( $input[ 'social_slideshare' ] ) ) {
		$input_validated[ 'social_slideshare' ] = esc_url_raw( $input[ 'social_slideshare' ] );
	}	
	if( isset( $input[ 'social_foursquare' ] ) ) {
		$input_validated[ 'social_foursquare' ] = esc_url_raw( $input[ 'social_foursquare' ] );
	}
	if( isset( $input[ 'social_flickr' ] ) ) {
		$input_validated[ 'social_flickr' ] = esc_url_raw( $input[ 'social_flickr' ] );
	}
	if( isset( $input[ 'social_tumblr' ] ) ) {
		$input_validated[ 'social_tumblr' ] = esc_url_raw( $input[ 'social_tumblr' ] );
	}	
	if( isset( $input[ 'social_deviantart' ] ) ) {
		$input_validated[ 'social_deviantart' ] = esc_url_raw( $input[ 'social_deviantart' ] );
	}
	if( isset( $input[ 'social_dribbble' ] ) ) {
		$input_validated[ 'social_dribbble' ] = esc_url_raw( $input[ 'social_dribbble' ] );
	}	
	if( isset( $input[ 'social_myspace' ] ) ) {
		$input_validated[ 'social_myspace' ] = esc_url_raw( $input[ 'social_myspace' ] );
	}
	if( isset( $input[ 'social_wordpress' ] ) ) {
		$input_validated[ 'social_wordpress' ] = esc_url_raw( $input[ 'social_wordpress' ] );
	}	
	if( isset( $input[ 'social_rss' ] ) ) {
		$input_validated[ 'social_rss' ] = esc_url_raw( $input[ 'social_rss' ] );
	}
	if( isset( $input[ 'social_delicious' ] ) ) {
		$input_validated[ 'social_delicious' ] = esc_url_raw( $input[ 'social_delicious' ] );
	}	
	if( isset( $input[ 'social_lastfm' ] ) ) {
		$input_validated[ 'social_lastfm' ] = esc_url_raw( $input[ 'social_lastfm' ] );
	}
	if( isset( $input[ 'social_instagram' ] ) ) {
		$input_validated[ 'social_instagram' ] = esc_url_raw( $input[ 'social_instagram' ] );
	}	
	if( isset( $input[ 'social_github' ] ) ) {
		$input_validated[ 'social_github' ] = esc_url_raw( $input[ 'social_github' ] );
	}
	if( isset( $input[ 'social_vkontakte' ] ) ) {
		$input_validated[ 'social_vkontakte' ] = esc_url_raw( $input[ 'social_vkontakte' ] );
	}	
	if( isset( $input[ 'social_myworld' ] ) ) {
		$input_validated[ 'social_myworld' ] = esc_url_raw( $input[ 'social_myworld' ] );
	}
	if( isset( $input[ 'social_odnoklassniki' ] ) ) {
		$input_validated[ 'social_odnoklassniki' ] = esc_url_raw( $input[ 'social_odnoklassniki' ] );
	}	
	if( isset( $input[ 'social_goodreads' ] ) ) {
		$input_validated[ 'social_goodreads' ] = esc_url_raw( $input[ 'social_goodreads' ] );
	}	
	if( isset( $input[ 'social_skype' ] ) ) {
		$input_validated[ 'social_skype' ] = sanitize_text_field( $input[ 'social_skype' ] );
	}
	if( isset( $input[ 'social_soundcloud' ] ) ) {
		$input_validated[ 'social_soundcloud' ] = esc_url_raw( $input[ 'social_soundcloud' ] );
	}		

	// data validation for Custom Social Icons 
	if ( isset( $input[ 'social_custom_qty' ] ) ) {
		$input_validated[ 'social_custom_qty' ] = absint( $input[ 'social_custom_qty' ] ) ? $input [ 'social_custom_qty' ] : 1;
	}
	if ( isset( $input[ 'social_custom_name' ] ) ) {
		$input_validated[ 'social_custom_name' ] = array();
	}
	if ( isset( $input[ 'social_custom_image' ] ) ) {
		$input_validated[ 'social_custom_image' ] = array();
	}
	if ( isset( $input[ 'social_custom_url' ] ) ) {
		$input_validated[ 'social_custom_url' ] = array();
	}		
 	if ( isset( $input[ 'social_custom_qty' ] ) )	{	
		for ( $i = 1; $i <= $input [ 'social_custom_qty' ]; $i++ ) {
			if ( !empty( $input[ 'social_custom_name' ][ $i ] ) ) {
				$input_validated[ 'social_custom_name'][ $i ] = sanitize_text_field($input[ 'social_custom_name'][ $i ]);
			}
			if ( !empty( $input[ 'social_custom_image' ][ $i ] ) ) {
				$input_validated[ 'social_custom_image' ][ $i ] = esc_url_raw($input[ 'social_custom_image' ][ $i ] );
			}
			if ( !empty( $input[ 'social_custom_url' ][ $i ] ) ) {
				$input_validated[ 'social_custom_url'][ $i ] = esc_url_raw($input[ 'social_custom_url'][ $i ]);
			}		
		}
	}	
	
		
	//Webmaster Tool Verification
	if( isset( $input[ 'google_verification' ] ) ) {
		$input_validated[ 'google_verification' ] = wp_filter_post_kses( $input[ 'google_verification' ] );
	}
	if( isset( $input[ 'yahoo_verification' ] ) ) {
		$input_validated[ 'yahoo_verification' ] = wp_filter_post_kses( $input[ 'yahoo_verification' ] );
	}
	if( isset( $input[ 'bing_verification' ] ) ) {
		$input_validated[ 'bing_verification' ] = wp_filter_post_kses( $input[ 'bing_verification' ] );
	}	
	if( isset( $input[ 'analytic_header' ] ) ) {
		$input_validated[ 'analytic_header' ] = wp_kses_stripslashes( $input[ 'analytic_header' ] );
	}
	if( isset( $input[ 'analytic_footer' ] ) ) {
		$input_validated[ 'analytic_footer' ] = wp_kses_stripslashes( $input[ 'analytic_footer' ] );	
	}		
	
    // Layout settings verification
	if( isset( $input[ 'sidebar_layout' ] ) ) {
		$input_validated[ 'sidebar_layout' ] = $input[ 'sidebar_layout' ];
	}
	if( isset( $input[ 'content_layout' ] ) ) {
		$input_validated[ 'content_layout' ] = $input[ 'content_layout' ];
	}
	
	//data validation for more text
    if( isset( $input[ 'more_tag_text' ] ) ) {
        $input_validated[ 'more_tag_text' ] = htmlentities( sanitize_text_field ( $input[ 'more_tag_text' ] ), ENT_QUOTES, 'UTF-8' );
    }
    //data validation for excerpt length
    if ( isset( $input[ 'excerpt_length' ] ) ) {
        $input_validated[ 'excerpt_length' ] = absint( $input[ 'excerpt_length' ] ) ? $input [ 'excerpt_length' ] : $defaults[ 'excerpt_length' ];
    }
	if ( isset( $input['reset_moretag'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'reset_moretag' ] = $input[ 'reset_moretag' ];
	}	
	
	//Reset Color Options
	if( $input[ 'reset_moretag' ] == 1 ) {
		$input_validated[ 'more_tag_text' ] = $defaults[ 'more_tag_text' ];
		$input_validated[ 'excerpt_length' ] = $defaults[ 'excerpt_length' ];
	}			
	
	
    if( isset( $input[ 'search_display_text' ] ) ) {
        $input_validated[ 'search_display_text' ] = sanitize_text_field( $input[ 'search_display_text' ] ) ? $input [ 'search_display_text' ] : $defaults[ 'search_display_text' ];
    }
	
	// Data Validation for Featured Image
	if ( isset( $input['featured_image'] ) ) {
		$input_validated[ 'featured_image' ] = $input[ 'featured_image' ];
	}
	
	if ( isset( $input['reset_layout'] ) ) {
		// Our checkbox value is either 0 or 1 
		$input_validated[ 'reset_layout' ] = $input[ 'reset_layout' ];
	}	
	
	//Reset Color Options
	if( $input[ 'reset_layout' ] == 1 ) {
		$input_validated[ 'sidebar_layout' ] = $defaults[ 'sidebar_layout' ];
		$input_validated[ 'content_layout' ] = $defaults[ 'content_layout' ];
		$input_validated[ 'featured_image' ] = $defaults[ 'featured_image' ];
	}		
	


	//Feed Redirect
	if ( isset( $input[ 'feed_url' ] ) ) {
		$input_validated['feed_url'] = esc_url_raw($input['feed_url']);
	}
	
	//Clearing the theme option cache
	if( function_exists( 'ecvetstep_themeoption_invalidate_caches' ) ) ecvetstep_themeoption_invalidate_caches();
	
	return $input_validated;
}


/*
 * Clearing the cache if any changes in Admin Theme Option
 */
function ecvetstep_themeoption_invalidate_caches() {
	delete_transient( 'ecvetstep_responsive'); // Responsive design
	delete_transient( 'ecvetstep_favicon' );	 // favicon on cpanel/ backend and frontend
	delete_transient( 'ecvetstep_featured_image' ); // featured header image	
	delete_transient( 'ecvetstep_inline_css' ); // Custom Inline CSS
	delete_transient( 'ecvetstep_post_sliders' ); // featured post slider
	delete_transient( 'ecvetstep_page_sliders' ); // featured page slider
	delete_transient( 'ecvetstep_category_sliders' ); // featured category slider
	delete_transient( 'ecvetstep_image_sliders' ); // featured image slider
	delete_transient( 'ecvetstep_default_sliders' ); //Default slider
	delete_transient( 'ecvetstep_homepage_headline' ); // Homepage Headline Message
	delete_transient( 'ecvetstep_default_featured_content' ); // Homepage Default Featured Content
	delete_transient( 'ecvetstep_homepage_featured_content' ); // Homepage Featured Content
	delete_transient( 'ecvetstep_footer_content' ); // Footer Content
	delete_transient( 'ecvetstep_social_networks' ); // Social Networks
	delete_transient( 'ecvetstep_webmaster' ); // scripts which loads on header
	delete_transient( 'ecvetstep_footercode' ); // scripts which loads on footer
	delete_transient( 'ecvetstep_web_clip' ); // web clip icons
}


/*
 * Clearing the cache if any changes in post or page
 */
function ecvetstep_post_invalidate_caches(){
	delete_transient( 'ecvetstep_post_sliders' ); // featured post slider
	delete_transient( 'ecvetstep_page_sliders' ); // featured page slider
	delete_transient( 'ecvetstep_category_sliders' ); // featured category slider
}
//Add action hook here save post
add_action( 'save_post', 'ecvetstep_post_invalidate_caches' );


/**
 * Creates new shortcodes for use in any shortcode-ready area.  This function uses the add_shortcode() 
 * function to register new shortcodes with WordPress.
 *
 * @uses add_shortcode() to create new shortcodes.
 */
function ecvetstep_add_shortcodes() {
	/* Add theme-specific shortcodes. */
	add_shortcode( 'footer-image', 'ecvetstep_footer_image_shortcode' );
	add_shortcode( 'the-year', 'ecvetstep_the_year_shortcode' );
	add_shortcode( 'site-link', 'ecvetstep_site_link_shortcode' );
	add_shortcode( 'wp-link', 'ecvetstep_wp_link_shortcode' );
	add_shortcode( 'theme-link', 'ecvetstep_theme_link_shortcode' );
	
}
/* Register shortcodes. */
add_action( 'init', 'ecvetstep_add_shortcodes' );


/**
 * Shortcode to display Footer Image.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function ecvetstep_footer_image_shortcode() {
	if( function_exists( 'ecvetstep_footerlogo' ) ) :
    	return ecvetstep_footerlogo(); 
    endif;
}


/**
 * Shortcode to display the current year.
 *
 * @uses date() Gets the current year.
 * @return string
 */
function ecvetstep_the_year_shortcode() {
	return date( __( 'Y', 'ecvetstep' ) );
}


/**
 * Shortcode to display a link back to the site.
 *
 * @uses get_bloginfo() Gets the site link
 * @return string
 */
function ecvetstep_site_link_shortcode() {
	return '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';
}


/**
 * Shortcode to display a link to WordPress.org.
 *
 * @return string
 */
function ecvetstep_wp_link_shortcode() {
	return '<a href="http://wordpress.org" target="_blank" title="' . esc_attr__( 'WordPress', 'ecvetstep' ) . '"><span>' . __( 'WordPress', 'ecvetstep' ) . '</span></a>';
}


/**
 * Shortcode to display a link to Theme Link.
 *
 * @return string
 */
function ecvetstep_theme_link_shortcode() {
	return '<a href="http://ecvet-step.eu" target="_blank" title="' . esc_attr__( 'ECVET STEP', 'ecvetstep' ) . '"><span>' . __( 'ECVET STEP', 'ecvetstep' ) . '</span></a>';
}