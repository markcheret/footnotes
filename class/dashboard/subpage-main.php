<?php
/**
 * Includes the Plugin Class to display all Settings.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 14:47
 *
 * Edited for:
 * 2.0.4  restore arrow settings  2020-11-01T0509+0100
 * 2.1.0  read-on button label  2020-11-08T2148+0100
 * 2.1.1  options for ref container and alternative tooltips  2020-11-16T2152+0100
 * 2.2.0  settings for ref container, tooltips and scrolling  2020-12-03T0950+0100
 *
 * Last modified: 2020-12-06T1321+0100
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
     */
    protected function getSections() {
        $l_arr_Tabs = array();
        $l_arr_Tabs[] = $this->addSection("settings", __("Settings", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 0, true);
        $l_arr_Tabs[] = $this->addSection("customize", __("Customize", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 1, true);
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_EXPERT_MODE))) {
            $l_arr_Tabs[] = $this->addSection("expert", __("Expert mode", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), 2, true);
        }
        $l_arr_Tabs[] = $this->addSection("how-to", __("How to", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), null, false);
        return $l_arr_Tabs;
    }

    /**
     * Returns an array of all registered meta boxes for each section of the sub page.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return array
     *
     * Edited for v2.0.4 to reflect changes in display since WPv5.5
     * Details in class/config.php
     */
    protected function getMetaBoxes() {
        return array(
            // Change string "%s styling" to "Footnotes styling" to fix layout in WPv5.5:
            $this->addMetaBox("settings", "styling", __("Footnotes styling", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Styling"),
            $this->addMetaBox("settings", "reference-container", __("References Container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "ReferenceContainer"),
            $this->addMetaBox("settings", "other", __("Other", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Other"),
            // Leave intact since this is not localized:
            $this->addMetaBox("settings", "love", MCI_Footnotes_Config::C_STR_PLUGIN_HEADING_NAME . '&nbsp;' . MCI_Footnotes_Config::C_STR_LOVE_SYMBOL_HEADING, "Love"),

            // The HyperlinkArrow meta box ceased for 2.0.0
            // The HyperlinkArrow meta box was restored for 2.0.4 to meet user demand for arrow symbol semantics
            // The HyperlinkArrow meta box ceased for 2.2.0 as its content is moved to Settings > Reference container > Display a backlink symbol
            $this->addMetaBox("customize", "superscript", __("Superscript layout", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Superscript"),
            $this->addMetaBox("customize", "mouse-over-box", __("Mouse-over box", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "MouseOverBox"),
            $this->addMetaBox("customize", "custom-css", __("Add custom CSS to the public page", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "CustomCSS"),

            $this->addMetaBox("expert", "lookup", __("WordPress hooks to look for Footnote short codes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "lookupHooks"),

            $this->addMetaBox("how-to", "help", __("Brief introduction in how to use the plugin", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Help"),
            $this->addMetaBox("how-to", "donate", __("Help us to improve our Plugin", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Donate")
        );
    }

    /**
     * Displays all settings for the reference container.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Completed:
     * @since 2.2.0: layout and typography options   2020-11-30T0548+0100
     */
    public function ReferenceContainer() {
        // options for the positioning of the reference container
        $l_arr_Positions = array(
            "footer" => __("in the footer", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "post_end" => __("at the end of the post", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "widget" => __("in the widget area", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // basic responsive page layout options:
        $l_arr_PageLayoutOptions = array(
            "none" => __("Don’t fix the layout", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "reference-container" => __("to the reference container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "page-content" => __("to everything after the post title until the reference container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "main-content" => __("to everything from the post title to the reference container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
        );
        // options for the separating punctuation between backlinks:
        // Unicode names are conventionally uppercase.
        $l_arr_Separators = array(
            "comma" => __("COMMA", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "semicolon" => __("SEMICOLON", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "en_dash" => __("EN DASH", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the terminating punctuation after backlinks:
        // The Unicode name of RIGHT PARENTHESIS was originally more accurate because it is bidi-mirrored.
        // The wrong names were enforced in spite of Unicode, that subsequently scrambled to correct.
        $l_arr_Terminators = array(
            "period" => __("FULL STOP", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
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
                "label-name" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME, __("References label", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "name" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME),

                "label-collapse" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE, __("Collapse references by default", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "collapse" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE, $l_arr_Enabled),

                "label-position" => $this->addLabel(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, __("Where shall the reference container appear", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "position" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, $l_arr_Positions),

                "label-page-layout" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT, __("Apply basic responsive page layout", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "page-layout" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT, $l_arr_PageLayoutOptions),
                "notice-page-layout" => __("Most themes don’t need this fix.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-startpage" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE, __("Display on start page too", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "startpage" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE, $l_arr_Enabled),

                "label-symbol" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE, __("Display a backlink symbol", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "symbol-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE, $l_arr_Enabled),
                "symbol-options" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW, MCI_Footnotes_Convert::getArrow()),
                "symbol-custom" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED),
                "notice-symbol" => __("Your input overrides the selection.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-switch" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH, __("Symbol appended, not prepended", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "switch" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH, $l_arr_Enabled),

                "label-3column" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE, __("Backlink symbol in an extra column", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "3column" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE, $l_arr_Enabled),
                "notice-3column" => __("This legacy layout is available if identical footnotes are not combined.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-separator" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_SEPARATOR_ENABLED, __("Add a separator when enumerating backlinks", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "separator-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_SEPARATOR_ENABLED, $l_arr_Enabled),
                "separator-options" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_OPTION, $l_arr_Separators),
                "separator-custom" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_CUSTOM),
                "notice-separator" => __("Your input overrides the selection.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-terminator" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_TERMINATOR_ENABLED, __("Add a terminal punctuation to backlinks", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "terminator-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_TERMINATOR_ENABLED, $l_arr_Enabled),
                "terminator-options" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_OPTION, $l_arr_Terminators),
                "terminator-custom" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_CUSTOM),
                "notice-terminator" => __("Your input overrides the selection.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-width" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED, __("Set backlinks column width", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "width-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED, $l_arr_Enabled),
                "width-scalar" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR, 0, 500, true),
                "width-unit" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT, $l_arr_WidthUnits),
                "notice-width" => __("Absolute width in pixels doesn’t need to be accurate to the tenth, but relative width in rem or em may.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-max-width" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED, __("Set backlinks column maximum width", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "max-width-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED, $l_arr_Enabled),
                "max-width-scalar" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR, 0, 500, true),
                "max-width-unit" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT, $l_arr_WidthUnits),
                "notice-max-width" => __("Absolute width in pixels doesn’t need to be accurate to the tenth, but relative width in rem or em may.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-line-break" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED, __("Stack backlinks when enumerating", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "line-break" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED, $l_arr_Enabled),
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all settings for the footnotes styling.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function Styling() {
        // define some space for the output
        $l_str_Space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        // options for the combination of identical footnotes
        $l_arr_Enable = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the start of the footnotes short code
        $l_arr_ShortCodeStart = array(
            "((" => "((",
            htmlspecialchars("<fn>") => htmlspecialchars("<fn>"),
            "[ref]" => "[ref]",
            "userdefined" => __('user defined', MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the end of the footnotes short code
        $l_arr_ShortCodeEnd = array(
            "))" => "))",
            htmlspecialchars("</fn>") => htmlspecialchars("</fn>"),
            "[/ref]" => "[/ref]",
            "userdefined" => __('user defined', MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the counter style of the footnotes
        $l_arr_CounterStyle = array(
            "arabic_plain" => __("Arabic Numbers - Plain", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "1, 2, 3, 4, 5, ...",
            "arabic_leading" => __("Arabic Numbers - Leading 0", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "01, 02, 03, 04, 05, ...",
            "latin_low" => __("Latin Character - lower case", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "a, b, c, d, e, ...",
            "latin_high" => __("Latin Character - upper case", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "A, B, C, D, E, ...",
            "romanic" => __("Roman Numerals", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . $l_str_Space . "I, II, III, IV, V, ..."
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-styling");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-short-code-start" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, __("Footnote tag starts with", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "short-code-start" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, $l_arr_ShortCodeStart),
                "short-code-start-user" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED),

                "label-short-code-end" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, __("and ends with", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "short-code-end" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, $l_arr_ShortCodeEnd),
                "short-code-end-user" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED),

                // for script showing/hiding user defined text boxes:
                "short-code-start-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START,
                "short-code-end-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END,
                "short-code-start-user-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED,
                "short-code-end-user-id" => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED,

                "label-counter-style" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, __("Counter style", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "counter-style" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, $l_arr_CounterStyle),

                // algorithmically combine identicals:
                "label-identical" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES, __("Combine identical footnotes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "identical" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES, $l_arr_Enable),

                "label-scroll-offset" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET, __("Scroll offset", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "scroll-offset" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET, 0, 100),
                "notice-scroll-offset" => __("per cent from the upper edge of the window", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-scroll-duration" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION, __("Scroll duration", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "scroll-duration" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION, 0, 20000),
                "notice-scroll-duration" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

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
     */
    public function Love() {
        // options for the positioning of the reference container
        $l_arr_Love = array(
            "text-1" => sprintf(__('I %s %s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            "text-2" => sprintf(__('this site uses the awesome %s Plugin', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            "text-3" => sprintf(__('extra smooth %s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME),
            "random" => __('random text', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => sprintf(__("Don't display a %s %s text in my footer.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-love");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-love" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, sprintf(__("Tell the world you're using %s", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME)),
                "love" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, $l_arr_Love),

                "label-no-love" => $this->addText(sprintf(__("Don't tell the world you're using %s on specific pages by adding the following short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME)),
                "no-love" => $this->addText(MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG)
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all settings that are not grouped in special meta boxes.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function Other() {
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );

        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "settings-other");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-link" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_LINK_ELEMENT_ENABLED, __("Use the link element for referrers and backlinks", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "link" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_LINK_ELEMENT_ENABLED, $l_arr_Enabled),

                "label-excerpt" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT, __("Allow footnotes on Summarized Posts", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "excerpt" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT, $l_arr_Enabled),
                "notice1-excerpt" => __("This should be disabled.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "notice2-excerpt" => __("In some themes, the Advanced Excerpt plugin is indispensable to display footnotes in excerpts.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "notice3-excerpt" => __("Footnotes cannot be disabled in excerpts. A workaround is to avoid footnotes in the first 55&nbsp;words.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-expert-mode" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_EXPERT_MODE, __("Enable the Expert mode", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "expert-mode" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_EXPERT_MODE, $l_arr_Enabled)
            )
        );
        // display template with replaced placeholders
        echo $l_obj_Template->getContent();
    }

    /**
     * Displays all settings for the footnotes Superscript.
     *
     * @author Stefan Herndler
     * @since 1.5.0
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
                "label-superscript" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS, __("Enable superscript for footnote referrers", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "superscript" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS, $l_arr_Enabled),

                "label-before" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE, __("Before Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "before" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE),

                "label-after" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER, __("After Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "after" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER)
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
     */
    public function MouseOverBox() {
        // options for Yes/No select box:
        $l_arr_Enabled = array(
            "yes" => __("Yes", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "no" => __("No", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
        );
        // options for the Mouse-over box position
        $l_arr_Position = array(
            "top left" => __("top left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "top center" => __("top center", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "top right" => __("top right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "center right" => __("center right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom right" => __("bottom right", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom center" => __("bottom center", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "bottom left" => __("bottom left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
            "center left" => __("center left", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)
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
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-mouse-over-box");
        // replace all placeholders
        $l_obj_Template->replace(
            array(

                // tooltip settings:

                "label-enable" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED, __("Enable the mouse-over box", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED, $l_arr_Enabled),

                "label-alternative" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE, __("Use alternative tooltip implementation", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "alternative" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE, $l_arr_Enabled),

                "label-activate-excerpt" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED, __("Display only an excerpt", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "activate-excerpt" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED, $l_arr_Enabled),

                "label-excerpt-length" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH, __("Maximum characters for the excerpt", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "excerpt-length" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH, 3, 10000),

                "label-readon" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL, __("‘Read on’ button label", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "readon" => $this->addTextBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL),

                "label-position" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION, __("Position", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "position" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION, $l_arr_Position),

                "label-offset-x" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X, __("Offset X (px)", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "offset-x" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X, -150, 150),
                "notice-offset-x" => __("Offset (X axis) in px (may be negative)", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-offset-y" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y, __("Offset Y (px)", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "offset-y" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y, -150, 150),
                "notice-offset-y" => __("Offset (Y axis) in px (may be negative)", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-max-width" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH, __("Max. width (px)", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "max-width" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH, 0, 1280),
                "notice-max-width" => __("Set the max-width to 0px to disable this setting.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                // display durations:

                "label-fade-in-delay" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY, __("Fade-in delay", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-in-delay" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY, 0, 20000),
                "notice-fade-in-delay" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-fade-in-duration" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION, __("Fade-in duration", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-in-duration" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION, 0, 20000),
                "notice-fade-in-duration" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-fade-out-delay" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY, __("Fade-out delay", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-out-delay" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY, 0, 20000),
                "notice-fade-out-delay" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-fade-out-duration" => $this->addLabel(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION, __("Fade-out duration", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "fade-out-duration" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION, 0, 20000),
                "notice-fade-out-duration" => __("milliseconds", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                // tooltip styling:

                "label-font-size" => $this->addLabel(MCI_Footnotes_Settings::C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED, __("Set font size", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "font-size-enable" => $this->addSelectBox(MCI_Footnotes_Settings::C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED, $l_arr_Enabled),
                "font-size-scalar" => $this->addNumBox(MCI_Footnotes_Settings::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR, 0, 50, true),
                "font-size-unit" => $this->addSelectBox(MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT, $l_arr_FontSizeUnits),
                "notice-font-size" => __("By default, the font size is set to equal the surrounding text.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-color" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR, __("Color", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "color" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR),
                "notice-color" => __("Empty color will use the default color defined by your current theme.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-background" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND, __("Background color", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "background" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND),
                "notice-background" => __("Empty color will use the default background-color defined by your current theme.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-border-width" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH, __("Border width (px)", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "border-width" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH, 0, 4, true),
                "notice-border-width" => __("Set the width to 0px to hide the border.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-border-color" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR, __("Border color", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "border-color" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR),
                "notice-border-color" => __("Empty color will use the default border-color defined by your current theme.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-border-radius" => $this->addLabel(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS, __("Border radius (px)", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "border-radius" => $this->addNumBox(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS, 0, 500),
                "notice-border-radius" => __("Set the radius to 0px to avoid a radius.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

                "label-box-shadow-color" => $this->addLabel(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR, __("Box shadow color", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "box-shadow-color" => $this->addColorSelection(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR),
                "notice-box-shadow-color" => __("Empty color will use the default box shadow defined by your current theme.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

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
     * @since 2.2.0  moved to Settings > Reference container > Display a backlink symbol
     */

    /**
     * Displays the custom css box.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function CustomCSS() {
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "customize-css");
        // replace all placeholders
        $l_obj_Template->replace(
            array(
                "label-css" => $this->addLabel(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS, __("Add custom CSS", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),
                "css" => $this->addTextArea(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS),

                "headline" => $this->addText(__("Available CSS classes to customize the footnotes and the reference container", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                "label-class-1" => ".footnote_plugin_tooltip_text",
                "class-1" => $this->addText(__("superscript, Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                "label-class-2" => ".footnote_tooltip",
                "class-2" => $this->addText(__("mouse-over box, tooltip for each superscript", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                "label-class-3" => ".footnote_plugin_index",
                "class-3" => $this->addText(__("1st column of the Reference Container, Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),

                "label-class-4" => ".footnote_plugin_text",
                "class-4" => $this->addText(__("2nd column of the Reference Container, Footnote text", MCI_Footnotes_Config::C_STR_PLUGIN_NAME))
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
     * Edited for:
     * 2.1.1  add priority level setting for the_content  2020-11-16T2152+0100
     * 2.2.0  add priority level settings for the other hooks   2020-11-19T1421+0100
     */
    public function lookupHooks() {
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "expert-lookup");

        // replace all placeholders
        // priority level was initially hard-coded default
        // shows "9223372036854775807" in the numbox
        // empty should be interpreted as PHP_INT_MAX,
        // but a numbox cannot be set to empty: <https://github.com/Modernizr/Modernizr/issues/171>
        // define -1 as PHP_INT_MAX instead

        $l_obj_Template->replace(
            array(

                "description-1" => __("The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "description-2" => __("Default 9223372036854775807 is lowest priority, 0 is highest.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "description-3" => __("To restore default priority, set to -1, interpreted as 9223372036854775807, the constant PHP_INT_MAX.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "description-4" => __("For the_content, this figure needs to be lower than 1200 to make sure that the reference container displays above features inserted by other plugins running at 1200 or a greater/lower level, later in the process.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "description-5" => __("The widget_text hook must be disabled, because a footnotes container is inserted at the bottom of each widget, but multiple containers in a page are not disambiguated.", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

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

                "label-end" => __("...and end your footnote with this short code:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
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
