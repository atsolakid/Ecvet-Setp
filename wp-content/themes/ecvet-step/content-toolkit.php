<?php
/**
 * The template for displaying content in the page.php template
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-container">
	<div class="entry-content">
        <?php the_content(); ?>
     	</div><!-- .entry-content -->
        
        <footer class="entry-meta">          
        <?php edit_post_link( __( 'Edit', 'ecvetstep' ), '<span class="edit-link">', '</span>' ); ?>        
        </footer><!-- .entry-meta -->
        
    </div><!-- .entry-container -->
    
</article><!-- #post-<?php the_ID(); ?> -->
