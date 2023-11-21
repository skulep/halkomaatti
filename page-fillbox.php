<?php echo do_shortcode ( '[need_login]' ); ?>

<?php global $current_user;
wp_get_current_user();
$user_name = $current_user->user_login;
$user_email = $current_user->user_email;
?>

<script type="text/javascript">
	var username = <?php echo json_encode($user_name) ?> ;
	var useremail = <?php echo json_encode($user_email) ?> ;

	console.log(username);
	console.log(useremail);

	//See if a firebase connection is possible -- if so

	if (username == 'filler') {
		console.log('Authorized to fill');
	}
	else {
		alert("This user is unauthorized to fill in this location.");
		window.open("https://firewood2go.eu/index.php/admin-main/","_self");
	}

</script>


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

	<!----------
	<div class="row pt-5">
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn fill-button empty btn-outline-grey-border btn-rounded-square">1</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn fill-button empty btn-outline-grey-border btn-rounded-square">2</button>
		</div>
		<div class="col d-flex justify-content-center">
			<button type="button" class="btn fill-button faulty btn-outline-grey-border btn-rounded-square">3</button>
		</div>
  	</div>

	//href for below
	href="https://localhost/wordpress"
	---------->

	<div class="row pt-5 ttfield">
 
  	</div>

</div>

<div class="form-group">
	<label for="message-field">Message (optional)</label>
	<textarea class="form-control" id="message-field" rows="3"></textarea>
</div>

<!----- Not priority but make a field required here -->
<select class="form-select" id="class-select" aria-label="Default select example">
	<option selected value="primary">Select dispenser state</option>
	<option value="success">OK</option>
	<option value="primary">Box filled with no issues</option>
	<option value="warning">Minor issues</option>
	<option value="danger">Major issues</option>
</select>

<a class="w-100 btn confirm-fill btn-lg btn-primary pb-5" id="confirm-fill" role="button"  type="button">Mark as filled</a> 

</main>    


<?php
get_sidebar();
get_footer('admin');
