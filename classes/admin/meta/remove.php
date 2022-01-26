<?php

namespace sMyles\WPJM\EMC\Admin\Meta;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Remove
 *
 * @package sMyles\WPJM\EMC\Admin\Meta
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
	public function check_fields_and_remove( $listing_id, $post ) {

		if( ! get_option( "job_manager_empty_meta_cleanup_{$this->type->slug}_enable", true ) ){
			return;
		}

		$fields = $this->get_fields();
		$skip_meta_keys = apply_filters( 'job_manager_empty_meta_cleaner_admin_skip_meta_keys', array(), $listing_id, $post, $this );

		foreach( (array) $fields as $_meta_key => $config ){
			/**
			 * Get the meta key without the prepended underscore, in case user passes value for skip keys without the prepended underscore ;-)
			 */
			$meta_key = substr( $_meta_key, 0, 1 ) === '_' ? substr( $_meta_key, 1 ) : $_meta_key;

			$raw_field_value = isset( $_POST[ $_meta_key ] ) ? $_POST[ $_meta_key ] : false;

			/**
			 * Because WP Job Manager saves fields even if there is no value for them, after this is done, we check if our custom field has an empty value,
			 * and if it does, we delete that meta from the listing.  This helps prevent excessive meta on listings with empty values.
			 */
			if ( ( $raw_field_value === '' || $raw_field_value === false || ( is_array( $raw_field_value ) && count( $raw_field_value ) < 1 ) ) && ! in_array( $_meta_key, $skip_meta_keys ) && ! in_array( $meta_key, $skip_meta_keys ) ) {
				delete_post_meta( $listing_id, $_meta_key );
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