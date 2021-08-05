<?php
/**
 * File providing the `ScopeAndPrioritySettingsSection` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\scopeandpriority;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-section.php';

use footnotes\includes\settings\SettingsSection;
// Import settings groups.
//use footnotes\includes\settings\scope-and-priority\...;

/**
 * Class defining plugin referrer and tooltips settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ScopeAndPrioritySettingsSection extends SettingsSection {	
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
	  
		//require_once plugin_dir_path( __DIR__ ) . 'general/class-reference-container-settings-group.php';
	}
	
	protected function add_settings_groups(): void {
		$this->settings_groups = array (
			// Add settings groups.
			//...::GROUP_ID => new ...($this->options_group_slug, $this->section_slug),
		);
	}
}
