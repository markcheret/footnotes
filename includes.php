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
 * @param string $directory Absolute Directory path to lookup for `*.php` files.
 */
function mci_footnotes_require_php_files( $directory ) {
	// Append slash at the end of the Directory if not exist.
	if ( '/' !== substr( $directory, -1 ) ) {
		$directory .= '/';
	}
	// Get all PHP files inside Directory.
	$files = scandir( $directory );
	// Iterate through each class.
	foreach ( $files as $file_name ) {
		// Skip all non-PHP files.
		if ( '.php' !== strtolower( substr( $file_name, -4 ) ) ) {
			continue;
		}
		// phpcs:disable Generic.Commenting.DocComment.MissingShort
		/** @noinspection PhpIncludeInspection */
		require_once $directory . $file_name;
		// phpcs:enable
	}
}

mci_footnotes_require_php_files( dirname( __FILE__ ) . '/class' );
mci_footnotes_require_php_files( dirname( __FILE__ ) . '/class/dashboard' );
mci_footnotes_require_php_files( dirname( __FILE__ ) . '/class/widgets' );
