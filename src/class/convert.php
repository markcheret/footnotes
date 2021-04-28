<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Includes the Convert Class.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 *
 * @since 2.2.0  add lowercase Roman
 */

/**
 * Converts data types and Footnotes specific values.
 *
 * @since 1.5.0
 */
class Footnotes_Convert {

	/**
	 * Converts a integer into the user-defined counter style for the footnotes.
	 *
	 * @since 1.5.0
	 * @param int    $p_int_index Index to be converted.
	 * @param string $p_str_convert_style Style of the new/converted Index.
	 * @return string Converted Index as string in the defined counter style.
	 *
	 * Edited:
	 * @since 2.2.0  lowercase Roman numerals supported
	 */
	public static function index( $p_int_index, $p_str_convert_style = 'arabic_plain' ) {
		switch ( $p_str_convert_style ) {
			case 'romanic':
				return self::to_romanic( $p_int_index, true );
			case 'roman_low':
				return self::to_romanic( $p_int_index, false );
			case 'latin_high':
				return self::to_latin( $p_int_index, true );
			case 'latin_low':
				return self::to_latin( $p_int_index, false );
			case 'arabic_leading':
				return self::to_arabic_leading( $p_int_index );
			case 'arabic_plain':
			default:
				return $p_int_index;
		}
	}

	/**
	 * Converts an integer into latin ascii characters, either lower or upper-case.
	 * Function available from A to ZZ ( means 676 footnotes at 1 page possible).
	 *
	 * @since 1.0-gamma
	 * @param int  $p_int_value Value/Index to be converted.
	 * @param bool $p_bool_upper_case True to convert the value to upper case letter, otherwise to lower case.
	 * @return string
	 */
	private static function to_latin( $p_int_value, $p_bool_upper_case ) {
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
	 * @since 1.0-gamma
	 * @param int $p_int_value Value/Index to be converted.
	 * @return string Value with a leading zero.
	 */
	private static function to_arabic_leading( $p_int_value ) {
		// Add a leading 0 if number lower then 10.
		if ( $p_int_value < 10 ) {
			return '0' . $p_int_value;
		}
		return $p_int_value;
	}

	/**
	 * Converts an integer to a romanic letter.
	 *
	 * @since 1.0-gamma
	 * @param int  $p_int_value Value/Index to be converted.
	 * @param bool $p_bool_upper_case Whether to uppercase.
	 * @return string
	 *
	 * Edited:
	 * @since 2.2.0   optionally lowercase (code from Latin)
	 */
	private static function to_romanic( $p_int_value, $p_bool_upper_case ) {
		// Table containing all necessary romanic letters.
		$l_arr_romanic_letters = array(
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
			foreach ( $l_arr_romanic_letters as $l_str_romanic => $l_int_arabic ) {
				if ( $p_int_value >= $l_int_arabic ) {
					$p_int_value  -= $l_int_arabic;
					$l_str_return .= $l_str_romanic;
					break;
				}
			}
		}
		// Return romanic letters as string.
		if ( $p_bool_upper_case ) {
			return strtoupper( $l_str_return );
		}
		return strtolower( $l_str_return );
	}

	/**
	 * Converts a string depending on its value to a boolean.
	 *
	 * @since 1.0-beta
	 * @param string $p_str_value String to be converted to boolean.
	 * @return bool Boolean representing the string.
	 */
	public static function to_bool( $p_str_value ) {
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
	 * Get a html Array short code depending on Arrow-Array key index.
	 *
	 * @since 1.3.2
	 * @param int $p_int_index Index representing the Arrow. If empty all Arrows are specified.
	 * @return array|string Array of all Arrows if Index is empty otherwise html tag of a specific arrow.
	 */
	public static function get_arrow( $p_int_index = -1 ) {
		// Define all possible arrows.
		$l_arr_arrows = array( '&#8593;', '&#8613;', '&#8607;', '&#8617;', '&#8626;', '&#8629;', '&#8657;', '&#8673;', '&#8679;', '&#65514;' );
		// Convert index to an integer.
		if ( ! is_int( $p_int_index ) ) {
			$p_int_index = intval( $p_int_index );
		}
		// Return the whole arrow array.
		if ( $p_int_index < 0 || $p_int_index > count( $l_arr_arrows ) ) {
			return $l_arr_arrows;
		}
		// Return a single arrow.
		return $l_arr_arrows[ $p_int_index ];
	}

	// phpcs:disable WordPress.PHP.DevelopmentFunctions.error_log_var_dump
	// phpcs:disable WordPress.PHP.DevelopmentFunctions.error_log_print_r
	/**
	 * Displays a Variable.
	 *
	 * @since 1.5.0
	 * @param mixed $p_mixed_value The variable to display.
	 * @return void
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
	// phpcs:disable
}
