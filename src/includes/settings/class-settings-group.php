<?php
/**
 * File providing the `SettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings;

use footnotes\admin\layout as Layout;

/**
 * Class defining a group of plugin settings within a section.
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
	 * The general settings.
	 *
	 * @var  Setting[]
	 *
	 * @since  2.8.0
	 */
	protected array $settings;
	
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
		protected string $section_slug
	) {		
		$this->load_dependencies();
		
		$this->add_settings( get_option( $this->options_group_slug ) );
	}
	
	protected function load_dependencies(): void {
		require_once plugin_dir_path( __DIR__ ) . 'settings/class-setting.php';
	}
	
	protected abstract function add_settings(array|false $options): void;
	
	protected function add_setting(array $setting): Setting {
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
			$overridden_by['key'] ?? null
		);
	}
	
	protected function load_values(array|false $options): void {
	  if ( ! $options ) return;
		
		// TODO remove unfound settings from option
		foreach ( $options as $setting_key => $setting_value ) {
		  $setting = $this->settings[$setting_key];
		  if ($setting) $setting->set_value( $setting_value );
		  else trigger_error("Setting with key {$setting_key} not found, skipping...", E_USER_WARNING);  
	  }
	}
	
	public function add_settings_fields(Layout\SettingsPage $component): void {	  
		foreach ($this->settings as $setting) {			
			add_settings_field(
				$setting->key, 
				__( $setting->name, 'footnotes' ),
				array ($component, 'setting_field_callback'),
				'footnotes',
				$setting->get_section_slug(),
				$setting->get_setting_field_args()
			);
		}
	}
	
	public function get_setting(string $setting_key): ?Setting {
		foreach ($this->settings as $setting) {
			if ($setting->key === $setting_key) return $setting;
		}
		
		return null;
	}

	public function get_options(): array {
		$options = array();
		
		foreach ($this->settings as $setting) {
			$options[$setting->key] = $setting->get_value();
		}
		
		return $options;
	}

	public function get_setting_value(string $setting_key) {
		$setting = $this->get_setting($setting_key);

		if (! $setting) return null;
		else return $setting->value ?? $setting->default_value;
	}

	public function set_setting_value(string $setting_key, $value): bool {
		return $this->get_setting($setting_key)->set_value($value);
	}
}
