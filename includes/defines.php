<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0-beta
 * Since: 1.0
 */

// PLUGIN INTERNAL NAME
define("FOOTNOTES_PLUGIN_NAME", "footnotes");
// PLUGIN PUBLIC NAME WITH STYLING
// @since 1.0.7
define("FOOTNOTES_PLUGIN_PUBLIC_NAME", '<span class="footnote_tag_styling footnote_tag_styling_1">foot</span><span class="footnote_tag_styling footnote_tag_styling_2">notes</span>');
// PLUGIN PUBLIC NAME WITH STYLING AND LINK
// @since 1.2.2
define("FOOTNOTES_PLUGIN_PUBLIC_NAME_LINKED", '<a href="http://wordpress.org/plugins/footnotes/" target="_blank" style="text-decoration:none;">' . FOOTNOTES_PLUGIN_PUBLIC_NAME . '</a>');
// PLUGIN LOVE SYMBOL WITH STYLING
// @since 1.2.2
define("FOOTNOTES_LOVE_SYMBOL", '<span style="color:#ff6d3b; font-weight:bold;">&hearts;</span>');


// PLUGIN DIRECTORIES
define("FOOTNOTES_PLUGIN_DIR_NAME", "footnotes");
define("FOOTNOTES_LANGUAGE_DIR", dirname(__FILE__) . "/../languages/");
define("FOOTNOTES_TEMPLATES_DIR", dirname(__FILE__) . "/../templates/");


// SETTINGS CONTAINER
define("FOOTNOTES_SETTINGS_CONTAINER", "footnotes_storage"); // database container where all footnote settings are stored
define("FOOTNOTES_SETTINGS_CONTAINER_CUSTOM", "footnotes_storage_custom"); // database container where all 'custom' settings are stored
// PLUGIN SETTINGS PAGE
define("FOOTNOTES_SETTINGS_PAGE_ID", "footnotes"); // plugins setting page internal id
// PLUGIN SETTINGS PAGE TABS
define("FOOTNOTES_SETTINGS_TAB_GENERAL", "footnotes_general_settings"); // internal label for the plugins general settings tab
define("FOOTNOTES_SETTINGS_TAB_CUSTOM", "footnotes_custom_settings"); // internal label for the plugins custom settings tab
define("FOOTNOTES_SETTINGS_TAB_HOWTO", "footnotes_howto_settings"); // internal label for the plugins how to tab
define("FOOTNOTES_SETTINGS_TAB_DIAGNOSTICS", "footnotes_diagnostics_settings"); // internal label for the plugins diagnostics tab

// PLUGIN SETTINGS INPUT FIELDS
define("FOOTNOTES_INPUT_COMBINE_IDENTICAL", "footnote_inputfield_combine_identical"); // id of input field for the combine identical setting
define("FOOTNOTES_INPUT_REFERENCES_LABEL", "footnote_inputfield_references_label"); // id of input field for the references label setting
define("FOOTNOTES_INPUT_COLLAPSE_REFERENCES", "footnote_inputfield_collapse_references"); // id of input field for the "collapse references" setting
define("FOOTNOTES_INPUT_PLACEHOLDER_START", "footnote_inputfield_placeholder_start"); // id of input field for the "placeholder starting tag" setting
define("FOOTNOTES_INPUT_PLACEHOLDER_END", "footnote_inputfield_placeholder_end"); // id of input field for the "placeholder ending tag" setting
define("FOOTNOTES_INPUT_SEARCH_IN_EXCERPT", "footnote_inputfield_search_in_excerpt"); // id of input field for the "allow footnotes in the excerpt" setting
define("FOOTNOTES_INPUT_LOVE", "footnote_inputfield_love"); // id of input field for "love and share this plugin" setting
define("FOOTNOTES_INPUT_COUNTER_STYLE", "footnote_inputfield_counter_style"); // id of input field for "counter style of footnote index" setting
define("FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE", "footnote_inputfield_reference_container_place"); // id of input field "placement of reference container" setting
define("FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED", "footnote_inputfield_placeholder_start_user_defined"); // id of input field for 'user defined placeholder start tag
define("FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED", "footnote_inputfield_placeholder_end_user_defined"); // id of input field for 'user defined placeholder end tag
define("FOOTNOTES_INPUT_CUSTOM_CSS", "footnote_inputfield_custom_css"); // id of input field for 'custom css' setting
define("FOOTNOTES_INPUT_CUSTOM_STYLING_BEFORE", "footnote_inputfield_custom_styling_before"); // id of input field for 'footnotes styling before' setting
define("FOOTNOTES_INPUT_CUSTOM_STYLING_AFTER", "footnote_inputfield_custom_styling_after"); // id of input field for 'footnotes styling after' setting
define("FOOTNOTES_INPUT_CUSTOM_HYPERLINK_SYMBOL", "footnote_inputfield_custom_hyperlink_symbol"); // id of input field for 'footnotes hyperlink symbol' setting
define("FOOTNOTES_INPUT_CUSTOM_HYPERLINK_SYMBOL_USER", "footnote_inputfield_custom_hyperlink_symbol_user"); // id of input field for 'footnotes hyperlink symbol' user-defined setting

// PLUGIN REFERENCES CONTAINER ID
define("FOOTNOTES_REFERENCES_CONTAINER_ID", "footnote_references_container"); // id for the div surrounding the footnotes
define("FOOTNOTES_REFERENCE_CONTAINER_POSITION", "[[footnotes reference container position]]");


// PLUGIN PLACEHOLDER TO NOT DISPLAY THE 'LOVE ME' SLUG
// @since 1.1.1
define("FOOTNOTES_NO_SLUGME_PLUG", "[[no footnotes: love]]");