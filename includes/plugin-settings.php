<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0
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
 * @since 1.0
 * @param string $p_str_OptionsField
 * @return array
 */
function footnote_filter_options( $p_str_OptionsField )
{
	$l_arr_Options = get_option( $p_str_OptionsField );
	/* loop through all keys in the array and filters them */
	foreach ( $l_arr_Options as $l_str_Key => $l_str_Value ) {
		$l_arr_Options[ $l_str_Key ] = stripcslashes( $l_str_Value );
	}
	/* returns the filtered array */
	return $l_arr_Options;
}