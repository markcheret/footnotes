<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 30.07.14 10:37
 * Version: 1.0
 * Since: 1.3
 */


// define class only once
if (!class_exists("MCI_Footnotes_Tab_General")) :

/**
 * Class MCI_Footnotes_Tab_General
 * @since 1.3
 */
class MCI_Footnotes_Tab_General extends MCI_Footnotes_Admin {

	/**
	 * register the meta boxes for the tab
	 * @constructor
	 * @since 1.3
	 * @param array $p_arr_Tabs
	 */
	public function __construct(&$p_arr_Tabs) {
		// add tab to the tab array
		$p_arr_Tabs[FOOTNOTES_SETTINGS_TAB_GENERAL] = __("General", FOOTNOTES_PLUGIN_NAME);
		// register settings tab
		add_settings_section(
			"MCI_Footnotes_Settings_Section_General",
			sprintf(__("%s Settings", FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME),
			array($this, 'Description'),
			FOOTNOTES_SETTINGS_TAB_GENERAL
		);
		// reference container
		add_meta_box(
			'MCI_Footnotes_Tab_General_ReferenceContainer',
			__("References Container", FOOTNOTES_PLUGIN_NAME),
			array($this, 'ReferenceContainer'),
			FOOTNOTES_SETTINGS_TAB_GENERAL,
			'main'
		);
		// styling
		add_meta_box(
			'MCI_Footnotes_Tab_General_Styling',
			sprintf(__("%s styling", FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME),
			array($this, 'Styling'),
			FOOTNOTES_SETTINGS_TAB_GENERAL,
			'main'
		);
		// love
		add_meta_box(
			'MCI_Footnotes_Tab_General_Love',
			FOOTNOTES_PLUGIN_PUBLIC_NAME . '&nbsp;' . FOOTNOTES_LOVE_SYMBOL,
			array($this, 'Love'),
			FOOTNOTES_SETTINGS_TAB_GENERAL,
			'main'
		);
		// other
		add_meta_box(
			'MCI_Footnotes_Tab_General_Other',
			__("Other", FOOTNOTES_PLUGIN_NAME),
			array($this, 'Other'),
			FOOTNOTES_SETTINGS_TAB_GENERAL,
			'main'
		);
	}

	/**
	 * output a description for the tab
	 * @since 1.3
	 */
	public function Description() {
		// unused
	}

	/**
	 * output the setting fields for the reference container
	 * @since 1.3
	 */
	public function ReferenceContainer() {
		// setting for 'reference label'
		$this->AddLabel(FOOTNOTES_INPUT_REFERENCES_LABEL, __("References label:", FOOTNOTES_PLUGIN_NAME));
		$this->AddTextbox(FOOTNOTES_INPUT_REFERENCES_LABEL, "footnote_plugin_50");
		$this->AddNewline();
		// setting for 'collapse reference container by default'
		$this->AddLabel(FOOTNOTES_INPUT_COLLAPSE_REFERENCES, __("Collapse references by default:", FOOTNOTES_PLUGIN_NAME));
		$this->AddCheckbox(FOOTNOTES_INPUT_COLLAPSE_REFERENCES);
		$this->AddNewline();
		// setting for 'placement of the reference container'
		// @since 1.0.7
		$l_arr_Options = array(
			"footer" => __("in the footer", FOOTNOTES_PLUGIN_NAME),
			"post_end" => __("at the end of the post", FOOTNOTES_PLUGIN_NAME),
			"widget" => __("in the widget area", FOOTNOTES_PLUGIN_NAME)
		);
		$this->AddLabel(FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE, __("Where shall the reference container appear:", FOOTNOTES_PLUGIN_NAME));
		$this->AddSelect(FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE, $l_arr_Options, "footnote_plugin_50");
	}

	/**
	 * output the setting fields for the footnotes styling
	 * @since 1.3
	 */
	public function Styling() {
		// setting for 'combine identical footnotes'
		$l_arr_Options = array(
			"yes" => __("Yes", FOOTNOTES_PLUGIN_NAME),
			"no" => __("No", FOOTNOTES_PLUGIN_NAME)
		);
		$this->AddLabel(FOOTNOTES_INPUT_COMBINE_IDENTICAL, __("Combine identical footnotes:", FOOTNOTES_PLUGIN_NAME));
		$this->AddSelect(FOOTNOTES_INPUT_COMBINE_IDENTICAL, $l_arr_Options, "footnote_plugin_50");
		$this->AddNewline();
		// setting for 'footnote tag starts with'
		$l_arr_Options = array(
			"((" => "((",
			"<fn>" => htmlspecialchars("<fn>"),
			"[ref]" => "[ref]",
			"userdefined" => __('user defined', FOOTNOTES_PLUGIN_NAME)
		);
		$this->AddLabel(FOOTNOTES_INPUT_PLACEHOLDER_START, __("Footnote tag starts with:", FOOTNOTES_PLUGIN_NAME));
		$this->AddSelect(FOOTNOTES_INPUT_PLACEHOLDER_START, $l_arr_Options, "footnote_plugin_15");
		// setting for 'footnote tag ends with'
		$l_arr_Options = array(
			"))" => "))",
			"</fn>" => htmlspecialchars("</fn>"),
			"[/ref]" => "[/ref]",
			"userdefined" => __('user defined', FOOTNOTES_PLUGIN_NAME)
		);
		$this->AddLabel(FOOTNOTES_INPUT_PLACEHOLDER_END, __("and ends with:", FOOTNOTES_PLUGIN_NAME) . '&nbsp;&nbsp;&nbsp;', 'text-align: right;');
		$this->AddSelect(FOOTNOTES_INPUT_PLACEHOLDER_END, $l_arr_Options, "footnote_plugin_15");
		$this->AddNewline();
		// user defined setting for 'footnote start and end tag'
		$this->AddLabel(FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED, "");
		$this->AddTextbox(FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED, "footnote_plugin_15", 14, false, true);
		$this->AddLabel(FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED, "");
		$this->AddTextbox(FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED, "footnote_plugin_15", 14, false, true);
		$this->AddNewline();
		// setting for 'footnotes counter style'
		$l_str_Space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$l_arr_Options = array(
			"arabic_plain" => __("Arabic Numbers - Plain", FOOTNOTES_PLUGIN_NAME) . $l_str_Space . "1, 2, 3, 4, 5, ...",
			"arabic_leading" => __("Arabic Numbers - Leading 0", FOOTNOTES_PLUGIN_NAME) . $l_str_Space . "01, 02, 03, 04, 05, ...",
			"latin_low" => __("Latin Character - lower case", FOOTNOTES_PLUGIN_NAME) . $l_str_Space . "a, b, c, d, e, ...",
			"latin_high" => __("Latin Character - upper case", FOOTNOTES_PLUGIN_NAME) . $l_str_Space . "A, B, C, D, E, ...",
			"romanic" => __("Roman Numerals", FOOTNOTES_PLUGIN_NAME) . $l_str_Space . "I, II, III, IV, V, ..."
		);
		$this->AddLabel(FOOTNOTES_INPUT_COUNTER_STYLE, __('Counter style:', FOOTNOTES_PLUGIN_NAME));
		$this->AddSelect(FOOTNOTES_INPUT_COUNTER_STYLE, $l_arr_Options, "footnote_plugin_50");
	}

	/**
	 * output the setting fields to love and share the footnotes plugin
	 * @since 1.3
	 */
	public function Love() {
		// setting for 'love and share this plugin in my footer'
		$l_arr_Options = array(
			"text-1" => sprintf(__('I %s %s', FOOTNOTES_PLUGIN_NAME), FOOTNOTES_LOVE_SYMBOL, FOOTNOTES_PLUGIN_PUBLIC_NAME),
			"text-2" => sprintf(__('this site uses the awesome %s Plugin', FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME),
			"text-3" => sprintf(__('extra smooth %s', FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME),
			"random" => __('random text', FOOTNOTES_PLUGIN_NAME),
			"no" => sprintf(__("Don't display a %s %s text in my footer.", FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME, FOOTNOTES_LOVE_SYMBOL)
		);
		$this->AddLabel(FOOTNOTES_INPUT_LOVE, sprintf(__("Tell the world you're using %s:", FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME));
		$this->AddSelect(FOOTNOTES_INPUT_LOVE, $l_arr_Options, "footnote_plugin_50");
		$this->AddNewline();
		// no 'love me' on specific pages
		$this->AddText(sprintf(__("Don't tell the world you're using %s on specific pages by adding the following short code:", FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME));
		$this->AddText("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
		$this->AddText(FOOTNOTES_NO_SLUGME_PLUG);
	}

	/**
	 * output settings fields with no specific topic
	 * @since 1.3
	 */
	public function Other() {
		// setting for 'search footnotes tag in excerpt'
		$l_arr_Options = array(
			"yes" => __("Yes", FOOTNOTES_PLUGIN_NAME),
			"no" => __("No", FOOTNOTES_PLUGIN_NAME)
		);
		$this->AddLabel(FOOTNOTES_INPUT_SEARCH_IN_EXCERPT, __('Allow footnotes on Summarized Posts:', FOOTNOTES_PLUGIN_NAME));
		$this->AddSelect(FOOTNOTES_INPUT_SEARCH_IN_EXCERPT, $l_arr_Options, "footnote_plugin_50");
	}
} // class MCI_Footnotes_Tab_General

endif;