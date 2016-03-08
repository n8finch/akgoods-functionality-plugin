<?php

/**
 * Reposition sidebar on categories
 */

add_action( 'woocommerce_archive_description', 'woocommerce_category_sidebar', 2 );

function woocommerce_category_sidebar() {
	if( is_shop() || is_product_category() || is_product_tag() ) {
		echo '<div class="shop-sidebar">';
		genesis_widget_area( 'store-sidebar');
		echo '</div>';
	}
}



/**
 * Reposition sidebar on categories
 */

add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
	if ( is_product_category() ){
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		if ( $image ) {
			echo '<div class="category-hero">';
			echo '<img src="' . $image . '" alt="" />';
			echo '<pre>';
			var_dump($cat->description);
			echo '</pre>';
			echo '</div>';
		}


	}
}