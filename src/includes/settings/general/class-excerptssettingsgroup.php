<?php
/**
 * File providing the `ExcerptsSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

use footnotes\includes\Footnotes;
use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the footnote exerpts settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ExcerptsSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'excerpts';

	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Footnotes in Excerpts';

	/**
	 * Settings container key to look for footnotes in post excerpts.
	 *
	 * @var  arrau
	 *
	 * @since  1.5.0
	 * @since  2.6.3  Enabled by default.
	 * @since  2.8.0  Move from `Settings` to `ExcerptsSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_IN_EXCERPT = array(
		'key'           => 'footnote_inputfield_search_in_excerpt',
		'name'          => 'Process Footnotes in Excerpts',
		'default_value' => 'manual',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array(
			'yes'    => 'Yes, generate excerpts from posts with effectively processed footnotes and other markup',
			'no'     => 'No, generate excerpts from posts but remove all footnotes and output plain text',
			'manual' => 'Yes but run the process only to display tooltips in manual excerpts with footnote short codes',
		),
	);

	/**
	 * Add the settings for this settings group.
	 *
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_IN_EXCERPT['key'] => $this->add_setting( self::FOOTNOTES_IN_EXCERPT ),
		);

		$this->load_values( $options );
	}
}
