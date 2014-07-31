<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0.6
 * Since: 1.0
 */


// define class only once
if (!class_exists( "MCI_Footnotes" )) :

/**
 * Class MCI_Footnotes
 * @since 1.0
 */
class MCI_Footnotes {
    // object to the plugin settings
    // @since 1.0
    // @var MCI_Footnotes_Admin $a_obj_Settings
    private $a_obj_Admin;

	// replace task object
	/** @var \MCI_Footnotes_Task $a_obj_Task */
	public $a_obj_Task;

    /**
     * @constructor
     * @since 1.0
     */
    public function __construct() {
        // load settings only if current WordPress user is admin
        if (is_admin()) {
			// load plugin settings
			require_once(dirname( __FILE__ ) . "/admin.php");
            $this->a_obj_Admin = new MCI_Footnotes_Admin();
        }
		// load plugin widget
		require_once(dirname( __FILE__ ) . "/widget.php");
		// register footnotes widget
		add_action('widgets_init', create_function('', 'return register_widget("MCI_Footnotes_Widget");'));
		// load public css and javascript files
		add_action('init', array($this, 'LoadScriptsAndStylesheets'));
		// adds javascript and stylesheets to the public page
		add_action('wp_enqueue_scripts', array($this, 'LoadScriptsAndStylesheets'));

		// load plugin widget
		require_once(dirname( __FILE__ ) . "/task.php");
		$this->a_obj_Task = new MCI_Footnotes_Task();
		$this->a_obj_Task->Register();
    }

    /**
     * activates the plugin
     * @since 1.0
     */
	public static function activate() {
        //  unused
    }

    /**
     * deactivates the plugin
     * @since 1.0
     */
	public static function deactivate() {
        //  unused
    }

    /**
     * uninstalls the plugin
     * updated file path in version 1.0.6
     * @since 1.0
     */
	public static function uninstall() {
		// uninstalling the plugin is only allowed for logged in users
		if (!is_user_logged_in()) {
			wp_die(__('You must be logged in to run this script.', FOOTNOTES_PLUGIN_NAME));
		}

		// current user needs the permission to (un)install plugins
		if (!current_user_can('install_plugins')) {
			wp_die(__('You do not have permission to run this script.', FOOTNOTES_PLUGIN_NAME));
		}

		// delete the settings container in the database
		// @since 1.0.6
		delete_option(FOOTNOTES_SETTINGS_CONTAINER);
		delete_option(FOOTNOTES_SETTINGS_CONTAINER_CUSTOM);
    }

	/**
	 * load public styling and client function
	 * called in class constructor @ init
	 * @since 1.0
	 */
	public function LoadScriptsAndStylesheets() {
		// register public stylesheets
		wp_register_style('MCI_Footnotes_public_style_General', plugins_url('../css/footnotes.css', __FILE__));
		wp_register_style('MCI_Footnotes_public_style_Tooltip', plugins_url('../css/tooltip.css', __FILE__));
		wp_register_style('MCI_Footnotes_public_style_ReferenceContainer', plugins_url('../css/reference_container.css', __FILE__));
		// add public stylesheets
		wp_enqueue_style('MCI_Footnotes_public_style_General');
		wp_enqueue_style('MCI_Footnotes_public_style_Tooltip');
		wp_enqueue_style('MCI_Footnotes_public_style_ReferenceContainer');

		// add the jQuery plugin (already registered by WP)
		wp_enqueue_script('jquery');
		// add jquery tools to public page
		wp_enqueue_script('footnotes_public_script', plugins_url('../js/jquery.tools.min.js', __FILE__), array());
	}

} // class MCI_Footnotes

endif;