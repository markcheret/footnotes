<?php
/**
 * 
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 17:47
 */

/**
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Language {

	/**
	 * Register WordPress Hook.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public static function registerHooks() {
		add_action('plugins_loaded', array("MCI_Footnotes_Language", "loadTextDomain"));
	}

	/**
	 * Loads the text domain for current WordPress language if exists. Otherwise fallback "en" will be loaded.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public static function loadTextDomain() {
		// language file with localization exists
		if (self::load(apply_filters('plugin_locale', get_locale()))) {
			return;
		}
		// language file without localization exists
		if (self::load(self::getLanguageCode())) {
			return;
		}
		// fallback to english
		self::load("en");
	}

	/**
	 * Loads a specific text domain.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.1
	 * @param string $p_str_LanguageCode Language Code to load a specific text domain.
	 * @return bool
	 */
	private static function load($p_str_LanguageCode) {
		return load_textdomain(MCI_Footnotes_Config::C_STR_PLUGIN_NAME,
			dirname(__FILE__) . "/../languages/" . MCI_Footnotes_Config::C_STR_PLUGIN_NAME . "-" . $p_str_LanguageCode . '.mo');
	}

	/**
	 * Returns the Language Code of the WordPress language. (only "en" from "en_US")
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	private static function getLanguageCode() {
		// read current WordPress language
		$l_str_locale = apply_filters('plugin_locale', get_locale());
		// check if WordPress language has a localization (e.g. "en_US" or "de_AT")
		if (strpos($l_str_locale, "_") !== false) {
			// remove localization code
			$l_arr_languageCode = explode("_", $l_str_locale);
			$l_str_languageCode = $l_arr_languageCode[0];
			return $l_str_languageCode;
		}
		// return language code lowercase
		return strtolower($l_str_locale);
	}
}