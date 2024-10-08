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

	<nav class="navbar navbar-expand-lg navbar-light px-2">
    <a class="navbar-brand" href="<?php echo get_home_url(); ?>">Vedogvarer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav w-100">
            <div class="dropdown">
                <button class="btn dropdown-toggle me-auto" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-pin-map"></i> Locations
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="background-color: rgba(166, 228, 194, 1)">
                    <?php
                    $taxonomy     = 'product_cat';
                    $orderby      = 'name';  
                    $show_count   = 0;      
                    $pad_counts   = 0;      
                    $hierarchical = 1;      
                    $title        = '';  
                    $empty        = 0;

                    $args = array(
                        'taxonomy'     => $taxonomy,
                        'orderby'      => $orderby,
                        'show_count'   => $show_count,
                        'pad_counts'   => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li'     => $title,
                        'hide_empty'   => $empty
                    );
                    $all_categories = get_categories( $args );
                    foreach ($all_categories as $cat) {
                        if($cat->category_parent == 0) {
                            $category_id = $cat->term_id;

                            $args2 = array(
                                'taxonomy'     => $taxonomy,
                                'child_of'     => 0,
                                'parent'       => $category_id,
                                'orderby'      => $orderby,
                                'show_count'   => $show_count,
                                'pad_counts'   => $pad_counts,
                                'hierarchical' => $hierarchical,
                                'title_li'     => $title,
                                'hide_empty'   => $empty
                            );
                            $sub_cats = get_categories( $args2 );
                            if($sub_cats) {
                                foreach($sub_cats as $sub_category) {
                                    echo '<a class="dropdown-item" href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a>';
                                }
                            }
                        }       
                    }
                    ?>
                </div>
            </div>

			<div>
				<a class="btn nav-item me-auto p-2" type="button" href="<?php echo get_home_url(); ?>/index.php/cart/">
					<i class="bi bi-cart3"></i> Cart (<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)
				</a>
			</div>	
            <div>
				<a class="btn nav-item me-auto p-2" type="button" href="<?php echo get_home_url(); ?>/index.php/customer-info/">
					<i class="bi bi-info-circle"></i> About 
				</a>
			</div>
			<div>
				<a class="btn nav-item me-auto p-2" type="button" href="<?php echo get_home_url(); ?>/index.php/legal/">
					<i class="bi bi-bank2"></i> Legal 
				</a>
			</div>
            
            <!-- Wrapper for alignment -->
            <div class="ml-auto">
                <a class="btn nav-item nav-link p-2" type="button" href="<?php echo get_home_url(); ?>/index.php/admin-main/">
                    Log In <i class="bi bi-person-gear"></i>
                </a>
            </div>
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

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var dropdownItems = document.querySelectorAll('.dropdown-item');
			dropdownItems.forEach(function (item) {
				item.addEventListener('click', function (e) {
					e.preventDefault();
					window.location.href = this.href;
				});
			});
		});
	</script>