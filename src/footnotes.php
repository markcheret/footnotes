<?php
/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @author Mark Cheret
 * @since 1.0.0
 * @package footnotes
 * @copyright 2021 Mark Cheret (email: mark@cheret.de)
 * @license GPL-3.0-only
 *
 * @wordpress-plugin
 * Plugin Name: footnotes
 * Plugin URI: https://wordpress.org/plugins/footnotes/
 * Description: footnotes lets you easily add highly-customisable footnotes on your WordPress Pages and Posts.
 * Version: 2.8.0d
 * Requires at least: 3.9
 * Requires PHP: 7.0
 * Author: Mark Cheret
 * Author URI: https://cheret.org/footnotes
 * Text Domain: footnotes
 * Domain Path: /languages
 * License: GPL v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'C_STR_FOOTNOTES_VERSION', '2.8.0d' );

/**
 * Defines the current environment ('development' or 'production').
 *
 * This primarily affects whether minified or unminified files are requested.
 *
 * @since 2.5.5
 */
define( 'PRODUCTION_ENV', false );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_footnotes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-footnotes-activator.php';
	Footnotes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-footnotes-deactivator.php';
	Footnotes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_footnotes' );
register_deactivation_hook( __FILE__, 'deactivate_footnotes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-footnotes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 2.8.0
 */
function run_footnotes() {
	global $footnotes;
	$footnotes = new Footnotes();
	$footnotes->run();
}
run_footnotes();
