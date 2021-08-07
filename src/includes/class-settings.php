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
	 * Options for the custom width units (per cent is a ratio, not a unit).
	 *
	 * @var  array
	 *
	 * @since  2.8.0
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const WIDTH_UNIT_OPTIONS = array(
		'%'   => 'per cent',
		'px'  => 'pixels',
		'rem' => 'root em',
		'em'  => 'em',
		'vw'  => 'viewport width',
	);

	/**
	 * Settings container key for the Custom CSS.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const CUSTOM_CSS = 'footnote_inputfield_custom_css';
	
	/**
	 * Settings container key to enable the `the_title` hook.
	 *
	 * These are checkboxes; the keyword `checked` is converted to `true`, whilst
	 * an empty string (the default) is converted to `false`.
	 *
	 * Hooks should all be enabled by default to prevent users from thinking at
	 * first that the feature is broken in post titles (see {@link
	 * https://wordpress.org/support/topic/more-feature-ideas/ here} for more
	 * information).
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 * @todo  In titles, footnotes are still buggy, because WordPress uses the
	 *              title string in menus and in the title element, but Footnotes doesn't
	 *              delete footnotes in them.
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_THE_TITLE = 'footnote_inputfield_expert_lookup_the_title';

	/**
	 * Settings container key to enable the `the_content` hook.
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_THE_CONTENT = 'footnote_inputfield_expert_lookup_the_content';

	/**
	 * Settings container key to enable the `the_excerpt` hook.
	 *
	 * @var  string
	 *
	 * @see FOOTNOTES_IN_EXCERPT
	 *
	 * @since  1.5.5
	 * @since  2.6.3  Enable by default.
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_THE_EXCERPT = 'footnote_inputfield_expert_lookup_the_excerpt';

	/**
	 * Settings container key to enable the `widget_title` hook.
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_WIDGET_TITLE = 'footnote_inputfield_expert_lookup_widget_title';

	/**
	 * Settings container key to enable the `widget_text` hook.
	 *
	 * The `widget_text` hook must be disabled by default, because it causes
	 * multiple reference containers to appear in Elementor accordions, but
	 * it must be enabled if multiple reference containers are desired, as
	 * in Elementor toggles.
	 *
	 * @var  string
	 *
	 * @since  1.5.5
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_WIDGET_TEXT = 'footnote_inputfield_expert_lookup_widget_text';

	/**
	 * Settings container key for the mouse-over box to define the max. width.
	 *
	 * The width should be limited to start with, for the box to have shape.
	 *
	 * The default width is 450.
	 *
	 * @var  int
	 *
	 * @since  1.5.6
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH = 'footnote_inputfield_custom_mouse_over_box_max_width';

	/**
	 * Settings container key to get the backlink symbol switch side.
	 *
	 * @var  string
	 *
	 * @since  2.1.1
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH = 'footnotes_inputfield_reference_container_backlink_symbol_switch';

	/**
	 * Settings container key for `the_content` hook priority level.
	 *
	 * Priority level of `the_content` and of `widget_text` as the only relevant
	 * hooks must be less than 99 because social buttons may yield scripts
	 * that contain the strings ‘((’ and ‘))’ (i.e., the default footnote
	 * start and end shortcodes), which causes issues with fake footnotes.
	 *
	 * Setting `the_content` priority to 10 instead of `PHP_INT_MAX` makes the
	 * footnotes reference container display beneath the post and above other
	 * features added by other plugins, e.g. related post lists and social buttons.
	 *
	 * For the {@link https://wordpress.org/plugins/yet-another-related-posts-plugin/
	 * YARPP} plugin to display related posts below the Footnotes reference container,
	 * priority needs to be at least 1,200.
	 *
	 * `PHP_INT_MAX` cannot be reset by leaving the number box empty, because
	 * WebKit browsers don't allow it, so we must resort to -1.
	 *
	 * @var  int
	 *
	 * @since  2.0.5
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_content_priority_level';

	/**
	 * Settings container key for `the_title` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_title_priority_level';

	/**
	 * Settings container key for `widget_title` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_widget_title_priority_level';

	/**
	 * Settings container key for `widget_text` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_widget_text_priority_level';

	/**
	 * Settings container key for `the_excerpt` hook priority level.
	 *
	 * @var  int
	 *
	 * @since  2.1.2
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL = 'footnote_inputfield_expert_lookup_the_excerpt_priority_level';
	
	/**
	 * Settings container key for reference container position shortcode.
	 *
	 * @var  string
	 *
	 * @since  2.2.0
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const REFERENCE_CONTAINER_POSITION_SHORTCODE = 'footnote_inputfield_reference_container_position_shortcode';

	/**
	 * Settings container key for the Custom CSS migrated to a dedicated tab.
	 *
	 * @var  string
	 *
	 * @since  2.2.2
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const CUSTOM_CSS_NEW = 'footnote_inputfield_custom_css_new';

	/**
	 * Settings container key to enable display of legacy Custom CSS metaboxes.
	 *
	 * This must be `false` if its setting is contained in the container to be hidden
	 * because when saving, all missing constants are emptied, and {@see
	 * Footnotes_Convert::to_bool()} converts empty to `false`.
	 *
	 * @var  string
	 *
	 * @since  2.2.2
	 * @since  2.3.0  Swap migration Boolean, meaning ‘show legacy’ instead of
	 *                              ‘migration complete’, due to storage data structure constraints.
	 * @todo  Move to `SettingsSection`/`SettingsGroup`.
	 */
	const CUSTOM_CSS_LEGACY_ENABLE = 'footnote_inputfield_custom_css_legacy_enable';

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
	 * Contains all default values for each Settings Container.
	 *
	 * @var  (string|int)[]
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Rename from `default` to `default_settings`.
	 * @deprecated
	 *
	 * @todo  Delete once moved to `SettingsSection`/`SettingsGroup`s.
	 */
	private array $default_settings = array(
	
		// Referrers and tooltips.
		'footnotes_storage_custom'     => array(
		
			// Your existing Custom CSS code.
			self::CUSTOM_CSS                               => '',

		),

		// Scope and priority.
		'footnotes_storage_expert'     => array(

			// WordPress hooks with priority level.
			self::EXPERT_LOOKUP_THE_TITLE                  => "",
			self::EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL   => PHP_INT_MAX,

			self::EXPERT_LOOKUP_THE_CONTENT                => 'checked',
			self::EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL => 98,

			self::EXPERT_LOOKUP_THE_EXCERPT                => '',
			self::EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL => PHP_INT_MAX,

			self::EXPERT_LOOKUP_WIDGET_TITLE               => '',
			self::EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL => PHP_INT_MAX,

			self::EXPERT_LOOKUP_WIDGET_TEXT                => '',
			self::EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL => 98,

		),

		// Custom CSS.
		'footnotes_storage_custom_css' => array(

			// Your existing Custom CSS code.
			self::CUSTOM_CSS_LEGACY_ENABLE => 'yes',

			// Custom CSS.
			self::CUSTOM_CSS_NEW           => '',

		),

	);

	/**
	 * Contains all Settings from each Settings Container.
	 *
	 * @var  (string|int)[]
	 *
	 * @since  1.5.0
	 * @deprecated
	 *
	 * @todo  Delete once all `SettingsSection`/`SettingsGroup`s set up.
	 */
	public array $settings = array();
	
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
	 * Register all Settings Containers for the plugin Settings Page in the Dashboard.
	 *
	 * The Settings Container label will be the same as the Settings Container name.
	 *
	 * @since  1.5.0
	 * @todo  Only register current tab?
	 */
	public function register_settings(): void {
		// Register all settings.	
		foreach ($this->default_settings as $options_groups_name => $options_groups_values) {
			foreach ($options_groups_values as $setting_name => $setting_value) {
				if (!is_array($setting_value)) {
					register_setting( $options_groups_name, $setting_name );
				} else {
					register_setting( $options_groups_name, $setting_name, $setting_value['setting_args']);
				}
			}
		}
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
