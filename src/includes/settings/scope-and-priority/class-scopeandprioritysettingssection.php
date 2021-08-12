<?php
/**
 * File providing the `ScopeAndPrioritySettingsSection` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\scopeandpriority;

use footnotes\includes\Settings;
use footnotes\includes\settings\SettingsSection;

use footnotes\includes\settings\scopeandpriority\WordPressHooksSettingsGroup;

/**
 * Class defining plugin hook priority settings.
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
	 * - {@see SettingsSection}: defines a settings section; and
	 * - {@see WordPressHooksSettingsGroup}.
	 *
	 * @see SettingsSection::load_dependencies()
	 */
	protected function load_dependencies(): void {
		parent::load_dependencies();

		require_once plugin_dir_path( __DIR__ ) . 'scope-and-priority/class-wordpresshookssettingsgroup.php';
	}

	/**
	 * Add the settings groups for this settings section.
	 *
	 * @see SettingsSection::add_settings_groups()
	 */
	protected function add_settings_groups(): void {
		$this->settings_groups = array(
			WordPressHooksSettingsGroup::GROUP_ID => new WordPressHooksSettingsGroup( $this->options_group_slug, $this->section_slug, $this->settings ),
		);
	}
}
