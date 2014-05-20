<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0-beta
 * Since: 1.0
 */

/* GENERAL PLUGIN CONSTANTS */
define( "FOOTNOTES_PLUGIN_NAME", "footnotes" ); /* plugin's internal name */
define( "FOOTNOTE_SETTINGS_CONTAINER", "footnotes_storage" ); /* database container where all footnote settings are stored */

/* PLUGIN SETTINGS PAGE */
define( "FOOTNOTES_SETTINGS_PAGE_ID", "footnotes" ); /* plugin's setting page internal id */

/* PLUGIN SETTINGS PAGE TABS */
define( "FOOTNOTE_SETTINGS_LABEL_GENERAL", "footnotes_general_settings" ); /* internal label for the plugin's settings tab */
define( "FOOTNOTE_SETTINGS_LABEL_HOWTO", "footnotes_howto" ); /* internal label for the plugin's settings tab */

/* PLUGIN SETTINGS INPUT FIELDS */
define( "FOOTNOTE_INPUTFIELD_COMBINE_IDENTICAL", "footnote_inputfield_combine_identical" ); /* id of input field for the combine identical setting */
define( "FOOTNOTE_INPUTFIELD_REFERENCES_LABEL", "footnote_inputfield_references_label" ); /* id of input field for the references label setting */
define( "FOOTNOTE_INPUTFIELD_COLLAPSE_REFERENCES", "footnote_inputfield_collapse_references" ); /* id of input field for the "collapse references" setting */

/* PLUGIN DEFAULT PLACEHOLDER */
define( "FOOTNOTE_PLACEHOLDER_START", "((" ); /* defines the default start tag for the placeholder */
define( "FOOTNOTE_PLACEHOLDER_END", "))" ); /* defines the default end tag for the placeholder */

/* PLUGIN REFERENCES CONTAINER ID */
define( "FOOTNOTE_REFERENCES_CONTAINER_ID", "footnote_references_container" ); /* id for the div surrounding the footnotes */

/* PLUGIN DIRECTORIES */
define( "FOOTNOTES_PLUGIN_DIR_NAME", "footnotes" );
define( "FOOTNOTES_LANGUAGE_DIR", dirname( __FILE__ ) . "/../languages/" );
define( "FOOTNOTES_TEMPLATES_DIR", dirname( __FILE__ ) . "/../templates/" );