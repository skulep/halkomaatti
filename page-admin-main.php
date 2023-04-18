<?php
/*
Template Name: Admin Main

fireb shortcode <?php echo do_shortcode ( '[custom_firebase]' ); ?>
*/


get_header('admin');
?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

	<main id="primary" class="site-main">
		<h1>Box Status</h1>

		<div class="container-fluid px-1 px-md-4 py-5 mx-auto">
    		<div class="row d-flex justify-content-center px-3">
        		<div class="card">
					<h2 class="card-font ml-auto mr-4 mt-3 mb-0 card-font-l">Tuira</h2>
					<p class="card-font ml-auto mr-4 mb-0 card-font-m">20/30</p>
					<h1 class="card-font ml-auto mr-4 card-font-m">Battery 56%&#176;</h1>
					<p class="card-font ml-4 mb-4 card-font-s">Previously filled: 15.3.2023</p>
        		</div>
    		</div>

			
		
			<div class="row d-flex justify-content-center px-3">
        		<div class="card">
					<h2 class="card-font ml-auto mr-4 mt-3 mb-0 card-font-l">Toinen Sijainti</h2>
					<p class="card-font ml-auto mr-4 mb-0 card-font-m">25/60</p>
					<h1 class="card-font ml-auto mr-4 card-font-m">Battery 4%&#176;</h1>
					<p class="card-font ml-4 mb-4 card-font-s">Previously filled: 11.3.2021</p>
        		</div>
    		</div>

		</div>

		<h1>Notifications</h1>
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

			
			<a href="http://localhost/wordpress/all-notifications/" class="btn btn-primary btn-lg" role="button" aria-disabled="true">All notifications...</a>

		</div>
		
		
	</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');
