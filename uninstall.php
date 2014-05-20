<?php
/**
 * User: she
 * Date: 29.04.14
 * Time: 15:03
 */

/* check if the wordpress function to uninstall plugins is active */
if (!defined('WP_UNINSTALL_PLUGIN')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

/* uninstalling the plugin is only allowed for logged in users */
if (!is_user_logged_in()) {
	wp_die('You must be logged in to run this script.');
}

/* current user needs the permission to (un)install plugins */
if (!current_user_can('install_plugins')) {
	wp_die('You do not have permission to run this script.');
}