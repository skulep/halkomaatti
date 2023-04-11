<?php
/*
Template Name: Customer Store View

extra shortcode that used to be there after products:
columns=4 limit=16
*/

get_header('customer');
?>

	<main id="primary" class="site-main">

			<!-- List of items -->

			<!-- Stack the columns on mobile by making one full-width and the other half-width -->

			<div class="container">
				<h5 class="text-center">Items and services</h5>

				<?php echo do_shortcode ( '[products columns=5 limit=16]' ); ?>
			</div>


		
	</main><!-- #main -->

<?php
get_sidebar();
get_footer('shoppage');
