<?php
/**
 * User: she
 * Date: 30.04.14
 * Time: 16:21
 */

/**
 * Class footnotes_class_plugin
 */
class footnotes_class_plugin
{
	var $settings, $options_page; /* class attributes */

	/**
	 * @constructor
	 */
	function __construct()
	{
		/* load settings only if current wordpress user is admin */
		if (is_admin()) {
			/* create a new instance of the class settings */
			$this->settings = new footnotes_class_settings();
		}

		/* execute class function: init, admin_init and admin_menu */
		add_action('init', array($this, 'init'));
		add_action('admin_init', array($this, 'admin_init'));
		add_action('admin_menu', array($this, 'admin_menu'));

		/* register hook for activating the plugin */
		register_activation_hook(__FILE__, array($this, 'activate'));
		/* register hook for deactivating the plugin */
		register_deactivation_hook(__FILE__, array($this, 'deactivate'));
		/* register hook for uninstalling the plugin */
		register_uninstall_hook(__FILE__, array(__CLASS__, 'uninstall'));
	}

	/**
	 * activates the plugin
	 */
	function activate()
	{
	}

	/**
	 * deactivates the plugin
	 */
	function deactivate()
	{
	}

	/**
	 * uninstalls the plugin
	 */
	function uninstall()
	{
		require_once(PLUGIN_DIR . 'uninstall.php');
	}

	/**
	 * initialize function
	 * called in the class constructor
	 */
	function init()
	{
	}

	/**
	 * do admin init stuff
	 * called in the class constructor
	 */
	function admin_init()
	{
	}

	/**
	 * do admin menu stuff
	 * called in the class constructor
	 */
	function admin_menu()
	{
	}

} /* class footnotes_class_plugin */