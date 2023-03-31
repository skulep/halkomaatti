<?php
/*
Template Name: Customer Home Page

	<main id="primary" class="site-main">
		<div class="">
			<img src="https://img.freepik.com/free-photo/river-surrounded-by-forests-cloudy-sky-thuringia-germany_181624-30863.jpg?w=1380&t=st=1679647986~exp=1679648586~hmac=3d3071b4c5e43aba1721ff57426f53a7a99857dd14719f6cd14f7a49988680cd" class="img-fluid" width="100%">
			<p class="text-on-img text-center">In need of wood? Halkomaatti has you covered!</p>
		</div>
*/

get_header('customer');
?>


<div class="banner"> <img src="https://img.freepik.com/free-photo/river-surrounded-by-forests-cloudy-sky-thuringia-germany_181624-30863.jpg?w=1380&t=st=1679647986~exp=1679648586~hmac=3d3071b4c5e43aba1721ff57426f53a7a99857dd14719f6cd14f7a49988680cd">
	<div class="container">
		<div class="home_slider_content"  data-animation-in="fadeIn" data-animation-out="animate-out fadeOut">
			<div class="home_slider_title text-on-img">In need of wood? Halkomaatti has you covered!</div>
		</div>
	</div>
</div>

<div class="vstack gap-3 col-md-8 mx-auto mt-5">		
	<a href="http://localhost/wordpress/customer-store-view/" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Tuira (94 km)</a>
	<a href="http://localhost/wordpress/customer-store-view/" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Niittylä (150 km)</a>
	<a href="http://localhost/wordpress/customer-store-view/" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Location 3 (222 km)</a>
	<a href="http://localhost/wordpress/customer-store-view/" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Location 4 (390 km)</a>
</div>


	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
