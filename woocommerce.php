<?php 
/*
Template Name: Woocommerce
*/


get_header();
?>
 

	<main id="primary" class="site-main">

		<?php echo do_shortcode ( '[products columns=4 limit=16]' ); ?>

		
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();