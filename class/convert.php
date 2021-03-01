<?php
/**
 * Includes the Convert Class.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 12.09.14 10:56
 * 
 * Edited:
 * @since 2.2.0  add lowercase Roman   2020-12-12T1540+0100
 * 
 * Last modified:  2020-12-12T1541+0100
 */


/**
 * Converts data types and Footnotes specific values.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Convert {

	/**
	 * Converts a integer into the user-defined counter style for the footnotes.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param int $p_int_Index Index to be converted.
	 * @param string $p_str_ConvertStyle Style of the new/converted Index.
	 * @return string Converted Index as string in the defined counter style.
	 * 
	 * Edited:
	 * @since 2.2.0  lowercase Roman numerals supported
	 */
	public static function Index($p_int_Index, $p_str_ConvertStyle = "arabic_plain") {
		switch ($p_str_ConvertStyle) {
			case "romanic":
				return self::toRomanic($p_int_Index, true);
			case "roman_low":
				return self::toRomanic($p_int_Index, false);
			case "latin_high":
				return self::toLatin($p_int_Index, true);
			case "latin_low":
				return self::toLatin($p_int_Index, false);
			case "arabic_leading":
				return self::toArabicLeading($p_int_Index);
			case "arabic_plain":
			default:
				return $p_int_Index;
		}
	}

	/**
	 * Converts an integer into latin ascii characters, either lower or upper-case.
	 * Function available from A to ZZ ( means 676 footnotes at 1 page possible).
	 *
	 * @author Stefan Herndler
	 * @since 1.0-gamma
	 * @param int $p_int_Value Value/Index to be converted.
	 * @param bool $p_bool_UpperCase True to convert the value to upper case letter, otherwise to lower case.
	 * @return string
	 */
	private static function toLatin($p_int_Value, $p_bool_UpperCase) {
		// output string
		$l_str_Return = "";
		$l_int_Offset = 0;
		// check if the value is higher then 26 = Z
		while ($p_int_Value > 26) {
			// increase offset and reduce counter
			$l_int_Offset++;
			$p_int_Value -= 26;
		}
		// if offset set (more then Z), then add a new letter in front
		if ($l_int_Offset > 0) {
			$l_str_Return = chr($l_int_Offset + 64);
		}
		// add the origin letter
		$l_str_Return .= chr($p_int_Value + 64);
		// return the latin character representing the integer
		if ($p_bool_UpperCase) {
			return strtoupper($l_str_Return);
		}
		return strtolower($l_str_Return);
	}

	/**
	 * Converts an integer to a leading-0 integer.
	 *
	 * @author Stefan Herndler
	 * @since 1.0-gamma
	 * @param int $p_int_Value Value/Index to be converted.
	 * @return string Value with a leading zero.
	 */
	private static function toArabicLeading($p_int_Value) {
		// add a leading 0 if number lower then 10
		if ($p_int_Value < 10) {
			return "0" . $p_int_Value;
		}
		return $p_int_Value;
	}

	/**
	 * Converts an integer to a romanic letter.
	 *
	 * @author Stefan Herndler
	 * @since 1.0-gamma
	 * @param int $p_int_Value Value/Index to be converted.
	 * @return string
	 * 
	 * Edited:
	 * @since 2.2.0   optionally lowercase (code from Latin)   2020-12-12T1538+0100
	 */
	private static function toRomanic($p_int_Value, $p_bool_UpperCase) {
		// table containing all necessary romanic letters
		$l_arr_RomanicLetters = array(
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1
		);
		// return value
		$l_str_Return = '';
		// iterate through integer value until it is reduced to 0
		while ($p_int_Value > 0) {
			foreach ($l_arr_RomanicLetters as $l_str_Romanic => $l_int_Arabic) {
				if ($p_int_Value >= $l_int_Arabic) {
					$p_int_Value -= $l_int_Arabic;
					$l_str_Return .= $l_str_Romanic;
					break;
				}
			}
		}
		// return romanic letters as string
		if ($p_bool_UpperCase) {
			return strtoupper($l_str_Return);
		}
		return strtolower($l_str_Return);
	}

	/**
	 * Converts a string depending on its value to a boolean.
	 *
	 * @author Stefan Herndler
	 * @since 1.0-beta
	 * @param string $p_str_Value String to be converted to boolean.
	 * @return bool Boolean representing the string.
	 */
	public static function toBool($p_str_Value) {
		// convert string to lower-case to make it easier
		$p_str_Value = strtolower($p_str_Value);
		// check if string seems to contain a "true" value
		switch ($p_str_Value) {
			case "checked":
			case "yes":
			case "true":
			case "on":
			case "1":
				return true;
		}
		// nothing found that says "true", so we return false
		return false;
	}

	/**
	 * Get a html Array short code depending on Arrow-Array key index.
	 *
	 * @author Stefan Herndler
	 * @since 1.3.2
	 * @param int $p_int_Index Index representing the Arrow. If empty all Arrows are specified.
	 * @return array|string Array of all Arrows if Index is empty otherwise html tag of a specific arrow.
	 */
	public static function getArrow($p_int_Index = -1) {
		// define all possible arrows
		$l_arr_Arrows = array("&#8593;", "&#8613;", "&#8607;", "&#8617;", "&#8626;", "&#8629;", "&#8657;", "&#8673;", "&#8679;", "&#65514;");
		// convert index to an integer
		if (!is_int($p_int_Index)) {
			$p_int_Index = intval($p_int_Index);
		}
		// return the whole arrow array
		if ($p_int_Index < 0 || $p_int_Index > count($l_arr_Arrows)) {
			return $l_arr_Arrows;
		}
		// return a single arrow
		return $l_arr_Arrows[$p_int_Index];
	}

	/**
	 * Displays a Variable.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param mixed $p_mixed_Value
	 */
	public static function debug($p_mixed_Value) {
		if (empty($p_mixed_Value)) {
			var_dump($p_mixed_Value);

		} else if (is_array($p_mixed_Value)) {
			printf("<pre>");
			print_r($p_mixed_Value);
			printf("</pre>");

		} else if (is_object($p_mixed_Value)) {
			printf("<pre>");
			print_r($p_mixed_Value);
			printf("</pre>");

		} else if (is_numeric($p_mixed_Value) || is_int($p_mixed_Value)) {
			var_dump($p_mixed_Value);

		} else if (is_date($p_mixed_Value)) {
			var_dump($p_mixed_Value);

		} else {
			var_dump($p_mixed_Value);
		}
		echo "<br/>";
	}
}
