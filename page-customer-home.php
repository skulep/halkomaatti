<?php
/*
Template Name: Customer Home Page


*/

get_header('customer');
?>



<div class="banner d-none d-sm-block"> 

	<div class="home-image" display="inline-block">
		<img src="https://images.pexels.com/photos/3225517/pexels-photo-3225517.jpeg" class="img-fluid" style="height: 350px; width: 100%; display: block;">
	</div>
	
	<div class="container d-flex justify-content-center">
		<div class="mask d-flex flex-column justify-content-center text-center" style="background-color: rgba(255,255,255,0.5); width: 250px">
			<h4 class="text-center">In need of wood?<br>We have you covered!</h4>
		</div>
	</div>
</div>

<h4 class="d-sm-none text-center pt-2 ">In need of wood?<br>We have you covered!</h4>

<div class="vstack gap-3 col-md-8 mx-auto mt-5">
	<h5 class="text-center">List of Locations</h5>	
	<?php

	$taxonomy     = 'product_cat';
	$orderby      = 'name';  
	$show_count   = 0;      // 1 for yes, 0 for no
	$pad_counts   = 0;      // 1 for yes, 0 for no
	$hierarchical = 1;      // 1 for yes, 0 for no  
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
			#echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';
			#We do not want to show the main categories here.

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
					$val = 0;
					foreach($sub_cats as $sub_category) {
						if($val == 0) {
							echo  '<br/><a class="btn btn-primary btn-lg active px-2" role="button" aria-pressed="true" href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a>';
							$val = 1;
						}
						else
						{
							echo  '<br/><a class="btn btn-secondary btn-lg active px-2" role="button" aria-pressed="true" href="'. get_term_link($sub_category->slug, 'product_cat') .'">'. $sub_category->name .'</a>';
							$val = 0;
						}
						
					}
				}
		}       
	}
	?>


</div>


	</main><!-- #main -->

<?php
get_sidebar();
get_footer();