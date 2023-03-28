<?php
/*
Template Name: Admin Fill Box

p class: h3 mb-3 fw-normal
*/

get_header();
?>

<main class="form-signin w-150 m-auto">
  <form>
    <h4 class="h3 mb-3 fw-normal">Tuira</h4>
	<p class="">Oulu, Finland</p>
	<p class="">53.6346, 353.6443</p>

    <div class="form-floating pb-2">
		<input type="number" class="form-control" id="typeNumber" placeholder="number">
		<label for="typeNumber">Firewood filled</label>
    </div>

	

	<div class="row">
		<p class="">Additional items added:</p>
		<div class="form-group col-md-4">
			<label for="inputState">Matches</label>
			<select id="inputState" class="form-control">
				<option selected>-</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label for="inputState">Batteries</label>
			<select id="inputState" class="form-control">
				<option selected>-</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
			</select>
		</div>
		<div class="form-group col-md-4">
			<label for="inputState">Paper</label>
			<select id="inputState" class="form-control">
				<option selected>-</option>
				<option>1</option>
				<option>2</option>
				<option>3</option>
		</select>
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
	<a class="w-100 btn btn-lg btn-primary" href="http://localhost/wordpress" role="button">Mark as filled</a> 
  </form>
</main>    

<?php
get_sidebar();
get_footer();
