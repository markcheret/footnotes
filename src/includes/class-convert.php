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
	 * @param  int    $p_int_index  Index to be converted.
	 * @param  string $p_str_convert_style  Counter style to use.
	 * @return  string  The index converted to the defined counter style.
	 *
	 * @since  1.5.0
	 */
	public static function index( int $p_int_index, string $p_str_convert_style = 'arabic_plain' ): string {
		switch ( $p_str_convert_style ) {
			case 'roman':
				return self::to_roman( $p_int_index, true );
			case 'roman_low':
				return self::to_roman( $p_int_index, false );
			case 'latin_high':
				return self::to_latin( $p_int_index, true );
			case 'latin_low':
				return self::to_latin( $p_int_index, false );
			case 'arabic_leading':
				return self::to_arabic_leading( $p_int_index );
			case 'arabic_plain':
			default:
				return (string) $p_int_index;
		}
	}

	/**
	 * Converts an integer into Latin ASCII characters, either lower or upper-case.
	 *
	 * This function works from values A–ZZ (meaning there is a limit of 676
	 * gootnotes per Page).
	 *
	 * @param  int  $p_int_value  Value to be converted.
	 * @param  bool $p_bool_upper_case  Whether to convert the value to upper-case.
	 *
	 * @since  1.0-gamma
	 * @todo  Replace with built-in char casting.
	 */
	private static function to_latin( int $p_int_value, bool $p_bool_upper_case ): string {
		// Output string.
		$l_str_return = '';
		$l_int_offset = 0;
		// Check if the value is higher then 26 = Z.
		while ( $p_int_value > 26 ) {
			// Increase offset and reduce counter.
			$l_int_offset++;
			$p_int_value -= 26;
		}
		// If offset set (more then Z), then add a new letter in front.
		if ( $l_int_offset > 0 ) {
			$l_str_return = chr( $l_int_offset + 64 );
		}
		// Add the origin letter.
		$l_str_return .= chr( $p_int_value + 64 );
		// Return the latin character representing the integer.
		if ( $p_bool_upper_case ) {
			return strtoupper( $l_str_return );
		}
		return strtolower( $l_str_return );
	}

	/**
	 * Converts an integer to a leading-0 integer.
	 *
	 * @param  int $p_int_value  Value to be converted.
	 * @return  string  Value with a leading zero.
	 *
	 * @since  1.0-gamma
	 * @todo  Replace with built-in string formatting.
	 */
	private static function to_arabic_leading( int $p_int_value ): string {
		// Add a leading 0 if number lower then 10.
		if ( $p_int_value < 10 ) {
			return '0' . $p_int_value;
		}
		return $p_int_value;
	}

	/**
	 * Converts an integer to a Roman numeral.
	 *
	 * @param  int  $p_int_value  Value to be converted.
	 * @param  bool $p_bool_upper_case  Whether to convert the value to upper-case.
	 *
	 * @since  1.0-gamma
	 */
	private static function to_roman( int $p_int_value, bool $p_bool_upper_case ): string {
		// Table containing all necessary roman letters.
		$l_arr_roman_numerals = array(
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
		$l_str_return = '';
		// Iterate through integer value until it is reduced to 0.
		while ( $p_int_value > 0 ) {
			foreach ( $l_arr_roman_numerals as $l_str_roman => $l_int_arabic ) {
				if ( $p_int_value >= $l_int_arabic ) {
					$p_int_value  -= $l_int_arabic;
					$l_str_return .= $l_str_roman;
					break;
				}
			}
		}
		// Return roman letters as string.
		if ( $p_bool_upper_case ) {
			return strtoupper( $l_str_return );
		}
		return strtolower( $l_str_return );
	}

	/**
	 * Converts a string depending on its value to a boolean.
	 *
	 * @param  string $p_str_value  String to be converted to boolean.
	 * @return  bool  Boolean value represented by the string.
	 *
	 * @since  1.0-beta
	 * @todo  Replace with built-in type casting.
	 */
	public static function to_bool( string $p_str_value ): bool {
		// Convert string to lower-case to make it easier.
		$p_str_value = strtolower( $p_str_value );
		// Check if string seems to contain a "true" value.
		switch ( $p_str_value ) {
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
	 * @param  int $p_int_index Index representing the arrow. If empty, all arrows are specified.
	 * @return  string|string[]  Array of all arrows if index is empty, otherwise HTML tag of a specific arrow.
	 *
	 * @since  1.3.2
	 * @todo  Review.
	 * @todo  Single return type.
	 */
	public static function get_arrow( int $p_int_index = -1 ): string|array {
		// Define all possible arrows.
		$l_arr_arrows = array( '&#8593;', '&#8613;', '&#8607;', '&#8617;', '&#8626;', '&#8629;', '&#8657;', '&#8673;', '&#8679;', '&#65514;' );
		// Convert index to an integer.
		if ( ! is_int( $p_int_index ) ) {
			$p_int_index = (int) $p_int_index;
		}
		// Return the whole arrow array.
		if ($p_int_index < 0) {
			return $l_arr_arrows;
		}
		if ($p_int_index > count( $l_arr_arrows )) {
			return $l_arr_arrows;
		}
		// Return a single arrow.
		return $l_arr_arrows[ $p_int_index ];
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
	// phpcs:enable WordPress.PHP.DevelopmentFunctions.error_log_var_dump, WordPress.PHP.DevelopmentFunctions.error_log_print_r
}
