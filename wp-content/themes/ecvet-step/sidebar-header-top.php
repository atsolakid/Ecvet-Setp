<?php
/**
 * The Header Top widget areas.
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */
?>
<?php 
/** 
 * ecvetstep_before_header_top hook
 */
do_action( 'ecvetstep_before_header_top' ); ?> 
<?php 
if ( is_active_sidebar( 'sidebar-header-top' ) ) {	?>
    <div id="header-top" class="header-sidebar widget-area">
    	<div class="container">
    		<?php dynamic_sidebar( 'sidebar-header-top' ); ?>
        </div>
    </div><!-- #header-right .widget-area -->
<?php 
}
/** 
 * ecvetstep_after_header_top hook
 */
do_action( 'ecvetstep_after_header_top' ); ?> 