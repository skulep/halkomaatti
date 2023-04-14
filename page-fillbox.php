<?php
/*
Template Name: Admin Fill Box

p class: h3 mb-3 fw-normal
*/

get_header('admin');
?>

<main class="container">

    <h4 class="h3 mb-3 fw-normal">Tuira</h4>
	<p class="">Oulu, Finland</p>
	<p class="">53.6346, 353.6443</p>

    <button type="button" class="btn btn-defaultfont">Info</button>

<div class="container">
	<p class="text-center">All Boxes</p>

	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-bs-whatever="@getbootstrap">Open modal for @getbootstrap</button>


  	<div class="row pt-5">
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">1
				<br>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
				</div>
			</button>
			
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
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">6</button>
		</div>
  	</div>

	  <div class="row pt-5 pb-5">
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">7</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">8</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn btn-outline-grey-border btn-rounded-square">9</button>
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


<!---- On-click Modal --->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title" id="exampleModalLabel1">New message</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
				<form>
					<div class="mb-3">
						<label for="recipient-name" class="col-form-label">Recipient:</label>
						<input type="text" class="form-control" id="recipient-name">
					</div>
					<div class="mb-3">
						<label for="message-text" class="col-form-label">Message:</label>
						<textarea class="form-control" id="message-text"></textarea>
					</div>
				</form>
      		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Send message</button>
			</div>
    	</div>
	</div>
</div>

</main>    





<?php
get_sidebar();
get_footer('admin');
