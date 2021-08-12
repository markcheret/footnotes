<?php
/**
 * File providing the `ReferrersAndTooltipsSettingsSection` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\referrersandtooltips;

use footnotes\includes\Settings;
use footnotes\includes\settings\SettingsSection;

/**
 * Class defining plugin referrer and tooltips settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ReferrersAndTooltipsSettingsSection extends SettingsSection {
	/**
	 * The groups of settings within this section.
	 *
	 * @var  SettingsGroup[]
	 *
	 * @since  2.8.0
	 */
	protected array $settings_groups;

	/**
	 * Constructs the settings section.
	 *
	 * @param string $options_group_slug The slug of the settings section's options group.
	 * @param string $section_slug The slug of the settings section.
	 * @param string $title The name of the settings section.
	 *
	 * @since  2.8.0
	 */
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
		private Settings $settings
	) {
		$this->options_group_slug = $options_group_slug;
		$this->section_slug       = $section_slug;
		$this->title              = $title;

		$this->load_dependencies();

		$this->add_settings_groups( get_option( $this->options_group_slug ) );

		$this->load_options_group();
	}

	/**
	 * Load the required dependencies.
	 *
	 * Include the following files that provide the settings for this section:
	 *
	 * - {@see SettingsSection}: defines a section of settings;
	 * - {@see BacklinkSymbolSettingsGroup};
	 * - {@see ReferrersSettingsGroup};
	 * - {@see ReferrersInLabelsSettingsGroup};
	 * - {@see TooltipsSettingsGroup};
	 * - {@see TooltipAppearanceSettingsGroup};
	 * - {@see TooltipDimensionsSettingsGroup};
	 * - {@see TooltipPositionSettingsGroup};
	 * - {@see TooltipTextSettingsGroup};
	 * - {@see TooltipTimingSettingsGroup}; and
	 * - {@see TooltipTruncationSettingsGroup}.
	 *
	 * @see SettingsSection::load_dependencies()
	 */
	protected function load_dependencies(): void {
		parent::load_dependencies();

		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-backlinksymbolsettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-referrerssettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-referrersinlabelssettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-tooltipssettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-tooltipappearancesettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-tooltipdimensionssettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-tooltippositionsettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-tooltiptextsettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-tooltiptimingsettingsgroup.php';
		require_once plugin_dir_path( __DIR__ ) . 'referrers-and-tooltips/class-tooltiptruncationsettingsgroup.php';
	}

	/**
	 * Add the settings groups for this settings section.
	 *
	 * @see SettingsSection::add_settings_groups()
	 */
	protected function add_settings_groups(): void {
		$this->settings_groups = array(
			BacklinkSymbolSettingsGroup::GROUP_ID    => new BacklinkSymbolSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			ReferrersSettingsGroup::GROUP_ID         => new ReferrersSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			ReferrersInLabelsSettingsGroup::GROUP_ID => new ReferrersInLabelsSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			TooltipsSettingsGroup::GROUP_ID          => new TooltipsSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			TooltipAppearanceSettingsGroup::GROUP_ID => new TooltipAppearanceSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			TooltipDimensionsSettingsGroup::GROUP_ID => new TooltipDimensionsSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			TooltipPositionSettingsGroup::GROUP_ID   => new TooltipPositionSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			TooltipTextSettingsGroup::GROUP_ID       => new TooltipTextSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			TooltipTimingSettingsGroup::GROUP_ID     => new TooltipTimingSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
			TooltipTruncationSettingsGroup::GROUP_ID => new TooltipTruncationSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
		);
	}
}
