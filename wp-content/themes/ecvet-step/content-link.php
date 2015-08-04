<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */
//Getting data from Theme Options Panel and Meta Box 
global $ecvetstep_options_settings;
$options = $ecvetstep_options_settings; 

//More Tag
$moretag = $options[ 'more_tag_text' ]; 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( function_exists( 'ecvetstep_content_image' ) ) : ecvetstep_content_image(); endif; ?>

	<div class="entry-container post-format">
    
        <header class="entry-format">
        	<a href="<?php echo get_post_format_link( 'link' ); ?>" title="<?php _e( 'All Link Posts', 'ecvetstep' ); ?>"><?php _e( 'Link', 'ecvetstep' ); ?></a>
        </header>
        
        <div class="entry-content">
            <?php the_content( $moretag ); ?>
			<?php wp_link_pages( array( 
                'before'		=> '<div class="page-link"><span class="pages">' . __( 'Pages:', 'ecvetstep' ) . '</span>',
                'after'			=> '</div>',
                'link_before' 	=> '<span>',
                'link_after'   	=> '</span>',
            ) ); 
            ?>
        </div><!-- .entry-content -->
    
        <footer class="entry-meta">
            <?php ecvetstep_post_format_meta(); ?>   
            <?php if ( comments_open() ) : ?>
            	<span class="sep"> | </span>
            	<span class="comments-link"><?php comments_popup_link(__('Leave a reply', 'ecvetstep'), __('1 Reply', 'ecvetstep'), __('% Replies;', 'ecvetstep')); ?></span>
            <?php endif; ?>
            <?php edit_post_link( __( 'Edit', 'ecvetstep' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
        </footer><!-- .entry-meta -->
         
  	</div><!-- .entry-container -->
    
</article><!-- #post-<?php the_ID(); ?> -->
