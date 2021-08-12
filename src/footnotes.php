<?php
/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package footnotes
 * @since 1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: footnotes
 * Plugin URI: https://wordpress.org/plugins/footnotes/
 * Description: footnotes lets you easily add highly-customisable footnotes on your WordPress Pages and Posts.
 * Version: 2.8.0d
 * Requires at least: 3.9
 * Requires PHP: 7.0
 * Author: Mark Cheret
 * Author URI: https://cheret.tech/footnotes
 * Text Domain: footnotes
 * Domain Path: /languages
 * License: GPL v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

declare(strict_types=1);

namespace footnotes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The plugin version.
 *
 * @link https://github.com/markcheret/footnotes/wiki/Versioning Versioning Guide
 *
 * @since 2.1.4
 * @todo Draw from envfile rather than hard-coding.
 *
 * @global string PLUGIN_VERSION The version of this instance of the plugin.
 */
define( 'PLUGIN_VERSION', '2.8.0d' );

/**
 * The environment that the plugin is configured for.
 *
 * This primarily affects whether minified or unminified CSS/JS files are
 * requested.
 *
 * @since 2.5.5
 * @todo Draw from envfile rather than hard-coding.
 * @todo Replace with string for >2 environment options.
 *
 * @global bool PRODUCTION_ENV Whether the plugin is running in production mode or not.
 */
define( 'PRODUCTION_ENV', false );

/**
 * Handles the activation of the plugin.
 *
 * @since 2.8.0
 * @see includes\Activator::activate()
 */
function activate_footnotes(): void {
	/**
	 * Provides plugin activation functionality.
	 */
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';

	includes\Activator::activate();
}

/**
 * Handles the deactivation of the plugin.
 *
 * @since 2.8.0
 * @see includes\Deactivator::deactivate()
 */
function deactivate_footnotes(): void {
	/**
	 * Provides plugin deactivation functionality.
	 */
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';

	includes\Deactivator::deactivate();
}

/*
 * TODO: currently these throw an error:
 * Uncaught TypeError: call_user_func_array(): Argument #1 ($function) must be
 * a valid callback, function "deactivate_footnotes" not found or invalid
 * function name in /srv/www/wordpress-one/public_html/wp-includes/class-wp-hook.php:292
 *
 * register_activation_hook( __FILE__, 'activate_footnotes' );
 * register_deactivation_hook( __FILE__, 'deactivate_footnotes' );
 */

/**
 * The core plugin class that defines internationalization, admin-specific and
 * public-facing site hooks and functionality.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks, then kicking off
 * the plugin from this point in the file does not affect the page life cycle.
 * This takes place after the `plugins_loaded` hook, so that other Plugins may
 * filter options.
 *
 * @since 2.8.0
 */
function run_footnotes(): void {
	/**
	 * The plugin core.
	 *
	 * @global includes\Core $footnotes
	 */
	global $footnotes;
	$footnotes = new includes\Core();
	$footnotes->run();
}
add_action( 'plugins_loaded', run_footnotes() );
