<?php
/**
 * The footnotes WordPress Plugin.
 *
 * @package footnotes
 * @author Mark Cheret
 * @copyright 2021 Mark Cheret (email: mark@cheret.de)
 * @license GPL-3.0-only
 *
 * @wordpress-plugin
 * Plugin Name: footnotes
 * Plugin URI: https://wordpress.org/plugins/footnotes/
 * Description: footnotes lets you easily add highly-customisable footnotes on your WordPress Pages and Posts.
 * Version: 2.7.3
 * Requires at least: 3.9
 * Requires PHP: 7.0
 * Author: Mark Cheret
 * Author URI: https://cheret.org/footnotes
 * Text Domain: footnotes
 * Domain Path: /languages
 * License: GPL v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */
 
declare(strict_types=1);
 
/**
 * Defines the current Plugin version.
 *
 * @since 2.1.4
 * @var string
 */
const C_STR_FOOTNOTES_VERSION = '2.7.3';

/**
 * Defines the current environment ('development' or 'production').
 *
 * This primarily affects whether minified or unminified files are requested.
 *
 * @since 2.5.5
 * @var bool
 */
const PRODUCTION_ENV = false;

/**
 * Defines the Plugin entry point (relative to the `wp-content/` dir).
 *
 * @since 2.8.0
 * @var string
 */
const PLUGIN_ENTRYPOINT = 'footnotes/footnotes.php';

// Get all common classes and functions.
require_once dirname( __FILE__ ) . '/includes.php';

// Add links to the ‘Installed Plugins’ page on the WordPress dashboard.
add_filter( "plugin_action_links_" . PLUGIN_ENTRYPOINT, array( 'Footnotes_Hooks', 'get_plugin_links' ), 10, 2 );

// Initialize the Plugin.
$g_obj_mci_footnotes = new Footnotes();
// Run the Plugin.
$g_obj_mci_footnotes->run();
