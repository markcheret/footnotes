<?php
/*
	Plugin Name: footnotes
	Plugin URI: http://wordpress.org/plugins/footnotes/
	Description: time to bring footnotes to your website! footnotes are known from offline publishing and everybody takes them for granted when reading a magazine.
	Author: media competence institute
	Version: 1.1.2
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
 * Version: 1.1.1
 * Since: 1.0
 */


/* include constants */
require_once(dirname(__FILE__) . "/includes/defines.php");
/* include language functions */
require_once(dirname(__FILE__) . "/includes/language.php");
/* include storage functions and global plugin functions */
require_once(dirname(__FILE__) . "/includes/plugin-settings.php");
/* include script and stylesheet functions */
require_once(dirname(__FILE__) . "/includes/scripts.php");
/* include script and stylesheet functions */
require_once(dirname(__FILE__) . "/includes/convert.php");
/* include script and stylesheet functions */
require_once(dirname(__FILE__) . "/includes/wysiwyg-editor.php");
/* include script and stylesheet functions */
require_once(dirname(__FILE__) . "/includes/replacer.php");

/* require plugin class */
require_once(dirname(__FILE__) . "/classes/footnotes.php");
/* require plugin settings class */
require_once(dirname(__FILE__) . "/classes/footnotes_settings.php");
/* require plugin widget class */
require_once(dirname(__FILE__) . "/classes/footnotes_widget.php");

/* register functions for the footnote replacement */
footnotes_RegisterReplacementFunctions();

/* adds javascript and stylesheets to the public page */
add_action('wp_enqueue_scripts', 'footnotes_add_public_stylesheet');

/* defines the callback function for the editor buttons */
add_action('wp_ajax_nopriv_footnotes_getTags', 'footnotes_wysiwyg_ajax_callback' );
add_action('wp_ajax_footnotes_getTags', 'footnotes_wysiwyg_ajax_callback' );
/* add new button to the WYSIWYG - editor */
add_filter('mce_buttons', 'footnotes_wysiwyg_editor_functions');
add_filter( "mce_external_plugins", "footnotes_wysiwyg_editor_buttons" );
/* add new button to the plain text editor */
add_action( 'admin_print_footer_scripts', 'footnotes_text_editor_buttons' );

/* action to locate language and load the wordpress-specific language file */
add_action('plugins_loaded', 'footnotes_load_language');

/* add link to the settings page in plugin main page */
$l_str_plugin_file = FOOTNOTES_PLUGIN_DIR_NAME . '/index.php';
add_filter("plugin_action_links_{$l_str_plugin_file}", 'footnotes_plugin_settings_link', 10, 2);

/* register footnotes widget */
add_action('widgets_init', create_function('', 'return register_widget("Class_FootnotesWidget");'));

/* only admin is allowed to execute the plugin settings */
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

/* register hook for activating the plugin */
register_activation_hook(__FILE__, array('Class_Footnotes', 'activate'));
/* register hook for deactivating the plugin */
register_deactivation_hook(__FILE__, array('Class_Footnotes', 'deactivate'));
/* register hook for uninstalling the plugin */
register_uninstall_hook(__FILE__, array('Class_Footnotes', 'uninstall'));

/* initialize an object of the plugin class */
global $g_obj_FootnotesPlugin;

/* if object isn't initialized yet, initialize it now */
if (empty($g_obj_FootnotesPlugin)) {
    $g_obj_FootnotesPlugin = new Class_Footnotes();
}