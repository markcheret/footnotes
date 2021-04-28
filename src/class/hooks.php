<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName, WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Footnotes_Hooks class
 *
 * @package footnotes
 * @subpackage WPDashboard
 * @since 1.5.0
 */

/**
 * Registers all WordPress hooks and executes them on demand.
 *
 * @since 1.5.0
 */
class Footnotes_Hooks {

	/**
	 * Registers all WordPress hooks.
	 *
	 * @since 1.5.0
	 */
	public static function register_hooks() {
		register_activation_hook( dirname( __FILE__ ) . '/../footnotes.php', array( 'Footnotes_Hooks', 'activate_plugin' ) );
		register_deactivation_hook( dirname( __FILE__ ) . '/../footnotes.php', array( 'Footnotes_Hooks', 'deactivate_plugin' ) );
		register_uninstall_hook( dirname( __FILE__ ) . '/../footnotes.php', array( 'Footnotes_Hooks', 'uninstall_plugin' ) );
	}

	/**
	 * Executes when the Plugin is activated.
	 *
	 * Currently a no-op placeholder.
	 *
	 * @since 1.5.0
	 */
	public static function activate_plugin() {
		// Currently unused.
	}

	/**
	 * Executes when the Plugin is deactivated.
	 *
	 * Currently a no-op placeholder.
	 *
	 * @since 1.5.0
	 */
	public static function deactivate_plugin() {
		// Currently unused.
	}

	/**
	 * Appends the Plugin links for display in the dashboard “Plugins” page.
	 *
	 * @since 1.5.0
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
