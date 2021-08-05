<?php
/**
 * File providing the (new) `SettingsSection` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings;

use footnotes\admin\layout as Layout;

/**
 * Class defining plugin settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
abstract class SettingsSection {		
	/**
	 * Setting options group slug.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	protected string $options_group_slug;
	
	/**
	 * Settings section slug.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	protected string $section_slug = '';
	
	/**
	 * Settings section title.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	protected string $title = '';
	
	/**
	 * The groups of settings within this section.
	 *
	 * @var  SettingGroup[]
	 *
	 * @since  2.8.0
	 */
	protected array $settings_groups;
	
	protected function load_dependencies(): void {
		require_once plugin_dir_path( __DIR__ ) . 'settings/class-setting.php';
	}
	
	public function load_options_group(): void {
		$options_group = get_option($this->options_group_slug);
		
		if (!! $options_group) {
			foreach ($options_group as $setting_key => $setting_value) {
				$this->set_setting_value($setting_key, $setting_value);
			}
		}
	}
	
	public function add_settings_section(): void {
		add_settings_section(
			$this->section_slug, 
			__( $this->title, 'footnotes'), 
			array($this, 'setting_section_callback'),
			'footnotes'
		);
	}
	
	public function add_settings_fields($component): void {
		foreach($this->settings_groups as $settings_group) {
			$settings_group->add_settings_fields($component);
		}
	}
	
	public function setting_section_callback(): void {
		echo "<hr>";
	}
	
	protected abstract function add_settings_groups(): void;
	
	public function get_options_group_slug(): string {
		return $this->options_group_slug;
	}
	
	public function get_section_slug(): string {
		return $this->section_slug;
	}
	
	public function get_title(): string {
		return $this->title;
	}
	
	public function get_settings_group(string $group_id) {
		return $this->settings_groups[$group_id];
	}
	
	public function get_setting(string $setting_key): ?Setting {
		foreach ($this->settings_groups as $settings_group) {
			$setting = $settings_group->get_setting($setting_key);
			
			if ($setting) return $setting;
		}
		
		return null;
	}
	
	public function get_options(): array {
		$options = array();
		
		foreach ($this->settings_groups as $settings_group) {
			$options = array_merge($options, $settings_group->get_options());
		}
		
		return $options;
	}

	public function get_setting_value(string $setting_key) {
		$setting = $this->get_setting($setting_key);

		if (! $setting) return null;
		else return $setting->value ?? $setting->default_value ?? trigger_error("No default value found for ".$setting_key.".", E_USER_ERROR);
	}

	public function set_setting_value(string $setting_key, $value): ?bool {
		$setting = $this->get_setting($setting_key);
		
		if (! $setting) return null;
		else return $setting->set_value($value);
	}
}
