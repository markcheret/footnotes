<?php
/**
 * Includes the main Class of the Plugin.
 *
 * ******************************************************************************************************
 * IMPORTANT: In registerPublic() line 163: Please keep plugin version # up to date for cache busting.  *
 *            Also in class/dashboard/layout:210 for settings.css                                       *
 * ******************************************************************************************************
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 12.09.14 10:56
 *
 * Edited for v1.6.5: Replaced deprecated function create_function()
 * Edited for v2.0.0: Added jQueryUI from Cloudflare   2020-10-26T1907+0100
 * Edited for v2.0.3: Added style sheet versioning   2020-10-29T1413+0100
 * Edited for v2.0.4: Added jQuery UI from WordPress   2020-11-01T1902+0100
 *
 * Continual update of version number for cache busting.
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
     * Updated for v2.0.0 adding jQuery UI
     * Updated for v2.0.4 by adding jQuery UI from WordPress following @check2020de:
     * <https://wordpress.org/support/topic/gdpr-issue-with-jquery/>
     * See <https://wordpress.stackexchange.com/questions/273986/correct-way-to-enqueue-jquery-ui>
     *
     * jQueryUI re-enables the tooltip infobox disabled when WPv5.5 was released.
     */
    public function registerPublic() {

        //###  SCRIPTS

        // These are only enqueued if the jQuery tooltips are enabled.
        // If alternative tooltips are enabled, these libraries are not needed.
        // Scroll animation doesn’t seem to need even jQuery Core or it gets it from elsewhere.

        if (!MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE))) {

            // enqueue the jQuery plugin registered by WordPress:
            wp_enqueue_script( 'jquery' );

            // enqueue jQuery UI libraries registered by WordPress, needed for tooltips:
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-widget' );
            wp_enqueue_script( 'jquery-ui-position' );
            wp_enqueue_script( 'jquery-ui-tooltip' );

            // enqueue jQuery Tools:                            redacted jQuery.browser, completed minification; added versioning 2020-11-18T2150+0100
            wp_enqueue_script('mci-footnotes-js-jquery-tools', plugins_url('../js/jquery.tools.min.js', __FILE__), '', '2.1.1');


            // Alternatively, fetch jQuery UI from cdnjs.cloudflare.com:
            // Used to add jQuery UI following @vonpiernik:
            // <https://wordpress.org/support/topic/tooltip-hover-not-showing/#post-13456762>:
            // This was enabled in Footnotes v2.0.0 through v2.0.3.
            // Re-added for 2.0.9d1 / 2.1.1d0 to look whether it can fix a broken tooltip display.   2020-11-07T1601+0100/2020-11-08T2246+0100
            //wp_register_script( 'jQueryUI', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', null, null, false ); // in header 2020-11-09T2003+0100
            //wp_enqueue_script( 'jQueryUI' );
            // This is then needed instead of the above first instance:
            // Add jQuery Tools and finish adding jQueryUI:   2020-11-08T1638+0100/2020-11-08T2246+0100
            //wp_enqueue_script('mci-footnotes-js-jquery-tools', plugins_url('../js/jquery.tools.min.js', __FILE__), ['jQueryUI']);

        }


        //###  STYLES

        // IMPORTANT: up-to-date plugin version number NEEDED FOR CACHE BUSTING:
        wp_enqueue_style(
            'mci-footnotes-css-public',
            plugins_url('../css/public.css', __FILE__),
            '',
            '2.1.4d3'
        );
    }

}
