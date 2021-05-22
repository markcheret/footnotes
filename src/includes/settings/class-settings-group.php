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
	 * Setting section slug.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	protected string $options_group_slug;
	/**
	 * Setting section slug.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	protected string $section_slug;
		
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = '';
	
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
	
	protected abstract function load_dependencies(): void;
	
	protected abstract function add_settings(array $options): void;
	
	protected abstract function add_settings_fields(Layout\Settings $component): void;
	
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
