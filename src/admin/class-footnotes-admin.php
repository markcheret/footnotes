<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @since      2.8.0
 *
 * @package    footnotes
 * @subpackage footnotes/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and enqueues all admin-specific stylesheets
 * and JavaScript.
 *
 * @package    footnotes
 * @subpackage footnotes/admin
 */
class Footnotes_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.8.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.8.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.8.0
	 * @param    string $plugin_name       The name of this plugin.
	 * @param    string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->load_dependencies();

	}

	/**
	 * Load the required admin-specific dependencies.
	 *
	 * Include the following files that provide the admin-specific functionality
	 * of this plugin:
	 *
	 * - `Footnotes_WYSIWYG`. TODO
	 * - `Footnotes_Layout_Settings`. TODO
	 *
	 * @since    2.8.0
	 * @access   private
	 */
	private function load_dependencies() {
		// TODO: neaten up and document once placements and names are settled.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-footnotes-wysiwyg.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/layout/class-footnotes-layout-init.php';

		new Footnotes_Layout_Init();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    2.8.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/settings' . ( ( PRODUCTION_ENV ) ? '.min' : '' ) . '.css',
			array(),
			( PRODUCTION_ENV ) ? $this->version : filemtime(
				plugin_dir_path(
					dirname( __FILE__ )
				) . 'css/settings.css'
			),
			'all'
		);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    2.8.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/wysiwyg-editor' . ( ( PRODUCTION_ENV ) ? '.min' : '' ) . '.js',
			array(),
			( PRODUCTION_ENV ) ? $this->version : filemtime(
				plugin_dir_path(
					dirname( __FILE__ )
				) . 'js/wysiwyg-editor.js'
			),
			false
		);

	}

	/**
	 * Appends the Plugin links for display in the dashboard Plugins page.
	 *
	 * @since 1.5.0
	 * @since 2.8.0 Moved into `Footnote_Admin` class.
	 * @param array $plugin_links The WP-default set of links to display.
	 * @return string[] The full set of links to display.
	 */
	public static function get_plugin_links( array $plugin_links ): array {
		// Append link to the WordPress Plugin page.
		$plugin_links[] = sprintf( '<a href="https://wordpress.org/support/plugin/footnotes" target="_blank">%s</a>', __( 'Support', 'footnotes' ) );
		// Append link to the settings page.
		$plugin_links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=footnotes' ), __( 'Settings', 'footnotes' ) );
		// Append link to the PayPal donate function.
		$plugin_links[] = sprintf( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6Z6CZDW8PPBBJ" target="_blank">%s</a>', __( 'Donate', 'footnotes' ) );
		// Return new links.
		return $plugin_links;
	}

}

