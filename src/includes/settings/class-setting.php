<?php
/**
 * File providing the `Setting` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings;

use footnotes\includes\Settings;

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
	protected $value;

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
		private string $input_type,
		
		/**
		 * Setting input field options (for 'select' inputs).
		 *
		 * @var  array
		 *
		 * @since  2.8.0
		 */
		private ?array $input_options,
		
		/**
		 * Setting input field max. value (for 'number' inputs).
		 *
		 * @var  int
		 *
		 * @since  2.8.0
		 */
		private ?int $input_max,
		
		/**
		 * Setting input field min. value (for 'number' inputs).
		 *
		 * @var  int
		 *
		 * @since  2.8.0
		 */
		private ?int $input_min,
		
		/**
		 * The setting for whether this setting is enabled or not.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private ?string $enabled_by,
		
		/**
		 * Any setting that overrides this setting.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		private ?string $overridden_by,
	) {
		$this->value = $this->default_value;
		
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
			'value' => $this->value,
			'description' => $this->description,
			'type' => $this->input_type,
			'options' => $this->input_options,
			'max' => $this->input_max,
			'min' => $this->input_min,
			'disabled' => $this->is_disabled_or_overridden()
		);
	}
	
	private function is_disabled_or_overridden(): ?bool {		
		if ($this->enabled_by) {
			if (!Settings::instance()->get_setting($this->enabled_by)->value) return true;
			
			if (!$this->overridden_by) return false;
			else if (isset(Settings::instance()->get_setting($this->overridden_by)->value)) return true;
			else return false;
		} else return null;
	}
	
	public function get_options_group_slug(): string {
		return $this->options_group_slug;
	}
	
	public function get_section_slug(): string {
		return $this->section_slug;
	}
	
	/**
	 * @todo  Add type safety.
	 */
	public function get_value() {
		return $this->value ?? $this->default_value ?? null;
	}
	
	/**
	 * @todo  Add type safety.
	 */
	public function set_value($value): bool {
		$this->value = $value;
		return true;
	}
}
