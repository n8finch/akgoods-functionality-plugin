<?php

/**
 * Reposition sidebar on categories
 */

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

add_action( 'woocommerce_before_main_content', 'start_sorting_container', 31 );

function start_sorting_container() {

	if ( is_product_category() ) {
		echo '<div class="start_sorting_container">';
		woocommerce_catalog_ordering();
		echo '</div> <!--end-->';
	}
}


/**
 * Add Category Hero Image and Overlay
 */

add_action( 'woocommerce_archive_description', 'woocommerce_category_image' );
function woocommerce_category_image() {
	if ( is_product_category() ) {
		global $wp_query;
		$cat             = $wp_query->get_queried_object(); //gets category meta
		$thumbnail_id    = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); //gets thumbnail ID

//		echo '<pre>';
//		print var_dump($cat);
//		echo '</pre>';


		$cat_name        = $cat->name; //gets termID
		$cat_description = $cat->description; //gets termID
		$image           = wp_get_attachment_url( $thumbnail_id ); //gets image thumbnail
		if ( $image ) {
			echo '<div class="category-hero-outer">';
				echo '<div class="category-hero" style="background-image: url(' . $image . ');">';
					echo '<div class="category-description-left">' . $cat_description . ' ';
						echo '<div class="category-description-button">View All<br/>' . $cat_name . '</div>';
					echo '</div>';//end category description
				echo '</div>';//end category hero

				echo '<div class="category-hero-right">';
					echo '<a href="#"><div class="category-hero-view-all">';
						echo '<h3 class="category-hero-right-titles">View All<br/>' . $cat_name . '</h3>';

					echo '</div></a>';

					echo '<a href="/shop/sale/"><div class="category-hero-sale">';
						echo '<h3 class="category-hero-right-titles">Sale</h3>';

					echo '</div></a>';

				echo '</div>';



			echo '</div>';//end category outer

		}
	}
}

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


