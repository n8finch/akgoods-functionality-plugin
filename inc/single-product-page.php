<?php

/**
 * Reposition sidebar on single products
 */


namespace single_product_page;


add_action( 'woocommerce_sidebar', __NAMESPACE__ . '\woocommerce_single_product_sidebar', 2 );
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

add_action( 'woocommerce_single_product_summary', __NAMESPACE__ . '\woocommerce_single_product_subtitle', 6 );
function woocommerce_single_product_subtitle() {
	if ( is_product() ) {
		echo '<h3 class="single_product_subtitle">' . the_field( 'single_product_subtitle' ) . '</h3>';

		global $wp_query;
		$post_excerpt = $wp_query->get_queried_object()->post_content;

		echo '<p>' . $post_excerpt . '</p>';


	}
}


/**
 * Add social sharing buttons
 */

add_action( 'woocommerce_product_thumbnails', __NAMESPACE__ . '\add_social_compare_wishlist_buttons', 25 );
function add_social_compare_wishlist_buttons() {
	if ( is_product() ) {
		echo '<div class="social-compare-wishlist-section">
					<span class="social-share-text">Share: </span>
					<a href="http://www.facebook.com/sharer.php?u=' . get_permalink( $post->ID ) . '" target="_blank"><span class="fa fa-facebook fa"></span></a>
					<a class="twitter" href="https://twitter.com/intent/tweet?url=' . get_permalink( $post->ID ) . '%2F&text=Check%20this%20out:%20&via=AKGHome" target="_blank"><span class="fa fa-twitter fa"></span></a>
					<a data-pin-do="buttonPin" data-pin-count="above" href="https://www.pinterest.com/pin/create/button/?url=https%3A%2F%2Fakgoods.com&media=' . wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ) . '&description=Check%20this%20out!" target="_blank"><span class="fa fa-pinterest fa"></span></a>
					<a href="https://plus.google.com/share?url=' . get_permalink( $post->ID ) . '" target="_blank"><span class="fa fa-google-plus fa"></span></a>
					<a href="mailto:?Subject=Thought you might like to see this...&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 https://akgoods.com"><span class="fa fa-envelope fa"></span></a>
				</div>';


	}
}

/**
 * Unregisters the add_compare_link for the YITH WooCompare plugin, adds it to under the social icons
 */

add_action( 'init', __NAMESPACE__ . '\unregister_yith_woocompare_add_compare_link' );

function unregister_yith_woocompare_add_compare_link() {
	if ( is_admin() ) {
		return;
	}
	global $yith_woocompare;

	remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
//	add_action( 'woocommerce_product_thumbnails', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
	add_action( 'woocommerce_after_add_to_cart_button', array( $yith_woocompare->obj, 'add_compare_link' ), 34 );


}

/**
 * Unregisters the add_compare_link for the YITH WooCompare plugin, adds it to under the
 */

add_action( 'woocommerce_product_thumbnails', __NAMESPACE__ . '\add_compare_and_wishlist_buttons_start', 34 );

function add_compare_and_wishlist_buttons_start() {

	echo '<div class="compare_and_wishlist_buttons">';

}

add_action( 'woocommerce_product_thumbnails', __NAMESPACE__ . '\add_compare_and_wishlist_buttons_end', 36 );

function add_compare_and_wishlist_buttons_end() {
	echo '</div>';
}

/**
 * Contact box above the extra product fields
 */

add_action( 'woocommerce_single_product_summary', __NAMESPACE__ . '\contact_box_above_custom_fields', 34 );

function contact_box_above_custom_fields() {

	$phone       = genesis_get_option( 'wsm_header_phone', 'jessica-settings' );
	$email       = genesis_get_option( 'wsm_header_email', 'jessica-settings' );

	echo '<div class="knowledgeable-team-container">';
	echo '<p>Our knowledgeable team is here to help with a phone and email.</p>';
	echo '<span class="knowledgeable-team fa fa-phone"></span><span class="knowledgeable-team-phone"> '.$phone.'</span> | ';
	echo '<span class="knowledgeable-team fa fa-envelope"></span> '.$email.' ';
	echo '</div>';

}

add_action( 'woocommerce_single_product_summary', __NAMESPACE__ . '\add_extra_fields_to_single_product', 35 );
function add_extra_fields_to_single_product() {

	global $wp_query;
	$post_excerpt = $wp_query->get_queried_object()->post_excerpt;

	$fields_array     = get_fields( $post->ID );
	$shape_field      = $fields_array['wpcf-shape'];
	$material_field   = $fields_array['wpcf-material'];
	$dimensions_field = $fields_array['wpcf-dimensions'];
	$finish_field     = $fields_array['wpcf-finish'];
	$technical_field  = $fields_array['wpcf-technical-information'];

//	Just in case I misunderstood the Shape dropdown.
//	<div class="single-product-custom-fields-titles" data-toggle="shape"><h3>Shape <span class="fa-float-right fa fa-chevron-down"></span></h3></div>
//            <div id="shape" class="single-product-custom-fields">' . $shape_field . '
//            </div>


	echo '<div class="accordion" id="product-description-accordion">
            <div class="single-product-custom-fields-titles" data-toggle="product-description"><h3>Product Description <span class="fa-float-right fa fa-chevron-down"></span></h3></div>
            <div id="product-description" class="single-product-custom-fields"><p>' . $post_excerpt . '</p>
            </div>
            <div class="single-product-custom-fields-titles" data-toggle="material-options"><h3>Material Options <span class="fa-float-right fa fa-chevron-down"></span></h3></div>
            <div id="material-options" class="single-product-custom-fields">';
	// . $material_field;

	wp_nav_menu( array('menu' => $material_field ) );

	echo '</div>
            <div class="single-product-custom-fields-titles" data-toggle="dimensions"><h3>Dimensions <span class="fa-float-right fa fa-chevron-down"></span></h3></div>
            <div id="dimensions" class="single-product-custom-fields">' . $dimensions_field . '
            </div>
            <div class="single-product-custom-fields-titles" data-toggle="finsih"><h3>Finish <span class="fa-float-right fa fa-chevron-down"></span></h3></div>
            <div id="finsih" class="single-product-custom-fields">';
	wp_nav_menu( array('menu' => $finish_field ) );

	echo '</div>          
            <div class="single-product-custom-fields-titles" data-toggle="technical-information"><h3>Technical Information <span class="fa-float-right fa fa-chevron-down"></span></h3></div>
            <div id="technical-information" class="single-product-custom-fields">';
	wp_nav_menu( array('menu' => 'Technical Information' ) );

	echo '</div>           
            <div class="single-product-custom-fields-titles" data-toggle="enquire-about-this"><h3>Enquire About This Product <span class="fa-float-right fa fa-chevron-down"></span></h3></div>
            <div id="enquire-about-this" class="single-product-custom-fields">';
	echo do_shortcode( '[contact-form-7 id="3450" title="Single Product Inquiry"]' );
	echo '</div>

          </div>';
}


/**
 * Remove and Add Pair With
 */


add_action( 'init', __NAMESPACE__ . '\reposition_pair_with_section' );
function reposition_pair_with_section() {
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

}

add_action( 'akg_woocommerce_footer', 'woocommerce_upsell_display' );


/**
 * Remove Reviews from Single Products
 */

add_filter( 'woocommerce_product_tabs', __NAMESPACE__ . '\wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab( $tabs ) {
	unset( $tabs['reviews'] );

	return $tabs;
}