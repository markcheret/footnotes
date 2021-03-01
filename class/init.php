<?php
/**
 * Includes the main Class of the Plugin.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 12.09.14 10:56
 *
 *
 * @lastmodified 2021-02-19T2031+0100
 *
 * @since 1.6.5  Bugfix: Improve widgets registration, thanks to @felipelavinz code contribution.
 * @since 1.6.5  Update: Fix for deprecated PHP function create_function(), thanks to @psykonevro @daliasued bug reports, thanks to @felipelavinz code contribution.
 * @since 2.0.0  Update: Tooltips: fix disabling bug by loading jQuery UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
 *
 * @since 2.0.3  add versioning of public.css for cache busting   2020-10-29T1413+0100
 * @since 2.0.4  add jQuery UI from WordPress   2020-11-01T1902+0100
 * @since 2.1.4  automate passing version number for cache busting  2020-11-30T0646+0100
 * @since 2.1.4  optionally enqueue an extra stylesheet  2020-12-04T2231+0100
 *
 * @since 2.5.5  Update: Stylesheets: increase speed and energy efficiency by tailoring stylesheets to the needs of the instance, thanks to @docteurfitness design contribution.
 * @since 2.5.5  Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
 * @since 2.5.5  Bugfix: Libraries: optimize processes by loading external and internal scripts only if needed, thanks to @docteurfitness issue report.
 * @since 2.5.6  Bugfix: Reference container: optional alternative expanding and collapsing without jQuery for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
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
	 * Template process and script / stylesheet load optimization.
	 *
	 * - Bugfix: Templates: optimize template load and processing based on settings, thanks to @misfist code contribution.
	 *
	 * @since 2.4.0
	 * @date 2021-01-04T1355+0100
	 *
	 * @author Patrizia Lutz @misfist
	 *
	 * @link https://wordpress.org/support/topic/template-override-filter/#post-13864301
	 * @link https://github.com/misfist/footnotes/releases/tag/2.4.0d3 repository
	 * @link https://github.com/misfist/footnotes/compare/2.4.0%E2%80%A62.4.0d3 diff
	 *
	 * @var bool
	 *
	 * Streamline process depending on tooltip enabled status.
	 * Load tooltip inline script only if jQuery tooltips are enabled.
	 * Actual value depends on settings.
	 */
	public static $a_bool_TooltipsEnabled = false;
	public static $a_bool_AlternativeTooltipsEnabled = false;

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
	 * @since 2.0.0  Update: Tooltips: fix disabling bug by loading jQuery UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
	 * @since 2.0.3  add versioning of public.css for cache busting   2020-10-29T1413+0100
	 * @since 2.0.4  add jQuery UI from WordPress   2020-11-01T1902+0100
	 * @since 2.1.4  automate passing version number for cache busting  2020-11-30T0646+0100
	 * @since 2.1.4  optionally enqueue an extra stylesheet  2020-12-04T2231+0100
	 */
	public function registerPublic() {

		/**
		 * Enqueues external scripts.
		 *
		 * - Bugfix: Libraries: optimize processes by loading external and internal scripts only if needed, thanks to @docteurfitness issue report.
		 *
		 * @since 2.5.5
		 * @reporter @docteurfitness
		 * @link https://wordpress.org/support/topic/simply-speed-optimisation/
		 *
		 * The condition about tooltips was missing, only the not-alternative-tooltips part was present.
		 */
		// set conditions re-used for stylesheet enqueuing:
		self::$a_bool_TooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED ) );
		self::$a_bool_AlternativeTooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE ) );
		$l_str_ScriptMode = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE);

		/**
		 * Enqueues the jQuery library registered by WordPress.
		 *
		 * - Bugfix: Reference container: optional alternative expanding and collapsing without jQuery for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
		 *
		 * @since 2.5.6
		 *
		 * @reporter @hopper87it
		 * @link https://wordpress.org/support/topic/footnotes-wp-rocket/
		 * 
		 * jQuery is also used for animated scrolling, so it was loaded by default.
		 * The function wp_enqueue_script() avoids loading the same library multiple times.
		 * After adding the alternative reference container, jQuery has become optional,
		 * but still enabled by default.
		 */
		if ( $l_str_ScriptMode == 'jquery' || ( self::$a_bool_TooltipsEnabled && ! self::$a_bool_AlternativeTooltipsEnabled ) ) {
	
			wp_enqueue_script( 'jquery' );
			
		}

		if ( self::$a_bool_TooltipsEnabled && ! self::$a_bool_AlternativeTooltipsEnabled ) {

			/**
			 * Enqueues the jQuery Tools library shipped with the plugin.
			 *
			 * redacted jQuery.browser, completed minification;
			 * see full header in js/jquery.tools.js
			 * added versioning 2020-11-18T2150+0100
			 * not use '-js' in the handle, is appended automatically
			 */
			wp_enqueue_script(
				'mci-footnotes-jquery-tools',
				plugins_url('footnotes/js/jquery.tools.min.js'),
				array(),
				'1.2.7.redacted.2'
			);

			/**
			 * Registers jQuery UI from the JavaScript Content Delivery Network.
			 *
			 * - Update: Tooltips: fix disabling bug by loading jQuery UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
			 *
			 * @since 2.0.0
			 * Alternatively, fetch jQuery UI from cdnjs.cloudflare.com:
			 * @since 2.0.0  add jQueryUI from Cloudflare   2020-10-26T1907+0100
			 * Used to add jQuery UI following @vonpiernik:
			 * <https://wordpress.org/support/topic/tooltip-hover-not-showing/#post-13456762>:
			 *
			 *
			 * jQueryUI re-enables the tooltip infobox disabled when WPv5.5 was released.
			 *
			 * Updated for v2.0.4 by adding jQuery UI from WordPress following @check2020de:
			 * <https://wordpress.org/support/topic/gdpr-issue-with-jquery/>
			 * See <https://wordpress.stackexchange.com/questions/273986/correct-way-to-enqueue-jquery-ui>
			 *
			 * This was enabled in Footnotes v2.0.0 through v2.0.3.
			 * Re-added for 2.0.9d1 / 2.1.1d0 to look whether it can fix a broken tooltip display.   2020-11-07T1601+0100/2020-11-08T2246+0100
			 */
			//wp_register_script( 'jQueryUI', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', null, null, false ); // in header 2020-11-09T2003+0100
			//wp_enqueue_script( 'jQueryUI' );
			/**
			 * This is then needed instead of the above first instance:
			 * Add jQuery Tools and finish adding jQueryUI:   2020-11-08T1638+0100/2020-11-08T2246+0100
			 */
			//wp_enqueue_script('mci-footnotes-js-jquery-tools', plugins_url('../js/jquery.tools.min.js', __FILE__), ['jQueryUI']);

			/**
			 * Enqueues some jQuery UI libraries registered by WordPress.
			 *
			 * @since 2.0.4  add jQuery UI from WordPress   2020-11-01T1902+0100
			 * If alternative tooltips are enabled, these libraries are not needed.
			 */
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-widget' );
			wp_enqueue_script( 'jquery-ui-position' );
			wp_enqueue_script( 'jquery-ui-tooltip' );

		}

		/**
		 * Enables enqueuing a new-scheme stylesheet.
		 *
		 * @since 2.5.5
		 * @date 2021-02-14T1512+0100
		 *
		 * Enables enqueuing the formatted individual stylesheets if false.
		 * WARNING: This facility is designed for development and must NOT be used in production.
		 *
		 * The Boolean may be set at the bottom of the plugin’s main PHP file.
		 * @see footnotes.php
		 */
		if ( C_BOOL_CSS_PRODUCTION_MODE === true ) {

			/**
			 * Enqueues a minified united external stylesheet in production.
			 *
			 * - Update: Stylesheets: increase speed and energy efficiency by tailoring stylesheets to the needs of the instance, thanks to @docteurfitness design contribution.
			 * - Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
			 *
			 * @since 2.5.5
			 * @date 2021-02-14T1543+0100
			 *
			 * @contributor @docteurfitness
			 * @link https://wordpress.org/support/topic/simply-speed-optimisation/
			 *
			 * @reporter @docteurfitness
			 * @link https://wordpress.org/support/topic/simply-speed-optimisation/
			 *
			 * The dashboard stylesheet is minified as-is.
			 * @see class/dashboard/layout.php
			 *
			 * @since 2.0.3  add versioning of public.css for cache busting.
			 * @date 2020-10-29T1413+0100
			 * Plugin version number is needed for busting browser caches after each plugin update.
			 * @since 2.1.4  automate passing version number for cache busting.
			 * @date 2020-11-30T0646+0100
			 * The constant C_STR_FOOTNOTES_VERSION is defined at start of footnotes.php.
			 *
			 * The media scope argument 'all' is the default.
			 * No need to use '-css' in the handle, as this is appended automatically.
			 */
			// set tooltip mode for use in stylesheet name:
			if ( self::$a_bool_TooltipsEnabled ) {
				if ( self::$a_bool_AlternativeTooltipsEnabled ) {
					$l_str_TooltipMode = 'al';
					$l_str_TComplement =   'ternative-tooltips';
				} else {
					$l_str_TooltipMode = 'jq';
					$l_str_TComplement =   'uery-tooltips';
				}
			} else {
				$l_str_TooltipMode = 'no';
				$l_str_TComplement =   '-tooltips';
			}

			// set basic responsive page layout mode for use in stylesheet name:
			$l_str_PageLayoutOption = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT);
			switch ( $l_str_PageLayoutOption ) {
				case "reference-container": $l_str_LayoutMode = '1'; break;
				case "entry-content"      : $l_str_LayoutMode = '2'; break;
				case "main-content"       : $l_str_LayoutMode = '3'; break;
				case "none":       default: $l_str_LayoutMode = '0'; break;
			}

			// enqueue the tailored united minified stylesheet:
			wp_enqueue_style(
				'mci-footnotes-' . $l_str_TooltipMode . $l_str_TComplement . '-pagelayout-' . $l_str_PageLayoutOption,
				plugins_url(
					MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/footnotes-' . $l_str_TooltipMode . 'ttbrpl' . $l_str_LayoutMode . '.min.css'
				),
				array(),
				C_STR_FOOTNOTES_VERSION,
				'all'
			);

		} else {

			/**
			 * Enqueues external stylesheets, ONLY in development now.
			 *
			 * @since 2.1.4  optionally enqueue an extra stylesheet.
			 * @date 2020-12-04T2231+0100
			 *
			 * This optional layout fix is useful by lack of layout support.
			 */
			wp_enqueue_style( 'mci-footnotes-common', plugins_url( MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/dev-common.css' ), array(), C_STR_FOOTNOTES_VERSION );
			wp_enqueue_style( 'mci-footnotes-tooltips', plugins_url( MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/dev-tooltips.css' ), array(), C_STR_FOOTNOTES_VERSION );
			wp_enqueue_style( 'mci-footnotes-alternative', plugins_url( MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/dev-tooltips-alternative.css' ), array(), C_STR_FOOTNOTES_VERSION );

			$l_str_PageLayoutOption = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT);
			if ($l_str_PageLayoutOption != 'none') {
				wp_enqueue_style(
					'mci-footnotes-layout-' . $l_str_PageLayoutOption,
					plugins_url(
						MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/dev-layout-' . $l_str_PageLayoutOption . '.css'
					),
					array(),
					C_STR_FOOTNOTES_VERSION,
					'all'
				);
			}
		}
	}
}
