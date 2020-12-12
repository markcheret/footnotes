<?php
/**
 * Includes Layout Engine for the admin dashboard.
 *
 * @filesource
 * @author Stefan Herndler
 * @since  1.5.0 12.09.14 10:56
 *
 * Edited:
 * 2.1.2  add versioning of settings.css for cache busting  2020-11-19T1456+0100
 * 2.1.4  automate passing version number for cache busting  2020-11-30T0648+0100
 * 2.1.4  optional step argument and support for floating in numbox  2020-12-05T0540+0100
 * 2.1.6  fix punctuation-related localization issue in dashboard labels  2020-12-08T1547+0100
 *
 * Last modified:  2020-12-10T1447+0100
 */


/**
 * Layout Engine for the administration dashboard.
 *
 * @author Stefan Herndler
 * @since  1.5.0
 */
abstract class MCI_Footnotes_LayoutEngine {

    /**
     * Stores the Hook connection string for the child sub page.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @var null|string
     */
    protected $a_str_SubPageHook = null;

    /**
     * Stores all Sections for the child sub page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @var array
     */
    protected $a_arr_Sections = array();

    /**
     * Returns a Priority index. Lower numbers have a higher Priority.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return int
     */
    abstract public function getPriority();

    /**
     * Returns the unique slug of the child sub page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     */
    abstract protected function getSubPageSlug();

    /**
     * Returns the title of the child sub page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     */
    abstract protected function getSubPageTitle();

    /**
     * Returns an array of all registered sections for a sub page.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return array
     */
    abstract protected function getSections();

    /**
     * Returns an array of all registered meta boxes.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return array
     */
    abstract protected function getMetaBoxes();

    /**
     * Returns an array describing a sub page section.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_ID Unique ID suffix.
     * @param string $p_str_Title Title of the section.
     * @param int $p_int_SettingsContainerIndex Settings Container Index.
     * @param bool $p_bool_hasSubmitButton Should a Submit Button be displayed for this section, default: true.
     * @return array Array describing the section.
     */
    protected function addSection($p_str_ID, $p_str_Title, $p_int_SettingsContainerIndex, $p_bool_hasSubmitButton = true) {
        return array("id" => MCI_Footnotes_Config::C_STR_PLUGIN_NAME . "-" . $p_str_ID, "title" => $p_str_Title, "submit" => $p_bool_hasSubmitButton, "container" => $p_int_SettingsContainerIndex);
    }

    /**
     * Returns an array describing a meta box.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_SectionID Parent Section ID.
     * @param string $p_str_ID Unique ID suffix.
     * @param string $p_str_Title Title for the meta box.
     * @param string $p_str_CallbackFunctionName Class method name for callback.
     * @return array meta box description to be able to append a meta box to the output.
     */
    protected function addMetaBox($p_str_SectionID, $p_str_ID, $p_str_Title, $p_str_CallbackFunctionName) {
        return array(
            "parent"   => MCI_Footnotes_Config::C_STR_PLUGIN_NAME . "-" . $p_str_SectionID, 
            "id"       => $p_str_ID, 
            "title"    => $p_str_Title, 
            "callback" => $p_str_CallbackFunctionName
        );
    }

    /**
     * Registers a sub page.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     */
    public function registerSubPage() {
        global $submenu;
        // any sub menu for our main menu exists
        if (array_key_exists(plugin_basename(MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG), $submenu)) {
            // iterate through all sub menu entries of the ManFisher main menu
            foreach($submenu[plugin_basename(MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG)] as $l_arr_SubMenu) {
                if ($l_arr_SubMenu[2] == plugin_basename(MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG . $this->getSubPageSlug())) {
                    // remove that sub menu and add it again to move it to the bottom
                    remove_submenu_page(MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG, MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG .$this->getSubPageSlug());
                }
            }
        }

        $this->a_str_SubPageHook = add_submenu_page(
            MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG, // parent slug
            $this->getSubPageTitle(), // page title
            $this->getSubPageTitle(), // menu title
            'manage_options', // capability
            MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG . $this->getSubPageSlug(), // menu slug
            array($this, 'displayContent') // function
        );
    }

    /**
     * Registers all sections for a sub page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function registerSections() {
        // iterate through each section
        foreach($this->getSections() as $l_arr_Section) {
            // append tab to the tab-array
            $this->a_arr_Sections[$l_arr_Section["id"]] = $l_arr_Section;
            add_settings_section(
                $l_arr_Section["id"], // unique id
                "", //$l_arr_Section["title"], // title
                array($this, 'Description'), // callback function for the description
                $l_arr_Section["id"] // parent sub page slug
            );
            $this->registerMetaBoxes($l_arr_Section["id"]);
        }
    }

    /**
     * Registers all Meta boxes for a sub page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_ParentID Parent section unique id.
     */
    private function registerMetaBoxes($p_str_ParentID) {
        // iterate through each meta box
        foreach($this->getMetaBoxes() as $l_arr_MetaBox) {
            if ($l_arr_MetaBox["parent"] != $p_str_ParentID) {
                continue;
            }
            add_meta_box(
                $p_str_ParentID. "-" . $l_arr_MetaBox["id"], // unique id
                $l_arr_MetaBox["title"], // meta box title
                array($this, $l_arr_MetaBox["callback"]), // callback function to display (echo) the content
                $p_str_ParentID, // post type = parent section id
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
    private function appendScripts() {
        // enable meta boxes layout and close functionality
        wp_enqueue_script('postbox');
        // add WordPress color picker layout
        wp_enqueue_style('wp-color-picker');
        // add WordPress color picker function
        wp_enqueue_script('wp-color-picker');


        // register stylesheet
        // added version # after changes started to settings.css from 2.1.2 on:
        // automated update of version number for cache busting
        wp_register_style( 'mci-footnotes-admin-styles', plugins_url('footnotes/css/settings.css'), array(), FOOTNOTES_VERSION );

        // add stylesheet to the output
        wp_enqueue_style('mci-footnotes-admin-styles');
    }

    /**
     * Displays the content of specific sub page.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     */
    public function displayContent() {
        // register and enqueue scripts and styling
        $this->appendScripts();
        // get current section
        reset($this->a_arr_Sections);
        $l_str_ActiveSectionID = isset($_GET['t']) ? $_GET['t'] : key($this->a_arr_Sections);
        $l_arr_ActiveSection = $this->a_arr_Sections[$l_str_ActiveSectionID];
        // store settings
        $l_bool_SettingsUpdated = false;
        if (array_key_exists("save-settings", $_POST)) {
            if ($_POST["save-settings"] == "save") {
                unset($_POST["save-settings"]);
                unset($_POST["submit"]);
                $l_bool_SettingsUpdated = $this->saveSettings();
            }
        }

        // display all sections and highlight the active section
        echo '<div class="wrap">';
        echo '<h2 class="nav-tab-wrapper">';
        // iterate through all register sections
        foreach ($this->a_arr_Sections as $l_str_ID => $l_arr_Description) {
            echo sprintf(
                '<a class="nav-tab%s" href="?page=%s&t=%s">%s</a>',
                $l_arr_ActiveSection["id"] == $l_str_ID ? ' nav-tab-active' : '',
                MCI_Footnotes_Layout_Init::C_STR_MAIN_MENU_SLUG . $this->getSubPageSlug(), $l_str_ID, $l_arr_Description["title"]
            );
        }
        echo '</h2><br/>';

        if ($l_bool_SettingsUpdated) {
            echo sprintf('<div id="message" class="updated">%s</div>', __("Settings saved", MCI_Footnotes_Config::C_STR_PLUGIN_NAME));
        }

        // form to submit the active section
        echo '<!--suppress HtmlUnknownTarget --><form method="post" action="">';
        //settings_fields($l_arr_ActiveSection["container"]);
        echo '<input type="hidden" name="save-settings" value="save" />';
        // outputs the settings field of the active section
        do_settings_sections($l_arr_ActiveSection["id"]);
        do_meta_boxes($l_arr_ActiveSection["id"], 'main', NULL);

        // add submit button to active section if defined
        if ($l_arr_ActiveSection["submit"]) {
            submit_button();
        }
        // close the form to submit data
        echo '</form>';
        // close container for the settings page
        echo '</div>';
        // output special javascript for the expand/collapse function of the meta boxes
        echo '<script type="text/javascript">';
        echo "jQuery(document).ready(function ($) {";
        echo 'jQuery(".mfmmf-color-picker").wpColorPicker();';
        echo "jQuery('.if-js-closed').removeClass('if-js-closed').addClass('closed');";
        echo "postboxes.add_postbox_toggles('" . $this->a_str_SubPageHook . "');";
        echo "});";
        echo '</script>';
    }

    /**
     * Save all Plugin settings.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return bool
     */
    private function saveSettings() {
        $l_arr_newSettings = array();
        // get current section
        reset($this->a_arr_Sections);
        $l_str_ActiveSectionID = isset($_GET['t']) ? $_GET['t'] : key($this->a_arr_Sections);
        $l_arr_ActiveSection = $this->a_arr_Sections[$l_str_ActiveSectionID];

        // iterate through each value that has to be in the specific container
        foreach(MCI_Footnotes_Settings::instance()->getDefaults($l_arr_ActiveSection["container"]) as $l_str_Key => $l_mixed_Value) {
            // setting is available in the POST array, use it
            if (array_key_exists($l_str_Key, $_POST)) {
                $l_arr_newSettings[$l_str_Key] = $_POST[$l_str_Key];
            } else {
                // setting is not defined in the POST array, define it to avoid the Default value
                $l_arr_newSettings[$l_str_Key] = "";
            }
        }
        // update settings
        return MCI_Footnotes_Settings::instance()->saveOptions($l_arr_ActiveSection["container"], $l_arr_newSettings);
    }

    /**
     * Output the Description of a section. May be overwritten in any section.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function Description() {
        // default no description will be displayed
    }

    /**
     * Loads specific setting and returns an array with the keys [id, name, value].
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_SettingKeyName Settings Array key name.
     * @return array Contains Settings ID, Settings Name and Settings Value.
     */
    protected function LoadSetting($p_str_SettingKeyName) {
        // get current section
        reset($this->a_arr_Sections);
        $p_arr_Return = array();
        $p_arr_Return["id"] = sprintf('%s', $p_str_SettingKeyName);
        $p_arr_Return["name"] = sprintf('%s', $p_str_SettingKeyName);
        $p_arr_Return["value"] = esc_attr(MCI_Footnotes_Settings::instance()->get($p_str_SettingKeyName));
        return $p_arr_Return;
    }

    /**
     * Returns a line break to start a new line.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return string
     */
    protected function addNewline() {
        return '<br/>';
    }

    /**
     * Returns a line break to have a space between two lines.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return string
     */
    protected function addLineSpace() {
        return '<br/><br/>';
    }

    /**
     * Returns a simple text inside html <span> text.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_Text Message to be surrounded with simple html tag (span).
     * @return string
     */
    protected function addText($p_str_Text) {
        return sprintf('<span>%s</span>', $p_str_Text);
    }

    /**
     * Returns the html tag for an input/select label.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_SettingName Name of the Settings key to connect the Label with the input/select field.
     * @param string $p_str_Caption Label caption.
     * @return string
     *
     * Edited 2020-12-01T0159+0100..
     * @since 2.1.6 no colon
     */
    protected function addLabel($p_str_SettingName, $p_str_Caption) {
        if (empty($p_str_Caption)) {
            return "";
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
        return sprintf('<label for="%s">%s</label>', $p_str_SettingName, $p_str_Caption);
        //                                ^ here deleted colon  2020-12-08T1546+0100
    }

    /**
     * Returns the html tag for an input [type = text].
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_SettingName Name of the Settings key to pre load the input field.
     * @param int    $p_str_MaxLength Maximum length of the input, default 999 characters.
     * @param bool   $p_bool_Readonly Set the input to be read only, default false.
     * @param bool   $p_bool_Hidden Set the input to be hidden, default false.
     * @return string
     */
    protected function addTextBox($p_str_SettingName, $p_str_MaxLength = 999, $p_bool_Readonly = false, $p_bool_Hidden = false) {
        $l_str_Style = "";
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingName);
        if ($p_bool_Hidden) {
            $l_str_Style .= 'display:none;';
        }
        return sprintf('<input type="text" name="%s" id="%s" maxlength="%d" style="%s" value="%s" %s/>',
                       $l_arr_Data["name"], $l_arr_Data["id"], $p_str_MaxLength,
                       $l_str_Style, $l_arr_Data["value"], $p_bool_Readonly ? 'readonly="readonly"' : '');
    }

    /**
     * Returns the html tag for an input [type = checkbox].
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_SettingName Name of the Settings key to pre load the input field.
     * @return string
     */
    protected function addCheckbox($p_str_SettingName) {
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingName);
        return sprintf('<input type="checkbox" name="%s" id="%s" %s/>',
                       $l_arr_Data["name"], $l_arr_Data["id"],
                       MCI_Footnotes_Convert::toBool($l_arr_Data["value"]) ? 'checked="checked"' : '');
    }

    /**
     * Returns the html tag for a select box.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_SettingName Name of the Settings key to pre select the current value.
     * @param array  $p_arr_Options Possible options to be selected.
     * @return string
     */
    protected function addSelectBox($p_str_SettingName, $p_arr_Options) {
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingName);
        $l_str_Options = "";

        /* loop through all array keys */
        foreach ($p_arr_Options as $l_str_Value => $l_str_Caption) {
            $l_str_Options .= sprintf('<option value="%s" %s>%s</option>',
                                      $l_str_Value,
                                      $l_arr_Data["value"] == $l_str_Value ? "selected" : "",
                                      $l_str_Caption);
        }
        return sprintf('<select name="%s" id="%s">%s</select>',
                       $l_arr_Data["name"], $l_arr_Data["id"], $l_str_Options);
    }

    /**
     * Returns the html tag for a text area.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_SettingName Name of the Settings key to pre fill the text area.
     * @return string
     */
    protected function addTextArea($p_str_SettingName) {
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingName);
        return sprintf('<textarea name="%s" id="%s">%s</textarea>',
            $l_arr_Data["name"], $l_arr_Data["id"], $l_arr_Data["value"]);
    }

    /**
     * Returns the html tag for an input [type = text] with color selection class.
     *
     * @author Stefan Herndler
     * @since  1.5.6
     * @param string $p_str_SettingName Name of the Settings key to pre load the input field.
     * @return string
     */
    protected function addColorSelection($p_str_SettingName) {
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingName);
        return sprintf('<input type="text" name="%s" id="%s" class="mfmmf-color-picker" value="%s"/>',
            $l_arr_Data["name"], $l_arr_Data["id"], $l_arr_Data["value"]);
    }

    /**
     * Returns the html tag for an input [type = num].
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param string $p_str_SettingName Name of the Settings key to pre load the input field.
     * @param int    $p_in_Min Minimum value.
     * @param int    $p_int_Max Maximum value.
     * @param bool   $p_bool_Deci  true if 0.1 steps and floating to string, false if integer (default)
     * @return string
     *
     * Edited:
     * @since 2.1.4  step argument and number_format() to allow decimals  2020-12-03T0631+0100..2020-12-12T1110+0100
     */
    protected function addNumBox($p_str_SettingName, $p_in_Min, $p_int_Max, $p_bool_Deci = false ) {
        // collect data for given settings field
        $l_arr_Data = $this->LoadSetting($p_str_SettingName);

        if ($p_bool_Deci) {
            $l_str_Value = number_format(floatval($l_arr_Data["value"]), 1);
            return sprintf('<input type="number" name="%s" id="%s" value="%s" step="0.1" min="%d" max="%d"/>',
            $l_arr_Data["name"], $l_arr_Data["id"], $l_str_Value, $p_in_Min, $p_int_Max);
        } else {
            return sprintf('<input type="number" name="%s" id="%s" value="%d" min="%d" max="%d"/>',
            $l_arr_Data["name"], $l_arr_Data["id"], $l_arr_Data["value"], $p_in_Min, $p_int_Max);
        }
    }

} // end of class
