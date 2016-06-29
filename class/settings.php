<?php
/**
 * Includes the Settings class to handle all Plugin settings.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 10:43
 */


/**
 * The class loads all Settings from each WordPress Settings container.
 * It a Setting is not defined yet the default value will be used.
 * Each Setting will be validated and sanitized when loaded from the container.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Settings {

	/**
	 * Settings Container Key for the label of the reference container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_REFERENCE_CONTAINER_NAME = "footnote_inputfield_references_label";

	/**
	 * Settings Container Key to collapse the reference container by default.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var bool
	 */
	const C_BOOL_REFERENCE_CONTAINER_COLLAPSE = "footnote_inputfield_collapse_references";

	/**
	 * Settings Container Key for the positioning of the reference container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_REFERENCE_CONTAINER_POSITION = "footnote_inputfield_reference_container_place";

	/**
	 * Settings Container Key to combine identical footnotes.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var bool
	 */
	const C_BOOL_COMBINE_IDENTICAL_FOOTNOTES = "footnote_inputfield_combine_identical";

	/**
	 * Settings Container Key for the start of the footnotes short code.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_START = "footnote_inputfield_placeholder_start";

	/**
	 * Settings Container Key for the end of the footnotes short code.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_END = "footnote_inputfield_placeholder_end";

	/**
	 * Settings Container Key for the user defined start of the footnotes short code.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED = "footnote_inputfield_placeholder_start_user_defined";

	/**
	 * Settings Container Key for the user defined end of the footnotes short code.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED = "footnote_inputfield_placeholder_end_user_defined";

	/**
	 * Settings Container Key for the counter style of the footnotes.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_COUNTER_STYLE = "footnote_inputfield_counter_style";

	/**
	 * Settings Container Key for the 'I love footnotes' text.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_LOVE = "footnote_inputfield_love";

	/**
	 * Settings Container Key to look for footnotes in post excerpts.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_BOOL_FOOTNOTES_IN_EXCERPT = "footnote_inputfield_search_in_excerpt";

    /**
     * Settings Container Key for the Expert mode.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     * @var string
     */
    const C_BOOL_FOOTNOTES_EXPERT_MODE = "footnote_inputfield_enable_expert_mode";

	/**
	 * Settings Container Key for the styling before the footnotes index.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_STYLING_BEFORE = "footnote_inputfield_custom_styling_before";

	/**
	 * Settings Container Key for the styling after the footnotes index.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_FOOTNOTES_STYLING_AFTER = "footnote_inputfield_custom_styling_after";

	/**
	 * Settings Container Key for the mouse-over box to be enabled.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.2
	 * @var string
	 */
	const C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED = "footnote_inputfield_custom_mouse_over_box_enabled";

    /**
     * Settings Container Key for the mouse-over box to display only an excerpt.
     *
     * @author Stefan Herndler
     * @since 1.5.4
     * @var string
     */
    const C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED = "footnote_inputfield_custom_mouse_over_box_excerpt_enabled";

    /**
     * Settings Container Key for the mouse-over box to define the max. length of the enabled expert.
     *
     * @author Stefan Herndler
     * @since 1.5.4
     * @var string
     */
    const C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH = "footnote_inputfield_custom_mouse_over_box_excerpt_length";

	/**
	 * Settings Container Key for the mouse-over box to define the positioning.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.7
	 * @var string
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION = "footnote_inputfield_custom_mouse_over_box_position";

	/**
	 * Settings Container Key for the mouse-over box to define the offset (x).
	 *
	 * @author Stefan Herndler
	 * @since 1.5.7
	 * @var string
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X = "footnote_inputfield_custom_mouse_over_box_offset_x";

	/**
	 * Settings Container Key for the mouse-over box to define the offset (y).
	 *
	 * @author Stefan Herndler
	 * @since 1.5.7
	 * @var string
	 */
	const C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y = "footnote_inputfield_custom_mouse_over_box_offset_y";

    /**
     * Settings Container Key for the mouse-over box to define the color.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @var string
     */
    const C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR = "footnote_inputfield_custom_mouse_over_box_color";

    /**
     * Settings Container Key for the mouse-over box to define the background color.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @var string
     */
    const C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND = "footnote_inputfield_custom_mouse_over_box_background";

    /**
     * Settings Container Key for the mouse-over box to define the border width.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @var string
     */
    const C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH = "footnote_inputfield_custom_mouse_over_box_border_width";

    /**
     * Settings Container Key for the mouse-over box to define the border color.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @var string
     */
    const C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR = "footnote_inputfield_custom_mouse_over_box_border_color";

    /**
     * Settings Container Key for the mouse-over box to define the border radius.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @var string
     */
    const C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS = "footnote_inputfield_custom_mouse_over_box_border_radius";

    /**
     * Settings Container Key for the mouse-over box to define the max width.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @var string
     */
    const C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH = "footnote_inputfield_custom_mouse_over_box_max_width";

	/**
	 * Settings Container Key for the mouse-over box to define the box-shadow color.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.8
	 * @var string
	 */
	const C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR = "footnote_inputfield_custom_mouse_over_box_shadow_color";

	/**
	 * Settings Container Key for the Hyperlink arrow.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_HYPERLINK_ARROW = "footnote_inputfield_custom_hyperlink_symbol";

	/**
	 * Settings Container Key for the user defined Hyperlink arrow.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_HYPERLINK_ARROW_USER_DEFINED = "footnote_inputfield_custom_hyperlink_symbol_user";

	/**
	 * Settings Container Key for the user defined styling.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_CUSTOM_CSS = "footnote_inputfield_custom_css";

    /**
     * Settings Container Key the activation of the_title hook.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     * @var string
     */
    const C_BOOL_EXPERT_LOOKUP_THE_TITLE = "footnote_inputfield_expert_lookup_the_title";

    /**
     * Settings Container Key the activation of the_content hook.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     * @var string
     */
    const C_BOOL_EXPERT_LOOKUP_THE_CONTENT = "footnote_inputfield_expert_lookup_the_content";

    /**
     * Settings Container Key the activation of the_excerpt hook.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     * @var string
     */
    const C_BOOL_EXPERT_LOOKUP_THE_EXCERPT = "footnote_inputfield_expert_lookup_the_excerpt";

    /**
     * Settings Container Key the activation of widget_title hook.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     * @var string
     */
    const C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE = "footnote_inputfield_expert_lookup_widget_title";

    /**
     * Settings Container Key the activation of widget_text hook.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     * @var string
     */
    const C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT = "footnote_inputfield_expert_lookup_widget_text";

    /**
     * Settings Container Key the activation of the_post hook.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     * @var string
     */
    const C_BOOL_EXPERT_LOOKUP_THE_POST = "footnote_inputfield_expert_lookup_the_post";

	/**
	 * Stores a singleton reference of this class.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @var MCI_Footnotes_Settings
	 */
	private static $a_obj_Instance = null;

	/**
	 * Contains all Settings Container names.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	private $a_arr_Container = array("footnotes_storage", "footnotes_storage_custom", "footnotes_storage_expert");

	/**
	 * Contains all Default Settings for each Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	private $a_arr_Default = array(
		"footnotes_storage" => array(
			self::C_STR_REFERENCE_CONTAINER_NAME => 'References',
			self::C_BOOL_REFERENCE_CONTAINER_COLLAPSE => '',
			self::C_STR_REFERENCE_CONTAINER_POSITION => 'post_end',
			self::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES => 'yes',
			self::C_STR_FOOTNOTES_SHORT_CODE_START => '((',
			self::C_STR_FOOTNOTES_SHORT_CODE_END => '))',
			self::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED => '',
			self::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED => '',
			self::C_STR_FOOTNOTES_COUNTER_STYLE => 'arabic_plain',
			self::C_STR_FOOTNOTES_LOVE => 'no',
			self::C_BOOL_FOOTNOTES_IN_EXCERPT => 'yes',
            self::C_BOOL_FOOTNOTES_EXPERT_MODE => 'no'
		),
		"footnotes_storage_custom" => array(
			self::C_STR_FOOTNOTES_STYLING_BEFORE => '',
			self::C_STR_FOOTNOTES_STYLING_AFTER => ')',
			self::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED => 'yes',
            self::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED => 'no',
            self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH => 150,
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION => 'top right',
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X => 10,
			self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y => 10,
            self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR => '',
            self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND => '#fff7a7',
            self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH => 1,
            self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR => '#cccc99',
            self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS => 3,
            self::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH => 0,
			self::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR => '#666666',
			self::C_STR_HYPERLINK_ARROW => '&#8593;',
			self::C_STR_HYPERLINK_ARROW_USER_DEFINED => '',
			self::C_STR_CUSTOM_CSS => ''
		),
        "footnotes_storage_expert" => array(
            self::C_BOOL_EXPERT_LOOKUP_THE_TITLE => '',
            self::C_BOOL_EXPERT_LOOKUP_THE_CONTENT => 'yes',
            self::C_BOOL_EXPERT_LOOKUP_THE_EXCERPT => 'yes',
            self::C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE => '',
            self::C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT => 'yes',
            self::C_BOOL_EXPERT_LOOKUP_THE_POST => ''
        )
	);

	/**
	 * Contains all Settings from each Settings container as soon as this class is initialized.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	private $a_arr_Settings = array();

	/**
	 * Class Constructor. Loads all Settings from each WordPress Settings container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function __construct() {
		$this->loadAll();
	}

	/**
	 * Returns a singleton of this class.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return MCI_Footnotes_Settings
	 */
	public static function instance() {
		// no instance defined yet, load it
		if (self::$a_obj_Instance === null) {
			self::$a_obj_Instance = new self();
		}
		// return a singleton of this class
		return self::$a_obj_Instance;
	}

	/**
	 * Returns the name of a specified Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param int $p_int_Index Settings Container Array Key Index.
	 * @return string Settings Container name.
	 */
	public function getContainer($p_int_Index) {
		return $this->a_arr_Container[$p_int_Index];
	}

    /**
     * Returns the default values of a specific Settings Container.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @param int $p_int_Index Settings Container Aray Key Index.
     * @return array
     */
    public function getDefaults($p_int_Index) {
        return $this->a_arr_Default[$this->a_arr_Container[$p_int_Index]];
    }

	/**
	 * Loads all Settings from each Settings container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function loadAll() {
		// clear current settings
		$this->a_arr_Settings = array();
		for ($i = 0; $i < count($this->a_arr_Container); $i++) {
			// load settings
			$this->a_arr_Settings = array_merge($this->a_arr_Settings, $this->Load($i));
		}
	}

	/**
	 * Loads all Settings from specified Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param int $p_int_Index Settings Container Array Key Index.
	 * @return array Settings loaded from Container of Default Settings if Settings Container is empty (first usage).
	 */
	private function Load($p_int_Index) {
		// load all settings from container
		$l_arr_Options = get_option($this->getContainer($p_int_Index));
		// load all default settings
		$l_arr_Default = $this->a_arr_Default[$this->getContainer($p_int_Index)];

		// no settings found, set them to their default value
		if (empty($l_arr_Options)) {
			return $l_arr_Default;
		}
		// iterate through all available settings ( = default values)
		foreach($l_arr_Default as $l_str_Key => $l_str_Value) {
			// available setting not found in the container
			if (!array_key_exists($l_str_Key, $l_arr_Options)) {
				// define the setting with its default value
				$l_arr_Options[$l_str_Key] = $l_str_Value;
			}
		}
		// iterate through each setting in the container
		foreach($l_arr_Options as $l_str_Key => $l_str_Value) {
			// remove all whitespace at the beginning and end of a setting
			//$l_str_Value = trim($l_str_Value);
			// write the sanitized value back to the setting container
			$l_arr_Options[$l_str_Key] = $l_str_Value;
		}
		// return settings loaded from Container
		return $l_arr_Options;
	}

	/**
	 * Updates a whole Settings container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param int $p_int_Index Index of the Settings container.
	 * @param array $p_arr_newValues new Settings.
	 * @return bool
	 */
	public function saveOptions($p_int_Index, $p_arr_newValues) {
		if (update_option($this->getContainer($p_int_Index), $p_arr_newValues)) {
			$this->loadAll();
			return true;
		}
		return false;
	}

	/**
	 * Returns the value of specified Settings name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Key Settings Array Key name.
	 * @return mixed Value of the Setting on Success or Null in Settings name is invalid.
	 */
	public function get($p_str_Key) {
		return array_key_exists($p_str_Key, $this->a_arr_Settings) ? $this->a_arr_Settings[$p_str_Key] : null;
	}

	/**
	 * Deletes each Settings Container and loads the default values for each Settings Container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function ClearAll() {
		// iterate through each Settings Container
		for ($i = 0; $i < count($this->a_arr_Container); $i++) {
			// delete the settings container
			delete_option($this->getContainer($i));
		}
		// set settings back to the default values
		$this->a_arr_Settings = $this->a_arr_Default;
	}

	/**
	 * Register all Settings Container for the Plugin Settings Page in the Dashboard.
	 * Settings Container Label will be the same as the Settings Container Name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function RegisterSettings() {
		// register all settings
		for ($i = 0; $i < count($this->a_arr_Container); $i++) {
			register_setting($this->getContainer($i), $this->getContainer($i));
		}
	}
}