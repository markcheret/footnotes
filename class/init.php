<?php
/**
 * Includes the main Class of the Plugin.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 12.09.14 10:56
 *
 *
 * @lastmodified 2021-02-11T0816+0100
 *
 * @since 1.6.5  Bugfix: Improve widgets registration, thanks to @felipelavinz code contribution.
 * @since 1.6.5  Update: Fix for deprecated PHP function create_function(), thanks to @psykonevro @daliasued bug reports, thanks to @felipelavinz code contribution.
 * @since 2.0.0  Update: Tooltips: fix disabling bug by loading jQuery UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
 *
 * @since 2.0.3  add versioning of public.css for cache busting   2020-10-29T1413+0100
 * @since 2.0.4  add jQuery UI from WordPress   2020-11-01T1902+0100
 * @since 2.1.4  automate passing version number for cache busting  2020-11-30T0646+0100
 * @since 2.1.4  optionally enqueue an extra style sheet  2020-12-04T2231+0100
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
     *
     *
     * - Bugfix: Improve widgets registration, thanks to @felipelavinz code contribution.
     *
     * @since 1.6.5
     *
     * @contributor @felipelavinz
     * @link https://github.com/media-competence-institute/footnotes/commit/87173d2980c7ff90e12ffee94ca7153e11163793
     *
     * @see self::initializeWidgets()
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
     *
     * - Update: Fix for deprecated PHP function create_function(), thanks to @psykonevro @daliasued bug reports, thanks to @felipelavinz code contribution
     *
     * @since 1.6.5
     *
     * @contributor @felipelavinz
     * @link https://github.com/media-competence-institute/footnotes/commit/87173d2980c7ff90e12ffee94ca7153e11163793
     *
     * @reporter @psykonevro
     * @link https://wordpress.org/support/topic/bug-function-create_function-is-deprecated/
     * @link https://wordpress.org/support/topic/deprecated-function-create_function-14/
     *
     * @reporter @daliasued
     * @link https://wordpress.org/support/topic/deprecated-function-create_function-14/#post-13312853
     *
     * create_function() was deprecated in PHP 7.2.0 and removed in PHP 8.0.0.
     * @link https://www.php.net/manual/en/function.create-function.php
     *
     * The fix is to move add_action() above into run(),
     * and use the bare register_widget() here.
     * @see self::run()
     *
     * Also, the visibility of initializeWidgets() is not private any longer.
     */
    public function initializeWidgets() {
      register_widget( "MCI_Footnotes_Widget_ReferenceContainer" );
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
     *
     * - Update: Tooltips: fix disabling bug by loading jQuery UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
     *
     * @since 2.0.0
     * Updated for v2.0.4 by adding jQuery UI from WordPress following @check2020de:
     * <https://wordpress.org/support/topic/gdpr-issue-with-jquery/>
     * See <https://wordpress.stackexchange.com/questions/273986/correct-way-to-enqueue-jquery-ui>
     *
     * jQueryUI re-enables the tooltip infobox disabled when WPv5.5 was released.
     * @since 2.0.0  Update: Tooltips: fix disabling bug by loading jQuery UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
     * @since 2.0.3  add versioning of public.css for cache busting   2020-10-29T1413+0100
     * @since 2.0.4  add jQuery UI from WordPress   2020-11-01T1902+0100
     * @since 2.1.4  automate passing version number for cache busting  2020-11-30T0646+0100
     * @since 2.1.4  optionally enqueue an extra style sheet  2020-12-04T2231+0100
     */
    public function registerPublic() {

        //###  SCRIPTS

        // These are only enqueued if the jQuery tooltips are enabled.
        // If alternative tooltips are enabled, these libraries are not needed.
        // Scroll animation doesn’t seem to need even jQuery Core or it gets it from elsewhere.
        // @since 2.0.0  add jQueryUI from Cloudflare   2020-10-26T1907+0100
        // @since 2.0.3  add versioning of public.css for cache busting   2020-10-29T1413+0100
        // @since 2.0.4  add jQuery UI from WordPress   2020-11-01T1902+0100
        // @since 2.1.4  automate passing version number for cache busting  2020-11-30T0646+0100
        // @since 2.1.4  optionally enqueue an extra style sheet  2020-12-04T2231+0100

        if (!MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE))) {

            // enqueue the jQuery plugin registered by WordPress:
            wp_enqueue_script( 'jquery' );

            // enqueue jQuery UI libraries registered by WordPress, needed for tooltips:
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-widget' );
            wp_enqueue_script( 'jquery-ui-position' );
            wp_enqueue_script( 'jquery-ui-tooltip' );

            // enqueue jQuery Tools:
            // redacted jQuery.browser, completed minification;
            // see full header in js/jquery.tools.js
            // added versioning 2020-11-18T2150+0100
            // not use '-js' in the handle, is appended automatically
            wp_enqueue_script(
                'mci-footnotes-jquery-tools',
                plugins_url('footnotes/js/jquery.tools.min.js'),
                array(),
                '1.2.7.redacted.2'
            );


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

        // up-to-date plugin version number needed for cache busting:
        // not use '-css' in the handle, is appended automatically;
        // constant C_STR_FOOTNOTES_VERSION defined in footnotes.php, media all is default
        wp_enqueue_style(
            'mci-footnotes-public',
            plugins_url(
                MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/public.css'
            ),
            array(),
            C_STR_FOOTNOTES_VERSION,
            'all'
        );

        // optional layout fix by lack of layout support:
        // since 2.1.4   2020-12-05T1417+0100
        $l_str_LayoutOption = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT);
        if ($l_str_LayoutOption != 'none') {
            wp_enqueue_style(
                'mci-footnotes-layout-' . $l_str_LayoutOption,
                plugins_url(
                    MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/layout-' . $l_str_LayoutOption . '.css'
                ),
                array(),
                C_STR_FOOTNOTES_VERSION,
                'all'
            );
        }
    }
}
