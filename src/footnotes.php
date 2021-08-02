<?php
/**
 * Plugin Name: footnotes
 * Plugin URI: https://wordpress.org/plugins/footnotes/
 * Description: footnotes lets you easily add highly-customisable footnotes on your WordPress Pages and Posts.
 * Author: Mark Cheret
 * Author URI: https://cheret.tech/footnotes
 * Version: 2.7.3
 * Text Domain: footnotes
 * Domain Path: /languages
 * Requires at least: 3.9
 * Requires PHP: 7.0
 *
 * @package footnotes
 * @copyright 2021 Mark Cheret (email: mark@cheret.de)
 */

/**
 * Package Version number for stylesheet cache busting.
 *
 * Please keep this string in sync with the 'Version' (not 'Package V.').
 * Please mirror the 'Version' also in js/wysiwyg-editor.js.
 *
 * @since 2.1.4
 * @since 2.5.3 (Hungarian)
 * @var str
 */
define( 'C_STR_FOOTNOTES_VERSION', '2.7.3' );

/**
 * Defines the current environment ('development' or 'production').
 *
 * @since 2.5.5
 * @var bool
 * @see Full docblock below next.
 *
 * In production, a minified CSS file tailored to the settings is enqueued.
 *
 * Developing stylesheets is meant to be easier when this is set to false.
 * WARNING: This facility designed for development must NOT be used in production.
 */
define( 'PRODUCTION_ENV', false );

/**
 * - Bugfix: Codebase: revert to 2.5.8, thanks to @little-shiva @watershare @adjayabdg @staho @frav8 @voregnev @dsl225 @alexclassroom @a223123131 @codldmac bug reports.
 *
 * @version 2.5.10 (reversion to @version 2.5.8)
 * @revision 2483464
 * @link https://plugins.trac.wordpress.org/changeset/2483464/footnotes/trunk
 *
 * @reporter @little-shiva
 * @link https://wordpress.org/support/topic/footnotes-broke-two-of-my-client-sites/
 *
 * @reporter @watershare
 * @link https://wordpress.org/support/topic/latest-update-broke-my-site-19/
 *
 * @reporter @adjayabdg
 * @link https://wordpress.org/support/topic/latest-update-broke-my-site-19/#post-14115531
 *
 * @reporter @staho
 * @link https://wordpress.org/support/topic/version-2-5-9d1-breaks-wp-down/
 *
 * @reporter @frav8
 * @link https://wordpress.org/support/topic/version-2-5-9d1-breaks-wp-down/#post-14115614
 *
 * @reporter @voregnev
 * @link https://wordpress.org/support/topic/version-2-5-9d1-breaks-wp-down/#post-14115632
 *
 * @reporter @dsl225
 * @link https://wordpress.org/support/topic/version-2-5-9d1-breaks-wp-down/#post-14115820
 *
 * @reporter @alexclassroom
 * @link https://wordpress.org/support/topic/version-2-5-9d1-breaks-wp-down/#post-14115860
 *
 * @reporter @a223123131
 * @link https://wordpress.org/support/topic/version-2-5-9d1-breaks-wp-down/#post-14115906
 * @link https://wordpress.org/support/topic/update-breaks-layout-3/
 * @link https://wordpress.org/support/topic/bugs-in-every-2nd-update/#post-14116804
 *
 * @reporter @codldmac
 * @link https://wordpress.org/support/topic/crashed-my-site-104/
 *
 * The accidental release of 2.5.9d1 was due to 3 factors:
 *
 * 1. The codebase got overhauled for the sake of WordPress Coding Standards compliance,
 *    one requirement of which is that files be named after the name of the class in them;
 * 2. The renamed folder was not added to Subversion version control due to an unexpected
 *    unfamiliarity with the system and its command line interface;
 * 3. The Stable Tag field in the Readme header was used for the package version because
 *    the related field is lacking, and the use of file headers for release configuration
 *    is uncommon.
 *
 * @link https://wordpress.org/support/topic/2-5-10-reverts-2-5-9d1-and-apologies/
 * @link https://wordpress.org/support/topic/2-5-10-reverts-2-5-9d1-and-apologies/#post-14119440
 * @link https://github.com/markcheret/footnotes/issues/55
 * @link https://meta.trac.wordpress.org/ticket/5645
 * @link https://wordpress.org/plugins/readme.txt
 * @link https://developer.wordpress.org/plugins/wordpress-org/how-your-readme-txt-works/
 */

/**
 * Plugin’s main PHP file.
 *
 * @filesource
 * @package footnotes
 * @since 0.0.1
 */

// Get all common classes and functions.
require_once dirname( __FILE__ ) . '/includes.php';

// Add Plugin Links to the "installed plugins" page.
$l_str_plugin_file = 'footnotes/footnotes.php';
add_filter( "plugin_action_links_{$l_str_plugin_file}", array( 'Footnotes_Hooks', 'get_plugin_links' ), 10, 2 );

/**
 * Initialises and runs the Plugin.
 *
 * This takes place after the `plugins_loaded` hook, so that
 * other Plugins may filter options.
 *
 * @since 2.7.4
 */
add_action( 'plugins_loaded', function() {
	// Initialize the Plugin.
	$g_obj_mci_footnotes = new Footnotes();
	// Run the Plugin.
	$g_obj_mci_footnotes->run();
});
