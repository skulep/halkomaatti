<?php
/**
 * The header visible for customers.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Halko
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'halko' ); ?></a>



<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #42F1BD">
  	<a class="navbar-brand" href="http://localhost/wordpress/customer">Halkomaatti</a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
  	</button>
  	<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    	<div class="navbar-nav display-flex">
		<button class="btn dropdown-toggle me-auto" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="bi bi-pin-map"></i> Locations
  		</button>
			<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				<a class="dropdown-item" href="http://localhost/wordpress/customer-store-view/">Tuira</a>
				<a class="dropdown-item" href="http://localhost/wordpress/customer-store-view/">Sijainti2</a>
				<a class="dropdown-item" href="http://localhost/wordpress/customer-store-view/">Sijainti3</a>
			</div>
			<a class="btn nav-item me-auto p-2" type="button" href="http://localhost/wordpress/cart/"><i class="bi bi-cart3"></i> Cart (<?php echo WC()->cart->get_cart_contents_count() ?>) </a>
			<a class="btn nav-item nav-link me-auto p-2" type="button" href="http://localhost/wordpress/customer-info/"><i class="bi bi-info-circle"></i> About</a>
    	</div>
  	</div>
</nav>


	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$halko_description = get_bloginfo( 'description', 'display' );
			if ( $halko_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $halko_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'halko' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	