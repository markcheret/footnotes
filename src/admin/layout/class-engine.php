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
 * @since  2.8.0  Rename file from `layout.php` to `class-engine.php`,
 *                rename `dashboard/` sub-directory to `layout/`.
 */

declare(strict_types=1);

namespace footnotes\admin\layout;

use footnotes\includes\{Settings, Convert, Admin};

require_once plugin_dir_path( __DIR__ ) . 'layout/class-init.php';

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
	protected ?string $sub_page_hook = null;

	/**
	 * Stores all Sections for the child sub-page.
	 *
	 * @access  protected
	 * @var  array
	 *
	 * @since  1.5.0
	 */
	protected array $sections = array();

	/**
	 * Returns a Priority index. Lower numbers have a higher priority.
	 *
	 * @abstract
	 *
	 * @since  1.5.0
	 */
	abstract public function get_priority(): int;
	/**
	 * Registers a sub-page.
	 *
	 * @since  1.5.0
	 */
	public function register_sub_page(): void {
		global $submenu;

		if ( array_key_exists( plugin_basename( Init::MAIN_MENU_SLUG ), $submenu ) ) {
			foreach ( $submenu[ plugin_basename( Init::MAIN_MENU_SLUG ) ] as $sub_menu ) {
				if ( plugin_basename( Init::MAIN_MENU_SLUG . $this->get_sub_page_slug() ) === $sub_menu[2] ) {
					remove_submenu_page( Init::MAIN_MENU_SLUG, Init::MAIN_MENU_SLUG . $this->get_sub_page_slug() );
				}
			}
		}

		$this->sub_page_hook = add_submenu_page(
			Init::MAIN_MENU_SLUG,
			$this->get_sub_page_title(),
			$this->get_sub_page_title(),
			'manage_options',
			Init::MAIN_MENU_SLUG . $this->get_sub_page_slug(),
			fn() => $this->display_content()
		);
	}
	/**
	 * Registers all sections for a sub-page.
	 *
	 * @since  1.5.0
	 */
	public function add_settings_sections(): void {
		$this->sections = array(
			$this->settings->settings_sections['general']->get_section_slug() => $this->settings->settings_sections['general'],
			$this->settings->settings_sections['referrers_and_tooltips']->get_section_slug() => $this->settings->settings_sections['referrers_and_tooltips'],
			$this->settings->settings_sections['scope_and_priority']->get_section_slug() => $this->settings->settings_sections['scope_and_priority'],
			$this->settings->settings_sections['custom_css']->get_section_slug() => $this->settings->settings_sections['custom_css'],
		);
	}
	
	// phpcs:disable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	/**
	 * Displays the content of specific sub-page.
	 *
	 * @since  1.5.0
	 * @todo  Review nonce verification.
	 */
	public function display_content(): void {
		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$active_section_id = isset( $_GET['t'] ) ? wp_unslash( $_GET['t'] ) : array_key_first( $this->sections );
		$active_section    = $this->sections[ $active_section_id ];

		// Store settings.
		$settings_updated = false;
		if ( array_key_exists( 'save-settings', $_POST ) ) {
			if ( 'save' === $_POST['save-settings'] ) {
				unset( $_POST['save-settings'] );
				unset( $_POST['submit'] );
				$settings_updated = $this->save_settings();
			}
		}

		?>
	<div class="wrap">
	  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	  <h2 class="nav-tab-wrapper">
			<?php foreach ( $this->sections as $section_slug => $section ) : ?>
				<a 
					class="nav-tab<?php echo ( $section_slug === $active_section->get_section_slug() ) ? ' nav-tab-active' : ''; ?>"
					href="?page=<?php echo Init::MAIN_MENU_SLUG; ?>&t=<?php echo $section_slug; ?>">
					<?php echo $section->get_title(); ?>	
				</a>
			<?php endforeach; ?>
			</h2>
			<?php

			if ( $settings_updated ) {
				echo sprintf( '<div id="message" class="updated">%s</div>', __( 'Settings saved', 'footnotes' ) );
			}

			// show error/update messages
			settings_errors( 'footnotes_messages' );
			?>
	  <form action="" method="post">
		  <input type="hidden" name="save-settings" value="save" />
		<?php
		// output security fields for the registered setting "footnotes"
		settings_fields( 'footnotes' );

		// output setting sections and their fields
		// (sections are registered for "footnotes", each field is registered to a specific section)
		do_settings_sections( 'footnotes' );

				// do_meta_boxes( $active_section['id'], 'main', null );

				// Add submit button to active section if defined.
				// if ( $l_arr_active_section['submit'] ) {
					submit_button();
				// }
		?>
	  </form>
	</div>
		<?php
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	
	/**
	 * Output the description of a section. May be overwritten in any section.
	 *
	 * @since  1.5.0
	 * @todo  Required? Should be `abstract`?
	 */
	public function description(): void {
		// Nothing yet.
	}

	/**
	 * Returns the unique slug of the child sub-page.
	 *
	 * @abstract
	 * @access  protected
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_sub_page_slug(): string;

	/**
	 * Returns the title of the child sub-page.
	 *
	 * @abstract
	 * @access  protected
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_sub_page_title(): string;

	/**
	 * Returns an array of all registered sections for a sub-page.
	 *
	 * @abstract
	 * @access  protected
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_sections(): array;

	/**
	 * Returns an array of all registered meta boxes.
	 *
	 * @abstract
	 * @access  protected
	 *
	 * @since  1.5.0
	 */
	abstract protected function get_meta_boxes(): array;


	abstract protected function add_settings_fields(): void;

	/**
	 * Returns an array describing a sub-page section.
	 *
	 * @access  protected
	 * @param  string $id  Unique ID suffix.
	 * @param  string $title  Title of the section.
	 * @param  int    $settings_container_index  Settings Container index.
	 * @param  bool   $has_submit_button  Whether a ‘Submit’ button should
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
	protected function add_section( string $id, string $title, int $settings_container_index, bool $has_submit_button = true ): array {
		return array(
			'id'        => $this->plugin_name . '-' . $id,
			'title'     => $title,
			'submit'    => $has_submit_button,
			'container' => $settings_container_index,
		);
	}

	/**
	 * Returns an array describing a meta box.
	 *
	 * @access  protected
	 * @param  string $section_id  Parent section ID.
	 * @param  string $id  Unique ID suffix.
	 * @param  string $title  Title for the meta box.
	 * @param  string $callback_function_name  Class method name for callback.
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
	protected function add_meta_box( string $section_id, string $id, string $title, string $callback_function_name ): array {
		return array(
			'parent'   => $this->plugin_name . '-' . $section_id,
			'id'       => $id,
			'title'    => $title,
			'callback' => $callback_function_name,
		);
	}

	/**
	 * Loads a specified setting.
	 *
	 * @access  protected
	 * @param  string $setting_key_name  Setting key.
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
	protected function load_setting( string $setting_key_name ): array {
		// Get current section.
		reset( $this->sections );
		$return          = array();
		$return['id']    = $setting_key_name;
		$return['name']  = $setting_key_name;
		$return['value'] = esc_attr( $this->settings->get( $setting_key_name ) );
		return $return;
	}

	/**
	 * Returns a simple text inside a 'span' element.
	 *
	 * @access  protected
	 * @param  string $text  Message to be surrounded with `<span>` tags.
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_text( string $text ): string {
		return sprintf( '<span>%s</span>', $text );
	}

	/**
	 * Returns the HTML tag for a 'label' element.
	 *
	 * @access  protected
	 * @param  string $setting_name  Settings key.
	 * @param  string $caption  Label caption.
	 *
	 * @since  1.5.0
	 * @todo  Refactor HTML generation.
	 */
	protected function add_label( string $setting_name, string $caption ): string {
		if ( empty( $caption ) ) {
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
		return sprintf( '<label for="%s">%s</label>', $setting_name, $caption );
	}

	/**************************************************************************
	 * NEW METHODS
	 **************************************************************************/

	/**
	 * Constructs the HTML for a text 'input' element.
	 *
	 * @access  protected
	 * @param  array $args Input arguments. @see {Setting::get_setting_field_args()}.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Rename function from 'add_text_box' to 'add_input_text'.
	 *                Replace multiple arguments with single 'args' array.
	 */
	protected function add_input_text( array $args ): void {
		extract( $args );

		echo ( sprintf(
			'<input type="text" name="%s" id="%s" maxlength="%d" style="%s" value="%s"%s%s/>',
			$name,
			$name,
			$max_length ?? 999,
			$style ?? '',
			$value,
			isset( $readonly ) ? ' readonly="readonly"' : '',
			$disabled ? ' disabled' : ''
		) );
	}

	/**
	 * Constructs the HTML for a 'textarea' element.
	 *
	 * @access  protected
	 * @param  array $args Input arguments. @see {Setting::get_setting_field_args()}.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Replace 'p_str_setting_name' argument with 'args' array.
	 */
	protected function add_textarea( array $args ): void {
		extract( $args );

		echo ( sprintf(
			'<textarea name="%s" id="%s" rows="4" cols="50" style="%s" %s%s>%s</textarea>',
			$name,
			$name,
			$style ?? '',
			isset( $readonly ) ? ' readonly="readonly"' : '',
			$disabled ? ' disabled' : '',
			$value,
		) );
	}

	/**
	 * Constructs the HTML for a numeric 'input' element.
	 *
	 * @access  protected
	 * @param  array $args Input arguments. @see {Setting::get_setting_field_args()}.
	 *
	 * @since  1.5.0
	 * @since  2.1.4  Add step argument and 'number_format()' to allow decimals
	 * @since  2.8.0  Rename function from 'add_num_box' to 'add_input_number'.
	 *                Replace multiple arguments with single 'args' array.
	 */
	protected function add_input_number( array $args ): void {
		extract( $args );

		echo ( sprintf(
			'<input type="number" name="%s" id="%s"%s%s value="%s"%s%s%s/>',
			$name,
			$name,
			isset( $max ) ? ' max="' . $max . '"' : '',
			isset( $min ) ? ' min="' . $min . '"' : '',
			is_float( $value ) ? number_format( $value, 1 ) : $value,
			is_float( $value ) ? ' step="0.1"' : '',
			isset( $readonly ) ? ' readonly="readonly"' : '',
			$disabled ? ' disabled' : ''
		) );
	}

	/**
	 * Constructs the HTML for a 'select' element.
	 *
	 * @access  protected
	 * @param  array $args Input arguments. @see {Setting::get_setting_field_args()}.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Rename function from 'add_select_box' to 'add_select'.
	 *                Replace multiple arguments with single 'args' array.
	 */
	protected function add_select( array $args ): void {
		extract( $args );

		if ( ! isset( $options ) ) {
			trigger_error( "No options passed to 'select' element.", E_USER_ERROR );
		}

		$select_options = '';
		// Loop through all array keys.
		foreach ( $options as $option_value => $option_text ) {
			$select_options .= sprintf(
				'<option value="%s"%s>%s</option>',
				$option_value,
				// Only check for equality, not identity, WRT backlink symbol arrows.
				// TODO convert to strict comparison
				// phpcs:disable WordPress.PHP.StrictComparisons.LooseComparison
				$value == $option_value ? ' selected' : '',
				// phpcs:enable WordPress.PHP.StrictComparisons.LooseComparison
				$option_text
			);
		}

		echo ( sprintf(
			'<select name="%s" id="%s"%s>%s</select>',
			$name,
			$name,
			$disabled ? ' disabled' : '',
			$select_options
		) );
	}

	/**
	 * Constructs the HTML for a checkbox 'input' element.
	 *
	 * @access  protected
	 * @param  array $args Input arguments. @see {Setting::get_setting_field_args()}.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Rename function from 'add_checkbox' to 'add_input_checkbox'.
	 *                Replace 'p_str_setting_name' argument with 'args' array.
	 */
	protected function add_input_checkbox( array $args ): void {
		extract( $args );

		echo sprintf(
			'<input type="checkbox" name="%s" id="%s"%s%s/>',
			$name,
			$name,
			$value ? ' checked="checked"' : '',
			$disabled ? ' disabled' : ''
		);
	}

	/**
	 * Constructs the HTML for a color 'input' element.
	 *
	 * @access  protected
	 * @param  array $args Input arguments. @see {Setting::get_setting_field_args()}.
	 *
	 * @since  1.5.6
	 * @since  2.8.0  Rename function from 'add_color_selection' to 'add_input_color'.
	 *                Replace 'p_str_setting_name' argument with 'args' array.
	 */
	protected function add_input_color( array $args ): void {
		extract( $args );

		echo sprintf(
			'<input type="color" name="%s" id="%s"%s/>',
			$name,
			$name,
			$disabled ? ' disabled' : ''
		);
	}

	/******************************
	 *  OLD METHODS
	 ******************************/

	/**
	 * Registers all Meta boxes for a sub-page.
	 *
	 * @access  private
	 * @param  string $parent_id  Parent section unique ID.
	 *
	 * @since  1.5.0
	 */
	private function register_meta_boxes( string $parent_id ): void {
		// Iterate through each meta box.
		foreach ( $this->get_meta_boxes() as $meta_box ) {
			if ( $parent_id !== $meta_box['parent'] ) {
				continue;
			}
			add_meta_box(
				$parent_id . '-' . $meta_box['id'],
				$meta_box['title'],
				array( $this, $meta_box['callback'] ),
				$parent_id,
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
	 * @todo  Move to {@see Admin}.
	 */
	private function append_scripts(): void {
		wp_enqueue_script( 'postbox' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing

	// phpcs:disable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing

	/**
	 * Save plugin settings.
	 *
	 * @access  private
	 * @return  bool  `true` on save success, else `false`.
	 *
	 * @since  1.5.0
	 * @todo  Review nonce verification.
	 * @todo  New settings require a page refresh to render correctly. Fix.
	 */
	private function save_settings(): bool {
		$new_settings      = array();
		$active_section_id = isset( $_GET['t'] ) ? wp_unslash( $_GET['t'] ) : array_key_first( $this->sections );
		$active_section    = $this->sections[ $active_section_id ];

		foreach ( array_keys( $active_section->get_options() ) as $setting_key ) {
			$new_settings[ $setting_key ] = array_key_exists( $setting_key, $_POST ) ? wp_unslash( $_POST[ $setting_key ] ) : '';
		}

		// Update settings.
		return $this->settings->save_options_group( $active_section->get_options_group_slug(), $new_settings );
	}

}
