<?php
/*
	Plugin Name: footnotes
	Plugin URI: https://github.com/media-competence-institute/footnotes
	Description: time to bring footnotes to your website! footnotes are known from offline publishing and everybody takes them for granted when reading a magazine.
	Author: media competence institute
	Version: 1.0.5
	Author URI: http://cheret.co.uk/mci
	Text Domain: footnotes
	Domain Path: /languages
*/
/*
	Copyright 2014  Mark Cheret, Stefan Herndler (email : mark@cheret.de | support@herndler.org)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 3, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0
 * Since: 1.0
 */


/* include constants */
require_once( dirname( __FILE__ ) . "/includes/defines.php" );
/* include language functions */
require_once( dirname( __FILE__ ) . "/includes/language.php" );
/* include storage functions and global plugin functions */
require_once( dirname( __FILE__ ) . "/includes/plugin-settings.php" );
/* include script and stylesheet functions */
require_once( dirname( __FILE__ ) . "/includes/scripts.php" );
/* include script and stylesheet functions */
require_once( dirname( __FILE__ ) . "/includes/convert.php" );
/* include script and stylesheet functions */
require_once( dirname( __FILE__ ) . "/includes/replacer.php" );

/* require plugin class */
require_once( dirname( __FILE__ ) . "/classes/footnotes.php" );
/* require plugin settings class */
require_once( dirname( __FILE__ ) . "/classes/footnotes_settings.php" );

/* register functions for the footnote replacement */
footnotes_RegisterReplacementFunctions();

/* adds javascript and stylesheets to the public page */
add_action( 'wp_enqueue_scripts', 'footnotes_add_public_stylesheet' );

/* only admin is allowed to execute the plugin settings */
if ( !function_exists( 'is_admin' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/* action to locate language and load the wordpress-specific language file */
add_action( 'plugins_loaded', 'footnotes_load_language' );

/* add link to the settings page in plugin main page */
$l_str_plugin_file = FOOTNOTES_PLUGIN_DIR_NAME . '/index.php';
add_filter( "plugin_action_links_{$l_str_plugin_file}", 'footnotes_plugin_settings_link', 10, 2 );

/* initialize an object of the plugin class */
global $g_obj_FootnotesPlugin;

/* if object isn't initialized yet, initialize it now */
if ( empty( $g_obj_FootnotesPlugin ) ) {
	$g_obj_FootnotesPlugin = new Class_Footnotes();
}