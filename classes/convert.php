<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 30.07.14 11:45
 * Version: 1.0
 * Since: 1.3
 */

// define class only once
if (!class_exists("MCI_Footnotes_Convert")) :

/**
 * Class MCI_Footnotes_Convert
 * @since 1.3
 */
class MCI_Footnotes_Convert {

	/**
	 * converts a integer into the user-defined counter style for the footnotes
	 * @since 1.0-gamma
	 * @param int $p_int_Index
	 * @param string $p_str_ConvertStyle [counter style]
	 * @return string
	 */
	public static function Index($p_int_Index, $p_str_ConvertStyle = "arabic_plain") {
		switch ($p_str_ConvertStyle) {
			case "romanic":
				return self::toRomanic($p_int_Index);
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
	 * converts a integer into latin ascii characters, either lower or upper-case
	 * function available from A to ZZ ( means 676 footnotes at 1 page possible)
	 * @since 1.0-gamma
	 * @param int $p_int_Value
	 * @param bool $p_bool_UpperCase
	 * @return string
	 */
	private static function toLatin($p_int_Value, $p_bool_UpperCase) {
		// decimal value of the starting ascii character
		$l_int_StartingASCII = 65 - 1; // = A
		// if lower-case, change decimal to lower-case "a"
		if (!$p_bool_UpperCase) {
			$l_int_StartingASCII = 97 - 1; // = a
		}
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
			$l_str_Return = chr($l_int_Offset + $l_int_StartingASCII);
		}
		// add the origin letter
		$l_str_Return .= chr($p_int_Value + $l_int_StartingASCII);
		// return the latin character representing the integer
		return $l_str_Return;
	}

	/**
	 * converts a integer to a leading-0 integer
	 * @since 1.0-gamma
	 * @param int $p_int_Value
	 * @return string
	 */
	private static function toArabicLeading($p_int_Value) {
		// add a leading 0 if number lower then 10
		if ($p_int_Value < 10) {
			return "0" . $p_int_Value;
		}
		return $p_int_Value;
	}

	/**
	 * converts a arabic integer value into a romanic letter value
	 * @since 1.0-gamma
	 * @param int $p_int_Value
	 * @return string
	 */
	private static function toRomanic($p_int_Value) {
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
		return $l_str_Return;
	}

	/**
	 * converts a string depending on its value to a boolean
	 * @since 1.0-beta
	 * @param string $p_str_Value
	 * @return bool
	 */
	public static function toBool($p_str_Value) {
		// convert string to lower-case to make it easier */
		$p_str_Value = strtolower($p_str_Value);
		// check if string seems to contain a "true" value */
		switch ($p_str_Value) {
			case "checked":
			case "yes":
			case "true":
			case "on":
			case "1":
				return true;
		}
		// nothing found that says "true", so we return false */
		return false;
	}
} // class MCI_Footnotes_Convert

endif;