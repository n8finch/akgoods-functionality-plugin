<?php

/*
Plugin Name: Artisan Kraft Functionality Plugin
Plugin URI: http://www.finchproservices.com
Description: All custom functionality that has been added to this site that should NOT go in the functions.php or other theme files.
Author: Nate Finch
Author URI: http://www.finchproservices.com
Version: 1.0.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/


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
 * Reposition sidebar on single products
 */

add_action( 'woocommerce_sidebar', 'woocommerce_single_product_sidebar', 2 );
function woocommerce_single_product_sidebar() {
	if( is_product() ) {
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




