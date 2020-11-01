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
 * Edited for v2.0.0: Added jQueryUI following @vonpiernik   2020-10-26T1907+0100
 * Edited for v2.0.3: Added style sheet versioning   2020-10-29T1413+0100
 * Edited for v2.0.4: Enqueuing settings.css   2020-11-01T0317+0100
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
     * Updated for v2.0.0 by adding jQueryUI following vonpiernik (@vonpiernik).
     * See <https://wordpress.org/support/topic/tooltip-hover-not-showing/#post-13456762>
     * 
     * jQueryUI re-enables the tooltip infobox disabled when WPv5.5 was released.
     */
    public function registerPublic() {
        
        // Add jQueryUI:
        wp_register_script( 'jQueryUI', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', null, null, true );
        wp_enqueue_script( 'jQueryUI' );
        
        // IMPORTANT: up-to-date plugin version number for cache busting.
        wp_enqueue_style('mci-footnotes-css-public',   plugins_url('../css/public.css',   __FILE__), '', '2.0.4');
        wp_enqueue_style('mci-footnotes-css-settings', plugins_url('../css/settings.css', __FILE__), '', '2.0.4');
        
        // add the jQuery plugin (already registered by WordPress)
        wp_enqueue_script('jquery');
        
        // Finish adding jQueryUI:
        wp_enqueue_script('mci-footnotes-js-jquery-tools', plugins_url('../js/jquery.tools.min.js', __FILE__), ['jQueryUI']);
    }
}
