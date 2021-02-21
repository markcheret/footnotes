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
 * @param string $p_str_directory Absolute Directory path to lookup for *.php files
 */
function MCI_Footnotes_require_php_files( $p_str_directory ) {
	// append slash at the end of the Directory if not exist
	if ( substr( $p_str_directory, -1 ) != '/' ) {
		$p_str_directory .= '/';
	}
	// get all PHP files inside Directory
	$l_arr_files = scandir( $p_str_directory );
	// iterate through each class
	foreach ( $l_arr_files as $l_str_file_name ) {
		// skip all non *.php files
		if ( strtolower( substr( $l_str_file_name, -4 ) ) != '.php' ) {
			continue;
		}
		/** @noinspection Php_include_inspection */
		require_once( $p_str_directory . $l_str_file_name );
	}
}

MCI_Footnotes_require_php_files( dirname( __FILE__ ) . '/class' );
MCI_Footnotes_require_php_files( dirname( __FILE__ ) . '/class/dashboard' );
MCI_Footnotes_require_php_files( dirname( __FILE__ ) . '/class/widgets' );
