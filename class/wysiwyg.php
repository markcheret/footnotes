<?php
/**
 * Includes the Class to handle the WYSIWYG-Buttons.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0 14.09.14 17:30
 */

/**
 * Handles the WSYIWYG-Buttons.
 *
 * @since 1.5.0
 */
class MCI_Footnotes_WYSIWYG {

	/**
	 * Registers Button hooks.
	 *
	 * @return void
	 */
	public static function register_hooks() {
		add_filter( 'mce_buttons', array( 'MCI_Footnotes_WYSIWYG', 'new_visual_editor_button' ) );
		add_action( 'admin_print_footer_scripts', array( 'MCI_Footnotes_WYSIWYG', 'new_plain_text_editor_button' ) );

		add_filter( 'mce_external_plugins', array( 'MCI_Footnotes_WYSIWYG', 'include_scripts' ) );

		add_action( 'wp_ajax_nopriv_footnotes_get_tags', array( 'MCI_Footnotes_WYSIWYG', 'ajax_callback' ) );
		add_action( 'wp_ajax_footnotes_get_tags', array( 'MCI_Footnotes_WYSIWYG', 'ajax_callback' ) );
	}


	/**
	 * Append a new Button to the WYSIWYG editor of Posts and Pages.
	 *
	 * @since 1.5.0
	 * @param array $p_arr_buttons pre defined Buttons from WordPress.
	 * @return array
	 */
	public static function new_visual_editor_button( $p_arr_buttons ) {
		array_push( $p_arr_buttons, MCI_Footnotes_Config::C_STR_PLUGIN_NAME );
		return $p_arr_buttons;
	}

	/**
	 * Add a new button to the plain text editor.
	 *
	 * @since 1.5.0
	 */
	public static function new_plain_text_editor_button() {
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'editor-button' );
		echo wp_kses_post( $l_obj_template->get_content() );
	}

	/**
	 * Includes the Plugins WYSIWYG editor script.
	 *
	 * @since 1.5.0
	 * @param array $p_arr_plugins Scripts to be included to the editor.
	 * @return array
	 */
	public static function include_scripts( $p_arr_plugins ) {
		$p_arr_plugins[ MCI_Footnotes_Config::C_STR_PLUGIN_NAME ] = plugins_url( '/../js/wysiwyg-editor.js', __FILE__ );
		return $p_arr_plugins;
	}

	/**
	 * AJAX Callback function when the Footnotes Button is clicked. Either in the Plain text or Visual editor.
	 * Returns an JSON encoded array with the Footnotes start and end short code.
	 *
	 * @since 1.5.0
	 */
	public static function ajax_callback() {
		// Get start and end tag for the footnotes short code.
		$l_str_starting_tag = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START );
		$l_str_ending_tag   = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END );
		if ( 'userdefined' === $l_str_starting_tag || 'userdefined' === $l_str_ending_tag ) {
			$l_str_starting_tag = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$l_str_ending_tag   = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}
		echo wp_json_encode(
			array(
				'start' => htmlspecialchars( $l_str_starting_tag ),
				'end'   => htmlspecialchars( $l_str_ending_tag ),
			)
		);
		exit;
	}
}
