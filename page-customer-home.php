<?php
/*
Template Name: Customer Home Page


*/

get_header('customer');
?>



<div class="banner d-none d-sm-block"> 

	<div class="home-image" display="inline-block">
		<img src="https://images.pexels.com/photos/3225517/pexels-photo-3225517.jpeg" class="img-fluid" style="height: 350px; width: 100%; display: block;">
	</div>
	
	<div class="container">
		<div class="mask d-flex flex-column justify-content-center text-center" style="background-color: rgba(200,200,200,0.5); width: 250px">
			<div class="home_slider_title text-center text-light">
				<h4>In need of wood?<br>We have you covered!</h4>
			</div>
		</div>
	</div>
</div>

<h4 class="d-sm-none text-center pt-2">In need of wood?<br>We have you covered!</h4>

<div class="vstack gap-3 col-md-8 mx-auto mt-5">
	<h5 class="text-center">List of Locations</h5>	
	<a href="https://firewood2go.eu/index.php/customer-store-view/" class="btn btn-primary btn-lg active px-2" role="button" aria-pressed="true">Tuira (94 km)</a>
	<a href="https://firewood2go.eu/index.php/customer-store-view/" class="btn btn-secondary btn-lg active px-2" role="button" aria-pressed="true">Niittylä (150 km)</a>
	<a href="https://firewood2go.eu/index.php/customer-store-view/" class="btn btn-primary btn-lg active px-2" role="button" aria-pressed="true">Location 3 (222 km)</a>
	

	<div class="btn-group">
		<button type="button" class="btn btn-secondary btn-lg dropdown-toggle border border-2 px-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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