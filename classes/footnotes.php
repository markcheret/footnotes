<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0.6
 * Since: 1.0
 */

/**
 * Class Class_Footnotes
 * @since 1.0
 */
class Class_Footnotes
{
    /*
     * object to the plugin's settings
     * @since 1.0
     */
    var $a_obj_Settings;

    /**
     * @constructor
     * @since 1.0
     */
    function __construct()
    {
        /* load settings only if current wordpress user is admin */
        if (is_admin()) {
            /* create a new instance of the class settings */
            $this->a_obj_Settings = new Class_FootnotesSettings();
        }

        /* execute class function: init, admin_init and admin_menu */
        add_action('init', array($this, 'init'));
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    /**
     * activates the plugin
     * @since 1.0
     */
    static function activate()
    {
        // unused
    }

    /**
     * deactivates the plugin
     * @since 1.0
     */
	static function deactivate()
    {
        // unused
    }

    /**
     * uninstalls the plugin
     * updated file path in version 1.0.6
     * @since 1.0
     */
	static function uninstall()
    {
		/* uninstalling the plugin is only allowed for logged in users */
		if (!is_user_logged_in()) {
			wp_die(__('You must be logged in to run this script.', FOOTNOTES_PLUGIN_NAME));
		}

		/* current user needs the permission to (un)install plugins */
		if (!current_user_can('install_plugins')) {
			wp_die(__('You do not have permission to run this script.', FOOTNOTES_PLUGIN_NAME));
		}

		/*
		 * delete the settings container in the database
		 * @since 1.0.6
		 */
		delete_option(FOOTNOTE_SETTINGS_CONTAINER);
    }

    /**
     * initialize function
     * called in the class constructor
     * @since 1.0
     */
    function init()
    {
        // unused
    }

    /**
     * do admin init stuff
     * called in the class constructor
     * @since 1.0
     */
    function admin_init()
    {
        // unused
    }

    /**
     * do admin menu stuff
     * called in the class constructor
     * @since 1.0
     */
    function admin_menu()
    {
        // unused
    }

} /* class Class_Footnotes */