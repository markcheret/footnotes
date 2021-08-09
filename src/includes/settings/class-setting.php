<?php
/**
 * File providing the `Setting` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings;

use footnotes\includes\{Core, Settings};

/**
 * Class defining a configurable plugin setting.
 *
 * @package footnotes
 * @since 2.8.0
 */
class Setting {
	/**
	 * Options for the custom width units (per cent is a ratio, not a unit).
	 *
	 * @var  array
	 *
	 * @since  2.8.0
	 */
	const WIDTH_UNIT_OPTIONS = array(
		'%'   => 'per cent',
		'px'  => 'pixels',
		'rem' => 'root em',
		'em'  => 'em',
		'vw'  => 'viewport width',
	);

	/**
	 * Options for the custom font size units (per cent is a ratio, not a unit).
	 *
	 * @var  array
	 *
	 * @since  2.8.0
	 */
	const FONT_SIZE_UNIT_OPTIONS = array(
		'em'  => 'em',
		'rem' => 'rem',
		'px'  => 'pixels',
		'pt'  => 'points',
		'pc'  => 'picas',
		'mm'  => 'millimeters',
		'%'   => 'per cent',
	);

	/**
	 * Options for the HTML text elements.
	 *
	 * @var  array
	 *
	 * @since  2.8.0
	 */
	const TEXT_ELEMENT_OPTIONS = array(
		'p'  => 'paragraph',
		'h2' => 'heading 2',
		'h3' => 'heading 3',
		'h4' => 'heading 4',
		'h5' => 'heading 5',
		'h6' => 'heading 6',
	);

	/**
	 * Setting value.
	 *
	 * @var  mixed
	 *
	 * @since  2.8.0
	 */
	protected $value;

	/**
	 * Constructs the setting.
	 *
	 * @since  2.8.0
	 */
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
		private mixed $default_value,

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
		private int|float|null $input_max,

		/**
		 * Setting input field min. value (for 'number' inputs).
		 *
		 * @var  int
		 *
		 * @since  2.8.0
		 */
		private int|float|null $input_min,

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

		/**
		 * The plugin settings object.
		 *
		 * @var  Settings
		 *
		 * @since  2.8.0
		 */
		private Settings $settings
	) {
		$this->value = $this->default_value;

		register_setting( $this->options_group_slug, $this->key, $this->get_setting_args() );
	}

	/**
	 * Get the args for registering the settings with WordPress.
	 *
	 * @see register_setting()
	 *
	 * @return array The setting field args.
	 *
	 * @since 2.8.0
	 */
	public function get_setting_args(): array {
		return array(
			'type'        => $this->type,
			'description' => $this->description,
			'default'     => $this->default_value,
		);
	}

	/**
	 * Get the args for rendering setting fields on the admin. dashboard.
	 *
	 * @see add_settings_field()
	 *
	 * @return array The setting field args.
	 *
	 * @since 2.8.0
	 */
	public function get_setting_field_args(): array {
		return array(
			'name'        => $this->key,
			'label_for'   => $this->key,
			'value'       => $this->value,
			'description' => $this->description,
			'type'        => $this->input_type,
			'options'     => $this->input_options,
			'max'         => $this->input_max,
			'min'         => $this->input_min,
			'disabled'    => $this->is_disabled_or_overridden(),
		);
	}

	/**
	 * Check whether a setting is enabled and/or overridden.
	 *
	 * @return ?bool 'True' if the setting is disabled or overridden.
	 *               'False' if it could be, but isn't currently.
	 *               'None' if the setting is not enabled/overridden by another.
	 *
	 * @since 2.8.0
	 */
	private function is_disabled_or_overridden(): ?bool {
		if ( isset( $this->enabled_by ) ) {
			$enabled_by_value = $this->settings->get_setting_value( $this->enabled_by );
			$is_enabled       = ( isset( $enabled_by_value ) || 'userdefined' === $enabled_by_value );
		}

		if ( isset( $this->overridden_by ) ) {
			$overridden_by_value = $this->settings->get_setting_value( $this->overridden_by );
			$is_overridden       = ! ( null === $overridden_by_value || '' === $overridden_by_value );
		}

		if ( isset( $is_enabled ) || isset( $is_overridden ) ) {
			if ( isset( $is_enabled ) && ! $is_enabled ) {
				return true;
			}

			if ( isset( $is_enabled ) && $is_enabled && ( isset( $is_overridden ) && ! $is_overridden ) ) {
				return false;
			}

			if ( isset( $is_overridden ) && $is_overridden ) {
				return true;
			}

			return false;
		} else {
			return null;
		}
	}

	/**
	 * Gets the slug of the setting's options group.
	 *
	 * @return string The options group slug.
	 *
	 * @since 2.8.0
	 */
	public function get_options_group_slug(): string {
		return $this->options_group_slug;
	}

	/**
	 * Gets the slug of the setting's section.
	 *
	 * @return string The section slug.
	 *
	 * @since 2.8.0
	 */
	public function get_section_slug(): string {
		return $this->section_slug;
	}

	/**
	 * Gets the value of the setting.
	 *
	 * @return  mixed  The value of the setting, or the default value if none is set. 'None' if neither are set.
	 *
	 * @since 2.8.0
	 */
	public function get_value(): mixed {
		return $this->value ?? $this->default_value ?? null;
	}

	/**
	 * Gets the default value of the setting.
	 *
	 * @return  mixed  The default value of the setting. 'None' if one is not set.
	 *
	 * @since 2.8.0
	 */
	public function get_default_value(): mixed {
		return $this->default_value ?? null;
	}

	/**
	 * Gets the input options of the setting.
	 *
	 * @return  ?array  The possible options of the setting. 'None' if no options are set.
	 *
	 * @since 2.8.0
	 */
	public function get_input_options(): ?array {
		return $this->input_options ?? null;
	}

	/**
	 * Sets the value of the setting.
	 *
	 * @param mixed $value The new value to set.
	 * @return bool 'True' if the value was successfully set. 'False' otherwise.
	 *
	 * @since 2.8.0
	 */
	public function set_value( $value ): bool {
		$this->value = $value;
		return true;
	}
}
