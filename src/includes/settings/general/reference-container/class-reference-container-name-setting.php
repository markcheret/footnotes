<?php
/**
 * File providing the `ReferenceContainerNameSetting` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general\ReferenceContainer;

require_once plugin_dir_path( dirname( __FILE__, 2 ) ) . 'class-setting.php';

use footnotes\includes\settings as Settings;

/**
 * Class defining the reference container name setting.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ReferenceContainerNameSetting extends Settings\Setting {	
	/**
	 * Setting slug.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const KEY = 'footnote_inputfield_references_label';
	
	/**
	 * Setting name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const NAME = 'Reference Container Title';
	
	/**
	 * Setting description.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const DESCRIPTION = 'The title of the reference container.';
	
	/**
	 * Setting default value.
	 *
	 * @var  mixed
	 *
	 * @since  2.8.0
	 */
	const DEFAULT_VALUE = 'Reference';
	
	/**
	 * Setting data type.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const TYPE = 'string';
	
	/**
	 * Setting input field type.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const INPUT_TYPE = 'text';
	
	public function __construct(
		/**
		 * Setting group ID.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private string $section_group_id,
		/**
		 * Setting section slug.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private string $options_group_slug,	
		/**
		 * Setting section slug.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private string $section_slug
	) {
		register_setting( $this->options_group_slug, self::NAME, $this->get_setting_args());
	}
}
