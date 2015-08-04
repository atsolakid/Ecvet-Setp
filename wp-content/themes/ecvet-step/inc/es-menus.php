<?php
if ( ! function_exists( 'ecvetstep_primary_menu' ) ) :
/**
 * Shows the Primary Menu 
 *
 * default load in sidebar-header-right.php
 */
function ecvetstep_primary_menu() { ?>
	<div id="header-menu">
        <nav id="access" role="navigation">
            <h2 class="assistive-text"><?php _e( 'Primary Menu', 'ecvetstep' ); ?></h2>
            <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'ecvetstep' ); ?>"><?php _e( 'Skip to content', 'ecvetstep' ); ?></a></div>
            <?php
                if ( has_nav_menu( 'primary' ) ) { 
                    $ecvetstep_primary_menu_args = array(
                        'theme_location'    => 'primary',
                        'container_class' 	=> 'menu-header-container', 
                        'items_wrap'        => '<ul class="menu">%3$s</ul>' 
                    );
                    wp_nav_menu( $ecvetstep_primary_menu_args );
                }
                else {
                    echo '<div class="menu-header-container">';
                    wp_page_menu( array( 'menu_class'  => 'menu' ) );
                    echo '</div>';
                }
            ?> 	         
        </nav><!-- .site-navigation .main-navigation -->  
	</div>
<?php
}
endif; // ecvetstep_primary_menu


if ( ! function_exists( 'ecvetstep_secondary_menu' ) ) :
/**
 * Shows the Secondary Menu 
 *
 * Hooked to ecvetstep_after_hgroup_wrap
 */
function ecvetstep_secondary_menu() { 
	if ( has_nav_menu( 'secondary' ) ) { ?>
	<div id="secondary-menu">
        <nav id="access-secondary" role="navigation">
            <h2 class="assistive-text"><?php _e( 'Secondary Menu', 'ecvetstep' ); ?></h2>
            <?php     
				$ecvetstep_secondary_menu_args = array(
					'theme_location'    => 'secondary',
					'container_class' 	=> 'menu-secondary-container', 
					'items_wrap'        => '<ul class="menu">%3$s</ul>' 
				);
				wp_nav_menu( $ecvetstep_secondary_menu_args );
            ?> 	         
        </nav><!-- .site-navigation .main-navigation -->  
	</div>
	<?php
	}
}
endif; // ecvetstep_secondary_menu

// Load  breadcrumb in ecvetstep_after_hgroup_wrap hook
add_action( 'ecvetstep_after_hgroup_wrap', 'ecvetstep_secondary_menu', 20 );