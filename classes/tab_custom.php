<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 30.07.14 10:53
 * Version: 1.0
 * Since: 1.3
 */


// define class only once
if (!class_exists("MCI_Footnotes_Tab_Custom")) :

/**
 * Class MCI_Footnotes_Tab_Custom
 * @since 1.3
 */
class MCI_Footnotes_Tab_Custom extends MCI_Footnotes_Admin {

	/**
	 * register the meta boxes for the tab
	 * @constructor
	 * @since 1.3
	 * @param array $p_arr_Tabs
	 */
	public function __construct(&$p_arr_Tabs) {
		// add tab to the tab array
		$p_arr_Tabs[FOOTNOTES_SETTINGS_TAB_CUSTOM] = __("Customize", FOOTNOTES_PLUGIN_NAME);
		// register settings tab
		add_settings_section(
			"MCI_Footnotes_Settings_Section_Custom",
			"&nbsp;",
			array($this, 'Description'),
			FOOTNOTES_SETTINGS_TAB_CUSTOM
		);
		// styling
		add_meta_box(
			'MCI_Footnotes_Tab_Custom_Styling',
			__("Layout", FOOTNOTES_PLUGIN_NAME),
			array($this, 'Styling'),
			FOOTNOTES_SETTINGS_TAB_CUSTOM,
			'main'
		);
		// custom css
		add_meta_box(
			'MCI_Footnotes_Tab_Custom_Customize',
			__("Add custom CSS to the public page", FOOTNOTES_PLUGIN_NAME),
			array($this, 'CSS'),
			FOOTNOTES_SETTINGS_TAB_CUSTOM,
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
	 * footnotes layout before and after the index in text
	 * @since 1.3.1
	 */
	public function Styling() {
		// setting for 'before footnotes'
		$this->AddLabel(FOOTNOTES_INPUT_CUSTOM_STYLING_BEFORE, __("Before Footnotes:", FOOTNOTES_PLUGIN_NAME));
		$this->AddTextbox(FOOTNOTES_INPUT_CUSTOM_STYLING_BEFORE, "footnote_plugin_50");
		$this->AddNewline();
		// setting for 'after footnotes'
		$this->AddLabel(FOOTNOTES_INPUT_CUSTOM_STYLING_AFTER, __("After Footnotes:", FOOTNOTES_PLUGIN_NAME));
		$this->AddTextbox(FOOTNOTES_INPUT_CUSTOM_STYLING_AFTER, "footnote_plugin_50");
		$this->AddNewline();
	}

	/**
	 * customize css box for public page
	 * @since 1.3
	 */
	public function CSS() {
		$l_str_Separator = " &rArr; ";
		// setting for 'reference label'
		$this->AddLabel(FOOTNOTES_INPUT_CUSTOM_CSS, __("Add custom CSS:", FOOTNOTES_PLUGIN_NAME));
		$this->AddTextarea(FOOTNOTES_INPUT_CUSTOM_CSS, 12, "footnote_plugin_100");
		$this->AddNewline();

		$this->AddText($this->Highlight(gettext("Available CSS classes to customize the footnotes and the reference container:")) . "<br/>");

		echo "<blockquote>";
		$this->AddText($this->Highlight(".footnote_plugin_tooltip_text") . $l_str_Separator . gettext("inline footnotes") . "<br/>");
		$this->AddText($this->Highlight(".footnote_tooltip") . $l_str_Separator . gettext("inline footnotes, mouse over highlight box") . "<br/><br/>");

		$this->AddText($this->Highlight(".footnote_plugin_index") . $l_str_Separator . gettext("reference container footnotes index") . "<br/>");
		$this->AddText($this->Highlight(".footnote_plugin_link") . $l_str_Separator . gettext("reference container footnotes linked arrow") . "<br/>");
		$this->AddText($this->Highlight(".footnote_plugin_text") . $l_str_Separator . gettext("reference container footnotes text"));
		echo "</blockquote>";
	}
} // class MCI_Footnotes_Tab_Custom

endif;