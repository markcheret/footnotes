<?php
/**
 * File providing the `GeneralSettingsSection` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-section.php';

use footnotes\includes\Settings;

use footnotes\includes\settings\SettingsSection;

use footnotes\includes\settings\general\ReferenceContainerSettingsGroup;
use footnotes\includes\settings\general\ScrollingSettingsGroup;
use footnotes\includes\settings\general\ShortcodeSettingsGroup;
use footnotes\includes\settings\general\NumberingSettingsGroup;
use footnotes\includes\settings\general\HardLinksSettingsGroup;
use footnotes\includes\settings\general\LoveSettingsGroup;
use footnotes\includes\settings\general\ExcerptsSettingsGroup;
use footnotes\includes\settings\general\AMPCompatSettingsGroup;

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
		$title,
		
		/**
		 * The plugin settings object.
		 *
		 * @access  private
		 * @since  2.8.0
		 */
		protected Settings $settings
	) {
		$this->options_group_slug = $options_group_slug;
		$this->section_slug       = $section_slug;
		$this->title              = $title;

		$this->load_dependencies();

		$this->add_settings_groups( get_option( $this->options_group_slug ) );

		$this->load_options_group();
	}

	protected function load_dependencies(): void {
		parent::load_dependencies();

		require_once plugin_dir_path( __DIR__ ) . 'general/class-reference-container-settings-group.php';
		require_once plugin_dir_path( __DIR__ ) . 'general/class-scrolling-settings-group.php';
		require_once plugin_dir_path( __DIR__ ) . 'general/class-shortcode-settings-group.php';
		require_once plugin_dir_path( __DIR__ ) . 'general/class-numbering-settings-group.php';
		require_once plugin_dir_path( __DIR__ ) . 'general/class-hard-links-settings-group.php';
		require_once plugin_dir_path( __DIR__ ) . 'general/class-love-settings-group.php';
		require_once plugin_dir_path( __DIR__ ) . 'general/class-excerpts-settings-group.php';
		require_once plugin_dir_path( __DIR__ ) . 'general/class-amp-compat-settings-group.php';
	}

	protected function add_settings_groups(): void {
		$this->settings_groups = array(
			AMPCompatSettingsGroup::GROUP_ID          => new AMPCompatSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			ReferenceContainerSettingsGroup::GROUP_ID => new ReferenceContainerSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			ScrollingSettingsGroup::GROUP_ID          => new ScrollingSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			ShortcodeSettingsGroup::GROUP_ID          => new ShortcodeSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			NumberingSettingsGroup::GROUP_ID          => new NumberingSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			HardLinksSettingsGroup::GROUP_ID          => new HardLinksSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			ExcerptsSettingsGroup::GROUP_ID           => new ExcerptsSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			LoveSettingsGroup::GROUP_ID               => new LoveSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
		);
	}
}
