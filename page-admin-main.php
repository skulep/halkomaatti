<?php echo do_shortcode ( '[need_login]' ); ?>

<?php
/*
Template Name: Admin Main

fireb shortcode <?php echo do_shortcode ( '[custom_firebase]' ); ?>


		<div class="notif-holder">
			<div class="text-center">
				<a href="https://firewood2go.eu/index.php/admin-notifications/" class="btn btn-primary btn-lg text-center justify-content-center" role="button" aria-disabled="true">All notifications</a>
			</div>

		</div>
*/



get_header('admin');
?>


<main id="primary" class="site-main">

		<div class="container pt-2">
			<div class="row">
				<div class="col">
					<div class="weather-card one">
						<div class="top">
							<div class="wrapper">
								<div class="mynav">
									<button class="dd-button"><span class="lnr lnr-chevron-down"></span></button>;
									<div id="myDropdown" class="dropdown-content" style="display: none;">
									</div>
								</div>
							<h1 id="deviceName" class="heading">Example</h1>
							<h3 id="organizationName" class="location">Use the top right menu to select a location ->></h3>
							<p class="temp">
								<span id="batteryValue" class="temp-value">95%</span>
							</p>
							<h3 id="streetName" class="location pb-2">Ex Street 103</h3>
							<h3 id="boxesState" class="location pb-2">Active Boxes: 0/20</h3>
							<hr>
							<div class="notif-holder"></div>
							</div>
				
							
							
						</div>
					</div>
				</div>
			</div>
		</div>
</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');