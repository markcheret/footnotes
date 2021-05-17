<?php
/**
 * File providing the `Setting` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings;

/**
 * Class defining a configurable plugin setting.
 *
 * @package footnotes
 * @since 2.8.0
 */
class Setting {		
	/**
	 * Setting value.
	 *
	 * @var  mixed
	 *
	 * @since  2.8.0
	 */
	private $value;

	public function __construct(
		/**
		 * Setting group ID.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private string $group_id,
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
		private string $section_slug,
		
		/**
		 * Setting slug.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		public string $key,

		/**
		 * Setting name.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		public string $name,
		
		/**
		 * Setting description.
		 *
		 * @var  string|null
		 *
		 * @since  2.8.0
		 */
		public ?string $description,
		
		/**
		 * Setting default value.
		 *
		 * @var  mixed
		 *
		 * @since  2.8.0
		 */
		private $default_value,
		
		/**
		 * Setting data type.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private string $type,
		
		/**
		 * Setting input field type.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private string $input_type
	) {
		register_setting( $this->options_group_slug, $this->key, $this->get_setting_args());
	}
	
	public function get_setting_args(): array {
		return array (
			'type' => $this->type,
			'description' => $this->description,
			'default' => $this->default_value,
		);
	}
	
	public function get_setting_field_args(): array {
		return array (
			'name' => $this->key,
			'label_for' => $this->key,
			'type' => $this->input_type,
			'value' => $this->value,
			'description' => $this->description,
		);
	}
	
	public function get_options_group_slug(): string {
		return $this->options_group_slug;
	}
	
	public function get_section_slug(): string {
		return $this->section_slug;
	}
}
