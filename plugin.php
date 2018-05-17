<?php
/**
 * Woocommerce Admin Product Search By Title Only allows in administration to search through Woocommerce products comparing only comparing with product title (no excerpt or other things).
 *
 * Plugin Name: Woocommerce Admin Product Search By Title Only
 * Plugin URI:  https://github.com/debba/woocommerce-admin-product-search-by-title-only
 * Description: A sample plugin to search through Woocommerce products comparing only comparing with product title (no excerpt or other things)
 * Version:     1.0
 * Author:      Andrea Debernardi
 * Author URI:  https://www.dueclic.com
 * License:     GPL-3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * GitHub Plugin URI: https://github.com/debba/woocommerce-admin-product-search-by-title-only
 */

/**
 *
 * SE_WC_Product_Data_Store_CPT class inclusion
 *
 */

define( 'WAPSTO_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

function change_product_data_store( &$stores ) {

	if ( ! class_exists( 'SE_WC_Product_Data_Store_CPT' ) ) {
		require_once( WAPSTO_PLUGIN_PATH . 'data-stores/class-se-wc-product-data-store-cpt.php' );
	}

	$stores["product"] = "SE_WC_Product_Data_Store_CPT";
	return $stores;
}

add_filter( "woocommerce_data_stores", "change_product_data_store" );