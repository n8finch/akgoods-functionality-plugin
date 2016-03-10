<?php

/**
 * Reposition sidebar on single products
 */

add_action( 'woocommerce_sidebar', 'woocommerce_single_product_sidebar', 2 );
function woocommerce_single_product_sidebar() {
	if ( is_product() ) {
		echo '<div class="shop-sidebar">';
		genesis_widget_area( 'store-sidebar' );
		echo '</div>';
	}
}

/**
 * Add sub-title to Product Page
 */

add_action( 'woocommerce_single_product_summary', 'woocommerce_single_product_subtitle', 6 );
function woocommerce_single_product_subtitle() {
	if ( is_product() ) {
		echo '<h3 class="single_product_subtitle">' . the_field( 'single_product_subtitle' ) . '</h3>';
	}
}


/**
 * Move Compare and Wishlist buttons
 */
// remove add_action( 'woocommerce_single_product_summary', array( $this, 'add_compare_link' ), 35 );
// from /yith-woocommerce-compare/includes/class.yith-woocompare-frontend.php

add_action( 'woocommerce_product_thumbnails', 'add_social_compare_wishlist_buttons' );
function add_social_compare_wishlist_buttons() {
	if ( is_product() ) {
		echo '<div class="social-compare-wishlist-section">
					<span class="social-share">Share: </span>
					<a href="https://instagram.com" target="_blank"><span class="fa fa-instagram fa-2x"></span></a>
					<a href="http://www.facebook.com/sharer.php?u='.get_permalink( $post->ID ).'" target="_blank"><span class="fa fa-facebook fa-2x"></span></a>
					<a class="twitter" href="https://twitter.com/intent/tweet?url=' . get_permalink( $post->ID ) . '%2F&text=Check%20this%20out:%20&via=AKGHome" target="_blank"><span class="fa fa-twitter fa-2x"></span></a>
					<span class="fa fa-pinterest fa-2x"></span>
					<a href="https://plus.google.com/share?url='.get_permalink( $post->ID ).'" target="_blank"><span class="fa fa-google-plus fa-2x"></span></a>
					<a href="mailto:?Subject=Thought you might like to see this...&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 https://akgoods.com"><span class="fa fa-envelope fa-2x"></span></a>
				</div>';
	}
}


/**
 * Remove Reviews from Single Products
 */

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab( $tabs ) {
	unset( $tabs['reviews'] );

	return $tabs;
}