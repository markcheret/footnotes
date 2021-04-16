<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Includes Layout Engine for the admin dashboard.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 *
 * @since 2.1.2  add versioning of settings.css for cache busting
 * @since 2.1.4  automate passing version number for cache busting
 * @since 2.1.4  optional step argument and support for floating in numbox
 * @since 2.1.6  fix punctuation-related localization issue in dashboard labels
 *
 * @since 2.5.5  Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
 */

/**
 * Layout Engine for the administration dashboard.
 *
 * @since  1.5.0
 */
abstract class Footnotes_Layout_Engine {

	/**
	 * Stores the Hook connection string for the child sub page.
	 *
	 * @since  1.5.0
	 * @var null|string
	 */
	protected $sub_page_hook = null;

	/**
	 * Stores all Sections for the child sub page.
	 *
	 * @since 1.5.0
	 * @var array
	 */
	protected $sections = array();

	/**
	 * Returns a Priority index. Lower numbers have a higher Priority.
	 *
	 * @since 1.5.0
	 * @return int
	 */
	abstract public function get_priority();

	/**
	 * Returns the unique slug of the child sub page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function get_sub_page_slug();

	/**
	 * Returns the title of the child sub page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function get_sub_page_title();

	/**
	 * Returns an array of all registered sections for a sub page.
	 *
	 * @since  1.5.0
	 * @return array
	 */
	abstract protected function get_sections();

	/**
	 * Returns an array of all registered meta boxes.
	 *
	 * @since  1.5.0
	 * @return array
	 */
	abstract protected function get_meta_boxes();

	/**
	 * Returns an array describing a sub page section.
	 *
	 * @since 1.5.0
	 * @param string $id Unique ID suffix.
	 * @param string $title Title of the section.
	 * @param int    $settings_container_index Settings Container Index.
	 * @param bool   $has_submit_button Should a Submit Button be displayed for this section, default: true.
	 * @return array Array describing the section.
	 */
	protected function add_section( $id, $title, $settings_container_index, $has_submit_button = true ) {
		return array(
			'id'        => Footnotes_Config::PLUGIN_NAME . '-' . $id,
			'title'     => $title,
			'submit'    => $has_submit_button,
			'container' => $settings_container_index,
		);
	}

	/**
	 * Returns an array describing a meta box.
	 *
	 * @since  1.5.0
	 * @param string $section_id Parent Section ID.
	 * @param string $id Unique ID suffix.
	 * @param string $title Title for the meta box.
	 * @param string $callback_function_name Class method name for callback.
	 * @return array meta box description to be able to append a meta box to the output.
	 */
	protected function add_meta_box( $section_id, $id, $title, $callback_function_name ) {
		return array(
			'parent'   => Footnotes_Config::PLUGIN_NAME . '-' . $section_id,
			'id'       => $id,
			'title'    => $title,
			'callback' => $callback_function_name,
		);
	}

	/**
	 * Registers a sub page.
	 *
	 * @since  1.5.0
	 */
	public function register_sub_page() {
		global $submenu;

		if ( array_key_exists( plugin_basename( Footnotes_Layout_Init::MAIN_MENU_SLUG ), $submenu ) ) {
			foreach ( $submenu[ plugin_basename( Footnotes_Layout_Init::MAIN_MENU_SLUG ) ] as $sub_menu ) {
				if ( plugin_basename( Footnotes_Layout_Init::MAIN_MENU_SLUG . $this->get_sub_page_slug() ) === $sub_menu[2] ) {
					remove_submenu_page( Footnotes_Layout_Init::MAIN_MENU_SLUG, Footnotes_Layout_Init::MAIN_MENU_SLUG . $this->get_sub_page_slug() );
				}
			}
		}

		$this->sub_page_hook = add_submenu_page(
			Footnotes_Layout_Init::MAIN_MENU_SLUG,
			$this->get_sub_page_title(),
			$this->get_sub_page_title(),
			'manage_options',
			Footnotes_Layout_Init::MAIN_MENU_SLUG . $this->get_sub_page_slug(),
			array( $this, 'display_content' )
		);
	}

	/**
	 * Registers all sections for a sub page.
	 *
	 * @since 1.5.0
	 */
	public function register_sections() {
		foreach ( $this->get_sections() as $section ) {
			// Append tab to the tab-array.
			$this->sections[ $section['id'] ] = $section;
			add_settings_section(
				$section['id'],
				'',
				array( $this, 'Description' ),
				$section['id']
			);
			$this->register_meta_boxes( $section['id'] );
		}
	}

	/**
	 * Registers all Meta boxes for a sub page.
	 *
	 * @since 1.5.0
	 * @param string $parent_id Parent section unique id.
	 */
	private function register_meta_boxes( $parent_id ) {
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
	 * Append javascript and css files for specific sub page.
	 *
	 * @since  1.5.0
	 */
	private function append_scripts() {
		wp_enqueue_script( 'postbox' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		/**
		 * Registers and enqueues the dashboard stylesheet.
		 *
		 * - Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
		 *
		 * @since 2.5.5
		 *
		 * @reporter @docteurfitness
		 * @link https://wordpress.org/support/topic/simply-speed-optimisation/
		 *
		 * See the public stylesheet enqueuing:
		 * @see class/init.php
		 *
		 * added version # after changes started to settings.css from 2.1.2 on.
		 * automated update of version number for cache busting.
		 * No need to use '-styles' in the handle, as '-css' is appended automatically.
		 */
		if ( true === PRODUCTION_ENV ) {

			wp_register_style( 'mci-footnotes-admin', plugins_url( 'footnotes/css/settings.min.css' ), array(), FOOTNOTES_VERSION );

		} else {

			wp_register_style( 'mci-footnotes-admin', plugins_url( 'footnotes/css/settings.css' ), array(), FOOTNOTES_VERSION );

		}

		wp_enqueue_style( 'mci-footnotes-admin' );
	}

	// phpcs:disable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	/**
	 * Displays the content of specific sub page.
	 *
	 * @since  1.5.0
	 */
	public function display_content() {
		$this->append_scripts();

		// TODO: add nonce verification.

		// Get the current section.
		reset( $this->sections );
		$active_section_id = isset( $_GET['t'] ) ? wp_unslash( $_GET['t'] ) : key( $this->sections );
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

		// Display all sections and highlight the active section.
		echo '<div class="wrap">';
		echo '<h2 class="nav-tab-wrapper">';
		// Iterate through all register sections.
		foreach ( $this->sections as $id => $description ) {
			$tab_active = ( $id === $active_section['id'] ) ? ' nav-tab-active' : '';
			echo sprintf(
				'<a class="nav-tab%s" href="?page=%s&t=%s">%s</a>',
				( $id === $active_section['id'] ) ? ' nav-tab-active' : '',
				Footnotes_Layout_Init::MAIN_MENU_SLUG,
				$id,
				$description['title']
			);
		}
		echo '</h2><br/>';

		if ( $settings_updated ) {
			echo sprintf( '<div id="message" class="updated">%s</div>', __( 'Settings saved', 'footnotes' ) );
		}

		// Form to submit the active section.
		echo '<!--suppress HtmlUnknownTarget --><form method="post" action="">';
		echo '<input type="hidden" name="save-settings" value="save" />';
		// Outputs the settings field of the active section.
		do_settings_sections( $active_section['id'] );
		do_meta_boxes( $active_section['id'], 'main', null );

		// Add submit button to active section if defined.
		if ( $active_section['submit'] ) {
			submit_button();
		}
		echo '</form>';
		echo '</div>';

		// Echo JavaScript for the expand/collapse function of the meta boxes.
		echo '<script type="text/javascript">';
		echo 'jQuery(document).ready(function ($) {';
		echo 'jQuery(".footnotes-color-picker").wpColorPicker();';
		echo "jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');";
		echo "postboxes.add_postbox_toggles('" . $this->sub_page_hook . "');";
		echo '});';
		echo '</script>';
	}
	// phpcs:enable  WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing

	// phpcs:disable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	/**
	 * Save all Plugin settings.
	 *
	 * @since 1.5.0
	 * @return bool
	 */
	private function save_settings() {
		$new_settings = array();

		// TODO: add nonce verification.

		// Get current section.
		reset( $this->sections );
		$active_section_id = isset( $_GET['t'] ) ? wp_unslash( $_GET['t'] ) : key( $this->sections );
		$active_section    = $this->sections[ $active_section_id ];

		foreach ( Footnotes_Settings::instance()->get_defaults( $active_section['container'] ) as $key => $l_mixed_value ) {
			if ( array_key_exists( $key, $_POST ) ) {
				$new_settings[ $key ] = wp_unslash( $_POST[ $key ] );
			} else {
				// Setting is not defined in the POST array, define it to avoid the Default value.
				$new_settings[ $key ] = '';
			}
		}
		// Update settings.
		return Footnotes_Settings::instance()->save_options( $active_section['container'], $new_settings );
	}
	// phpcs:enable WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing

	/**
	 * Output the Description of a section. May be overwritten in any section.
	 *
	 * @since 1.5.0
	 */
	public function description() {
		// Default no description will be displayed.
	}

	/**
	 * Loads specific setting and returns an array with the keys [id, name, value].
	 *
	 * @since 1.5.0
	 * @param string $setting_key_name Settings Array key name.
	 * @return array Contains Settings ID, Settings Name and Settings Value.
	 *
	 * @since 2.5.11 Remove escapement function.
	 * When refactoring the codebase after 2.5.8, all and every output was escaped.
	 * After noticing that the plugin was broken, all escapement functions were removed.
	 * @link https://github.com/markcheret/footnotes/pull/50/commits/25c3f2f12eb5de1079e9215bf624ec4289b095a5
	 * @link https://github.com/markcheret/footnotes/pull/50#issuecomment-787624123
	 * In that process, this instance of esc_attr() was removed too, so the plugin was
	 * broken again.
	 * @link https://github.com/markcheret/footnotes/pull/50/commits/25c3f2f12eb5de1079e9215bf624ec4289b095a5#diff-a8ed6e859c32a18fc10bbbad3b4dd8ce7f43f2378d29471c7638e314ab30f1bdL349-L354
	 *
	 * @since 2.5.15 To fix it, the data was escaped in add_select_box() instead.
	 * @since 2.6.1  Restore esc_attr() in load_setting().
	 * @see add_select_box()
	 * This is the only instance of esc_|kses|sanitize in the pre-2.5.11 codebase.
	 * Removing this did not fix the quotation mark backslash escapement bug.
	 */
	protected function load_setting( $setting_key_name ) {
		// Get current section.
		reset( $this->sections );
		$return          = array();
		$return['id']    = sprintf( '%s', $setting_key_name );
		$return['name']  = sprintf( '%s', $setting_key_name );
		$return['value'] = esc_attr( Footnotes_Settings::instance()->get( $setting_key_name ) );
		return $return;
	}

	/**
	 * Returns a line break to start a new line.
	 *
	 * @since  1.5.0
	 * @return string
	 */
	protected function add_newline() {
		return '<br/>';
	}

	/**
	 * Returns a line break to have a space between two lines.
	 *
	 * @since  1.5.0
	 * @return string
	 */
	protected function add_line_space() {
		return '<br/><br/>';
	}

	/**
	 * Returns a simple text inside html <span> text.
	 *
	 * @since  1.5.0
	 * @param string $text Message to be surrounded with simple html tag (span).
	 * @return string
	 */
	protected function add_text( $text ) {
		return sprintf( '<span>%s</span>', $text );
	}

	/**
	 * Returns the html tag for an input/select label.
	 *
	 * @since  1.5.0
	 * @param string $setting_name Name of the Settings key to connect the Label with the input/select field.
	 * @param string $caption Label caption.
	 * @return string
	 */
	protected function add_label( $setting_name, $caption ) {
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
		 * [style guides](https://softwareengineering.stackexchange.com/questions/234546/colons-in-internationalized-ui).
		 */
		return sprintf( '<label for="%s">%s</label>', $setting_name, $caption );
	}

	/**
	 * Returns the html tag for an input [type = text].
	 *
	 * @since  1.5.0
	 * @param string $setting_name Name of the Settings key to pre load the input field.
	 * @param int    $max_length Maximum length of the input, default 999 characters.
	 * @param bool   $readonly Set the input to be read only, default false.
	 * @param bool   $hidden Set the input to be hidden, default false.
	 * @return string
	 */
	protected function add_text_box( $setting_name, $max_length = 999, $readonly = false, $hidden = false ) {
		$style = '';
		// Collect data for given settings field.
		$data = $this->load_setting( $setting_name );
		if ( $hidden ) {
			$style .= 'display:none;';
		}
		return sprintf(
			'<input type="text" name="%s" id="%s" maxlength="%d" style="%s" value="%s" %s/>',
			$data['name'],
			$data['id'],
			$max_length,
			$style,
			$data['value'],
			$readonly ? 'readonly="readonly"' : ''
		);
	}

	/**
	 * Returns the html tag for an input [type = checkbox].
	 *
	 * @since  1.5.0
	 * @param string $setting_name Name of the Settings key to pre load the input field.
	 * @return string
	 */
	protected function add_checkbox( $setting_name ) {
		// Collect data for given settings field.
		$data = $this->load_setting( $setting_name );
		return sprintf(
			'<input type="checkbox" name="%s" id="%s" %s/>',
			$data['name'],
			$data['id'],
			Footnotes_Convert::to_bool( $data['value'] ) ? 'checked="checked"' : ''
		);
	}

	/**
	 * Returns the html tag for a select box.
	 *
	 * @since  1.5.0
	 *
	 * - Bugfix: Dashboard: Referrers and tooltips: Backlink symbol: debug select box by reverting identity check to equality check, thanks to @lolzim bug report.
	 *
	 * @reporter @lolzim
	 *
	 * @since 2.5.13
	 * @param string $setting_name  Name of the Settings key to pre select the current value.
	 * @param array  $options       Possible options to be selected.
	 * @return string
	 *
	 * @since 2.5.15 Bugfix: Dashboard: General settings: Footnote start and end short codes: debug select box for shortcodes with pointy brackets.
	 * @since 2.6.1  Restore esc_attr() in load_setting(), remove htmlspecialchars() here.
	 */
	protected function add_select_box( $setting_name, $options ) {
		// Collect data for given settings field.
		$data    = $this->load_setting( $setting_name );
		$select_options = '';

		// Loop through all array keys.
		foreach ( $options as $value => $caption ) {
			$select_options .= sprintf(
				'<option value="%s" %s>%s</option>',
				$value,
				// Only check for equality, not identity, WRT backlink symbol arrows.
				$value == $data['value'] ? 'selected' : '',
				$caption
			);
		}
		return sprintf(
			'<select name="%s" id="%s">%s</select>',
			$data['name'],
			$data['id'],
			$select_options
		);
	}

	/**
	 * Returns the html tag for a text area.
	 *
	 * @since 1.5.0
	 * @param string $setting_name Name of the Settings key to pre fill the text area.
	 * @return string
	 */
	protected function add_textarea( $setting_name ) {
		// Collect data for given settings field.
		$data = $this->load_setting( $setting_name );
		return sprintf(
			'<textarea name="%s" id="%s">%s</textarea>',
			$data['name'],
			$data['id'],
			$data['value']
		);
	}

	/**
	 * Returns the html tag for an input [type = text] with color selection class.
	 *
	 * @since  1.5.6
	 * @param string $setting_name Name of the Settings key to pre load the input field.
	 * @return string
	 */
	protected function add_color_selection( $setting_name ) {
		// Collect data for given settings field.
		$data = $this->load_setting( $setting_name );
		return sprintf(
			'<input type="text" name="%s" id="%s" class="footnotes-color-picker" value="%s"/>',
			$data['name'],
			$data['id'],
			$data['value']
		);
	}

	/**
	 * Returns the html tag for an input [type = num].
	 *
	 * @since  1.5.0
	 * @param string $setting_name Name of the Settings key to pre load the input field.
	 * @param int    $p_in_min Minimum value.
	 * @param int    $max Maximum value.
	 * @param bool   $deci  true if 0.1 steps and floating to string, false if integer (default).
	 * @return string
	 *
	 * Edited:
	 * @since 2.1.4  step argument and number_format() to allow decimals  ..
	 */
	protected function add_num_box( $setting_name, $p_in_min, $max, $deci = false ) {
		// Collect data for given settings field.
		$data = $this->load_setting( $setting_name );

		if ( $deci ) {
			$value = number_format( floatval( $data['value'] ), 1 );
			return sprintf(
				'<input type="number" name="%s" id="%s" value="%s" step="0.1" min="%d" max="%d"/>',
				$data['name'],
				$data['id'],
				$value,
				$p_in_min,
				$max
			);
		} else {
			return sprintf(
				'<input type="number" name="%s" id="%s" value="%d" min="%d" max="%d"/>',
				$data['name'],
				$data['id'],
				$data['value'],
				$p_in_min,
				$max
			);
		}
	}

}
