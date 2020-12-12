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
     * @since  1.5.0
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
            null // position
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
        printf("<br/><br/>");
        // load template file
        $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_DASHBOARD, "manfisher");
        echo $l_obj_Template->getContent();

        printf('<em>visit <a href="https://cheret.de/plugins/footnotes-2/" target="_blank">Mark Cheret</a></em>');
        printf("<br/><br/>");
        
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
            echo json_encode(array("error" => "Error receiving Plugin Information from WordPress."));
            exit;
        }
        if (!array_key_exists("body", $l_arr_Response)) {
            echo json_encode(array("error" => "Error reading WordPress API response message."));
            exit;
        }
        // get the body of the response
        $l_str_Response = $l_arr_Response["body"];
        // get plugin object
        $l_arr_Plugin = json_decode($l_str_Response, true);
        if (empty($l_arr_Plugin)) {
            echo json_encode(array("error" => "Error reading Plugin meta information.<br/>URL: " . $l_str_Url . "<br/>Response: " . $l_str_Response));
            exit;
        }

        $l_int_NumRatings = array_key_exists("num_ratings", $l_arr_Plugin) ? intval($l_arr_Plugin["num_ratings"]) : 0;
        $l_int_Rating = array_key_exists("rating", $l_arr_Plugin) ? floatval($l_arr_Plugin["rating"]) : 0.0;
        $l_int_Stars = round(5 * $l_int_Rating / 100.0, 1);

        // return Plugin information as JSON encoded string
        echo json_encode(
            array(
                "error" => "",
                "PluginDescription" => array_key_exists("short_description", $l_arr_Plugin) ? html_entity_decode($l_arr_Plugin["short_description"]) : "Error reading Plugin information",
                "PluginAuthor" => array_key_exists("author", $l_arr_Plugin) ? html_entity_decode($l_arr_Plugin["author"]) : "unknown",
                "PluginRatingText" => $l_int_Stars . " " . __("rating based on", MCI_Footnotes_Config::C_STR_PLUGIN_NAME) . " " . $l_int_NumRatings . " " . __("ratings", MCI_Footnotes_Config::C_STR_PLUGIN_NAME),
                "PluginRating1" => $l_int_Stars >= 0.5 ? "star-full" : "star-empty",
                "PluginRating2" => $l_int_Stars >= 1.5 ? "star-full" : "star-empty",
                "PluginRating3" => $l_int_Stars >= 2.5 ? "star-full" : "star-empty",
                "PluginRating4" => $l_int_Stars >= 3.5 ? "star-full" : "star-empty",
                "PluginRating5" => $l_int_Stars >= 4.5 ? "star-full" : "star-empty",
                "PluginRating" => $l_int_NumRatings,
                "PluginLastUpdated" => array_key_exists("last_updated", $l_arr_Plugin) ? $l_arr_Plugin["last_updated"] : "unknown",
                "PluginDownloads" => array_key_exists("downloaded", $l_arr_Plugin) ? $l_arr_Plugin["downloaded"] : "---"
            )
        );
        exit;
    }
}
