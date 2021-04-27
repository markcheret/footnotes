<?php // phpcs:disable Squiz.Commenting.FileComment.Missing
/**
 * File provides WYSIWYG editor integration.
 *
 * @since      1.5.0
 *
 * @package    footnotes
 * @subpackage admin
 */

/**
 * Handles the WSYIWYG-Buttons.
 *
 * @since 1.5.0
 */
class Footnotes_WYSIWYG {

	/**
	 * The ID of this plugin.
	 *
	 * @since    2.8.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.8.0
	 * @param    string $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	}

	/**
	 * Append a new Button to the WYSIWYG editor of Posts and Pages.
	 *
	 * @since 1.5.0
	 * @param array $p_arr_buttons pre defined Buttons from WordPress.
	 * @return array
	 *
	 * @todo Does this need to be `static`?
	 */
	public static function new_visual_editor_button( $p_arr_buttons ) {
		array_push( $p_arr_buttons, 'footnotes' );
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
	 *
	 * @todo Does this need to be `static`?
	 */
	public static function include_scripts( $p_arr_plugins ) {
		$p_arr_plugins['footnotes'] = plugins_url( '/../admin/js/wysiwyg-editor' . ( ( PRODUCTION_ENV ) ? '.min' : '' ) . '.js', __FILE__ );
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
		echo wp_json_encode(
			array(
				'start' => htmlspecialchars( $l_str_starting_tag ),
				'end'   => htmlspecialchars( $l_str_ending_tag ),
			)
		);
		exit;
	}
}
