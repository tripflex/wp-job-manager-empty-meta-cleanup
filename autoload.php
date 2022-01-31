<?php
namespace sMyles\WPJM\EMC;

/**
 * Auto Class Loading
 *
 *
 * @param $class
 *
 * @since 1.0.0
 *
 */
function autoload_classes( $class ) {

	// project-specific namespace prefix
	$prefix = 'sMyles\\WPJM\\EMC\\';

	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr( $class, $len );

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = strtolower( str_replace( '\\', '/', $relative_class ) ) . '.php';

	$file_location = WPJM_EMPTY_META_CLEANUP_PLUGIN_DIR . '/classes/' . $file;
	if( file_exists( $file_location ) ){
		include_once $file_location;
	}
}

spl_autoload_register( 'sMyles\WPJM\EMC\autoload_classes' );