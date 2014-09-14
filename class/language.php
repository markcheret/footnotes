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
		$l_str_LanguagePath = dirname(__FILE__) . "/../languages/" . MCI_Footnotes_Config::C_STR_PLUGIN_NAME - "-";
		// language file with localization exists
		$l_bool_DomainLoaded = load_textdomain(MCI_Footnotes_Config::C_STR_PLUGIN_NAME, $l_str_LanguagePath . apply_filters('plugin_locale', get_locale(), MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . '.mo');
		if (!empty($l_bool_DomainLoaded)) {
			return;
		}
		// language file without localization exists
		$l_bool_DomainLoaded = load_textdomain(MCI_Footnotes_Config::C_STR_PLUGIN_NAME, $l_str_LanguagePath . self::getLanguageCode() . '.mo');
		if (!empty($l_bool_DomainLoaded)) {
			return;
		}
		// fallback to english
		load_textdomain(MCI_Footnotes_Config::C_STR_PLUGIN_NAME, $l_str_LanguagePath . '-en.mo');
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
		$l_str_locale = apply_filters('plugin_locale', get_locale(), MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
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