<?php
/*
Template Name: Admin Login
type="submit" -- button type
*/

get_header('admin');
?>


	<main class="form-signin w-100 m-auto">
  <form>
    <h1 class="h3 mb-3 fw-normal text-center">Halkomaatti</h1>

    <div class="form-floating">
		<input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
		<label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
		<input type="password" class="form-control" id="floatingPassword" placeholder="Password">
		<label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
		<label>
				<input type="checkbox" value="remember-me"> Remember me
		</label>
    </div>
	<a class="w-100 btn btn-lg btn-primary" href="https://firewood2go.eu/index.php/admin-main/" role="button">Log In</a> 
  </form>
</main>    

<?php
get_sidebar();
get_footer('admin');
