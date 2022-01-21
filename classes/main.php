<?php
namespace sMyles\WPJM\EMC;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * Main initiation class
 *
 * @since  1.0.0
 * @var  string $version  Plugin version
 * @var  string $basename Plugin basename
 * @var  string $url      Plugin URL
 * @var  string $path     Plugin Path
 */
class Main {

	/**
	 * @var null|\sMyles\WPJM\EMC\Main
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return Main A single instance of this class.
	 * @since  1.0.0
	 */
	public static function get_instance() {

		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin
	 *
	 * @since  1.0.0
	 */
	protected function __construct() {
		// Init Classes
		if ( is_admin() ) {
			new Admin();
		}

		new Plugins();
		new Job();
		new Resume();
		// Companies gets loaded in Plugins() due to numerous different ones available

		register_activation_hook( __FILE__, array( $this, '_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, '_deactivate' ) );
	}

	/**
	 * Add hooks and filters
	 *
	 * Executed after plugins_loaded action
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Activate the plugin
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function _activate() {
		// Make sure any rewrite functionality has been loaded
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function _deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Init hooks
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function init() {

		if ( $this->check_requirements() ) {
			// Load translation files
		}
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @return boolean result of meets_requirements
	 * @since  1.0.0
	 */
	public function check_requirements() {

		if ( ! self::meets_requirements() ) {
			add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );
			deactivate_plugins( WPJM_EMPTY_META_CLEANUP_BASENAME );
			return false;
		}

		return true;
	}

	/**
	 * Check that all plugin requirements are met
	 *
	 * @return boolean
	 * @since  1.0.0
	 */
	public static function meets_requirements() {
		// Do checks for required classes / functions
		// function_exists('') & class_exists('')
		// We have met all requirements
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function requirements_not_met_notice() {
		echo '<div id="message" class="error">';
		echo '<p>' . sprintf( __( 'Empty Meta Cleanup for WP Job Manager plugin is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.' ), admin_url( 'plugins.php' ) ) . '</p>';
		echo '</div>';
	}
}
