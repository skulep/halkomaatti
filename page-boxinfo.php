<?php echo do_shortcode ( '[need_login]' ); ?>

<?php
/*
Template Name: Admin Box Info
*/

get_header('admin');
?>

	<main id="primary" class="site-main">


		<div class="row">
			<div class="col-lg-8">
				<div class="container" id="container">
					<h1 class="pb-5">Device List</h1>
				</div>
			</div>
		</div>



	</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');
