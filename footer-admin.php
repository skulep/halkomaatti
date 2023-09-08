<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Halko
 */

?>

	<footer id="colophon" class="site-footer">
	<div class="bottom-nav-bar fixed-bottom pt-2 pb-2">
		<div class="container">
			<div class="row">
				<div class="col-md-14 d-flex justify-content-center">
					<ul class="bottom-nav-bar-list">
						<li>	
							<a class="btn btn-primary" href="https://firewood2go.eu/index.php/admin-main/" role="button">
								Home <i class="bi bi-house-door"></i>  
							</a>
						</li>

						<li>
							<a class="btn btn-primary" href="https://firewood2go.eu/index.php/admin-box-info/" role="button">
								Dispensers <i class="bi bi-box-seam"></i> 
							</a>
								
						</li>

						<li>
							<a class="btn btn-primary" href="https://firewood2go.eu/index.php/admin-notifications/" role="button">
								Notifications <i class="bi bi-bell"></i>
							</a>
						</li>

					</ul>
				</div>
			</div>
		</div>	
	</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
