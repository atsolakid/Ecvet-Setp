<?php
/**
 * The template for displaying search forms in ECVET STEP One
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */
 
// get the data value from theme options
global $ecvetstep_options_settings;
$options = $ecvetstep_options_settings;

$ecvetstep_search_text = $options[ 'search_display_text' ]; 
?>
	<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'ecvetstep' ); ?></label>
		<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php printf( __( '%s', 'ecvetstep' ) , $ecvetstep_search_text ); ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'ecvetstep' ); ?>" />
	</form>
