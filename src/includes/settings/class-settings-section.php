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
	
	protected abstract function load_dependencies(): void;
	
	public function add_settings_section(): void {
		add_settings_section(
			$this->section_slug, 
			$this->title, 
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
}
