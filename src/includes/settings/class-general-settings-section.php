<?php
/**
 * File providing the `GeneralSettingsSection` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings;

require_once plugin_dir_path( __DIR__ ) . 'settings/class-settings-section.php';

use footnotes\includes\settings\general\ReferenceContainerSettingsGroup;

/**
 * Class defining general plugin settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class GeneralSettingsSection extends SettingsSection {	
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
	}
	
	protected function load_dependencies(): void {
		require_once plugin_dir_path( __DIR__ ) . 'settings/general/class-reference-container-settings-group.php';
	}
	
	protected function add_settings_groups(): void {
		$this->settings_groups = array (
			ReferenceContainerSettingsGroup::GROUP_ID => new ReferenceContainerSettingsGroup($this->options_group_slug, $this->section_slug),
		);
	}
}
