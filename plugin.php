<?php
/**
 * Woocommerce Admin Product Search By Title Only
 *
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
Copyright 2016 Andrea Debernardi (email : andrea.debernardi@dueclic.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 *
 * SE_WC_Product_Data_Store_CPT class inclusion
 *
 */

if ( ! class_exists( 'SE_WC_Product_Data_Store_CPT' ) )
	require_once( dirname(__FILE__) . 'data-stores/class-se-wc-product-data-store-cpt.php' );

function change_product_data_store(&$stores){
	$stores["product"] = "SE_WC_Product_Data_Store_CPT";
	return $stores;
}

add_filter("woocommerce_data_stores", "change_product_data_store");

