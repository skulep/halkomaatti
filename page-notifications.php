<?php echo do_shortcode ( '[need_login]' ); ?>

<?php
/*
Template Name: Admin Notifications
*/


get_header('admin');
?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
		<div class="notif-holder">
			<h2 class="text-center py-3">All Notifications</h2>

			<div class="alert row alert-primary" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Lockers refilled completely
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-success" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Battery swapped
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-warning" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Locker #21 is stuck
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-danger" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Battery #1 is empty, device is turning off shortly
				</div>
				<div class="col-md-2">
					20.2.2022
				</div>
			</div>
			


			<div class="alert row alert-primary" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Lockers refilled completely
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-success" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Battery swapped
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-warning" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Locker #21 is stuck
				</div>
				<div class="col-md-2 align-right">
					20.2.2022
				</div>
			</div>

			<div class="alert row alert-danger" role="alert">
				<div class="col-md-2">
					<strong>Tuira</strong>
				</div>
				<div class="col-md-8">
					Battery #1 is empty, device is turning off shortly
				</div>
				<div class="col-md-2">
					20.2.2022
				</div>
			</div>

		</div>
		
		
	</main><!-- #main -->

<?php
get_sidebar();
get_footer('admin');
