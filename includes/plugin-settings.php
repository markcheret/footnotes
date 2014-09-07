<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0-beta
 * Since: 1.0
 */

// add link to the settings page in plugin main page
$l_str_plugin_file = FOOTNOTES_PLUGIN_DIR_NAME . '/index.php';
add_filter("plugin_action_links_{$l_str_plugin_file}", 'MCI_Footnotes_PluginLinks', 10, 2);

/**
 * add short links to the plugin main page
 * @since 1.0
 * @param array $p_arr_Links
 * @param string $p_str_File
 * @return array
 */
function MCI_Footnotes_PluginLinks($p_arr_Links, $p_str_File) {
    // add link to the footnotes plugin settings page
    $l_str_Settings = '<a href="' . admin_url('options-general.php?page=' . FOOTNOTES_SETTINGS_PAGE_ID) . '">' . __('Settings', FOOTNOTES_PLUGIN_NAME) . '</a>';
	// add link to the footnotes plugin support page on wordpress.org
	$l_str_Support = '<a href="http://wordpress.org/support/plugin/footnotes" target="_blank">' . __('Support', FOOTNOTES_PLUGIN_NAME) . '</a>';
	// add link to Donate
	$l_str_Donate = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6Z6CZDW8PPBBJ" target="_blank">' . __('Donate', FOOTNOTES_PLUGIN_NAME) . '</a>';

	// add defined links to the plugin main page
	$p_arr_Links[] = $l_str_Support;
	$p_arr_Links[] = $l_str_Settings;
	$p_arr_Links[] = $l_str_Donate;

    // return new links
    return $p_arr_Links;
}

/**
 * reads a option field, filters the values and returns the filtered option array
 * fallback to default value since 1.0-gamma
 * @since 1.0
 * @param bool $p_bool_ConvertHtmlChars
 * @return array
 */
function MCI_Footnotes_getOptions($p_bool_ConvertHtmlChars = true) {
	// default settings for the 'general' settings container
	$l_arr_Default_General = array(
		FOOTNOTES_INPUT_COMBINE_IDENTICAL => 'yes',
		FOOTNOTES_INPUT_REFERENCES_LABEL => 'References',
		FOOTNOTES_INPUT_COLLAPSE_REFERENCES => '',
		FOOTNOTES_INPUT_PLACEHOLDER_START => '((',
		FOOTNOTES_INPUT_PLACEHOLDER_END => '))',
		FOOTNOTES_INPUT_SEARCH_IN_EXCERPT => 'yes',
		FOOTNOTES_INPUT_LOVE => 'no',
		FOOTNOTES_INPUT_COUNTER_STYLE => 'arabic_plain',
		FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE => 'post_end',
		FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED => '',
		FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED => ''
	);
	// default settings for the 'custom' settings container
	$l_arr_Default_Custom = array(
		FOOTNOTES_INPUT_CUSTOM_CSS => '',
		FOOTNOTES_INPUT_CUSTOM_STYLING_BEFORE => '',
		FOOTNOTES_INPUT_CUSTOM_STYLING_AFTER => ')',
		FOOTNOTES_INPUT_CUSTOM_HYPERLINK_SYMBOL => '&#8593;',
		FOOTNOTES_INPUT_CUSTOM_HYPERLINK_SYMBOL_USER => ''
	);

    $l_arr_General = MCI_Footnotes_ValidateOptions(get_option(FOOTNOTES_SETTINGS_CONTAINER), $l_arr_Default_General, $p_bool_ConvertHtmlChars);
	$l_arr_Custom = MCI_Footnotes_ValidateOptions(get_option(FOOTNOTES_SETTINGS_CONTAINER_CUSTOM), $l_arr_Default_Custom, $p_bool_ConvertHtmlChars);

	return array_merge($l_arr_General, $l_arr_Custom);
}

/**
 * validate each option, fallback is the default value
 * @since 1.3
 * @param array $p_arr_Options
 * @param array $p_arr_Default
 * @param bool $p_bool_ConvertHtmlChars
 * @return array
 */
function MCI_Footnotes_ValidateOptions($p_arr_Options, $p_arr_Default, $p_bool_ConvertHtmlChars) {
	// if no settings set yet return default values
	if (empty($p_arr_Options)) {
		return $p_arr_Default;
	}
	// loop through all keys in the array and filters them
	foreach ($p_arr_Options as $l_str_Key => $l_str_Value) {
		// removes special chars from the settings value
		$l_str_Value = stripcslashes($l_str_Value);
		// if set, convert html special chars
		if ($p_bool_ConvertHtmlChars) {
			$l_str_Value = htmlspecialchars($l_str_Value);
		}
		// check if settings value is not empty, otherwise load the default value, or empty string if no default is defined
		if (!empty($l_str_Value)) {
			$p_arr_Options[$l_str_Key] = $l_str_Value;
			// check if default value is defined
		//} else if (array_key_exists($l_str_Key, $p_arr_Default)) {
		//	$p_arr_Options[$l_str_Key] = $p_arr_Default[$l_str_Key];
		} else {
			$p_arr_Options[$l_str_Key] = "";
		}
	}

	// check if each key from the default values exist in return array
	foreach($p_arr_Default as $l_str_Key => $l_str_Value) {
		// if key not exists, add it with its default value
		if (!array_key_exists($l_str_Key, $p_arr_Options)) {
			$p_arr_Options[$l_str_Key] = $l_str_Value;
		}
	}
	// returns the filtered array
	return $p_arr_Options;
}