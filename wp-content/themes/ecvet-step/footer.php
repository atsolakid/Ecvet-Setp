<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package ECVET STEP Themes
 * @subpackage ECVET STEP One
 * @since ECVET STEP One 1.0
 */
?>

	<?php 
    /** 
     * ecvetstep_content_sidebar_end hook
     *
     * @hooked ecvetstep_content_sidebar_wrap_end - 10
	 * @hooked ecvetstep_third_sidebar - 15
     */
    do_action( 'ecvetstep_content_sidebar_end' ); 
    ?>  

	</div><!-- #main .site-main -->
    
	<?php 
    /**  
     * ecvetstep_after_main hook
     */
    do_action( 'ecvetstep_after_main' ); 
    ?> 
    
	<footer id="colophon" role="contentinfo">
		<?php
        /** 
         * ecvetstep_before_footer_sidebar hook
         */
        do_action( 'ecvetstep_before_footer_sidebar' );    

		/* A sidebar in the footer? Yep. You can can customize
		 * your footer with three columns of widgets.
		 */
		get_sidebar( 'footer' ); 

		/** 
		 * ecvetstep_after_footer_sidebar hook
		 */
		do_action( 'ecvetstep_after_footer_sidebar' ); ?>   
           
        <div id="site-generator" class="container">
			<?php 
            /** 
             * ecvetstep_before_site_info hook
             */
            do_action( 'ecvetstep_before_site_info' ); ?>  
                    
        	<div class="site-info">
            	<?php 
				/** 
				 * ecvetstep_site_info hook
				 *
				 * @hooked ecvetstep_footer_content - 10
				 */
				do_action( 'ecvetstep_site_generator' ); ?>
          	</div><!-- .site-info -->
            
			<?php 
            /** 
             * ecvetstep_after_site_info hook
             */
            do_action( 'ecvetstep_after_site_info' ); ?>              
       	</div><!-- #site-generator --> 
        
        <?php
        /** 
		 * ecvetstep_after_site_generator hook
		 */
		do_action( 'ecvetstep_after_site_generator' ); ?>  
               
	</footer><!-- #colophon .site-footer -->
    
    <?php 
    /** 
     * ecvetstep_after_footer hook
     */
    do_action( 'ecvetstep_after_footer' ); 
    ?> 
    
</div><!-- #page .hfeed .site -->

<?php 
/** 
 * ecvetstep_after hook
 */
do_action( 'ecvetstep_after' );

wp_footer(); ?>

</body>
</html>