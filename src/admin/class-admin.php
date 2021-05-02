<?php
/**
 * Admin: Admin class
 *
 * The Admin. subpackage is initialised at runtime by the {@see Admin}
 * class, which draws in the {@see WYSIWYG} class for WYSIWYG editor
 * integration and the {@see footnotes\admin\layout} subpackage for rendering
 * dashboard pages.
 *
 * @package  footnotes
 * @since  2.8.0
 */

declare(strict_types=1);

namespace footnotes\admin;

use footnotes\includes as Includes;

/**
 * Class provide all admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and enqueues all admin-specific stylesheets
 * and JavaScript.
 *
 * @package  footnotes
 * @since  2.8.0
 */
class Admin {

	/**
	 * The WYSIWYG editor integration object.
	 *
	 * @since  2.8.0
	 * @var  WYSIWYG  $wysiwyg  The WYSIWYG editor integration object.
	 */
	public WYSIWYG $wysiwyg;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  2.8.0
	 */
	public function __construct( /**
								  * The ID of this plugin.
								  *
								  * @access  private
								  * @since  2.8.0
								  * @see  Includes\Footnotes::$plugin_name
								  * @var  string  $plugin_name  The ID of this plugin.
								  */
	private string $plugin_name, /**
								  * The version of this plugin.
								  *
								  * @access  private
								  * @since  2.8.0
								  * @see  Includes\Footnotes::$version
								  * @var  string  $version  The current version of this plugin.
								  */
	private string $version ) {

		$this->load_dependencies();

	}

	/**
	 * Load the required admin-specific dependencies.
	 *
	 * Includes the following files that provide the admin-specific functionality
	 * of this plugin:
	 *
	 * - {@see WYSIWYG}: Provides plugin integration with the WYSIWYG editor.
	 * - {@see layout\Settings}: Defines the plugin dashboard page(s).
	 *
	 * @access  private
	 *
	 * @since  2.8.0
	 */
	private function load_dependencies(): void {
		/**
		 * The class responsible for WYSIWYG editor integration.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-wysiwyg.php';

		$this->wysiwyg = new WYSIWYG( $this->plugin_name );

		/**
		 * The class responsible for constructing the plugin dashboard page(s).
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/layout/class-init.php';

		new layout\Init( $this->plugin_name );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since  2.8.0
	 */
	public function enqueue_styles(): void {

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/settings' . ( ( PRODUCTION_ENV ) ? '.min' : '' ) . '.css',
			array(),
			( PRODUCTION_ENV ) ? $this->version : filemtime(
				plugin_dir_path(
					__FILE__
				) . 'css/settings.css'
			),
			'all'
		);

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since  2.8.0
	 */
	public function enqueue_scripts(): void {

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/wysiwyg-editor' . ( ( PRODUCTION_ENV ) ? '.min' : '' ) . '.js',
			array(),
			( PRODUCTION_ENV ) ? $this->version : filemtime(
				plugin_dir_path(
					__FILE__
				) . 'js/wysiwyg-editor.js'
			),
			false
		);

	}

	/**
	 * Appends the Plugin links for display in the dashboard Plugins page.
	 *
	 * @param  string[] $plugin_links  The default set of links to display.
	 * @return  string[]  The full set of links to display.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Moved from `Hooks` class to `Admin`.
	 */
	public function action_links( array $plugin_links ): array {
		// Append link to the WordPress Plugin page.
		$plugin_links[] = sprintf( '<a href="https://wordpress.org/support/plugin/footnotes" target="_blank">%s</a>', __( 'Support', 'footnotes' ) );
		// Append link to the settings page.
		$plugin_links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'options-general.php?page=footnotes' ) ), __( 'Settings', 'footnotes' ) );
		// Append link to the PayPal donate function.
		$plugin_links[] = sprintf( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6Z6CZDW8PPBBJ" target="_blank">%s</a>', __( 'Donate', 'footnotes' ) );
		return $plugin_links;
	}

}

