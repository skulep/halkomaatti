<?php
/*
Template Name: Admin Box Info
*/

get_header('admin');
?>

	<main id="primary" class="site-main">


		<div class="row">
			<div class="col-lg-8">
				<iframe
				src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1683.6863634062288!2d25.551695752358476!3d65.03934838392831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4681d2cf3d4cd4a9%3A0x186f4dca5379003d!2sK-Citymarket%20Oulu%20Rusko!5e0!3m2!1sfi!2sfi!4v1679042615737!5m2!1sfi!2sfi"
				class="w-100" height="500" allowfullscreen="" loading="lazy"></iframe>
			</div>


			<!-------- PC/Tablet view -->
			<div class="col-lg-2 my-4 d-flex align-items-center d-none d-lg-block">
				<div>
					<h2 class="pb-5">Box Status</h2>
					<h5>Tuira</h5>
					<h6>Example Street Name</h6>
					<h6>Oulu, Finland</h6>
					<h6>14.595328, 15.2335643</h6>
					<a class="btn btn-primary" style="w-100" href="http://localhost/wordpress/fill-a-dispenser/" role="button">Register to Fill</a> 

					<a class="btn btn-outline-warning" href="#" role="button">Remove from database</a>
				</div>
			</div>

			<!-------- Mobile view -->
			<div class="col my-4 d-flex justify-content-center text-center d-lg-none">
				<div>
					<h2 class="pb-5">Box Status</h2>
					<h5>Tuira</h5>
					<h6>Example Street Name</h6>
					<h6>Oulu, Finland</h6>
					<h6>14.595328, 15.2335643</h6>
					<a class="btn btn-primary" href="http://localhost/wordpress/fill-a-dispenser/" role="button">Register to Fill</a> 

					<a class="btn btn-outline-warning" href="#" role="button">Remove from database</a>
				</div>
			</div>
		</div>



	</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');
