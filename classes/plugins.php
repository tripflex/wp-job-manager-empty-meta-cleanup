<?php

namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Class Plugins
 *
 * @package sMyles\WPJM\EMC
 */
class Plugins {

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		/**
		 * Disable the built-in field editor handling as this would just be duplicate of what this plugin does
		 */
		add_filter( 'field_editor_save_admin_custom_fields_remove_empty_value_fields', '__return_false' );
		add_filter( 'field_editor_save_custom_fields_remove_empty_value_fields', '__return_false' );
	}

}