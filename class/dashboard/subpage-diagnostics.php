<?php
/**
 * Includes the Plugin Class to display Diagnostics.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 14:47
 */

/**
 * Displays Diagnostics of the web server, PHP and WordPress.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Layout_Diagnostics extends MCI_Footnotes_LayoutEngine {

	/**
	 * Returns a Priority index. Lower numbers have a higher Priority.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return int
	 */
	public function getPriority() {
		return 999;
	}

	/**
	 * Returns the unique slug of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	protected function getSubPageSlug() {
		return "-diagnostics";
	}

	/**
	 * Returns the title of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	protected function getSubPageTitle() {
		return __("Diagnostics", MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
	}

	/**
	 * Returns an array of all registered sections for the sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	protected function getSections() {
		return array(
			$this->addSection("diagnostics", __("Diagnostics", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), null, false)
		);
	}

	/**
	 * Returns an array of all registered meta boxes for each section of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	protected function getMetaBoxes() {
		return array(
			$this->addMetaBox("diagnostics", "diagnostics", __("Displays information about the web server, PHP and WordPress", MCI_Footnotes_Config::C_STR_PLUGIN_NAME), "Diagnostics")
		);
	}

	/**
	 * Displays a diagnostics about the web server, php and WordPress.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Diagnostics() {
		global $wp_version;
		$l_str_PhpExtensions = "";
		// iterate through each PHP extension
		foreach (get_loaded_extensions() as $l_int_Index => $l_str_Extension) {
			if ($l_int_Index > 0) {
				$l_str_PhpExtensions .= ' | ';
			}
			$l_str_PhpExtensions .= $l_str_Extension . ' ' . phpversion($l_str_Extension);
		}

		/** @var WP_Theme $l_obj_CurrentTheme */
		$l_obj_CurrentTheme = wp_get_theme();

		$l_str_WordPressPlugins = "";
		// iterate through each installed WordPress Plugin
		foreach (get_plugins() as $l_arr_Plugin) {
			$l_str_WordPressPlugins .= '<tr>';
			$l_str_WordPressPlugins .= '<td>' . $l_arr_Plugin["Name"] . '</td>';
			$l_str_WordPressPlugins .= '<td>' . $l_arr_Plugin["Version"] . ' [' . $l_arr_Plugin["PluginURI"] . ']' . '</td>';
			$l_str_WordPressPlugins .= '</tr>';
		}
		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "diagnostics");
		// replace all placeholders
		$l_obj_Template->replace(
			array(
				"label-server" => __("Server name", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"server" => $_SERVER["SERVER_NAME"],

				"label-php" => __("PHP version", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"php" => phpversion(),

                "label-user-agent" => __("User agent", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "user-agent" => $_SERVER["HTTP_USER_AGENT"],

				"label-max-execution-time" => __("Max execution time", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"max-execution-time" => ini_get('max_execution_time') . ' ' . __('seconds', MCI_Footnotes_Config::C_STR_PLUGIN_NAME),

				"label-memory-limit" => __("Memory limit", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"memory-limit" => ini_get('memory_limit'),

				"label-php-extensions" => __("PHP extensions", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"php-extensions" => $l_str_PhpExtensions,

				"label-wordpress" => __("WordPress version", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"wordpress" => $wp_version,

				"label-theme" => __("Active Theme", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
				"theme" => $l_obj_CurrentTheme->get("Name") . " " . $l_obj_CurrentTheme->get("Version") . ", " . $l_obj_CurrentTheme->get("Author"). " [" . $l_obj_CurrentTheme->get("AuthorURI") . "]",

				"plugins" => $l_str_WordPressPlugins
			)
		);
		// display template with replaced placeholders
		echo $l_obj_Template->getContent();
	}
}