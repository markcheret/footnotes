<?php
/**
 * Includes the main Class of the Plugin.
 * 
 * IMPORTANT: In registerPublic(), keep plugin version # up to date for cache busting.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 12.09.14 10:56
 * 
 * Edited for v2.0.0: Added jQueryUI from CDN   2020-10-26T1907+0100
 * Edited for v2.0.3: Added style sheet versioning   2020-10-29T1413+0100
 * Edited for v2.0.4: Added jQuery UI from WordPress   2020-11-01T1902+0100
 * 
 * Last modified:   2020-11-05T1824+0100
 */


/**
 * Entry point of the Plugin. Loads the Dashboard and executes the Task.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes {

    /**
     * Reference to the Plugin Task object.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @var null|MCI_Footnotes_Task
     */
    public $a_obj_Task = null;

    /**
     * Executes the Plugin.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    public function run() {
            // register language
        MCI_Footnotes_Language::registerHooks();
        // register Button hooks
        MCI_Footnotes_WYSIWYG::registerHooks();
        // register general hooks
        MCI_Footnotes_Hooks::registerHooks();
        
        // initialize the Plugin Dashboard
        $this->initializeDashboard();
        // initialize the Plugin Task
        $this->initializeTask();
        
        // Register all Public Stylesheets and Scripts
        add_action('init', array($this, 'registerPublic'));
        // Enqueue all Public Stylesheets and Scripts
        add_action('wp_enqueue_scripts', array($this, 'registerPublic'));
        // Register all Widgets of the Plugin.
        add_action('widgets_init', array($this, 'initializeWidgets'));
    }

    /**
     * Initializes all Widgets of the Plugin.
     *
     * @author Stefan Herndler
     * @since 1.5.0
	 * 
	 * Edited for 1.6.5: replaced deprecated function create_function()
	 * 
	 * Contributed by Felipe Lavín Z.   Thankfully acknowledged.
	 * 
	 * create_function() was deprecated in PHP 7.2:
	 * <https://wordpress.org/support/topic/deprecated-in-php-7-2-function-create_function-is-deprecated/>
	 * See also: <https://wordpress.org/support/topic/deprecated-function-create_function-14/>
     */
    public function initializeWidgets() {
      register_widget("MCI_Footnotes_Widget_ReferenceContainer");
    }

    /**
     * Initializes the Dashboard of the Plugin and loads them.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    private function initializeDashboard() {
        new MCI_Footnotes_Layout_Init();
    }

    /**
     * Initializes the Plugin Task and registers the Task hooks.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     */
    private function initializeTask() {
        $this->a_obj_Task = new MCI_Footnotes_Task();
        $this->a_obj_Task->registerHooks();
    }

    /**
     * Registers and enqueues scripts and stylesheets to the public pages.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * 
     * Updated for v2.0.4 by adding jQueryUI from WordPress following @check2020de:
     * <https://wordpress.org/support/topic/gdpr-issue-with-jquery/>
     * See <https://wordpress.stackexchange.com/questions/273986/correct-way-to-enqueue-jquery-ui>
     * 
     * jQueryUI re-enables the tooltip infobox disabled when WPv5.5 was released.
     */
    public function registerPublic() {
        
        // add the jQuery plugin (already registered by WordPress)
        wp_enqueue_script( 'jquery' );
        // Add jQueryUI: 'no need to enqueue -core, because dependencies are set'
        wp_enqueue_script( 'jquery-ui-widget' );
        wp_enqueue_script( 'jquery-ui-mouse' );
        wp_enqueue_script( 'jquery-ui-accordion' );
        wp_enqueue_script( 'jquery-ui-autocomplete' );
        wp_enqueue_script( 'jquery-ui-slider' );
        
        // Add jQuery tools:
        wp_enqueue_script('mci-footnotes-js-jquery-tools', plugins_url('../js/jquery.tools.min.js', __FILE__));
        
        // IMPORTANT: up-to-date plugin version number for cache busting.
        wp_enqueue_style('mci-footnotes-css-public',   plugins_url('../css/public.css',   __FILE__), '', '2.0.6');
    }
}
