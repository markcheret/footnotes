<?php
/*
    Plugin Name: footnotes
    Plugin URI: https://wordpress.org/plugins/footnotes/
    Description: time to bring footnotes to your website! footnotes are known from offline publishing and everybody takes them for granted when reading a magazine.
    Author: Mark Cheret
    Version: 2.4.0
    Author URI: http://cheret.de/plugins/footnotes-2/
    Text Domain: footnotes
    Domain Path: /languages
*/
define( 'FOOTNOTES_VERSION', '2.4.0' );
/*
    Copyright 2020 Mark Cheret (email: mark@cheret.de)

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
 * @filesource
 * @author Stefan Herndler
 * @since 0.0.1
 */

// Get all common classes and functions
require_once(dirname(__FILE__) . "/includes.php");

// add Plugin Links to the "installed plugins" page
$l_str_plugin_file = 'footnotes/footnotes.php';
add_filter("plugin_action_links_{$l_str_plugin_file}", array("MCI_Footnotes_Hooks", "PluginLinks"), 10, 2);

// initialize the Plugin
$g_obj_MCI_Footnotes = new MCI_Footnotes();
// run the Plugin
$g_obj_MCI_Footnotes->run();
