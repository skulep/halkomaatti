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
			<div class="alert row alert-primary" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Lockers refilled completely
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-success" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Battery swapped
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-warning" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Locker #21 is stuck
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-danger" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Battery #1 is empty, device is turning off shortly
				</div>
				<div class="col-md-2">
					20.2.2022
				</div>
			</div>

			<div class="text-center">
				<a href="http://localhost/wordpress/all-notifications/" class="btn btn-primary btn-lg text-center justify-content-center" role="button" aria-disabled="true">All notifications</a>
			</div>

		</div>
		
		
	</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');
