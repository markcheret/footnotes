<?php
/**
 * File providing the `ReferenceContainerSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;
use footnotes\admin\layout\Settings as SettingsLayout;

/**
 * Class defining the reference container settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ReferenceContainerSettingsGroup extends SettingsGroup {		
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'reference-container';
	
	/**
	 * Settings container key for the label of the reference container.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const REFERENCE_CONTAINER_NAME = array(
		'key' => 'footnote_inputfield_references_label',
		'name' => 'Reference Container Name',
		'description' => 'The title of the reference container.',
		'default_value' => 'Reference',
		'type' => 'string',
		'input_type' => 'text'
	);
	
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
		
		$this->add_settings(get_option( $this->options_group_slug ));
	}
	
	protected function load_dependencies(): void {
		require_once plugin_dir_path( __DIR__ ) . 'class-setting.php';
	}
	
	protected function add_settings(array $options): void {
		$this->settings = array(
			self::REFERENCE_CONTAINER_NAME['key'] => $this->add_setting(self::REFERENCE_CONTAINER_NAME)
		);
	}
	
	private function add_setting(array $setting): Setting {
		extract( $setting );
		
		return new Setting(
			self::GROUP_ID, 
			$this->options_group_slug, 
			$this->section_slug,
			$key,
			$name,
			$description,
			$default_value,
			$type,
			$input_type
		);
	}
	
	public function add_settings_fields($component): void {
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
}
