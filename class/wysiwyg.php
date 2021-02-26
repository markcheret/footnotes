<?php
/**
 * Includes the Class to handle the WYSIWYG-Buttons.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 17:30
 */

/**
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_WYSIWYG {

	public static function registerHooks() {
		add_filter("mce_buttons", array("MCI_Footnotes_WYSIWYG", "newVisualEditorButton"));
		add_action("admin_print_footer_scripts", array("MCI_Footnotes_WYSIWYG", "newPlainTextEditorButton"));

		add_filter("mce_external_plugins", array("MCI_Footnotes_WYSIWYG", "includeScripts"));

		add_action("wp_ajax_nopriv_footnotes_getTags", array("MCI_Footnotes_WYSIWYG", "ajaxCallback"));
		add_action("wp_ajax_footnotes_getTags", array("MCI_Footnotes_WYSIWYG", "ajaxCallback"));
	}


	/**
	 * Append a new Button to the WYSIWYG editor of Posts and Pages.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param array $p_arr_Buttons pre defined Buttons from WordPress.
	 * @return array
	 */
	public static function newVisualEditorButton($p_arr_Buttons) {
		array_push($p_arr_Buttons, MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
		return $p_arr_Buttons;
	}

	/**
	 * Add a new button to the plain text editor.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public static function newPlainTextEditorButton() {
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "editor-button");
		echo $l_obj_Template->getContent();
	}

	/**
	 * Includes the Plugins WYSIWYG editor script.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param array $p_arr_Plugins Scripts to be included to the editor.
	 * @return array
	 */
	public static function includeScripts($p_arr_Plugins) {
		$p_arr_Plugins[MCI_Footnotes_Config::C_STR_PLUGIN_NAME] = plugins_url('/../js/wysiwyg-editor.js', __FILE__);
		return $p_arr_Plugins;
	}

	/**
	 * AJAX Callback function when the Footnotes Button is clicked. Either in the Plain text or Visual editor.
	 * Returns an JSON encoded array with the Footnotes start and end short code.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public static function ajaxCallback() {
		// get start and end tag for the footnotes short code
		$l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START);
		$l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END);
		if ($l_str_StartingTag == "userdefined" || $l_str_EndingTag == "userdefined") {
			$l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED);
			$l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED);
		}
		echo json_encode(array("start" => htmlspecialchars($l_str_StartingTag), "end" => htmlspecialchars($l_str_EndingTag)));
		exit;
	}
}