<?php

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




add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) {
	unset($tabs['reviews']);
	return $tabs;
}