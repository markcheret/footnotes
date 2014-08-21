<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0.7
 * Since: 1.0
 */

// define class only once
if (!class_exists("MCI_Footnotes_Admin")) :

/**
 * Class MCI_Footnotes_Admin
 * @since 1.0
 */
class MCI_Footnotes_Admin {
    // page hook for adding a new sub menu page to the settings
    // @since 1.0
	private $a_str_Pagehook = null;

    // collection of settings values for this plugin
    // @since 1.0
	private $a_arr_Options = array();

    // collection of tabs for the settings page of this plugin
    // @since 1.0
    private $a_arr_SettingsTabs = array();

	// current active tab
	public static $a_str_ActiveTab = null;

    /**
     * @constructor
     * @since 1.0
     */
    public function __construct() {
		// include script and stylesheet functions
		require_once(dirname(__FILE__) . "/../includes/wysiwyg-editor.php");
        // load setting tabs
        add_action('admin_init', array($this, 'Register'));
		// register plugin in settings menu
        add_action('admin_menu', array($this, 'RegisterMenu'));
    }

    /**
     * register the settings field in the database for the "save" function
     * called in class constructor @ admin_init
     * @since 1.0
     */
    public function Register() {
		// register settings
        register_setting(FOOTNOTES_SETTINGS_TAB_GENERAL, FOOTNOTES_SETTINGS_CONTAINER);
		register_setting(FOOTNOTES_SETTINGS_TAB_CUSTOM, FOOTNOTES_SETTINGS_CONTAINER_CUSTOM);

		// load tab 'general'
		require_once(dirname( __FILE__ ) . "/tab_general.php");
		new MCI_Footnotes_Tab_General($this->a_arr_SettingsTabs);
		// load tab 'custom'
		require_once(dirname( __FILE__ ) . "/tab_custom.php");
		new MCI_Footnotes_Tab_Custom($this->a_arr_SettingsTabs);
		// load tab 'how to'
		require_once(dirname( __FILE__ ) . "/tab_howto.php");
		new MCI_Footnotes_Tab_HowTo($this->a_arr_SettingsTabs);
    }

    /**
     * sets the plugin's title for the admins settings menu
     * called in class constructor @ admin_menu
     * @since 1.0
     */
	public function RegisterMenu() {
        // current user needs the permission to update plugins for further access
        if (!current_user_can('update_plugins')) {
            return;
        }
        // Add a new sub menu to the standard Settings panel
        $this->a_str_Pagehook = add_options_page(
			FOOTNOTES_PLUGIN_PUBLIC_NAME,
			FOOTNOTES_PLUGIN_PUBLIC_NAME,
			'administrator',
			FOOTNOTES_SETTINGS_PAGE_ID,
			array($this, 'DisplaySettings')
		);
    }

    /**
     * Plugin Options page rendering goes here, checks
     * for active tab and replaces key with the related
     * settings key. Uses the plugin_options_tabs method
     * to render the tabs.
     * @since 1.0
     */
	public function DisplaySettings() {
		// load stylesheets and scripts
		$this->LoadScriptsAndStylesheets();

        // gets active tab, or if nothing set the "general" tab will be set to active
        self::$a_str_ActiveTab = isset($_GET['tab']) ? $_GET['tab'] : FOOTNOTES_SETTINGS_TAB_GENERAL;
        // outputs all tabs
        echo '<div class="wrap">';
		echo '<h2 class="nav-tab-wrapper">';
		// iterate through all register tabs
		foreach ($this->a_arr_SettingsTabs as $l_str_TabKey => $l_str_TabCaption) {
			$l_str_Active = self::$a_str_ActiveTab == $l_str_TabKey ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $l_str_Active . '" href="?page=' . FOOTNOTES_SETTINGS_PAGE_ID . '&tab=' . $l_str_TabKey . '">' . $l_str_TabCaption . '</a>';
		}
		echo '</h2>';

        // outputs a form with the content of the current active tab
        echo '<form method="post" action="options.php">';
        wp_nonce_field('update-options');
        settings_fields(self::$a_str_ActiveTab);
        // outputs the settings field of the current active tab
        do_settings_sections(self::$a_str_ActiveTab);
        do_meta_boxes(self::$a_str_ActiveTab, 'main', NULL);
        // adds a submit button to the current page
        if (self::$a_str_ActiveTab != FOOTNOTES_SETTINGS_TAB_HOWTO) {
            submit_button();
        }
        echo '</form>';
        echo '</div>';

        // output settings page specific javascript code
        $this->OutputJavascript();
    }

	/**
	 * register and loads css and javascript files for settings
	 * @since 1.3
	 */
	private function LoadScriptsAndStylesheets() {
		// register settings stylesheet
		wp_register_style('footnote_settings_style', plugins_url('../css/settings.css', __FILE__));
		// add settings stylesheet
		wp_enqueue_style('footnote_settings_style');

		// Needed to allow meta box layout and close functionality
		wp_enqueue_script('postbox');
	}

    /**
     * outputs page specific javascript code
     * @since 1.0.7
     */
	private function OutputJavascript() {
        ?>
        <!-- Needed to allow meta box layout and close functionality. -->
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                // close postboxes that should be closed
                $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                // postboxes setup
                postboxes.add_postbox_toggles('<?php echo $this->a_str_Pagehook; ?>');

                jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_START); ?>').on('change', function() {
                    var l_int_SelectedIndex = jQuery(this).prop("selectedIndex");
                    jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_END); ?> option:eq(' + l_int_SelectedIndex + ')').prop('selected', true);
                    footnotes_Display_UserDefined_Placeholders();
                });
                jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_END); ?>').on('change', function() {
                    var l_int_SelectedIndex = jQuery(this).prop("selectedIndex");
                    jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_START); ?> option:eq(' + l_int_SelectedIndex + ')').prop('selected', true);
                    footnotes_Display_UserDefined_Placeholders();
                });
                footnotes_Display_UserDefined_Placeholders();
            });

            function footnotes_Display_UserDefined_Placeholders() {
                if (jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_START); ?>').val() == "userdefined") {
                    jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED); ?>').show();
                    jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED); ?>').show();
                } else {
                    jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED); ?>').hide();
                    jQuery('#<?php echo $this->getFieldID(FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED); ?>').hide();
                }
            }
        </script>
    <?php
    }

    /**
     * loads specific setting and returns an array with the keys [id, name, value]
     * @since 1.0
     * @param $p_str_FieldID
     * @return array
     */
    protected function LoadSetting($p_str_FieldID) {
		// loads and filters the settings for this plugin
		if (empty($this->a_arr_Options)) {
			$this->a_arr_Options = MCI_Footnotes_getOptions(true);
		}
        $p_arr_Return = array();
        $p_arr_Return["id"] = $this->getFieldID($p_str_FieldID);
        $p_arr_Return["name"] = $this->getFieldName($p_str_FieldID);
        $p_arr_Return["value"] = esc_attr($this->getFieldValue($p_str_FieldID));
        return $p_arr_Return;
    }

    /**
     * access settings field by name
     * @since 1.0
     * @param string $p_str_FieldName
     * @return string
     */
    protected function getFieldName($p_str_FieldName) {
		// general setting
		if (MCI_Footnotes_Admin::$a_str_ActiveTab == FOOTNOTES_SETTINGS_TAB_GENERAL) {
			return sprintf('%s[%s]', FOOTNOTES_SETTINGS_CONTAINER, $p_str_FieldName);
		// custom setting
		} else if (MCI_Footnotes_Admin::$a_str_ActiveTab == FOOTNOTES_SETTINGS_TAB_CUSTOM) {
			return sprintf('%s[%s]', FOOTNOTES_SETTINGS_CONTAINER_CUSTOM, $p_str_FieldName);
		}
		// undefined
		return sprintf('%s[%s]', FOOTNOTES_SETTINGS_CONTAINER, $p_str_FieldName);
    }

    /**
     * access settings field by id
     * @since 1.0
     * @param string $p_str_FieldID
     * @return string
     */
    protected function getFieldID($p_str_FieldID) {
        return sprintf( '%s', $p_str_FieldID );
    }

    /**
     * get settings field value
     * @since 1.0
     * @param string $p_str_Key
     * @return string
     */
    protected function getFieldValue($p_str_Key) {
        return $this->a_arr_Options[$p_str_Key];
    }

    /**
     * outputs a break to have a new line
     * @since 1.0.7
     */
    public function AddNewline() {
        echo '<br/><br/>';
    }

	/**
	 * outputs a simple text
	 * @param string $p_str_Text
	 * @since 1.1.1
	 */
	public function AddText($p_str_Text) {
		echo '<span>' . $p_str_Text . '</span>';
	}

	/**
	 * outputs a simple text with some highlight
	 * @param string $p_str_Text+
	 * @return string
	 * @since 1.1.1
	 */
	public function Highlight($p_str_Text) {
		return '<b>' . $p_str_Text . '</b>';
	}

    /**
     * outputs a label for a specific input/select box
     * @param string $p_str_SettingsID
     * @param string $p_str_Caption
     * @param string $p_str_Styling
     * @since 1.0.7
     */
	public function AddLabel($p_str_SettingsID, $p_str_Caption, $p_str_Styling = "") {
        // add styling tag if styling is set
        if (!empty($p_str_Styling)) {
            $p_str_Styling = ' style="' . $p_str_Styling . '"';
        }
        echo '<label for="' . $p_str_SettingsID . '"' . $p_str_Styling . '>' . $p_str_Caption . '</label>';
    }

    /**
     * outputs a input type=text
     * @param string $p_str_SettingsID [id of the settings field]
     * @param string $p_str_ClassName [css class name]
     * @param int $p_str_MaxLength [max length for the input value]
	 * @param bool $p_bool_Readonly [input is readonly] in version 1.1.1
     * @param bool $p_bool_Hidden [input is hidden by default] in version 1.1.2
     * @since 1.0-beta
     * removed optional parameter for a label in version 1.0.7
     */
	public function AddTextbox($p_str_SettingsID, $p_str_ClassName = "", $p_str_MaxLength = 0, $p_bool_Readonly = false, $p_bool_Hidden = false) {
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingsID);

        // if input shall have a css class, add the style tag for it
        if (!empty($p_str_ClassName)) {
            $p_str_ClassName = 'class="' . $p_str_ClassName . '"';
        }
        // optional add a max length to the input field
        if (!empty($p_str_MaxLength)) {
            $p_str_MaxLength = ' maxlength="' . $p_str_MaxLength . '"';
        }

		if ($p_bool_Readonly) {
			$p_bool_Readonly = ' readonly="readonly"';
		}
        if ($p_bool_Hidden) {
            $p_bool_Hidden = ' style="display:none;"';
        }
        // outputs an input field type TEXT
        echo '<input type="text" ' . $p_str_ClassName . $p_str_MaxLength . $p_bool_Readonly . $p_bool_Hidden . ' name="' . $l_arr_Data["name"] . '" id="' . $l_arr_Data["id"] . '" value="' . $l_arr_Data["value"] . '"/>';
    }

    /**
     * outputs a input type=checkbox
     * @param string $p_str_SettingsID [id of the settings field]
     * @param string $p_str_ClassName [optional css class name]
     * @since 1.0-beta
     */
	public function AddCheckbox($p_str_SettingsID, $p_str_ClassName = "") {
		require_once(dirname(__FILE__) . "/convert.php");
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingsID);

        // if input shall have a css class, add the style tag for it
        if (!empty($p_str_ClassName)) {
            $p_str_ClassName = 'class="' . $p_str_ClassName . '"';
        }

        // lookup if the checkbox shall be pre-checked
        $l_str_Checked = "";
        if (MCI_Footnotes_Convert::toBool($l_arr_Data["value"])) {
            $l_str_Checked = 'checked="checked"';
        }

        // outputs an input field type CHECKBOX
        echo sprintf('<input type="checkbox" ' . $p_str_ClassName . ' name="' . $l_arr_Data["name"] . '" id="' . $l_arr_Data["id"] . '" %s/>', $l_str_Checked);
    }

    /**
     * outputs a select box
     * @param string $p_str_SettingsID [id of the settings field]
     * @param array $p_arr_Options [array with options]
     * @param string $p_str_ClassName [optional css class name]
     * @since 1.0-beta
     */
	public function AddSelect($p_str_SettingsID, $p_arr_Options, $p_str_ClassName = "") {
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingsID);

        // if input shall have a css class, add the style tag for it
        if (!empty($p_str_ClassName)) {
            $p_str_ClassName = 'class="' . $p_str_ClassName . '"';
        }

        // select starting tag
        $l_str_Output = '<select ' . $p_str_ClassName . ' name="' . $l_arr_Data["name"] . '" id="' . $l_arr_Data["id"] . '">';
        // loop through all array keys
        foreach ($p_arr_Options as $l_str_Value => $l_str_Caption) {
			if (!is_string($l_str_Value)) {
				$l_str_Value = (string)$l_str_Value;
			}
            // add key as option value
            $l_str_Output .= '<option value="' . $l_str_Value . '"';
            // check if option value is set and has to be pre-selected
            if ($l_arr_Data["value"] == $l_str_Value) {
                $l_str_Output .= ' selected';
            }
            // write option caption and close option tag
            $l_str_Output .= '>' . $l_str_Caption . '</option>';
        }
        // close select
        $l_str_Output .= '</select>';
        // outputs the SELECT field
        echo $l_str_Output;
    }

	/**
	 * outputs a textarea
	 * @param string $p_str_SettingsID [id of the settings field]
	 * @param int $p_int_Rows [amount of rows]
	 * @param string $p_str_ClassName [css class name]
	 * @since 1.3
	 */
	public function AddTextarea($p_str_SettingsID, $p_int_Rows, $p_str_ClassName = "") {
		// collect data for given settings field
		$l_arr_Data = $this->LoadSetting($p_str_SettingsID);

		// if input shall have a css class, add the style tag for it
		if (!empty($p_str_ClassName)) {
			$p_str_ClassName = 'class="' . $p_str_ClassName . '"';
		}
		// outputs an input field type TEXT
		echo '<textarea ' . $p_str_ClassName . ' name="' . $l_arr_Data["name"] . '" id="' . $l_arr_Data["id"] . '" rows="'.$p_int_Rows.'">' . $l_arr_Data["value"] . '</textarea>';
	}

}// class MCI_Footnotes_Admin

endif;