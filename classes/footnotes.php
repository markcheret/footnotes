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

        /* register hook for activating the plugin */
        register_activation_hook(__FILE__, array($this, 'activate'));
        /* register hook for deactivating the plugin */
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        /* register hook for uninstalling the plugin */
        register_uninstall_hook(__FILE__, array($this, 'uninstall'));
    }

    /**
     * activates the plugin
     * @since 1.0
     */
    function activate()
    {
        // unused
    }

    /**
     * deactivates the plugin
     * @since 1.0
     */
    function deactivate()
    {
        // unused
    }

    /**
     * uninstalls the plugin
     * updated file path in version 1.0.6
     * @since 1.0
     */
    function uninstall()
    {
        require_once(dirname(__FILE__) . '/../includes/uninstall.php');
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