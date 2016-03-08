<?php

/**
 * Reposition sidebar on categories
 */

add_action( 'woocommerce_before_shop_loop', 'woocommerce_category_sidebar', 2 );

function woocommerce_category_sidebar() {
	if( is_shop() || is_product_category() || is_product_tag() ) {
		echo '<div class="shop-sidebar">';
		genesis_widget_area( 'store-sidebar');
		echo '</div>';
	}
}

remove_all_actions('woocommerce_sidebar', 999);

/**
 * Reposition sidebar on categories
 */

add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
	if ( is_product_category() ){
		global $wp_query;
		$cat = $wp_query->get_queried_object(); //gets category meta
		$termID = $cat->term_id; //gets termID
		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); //gets thumbnail ID
		$image = wp_get_attachment_url( $thumbnail_id ); //gets image thumbnail
		if ( $image ) {
			echo '<div class="category-hero">';
			echo '<img src="' . $image . '" alt="" />';
			echo '<pre>';
			var_dump($cat);

			echo '</pre>';

			the_field('category_page_top_description', 'product_cat_'.$termID); //gets the ACF field and displays it.
			echo '</div>';


		}


	}
}