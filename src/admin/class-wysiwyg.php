<?php
/**
 * Admin: WYSIWYG class
 *
 * The Admin. subpackage is initialised at runtime by the {@see Admin}
 * class, which draws in the {@see WYSIWYG} class for WYSIWYG editor
 * integration and the {@see footnotes\admin_layout} subpackage for rendering
 * dashboard pages.
 *
 * @package  footnotes
 * @since  1.5.0
 * @since  2.8.0  Rename file from `wysiwyg.php` to `class-footnotes-wysiwyg.php`,
 *                              move from `class/` sub-directory to `admin/`.
 */

declare(strict_types=1);

namespace footnotes\admin;

use footnotes\includes\{Settings, Template};

/**
 * Class providing WYSIWYG editor intergration for the plugin.
 *
 * @package  footnotes
 * @since  1.5.0
 */
class WYSIWYG {

	/**
	 * Append a new Button to the WYSIWYG editor of Posts and Pages.
	 *
	 * @param  string[] $buttons  Already-defined editor buttons.
	 * @return  string[]
	 *
	 * @since  1.5.0
	 * @todo  Should this be `static`?
	 */
	public static function new_visual_editor_button( array $buttons ): array {
		$buttons[] = 'footnotes';
		return $buttons;
	}

	/**
	 * Add a new button to the plain text editor.
	 *
	 * @since  1.5.0
	 */
	public static function new_plain_text_editor_button(): void {
		$template = new Template( Template::DASHBOARD, 'editor-button' );
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $template->get_content();
		// phpcs:enable
	}

	/**
	 * Includes the Plugins WYSIWYG editor script.
	 *
	 * @param  string[] $plugins  Scripts to be included by the editor.
	 * @return  string[]
	 *
	 * @since  1.5.0
	 * @todo  Should this be `static`?
	 */
	public static function include_scripts( array $plugins ): array {
		$plugins['footnotes'] = plugins_url( '/../admin/js/wysiwyg-editor' . ( ( PRODUCTION_ENV ) ? '.min' : '' ) . '.js', __FILE__ );
		return $plugins;
	}

	/**
	 * AJAX Callback function when the Footnotes Button is clicked. Either in the Plain text or Visual editor.
	 * Returns an JSON encoded array with the Footnotes start and end short code.
	 *
	 * @since  1.5.0
	 */
	public static function ajax_callback(): void {
		// Get start and end tag for the footnotes short code.
		$starting_tag = Settings::instance()->get( Settings::FOOTNOTES_SHORT_CODE_START );
		$ending_tag   = Settings::instance()->get( Settings::FOOTNOTES_SHORT_CODE_END );
		if ( 'userdefined' === $starting_tag || 'userdefined' === $ending_tag ) {
			$starting_tag = Settings::instance()->get( Settings::FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$ending_tag   = Settings::instance()->get( Settings::FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}
		echo wp_json_encode(
			array(
				'start' => htmlspecialchars( $starting_tag ),
				'end'   => htmlspecialchars( $ending_tag ),
			)
		);
		exit;
	}
}
