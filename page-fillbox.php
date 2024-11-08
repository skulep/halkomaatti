<?php echo do_shortcode ( '[need_login]' ); ?>

<?php global $current_user;
wp_get_current_user();
$user_name = $current_user->user_login;
$user_email = $current_user->user_email;
$user_roles = $current_user->roles;
$page_id = get_the_ID();

$allowed_roles = get_field('allowed_roles_list');


if (!empty($allowed_roles)) {
    // Convert the string of roles to an array. Note: uses comma as a separator
    $allowed_roles = explode(',', $allowed_roles);

    // Trim excess white space
    $allowed_roles = array_map('trim', $allowed_roles);

    // Check if the current user has any of the allowed roles
    $current_user = wp_get_current_user();
    $user_roles = $current_user->roles;

    $is_allowed = false;
	  $is_admin = in_array('administrator', $user_roles);

	//Check if user's role is allowed. Admin is always allowed, other roles need to be written down in Allowed Roles Field
    foreach ($allowed_roles as $role) {
        if (in_array($role, $user_roles) || $is_admin) {
            $is_allowed = true;
            break;
        }
    }

    if ($is_allowed) {
		//User is allowed -- load page normally.
        //echo do_shortcode('[need_login]');
    } else {
      $redirect_url = get_home_url() . '/admin-main/';
      echo '<script>alert("You are not authorized to view this page."); window.open("' . $redirect_url . '", "_self");</script>';
    }
} else {
	$redirect_url = get_home_url() . '/admin-main/';
  echo '<script>alert("You are not authorized to view this page."); window.open("' . $redirect_url . '", "_self");</script>';
}
?>

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
		<h4 id="rowLocation" class="h3 my-3 fw-normal text-center ">Placeholder</h4>
		<p id="rowCountry" class="text-center">Placeholder</p>
		<p id="rowCoords" class="text-center">Placeholder</p>
    
    <div class="text-center">
 
      <div class="container">
        <div class="row justify-content-md-center">
          <div class="col col-lg-2 pt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
              View Help
            </button>
          </div>
          <div class="col-lg-auto pt-2">
            
          </div>
          <div class="col col-lg-2 pt-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#openAllModal">
              Open All Boxes
            </button>
          </div>
        </div>
      </div>
    </div>
	</div>
<!---- We create button+select elements here using JS. 
	<div class="col">
		<p class="text-center">Info</p>
		<p class="text-center"><i class="bi bi-square-fill icon-green">  Filled Box</i></p>
		<p class="text-center"><i class="bi bi-square-fill icon-red">  Faulty Box</i></p>
		<p class="text-center"><i class="bi bi-square-fill icon-grey">  Empty Box</i></p>
		<p class="text-center">Tap the box to toggle</p>
	</div>---------->
</div>

<div class="container mt-2">
	<div class="row pt-2 ttfield">
		<!---- We create button+select elements here using JS. ---------->
  	</div>

</div>

<div class="form-group">
	<label for="message-field">Message (optional)</label>
	<textarea class="form-control" id="message-field" rows="3"></textarea>
</div>

<!----- Not priority but make a field required here -->
<select class="form-select w-100 mb-1" id="class-select" aria-label="Default select example">
	<option selected value="primary">Select device state</option>
	<option value="success">Perfect</option>
	<option value="primary">No major issues, but could use cleaning/other</option>
	<option value="warning">Minor issues (ex. one broken lock)</option>
	<option value="danger">Major issues (ex. multiple broken locks)</option>
</select>

<a class="w-100 btn confirm-fill btn-lg btn-primary mb-5" id="confirm-fill" role="button"  type="button">Mark as Filled</a> 

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Help</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center"><i class="bi bi-square-fill icon-green">  Filled Box</i></p>
        <p class="text-center"><i class="bi bi-square-fill icon-grey">  Empty Box</i></p>
        <p class="text-center"><i class="bi bi-square-fill icon-red">  Faulty Box</i></p>
        <p class="text-center">Tap the box to toggle. Select the item using the select option below the box.</p>
        <p class="text-center">Select device's state and click "Mark as Filled" to push your changes.</p>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="openAllModal" tabindex="-1" role="dialog" aria-labelledby="openAllModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="openAllModalLabel">Are you sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center">This may take a while, depending on how many locks there are to open.</p>
        <a class="w-100 btn confirm-fill btn-lg btn-primary mb-5" id="openBoxesButton" role="button" type="button" data-dismiss="modal">Open all boxes</a>
      </div>
    </div>
  </div>
</div>

</main>   


<?php
get_sidebar();
get_footer('admin');
