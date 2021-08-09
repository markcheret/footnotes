<?php
/**
 * File providing the `SettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings;

use footnotes\includes\Settings;
use footnotes\admin\layout\SettingsPage;

/**
 * Class defining a group of plugin settings within a section.
 *
 * NB: the concept of a 'settings group' is just a semantic aide for developers,
 * it has no relevance within WordPress itself, which only recognises settings
 * sections and options groups.
 *
 * @package footnotes
 * @since 2.8.0
 */
abstract class SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'undefined';

	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'undefined';

	/**
	 * The setting classes.
	 *
	 * @var  string[]
	 *
	 * @since  2.8.0
	 */
	protected array $setting_classes;

	/**
	 * The settings in this group.
	 *
	 * @var  Setting[]
	 *
	 * @since  2.8.0
	 */
	protected array $settings;

	/**
	 * Constructs the settings section.
	 *
	 * @since  2.8.0
	 */
	public function __construct(
		/**
		 * Setting options group slug.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		protected string $options_group_slug,

		/**
		 * Setting section slug.
		 *
		 * @var  string
		 *
		 * @since  2.8.0
		 */
		protected string $section_slug,

		/**
		 * The plugin settings object.
		 *
		 * @access  private
		 * @since  2.8.0
		 */
		protected Settings $settings_obj
	) {
		$this->load_dependencies();

		$this->add_settings( get_option( $this->options_group_slug ) );
	}

	/**
	 * Load the required dependencies.
	 *
	 * Include the following files that provide the settings for this plugin:
	 *
	 * - {@see Setting}: defines individual settings.
	 *
	 * @since  2.8.0
	 */
	protected function load_dependencies(): void {
		require_once plugin_dir_path( __DIR__ ) . 'settings/class-setting.php';
	}

	/**
	 * Add the settings for this settings group.
	 *
	 * @abstract
	 * @param  array<string,mixed>|false $options  Saved values for the settings in this group. 'False' if none exist.
	 * @return  void
	 *
	 * @since  2.8.0
	 */
	abstract protected function add_settings( array|false $options): void;

	/**
	 * Constructs settings from the provided details.
	 *
	 * @param  array<string,mixed> $setting  The setting details.
	 * @return  Setting  The constructed setting object.
	 *
	 * @since  2.8.0
	 */
	protected function add_setting( array $setting ): Setting {
		extract( $setting );

		return new Setting(
			self::GROUP_ID,
			$this->options_group_slug,
			$this->section_slug,
			$key,
			$name,
			$description ?? null,
			$default_value ?? null,
			$type,
			$input_type,
			$input_options ?? null,
			$input_max ?? null,
			$input_min ?? null,
			$enabled_by['key'] ?? null,
			$overridden_by['key'] ?? null,
			$this->settings_obj
		);
	}

	/**
	 * Load the values for this settings group.
	 *
	 * @param  array<string,mixed>|false $options  Saved values for the settings in this group. 'False' if none exist.
	 * @return  void
	 *
	 * @since  2.8.0
	 * @todo Remove settings from options group when not found.
	 */
	protected function load_values( array|false $options ): void {
		if ( ! $options ) {
			return;
		}

		foreach ( $options as $setting_key => $setting_value ) {
			if ( array_key_exists( $setting_key, $this->settings ) ) {
				$this->settings[ $setting_key ]->set_value( $setting_value );
			}
		}
	}

	/**
	 * Adds all the settings fields for this group to the admin. dashboard.
	 *
	 * @param  SettingsPage $component  The admin. dashboard settings page.
	 * @return  void
	 *
	 * @since  2.8.0
	 */
	public function add_settings_fields( SettingsPage $component ): void {
		foreach ( $this->settings as $setting ) {
			add_settings_field(
				$setting->key,
				__( $setting->name, 'footnotes' ),
				array( $component, 'setting_field_callback' ),
				'footnotes',
				$setting->get_section_slug(),
				$setting->get_setting_field_args()
			);
		}
	}

	/**
	 * Retrieve a setting by its key.
	 *
	 * @see Settings::get_setting()
	 */
	public function get_setting( string $setting_key ): ?Setting {
		foreach ( $this->settings as $setting ) {
			if ( $setting->key === $setting_key ) {
				return $setting;
			}
		}

		return null;
	}

	/**
	 * Creates an options group from the values of the settings in this section.
	 *
	 * @see SettingsSection::get_options()
	 */
	public function get_options(): array {
		$options = array();

		foreach ( $this->settings as $setting ) {
			$options[ $setting->key ] = $setting->get_value();
		}

		return $options;
	}

	/**
	 * Get a setting's value by its key.
	 *
	 * @see Settings::get_setting_value()
	 */
	public function get_setting_value( string $setting_key ) {
		$setting = $this->get_setting( $setting_key );

		if ( ! $setting ) {
			return null;
		} else {
			return $setting->value ?? $setting->default_value;
		}
	}

	/**
	 * Set a setting's value by its key.
	 *
	 * @see Settings::set_setting_value()
	 */
	public function set_setting_value( string $setting_key, $value ): bool {
		return $this->get_setting( $setting_key )->set_value( $value );
	}
}
