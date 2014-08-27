<?php
/*
	Plugin Name: footnotes
	Plugin URI: http://wordpress.org/plugins/footnotes/
	Description: time to bring footnotes to your website! footnotes are known from offline publishing and everybody takes them for granted when reading a magazine.
	Author: ManFisher Medien ManuFaktur
	Version: 1.3.3
	Author URI: http://manfisher.net/plugins/footnotes/
	Text Domain: footnotes
	Domain Path: /languages
*/
/*
	Copyright 2014  Mark Cheret, Stefan Herndler (email : info@manfisher.eu | support@herndler.org)

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

// include constants
require_once(dirname(__FILE__) . "/includes/defines.php");
// include language functions
require_once(dirname(__FILE__) . "/includes/language.php");
// include storage functions and global plugin functions
require_once(dirname(__FILE__) . "/includes/plugin-settings.php");

// require plugin class
require_once(dirname( __FILE__ ) . "/classes/footnotes.php");


// initialize an object of the plugin class
global $g_obj_MCI_Footnotes;
// if object isn't initialized yet, initialize it now
if (empty($g_obj_MCI_Footnotes)) {
	$g_obj_MCI_Footnotes = new MCI_Footnotes();
}

// register hook for activating the plugin
register_activation_hook(__FILE__, array('MCI_Footnotes', 'activate'));
// register hook for deactivating the plugin
register_deactivation_hook(__FILE__, array('MCI_Footnotes', 'deactivate'));

// only admin is allowed to execute the following functions
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// register hook for uninstalling the plugin
register_uninstall_hook(__FILE__, array('MCI_Footnotes', 'uninstall'));

