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
remove_action( 'woocommerce_single_product_summary', array( 'YITH_Woocompare_Helper', 'add_compare_link' ), 35 );
// from /yith-woocommerce-compare/includes/class.yith-woocompare-frontend.php

add_action( 'woocommerce_product_thumbnails', 'add_social_compare_wishlist_buttons' );
function add_social_compare_wishlist_buttons() {
	if ( is_product() ) {
		echo '<div class="social-compare-wishlist-section">
					<span class="social-share-text">Share: </span>
					<a href="http://www.facebook.com/sharer.php?u=' . get_permalink( $post->ID ) . '" target="_blank"><span class="fa fa-facebook fa-2x"></span></a>
					<a class="twitter" href="https://twitter.com/intent/tweet?url=' . get_permalink( $post->ID ) . '%2F&text=Check%20this%20out:%20&via=AKGHome" target="_blank"><span class="fa fa-twitter fa-2x"></span></a>
					<a data-pin-do="buttonPin" data-pin-count="above" href="https://www.pinterest.com/pin/create/button/?url=https%3A%2F%2Fakgoods.com&media=' . wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) . '&description=Check%20this%20out!" target="_blank"><span class="fa fa-pinterest fa-2x"></span></a>
					<a href="https://plus.google.com/share?url=' . get_permalink( $post->ID ) . '" target="_blank"><span class="fa fa-google-plus fa-2x"></span></a>
					<a href="mailto:?Subject=Thought you might like to see this...&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 https://akgoods.com"><span class="fa fa-envelope fa-2x"></span></a>
				</div>';


	}
}

add_action( 'woocommerce_after_add_to_cart_button', 'add_extra_fields_to_single_product' );
function add_extra_fields_to_single_product() {

	global $wp_query;
	$post_excerpt = $wp_query->get_queried_object()->post_excerpt;

	$fields_array     = get_fields( $post->ID );
	$shape_field      = $fields_array['wpcf-shape'];
	$material_field   = $fields_array['wpcf-material'];
	$dimensions_field = $fields_array['wpcf-dimensions'];
	$finish_field     = $fields_array['wpcf-finish'];
	$technical_field  = $fields_array['wpcf-technical-information'];


	echo '<div class="accordion" id="product-description-accordion">
            <h3>Product Description</h3>
            <div itemprop="description">
              <p>' . $post_excerpt .'</p>
            </div>
            <h3>Shape</h3>
            <div>
              <p>' . $shape_field . '
              </p>
            </div>
            <h3>Material Options</h3>
            <div>
              <p>' . $material_field . '
              </p>
            </div>
            <h3>Dimensions</h3>
            <div>
              <p>' . $dimensions_field . '
              </p>
            </div>
            <h3>Finish</h3>
            <div>
              <p>' . $finish_field . '
              </p>
            </div>
            <h3>Technical Information</h3>
            <div>
              <p>' . $technical_field . '
              </p>
            </div>
            <h3>Enquire About This Product</h3>
            <div>
              <p>
              </p>
            </div>

          </div>';
}


/**
 * Remove Reviews from Single Products
 */

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab( $tabs ) {
	unset( $tabs['reviews'] );

	return $tabs;
}