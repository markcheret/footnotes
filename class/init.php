<?php
/**
 * Includes the main Class of the Plugin.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0 12.09.14 10:56
 *
 * @lastmodified 2021-02-19T2031+0100
 *
 * @since 1.6.5  Bugfix: Improve widgets registration, thanks to @felipelavinz code contribution.
 * @since 1.6.5  Update: Fix for deprecated PHP function create_function(), thanks to @psykonevro @daliasued bug reports, thanks to @felipelavinz code contribution.
 * @since 2.0.0  Update: Tooltips: fix disabling bug by loading j_query UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
 *
 * @since 2.0.3  add versioning of public.css for cache busting   2020-10-29T1413+0100
 * @since 2.0.4  add j_query UI from WordPress   2020-11-01T1902+0100
 * @since 2.1.4  automate passing version number for cache busting  2020-11-30T0646+0100
 * @since 2.1.4  optionally enqueue an extra stylesheet  2020-12-04T2231+0100
 *
 * @since 2.5.5  Update: Stylesheets: increase speed and energy efficiency by tailoring stylesheets to the needs of the instance, thanks to @docteurfitness design contribution.
 * @since 2.5.5  Bugfix: Stylesheets: minify to shrink the carbon footprint, increase speed and implement best practice, thanks to @docteurfitness issue report.
 * @since 2.5.5  Bugfix: Libraries: optimize processes by loading external and internal scripts only if needed, thanks to @docteurfitness issue report.
 * @since 2.5.6  Bugfix: Reference container: optional alternative expanding and collapsing without j_query for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
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
	public $a_obj_task = null;

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
	 * Load tooltip inline script only if j_query tooltips are enabled.
	 * Actual value depends on settings.
	 */
	public static $a_bool_tooltips_enabled = false;
	public static $a_bool_alternative_tooltips_enabled = false;

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
	 * @see self::initialize_widgets()
	 */
	public function run() {
		// Register language.
		MCI_Footnotes_Language::register_hooks();
		// Register Button hooks.
		MCI_Footnotes_WYSIWYG::register_hooks();
		// Register general hooks.
		MCI_Footnotes_Hooks::register_hooks();

		// Initialize the Plugin Dashboard.
		$this->initialize_dashboard();
		// Initialize the Plugin Task.
		$this->initialize_task();

		// Register all Public Stylesheets and Scripts.
		add_action( 'init', array( $this, 'register_public' ) );
		// Enqueue all Public Stylesheets and Scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_public' ) );
		// Register all Widgets of the Plugin..
		add_action( 'widgets_init', array( $this, 'initialize_widgets' ) );
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
	 * Also, the visibility of initialize_widgets() is not private any longer.
	 */
	public function initialize_widgets() {
		register_widget( 'MCI_Footnotes_Widget_Reference_container' );
	}

	/**
	 * Initializes the Dashboard of the Plugin and loads them.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function initialize_dashboard() {
		new MCI_Footnotes_Layout_Init();
	}

	/**
	 * Initializes the Plugin Task and registers the Task hooks.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function initialize_task() {
		$this->a_obj_task = new MCI_Footnotes_Task();
		$this->a_obj_task->register_hooks();
	}

	/**
	 * Registers and enqueues scripts and stylesheets to the public pages.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 *
	 * @since 2.0.0  Update: Tooltips: fix disabling bug by loading j_query UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
	 * @since 2.0.3  add versioning of public.css for cache busting   2020-10-29T1413+0100
	 * @since 2.0.4  add j_query UI from WordPress   2020-11-01T1902+0100
	 * @since 2.1.4  automate passing version number for cache busting  2020-11-30T0646+0100
	 * @since 2.1.4  optionally enqueue an extra stylesheet  2020-12-04T2231+0100
	 */
	public function register_public() {

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
		// Set conditions re-used for stylesheet enqueuing:.
		self::$a_bool_tooltips_enabled = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED ) );
		self::$a_bool_alternative_tooltips_enabled = MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE ) );
		$l_str_script_mode = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE );

		/**
		 * Enqueues the j_query library registered by WordPress.
		 *
		 * - Bugfix: Reference container: optional alternative expanding and collapsing without j_query for use with hard links, thanks to @hopper87it @pkverma99 issue reports.
		 *
		 * @since 2.5.6
		 *
		 * @reporter @hopper87it
		 * @link https://wordpress.org/support/topic/footnotes-wp-rocket/
		 *
		 * j_query is also used for animated scrolling, so it was loaded by default.
		 * The function wp_enqueue_script() avoids loading the same library multiple times.
		 * After adding the alternative reference container, j_query has become optional,
		 * but still enabled by default.
		 */
		if ( $l_str_script_mode == 'jquery' || ( self::$a_bool_tooltips_enabled && ! self::$a_bool_alternative_tooltips_enabled ) ) {

			wp_enqueue_script( 'jquery' );

		}

		if ( self::$a_bool_tooltips_enabled && ! self::$a_bool_alternative_tooltips_enabled ) {

			/**
			 * Enqueues the j_query Tools library shipped with the plugin.
			 *
			 * redacted j_query.browser, completed minification;
			 * see full header in js/jquery.tools.js
			 * added versioning 2020-11-18T2150+0100
			 * not use '-js' in the handle, is appended automatically
			 */
			wp_enqueue_script(
				'mci-footnotes-jquery-tools',
				plugins_url( 'footnotes/js/jquery.tools.min.js' ),
				array(),
				'1.2.7.redacted.2'
			);

			/**
			 * Registers j_query UI from the Java_script Content Delivery Network.
			 *
			 * - Update: Tooltips: fix disabling bug by loading j_query UI library, thanks to @rajinderverma @ericcorbett2 @honlapdavid @mmallett bug reports, thanks to @vonpiernik code contribution.
			 *
			 * @since 2.0.0
			 * Alternatively, fetch j_query UI from cdnjs.cloudflare.com:
			 * @since 2.0.0  add j_query_uI from Cloudflare   2020-10-26T1907+0100
			 * Used to add j_query UI following @vonpiernik:
			 * <https://wordpress.org/support/topic/tooltip-hover-not-showing/#post-13456762>:
			 *
			 *
			 * j_query_uI re-enables the tooltip infobox disabled when WPv5.5 was released.
			 *
			 * Updated for v2.0.4 by adding j_query UI from WordPress following @check2020de:
			 * <https://wordpress.org/support/topic/gdpr-issue-with-jquery/>
			 * See <https://wordpress.stackexchange.com/questions/273986/correct-way-to-enqueue-jquery-ui>
			 *
			 * This was enabled in Footnotes v2.0.0 through v2.0.3.
			 * Re-added for 2.0.9d1 / 2.1.1d0 to look whether it can fix a broken tooltip display.   2020-11-07T1601+0100/2020-11-08T2246+0100
			 */
			// Wp_register_script( 'j_query_uI', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', null, null, false ); // In header 2020-11-09T2003+0100.
			// Wp_enqueue_script( 'j_query_uI' );.
			/**
			 * This is then needed instead of the above first instance:
			 * Add j_query Tools and finish adding j_query_uI:   2020-11-08T1638+0100/2020-11-08T2246+0100
			 */
			// Wp_enqueue_script('mci-footnotes-js-jquery-tools', plugins_url('../js/jquery.tools.min.js', __FILE__), ['j_query_uI']);.

			/**
			 * Enqueues some j_query UI libraries registered by WordPress.
			 *
			 * @since 2.0.4  add j_query UI from WordPress   2020-11-01T1902+0100
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
			// Set tooltip mode for use in stylesheet name:.
			if ( self::$a_bool_tooltips_enabled ) {
				if ( self::$a_bool_alternative_tooltips_enabled ) {
					$l_str_tooltip_mode = 'al';
					$l_str_tcomplement = 'ternative-tooltips';
				} else {
					$l_str_tooltip_mode = 'jq';
					$l_str_tcomplement = 'uery-tooltips';
				}
			} else {
				$l_str_tooltip_mode = 'no';
				$l_str_tcomplement = '-tooltips';
			}

			// Set basic responsive page layout mode for use in stylesheet name:.
			$l_str_page_layout_option = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT );
			switch ( $l_str_page_layout_option ) {
				case 'reference-container':
					$l_str_layout_mode = '1';
					break;
				case 'entry-content':
					$l_str_layout_mode = '2';
					break;
				case 'main-content':
					$l_str_layout_mode = '3';
					break;
				case 'none':
				default:
					$l_str_layout_mode = '0';
					break;
			}

			// Enqueue the tailored united minified stylesheet:.
			wp_enqueue_style(
				'mci-footnotes-' . $l_str_tooltip_mode . $l_str_tcomplement . '-pagelayout-' . $l_str_page_layout_option,
				plugins_url(
					MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/footnotes-' . $l_str_tooltip_mode . 'ttbrpl' . $l_str_layout_mode . '.min.css'
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

			$l_str_page_layout_option = MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT );
			if ( $l_str_page_layout_option != 'none' ) {
				wp_enqueue_style(
					'mci-footnotes-layout-' . $l_str_page_layout_option,
					plugins_url(
						MCI_Footnotes_Config::C_STR_PLUGIN_NAME . '/css/dev-layout-' . $l_str_page_layout_option . '.css'
					),
					array(),
					C_STR_FOOTNOTES_VERSION,
					'all'
				);
			}
		}
	}
}
