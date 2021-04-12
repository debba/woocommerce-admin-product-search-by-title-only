<?php
/**
 * SE_WC_Product_Data_Store_CPT class file.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class SE_WC_Product_Data_Store_CPT extends WC_Product_Data_Store_CPT {

	public function search_products( $term, $type = '', $include_variations = false, $all_statuses = false, $limit = NULL, $include = NULL, $exclude = NULL ) {
		global $wpdb;

		$like_term     = '%' . $wpdb->esc_like( $term ) . '%';
		$post_types    = $include_variations ? array( 'product', 'product_variation' ) : array( 'product' );
		$post_statuses = current_user_can( 'edit_private_products' ) ? array( 'private', 'publish' ) : array( 'publish' );
		$type_join     = '';
		$type_where    = '';
		$status_where  = '';

		if ( $type ) {
			if ( in_array( $type, array( 'virtual', 'downloadable' ), true ) ) {
				$type_join  = " LEFT JOIN {$wpdb->postmeta} postmeta_type ON posts.ID = postmeta_type.post_id ";
				$type_where = " AND ( postmeta_type.meta_key = '_{$type}' AND postmeta_type.meta_value = 'yes' ) ";
			}
		}

		if ( ! $all_statuses ) {
			$status_where = " AND posts.post_status IN ('" . implode( "','", $post_statuses ) . "') ";
		}

		// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.DirectQuery
		$search_results = $wpdb->get_results(
		// phpcs:disable
			$wpdb->prepare(
				"SELECT DISTINCT posts.ID as product_id, posts.post_parent as parent_id FROM {$wpdb->posts} posts
				LEFT JOIN {$wpdb->postmeta} postmeta ON posts.ID = postmeta.post_id
				$type_join
				WHERE (
					posts.post_title LIKE %s
					OR (
						postmeta.meta_key = '_sku' AND postmeta.meta_value LIKE %s
					)
				)
				AND posts.post_type IN ('" . implode( "','", $post_types ) . "')
				$status_where
				$type_where
				ORDER BY posts.post_parent ASC, posts.post_title ASC",
				$like_term,
				$like_term,
				$like_term,
				$like_term
			)
		// phpcs:enable
		);

		$product_ids = wp_parse_id_list( array_merge( wp_list_pluck( $search_results, 'product_id' ), wp_list_pluck( $search_results, 'parent_id' ) ) );

		if ( is_numeric( $term ) ) {
			$post_id   = absint( $term );
			$post_type = get_post_type( $post_id );

			if ( 'product_variation' === $post_type && $include_variations ) {
				$product_ids[] = $post_id;
			} elseif ( 'product' === $post_type ) {
				$product_ids[] = $post_id;
			}

			$product_ids[] = wp_get_post_parent_id( $post_id );
		}

		return wp_parse_id_list( $product_ids );
	}

}
