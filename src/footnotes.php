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

/**
 * Defines the current Plugin version.
 *
 * @since 2.1.4
 * @var string
 */
define( 'C_STR_FOOTNOTES_VERSION', '2.7.3' );

/**
 * Defines the current environment ('development' or 'production').
 *
 * This primarily affects whether minified or unminified files are requested.
 *
 * @since 2.5.5
 * @var bool
 */
define( 'PRODUCTION_ENV', false );

/**
 * - Bugfix: Codebase: revert to 2.5.8, thanks to @little-shiva @watershare @adjayabdg @staho @frav8 @voregnev @dsl225 @alexclassroom @a223123131 @codldmac bug reports.
 *
 * @since 2.8.0
 * @var string
 */

// Get all common classes and functions.
require_once dirname( __FILE__ ) . '/includes.php';

// Add Plugin Links to the "installed plugins" page.
$l_str_plugin_file = 'footnotes/footnotes.php';
add_filter( "plugin_action_links_{$l_str_plugin_file}", array( 'Footnotes_Hooks', 'get_plugin_links' ), 10, 2 );

// Initialize the Plugin.
$g_obj_mci_footnotes = new Footnotes();
// Run the Plugin.
$g_obj_mci_footnotes->run();
