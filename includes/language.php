<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0
 * Since: 1.0
 */

// action to locate language and load the WordPress-specific language file
add_action('plugins_loaded', 'MCI_Footnotes_LoadLanguage');

/**
 * loads the language file including localization if exists
 * otherwise loads the language file without localization information
 * @since 1.0
 */
function MCI_Footnotes_LoadLanguage() {
    // read current WordPress language
    $l_str_locale = apply_filters('plugin_locale', get_locale(), FOOTNOTES_PLUGIN_NAME);
    // get only language code (removed localization code)
    $l_str_languageCode = MCI_Footnotes_getLanguageCode();

    // language file with localization exists
	$l_bool_loaded = load_textdomain(FOOTNOTES_PLUGIN_NAME, FOOTNOTES_LANGUAGE_DIR . FOOTNOTES_PLUGIN_NAME . '-' . $l_str_locale . '.mo');
	if (empty($l_bool_loaded)) {
		// language file without localization exists
		$l_bool_loaded = load_textdomain(FOOTNOTES_PLUGIN_NAME, FOOTNOTES_LANGUAGE_DIR . FOOTNOTES_PLUGIN_NAME . '-' . $l_str_languageCode . '.mo');
		if (empty($l_bool_loaded)) {
			// fallback to english
			load_textdomain(FOOTNOTES_PLUGIN_NAME, FOOTNOTES_LANGUAGE_DIR . FOOTNOTES_PLUGIN_NAME . '-en.mo');
		}
	}
}

/**
 * reads the WordPress language and returns only the language code lowercase
 * removes the localization code
 * @since 1.0
 * @return string (only the "en" from "en_US")
 */
function MCI_Footnotes_getLanguageCode() {
	// read current WordPress language
    $l_str_locale = apply_filters('plugin_locale', get_locale(), FOOTNOTES_PLUGIN_NAME);
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