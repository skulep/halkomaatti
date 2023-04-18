<?php
/*
Template Name: Customer Home Page

	<main id="primary" class="site-main">
		<div class="">
			<img src="https://img.freepik.com/free-photo/river-surrounded-by-forests-cloudy-sky-thuringia-germany_181624-30863.jpg?w=1380&t=st=1679647986~exp=1679648586~hmac=3d3071b4c5e43aba1721ff57426f53a7a99857dd14719f6cd14f7a49988680cd" class="img-fluid" width="100%">
			<p class="text-on-img text-center">In need of wood? Halkomaatti has you covered!</p>
		</div>

		<div class="banner"> 
	<div class="banner-img" style="max-height: 550px">
	<div class="container">
		<div class="home_slider_content"  data-animation-in="fadeIn" data-animation-out="animate-out fadeOut">
			<div class="home_slider_title text-on-img">In need of wood? Halkomaatti has you covered!</div>
		</div>
	</div>
</div>
*/

get_header('customer');
?>



<div class="banner d-none d-sm-block"> 
<img src="https://img.freepik.com/free-photo/river-surrounded-by-forests-cloudy-sky-thuringia-germany_181624-30863.jpg?w=1380&t=st=1679647986~exp=1679648586~hmac=3d3071b4c5e43aba1721ff57426f53a7a99857dd14719f6cd14f7a49988680cd" style="width: 100%">
	<div class="container">
		<div class="home_slider_content">
			<div class="home_slider_title text-on-img">In need of wood?<br>Halkomaatti has you covered!</div>
		</div>
	</div>
</div>

<h4 class="d-sm-none text-center">In need of wood?<br>Halkomaatti has you covered!</h4>

<div class="vstack gap-3 col-md-8 mx-auto mt-5">
	<h5 class="text-center">List of Locations</h5>	
	<a href="http://localhost/wordpress/customer-store-view/" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Tuira (94 km)</a>
	<a href="http://localhost/wordpress/customer-store-view/" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Niittylä (150 km)</a>
	<a href="http://localhost/wordpress/customer-store-view/" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Location 3 (222 km)</a>
	

	<div class="btn-group">
		<button type="button" class="btn btn-secondary btn-lg dropdown-toggle border border-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			All Locations
		</button>

  		<div class="dropdown-menu">
    		<a class="dropdown-item" href="#">Tuira</a>
			<div class="dropdown-divider"></div>
    		<a class="dropdown-item" href="#">Niittylä</a>
			<div class="dropdown-divider"></div>
    		<a class="dropdown-item" href="#">Location3</a>
  		</div>
	</div>

</div>


	</main><!-- #main -->

<?php
get_sidebar();
get_footer();