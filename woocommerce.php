<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Halko
 */

get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">

			<?php
				// Check if it's a product category page
				if (is_product_category()) {
					$google_map = get_field('google_maps_category_page_embed', get_queried_object());

					if ($google_map) {
						echo '<div class="category-google-map mb-2 border bg-primary">';
						echo '<iframe src="' . esc_url($google_map) . '" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="100%" height="320"></iframe>';
						echo '</div>';
					}
				}
				woocommerce_content();
			?>
		</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
