<?php
/**
 * Includes the Plugin settings menu.
 *
 * @filesource
 * @author Stefan Herndler
 * @since  1.5.0 12.09.14 10:26
 */


/**
 * Handles the Settings interface of the Plugin.
 *
 * @author Stefan Herndler
 * @since  1.5.0
 */
class MCI_Footnotes_Layout_Init {

	/**
	 * Slug for the Plugin main menu.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_MAIN_MENU_SLUG = "mfmmf";

	/**
	 * Plugin main menu name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_MAIN_MENU_TITLE = "ManFisher";

	/**
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	private $a_arr_SubPageClasses = array();

	/**
	 * Class Constructor. Initializes all WordPress hooks for the Plugin Settings.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 */
	public function __construct() {
		// iterate through each class define in the current script
		foreach(get_declared_classes() as $l_str_ClassName) {
			// accept only child classes of the layout engine
			if(is_subclass_of($l_str_ClassName, 'MCI_Footnotes_LayoutEngine')) {
				/** @var MCI_Footnotes_LayoutEngine $l_obj_Class */
				$l_obj_Class = new $l_str_ClassName();
				// append new instance of the layout engine sub class
				$this->a_arr_SubPageClasses[$l_obj_Class->getPriority()] = $l_obj_Class;
			}
		}
		ksort($this->a_arr_SubPageClasses);

		// register hooks/actions
		add_action('admin_init', array($this, 'initializeSettings'));
		add_action('admin_menu', array($this, 'registerMainMenu'));
		// register AJAX callbacks for Plugin information
		add_action("wp_ajax_nopriv_footnotes_getPluginInfo", array($this, "getPluginMetaInformation"));
		add_action("wp_ajax_footnotes_getPluginInfo", array($this, "getPluginMetaInformation"));
	}

	/**
	 * Initializes all sub pages and registers the settings.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 */
	public function initializeSettings() {
		MCI_Footnotes_Settings::instance()->RegisterSettings();
		// iterate though each sub class of the layout engine and register their sections
		/** @var MCI_Footnotes_LayoutEngine $l_obj_LayoutEngineSubClass */
		foreach($this->a_arr_SubPageClasses as $l_obj_LayoutEngineSubClass) {
			$l_obj_LayoutEngineSubClass->registerSections();
		}
	}

	/**
	 * Registers the new main menu for the WordPress dashboard.
	 * Registers all sub menu pages for the new main menu.
	 *
	 * @author Stefan Herndler
	 * @since  2.0.2
	 * @see http://codex.wordpress.org/Function_Reference/add_menu_page
	 */
	public function registerMainMenu() {
		global $menu;
		// iterate through each main menu
		foreach($menu as $l_arr_MainMenu) {
			// iterate through each main menu attribute
			foreach($l_arr_MainMenu as $l_str_Attribute) {
				// main menu already added, append sub pages and stop
				if ($l_str_Attribute == self::C_STR_MAIN_MENU_SLUG) {
					$this->registerSubPages();
					return;
				}
			}
		}

		// add a new main menu page to the WordPress dashboard
		add_menu_page(
			self::C_STR_MAIN_MENU_TITLE, // page title
			self::C_STR_MAIN_MENU_TITLE, // menu title
			'manage_options', // capability
			self::C_STR_MAIN_MENU_SLUG, // menu slug
			array($this, "displayOtherPlugins"), // function
			plugins_url('footnotes/img/main-menu.png'), // icon url
			81 // position
		);
		$this->registerSubPages();
	}

	/**
	 * Registers all SubPages for this Plugin.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function registerSubPages() {
		// first registered sub menu page MUST NOT contain a unique slug suffix
		// iterate though each sub class of the layout engine and register their sub page
		/** @var MCI_Footnotes_LayoutEngine $l_obj_LayoutEngineSubClass */
		foreach($this->a_arr_SubPageClasses as $l_obj_LayoutEngineSubClass) {
			$l_obj_LayoutEngineSubClass->registerSubPage();
		}
	}

	/**
	 * Displays other Plugins from the developers.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function displayOtherPlugins() {
		printf("<br/>");
		printf("<h3>%s</h3>", __('Take a look on other Plugins we have developed.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME));
		printf('<em><a href="http://manfisher.net/" target="_blank">visit ManFisher Medien ManuFaktur</a></em>');
		printf("<br/><br/>");
/*
		// collect plugin list as JSON
		$l_arr_Response = wp_remote_get("http://herndler.org/wordpress/plugins/get.json");
		// check if response is valid
		if (is_wp_error($l_arr_Response)) {
			printf(__("Error loading other WordPress Plugins from Manfisher. Sorry!", MCI_Footnotes_Config::C_STR_PLUGIN_NAME));
			return;
		}
		// get the body of the response
		$l_str_Response = $l_arr_Response["body"];
		// convert the body to a json string
		$l_arr_Plugins = json_decode($l_str_Response, true);
*/
		$l_arr_Plugins = array(
			array("name" => "identity", "title" => "Identity"),
			array("name" => "google-keyword-suggest", "title" => "Google Keyword Suggest"),
			array("name" => "competition", "title" => "competition"),
			array("name" => "footnotes", "title" => "Footnotes")
		);

		// load template file
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "other-plugins");

		printf('<div id="the-list">');
		// iterate through each Plugin
		foreach($l_arr_Plugins as $l_arr_PluginInfo) {
			// replace Plugin information
			$l_obj_Template->replace(
				array(
					"name" => $l_arr_PluginInfo["name"],
					"title" => $l_arr_PluginInfo["title"]
				)
			);
			// display Plugin
			echo $l_obj_Template->getContent();
			// reload template
			$l_obj_Template->reload();
		}
		printf('</div>');
	}

	/**
	 * AJAX call. returns a JSON string containing meta information about a specific WordPress Plugin.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function getPluginMetaInformation() {
		// get plugin internal name from POST data
		$l_str_PluginName = array_key_exists("plugin", $_POST) ? $_POST["plugin"] : null;
		if (empty($l_str_PluginName)) {
			echo json_encode(array("error" => "Plugin name invalid."));
			exit;
		}
		$l_str_Url = "https://api.wordpress.org/plugins/info/1.0/".$l_str_PluginName.".json";
		// call URL and collect data
		$l_arr_Response = wp_remote_get($l_str_Url);
		// check if response is valid
		if (is_wp_error($l_arr_Response)) {
			echo json_encode(array("error" => "Can't get Plugin information."));
			exit;
		}
		// get the body of the response
		$l_str_Response = $l_arr_Response["body"];
		// get plugin object
		$l_arr_Plugin = json_decode($l_str_Response, true);

		// return Plugin information as JSON encoded string
		echo json_encode(
			array(
				"error" => "",
				"PluginImage" => "",
				"PluginDescription" => html_entity_decode($l_arr_Plugin["short_description"]),
				"PluginUrl" => $l_arr_Plugin["homepage"],
				"PluginVersion" => $l_arr_Plugin["version"]
			)
		);
		exit;
	}
}