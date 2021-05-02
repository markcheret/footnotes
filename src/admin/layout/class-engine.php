<?php // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Admin. Layouts: Engine class
 *
 * The Admin. Layouts subpackage is composed of the {@see Engine}
 * abstract class, which is extended by the {@see Settings}
 * sub-class. The subpackage is initialised at runtime by the {@see
 * Init} class.
 *
 * @package  footnotes
 * @since  1.5.0
 * @since  2.8.0  Rename file from `layout.php` to `class-footnotes-layout-engine.php`,
 *                              rename `dashboard/` sub-directory to `layout/`.
 */

declare(strict_types=1);

namespace footnotes\admin\layout;

use footnotes\includes as Includes;

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'layout/class-init.php';

/**
 * Class to be extended by page layout sub-classes.
 *
 * @abstract
 *
 * @package  footnotes
 * @since  1.5.0
 */
abstract class Engine {

	/**
	 * The ID of this plugin.
	 *
	 * @access  protected
	 * @var  string  $plugin_name  The ID of this plugin.
	 *
	 * @since  2.8.0
	 */
	protected string $plugin_name;

	/**
	 * Stores the Hook connection string for the child sub-page.
	 *
	 * @access  protected
	 * @var  null|string
	 *
	 * @since  1.5.0
	 */
	protected ?string $a_str_sub_page_hook;

	/**
	 * Stores all Sections for the child sub-page.
	 *
	 * @access  protected
	 * @var  array
	 *
	 * @since  1.5.0
	 */
	protected array $a_arr_sections = array();

	/**
	 * Returns a Priority index. Lower numbers have a higher priority.
	 *
	 * @abstract
	 * @return  int
	 *
	 * @since  1.5.0
	 */
	abstract public function get_priority(): int;

	/**
	 * Returns the unique slug of the child sub-page.
	 *
	 * @abstract
	 * @access  protected
	 * @return  string
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_sub_page_slug(): string;

	/**
	 * Returns the title of the child sub-page.
	 *
	 * @abstract
	 * @access  protected
	 * @return  string
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_sub_page_title(): string;

	/**
	 * Returns an array of all registered sections for a sub-page.
	 *
	 * @abstract
	 * @access  protected
	 * @return  array
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_sections(): array;

	/**
	 * Returns an array of all registered meta boxes.
	 *
	 * @abstract
	 * @access  protected
	 * @return  array
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_meta_boxes(): array;

	/**
	 * Returns an array describing a sub-page section.
	 *
	 * @access  protected
	 * @param  string $p_str_id  Unique ID suffix.
	 * @param  string $p_str_title  Title of the section.
	 * @param  int    $p_int_settings_container_index  Settings Container index.
	 * @param  bool   $p_bool_has_submit_button  Whether a ‘Submit’ button should
	 *                                           be displayed for this section. Default `true`.
	 * @return  array  {
	 *     A dashboard section.
	 *
	 *     @type  string  $id  Section ID.
	 *     @type  string  $title  Section title.
	 *     @type  bool  $submit  Whether the section has a submit button or not.
	 *     @type  int  $container  Settings Container index.
	 * }
	 *
	 * @since  1.5.0
	 * @todo  Refactor sections into their own class?
	 */
	protected function add_section( string $p_str_id, string $p_str_title, int $p_int_settings_container_index, bool $p_bool_has_submit_button = true ): array {
		return array(
			'id'        => $this->plugin_name . '-' . $p_str_id,
			'title'     => $p_str_title,
			'submit'    => $p_bool_has_submit_button,
			'container' => $p_int_settings_container_index,
		);
	}

	/**
	 * Returns an array describing a meta box.
	 *
	 * @access  protected
	 * @param  string $p_str_section_id  Parent section ID.
	 * @param  string $p_str_id  Unique ID suffix.
	 * @param  string $p_str_title  Title for the meta box.
	 * @param  string $p_str_callback_function_name  Class method name for callback.
	 * @return  array  {
	 *     A dashboard meta box.
	 *
	 *     @type  string  $parent  Parent section ID.
	 *     @type  string  $id  Meta box ID.
	 *     @type  string  $title  Meta box title.
	 *     @type  string  $callback  Meta box callback function.
	 * }
	 *
	 * @since  1.5.0
	 * @todo  Refactor meta boxes into their own class?
	 * @todo  Pass actual functions rather than strings?
	 */
	protected function add_meta_box( string $p_str_section_id, string $p_str_id, string $p_str_title, string $p_str_callback_function_name ): array {
		return array(
			'parent'   => $this->plugin_name . '-' . $p_str_section_id,
			'id'       => $p_str_id,
			'title'    => $p_str_title,
			'callback' => $p_str_callback_function_name,
		);
	}

	/**
	 * Registers a sub-page.
	 *
	 * @since  1.5.0
	 */
	public function register_sub_page(): void {
		global $submenu;

		if ( array_key_exists( plugin_basename( Init::C_STR_MAIN_MENU_SLUG ), $submenu ) ) {
			foreach ( $submenu[ plugin_basename( Init::C_STR_MAIN_MENU_SLUG ) ] as $l_arr_sub_menu ) {
				if ( plugin_basename( Init::C_STR_MAIN_MENU_SLUG . $this->get_sub_page_slug() ) === $l_arr_sub_menu[2] ) {
					remove_submenu_page( Init::C_STR_MAIN_MENU_SLUG, Init::C_STR_MAIN_MENU_SLUG . $this->get_sub_page_slug() );
				}
			}
		}

		$this->a_str_sub_page_hook = add_submenu_page(
			Init::C_STR_MAIN_MENU_SLUG,
			$this->get_sub_page_title(),
			$this->get_sub_page_title(),
			'manage_options',
			Init::C_STR_MAIN_MENU_SLUG . $this->get_sub_page_slug(),
			function () {
				return $this->display_content();
			}
		);
	}

	/**
	 * Registers all sections for a sub-page.
	 *
	 * @since  1.5.0
	 */
	public function register_sections(): void {
		foreach ( $this->get_sections() as $l_arr_section ) {
			// Append tab to the tab-array.
			$this->a_arr_sections[ $l_arr_section['id'] ] = $l_arr_section;
			add_settings_section(
				$l_arr_section['id'],
				'',
				function () {
					return $this->description();
				},
				$l_arr_section['id']
			);
			$this->register_meta_boxes( $l_arr_section['id'] );
		}
	}

	/**
	 * Registers all Meta boxes for a sub-page.
	 *
	 * @access  private
	 * @param  string $p_str_parent_id  Parent section unique ID.
	 *
	 * @since  1.5.0
	 */
	private function register_meta_boxes( string $p_str_parent_id ): void {
		// Iterate through each meta box.
		foreach ( $this->get_meta_boxes() as $l_arr_meta_box ) {
			if ( $p_str_parent_id !== $l_arr_meta_box['parent'] ) {
				continue;
			}
			add_meta_box(
				$p_str_parent_id . '-' . $l_arr_meta_box['id'],
				$l_arr_meta_box['title'],
				array( $this, $l_arr_meta_box['callback'] ),
				$p_str_parent_id,
				'main'
			);
		}
	}

	/**
	 * Append JavaScript and CSS files for specific sub-page.
	 *
	 * @access  private
	 *
	 * @since  1.5.0
	 * @todo  Move to {@see Includes\Admin}.
	 */
	private function append_scripts(): void {
		wp_enqueue_script( 'postbox' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	// phpcs:disable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	/**
	 * Displays the content of specific sub-page.
	 *
	 * @since  1.5.0
	 * @todo  Review nonce verification.
	 */
	public function display_content(): void {
		$this->append_scripts();

		// Get the current section.
		reset( $this->a_arr_sections );
		$l_str_active_section_id = isset( $_GET['t'] ) ? wp_unslash( $_GET['t'] ) : key( $this->a_arr_sections );
		$l_arr_active_section    = $this->a_arr_sections[ $l_str_active_section_id ];

		// Store settings.
		$l_bool_settings_updated = false;
		if ( array_key_exists( 'save-settings', $_POST ) && 'save' === $_POST['save-settings'] ) {
			unset( $_POST['save-settings'] );
			unset( $_POST['submit'] );
			$l_bool_settings_updated = $this->save_settings();
		}

		// Display all sections and highlight the active section.
		echo '<div class="wrap">';
		echo '<h2 class="nav-tab-wrapper">';
		// Iterate through all register sections.
		foreach ( $this->a_arr_sections as $l_str_id => $l_arr_description ) {
			echo sprintf(
				'<a class="nav-tab%s" href="?page=%s&t=%s">%s</a>',
				( $l_str_id === $l_arr_active_section['id'] ) ? ' nav-tab-active' : '',
				Init::C_STR_MAIN_MENU_SLUG,
				$l_str_id,
				$l_arr_description['title']
			);
		}
		echo '</h2><br/>';

		if ( $l_bool_settings_updated ) {
			echo sprintf( '<div id="message" class="updated">%s</div>', __( 'Settings saved', 'footnotes' ) );
		}

		// Form to submit the active section.
		echo '<!--suppress HtmlUnknownTarget --><form method="post" action="">';
		echo '<input type="hidden" name="save-settings" value="save" />';
		// Outputs the settings field of the active section.
		do_settings_sections( $l_arr_active_section['id'] );
		do_meta_boxes( $l_arr_active_section['id'], 'main', null );

		// Add submit button to active section if defined.
		if ( $l_arr_active_section['submit'] ) {
			submit_button();
		}
		echo '</form>';
		echo '</div>';

		// Echo JavaScript for the expand/collapse function of the meta boxes.
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function ($) {';
		echo 'jQuery(".footnotes-color-picker").wpColorPicker();';
		echo "jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');";
		echo "postboxes.add_postbox_toggles('" . $this->a_str_sub_page_hook . "');";
		echo '});';
		echo '</script>';
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing

	// phpcs:disable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	/**
	 * Save all plugin settings.
	 *
	 * @access  private
	 * @return  bool  `true` on save success, else `false`.
	 *
	 * @since  1.5.0
	 * @todo  Review nonce verification.
	 */
	private function save_settings(): bool {
		$l_arr_new_settings = array();

		// TODO: add nonce verification.

		// Get current section.
		reset( $this->a_arr_sections );
		$l_str_active_section_id = isset( $_GET['t'] ) ? wp_unslash( $_GET['t'] ) : key( $this->a_arr_sections );
		$l_arr_active_section    = $this->a_arr_sections[ $l_str_active_section_id ];

		foreach ( array_keys( Includes\Settings::instance()->get_defaults( $l_arr_active_section['container'] ) ) as $l_str_key ) {
			$l_arr_new_settings[ $l_str_key ] = array_key_exists( $l_str_key, $_POST ) ? wp_unslash( $_POST[ $l_str_key ] ) : '';
		}
		// Update settings.
		return Includes\Settings::instance()->save_options( $l_arr_active_section['container'], $l_arr_new_settings );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing

	/**
	 * Output the description of a section. May be overwritten in any section.
	 *
	 * @since  1.5.0
	 * @todo  Required? Should be `abstract`?
	 */
	public function description(): void {
		// Default no description will be displayed.
	}

	/**
	 * Loads a specified setting.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_key_name  Setting key.
	 * @return  array  {
	 *     A configurable setting.
	 *
	 *     @type  string  $id  Setting key.
	 *     @type  string  $name  Setting name.
	 *     @type  string  $value  Setting value.
	 * }
	 *
	 * @since  1.5.0
	 * @since  2.5.11  Broken due to accidental removal of `esc_attr()` call.
	 * @since  2.6.1  Restore `esc_attr()` call.
	 */
	protected function load_setting( string $p_str_setting_key_name ): array {
		// Get current section.
		reset( $this->a_arr_sections );
		$p_arr_return          = array();
		$p_arr_return['id']    = $p_str_setting_key_name;
		$p_arr_return['name']  = $p_str_setting_key_name;
		$p_arr_return['value'] = esc_attr( Includes\Settings::instance()->get( $p_str_setting_key_name ) );
		return $p_arr_return;
	}

	/**
	 * Returns a simple text inside a 'span' element.
	 *
	 * @access  protected
	 * @param  string $p_str_text  Message to be surrounded with `<span>` tags.
	 * @return  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_text( string $p_str_text ): string {
		return sprintf( '<span>%s</span>', $p_str_text );
	}

	/**
	 * Returns the HTML tag for a 'label' element.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_name  Settings key.
	 * @param  string $p_str_caption  Label caption.
	 * @return  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_label( string $p_str_setting_name, string $p_str_caption ): string {
		if ( empty( $p_str_caption ) ) {
			return '';
		}

		/*
		 * Remove the colon causing localization issues with French, and with
		 * languages not using punctuation at all, and with languages using other
		 * punctuation marks instead of colon, e.g. Greek using a raised dot.
		 * In French, colon is preceded by a space, forcibly non-breaking, and
		 * narrow per new school.
		 * Add colon to label strings for inclusion in localization. Colon after
		 * label is widely preferred best practice, mandatory per
		 * {@link https://softwareengineering.stackexchange.com/questions/234546/colons-in-internationalized-ui
		 * style guides}.
		 */
		return sprintf( '<label for="%s">%s</label>', $p_str_setting_name, $p_str_caption );
	}

	/**
	 * Constructs the HTML for a text 'input' element.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_name  Setting key.
	 * @param  int    $p_str_max_length  Maximum length of the input. Default length 999 chars.
	 * @param  bool   $p_bool_readonly  Set the input to be read only. Default `false`.
	 * @param  bool   $p_bool_hidden  Set the input to be hidden. Default `false`.
	 * @return  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_text_box( string $p_str_setting_name, int $p_str_max_length = 999, bool $p_bool_readonly = false, bool $p_bool_hidden = false ): string {
		$l_str_style = '';
		// Collect data for given settings field.
		$l_arr_data = $this->load_setting( $p_str_setting_name );
		if ( $p_bool_hidden ) {
			$l_str_style .= 'display:none;';
		}
		return sprintf(
			'<input type="text" name="%s" id="%s" maxlength="%d" style="%s" value="%s" %s/>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			$p_str_max_length,
			$l_str_style,
			$l_arr_data['value'],
			$p_bool_readonly ? 'readonly="readonly"' : ''
		);
	}

	/**
	 * Constructs the HTML for a checkbox 'input' element.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_name  Setting key.
	 * @return  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_checkbox( string $p_str_setting_name ): string {
		// Collect data for given settings field.
		$l_arr_data = $this->load_setting( $p_str_setting_name );
		return sprintf(
			'<input type="checkbox" name="%s" id="%s" %s/>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			Includes\Convert::to_bool( $l_arr_data['value'] ) ? 'checked="checked"' : ''
		);
	}

	/**
	 * Constructs the HTML for a 'select' element.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_name  Setting key.
	 * @param  array  $p_arr_options  Possible options.
	 * @return  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_select_box( string $p_str_setting_name, array $p_arr_options ): string {
		// Collect data for given settings field.
		$l_arr_data    = $this->load_setting( $p_str_setting_name );
		$l_str_options = '';

		// Loop through all array keys.
		foreach ( $p_arr_options as $l_str_value => $l_str_caption ) {
			$l_str_options .= sprintf(
				'<option value="%s" %s>%s</option>',
				$l_str_value,
				// Only check for equality, not identity, WRT backlink symbol arrows.
				// phpcs:disable WordPress.PHP.StrictComparisons.LooseComparison
				$l_str_value == $l_arr_data['value'] ? 'selected' : '',
				// phpcs:enable WordPress.PHP.StrictComparisons.LooseComparison
				$l_str_caption
			);
		}
		return sprintf(
			'<select name="%s" id="%s">%s</select>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			$l_str_options
		);
	}

	/**
	 * Constructs the HTML for a 'textarea' element.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_name  Setting key.
	 * @return  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_textarea( $p_str_setting_name ): string {
		// Collect data for given settings field.
		$l_arr_data = $this->load_setting( $p_str_setting_name );
		return sprintf(
			'<textarea name="%s" id="%s">%s</textarea>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			$l_arr_data['value']
		);
	}

	/**
	 * Constructs the HTML for a text 'input' element with the colour selection
	 * class.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_name Setting key.
	 * @return  string
	 *
	 * @since  1.5.6
	 * @todo  Refactor HTML generation.
	 * @todo  Use proper colorpicker element.
	 */
	protected function add_color_selection( string $p_str_setting_name ): string {
		// Collect data for given settings field.
		$l_arr_data = $this->load_setting( $p_str_setting_name );
		return sprintf(
			'<input type="text" name="%s" id="%s" class="footnotes-color-picker" value="%s"/>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			$l_arr_data['value']
		);
	}

	/**
	 * Constructs the HTML for numeric 'input' element.
	 *
	 * @access  protected
	 * @param  string $p_str_setting_name Setting key.
	 * @param  int    $p_in_min  Minimum value.
	 * @param  int    $p_int_max  Maximum value.
	 * @param  bool   $p_bool_deci  `true` if float, `false` if integer. Default `false`.
	 * @return  string
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_num_box( string  $p_str_setting_name, int $p_in_min, int $p_int_max, bool $p_bool_deci = false ): string {
		// Collect data for given settings field.
		$l_arr_data = $this->load_setting( $p_str_setting_name );

		if ( $p_bool_deci ) {
			$l_str_value = number_format( floatval( $l_arr_data['value'] ), 1 );
			return sprintf(
				'<input type="number" name="%s" id="%s" value="%s" step="0.1" min="%d" max="%d"/>',
				$l_arr_data['name'],
				$l_arr_data['id'],
				$l_str_value,
				$p_in_min,
				$p_int_max
			);
		} else {
			return sprintf(
				'<input type="number" name="%s" id="%s" value="%d" min="%d" max="%d"/>',
				$l_arr_data['name'],
				$l_arr_data['id'],
				$l_arr_data['value'],
				$p_in_min,
				$p_int_max
			);
		}
	}

}
