<?php
/*
Template Name: Admin Main

fireb shortcode <?php echo do_shortcode ( '[custom_firebase]' ); ?>
*/


get_header('admin');
?>


	<main id="primary" class="site-main">
		<h1 class="text-center">Box Status</h1>

		<div class="container-fluid px-1 px-md-4 py-5 mx-auto box-status-holder">
			
		</div>

		<h1 class="text-center">Notifications</h1>
		<div class="notif-holder">
			<div class="text-center">
				<a href="http://localhost/wordpress/all-notifications/" class="btn btn-primary btn-lg text-center justify-content-center" role="button" aria-disabled="true">All notifications</a>
			</div>

		</div>
		
		
	</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');
