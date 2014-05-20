<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0-beta
 * Since: 1.0
 */


/**
 * add short links to the plugin main page
 * @since 1.0
 * @param array $links
 * @param mixed $file
 * @return array
 */
function footnotes_plugin_settings_link( $links, $file )
{
	/* add link to the /forms.contact plugin's settings page */
	$settings_link = '<a href="' . admin_url( 'options-general.php?page=' . FOOTNOTES_SETTINGS_PAGE_ID ) . '">' . __( 'Settings', FOOTNOTES_PLUGIN_NAME ) . '</a>';
	array_unshift( $links, $settings_link );

	/* return new links */
	return $links;
}


/**
 * reads a option field, filters the values and returns the filtered option array
 * fallback to default value since 1.0-gamma
 * @since 1.0
 * @param string $p_str_OptionsField
 * @param array $p_arr_DefaultValues
 * @return array
 */
function footnotes_filter_options( $p_str_OptionsField, $p_arr_DefaultValues )
{
	$l_arr_Options = get_option( $p_str_OptionsField );
	/* loop through all keys in the array and filters them */
	foreach ( $l_arr_Options as $l_str_Key => $l_str_Value ) {
		/* removes special chars from the settings value */
		$l_str_Value = stripcslashes( $l_str_Value );
		/* check if settings value is not empty, otherwise load the default value, or empty string if no default is defined */
		if (!empty($l_str_Value)) {
			$l_arr_Options[ $l_str_Key ] = stripcslashes( $l_str_Value );
		/* check if default value is defined */
		} else if (array_key_exists($l_str_Key, $p_arr_DefaultValues)) {
			$l_arr_Options[ $l_str_Key ] = $p_arr_DefaultValues[$l_str_Key];
		} else {
			$l_arr_Options[ $l_str_Key ] = "";
		}
	}
	/* returns the filtered array */
	return $l_arr_Options;
}

/**
 * converts a string depending on its value to a boolean
 * @since 1.0-beta
 * @param string $p_str_Value
 * @return bool
 */
function footnotes_ConvertToBool($p_str_Value) {
	/* convert string to lower-case to make it easier */
	$p_str_Value = strtolower($p_str_Value);
	/* check if string seems to contain a "true" value */
	switch($p_str_Value) {
		case "checked":
		case "yes":
		case "true":
		case "on":
		case "1":
			return true;
	}
	/* nothing found that says "true", so we return false */
	return false;
}