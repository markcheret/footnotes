<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Handles all WordPress hooks of this Plugin.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0 12.09.14 10:56
 *
 * Edited:
 * @since 2.2.0    2020-12-12T1223+0100
 */

/**
 * Registers all WordPress Hooks and executes them on demand.
 *
 * @since 1.5.0
 */
class MCI_Footnotes_Hooks {

	/**
	 * Registers all WordPress hooks.
	 *
	 * @since 1.5.0
	 */
	public static function register_hooks() {
		register_activation_hook( dirname( __FILE__ ) . '/../footnotes.php', array( 'MCI_Footnotes_Hooks', 'activate_plugin' ) );
		register_deactivation_hook( dirname( __FILE__ ) . '/../footnotes.php', array( 'MCI_Footnotes_Hooks', 'deactivate_plugin' ) );
		register_uninstall_hook( dirname( __FILE__ ) . '/../footnotes.php', array( 'MCI_Footnotes_Hooks', 'uninstall_plugin' ) );
	}

	/**
	 * Executed when the Plugin gets activated.
	 *
	 * @since 1.5.0
	 */
	public static function activate_plugin() {
		// Currently unused.
	}

	/**
	 * Executed when the Plugin gets deactivated.
	 *
	 * @since 1.5.0
	 */
	public static function deactivate_plugin() {
		// Currently unused.
	}

	/**
	 * Executed when the Plugin gets uninstalled.
	 *
	 * @since 1.5.0
	 *
	 * Edit: Clear_all didn’t actually work.
	 * @since 2.2.0 this function is not called any longer when deleting the plugin
	 */
	public static function uninstall_plugin() {
		// WordPress User has to be logged in.
		if ( ! is_user_logged_in() ) {
			wp_die( wp_kses_post( __( 'You must be logged in to run this script.', 'footnotes' ) ) );
		}
		// WordPress User needs the permission to (un)install plugins.
		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_die( wp_kses_post( __( 'You do not have permission to run this script.', 'footnotes' ) ) );
		}
		// Deletes all settings and restore the default values.
		// MCI_Footnotes_Settings::instance()->Clear_all();.
	}

	/**
	 * Add Links to the Plugin in the "installed Plugins" page.
	 *
	 * @since 1.5.0
	 * @param array  $p_arr_links Current Links.
	 * @param string $p_str_plugin_file_name Plugins init file name.
	 * @return array
	 */
	public static function plugin_links( $p_arr_links, $p_str_plugin_file_name ) {
		// Append link to the WordPress Plugin page.
		$p_arr_links[] = sprintf( '<a href="http://wordpress.org/support/plugin/footnotes" target="_blank">%s</a>', __( 'Support', 'footnotes' ) );
		// Append link to the Settings page.
		$p_arr_links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=mfmmf-footnotes' ), __( 'Settings', 'footnotes' ) );
		// Append link to the Play_pal Donate function.
		$p_arr_links[] = sprintf( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6Z6CZDW8PPBBJ" target="_blank">%s</a>', __( 'Donate', 'footnotes' ) );
		// Return new links.
		return $p_arr_links;
	}
}
