<?php

/**
 * Reposition sidebar on categories
 */

remove_action( 'genesis_before_sidebar_widget_area', 'jessica_child_do_sidebar', 999 );

add_action( 'woocommerce_before_shop_loop', 'woocommerce_category_sidebar', 2 );

function woocommerce_category_sidebar() {
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		echo '<div class="shop-sidebar">';
		genesis_widget_area( 'store-sidebar' );
		echo '</div>';
	}
}

/**
 * Add Category Name and SEO description to top of category page
 */

add_action( 'woocommerce_before_main_content', 'add_category_title_and_description_to_page', 30 );

function add_category_title_and_description_to_page() {
	if ( is_product_category() ) {
		global $wp_query;
		$cat         = $wp_query->get_queried_object();
		$cat_name    = $cat->name; //gets termID
		$termID      = $cat->term_id; //gets termID
		$topSEOfield = get_field( 'category_page_top_seo_description', 'product_cat_' . $termID );

		echo '<div class="category-header">
				<h2 class="category-header-name">' . $cat_name . '</h2>' .
		     '<p class="category-header-description">' . $topSEOfield . '</p></div>';
	}
}


/**
 * Add Catalog ordering Function
 */

add_action( 'woocommerce_before_shop_loop', 'start_sorting_container', 26 );

function start_sorting_container() {

	if ( ! woocommerce_products_will_display() ) :
		return;
	endif;

	echo '<div class="start_sorting_container">';
}

add_action( 'woocommerce_before_shop_loop', 'do_the_woocommerce_sorting_container', 28 );

function do_the_woocommerce_sorting_container() {

	if ( ! woocommerce_products_will_display() ) :
		return;
	endif;

//	if ( is_product_category() ) {
//		echo '<div class="start_sorting_container">';
	woocommerce_catalog_ordering();
//		echo '</div> <!--end-->';
//	}
}

add_action( 'woocommerce_before_shop_loop', 'end_sorting_container', 30 );

function end_sorting_container() {

	if ( ! woocommerce_products_will_display() ) :
		return;
	endif;

	echo '</div> <!--end-->';
}


/**
 * Add Category Hero Image and Overlay
 */

add_action( 'woocommerce_archive_description', 'woocommerce_category_image' );
function woocommerce_category_image() {

	if ( woocommerce_products_will_display() ) :
		return;
	endif;

	if ( is_product_category() ) {
		global $wp_query;
		$cat               = $wp_query->get_queried_object(); //gets category meta
		$cat_slug          = $cat->slug;
		$view_all_link     = '/shop/' . $cat_slug . '/all-' . $cat_slug . '/';
		$sale_link         = '/shop/' . $cat_slug . '/sale-' . $cat_slug . '/';
		$thumbnail_id      = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); //gets thumbnail ID
		$termID            = $cat->term_id; //gets termID
		$brown_button_text = get_field( 'brown_button_text', 'product_cat_' . $termID );
		$brown_button_link = get_field( 'brown_button_link', 'product_cat_' . $termID );


//		echo '<pre>';
//		print var_dump( $brown_button_text );
//		echo '</pre>';


		$cat_name        = $cat->name; //gets termID
		$cat_description = $cat->description; //gets termID
		$image           = wp_get_attachment_url( $thumbnail_id ); //gets image thumbnail
		if ( $image ) {
			echo '<div class="category-hero-outer">';
			echo '<a href="/shop/' . $brown_button_link . '"><div class="category-hero" style="background-image: url(' . $image . ');">';
			echo '<div class="category-description-left">' . $cat_description . ' ';
			echo '<div class="category-description-button">' . $brown_button_text . '</div>';
			echo '</div>';//end category description
			echo '</div></a>';//end category hero

			echo '<div class="category-hero-right">';
			echo '<a href="' . $view_all_link . '"><div class="category-hero-view-all desktop-only">';
			echo '<h3 class="category-hero-right-titles">View All<br/>' . $cat_name . '</h3>';

			echo '</div></a>';

			if ( is_product_category( 'fireplaces-mantels' ) ) {
				echo '<a href="' . $sale_link . '"><div class="category-hero-sale">';
				echo '<h3 class="category-hero-right-titles">Sale</h3>';

				echo '</div></a>';
			} else {
				echo '<a href="' . $sale_link . '"><div class="category-hero-sale desktop-only">';
				echo '<h3 class="category-hero-right-titles">Sale</h3>';

				echo '</div></a>';
			}

			echo '</div>';


			echo '</div>';//end category outer

		}
	}
}

//add_filter('loop_shop_per_page', 'wg_view_all_products');
//
//function wg_view_all_products(){
//	if($_GET['view'] === 'all'){
//		return '9999';
//	}
//}


/**
 * Add bottom SEO description
 */

add_action( 'woocommerce_after_main_content', 'add_description_after_product_loop' );

function add_description_after_product_loop() {
	if ( is_product_category() ) {
		global $wp_query;
		$cat    = $wp_query->get_queried_object(); //gets category meta
		$termID = $cat->term_id; //gets termID
		echo '<div class="description_after_product_loop">';
		the_field( 'category_page_bottom_seo_description', 'product_cat_' . $termID ); //gets the ACF field and displays it.
		echo '</div>';
	}
}


add_filter( 'wpseo_separator_options', 'addmyfilter' );

function addmyfilter( $separators ) {
	array_push( $separators, " " );

	return $separators;
}