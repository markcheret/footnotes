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
		$p_arr_Tabs[FOOTNOTES_SETTINGS_TAB_CUSTOM] = __("Custom CSS", FOOTNOTES_PLUGIN_NAME);
		// register settings tab
		add_settings_section(
			"MCI_Footnotes_Settings_Section_Custom",
			"&nbsp;",
			array($this, 'Description'),
			FOOTNOTES_SETTINGS_TAB_CUSTOM
		);
		// help
		add_meta_box(
			'MCI_Footnotes_Tab_HowTo_Custom',
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