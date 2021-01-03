<?php
/**
 * Includes the Plugin Class to display all Settings.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 14:47
 *
 * Last modified: 2021-01-02T2335+0100
 *
 * Edited:
 * @since 2.0.4  restore arrow settings  2020-11-01T0509+0100
 * @since 2.1.0  read-on button label  2020-11-08T2148+0100
 * @since 2.1.1  options for ref container and alternative tooltips  2020-11-16T2152+0100
 * @since 2.1.2  priority level settings for all other hooks, thanks to @nikelaos
 * @see <https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13676705>
 * @since 2.1.4  settings for ref container, tooltips and scrolling  2020-12-03T0950+0100
 * @since 2.1.6  slight UI reordering   2020-12-09T1114+0100
 * @since 2.1.6  option to disable URL line wrapping   2020-12-09T1604+0100
 * @since 2.1.6  remove expert mode setting as outdated   2020-12-09T2105+0100
 * @since 2.2.0  start/end short codes: more predefined options, thanks to @nikelaos
 * @see <https://wordpress.org/support/topic/doesnt-work-with-mailpoet/>
 * @since 2.2.0  add options, redistribute, update strings   2020-12-12T2135+0100
 * @since 2.2.0  shortcode for reference container custom position   2020-12-13T2055+0100
 * @since 2.2.2  Custom CSS settings container migration  2020-12-15T0709+0100
 * @since 2.2.4  move backlink symbol selection under previous tab  2020-12-16T1244+0100
 * @since 2.2.5  support for Ibid. notation thanks to @meglio   2020-12-17T2021+0100
 * @see <https://wordpress.org/support/topic/add-support-for-ibid-notation/>
 * @since 2.2.5  options for label element and label bottom border, thanks to @markhillyer   2020-12-18T1447+0100
 * @see <https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/>
 * @since 2.2.10 reference container row border option, thanks to @noobishh   2020-12-25T2316+0100
 * @see <https://wordpress.org/support/topic/borders-25/>
 * @since 2.3.0  Reference container: convert top padding to margin and make it a setting, thanks to @hamshe
 * @see <https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635>
 * @since 2.3.0  rename Priority level tab as Scope and priority   2020-12-26T2222+0100
 * @since 2.3.0  swap Custom CSS migration Boolean from 'migration complete' to 'show legacy'  2020-12-27T1243+0100
 * @since 2.3.0  mention op. cit. abbreviation   2020-12-28T2342+0100
 * @since 2.3.0  add settings for hard links, thanks to @psykonevro and @martinneumannat  2020-12-29T1322+0100
 * @see <https://wordpress.org/support/topic/making-it-amp-compatible/>
 * @see <https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/>
 * @since 2.4.0  footnote shortcode syntax validation  2021-01-01T0624+0100
 */

/**
 * Displays and handles all Settings of the Plugin.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Layout_Settings extends MCI_Footnotes_LayoutEngine {

    /**
     * Returns a Priority index. Lower numbers have a higher Priority.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return int
     */
    public function getPriority() {
        return 10;
    }

    /**
     * Returns the unique slug of the sub page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     */
    protected function getSubPageSlug() {
        return "-" . MCI_Footnotes_Config::C_STR_PLUGIN_NAME;
    }

    /**
     * Returns the title of the sub page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     */
    protected function getSubPageTitle() {
        return MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME;
    }

    /**
     * Returns an array of all registered sections for the sub page.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return array
     *
     * Edited:
     * @since 2.1.6  tabs reordered and renamed
     * @see customization vs configuration
     * <https://www.linkedin.com/pulse/20140610191154-4746170-configuration-vs-customization-when-and-why-would-i-implement-each>
     *
     * @since 2.1.6  removed if statement around expert tab
     */
    protected function getSections() {
        $l_arr_Tabs = array();
        $l_arr_Tabs[] = $this->addSection("settings", __("General settings", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 0, true);
        // tab name used in public function CustomCSSMigration()
        $l_arr_Tabs[] = $this->addSection("customize", __("Referrers and tooltips", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 1, true);
        $l_arr_Tabs[] = $this->addSection("expert", __("Scope and priority", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 2, true);
        $l_arr_Tabs[] = $this->addSection("customcss", __("Custom CSS", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 3, true);
        $l_arr_Tabs[] = $this->addSection("how-to", __("Quick start guide", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), null, false);
        return $l_arr_Tabs;
    }

    /**
     * Returns an array of all registered meta boxes for each section of the sub page.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return array
     *
     * Edited for 2.0.0 and later.
     *
     * HyperlinkArrow meta box:
     * @since 2.0.0 discontinued
     * @since 2.0.4 restored to meet user demand for arrow symbol semantics
     * @since 2.1.4 discontinued, content moved to Settings > Reference container > Display a backlink symbol
     *
     * @since 2.0.4 to reflect changes in meta box label display since WPv5.5
     * spans need position:fixed and become unlocalizable
     * fix: logo is kept only in the label that doesn’t need to be translated:
     * Change string "%s styling" to "Footnotes styling" to fix layout in WPv5.5
     * @see details in class/config.php
     *
     * @since 2.1.6 / 2.2.0 tabs reordered and renamed
     */
    protected function getMetaBoxes() {
        $l_arr_MetaBoxes = array();

        $l_arr_MetaBoxes[] = $this->addMetaBox("settings", "start-end", __("Footnote start and end short codes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "StartEnd");
        $l_arr_MetaBoxes[] = $this->addMetaBox("settings", "numbering", __("Footnotes numbering", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Numbering");
        $l_arr_MetaBoxes[] = $this->addMetaBox("settings", "scrolling", __("Scrolling behavior", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Scrolling");
        $l_arr_MetaBoxes[] = $this->addMetaBox("settings", "reference-container", __("Reference container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "ReferenceContainer");
        $l_arr_MetaBoxes[] = $this->addMetaBox("settings", "excerpts", __("Footnotes in excerpts", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Excerpts");
        $l_arr_MetaBoxes[] = $this->addMetaBox("settings", "love", MCI_Footnotes_Config::C_STR_PLUGIN_HEADING_NAME . '&nbsp;' . MCI_Footnotes_Config::C_STR_LOVE_SYMBOL_HEADING, "Love");

        $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "hyperlink-arrow", __("Backlink symbol", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "HyperlinkArrow");
        $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "superscript", __("Referrer typesetting and formatting", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Superscript");
        $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "mouse-over-box", __("Tooltips", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "MouseOverBox");

        $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "mouse-over-box-position", __("Tooltip position", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "MouseOverBoxPosition");
        $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "mouse-over-box-timing", __("Tooltip timing", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "MouseOverBoxTiming");
        $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "mouse-over-box-truncation", __("Tooltip truncation", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "MouseOverBoxTruncation");
        $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "mouse-over-box-appearance", __("Tooltip appearance", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "MouseOverBoxAppearance");
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_CUSTOM_CSS_LEGACY_ENABLE))) {
            $l_arr_MetaBoxes[] = $this->addMetaBox("customize", "custom-css", __("Your existing Custom CSS code", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "CustomCSS");
        }

        $l_arr_MetaBoxes[] = $this->addMetaBox("expert", "lookup", __("WordPress hooks with priority level", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "LookupHooks");

        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_CUSTOM_CSS_LEGACY_ENABLE))) {
            $l_arr_MetaBoxes[] = $this->addMetaBox("customcss", "custom-css-migration", __("Your existing Custom CSS code", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "CustomCSSMigration");
        }
        $l_arr_MetaBoxes[] = $this->addMetaBox("customcss", "custom-css-new", __("Custom CSS", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "CustomCSSNew");

        $l_arr_MetaBoxes[] = $this->addMetaBox("how-to", "help", __("Brief introduction in how to use the plugin", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Help");
        $l_arr_MetaBoxes[] = $this->addMetaBox("how-to", "donate", __("Help us to improve our Plugin", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Donate");

        return $l_arr_MetaBoxes;
    }

    /**
     * Displays all settings for the reference container.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Completed:
     * @since 2.1.4: layout and typography options   2020-11-30T0548+0100
     * @since 2.2.5  options for label element and label bottom border, thanks to @markhillyer   2020-12-18T1447+0100
     * @see <https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/>
     */
    public function ReferenceContainer() {

        // options for the label element:
        $l_arr_LabelElement = array(
            "p"  => __("paragraph", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "h2" => __("heading 2", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "h3" => __("heading 3", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "h4" => __("heading 4", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "h5" => __("heading 5", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "h6" => __("heading 6", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );
        // options for the positioning of the reference container
        $l_arr_Positions = array(
            "post_end" => __("at the end of the post", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "widget" => __("in the widget area", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "footer" => __("in the footer", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );
        // basic responsive page layout options:
        $l_arr_PageLayoutOptions = array(
            "none" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "reference-container" => __("to the reference container exclusively", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "entry-content" => __("to the div element starting below the post title", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "main-content" => __("to the main element including the post title", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );
        // options for the separating punctuation between backlinks:
            $l_arr_Separators = array(
            // Unicode character names are conventionally uppercase.
            "comma" => __("COMMA", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "semicolon" => __("SEMICOLON", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "en_dash" => __("EN DASH", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the terminating punctuation after backlinks:
        // The Unicode name of RIGHT PARENTHESIS was originally more accurate because
        // this character is bidi-mirrored. Let’s use the Unicode 1.0 name.
        // The wrong names were enforced in spite of Unicode, that subsequently scrambled to correct.
        $l_arr_Terminators = array(
            "period" => __("FULL STOP", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            // Unicode 1.0 name of RIGHT PARENTHESIS (represented as a left parenthesis in right-to-left scripts):
            "parenthesis" => __("CLOSING PARENTHESIS", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "colon" => __("COLON", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the first column width (per cent is a ratio, not a unit):
        $l_arr_WidthUnits = array(
            "%" => __("per cent", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "px" => __("pixels", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "rem" => __("root em", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "em" => __("em", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "vw" => __("viewport width", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-reference-container");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-name" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME, __("Heading:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "name" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME),

                "label-element" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT, __("Heading’s HTML element:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "element" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT, $l_arr_LabelElement),

                "label-border" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER, __("Border under the heading:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "border" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER, $l_arr_Enabled),

                "label-collapse" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE, __("Collapse by default:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "collapse" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE, $l_arr_Enabled),

                "label-position" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, __("Default position:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "position" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, $l_arr_Positions),
                "notice-position" => sprintf(__("To use the position shortcode, please set the position to: %s", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), '<span style="font-style: normal;">' . __("at the end of the post", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . '</span>'),

                "label-shortcode" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE, __("Position shortcode:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "shortcode" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE),
                "notice-shortcode" => __("If present in the content, any shortcode in this text box will be replaced with the reference container.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-startpage" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE, __("Display on start page too:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "startpage" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE, $l_arr_Enabled),

                "label-margin-top" => $this->addLabel(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN, __("Top margin:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "margin-top" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN, -500, 500),
                "notice-margin-top" => __("pixels; may be negative", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-margin-bottom" => $this->addLabel(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN, __("Bottom margin:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "margin-bottom" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN, -500, 500),
                "notice-margin-bottom" => __("pixels; may be negative", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-page-layout" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT, __("Apply basic responsive page layout:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "page-layout" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT, $l_arr_PageLayoutOptions),
                "notice-page-layout" => __("Most themes don’t need this fix.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-url-wrap" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_URL_WRAP_ENABLED, __("Allow URLs to line-wrap anywhere:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "url-wrap" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_URL_WRAP_ENABLED, $l_arr_Enabled),
                "notice-url-wrap" => __("Unicode-conformant browsers don’t need this fix.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-symbol" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE, __("Display a backlink symbol:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "symbol-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE, $l_arr_Enabled),
                "notice-symbol" => __("Please choose or input the symbol at the top of the next dashboard tab.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-switch" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH, __("Symbol appended, not prepended:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "switch" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH, $l_arr_Enabled),

                "label-3column" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE, __("Backlink symbol in an extra column:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "3column" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE, $l_arr_Enabled),
                "notice-3column" => __("This legacy layout is available if identical footnotes are not combined.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-row-borders" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE, __("Borders around the table rows:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "row-borders" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE, $l_arr_Enabled),

                "label-separator" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_SEPARATOR_ENABLED, __("Add a separator when enumerating backlinks:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "separator-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_SEPARATOR_ENABLED, $l_arr_Enabled),
                "separator-options" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_OPTION, $l_arr_Separators),
                "separator-custom" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_CUSTOM),
                "notice-separator" => __("Your input overrides the selection.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-terminator" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_TERMINATOR_ENABLED, __("Add a terminal punctuation to backlinks:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "terminator-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_TERMINATOR_ENABLED, $l_arr_Enabled),
                "terminator-options" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_OPTION, $l_arr_Terminators),
                "terminator-custom" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_CUSTOM),
                "notice-terminator" => __("Your input overrides the selection.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-width" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED, __("Set backlinks column width:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "width-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED, $l_arr_Enabled),
                "width-scalar" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR, 0, 500, true),
                "width-unit" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT, $l_arr_WidthUnits),
                "notice-width" => __("Absolute width in pixels doesn’t need to be accurate to the tenth, but relative width in rem or em may.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-max-width" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED, __("Set backlinks column maximum width:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "max-width-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED, $l_arr_Enabled),
                "max-width-scalar" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR, 0, 500, true),
                "max-width-unit" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT, $l_arr_WidthUnits),
                "notice-max-width" => __("Absolute width in pixels doesn’t need to be accurate to the tenth, but relative width in rem or em may.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-line-break" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED, __("Stack backlinks when enumerating:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "line-break" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED, $l_arr_Enabled),
                "notice-line-break" => __("This option adds a line break before each added backlink when identical footnotes are combined.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-link" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_LINK_ELEMENT_ENABLED, __("Use the link element for referrers and backlinks:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "link" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_LINK_ELEMENT_ENABLED, $l_arr_Enabled),
                "notice-link" => __("The link element is needed to apply the theme’s link color.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "description-link" => __("If the link element is not desired for styling, a simple span is used instead when the above is set to No. The link addresses have been removed. Else footnote clicks are logged in the browsing history and make the back button unusable.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all options for the footnotes start and end tag short codes
     * Displays all options for the footnotes numbering
     * Displays all options for the scrolling behavior
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited heading  2020-12-12T1412+0100
     * @since 2.2.0  start/end short codes: more predefined options  2020-12-12T1412+0100
     * @see <https://wordpress.org/support/topic/doesnt-work-with-mailpoet/>
     * @since 2.2.0  3 boxes for clarity  2020-12-12T1422+0100
     * @since 2.2.5  support for Ibid. notation thanks to @meglio   2020-12-17T2019+0100
     * @see <https://wordpress.org/support/topic/add-support-for-ibid-notation/>
	 * @since 2.4.0  added warning about Block Editor escapement disruption  2021-01-02T2324+0100
	 * @since 2.4.0  removed the HTML comment tag option  2021-01-02T2325+0100
     */
    public function StartEnd() {
        // footnotes start tag short code options:
        $l_arr_ShortCodeStart = array(
            "((" => "((",
            "(((" => "(((",
            "{{" => "{{",
            "{{{" => "{{{",
            "[n]" => "[n]",
            "[fn]" => "[fn]",
            htmlspecialchars("<fn>") => htmlspecialchars("<fn>"),
            "[ref]" => "[ref]",
            htmlspecialchars("<ref>") => htmlspecialchars("<ref>"),
            // Custom (user-defined) start and end tags bracketing the footnote text inline:
            "userdefined" => __('custom short code', MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // footnotes end tag short code options:
        $l_arr_ShortCodeEnd = array(
            "))" => "))",
            ")))" => ")))",
            "}}" => "}}",
            "}}}" => "}}}",
            "[/n]" => "[/n]",
            "[/fn]" => "[/fn]",
            htmlspecialchars("</fn>") => htmlspecialchars("</fn>"),
            "[/ref]" => "[/ref]",
            htmlspecialchars("</ref>") => htmlspecialchars("</ref>"),
            // Custom (user-defined) start and end tags bracketing the footnote text inline:
            "userdefined" => __("custom short code", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the syntax validation:
        $l_arr_Enable = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-start-end");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "description" => __("WARNING: Short codes with closing pointy brackets are disabled in the new WordPress Block Editor that disrupts the traditional balanced escapement applied by WordPress Classic Editor.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-short-code-start" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, __("Footnote start tag short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "short-code-start" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, $l_arr_ShortCodeStart),
                "short-code-start-user" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED),

                "label-short-code-end" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, __("Footnote end tag short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "short-code-end" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, $l_arr_ShortCodeEnd),
                "short-code-end-user" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED),

                // for script showing/hiding user defined text boxes:
                "short-code-start-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START,
                "short-code-end-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END,
                "short-code-start-user-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED,
                "short-code-end-user-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED,

                // option to enable syntax validation:
                "label-syntax" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE, __("Check for balanced shortcodes:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "syntax" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE, $l_arr_Enable),
                "notice-syntax" => __("In the presence of a lone start tag shortcode, a warning displays below the post title.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function Numbering() {
        // define some space for the output
        $l_str_Space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        // options for the combination of identical footnotes
        $l_arr_Enable = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the numbering style of the footnotes:
        $l_arr_CounterStyle = array(
            "arabic_plain"   => __("plain Arabic numbers", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "1, 2, 3, 4, 5, …",
            "arabic_leading" => __("zero-padded Arabic numbers", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "01, 02, 03, 04, 05, …",
            "latin_low"      => __("lowercase Latin letters", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "a, b, c, d, e, …",
            "latin_high"     => __("uppercase Latin letters", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "A, B, C, D, E, …",
            "romanic"        => __("uppercase Roman numerals", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "I, II, III, IV, V, …",
            "roman_low"      => __("lowercase Roman numerals", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "i, ii, iii, iv, v, …",
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-numbering");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-counter-style" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, __("Numbering style:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "counter-style" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, $l_arr_CounterStyle),

                // algorithmically combine identicals:
                "label-identical" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES, __("Combine identical footnotes:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "identical" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES, $l_arr_Enable),
                "notice-identical" => __("This option may require copy-pasting footnotes in multiple instances.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                // Support for Ibid. notation added thanks to @meglio in <https://wordpress.org/support/topic/add-support-for-ibid-notation/>.
                "description-identical" => __("Even when footnotes are combined, footnote numbers keep incrementing. This avoids suboptimal referrer and backlink disambiguation using a secondary numbering system. The Ibid. notation and the op. cit. abbreviation followed by the current page number avoid repeating the footnote content. For changing sources, shortened citations may be used. Repeating full citations is also an opportunity to add details.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function Scrolling() {

        // options for enabling hard links for AMP compat:
        $l_arr_Enable = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-scrolling");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "label-scroll-offset" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET, __("Scroll offset:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "scroll-offset" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET, 0, 100),
                "notice-scroll-offset" => __("per cent from the upper edge of the window", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-scroll-duration" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION, __("Scroll duration:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "scroll-duration" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION, 0, 20000),
                "notice-scroll-duration" => __("milliseconds; instantly if hard links are enabled and JavaScript is disabled", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                // enable hard links for AMP compat:
                "label-hard-links" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_HARD_LINKS_ENABLE, __("Enable hard links:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "hard-links" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_HARD_LINKS_ENABLE, $l_arr_Enable),
                "notice-hard-links" => __("Hard links are indispensable for AMP compatibility and allow to link to footnotes.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-footnote" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG, __("Fragment identifier slug for footnotes:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "footnote" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG),
                "notice-footnote" => __("This will show up in the address bar after clicking on a hard-linked footnote referrer.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-referrer" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG, __("Fragment identifier slug for footnote referrers:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "referrer" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG),
                "notice-referrer" => __("This will show up in the address bar after clicking on a hard-linked backlink.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-separator" => $this->addLabel(MCI_Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR, __("ID separator:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "separator" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR),
                "notice-separator" => __("May be empty or any string, for example _, - or +, to distinguish post number, container number and footnote number.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all settings for 'I love Footnotes'.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited:
     * @since 2.2.0  position-sensitive placeholders to support more locales   2020-12-11T0432+0100
     * @since 2.2.0  more options   2020-12-11T0432+0100
     */
    public function Love() {
        // options for the acknowledgment display in the footer:
        $l_arr_Love = array(
            // logo only:
            "text-3" => sprintf('%s', MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            // logo followed by heart symbol:
            "text-4" => sprintf('%s %s', MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL),
            // logo preceded by heart symbol:
            "text-5" => sprintf('%s %s', MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            // "I love Footnotes": placeholder %1$s is the 'footnotes' logogram, placeholder %2$s is a heart symbol.
            "text-1" => sprintf(__('I %2$s %1$s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL),
            // "This website uses Footnotes."
            "text-6" => sprintf(__('This website uses %s.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            // "This website uses the Footnotes plugin."
            "text-7" => sprintf(__('This website uses the %s plugin.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            // "This website uses the awesome Footnotes plugin."
            "text-2" => sprintf(__('This website uses the awesome %s plugin.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            "random" => __('randomly determined display of either mention', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            // "No display of any “Footnotes love” mention in the footer"
            "no" => sprintf(__('no display of any “%1$s %2$s” mention in the footer', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-love");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-love" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, sprintf(__("Tell the world you’re using %s:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME)),
                "love" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, $l_arr_Love),

                "label-no-love" => $this->addText(sprintf(__("Shortcode to inhibit the display of the %s mention on specific pages:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME)),
                "no-love" => $this->addText(MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG)
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays the excerpt setting
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited heading   2020-12-12T1453+0100
     * @since 2.1.1   more settings and notices, thanks to @nikelaos
     * @see <https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13687068>
     * @since 2.2.0   dedicated to the excerpt setting and its notices   2020-12-12T1454+0100
     */
    public function Excerpts() {
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-excerpts");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-excerpts" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT, __("Display footnotes in excerpts:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "excerpts" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT, $l_arr_Enabled),
                "notice-excerpts" => __("The recommended value is No.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                // In some themes, the Advanced Excerpt plugin is indispensable to display footnotes in excerpts.
                "description-excerpts" => sprintf(__("In some themes, the %s plugin is indispensable to display footnotes in excerpts. Footnotes cannot be disabled in excerpts. A workaround is to avoid footnotes in the first 55&nbsp;words.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), '<a href="https://wordpress.org/plugins/advanced-excerpt/" target="_blank">Advanced Excerpt</a>'),
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all settings for the footnote referrers
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited heading   2020-12-12T1513+0100
     * @since 2.1.1  option for superscript (optionally baseline referrers)
     * @since 2.2.0  option for link element moved here   2020-12-12T1514+0100
     */
    public function Superscript() {
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-superscript");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-superscript" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS, __("Display footnote referrers in superscript:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "superscript" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS, $l_arr_Enabled),

                "label-before" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE, __("At the start of the footnote referrers:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "before" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE),

                "label-after" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER, __("At the end of the footnote referrers:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "after" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER),

                "label-link" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_LINK_ELEMENT_ENABLED, __("Use the link element for referrers and backlinks:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "notice-link" => __("Please find this setting at the end of the reference container settings. The link element is needed to apply the theme’s link color.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all settings for the footnotes mouse-over box.
     *
     * @author Stefan Herndler
     * @since 1.5.2
     *
     * Edited:
     * @since 2.2.0   5 parts to address increased settings number
     * @since 2.2.5   added position settings for the alternative tooltips
     */
    public function MouseOverBox() {
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "mouse-over-box-display");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "label-enable" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED, __("Display tooltips:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED, $l_arr_Enabled),
                "notice-enable" => __("Formatted text boxes allowing hyperlinks, displayed on mouse-over or on tap and hold.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-alternative" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE, __("Display alternative tooltips:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "alternative" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE, $l_arr_Enabled),
                "notice-alternative" => __("Intended to work around a configuration-related tooltip outage.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                // The placeholder is the name of the plugin as logogram “footnotes”.
                "description-alternative" => sprintf(__("Some themes inhibit jQuery tooltips. Some may disable CSS transitions as well. Alternative tooltips are triggered by inline JavaScript and animated with CSS transitions. If this option is enabled, %s does not load any external scripts.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), '<span style="font-style: normal;">' . MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME . '</span>'),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function MouseOverBoxPosition() {

        // options for the Mouse-over box position
        $l_arr_Position = array(
            "top left"      => __("top left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "top center"    => __("top center", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "top right"     => __("top right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "center right"  => __("center right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom right"  => __("bottom right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom center" => __("bottom center", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom left"   => __("bottom left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "center left"   => __("center left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );
        // options for the alternative Mouse-over box position
        $l_arr_AlternativePosition = array(
            "top left"      => __("top left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "top right"     => __("top right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom right"  => __("bottom right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom left"   => __("bottom left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "mouse-over-box-position");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "label-position" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION, __("Position:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "position" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION, $l_arr_Position),
                "position-alternative" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION, $l_arr_AlternativePosition),
                "notice-position" => __("The second column of settings boxes is for the alternative tooltips.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-offset-x" => $this->addLabel (MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X, __("Horizontal offset:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "offset-x" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X, -500, 500),
                "offset-x-alternative" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X, -500, 500),
                "notice-offset-x" => __("pixels; negative value for a leftwards offset; alternative tooltips: direction depends on position", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-offset-y" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y, __("Vertical offset:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "offset-y" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y, -500, 500),
                "offset-y-alternative" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y, -500, 500),
                "notice-offset-y" => __("pixels; negative value for an upwards offset; alternative tooltips: direction depends on position", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-max-width" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH, __("Maximum width:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "max-width" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH, 0, 1280),
                "width" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH, 0, 1280),
                "notice-max-width" => __("pixels; set to 0 for jQuery tooltips without max width; alternative tooltips are given the value in the second box as fixed width.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function MouseOverBoxTiming() {

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "mouse-over-box-timing");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "label-fade-in-delay" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY, __("Fade-in delay:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-in-delay" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY, 0, 20000),
                "notice-fade-in-delay" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-fade-in-duration" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION, __("Fade-in duration:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-in-duration" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION, 0, 20000),
                "notice-fade-in-duration" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-fade-out-delay" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY, __("Fade-out delay:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-out-delay" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY, 0, 20000),
                "notice-fade-out-delay" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-fade-out-duration" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION, __("Fade-out duration:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-out-duration" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION, 0, 20000),
                "notice-fade-out-duration" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function MouseOverBoxTruncation() {
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "mouse-over-box-truncation");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "label-truncation" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED, __("Truncate the note in the tooltip:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "truncation" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED, $l_arr_Enabled),

                "label-max-length" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH, __("Maximum number of characters in the tooltip:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "max-length" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH, 3, 10000),
                // The feature trims back until the last full word.
                "notice-max-length" => __("No weird cuts.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-readon" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL, __("‘Read on’ button label:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "readon" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function MouseOverBoxAppearance() {
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the font size unit:
        $l_arr_FontSizeUnits = array(
            "em" => __("em", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "rem" => __("rem", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "px" => __("pixels", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "pt" => __("points", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "pc" => __("picas", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "mm" => __("millimeters", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "%" => __("per cent", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "mouse-over-box-appearance");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "label-font-size" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED, __("Set font size:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "font-size-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED, $l_arr_Enabled),
                "font-size-scalar" => $this->addNumBox(MCI_Footnotes_Settings::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR, 0, 50, true),
                "font-size-unit" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT, $l_arr_FontSizeUnits),
                "notice-font-size" => __("By default, the font size is set to equal the surrounding text.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-color" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR, __("Text color:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "color" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR),
                // To use default: Clear or leave empty.
                "notice-color" => sprintf(__("To use the current theme’s default text color: %s", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("Clear or leave empty.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                "label-background" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND, __("Background color:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "background" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND),
                // To use default: Clear or leave empty.
                "notice-background" => sprintf(__("To use the current theme’s default background color: %s", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("Clear or leave empty.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                "label-border-width" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH, __("Border width:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "border-width" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH, 0, 4, true),
                "notice-border-width" => __("pixels; 0 for borderless", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-border-color" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR, __("Border color:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "border-color" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR),
                // To use default: Clear or leave empty.
                "notice-border-color" => sprintf(__("To use the current theme’s default border color: %s", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("Clear or leave empty.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                "label-border-radius" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS, __("Rounded corner radius:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "border-radius" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS, 0, 500),
                "notice-border-radius" => __("pixels; 0 for sharp corners", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-box-shadow-color" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR, __("Box shadow color:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "box-shadow-color" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR),
                // To use default: Clear or leave empty.
                "notice-box-shadow-color" => sprintf(__("To use the current theme’s default box shadow color: %s", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("Clear or leave empty.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all settings for the prepended symbol
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited heading for v2.0.4
     *
     * The former 'hyperlink arrow', incompatible with combined identical footnotes,
     * became 'prepended arrow' in v2.0.3 after a user complaint about missing backlinking semantics
     * of the footnote number.
     *
     * @since 2.1.4  moved to Settings > Reference container > Display a backlink symbol
     * @since 2.2.1 and 2.2.4  back here
     */
    public function HyperlinkArrow() {
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-hyperlink-arrow");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-symbol" => $this->addLabel(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW, __("Select or input the backlink symbol:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "symbol-options" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW, MCI_Footnotes_Convert::getArrow()),
                "symbol-custom" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED),
                "notice-symbol" => __("Your input overrides the selection.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "description-symbol" => __("This setting cannot be moved into the reference container settings, because each tab is saved in a different place, so moving a setting breaks user data. Our apologies for having done so with this setting now moved back to the tab it pre-existed under.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays the custom css box.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited:
     * @since 2.1.6  drop localized notices for CSS classes as the number increased to 16
     *        list directly in the template, as CSS is in English anyway
     * @see templates/dashboard/customize-css.html
     *         2020-12-09T1113+0100
     *
     * @since 2.2.2  migrate Custom CSS to a dedicated tab   2020-12-15T0506+0100
     * @since 2.3.0  say 'copy-paste' instead of 'cut and paste', since cutting is not needed  2020-12-27T1257+0100
     */
    public function CustomCSS() {
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-css");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-css" => $this->addLabel(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS, __("Your existing Custom CSS code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "css" => $this->addTextArea(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS),
                "description-css" => __('Custom CSS migrates to a dedicated tab. This text area is intended to keep your data safe. Please copy-paste the content into the new text area under the new tab.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                // CSS classes are listed in the template.
                // Localized notices are dropped to ease translators’ task.

                // "label-class-1" => ".footnote_plugin_tooltip_text",
                // "class-1" => $this->addText(__("superscript, Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                // "label-class-2" => ".footnote_tooltip",
                // "class-2" => $this->addText(__("mouse-over box, tooltip for each superscript", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                // "label-class-3" => ".footnote_plugin_index",
                // "class-3" => $this->addText(__("1st column of the Reference Container, Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                // "label-class-4" => ".footnote_plugin_text",
                // "class-4" => $this->addText(__("2nd column of the Reference Container, Footnote text", MCI_Footnotes_Config::C_STR_PLUGIN_NAME))
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function CustomCSSMigration() {

        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-css-migration");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-css" => $this->addLabel(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS, __("Your existing Custom CSS code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "css" => $this->addTextArea(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS),
                "description-css" => __('Custom CSS migrates to a dedicated tab. This text area is intended to keep your data safe. Please copy-paste the content into the new text area below.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-show-legacy" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_CUSTOM_CSS_LEGACY_ENABLE, "Show legacy Custom CSS settings containers:"),
                "show-legacy" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_CUSTOM_CSS_LEGACY_ENABLE, $l_arr_Enabled),
                "notice-show-legacy" => __("Please set to No when you are done migrating, for the legacy Custom CSS containers to disappear.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                // The placeholder is the “Referrers and tooltips” settings tab name.
                "description-show-legacy" => sprintf(__('The legacy Custom CSS under the %s tab and its mirror here are emptied, and the select box saved as No, when the settings tab is saved while the settings container is not displayed.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), __("Referrers and tooltips", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    public function CustomCSSNew() {
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-css-new");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "css" => $this->addTextArea(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_NEW),

                "headline" => $this->addText(__("Recommended CSS classes:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays available Hooks to look for Footnote short codes.
     *
     * @author Stefan Herndler
     * @since 1.5.5
     *
     * Edited:
     * @since 2.1.1  priority level setting for the_content  2020-11-16T2152+0100
     * @since 2.1.4  priority level settings for the other hooks   2020-11-19T1421+0100
     *
     * priority level was initially hard-coded default
     * shows "9223372036854775807" in the numbox
     * empty should be interpreted as PHP_INT_MAX,
     * but a numbox cannot be set to empty: <https://github.com/Modernizr/Modernizr/issues/171>
     * define -1 as PHP_INT_MAX instead
     *
     * @since 2.2.9  removed the warning about the widget text hook  2020-12-25T0348+0100
     * @since 2.2.9  added guidance for the widget text hook  2020-12-25T0353+0100
     */
    public function LookupHooks() {
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "expert-lookup");

        // replace all placeholders
        $l_obj_Template->replace(
            array(

                "description-1" => __('The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "description-2" => sprintf(__('For the_content, this figure must be lower than %1$d so that certain strings added by a plugin running at %1$d may not be mistaken as a footnote. This makes also sure that the reference container displays above a feature inserted by a plugin running at %2$d.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 99, 1200),
                "description-3" => sprintf(__('%1$d is lowest priority, %2$d is highest. To set priority level to lowest, set it to %3$d, interpreted as %1$d, the constant %4$s.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), PHP_INT_MAX, 0, -1, 'PHP_INT_MAX'),
                "description-4" => __('The widget_text hook must be enabled either when footnotes are present in theme text widgets, or when Elementor accordions or toggles shall have a reference container per section. If they should not, this hook must be disabled.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "head-hook" => __("WordPress hook function name", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "head-checkbox" => __("Activate", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "head-numbox" => __("Priority level", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "head-url" => __("WordPress documentation", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-the-title" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_TITLE, "the_title"),
                "the-title" => $this->addCheckbox(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_TITLE),
                "priority-the-title" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL, -1, PHP_INT_MAX),
                "url-the-title" => "https://developer.wordpress.org/reference/hooks/the_title/",

                "label-the-content" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_CONTENT, "the_content"),
                "the-content" => $this->addCheckbox(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_CONTENT),
                "priority-the-content" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL, -1, PHP_INT_MAX),
                "url-the-content" => "https://developer.wordpress.org/reference/hooks/the_content/",

                "label-the-excerpt" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_EXCERPT, "the_excerpt"),
                "the-excerpt" => $this->addCheckbox(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_EXCERPT),
                "priority-the-excerpt" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL, -1, PHP_INT_MAX),
                "url-the-excerpt" => "https://developer.wordpress.org/reference/functions/the_excerpt/",

                "label-widget-title" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE, "widget_title"),
                "widget-title" => $this->addCheckbox(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE),
                "priority-widget-title" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL, -1, PHP_INT_MAX),
                "url-widget-title" => "https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_title",

                "label-widget-text" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT, "widget_text"),
                "widget-text" => $this->addCheckbox(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT),
                "priority-widget-text" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL, -1, PHP_INT_MAX),
                "url-widget-text" => "https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_text",
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays a short introduction of the Plugin.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function Help() {
        global $g_obj_MCI_Footnotes;
        // load footnotes starting and end tag
        $l_arr_Footnote_StartingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START);
        $l_arr_Footnote_EndingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END);

        if ($l_arr_Footnote_StartingTag["value"] == "userdefined" || $l_arr_Footnote_EndingTag["value"] == "userdefined") {
            // load user defined starting and end tag
            $l_arr_Footnote_StartingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED);
            $l_arr_Footnote_EndingTag = $this->LoadSetting(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED);
        }
        $l_str_Example = "Hello" . $l_arr_Footnote_StartingTag["value"] .
                         "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,".
                         " sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.".
                         " Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet,".
                         " consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.".
                         " At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet."
                         . $l_arr_Footnote_EndingTag["value"] . " World!";

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "how-to-help");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-start" => __("Start your footnote with the following short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "start" => $l_arr_Footnote_StartingTag["value"],

                "label-end" => __("…and end your footnote with this short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "end" => $l_arr_Footnote_EndingTag["value"],

                "example-code" => $l_str_Example,
                "example-string" => "<br/>" . __("will be displayed as:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "example" => $g_obj_MCI_Footnotes->a_obj_Task->exec($l_str_Example, true),

                "information" => sprintf(__("For further information please check out our %ssupport forum%s on WordPress.org.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), '<a href="http://wordpress.org/support/plugin/footnotes" target="_blank" class="footnote_plugin">', '</a>')
            )
        );
        // call wp_head function to get the Styling of the mouse-over box
        $g_obj_MCI_Footnotes->a_obj_Task->wp_head();
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all Donate button to support the developers.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function Donate() {
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "how-to-donate");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "caption" => __('Donate now',MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }
}
