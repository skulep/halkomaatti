<?php
/*
Template Name: Admin Fill Box

p class: h3 mb-3 fw-normal
*/

get_header('admin');
?>

<main class="container">

<div class="row flex">
	<div class="col">
		<h4 class="h3 my-3 fw-normal text-center ">Tuira</h4>
		<p class="text-center">Oulu, Finland</p>
		<p class="text-center">53.6346, 353.6443</p>
	</div>

	<div class="col">
		<p class="text-center">Info</p>
		<p class="text-center"><i class="bi bi-square-fill icon-green">  Filled Box</i></p>
		<p class="text-center"><i class="bi bi-square-fill icon-red">  Faulty Box</i></p>
		<p class="text-center"><i class="bi bi-square-fill icon-grey">  Empty Box</i></p>
		<p class="text-center">Tap the box to toggle</p>
	</div>
</div>

<div class="container">

  	<div class="row pt-5">
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">1</button>
			
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">2</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">3</button>
		</div>
  	</div>

	  <div class="row pt-5">
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">4</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">5</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-primary btn-rounded-square">6</button>
		</div>
  	</div>

	  <div class="row pt-5 pb-5">
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn1 btn-primary btn-rounded-square">7</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">8</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" id="btn-fill" class="btn btn-danger btn-rounded-square">9</button>
		</div>
  	</div>

</div>

<div class="form-group">
	<label for="exampleFormControlTextarea1">Message (optional)</label>
	<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>

<div class="checkbox mb-3">
	<label>
		<input type="checkbox" value="remember-me"> Mark as important/critical
	</label>
</div>

<a class="w-100 btn btn-lg btn-primary pb-5" href="http://localhost/wordpress" role="button">Mark as filled</a> 

</main>    





<?php
get_sidebar();
get_footer('admin');
