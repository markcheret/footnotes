<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 07.09.14 02:53
 * Since: 1.4.0
 */


// define class only once
if (!class_exists("MCI_Footnotes_Tab_Diagnostics")) :

/**
 * Class MCI_Footnotes_Tab_Diagnostics
 * @since 1.4.0
 */
class MCI_Footnotes_Tab_Diagnostics extends MCI_Footnotes_Admin {

	/**
	 * register the meta boxes for the tab
	 * @constructor
	 * @since 1.4.0
	 * @param array $p_arr_Tabs
	 */
	public function __construct(&$p_arr_Tabs) {
		// add tab to the tab array
		$p_arr_Tabs[FOOTNOTES_SETTINGS_TAB_DIAGNOSTICS] = __("Diagnostics", FOOTNOTES_PLUGIN_NAME);
		// register settings tab
		add_settings_section(
			"MCI_Footnotes_Settings_Section_Diagnostics",
			"&nbsp;",
			array($this, 'Description'),
			FOOTNOTES_SETTINGS_TAB_DIAGNOSTICS
		);
		// help
		add_meta_box(
			'MCI_Footnotes_Tab_Diagnostics_Display',
			__("Displays information about the web server, PHP and WordPress.", FOOTNOTES_PLUGIN_NAME),
			array($this, 'Display'),
			FOOTNOTES_SETTINGS_TAB_DIAGNOSTICS,
			'main'
		);
	}

	/**
	 * output a description for the tab
	 * @since 1.4.0
	 */
	public function Description() {
		// unused
	}

	/**
	 * outputs the diagnostics
	 * @since 1.4.0
	 */
	public function Display() {
		global $wp_version;

		echo '<table style="width: 100%;">';
		echo '<tbody>';

		// website
		echo '<tr>';
		echo '<td style="vertical-align:top; width: 20%;">' . $this->Highlight(__('Server name', FOOTNOTES_PLUGIN_NAME)) . '</td>';
		echo '<td>' . $_SERVER["SERVER_NAME"] . '</td>';
		echo '</tr>';

		// PHP version
		echo '<tr>';
		echo '<td>' . $this->Highlight(__('PHP version', FOOTNOTES_PLUGIN_NAME)) . '</td>';
		echo '<td>' . phpversion() . '</td>';
		echo '</tr>';

		// max. execution time
		echo '<tr>';
		echo '<td>' . $this->Highlight(__('Max execution time', FOOTNOTES_PLUGIN_NAME)) . '</td>';
		echo '<td>' . ini_get('max_execution_time') . ' ' . __('seconds', FOOTNOTES_PLUGIN_NAME) . '</td>';
		echo '</tr>';

		// memory limit
		echo '<tr>';
		echo '<td>' . $this->Highlight(__('Memory limit', FOOTNOTES_PLUGIN_NAME)) . '</td>';
		echo '<td>' . ini_get('memory_limit') . '</td>';
		echo '</tr>';

		// PHP extensions
		echo '<tr>';
		echo '<td>' . $this->Highlight(__('PHP extensions', FOOTNOTES_PLUGIN_NAME)) . '</td>';
		echo '<td>';
		foreach (get_loaded_extensions() as $l_int_Index => $l_str_Extension) {
			if ($l_int_Index > 0) {
				echo ' | ';
			}
			echo $l_str_Extension . ' ' . phpversion($l_str_Extension);
		}
		echo '</td>';
		echo '</tr>';

		// WordPress version
		echo '<tr>';
		echo '<td>' . $this->Highlight(__('WordPress version', FOOTNOTES_PLUGIN_NAME)) . '</td>';
		echo '<td>' . $wp_version . '</td>';
		echo '</tr>';

		// WordPress Plugins installed
		foreach (get_plugins() as $l_arr_Plugin) {
			echo '<tr>';
			echo '<td>' . $this->Highlight($l_arr_Plugin["Name"]) . '</td>';
			echo '<td>' . $l_arr_Plugin["Version"] . ' [' . $l_arr_Plugin["PluginURI"] . ']' . '</td>';
			echo '</tr>';
		}

		echo '</tbody>';
		echo '</table>';
	}
} // class MCI_Footnotes_Tab_Diagnostics

endif;