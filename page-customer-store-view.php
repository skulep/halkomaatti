<?php
/*
Template Name: Customer Store View
*/

get_header('customer');
?>

	<main id="primary" class="site-main">

		<div class="row w-100 box-info-box">
			<div class="col-lg-8">
				<iframe
				src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1683.6863634062288!2d25.551695752358476!3d65.03934838392831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4681d2cf3d4cd4a9%3A0x186f4dca5379003d!2sK-Citymarket%20Oulu%20Rusko!5e0!3m2!1sfi!2sfi!4v1679042615737!5m2!1sfi!2sfi"
				class="w-100" height="500" allowfullscreen="" loading="lazy"></iframe>
			</div>
			<div class="col-lg-2 my-2 d-flex align-items-center">
				<div>
					<h6>Location info:</h6>
					<h5>Tuira</h5>
					<h6>Example Street Name</h6>
					<h6>Oulu, Finland</h6>
					<h6>14.595328, 15.2335643</h6>
				</div>
			</div>
		</div>


		<!-- List of items -->

		<!-- Stack the columns on mobile by making one full-width and the other half-width -->

		<h5 class="text-center">Items and services</h5>

		<div class="row img-container">
			<div class="col-12 col-md-8">
				<button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
					<img src="https://images.pexels.com/photos/235964/pexels-photo-235964.jpeg?cs=srgb&dl=pexels-pixabay-235964.jpg&fm=jpg" alt="Firewood Large" class="img-thumbnail store-thumbnail">
				</button>
			</div>
			<div class="col-6 col-md-4">
				<img src="https://thumbs.dreamstime.com/b/firewood-9635309.jpg" alt="Firewood Small" class="img-thumbnail store-thumbnail">
			</div>
		</div>

		
		<div class="row img-container">
			<div class="col-6 col-md-4"><img src="https://img.freepik.com/free-vector/vector-opened-box-brown-matches-isolated-gray-background_1284-46510.jpg" alt="Matches" class="img-thumbnail store-thumbnail"></div>
			<div class="col-6 col-md-4"><img src="https://cdn.pixabay.com/photo/2015/01/18/14/16/phone-603048__480.jpg" alt="Device Charging" class="img-thumbnail store-thumbnail"></div>
			<div class="col-6 col-md-4"><img src="https://thumbs.dreamstime.com/b/female-hands-hold-hand-warmers-isolated-background-169670365.jpg" alt="Hand Warmers" class="img-thumbnail store-thumbnail"></div>
		</div>

		
		<div class="row img-container">
			<div class="col-6">Placeholder Div</div>
			<div class="col-6">Placeholder Div</div>
		</div>
		

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Firewood</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        A bag of firewood containing 10 logs of the finest wood.
      </div>
      <div class="modal-footer">
		<div class="col-md-4"><h5 class="align-left">9,99€</h5></div>
		<h6 class="">Amount</h6>
        <div class="form-group col-md-2">
			<select id="inputState" class="form-control">
				<option selected>1</option>
				<option>2</option>
				<option>3</option>
			</select>
		</div>
        <button type="button" class="btn btn-primary close" data-dismiss="modal">Add to Cart</button>
      </div>
    </div>
  </div>
</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
