<?php
/**
 * File providing core `Convert` class.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Rename file from `convert.php` to `class-footnotes-convert.php`,
 *                              rename `class/` sub-directory to `includes/`.
 */

declare(strict_types=1);

namespace footnotes\includes;

/**
 * Class providing variable type and value conversion functions.
 *
 * @since 1.5.0
 */
class Convert {

	/**
	 * Converts an integer into the user-defined counter style for the footnotes.
	 *
	 * @param  int    $index  Index to be converted.
	 * @param  string $convert_style  Counter style to use.
	 * @return  string  The index converted to the defined counter style.
	 *
	 * @since  1.5.0
	 */
	public static function index( int $index, string $convert_style = 'arabic_plain' ): string {
		switch ( $convert_style ) {
			case 'roman':
				return self::to_roman( $index, true );
			case 'roman_low':
				return self::to_roman( $index, false );
			case 'latin_high':
				return self::to_latin( $index, true );
			case 'latin_low':
				return self::to_latin( $index, false );
			case 'arabic_leading':
				return self::to_arabic_leading( $index );
			case 'arabic_plain':
			default:
				return (string) $index;
		}
	}

	/**
	 * Converts a string depending on its value to a boolean.
	 *
	 * @param  string $value  String to be converted to boolean.
	 * @return  bool  Boolean value represented by the string.
	 *
	 * @since  1.0-beta
	 * @todo  Replace with built-in type casting.
	 */
	public static function to_bool( string|null $value ): bool {
		if (!$value) return false;
		
		// Convert string to lower-case to make it easier.
		$value = strtolower( $value );
		// Check if string seems to contain a "true" value.
		switch ( $value ) {
			case 'checked':
			case 'yes':
			case 'true':
			case 'on':
			case '1':
				return true;
		}
		// Nothing found that says "true", so we return false.
		return false;
	}

	/**
	 * Get an HTML array short code depending on Arrow-Array key index.
	 *
	 * @param  int $index Index representing the arrow. If empty, all arrows are specified.
	 * @return string|string[] Array of all arrows if index is empty, otherwise HTML tag of a specific arrow.
	 *
	 * @since  1.3.2
	 * @todo  Review.
	 * @todo  Single return type.
	 */
	public static function get_arrow( int $index = -1 ): string|array {
		// Define all possible arrows.
		$arrows = array( '&#8593;', '&#8613;', '&#8607;', '&#8617;', '&#8626;', '&#8629;', '&#8657;', '&#8673;', '&#8679;', '&#65514;' );
		
		// Return the whole arrow array.
		if ( $index < 0 ) {
			return $arrows;
		}
		if ( $index > count( $arrows ) ) {
			return $arrows;
		}
		// Return a single arrow.
		return $arrows[ $index ];
	}

	// phpcs:disable WordPress.PHP.DevelopmentFunctions.error_log_var_dump, WordPress.PHP.DevelopmentFunctions.error_log_print_r
	/**
	 * Displays a variable.
	 *
	 * @param  mixed $p_mixed_value  The variable to display.
	 * @return void
	 *
	 * @since  1.5.0
	 * @todo  Replace with proper logging/debug functions.
	 */
	public static function debug( $p_mixed_value ) {
		if ( empty( $p_mixed_value ) ) {
			var_dump( $p_mixed_value );

		} elseif ( is_array( $p_mixed_value ) ) {
			printf( '<pre>' );
			print_r( $p_mixed_value );
			printf( '</pre>' );

		} elseif ( is_object( $p_mixed_value ) ) {
			printf( '<pre>' );
			print_r( $p_mixed_value );
			printf( '</pre>' );

		} elseif ( is_numeric( $p_mixed_value ) || is_int( $p_mixed_value ) ) {
			var_dump( $p_mixed_value );

		} elseif ( is_date( $p_mixed_value ) ) {
			var_dump( $p_mixed_value );

		} else {
			var_dump( $p_mixed_value );
		}
		echo '<br/>';
	}
	/**
	 * Converts an integer into Latin ASCII characters, either lower or upper-case.
	 *
	 * This function works from values A–ZZ (meaning there is a limit of 676
	 * gootnotes per Page).
	 *
	 * @param  int  $value  Value to be converted.
	 * @param  bool $upper_case  Whether to convert the value to upper-case.
	 *
	 * @since  1.0-gamma
	 * @todo  Replace with built-in char casting.
	 */
	private static function to_latin( int $value, bool $upper_case ): string {
		// Output string.
		$return = '';
		$offset = 0;
		// Check if the value is higher then 26 = Z.
		while ( $value > 26 ) {
			// Increase offset and reduce counter.
			$offset++;
			$value -= 26;
		}
		// If offset set (more then Z), then add a new letter in front.
		if ( $offset > 0 ) {
			$return = chr( $offset + 64 );
		}
		// Add the origin letter.
		$return .= chr( $value + 64 );
		// Return the latin character representing the integer.
		if ( $upper_case ) {
			return strtoupper( $return );
		}
		return strtolower( $return );
	}
	/**
	 * Converts an integer to a leading-0 integer.
	 *
	 * @param  int $value  Value to be converted.
	 * @return  string  Value with a leading zero.
	 *
	 * @since  1.0-gamma
	 * @todo  Replace with built-in string formatting.
	 */
	private static function to_arabic_leading( int $value ): string {
		// Add a leading 0 if number lower then 10.
		if ( $value < 10 ) {
			return '0' . $value;
		}
		return $value;
	}
	/**
	 * Converts an integer to a Roman numeral.
	 *
	 * @param  int  $value  Value to be converted.
	 * @param  bool $upper_case  Whether to convert the value to upper-case.
	 *
	 * @since  1.0-gamma
	 */
	private static function to_roman( int $value, bool $upper_case ): string {
		// Table containing all necessary roman letters.
		$roman_numerals = array(
			'M'  => 1000,
			'CM' => 900,
			'D'  => 500,
			'CD' => 400,
			'C'  => 100,
			'XC' => 90,
			'L'  => 50,
			'XL' => 40,
			'X'  => 10,
			'IX' => 9,
			'V'  => 5,
			'IV' => 4,
			'I'  => 1,
		);
		// Return value.
		$return = '';
		// Iterate through integer value until it is reduced to 0.
		while ( $value > 0 ) {
			foreach ( $roman_numerals as $roman => $arabic ) {
				if ( $value >= $arabic ) {
					$value  -= $arabic;
					$return .= $roman;
					break;
				}
			}
		}
		// Return roman letters as string.
		if ( $upper_case ) {
			return strtoupper( $return );
		}
		return strtolower( $return );
	}
	// phpcs:enable WordPress.PHP.DevelopmentFunctions.error_log_var_dump, WordPress.PHP.DevelopmentFunctions.error_log_print_r
}
