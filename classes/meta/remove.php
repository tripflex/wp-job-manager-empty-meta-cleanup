<?php

namespace sMyles\WPJM\EMC\Meta;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Remove
 *
 * @package sMyles\WPJM\EMC\Meta
 */
class Remove {

	/**
	 * Check for Empty Meta Fields on Submit and Remove
	 *
	 * Ideally this would be handled by removing the fields from the fields array, preventing WP Job Manager (or other plugins) from actually saving
	 * the fields, but that would take a very extensive amount of work and could cause other complications.  For now we just delete the meta.
	 *
	 * @since @@version
	 *
	 */
	public function check_fields_and_remove( $listing_id, $values ) {
		$fields = $this->get_fields();
		$skip_meta_keys = apply_filters( 'job_manager_empty_meta_cleaner_frontend_skip_meta_keys', array(), $listing_id, $values, $this );

		/**
		 * Whether to also check $_POST for field
		 *
		 * For the frontend handling we check through an action triggered by the plugin, which passes the values used (after passing through internal filters).  With this handling enabled,
		 * we also check $_POST for a value (and use that if not set in the passed values), in the instance that another plugin/theme specifically removed it (but doesn't want it removed).
		 */
		$also_check_POST = apply_filters( 'job_manager_empty_meta_cleaner_frontend_check_post', true, $listing_id, $values, $this );

		foreach( (array) $fields as $field_group => $fields ){

			foreach( (array) $fields as $meta_key => $config ){

				$_meta_key = "_{$meta_key}";
				$field_value = isset( $values[ $field_group ][ $meta_key ] ) ? $values[ $field_group ][ $meta_key ] : false;

				if( $also_check_POST && $field_value === false ){
					/**
					 * Sanitize just for sanity's sake (not necessary)
					 */
					$field_value = isset( $_POST[ $meta_key ] ) ? sanitize_text_field( $_POST[ $meta_key ] ) : false;
				}

				if ( ( $field_value === '' || $field_value === false || ( is_array( $field_value ) && count( $field_value ) < 1 ) ) && ! in_array( $meta_key, $skip_meta_keys ) ) {
					delete_post_meta( $listing_id, $_meta_key );
				}

			}

		}
	}

	/**
	 * Get Fields Placeholder
	 *
	 * @return array
	 * @since @@version
	 *
	 */
	public function get_fields() {
		return array();
	}
}