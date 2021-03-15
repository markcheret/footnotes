<?php
/**
 * Plugin Name: footnotes
 * Plugin URI: https://wordpress.org/plugins/footnotes/
 * Description: time to bring footnotes to your website! footnotes are known from offline publishing and everybody takes them for granted when reading a magazine.
 * Author: Mark Cheret
 * Package V.: 2.5.11d3
 * Version: 2.5.10
 * CAUTION: THIS V. FIELD IS PARSED FOR UPDATE CONFIGURATION.
 * Author URI: https://cheret.org/footnotes/
 * Text Domain: footnotes
 * Domain Path: /languages
 *
 * @package footnotes
 * @copyright 2021 Mark Cheret (email: mark@cheret.de)
 */

/**
 * Package Version number for stylesheet cache busting.
 *
 * Please keep this constant in sync with the Package Version in the header above
 * and in the header of the readme, but not necessarily with the other Version.
 *
 * @since 2.1.4
 * @since 2.5.3 (Hungarian)
 * @var str
 * @lastmodified 2021-03-11T2202+0100
 */
define( 'C_STR_PACKAGE_VERSION', '2.5.11d3' );

/**
 * Version numbers in WordPress plugin readme.txt and main PHP headers.
 *
 * - Adding: Documentation: Readme.txt: informative 'Package Version' field in sync with the package version currently hidden in the main PHP script header.
 * - Adding: Documentation: Readme.txt: informative 'Version' field pointing a tag folder in SVN for bugfix versions available ahead of the stable tag.
 * - Adding: Documentation: Readme.txt: comment line below the 'Stable Tag' field to warn that this is (unexpectedly) parsed for release configuration.
 *
 * @since 2.5.11
 * @see readme.txt
 * @link https://meta.trac.wordpress.org/ticket/5652
 *
 * Package Version   Actual version string, informative only.
 *                   May identify a development version.
 *                   A 'd' series is suffixed to incremented bugfix version.
 *                   Used for style sheet cache busting.
 *
 * Version           Parsed in the main PHP file header for update configuration.
 *                   Refers to the latest tag.
 *                   Typically the best available version.
 *                   May not be released, due to release frequency concerns.
 *
 * Stable Tag        Parsed in the readme.txt in trunk/ for release configuration.
 *                   May be smaller than Version, avoiding too frequent releases.
 *
 * WordPress plugin readmes are usually lacking the version number of the package.
 * In Footnotes, this has been included after the stable tag had been mistaken for
 * the package version, given that state-of-the-art readmes have that information.
 *
 * - Bugfix: Codebase: revert to 2.5.8, thanks to @little-shiva @watershare @adjayabdg @staho @frav8 @voregnev @dsl225 @alexclassroom @a223123131 @codldmac bug reports.
 *
 * @version 2.5.10 (reversion to @version 2.5.8)
 * @revision 2483464
 * @timestamp 2021-03-01 11:09:29 +0000
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
add_filter( "plugin_action_links_{$l_str_plugin_file}", array( 'MCI_Footnotes_Hooks', 'plugin_links' ), 10, 2 );

// Initialize the Plugin.
$g_obj_mci_footnotes = new MCI_Footnotes();
// Run the Plugin.
$g_obj_mci_footnotes->run();

/**
 * Sets the stylesheet enqueuing mode for production.
 *
 * @since 2.5.5
 * @var bool
 * @see class/init.php
 *
 * In production, a minified CSS file tailored to the settings is enqueued.
 *
 * Developing stylesheets is meant to be easier when this is set to false.
 * WARNING: This facility designed for development must NOT be used in production.
 */
define( 'C_BOOL_CSS_PRODUCTION_MODE', true );
