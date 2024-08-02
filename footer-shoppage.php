<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Halko
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="fixed-bottom pt-2 pb-2">
			<div class="container">
				<div class="row">
					<div class="col-4 d-flex justify-content-front">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#locationModal">
							<i class="bi bi-geo-alt"></i> Location Info
						</button>
					</div>

					<div class="col-4 d-flex justify-content-center">
					</div>

					<div class="col-4 d-flex justify-content-end">
						<a class="btn btn-primary" href="<?php echo get_home_url(); ?>/index.php/cart/" role="button">
							Cart <i class="bi bi-cart2"></i>
						</a>
					</div>
				</div>
			</div>	
		</div>

		<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
  			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    			<div class="modal-content">
      				<div class="modal-header">
						<h5 class="modal-title" id="locationModalLabel">Location Info</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      			<div class="modal-body">
				  <div class="container">
					<div class="row w-100 ">
						<div class="col-lg-8">
							<iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1683.6863634062288!2d25.551695752358476!3d65.03934838392831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4681d2cf3d4cd4a9%3A0x186f4dca5379003d!2sK-Citymarket%20Oulu%20Rusko!5e0!3m2!1sfi!2sfi!4v1679042615737!5m2!1sfi!2sfi"
							class="w-100" height="500" allowfullscreen="" loading="lazy"></iframe>
						</div>
						<div class="col-lg-2 my-2 d-flex align-items-center">
							<div>
								<h5>Tuira</h5>
								<h6>Example Street Name</h6>
								<h6>Oulu, Finland</h6>
								<h6>14.595328, 15.2335643</h6>
							</div>
						</div>
					</div>
				</div>
      			<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<a class="btn btn-primary" href="geo:14.595328,15.2335643" target="_blank" role="button">Open in app</a>
				</div>
    		</div>
  		</div>
	</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
