<?php
/**
 * Includes Layout Engine for the admin dashboard.
 *
 * @filesource
 * @package footnotes
 * @author Stefan Herndler
 * @since  1.5.0 12.09.14 10:56
 *
 * @lastmodified 2021-02-18T2021+0100
 *
 * @since 2.1.2  add versioning of settings.css for cache busting  2020-11-19T1456+0100
 * @since 2.1.4  automate passing version number for cache busting  2020-11-30T0648+0100
 * @since 2.1.4  optional step argument and support for floating in numbox  2020-12-05T0540+0100
 * @since 2.1.6  fix punctuation-related localization issue in dashboard labels  2020-12-08T1547+0100
 *
 * @since 2.5.5  Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
 */


/**
 * Layout Engine for the administration dashboard.
 *
 * @author Stefan Herndler
 * @since  1.5.0
 */
abstract class MCI_Footnotes_Layout_Engine {

	/**
	 * Stores the Hook connection string for the child sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @var null|string
	 */
	protected $a_str_sub_page_hook = null;

	/**
	 * Stores all Sections for the child sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	protected $a_arr_sections = array();

	/**
	 * Returns a Priority index. Lower numbers have a higher Priority.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return int
	 */
	abstract public function get_priority();

	/**
	 * Returns the unique slug of the child sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function get_sub_page_slug();

	/**
	 * Returns the title of the child sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function get_sub_page_title();

	/**
	 * Returns an array of all registered sections for a sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	abstract protected function get_sections();

	/**
	 * Returns an array of all registered meta boxes.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	abstract protected function get_meta_boxes();

	/**
	 * Returns an array describing a sub page section.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_id Unique ID suffix.
	 * @param string $p_str_title Title of the section.
	 * @param int    $p_int_settings_container_index Settings Container Index.
	 * @param bool   $p_bool_has_submit_button Should a Submit Button be displayed for this section, default: true.
	 * @return array Array describing the section.
	 */
	protected function add_section( $p_str_id, $p_str_title, $p_int_settings_container_index, $p_bool_has_submit_button = true ) {
		return array(
			'id'        => MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '-' . $p_str_id,
			'title'     => $p_str_title,
			'submit'    => $p_bool_has_submit_button,
			'container' => $p_int_settings_container_index,
		);
	}

	/**
	 * Returns an array describing a meta box.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_section_id Parent Section ID.
	 * @param string $p_str_id Unique ID suffix.
	 * @param string $p_str_title Title for the meta box.
	 * @param string $p_str_callback_function_name Class method name for callback.
	 * @return array meta box description to be able to append a meta box to the output.
	 */
	protected function add_meta_box( $p_str_section_id, $p_str_id, $p_str_title, $p_str_callback_function_name ) {
		return array(
			'parent'   => MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '-' . $p_str_section_id,
			'id'       => $p_str_id,
			'title'    => $p_str_title,
			'callback' => $p_str_callback_function_name,
		);
	}

	/**
	 * Registers a sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 */
	public function register_sub_page() {
		global $submenu;
		// any sub menu for our main menu exists
		if ( array_key_exists( plugin_basename( MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG ), $submenu ) ) {
			// iterate through all sub menu entries of the ManFisher main menu
			foreach ( $submenu[ plugin_basename( MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG ) ] as $l_arr_sub_menu ) {
				if ( $l_arr_sub_menu[2] == plugin_basename( MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG . $this->get_sub_page_slug() ) ) {
					// remove that sub menu and add it again to move it to the bottom
					remove_submenu_page( MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG, MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG . $this->get_sub_page_slug() );
				}
			}
		}

		$this->a_str_sub_page_hook = add_submenu_page(
			MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG, // parent slug
			$this->get_sub_page_title(), // page title
			$this->get_sub_page_title(), // menu title
			'manage_options', // capability
			MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG . $this->get_sub_page_slug(), // menu slug
			array( $this, 'display_content' ) // function
		);
	}

	/**
	 * Registers all sections for a sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function register_sections() {
		// iterate through each section
		foreach ( $this->get_sections() as $l_arr_section ) {
			// append tab to the tab-array
			$this->a_arr_sections[ $l_arr_section['id'] ] = $l_arr_section;
			add_settings_section(
				$l_arr_section['id'], // unique id
				'', // $l_arr_section["title"], // title
				array( $this, 'Description' ), // callback function for the description
				$l_arr_section['id'] // parent sub page slug
			);
			$this->register_meta_boxes( $l_arr_section['id'] );
		}
	}

	/**
	 * Registers all Meta boxes for a sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_parent_id Parent section unique id.
	 */
	private function register_meta_boxes( $p_str_parent_id ) {
		// iterate through each meta box
		foreach ( $this->get_meta_boxes() as $l_arr_meta_box ) {
			if ( $l_arr_meta_box['parent'] != $p_str_parent_id ) {
				continue;
			}
			add_meta_box(
				$p_str_parent_id . '-' . $l_arr_meta_box['id'], // unique id
				$l_arr_meta_box['title'], // meta box title
				array( $this, $l_arr_meta_box['callback'] ), // callback function to display (echo) the content
				$p_str_parent_id, // post type = parent section id
				'main' // context
			);
		}
	}

	/**
	 * Append javascript and css files for specific sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 */
	private function append_scripts() {
		// enable meta boxes layout and close functionality
		wp_enqueue_script( 'postbox' );
		// add WordPress color picker layout
		wp_enqueue_style( 'wp-color-picker' );
		// add WordPress color picker function
		wp_enqueue_script( 'wp-color-picker' );

		/**
		 * Registers and enqueues the dashboard stylesheet.
		 *
		 * - Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
		 *
		 * @since 2.5.5
		 * @date 2021-02-14T1928+0100
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
		if ( C_BOOL_CSS_PRODUCTION_MODE === true ) {

			wp_register_style( 'mci-footnotes-admin', plugins_url( 'footnotes/css/settings.min.css' ), array(), C_STR_FOOTNOTES_VERSION );

		} else {

			wp_register_style( 'mci-footnotes-admin', plugins_url( 'footnotes/css/settings.css' ), array(), C_STR_FOOTNOTES_VERSION );

		}

		wp_enqueue_style( 'mci-footnotes-admin' );
	}

	/**
	 * Displays the content of specific sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 */
	public function display_content() {
		// register and enqueue scripts and styling
		$this->append_scripts();
		// get current section
		reset( $this->a_arr_sections );
		$l_str_active_section_id = isset( $_GET['t'] ) ? $_GET['t'] : key( $this->a_arr_sections );
		$l_arr_active_section   = $this->a_arr_sections[ $l_str_active_section_id ];
		// store settings
		$l_bool_settings_updated = false;
		if ( array_key_exists( 'save-settings', $_POST ) ) {
			if ( $_POST['save-settings'] == 'save' ) {
				unset( $_POST['save-settings'] );
				unset( $_POST['submit'] );
				$l_bool_settings_updated = $this->save_settings();
			}
		}

		// display all sections and highlight the active section
		echo '<div class="wrap">';
		echo '<h2 class="nav-tab-wrapper">';
		// iterate through all register sections
		foreach ( $this->a_arr_sections as $l_str_id => $l_arr_description ) {
			echo sprintf(
				'<a class="nav-tab%s" href="?page=%s&t=%s">%s</a>',
				$l_arr_active_section['id'] == $l_str_id ? ' nav-tab-active' : '',
				MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG . $this->get_sub_page_slug(),
				$l_str_id,
				$l_arr_description['title']
			);
		}
		echo '</h2><br/>';

		if ( $l_bool_settings_updated ) {
			echo sprintf( '<div id="message" class="updated">%s</div>', __( 'Settings saved', 'footnotes' ) );
		}

		// form to submit the active section
		echo '<!--suppress Html_unknown_target --><form method="post" action="">';
		// settings_fields($l_arr_active_section["container"]);
		echo '<input type="hidden" name="save-settings" value="save" />';
		// outputs the settings field of the active section
		do_settings_sections( $l_arr_active_section['id'] );
		do_meta_boxes( $l_arr_active_section['id'], 'main', null );

		// add submit button to active section if defined
		if ( $l_arr_active_section['submit'] ) {
			submit_button();
		}
		// close the form to submit data
		echo '</form>';
		// close container for the settings page
		echo '</div>';
		// output special javascript for the expand/collapse function of the meta boxes
		echo '<script type="text/javascript">';
		echo 'j_query(document).ready(function ($) {';
		echo 'j_query(".mfmmf-color-picker").wp_color_picker();';
		echo "j_query('.if-js-closed').remove_class('if-js-closed').add_class('closed');";
		echo "postboxes.add_postbox_toggles('" . $this->a_str_sub_page_hook . "');";
		echo '});';
		echo '</script>';
	}

	/**
	 * Save all Plugin settings.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return bool
	 */
	private function save_settings() {
		$l_arr_new_settings = array();
		// get current section
		reset( $this->a_arr_sections );
		$l_str_active_section_id = isset( $_GET['t'] ) ? $_GET['t'] : key( $this->a_arr_sections );
		$l_arr_active_section   = $this->a_arr_sections[ $l_str_active_section_id ];

		// iterate through each value that has to be in the specific container
		foreach ( MCI_Footnotes_Settings::instance()->get_defaults( $l_arr_active_section['container'] ) as $l_str_key => $l_mixed_value ) {
			// setting is available in the POST array, use it
			if ( array_key_exists( $l_str_key, $_POST ) ) {
				$l_arr_new_settings[ $l_str_key ] = $_POST[ $l_str_key ];
			} else {
				// setting is not defined in the POST array, define it to avoid the Default value
				$l_arr_new_settings[ $l_str_key ] = '';
			}
		}
		// update settings
		return MCI_Footnotes_Settings::instance()->save_options( $l_arr_active_section['container'], $l_arr_new_settings );
	}

	/**
	 * Output the Description of a section. May be overwritten in any section.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function description() {
		// default no description will be displayed
	}

	/**
	 * Loads specific setting and returns an array with the keys [id, name, value].
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_setting_key_name Settings Array key name.
	 * @return array Contains Settings ID, Settings Name and Settings Value.
	 */
	protected function load_setting( $p_str_setting_key_name ) {
		// get current section
		reset( $this->a_arr_sections );
		$p_arr_return          = array();
		$p_arr_return['id']    = sprintf( '%s', $p_str_setting_key_name );
		$p_arr_return['name']  = sprintf( '%s', $p_str_setting_key_name );
		$p_arr_return['value'] = esc_attr( MCI_Footnotes_Settings::instance()->get( $p_str_setting_key_name ) );
		return $p_arr_return;
	}

	/**
	 * Returns a line break to start a new line.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return string
	 */
	protected function add_newline() {
		return '<br/>';
	}

	/**
	 * Returns a line break to have a space between two lines.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return string
	 */
	protected function add_line_space() {
		return '<br/><br/>';
	}

	/**
	 * Returns a simple text inside html <span> text.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_text Message to be surrounded with simple html tag (span).
	 * @return string
	 */
	protected function add_text( $p_str_text ) {
		return sprintf( '<span>%s</span>', $p_str_text );
	}

	/**
	 * Returns the html tag for an input/select label.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_setting_name Name of the Settings key to connect the Label with the input/select field.
	 * @param string $p_str_caption Label caption.
	 * @return string
	 *
	 * Edited 2020-12-01T0159+0100..
	 * @since 2.1.6 no colon
	 */
	protected function add_label( $p_str_setting_name, $p_str_caption ) {
		if ( empty( $p_str_caption ) ) {
			return '';
		}
		// remove the colon causing localization issues with French,
		// and with languages not using punctuation at all,
		// and with languages using other punctuation marks instead of colon,
		// e.g. Greek using a raised dot.
		// In French, colon is preceded by a space, forcibly non-breaking,
		// and narrow per new school.
		// Add colon to label strings for inclusion in localization.
		// Colon after label is widely preferred best practice, mandatory per style guides.
		// <https://softwareengineering.stackexchange.com/questions/234546/colons-in-internationalized-ui>
		return sprintf( '<label for="%s">%s</label>', $p_str_setting_name, $p_str_caption );
		// ^ here deleted colon  2020-12-08T1546+0100
	}

	/**
	 * Returns the html tag for an input [type = text].
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_setting_name Name of the Settings key to pre load the input field.
	 * @param int    $p_str_max_length Maximum length of the input, default 999 characters.
	 * @param bool   $p_bool_readonly Set the input to be read only, default false.
	 * @param bool   $p_bool_hidden Set the input to be hidden, default false.
	 * @return string
	 */
	protected function add_text_box( $p_str_setting_name, $p_str_max_length = 999, $p_bool_readonly = false, $p_bool_hidden = false ) {
		$l_str_style = '';
		// collect data for given settings field
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
	 * Returns the html tag for an input [type = checkbox].
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_setting_name Name of the Settings key to pre load the input field.
	 * @return string
	 */
	protected function add_checkbox( $p_str_setting_name ) {
		// collect data for given settings field
		$l_arr_data = $this->load_setting( $p_str_setting_name );
		return sprintf(
			'<input type="checkbox" name="%s" id="%s" %s/>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			MCI_Footnotes_Convert::to_bool( $l_arr_data['value'] ) ? 'checked="checked"' : ''
		);
	}

	/**
	 * Returns the html tag for a select box.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_setting_name Name of the Settings key to pre select the current value.
	 * @param array  $p_arr_options Possible options to be selected.
	 * @return string
	 */
	protected function add_select_box( $p_str_setting_name, $p_arr_options ) {
		// collect data for given settings field
		$l_arr_data    = $this->load_setting( $p_str_setting_name );
		$l_str_options = '';

		/* loop through all array keys */
		foreach ( $p_arr_options as $l_str_value => $l_str_caption ) {
			$l_str_options .= sprintf(
				'<option value="%s" %s>%s</option>',
				$l_str_value,
				$l_arr_data['value'] == $l_str_value ? 'selected' : '',
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
	 * Returns the html tag for a text area.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_setting_name Name of the Settings key to pre fill the text area.
	 * @return string
	 */
	protected function add_text_area( $p_str_setting_name ) {
		// collect data for given settings field
		$l_arr_data = $this->load_setting( $p_str_setting_name );
		return sprintf(
			'<textarea name="%s" id="%s">%s</textarea>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			$l_arr_data['value']
		);
	}

	/**
	 * Returns the html tag for an input [type = text] with color selection class.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.6
	 * @param string $p_str_setting_name Name of the Settings key to pre load the input field.
	 * @return string
	 */
	protected function add_color_selection( $p_str_setting_name ) {
		// collect data for given settings field
		$l_arr_data = $this->load_setting( $p_str_setting_name );
		return sprintf(
			'<input type="text" name="%s" id="%s" class="mfmmf-color-picker" value="%s"/>',
			$l_arr_data['name'],
			$l_arr_data['id'],
			$l_arr_data['value']
		);
	}

	/**
	 * Returns the html tag for an input [type = num].
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @param string $p_str_setting_name Name of the Settings key to pre load the input field.
	 * @param int    $p_in_min Minimum value.
	 * @param int    $p_int_max Maximum value.
	 * @param bool   $p_bool_deci  true if 0.1 steps and floating to string, false if integer (default)
	 * @return string
	 *
	 * Edited:
	 * @since 2.1.4  step argument and number_format() to allow decimals  2020-12-03T0631+0100..2020-12-12T1110+0100
	 */
	protected function add_num_box( $p_str_setting_name, $p_in_min, $p_int_max, $p_bool_deci = false ) {
		// collect data for given settings field
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

} // end of class
