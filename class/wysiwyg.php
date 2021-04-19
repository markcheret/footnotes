<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Includes the Class to handle the WYSIWYG-Buttons.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 */

/**
 * Handles the WSYIWYG-Buttons.
 *
 * @since 1.5.0
 */
class Footnotes_WYSIWYG {

	/**
	 * Registers Button hooks.
	 *
	 * @since 1.5.0
	 *
	 * - Bugfix: Editor buttons: debug button by reverting name change in PHP file while JS file and HTML template remained unsynced, thanks to @gova bug report.
	 *
	 * @reporter @gova
	 * @link https://wordpress.org/support/topic/back-end-footnotes-not-working-400-bad-erro/
	 *
	 * @since 2.6.5
	 * @return void
	 */
	public static function register_hooks() {
		add_filter( 'mce_buttons', array( 'Footnotes_WYSIWYG', 'new_visual_editor_button' ) );
		add_action( 'admin_print_footer_scripts', array( 'Footnotes_WYSIWYG', 'new_plain_text_editor_button' ) );

		add_filter( 'mce_external_plugins', array( 'Footnotes_WYSIWYG', 'include_scripts' ) );

		// phpcs:disable
		// 'footnotes_getTags' must match its instance in wysiwyg-editor.js.
		// 'footnotes_getTags' must match its instance in editor-button.html.
		add_action( 'wp_ajax_nopriv_footnotes_getTags', array( 'Footnotes_WYSIWYG', 'ajax_callback' ) );
		add_action( 'wp_ajax_footnotes_getTags', array( 'Footnotes_WYSIWYG', 'ajax_callback' ) );
		// phpcs:enable
	}


	/**
	 * Append a new Button to the WYSIWYG editor of Posts and Pages.
	 *
	 * @since 1.5.0
	 * @param array $p_arr_buttons pre defined Buttons from WordPress.
	 * @return array
	 */
	public static function new_visual_editor_button( $p_arr_buttons ) {
		array_push( $p_arr_buttons, Footnotes_Config::C_STR_PLUGIN_NAME );
		return $p_arr_buttons;
	}

	/**
	 * Add a new button to the plain text editor.
	 *
	 * @since 1.5.0
	 */
	public static function new_plain_text_editor_button() {
		$l_obj_template = new Footnotes_Template( Footnotes_Template::C_STR_DASHBOARD, 'editor-button' );
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Includes the Plugins WYSIWYG editor script.
	 *
	 * @since 1.5.0
	 * @param array $p_arr_plugins Scripts to be included to the editor.
	 * @return array
	 */
	public static function include_scripts( $p_arr_plugins ) {
		$p_arr_plugins[ Footnotes_Config::C_STR_PLUGIN_NAME ] = plugins_url( '/../js/wysiwyg-editor.js', __FILE__ );
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
		$l_str_starting_tag = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START );
		$l_str_ending_tag   = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END );
		if ( 'userdefined' === $l_str_starting_tag || 'userdefined' === $l_str_ending_tag ) {
			$l_str_starting_tag = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$l_str_ending_tag   = Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}
		echo json_encode(
			array(
				'start' => htmlspecialchars( $l_str_starting_tag ),
				'end'   => htmlspecialchars( $l_str_ending_tag ),
			)
		);
		exit;
	}
}
