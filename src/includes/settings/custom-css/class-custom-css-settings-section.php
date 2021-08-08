<?php
/**
 * File providing the `CustomCSSSettingsSection` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\customcss;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-section.php';

use footnotes\includes\settings\SettingsSection;

// Import settings groups.
use footnotes\includes\settings\customcss\CustomCSSSettingsGroup;

/**
 * Class defining plugin referrer and tooltips settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class CustomCSSSettingsSection extends SettingsSection {	
	/**
	 * The groups of settings within this section.
	 *
	 * @var  SettingsGroup[]
	 *
	 * @since  2.8.0
	 */
	protected array $settings_groups;
	
	public function __construct(
		$options_group_slug,
		$section_slug,
		$title
	) {
		$this->options_group_slug = $options_group_slug;
		$this->section_slug = $section_slug;
		$this->title = $title;
				
		$this->load_dependencies();
		
		$this->add_settings_groups(get_option( $this->options_group_slug ));

		$this->load_options_group();
	}
	
	protected function load_dependencies(): void {
	  parent::load_dependencies();
	  
		require_once plugin_dir_path( __DIR__ ) . 'custom-css/class-custom-css-settings-group.php';
	}
	
	protected function add_settings_groups(): void {
		$this->settings_groups = array (
			CustomCSSSettingsGroup::GROUP_ID => new CustomCSSSettingsGroup($this->options_group_slug, $this->section_slug),
		);
	}
}
