<?php
/*
	Plugin Name: footnotes
	Plugin URI: http://www.herndler.org
	Description: simple adding footnotes to your pages
	Author: Mark Cheret, Stefan Herndler
	Version: 1.0.0
	Author URI: http://www.cheret.de
	Text Domain: footnotes
	Domain Path: /languages
*/

/*
	Copyright 2014  Mark Cheret, Stefan Herndler (email : mark@cheret.de | admin@herndler.org)

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
 * User: she
 * Date: 02.05.14
 * Time: 16:21
 */


/* include all defines */
require_once(dirname(__FILE__) . "/constants.php");
/* require plugin global functions */
require_once(dirname(__FILE__) . "/functions.php");

/* calls the wordpress filter function to replace content before displayed on public pages */
add_filter('the_content', 'footnotes_replace_public_placeholders');
add_filter('the_excerpt', 'footnotes_replace_public_placeholders');

add_filter('widget_title', 'footnotes_replace_public_placeholders', 11);
add_filter('widget_text', 'footnotes_replace_public_placeholders', 99 );

/* adds javascript and stylesheets to the public page */
add_action('wp_enqueue_scripts', 'footnotes_public_page_scripts');

/* only admin is allowed to execute the plugin settings */
if (!function_exists('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

/* require plugin class */
require_once(dirname(__FILE__) . "/plugin.class.php");
/* require plugin settings class */
require_once(dirname(__FILE__) . "/settings.class.php");

/* action to locate language and load the wordpress-specific language file */
add_action('plugins_loaded', 'footnotes_load_language');

/* add link to the settings page in plugin main page */
$l_str_plugin_file = FOOTNOTES_PLUGIN_DIR_NAME . '/index.php';
add_filter("plugin_action_links_{$l_str_plugin_file}", 'footnotes_plugin_settings_link', 10, 2);

/* initialize an object of the plugin class */
global $g_obj_FootnotesPlugin;

/* if object isn't initialized yet, initialize it now */
if (empty($g_obj_FootnotesPlugin)) {
	$g_obj_FootnotesPlugin = new footnotes_class_plugin();
}