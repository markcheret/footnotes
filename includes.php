<?php
/**
 * Includes all common files.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 13:40
 */

/**
 * Requires (require_once) all *.php files inside a specific Directory.
 *
 * @author Stefan Herndler
 * @since  1.5.0
 * @param string $p_str_Directory Absolute Directory path to lookup for *.php files
 */
function MCI_Footnotes_requirePhpFiles($p_str_Directory) {
	// append slash at the end of the Directory if not exist
	if (substr($p_str_Directory, -1) != "/") {
		$p_str_Directory .= "/";
	}
	// get all PHP files inside Directory
	$l_arr_Files = scandir($p_str_Directory);
	// iterate through each class
	foreach ($l_arr_Files as $l_str_FileName) {
		// skip all non *.php files
		if (strtolower(substr($l_str_FileName, -4)) != ".php") {
			continue;
		}
		/** @noinspection PhpIncludeInspection */
		require_once($p_str_Directory . $l_str_FileName);
	}
}

MCI_Footnotes_requirePhpFiles(dirname(__FILE__) . "/class");
MCI_Footnotes_requirePhpFiles(dirname(__FILE__) . "/class/dashboard");
MCI_Footnotes_requirePhpFiles(dirname(__FILE__) . "/class/widgets");