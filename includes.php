<?php
/**
 * Includes all common files.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0 14.09.14 13:40
 */

/**
 * Requires (`require_once`) all `*.php` files inside a specific Directory.
 *
 * @author Stefan Herndler
 * @since  1.5.0
 * @param string $p_str_directory Absolute Directory path to lookup for `*.php` files.
 */
function mci_footnotes_require_php_files( $p_str_directory ) {
	// Append slash at the end of the Directory if not exist.
	if ( '/' !== substr( $p_str_directory, -1 ) ) {
		$p_str_directory .= '/';
	}
	// Get all PHP files inside Directory.
	$l_arr_files = scandir( $p_str_directory );
	// Iterate through each class.
	foreach ( $l_arr_files as $l_str_file_name ) {
		// Skip all non-PHP files.
		if ( '.php' !== strtolower( substr( $l_str_file_name, -4 ) ) ) {
			continue;
		}
		// phpcs:disable Generic.Commenting.DocComment.MissingShort
		/** @noinspection PhpIncludeInspection */
		require_once $p_str_directory . $l_str_file_name;
		// phpcs:enable
	}
}

mci_footnotes_require_php_files( dirname( __FILE__ ) . '/class' );
mci_footnotes_require_php_files( dirname( __FILE__ ) . '/class/dashboard' );
mci_footnotes_require_php_files( dirname( __FILE__ ) . '/class/widgets' );
