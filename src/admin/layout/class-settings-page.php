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
	 * @param  string $plugin_name  The name of this plugin.
	 */
	public function __construct( string $plugin_name ) {
		$this->plugin_name = $plugin_name;
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
				Settings::instance()->settings_sections['general']->add_settings_fields($this);
				break;
			case 'footnotes-customize':
				Settings::instance()->settings_sections['referrers_and_tooltips']->add_settings_fields($this);
				break;
			case 'footnotes-expert':
				Settings::instance()->settings_sections['scope_and_priority']->add_settings_fields($this);
				break;
			case 'footnotes-customcss':
				Settings::instance()->settings_sections['custom_css']->add_settings_fields($this);
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
				case 'number':
					$this->add_input_number($args);
					return;
				case 'select':
					$this->add_input_select($args);
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
	 * Displays the Custom CSS box.
	 *
	 * @since  1.5.0
	 */
	public function custom_css() {
		// Load template file.
		$template = new Template( Template::DASHBOARD, 'customize-css' );
		// Replace all placeholders.
		$template->replace(
			array(
				'label-css'       => $this->add_label( Settings::CUSTOM_CSS, __( 'Your existing Custom CSS code:', 'footnotes' ) ),
				'css'             => $this->add_textarea( Settings::CUSTOM_CSS ),
				'description-css' => __( 'Custom CSS migrates to a dedicated tab. This text area is intended to keep your data safe, and the code remains valid while visible. Please copy-paste the content into the new text area under the new tab.', 'footnotes' ),

				// phpcs:disable Squiz.PHP.CommentedOutCode.Found
				// CSS classes are listed in the template.
				// Localized notices are dropped to ease translators' task.

				// "label-class-1" => ".footnote_plugin_tooltip_text",.
				// "class-1" => $this->add_text(__("superscript, Footnotes index", $this->plugin_name)),.

				// "label-class-2" => ".footnote_tooltip",.
				// "class-2" => $this->add_text(__("mouse-over box, tooltip for each superscript", $this->plugin_name)),.

				// "label-class-3" => ".footnote_plugin_index",.
				// "class-3" => $this->add_text(__("1st column of the Reference Container, Footnotes index", $this->plugin_name)),.

				// "label-class-4" => ".footnote_plugin_text",.
				// "class-4" => $this->add_text(__("2nd column of the Reference Container, Footnote text", $this->plugin_name)).
				// phpcs:enable
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays transitional legacy Custom CSS box.
	 *
	 * @since  2.2.2
	 * @deprecated
	 */
	public function custom_css_migration(): void {

		// Options for Yes/No select box.
		$enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$template = new Template( Template::DASHBOARD, 'customize-css-migration' );
		// Replace all placeholders.
		$template->replace(
			array(
				'label-css'               => $this->add_label( Settings::CUSTOM_CSS, __( 'Your existing Custom CSS code:', 'footnotes' ) ),
				'css'                     => $this->add_textarea( Settings::CUSTOM_CSS ),
				'description-css'         => __( 'Custom CSS migrates to a dedicated tab. This text area is intended to keep your data safe, and the code remains valid while visible. Please copy-paste the content into the new text area below. Set Show legacy to No. Save twice.', 'footnotes' ),

				'label-show-legacy'       => $this->add_label( Settings::CUSTOM_CSS_LEGACY_ENABLE, 'Show legacy Custom CSS settings containers:' ),
				'show-legacy'             => $this->add_select_box( Settings::CUSTOM_CSS_LEGACY_ENABLE, $enabled ),
				'notice-show-legacy'      => __( 'Please set to No when you are done migrating, for the legacy Custom CSS containers to disappear.', 'footnotes' ),
				// Translators: %s: Referres and tooltips.
				'description-show-legacy' => sprintf( __( 'The legacy Custom CSS under the %s tab and its mirror here are emptied, and the select box saved as No, when the settings tab is saved while the settings container is not displayed.', 'footnotes' ), __( 'Referrers and tooltips', 'footnotes' ) ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays the new Custom CSS box.
	 *
	 * @since  2.2.2
	 */
	public function custom_css_new(): void {
		// Load template file.
		$template = new Template( Template::DASHBOARD, 'customize-css-new' );
		// Replace all placeholders.
		$template->replace(
			array(
				'css'      => $this->add_textarea( Settings::CUSTOM_CSS_NEW ),

				'headline' => $this->add_text( __( 'Recommended CSS classes:', 'footnotes' ) ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays available Hooks to look for Footnote short codes.
	 *
	 * Priority level was initially a hard-coded default
	 * shows ‘9223372036854775807’ in the numbox
	 * empty should be interpreted as `PHP_INT_MAX`,
	 * but a numbox cannot be set to empty, see {@link https://github.com/Modernizr/Modernizr/issues/171
	 * here}
	 * define -1 as `PHP_INT_MAX` instead
	 *
	 * @since  1.5.5
	 */
	public function lookup_hooks(): void {
		// Load template file.
		$template = new Template( Template::DASHBOARD, 'expert-lookup' );

		// Replace all placeholders.
		$template->replace(
			array(
				'description-1'         => __( 'The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features.', 'footnotes' ),
				// Translators: 1: 99; 2: 1200.
				'description-2'         => sprintf( __( 'For the_content, this figure must be lower than %1$d so that certain strings added by a plugin running at %1$d may not be mistaken as a footnote. This makes also sure that the reference container displays above a feature inserted by a plugin running at %2$d.', 'footnotes' ), 99, 1200 ),
				// Translators: 1: PHP_INT_MAX; 2: 0; 3: -1; 4: 'PHP_INT_MAX'.
				'description-3'         => sprintf( __( '%1$d is lowest priority, %2$d is highest. To set priority level to lowest, set it to %3$d, interpreted as %1$d, the constant %4$s.', 'footnotes' ), PHP_INT_MAX, 0, -1, 'PHP_INT_MAX' ),
				'description-4'         => __( 'The widget_text hook must be enabled either when footnotes are present in theme text widgets, or when Elementor accordions or toggles shall have a reference container per section. If they should not, this hook must be disabled.', 'footnotes' ),

				'head-hook'             => __( 'WordPress hook function name', 'footnotes' ),
				'head-checkbox'         => __( 'Activate', 'footnotes' ),
				'head-numbox'           => __( 'Priority level', 'footnotes' ),
				'head-url'              => __( 'WordPress documentation', 'footnotes' ),

				'label-the-title'       => $this->add_label( Settings::EXPERT_LOOKUP_THE_TITLE, 'the_title' ),
				'the-title'             => $this->add_checkbox( Settings::EXPERT_LOOKUP_THE_TITLE ),
				'priority-the-title'    => $this->add_num_box( Settings::EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-the-title'         => 'https://developer.wordpress.org/reference/hooks/the_title/',

				'label-the-content'     => $this->add_label( Settings::EXPERT_LOOKUP_THE_CONTENT, 'the_content' ),
				'the-content'           => $this->add_checkbox( Settings::EXPERT_LOOKUP_THE_CONTENT ),
				'priority-the-content'  => $this->add_num_box( Settings::EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-the-content'       => 'https://developer.wordpress.org/reference/hooks/the_content/',

				'label-the-excerpt'     => $this->add_label( Settings::EXPERT_LOOKUP_THE_EXCERPT, 'the_excerpt' ),
				'the-excerpt'           => $this->add_checkbox( Settings::EXPERT_LOOKUP_THE_EXCERPT ),
				'priority-the-excerpt'  => $this->add_num_box( Settings::EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-the-excerpt'       => 'https://developer.wordpress.org/reference/functions/the_excerpt/',

				'label-widget-title'    => $this->add_label( Settings::EXPERT_LOOKUP_WIDGET_TITLE, 'widget_title' ),
				'widget-title'          => $this->add_checkbox( Settings::EXPERT_LOOKUP_WIDGET_TITLE ),
				'priority-widget-title' => $this->add_num_box( Settings::EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-widget-title'      => 'https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_title',

				'label-widget-text'     => $this->add_label( Settings::EXPERT_LOOKUP_WIDGET_TEXT, 'widget_text' ),
				'widget-text'           => $this->add_checkbox( Settings::EXPERT_LOOKUP_WIDGET_TEXT ),
				'priority-widget-text'  => $this->add_num_box( Settings::EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-widget-text'       => 'https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_text',
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $template->get_content();
		// phpcs:enable
	}

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

		$meta_boxes[] = $this->add_meta_box( 'settings', 'amp-compat', __( 'AMP compatibility', 'footnotes' ), 'amp_compat' );
		$meta_boxes[] = $this->add_meta_box( 'settings', 'numbering', __( 'Footnotes numbering', 'footnotes' ), 'numbering' );
		$meta_boxes[] = $this->add_meta_box( 'settings', 'scrolling', __( 'Scrolling behavior', 'footnotes' ), 'scrolling' );
		$meta_boxes[] = $this->add_meta_box( 'settings', 'hard-links', __( 'URL fragment ID configuration', 'footnotes' ), 'hard_links' );
		$meta_boxes[] = $this->add_meta_box( 'settings', 'reference-container', __( 'Reference container', 'footnotes' ), 'reference_container' );
		$meta_boxes[] = $this->add_meta_box( 'settings', 'excerpts', __( 'Footnotes in excerpts', 'footnotes' ), 'excerpts' );
		$meta_boxes[] = $this->add_meta_box( 'settings', 'love', Config::PLUGIN_HEADING_NAME . '&nbsp;' . Config::LOVE_SYMBOL_HEADING, 'love' );

		$meta_boxes[] = $this->add_meta_box( 'customize', 'superscript', __( 'Referrers', 'footnotes' ), 'superscript' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'label-solution', __( 'Referrers in labels', 'footnotes' ), 'label_solution' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box', __( 'Tooltips', 'footnotes' ), 'mouseover_box' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-position', __( 'Tooltip position', 'footnotes' ), 'mouseover_box_position' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-dimensions', __( 'Tooltip dimensions', 'footnotes' ), 'mouseover_box_dimensions' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-timing', __( 'Tooltip timing', 'footnotes' ), 'mouseover_box_timing' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-truncation', __( 'Tooltip truncation', 'footnotes' ), 'mouseover_box_truncation' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-text', __( 'Tooltip text', 'footnotes' ), 'mouseover_box_text' );
		$meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-appearance', __( 'Tooltip appearance', 'footnotes' ), 'mouseover_box_appearance' );
		if ( Convert::to_bool( Settings::instance()->get( Settings::CUSTOM_CSS_LEGACY_ENABLE ) ) ) {
			$meta_boxes[] = $this->add_meta_box( 'customize', 'custom-css', __( 'Your existing Custom CSS code', 'footnotes' ), 'custom_css' );
		}

		$meta_boxes[] = $this->add_meta_box( 'expert', 'lookup', __( 'WordPress hooks with priority level', 'footnotes' ), 'lookup_hooks' );

		if ( Convert::to_bool( Settings::instance()->get( Settings::CUSTOM_CSS_LEGACY_ENABLE ) ) ) {
			$meta_boxes[] = $this->add_meta_box( 'customcss', 'custom-css-migration', __( 'Your existing Custom CSS code', 'footnotes' ), 'custom_css_migration' );
		}
		$meta_boxes[] = $this->add_meta_box( 'customcss', 'custom-css-new', __( 'Custom CSS', 'footnotes' ), 'custom_css_new' );

		$meta_boxes[] = $this->add_meta_box( 'how-to', 'help', __( 'Brief introduction: How to use the plugin', 'footnotes' ), 'help' );
		$meta_boxes[] = $this->add_meta_box( 'how-to', 'donate', __( 'Help us to improve our Plugin', 'footnotes' ), 'donate' );

		return $meta_boxes;
	}
}
