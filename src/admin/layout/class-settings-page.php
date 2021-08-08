<?php // phpcs:disable Squiz.Commenting.FileComment.Missing
/**
 * Admin. Layouts: Settings class
 *
 * The Admin. Layouts subpackage is composed of the {@see Engine}
 * abstract class, which is extended by the {@see Settings}
 * sub-class. The subpackage is initialised at runtime by the {@see
 * Init} class.
 *
 * @package  footnotes\admin_layout
 * @since  1.5.0
 * @since  2.8.0  Rename file from `subpage-main.php` to `class-settings-page.php`,
 *                Rename `dashboard/` sub-directory to `layout/`.
 */

declare(strict_types=1);

namespace footnotes\admin\layout;

require_once plugin_dir_path( dirname( __FILE__, 2 ) ) . 'includes/class-settings.php';

use footnotes\includes\{Template, Settings, Parser, Config, Convert};
use footnotes\general\General;
use const footnotes\settings\general\ReferenceContainerSettingsGroup\{COMBINE_IDENTICAL_FOOTNOTES};

/**
 * Provides the abstract class to be extended for page layouts.
 */
require_once plugin_dir_path( __DIR__ ) . 'layout/class-engine.php';

/**
 * Class to initialise all defined page layouts.
 *
 * @package  footnotes
 * @since  1.5.0
 * @since  2.8.0  Rename class from `Settings` to `SettingsPage`.
 *
 * @see  Engine
 */
class SettingsPage extends Engine {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  2.8.0
	 */
	public function __construct(
		/**
		 * The ID of this plugin.
		 *
		 * @access  private
		 * @var  string  $plugin_name  The ID of this plugin.
		 *
		 * @since  2.8.0
		 */
		protected string $plugin_name,
		
		/**
		 * The plugin settings object.
		 *
		 * @access  private
		 * @since  2.8.0
		 */
		protected Settings $settings	
  ) {
  }

	/**
	 * Returns a priority index.
	 *
	 * Lower numbers have a higher priority.
	 *
	 * @since  1.5.0
	 * @return  int
	 */
	public function get_priority(): int {
		return 10;
	}
	
	/**************************************************************************
	 * NEW METHODS
	 **************************************************************************/
	 
	public function add_settings_fields(): void {
		$active_section_id = isset( $_GET['t'] ) ? wp_unslash( $_GET['t'] ) : array_key_first( $this->sections );
		$active_section    = $this->sections[ $active_section_id ];
		
		switch ($active_section->get_section_slug()) {
			case 'footnotes-settings':
				$this->settings->settings_sections['general']->add_settings_fields($this);
				break;
			case 'footnotes-customize':
				$this->settings->settings_sections['referrers_and_tooltips']->add_settings_fields($this);
				break;
			case 'footnotes-expert':
				$this->settings->settings_sections['scope_and_priority']->add_settings_fields($this);
				break;
			case 'footnotes-customcss':
				$this->settings->settings_sections['custom_css']->add_settings_fields($this);
				break;
			case 'footnotes-how-to':
				print_r("Demo goes here");
				break;
			default: print_r("ERR: section not found");
		}		
	}
	
	public function setting_field_callback( array $args ): void {		
		if (isset($args['type'])) {
			echo $args['description'] . '</td><td>';
			
			switch($args['type']) {
				case 'text':
					$this->add_input_text($args);
					return;
				case 'textarea':
					$this->add_textarea($args);
					return;
				case 'number':
					$this->add_input_number($args);
					return;
				case 'select':
					$this->add_select($args);
					return;
				case 'checkbox':
					$this->add_input_checkbox($args);
					return;
				case 'color':
					$this->add_input_color($args);
					return;
				default: trigger_error("Unknown setting type.", E_USER_ERROR);
			}
		} else trigger_error("No setting type.", E_USER_ERROR);
	}

	/**************************************************************************
	 * NEW METHODS END
	 **************************************************************************/
	 
	/**
	 * Displays a short introduction to the plugin.
	 *
	 * @since  1.5.0
	 * @todo Review in light of admin/public split.
	 */
	public function help(): void {
		$general = new General( $this->plugin_name, 'foo' );

		// Load footnotes starting and end tag.
		$footnote_starting_tag = $this->load_setting( Settings::FOOTNOTES_SHORT_CODE_START );
		$footnote_ending_tag   = $this->load_setting( Settings::FOOTNOTES_SHORT_CODE_END );

		if ( 'userdefined' === $footnote_starting_tag['value'] || 'userdefined' === $footnote_ending_tag['value'] ) {
			// Load user defined starting and end tag.
			$footnote_starting_tag = $this->load_setting( Settings::FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$footnote_ending_tag   = $this->load_setting( Settings::FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}
		$example = 'Hello' . $footnote_starting_tag['value'] .
		'Sed ut perspiciatis, unde omnis iste natus error ' .
		'sit voluptatem accusantium doloremque laudantium, ' .
		'totam rem aperiam eaque ipsa, quae ab illo ' .
		'inventore veritatis et quasi architecto beatae ' .
		'vitae dicta sunt, explicabo. Nemo enim ipsam ' .
		'voluptatem, quia voluptas sit, aspernatur aut ' .
		'odit aut fugit, sed quia consequuntur magni ' .
		'dolores eos, qui ratione voluptatem sequi nesciunt, ' .
		'neque porro quisquam est, qui dolorem ipsum, quia ' .
		'dolor sit amet, consectetur, adipisci velit, sed ' .
		'quia non numquam eius modi tempora incidunt, ut ' .
		'labore et dolore magnam aliquam quaerat voluptatem.' .
		$footnote_ending_tag['value'] . ' World!';

		// Load template file.
		$template = new Template( Template::DASHBOARD, 'how-to-help' );
		// Replace all placeholders.
		$template->replace(
			array(
				'label-start'    => __( 'Start your footnote with the following short code:', 'footnotes' ),
				'start'          => $footnote_starting_tag['value'],
				'label-end'      => __( '&hellip;and end your footnote with this short code:', 'footnotes' ),
				'end'            => $footnote_ending_tag['value'],
				'example-code'   => $example,
				'example-string' => '<br/>' . __( 'will be displayed as:', 'footnotes' ),
				'example'        => $general->task->exec( $example, true ),
				// Translators: %1$s, %2$s: anchor element with hyperlink to the Support Forum.
				'information'    => sprintf( __( 'For further information please check out our %1$sSupport Forum%2$s on WordPress.org.', 'footnotes' ), '<a href="https://wordpress.org/support/plugin/footnotes" target="_blank" class="footnote_plugin">', '</a>' ),
			)
		);

		/*
		 * Call {@see Parser::footnotes_output_head()} function to get
		 * the styling of the mouse-over box.
		 *
		 * The name of the callback function ought to be distinct from
		 * the name of the filtered function.
		 * When this callback function was renamed, this call went unnoticed.
		 */
		$general->task->footnotes_output_head();

		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all Donate button to support the developers.
	 *
	 * @since  1.5.0
	 */
	public function donate(): void {
		// Load template file.
		$template = new Template( Template::DASHBOARD, 'how-to-donate' );
		// Replace all placeholders.
		$template->replace(
			array(
				'caption' => __( 'Donate now', 'footnotes' ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $template->get_content();
		// phpcs:enable
	}
	/**
	 * Returns the unique slug of the sub-page.
	 *
	 * @since  1.5.0
	 * @return  string
	 */
	protected function get_sub_page_slug(): string {
		return '-' . $this->plugin_name;
	}
	/**
	 * Returns the title of the sub-page.
	 *
	 * @since  1.5.0
	 * @return  string
	 */
	protected function get_sub_page_title(): string {
		return Config::PLUGIN_PUBLIC_NAME;
	}
	/**
	 * Returns an array of all registered sections for the sub-page.
	 *
	 * @see  Engine::add_section()  For more information on the section array format.
	 * @return  array[]  All of the registered sections.
	 *
	 * @since  1.5.0
	 * @since  2.1.6  Remove conditional rendering of ‘Expert’ tab.
	 */
	protected function get_sections(): array {
		$tabs = array();

		// Sync tab name with mirror in task.php.
		$tabs[] = $this->add_section( 'settings', __( 'General settings', 'footnotes' ), 0, true );

		// Sync tab name with mirror in public function custom_css_migration().
		$tabs[] = $this->add_section( 'customize', __( 'Referrers and tooltips', 'footnotes' ), 1, true );

		$tabs[] = $this->add_section( 'expert', __( 'Scope and priority', 'footnotes' ), 2, true );
		$tabs[] = $this->add_section( 'customcss', __( 'Custom CSS', 'footnotes' ), 3, true );
		$tabs[] = $this->add_section( 'how-to', __( 'Quick start guide', 'footnotes' ), 4, false );

		return $tabs;
	}
	/**
	 * Returns an array of all registered meta boxes for each section of the sub-page.
	 *
	 * @see  Engine::add_meta_box()  For more information on the
	 *                                                                                      meta box array format.
	 * @return  array[]  All of the registered meta boxes.
	 *
	 * @since  1.5.0
	 * @since  2.2.0  Re-order and rename tabs.
	 */
	protected function get_meta_boxes(): array {
		$meta_boxes = array();

		$meta_boxes[] = $this->add_meta_box( 'how-to', 'help', __( 'Brief introduction: How to use the plugin', 'footnotes' ), 'help' );
		$meta_boxes[] = $this->add_meta_box( 'how-to', 'donate', __( 'Help us to improve our Plugin', 'footnotes' ), 'donate' );

		return $meta_boxes;
	}
}
