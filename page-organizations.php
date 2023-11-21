<?php echo do_shortcode ( '[need_login]' ); ?>

<?php
/*
Template Name: Admin Organizations
*/

get_header('admin');
?>

	<main id="primary" class="site-main">
		<h1 class="text-center py-3">List of Organizations</h1>

		

		<div class="container-fluid px-1 px-md-4 py-3 mx-auto">
    		<div class="row d-flex justify-content-center px-3">
        		<div class="card">
					<h2 class="card-font ml-auto mr-4 mt-3 mb-0 card-font-l">Vedogvarer</h2>
					<p class="card-font ml-auto mr-4 mb-0 card-font-m">Owners: Matti</p>
					<p class="card-font ml-auto mr-4 mb-2 card-font-m">List of registered dispensers:</p>

					<div class="alert row alert-success" role="alert">
						<div class="col-md-4">
							<strong>Tuira</strong>
						</div>
						<div class="col-md-4">
							Fillers appointed: 5
						</div>
						<div class="col-md-4 align-right">
							Previously used on: 12.12.2012
						</div>
					</div>

					<div class="alert row alert-success" role="alert">
						<div class="col-md-4">
							<strong>Tuira Secondary</strong>
						</div>
						<div class="col-md-4">
							Fillers appointed: 25
						</div>
						<div class="col-md-4 align-right">
							Previously used on: 12.12.1920
						</div>
					</div>
        		</div>
			</div>
    	</div>


	</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');


					