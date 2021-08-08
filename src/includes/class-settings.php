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

use footnotes\includes\settings\Setting;

/**
 * Provides data conversion methods.
 *
 * @todo Move to {@see Loader}.
 */
require_once plugin_dir_path( __DIR__ ) . 'includes/class-convert.php';

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
 *        Moved under `footnotes\includes` namespace.
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
	
	/**********************************************************************
	 *      SETTINGS STORAGE.
	 **********************************************************************/
	 
	/**
	 * Stores a singleton reference of this class.
	 *
	 * @since  1.5.0
	 *
	 * @todo  Still needed?
	 */
	private static ?Settings $instance = null;

	/**
	 * Loads all Settings from each WordPress Settings Container.
	 *
	 * @since  1.5.0
	 */
	public function __construct() {		
		$this->load_dependencies();
		
		$this->settings_sections = array(
			'general' => new GeneralSettingsSection('footnotes_storage', 'footnotes-settings', 'General Settings'),
			'referrers_and_tooltips' => new ReferrersAndTooltipsSettingsSection('footnotes_storage_custom', 'footnotes-customize', 'Referrers and Tooltips'),
			'scope_and_priority' => new ScopeAndPrioritySettingsSection('footnotes_storage_expert', 'footnotes-expert', 'Scope and Priority'),
			'custom_css' => new CustomCSSSettingsSection('footnotes_storage_custom_css', 'footnotes-customcss', 'Custom CSS'),
		);
	}
	
	/**
	 * Load the required dependencies for this file.
	 *
	 * Includes the following files that make up the plugin:
	 *
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
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/general/class-general-settings-section.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/referrers-and-tooltips/class-referrers-and-tooltips-settings-section.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/scope-and-priority/class-scope-and-priority-settings-section.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/settings/custom-css/class-custom-css-settings-section.php';
	}
	
	/**
	 * Retrieve a setting by its key.
	 *
	 * @param  string  $setting_key  The key of the setting to search for.
	 * @return  ?Setting Either the setting object, or `null` if non exists.
	 *
	 * @since  2.8.0
	 *
	 * @todo  This is an _O(n)_ linear search. Explore more scaleable alternatives.
	 */
	public function get_setting( string $setting_key ): ?Setting {		
		foreach ($this->settings_sections as $settings_section) {
			$setting = $settings_section->get_setting($setting_key);
			
			if ($setting) return $setting;
		}
		
		return null;
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
	 * Returns the default value(s) of a specific Settings Container.
	 *
	 * @param  int $index  Settings Container index.
	 * @return  (string|int)[]  Settings Container default value(s).
	 *
	 * @since  1.5.6
	 * @deprecated
	 */
	public function get_defaults( int $index ): array {
		return $this->default_settings[ $this->get_options_group_slug[ $index ] ];
	}

	/**
	 * Updates a whole Setting Container on save.
	 *
	 * @param  string  $options_group_slug  Options group slug to save.
	 * @param  array  $new_values  The new Settings value(s).
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Change first parameter type from `int` to `string`.
	 */
	public function save_options( string $options_group_slug, array $new_values ): bool {
		if ( update_option( $options_group_slug, $new_values ) ) {
			foreach ($this->settings_sections as $settings_section) {
				if ($settings_section->get_options_group_slug() === $options_group_slug) {
					$settings_section->load_options_group();
				}
			}
			return true;
		}
		return false;
	}
	
	protected function load_options_group(): void {
		$options_group = get_option($this->options_group_slug);
		
		if (!! $options_group) {
			foreach ($options_group as $setting_key => $setting_value) {
				$this->set_setting_value($setting_key, $setting_value);
			}
		}
	}

	/**
	 * Returns the value of specified Setting.
	 *
	 * @param  string $key  Setting key.
	 * @return  string|int|null  Setting value, or `null` if setting key is invalid.
	 *
	 * @since  1.5.0
	 * @todo Add return type.
	 */
	public function get( string $key ) {
		return $this->settings[ $key ] ?? null;
	}

	/**
	 * Returns a singleton of this class.
	 *
	 * @since  1.5.0
	 * @todo  Remove?
	 */
	public static function instance(): self {
		// No instance defined yet, load it.
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		// Return a singleton of this class.
		return self::$instance;
	}
	
	/**
	 * Loads all settings from each option group.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Renamed from `load_all()` to `load_options()`.
	 */
	private function load_options(): void {
		// Clear current settings.
		$this->settings = array();
		
		foreach ($this->options_group_slugs as $options_group_slug) {
			$this->settings[$options_group_slug] = $this->load_option( $options_group_slug );
		}
	}
	
	/**
	 * Loads all settings from a given option group.
	 *
	 * @param  string  $options_group  Option group slug.
	 * @return  (string|int)[]  Loaded settings (or defaults if specified option group is empty).
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Renamed from `load()` to `load_option()`.
	 */
	private function load_option(string $options_group_slug): array {
		// Load all settings from option group.
		$options_group = get_option( $options_group_slug );
		
		// No settings found, set them to their default value.
		if ( empty( $options_group ) ) {
			print_r("Options group ".$options_group_slug." is empty!");
			return $this->default_settings[$options_group_slug];
		}
				
		foreach ( $this->default_settings[$options_group_slug] as $setting_name => $setting_value ) {
			// Available setting not found in the option group.
			if ( ! array_key_exists( $setting_name, $options_group ) ) {
				// Define the setting with its default value.
				$options_group[ $setting_name ] = $setting_value;
			}
		}
		// Return settings loaded from option group.
		return $options_group;
	}
}
