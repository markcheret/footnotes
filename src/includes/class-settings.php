<?php // phpcs:disable Squiz.Commenting.FileComment.Missing
/**
 * File providing the `Settings` class.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed file from `settings.php` to `class-settings.php`.
 *              Renamed parent `class/` directory to `includes/`.
 */

declare(strict_types=1);

namespace footnotes\includes;

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;

use footnotes\includes\settings\general\GeneralSettingsSection;
use footnotes\includes\settings\referrersandtooltips\ReferrersAndTooltipsSettingsSection;
use footnotes\includes\settings\scopeandpriority\ScopeAndPrioritySettingsSection;
use footnotes\includes\settings\customcss\CustomCSSSettingsSection;

/**
 * Class defining configurable plugin settings.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed class from `Footnotes_Settings` to `Settings`.
 *              Moved under `footnotes\includes` namespace.
 */
class Settings {

	/**
	 * Contains all Settings option group slugs.
	 *
	 * Each option group relates to a single tab on the admin. dashboard.
	 *
	 * @var  string[]
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Renamed from `container` to `options_group_slugs`.
	 */
	private array $options_group_slugs = array(
		'footnotes_storage',
		'footnotes_storage_custom',
		'footnotes_storage_expert',
		'footnotes_storage_custom_css',
	);

	/**
	 * Contains each section of settings.
	 *
	 * @var  SettingsSection[]
	 *
	 * @since  2.8.0
	 */
	public $settings_sections = array();

	/**
	 * Loads all Settings from each WordPress Settings Container.
	 *
	 * @since  1.5.0
	 */
	public function __construct() {
		$this->load_dependencies();

		$this->settings_sections = array(
			'general'                => new GeneralSettingsSection( 'footnotes_storage', 'footnotes-settings', 'General Settings', $this ),
			'referrers_and_tooltips' => new ReferrersAndTooltipsSettingsSection( 'footnotes_storage_custom', 'footnotes-customize', 'Referrers and Tooltips', $this ),
			'scope_and_priority'     => new ScopeAndPrioritySettingsSection( 'footnotes_storage_expert', 'footnotes-expert', 'Scope and Priority', $this ),
			'custom_css'             => new CustomCSSSettingsSection( 'footnotes_storage_custom_css', 'footnotes-customcss', 'Custom CSS', $this ),
		);
	}

	/**
	 * Load the required dependencies for this file.
	 *
	 * Includes the following files that make up the plugin:
	 *
	 * - {@see SettingsSection}: defines a section of settings groups;
	 * - {@see SettingsGroup}: defines a group of settings;
	 * - {@see Setting}: defines a single setting;
	 * - {@see GeneralSettingsSection}: provides general plugin settings;
	 * - {@see ReferrersAndTooltipsSettingsSection}: provides settings for
	 *   customising the plugin's created referrers and tooltips;
	 * - {@see ScopeAndPrioritySettingsSection}: defines plugin scope and priority
	 *   settings; and
	 * - {@see CustomCSSSettingsSection}: provides custom CSS settings.
	 *
	 * @since 2.8.0
	 *
	 * @return void
	 */
	protected function load_dependencies(): void {
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/class-settingssection.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/class-settingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/class-setting.php';

		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/general/class-generalsettingssection.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/referrers-and-tooltips/class-referrersandtooltipssettingssection.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/scope-and-priority/class-scopeandprioritysettingssection.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/custom-css/class-customcsssettingssection.php';
	}

	/**
	 * Retrieve a setting by its key.
	 *
	 * @param  string $setting_key  The key of the setting to search for.
	 * @return  ?Setting Either the setting object, or `null` if none exists.
	 *
	 * @since  2.8.0
	 *
	 * @todo  This is an _O(n)_ linear search. Explore more scaleable alternatives.
	 */
	public function get_setting( string $setting_key ): ?Setting {
		foreach ( $this->settings_sections as $settings_section ) {
			$setting = $settings_section->get_setting( $setting_key );

			if ( $setting ) {
				return $setting;
			}
		}

		return null;
	}

	/**
	 * Retrieve a setting's value by its key.
	 *
	 * @param  string $setting_key  The key of the setting to search for.
	 * @return  mixed Either the setting's value, or `null` if the setting does not exist.
	 *
	 * @since  2.8.0
	 *
	 * @todo  This is an _O(n)_ linear search. Explore more scaleable alternatives.
	 * @todo  How to handle settings with a value of `null`?
	 */
	public function get_setting_value( string $setting_key ): mixed {
		foreach ( $this->settings_sections as $settings_section ) {
			$setting = $settings_section->get_setting( $setting_key );

			if ( $setting ) {
				return $setting->get_value();
			}
		}

		return null;
	}

	/**
	 * Retrieve a setting's default value by its key.
	 *
	 * @param  string $setting_key  The key of the setting to search for.
	 * @return  mixed Either the setting's default value, or `null` if the setting does not exist.
	 *
	 * @since  2.8.0
	 *
	 * @todo  This is an _O(n)_ linear search. Explore more scaleable alternatives.
	 * @todo  How to handle settings with a default value of `null`?
	 */
	public function get_setting_default_value( string $setting_key ): mixed {
		foreach ( $this->settings_sections as $settings_section ) {
			$setting = $settings_section->get_setting( $setting_key );

			if ( $setting ) {
				return $setting->get_default_value();
			}
		}

		return null;
	}

	/**
	 * Set a setting's value by its key.
	 *
	 * @param  string $setting_key  The key of the setting to search for.
	 * @param  mixed  $setting_value  The new value to set.
	 * @return  mixed  'True' if the value was successfully set. 'False' otherwise.
	 *
	 * @since  2.8.0
	 *
	 * @todo  This is an _O(n)_ linear search. Explore more scaleable alternatives.
	 * @todo  How to handle settings with a value of `null`?
	 */
	public function set_setting_value( string $setting_key, $setting_value ): ?bool {
		foreach ( $this->settings_sections as $settings_section ) {
			$setting = $settings_section->get_setting( $setting_key );

			if ( $setting ) {
				return $setting->set_value( $setting_value );
			}
		}

		return false;
	}

	/**
	 * Returns the name of a specified Settings Container.
	 *
	 * @param  int $index  Options group index.
	 * @return  string  Options group slug name.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Renamed from `get_container()` to `get_options_group_slug()`.
	 */
	public function get_options_group_slug( int $index ): string {
		return $this->options_group_slugs[ $index ];
	}

	/**
	 * Updates a whole Setting Container on save.
	 *
	 * @param  string $options_group_slug  Options group slug to save.
	 * @param  array  $new_values  The new Settings value(s).
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Change first parameter type from `int` to `string`.
	 */
	public function save_options_group( string $options_group_slug, array $new_values ): bool {
		if ( update_option( $options_group_slug, $new_values ) ) {
			foreach ( $this->settings_sections as $settings_section ) {
				if ( $settings_section->get_options_group_slug() === $options_group_slug ) {
					$settings_section->load_options_group();
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Loads all settings from each option group.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Renamed from `load_all()` to `load_options_groups()`.
	 */
	protected function load_options_groups(): void {
		foreach ( $this->options_group_slug as $options_group_slug ) {
			$options_group = get_option( $options_group_slug );

			if ( ! ! $options_group ) {
				foreach ( $this->settings_sections as $settings_section ) {
					if ( $settings_section->get_options_group_slug() === $options_group_slug ) {
						$settings_section->load_options_group();
					}
				}
			}
		}
	}
}
