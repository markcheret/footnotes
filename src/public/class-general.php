<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package footnotes
 * @since 2.8.0
 */

namespace footnotes\general;

use footnotes\includes as Includes;

/**
 * Class provide all public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and enqueues all public-facing stylesheets
 * and JavaScript.
 *
 * @package footnotes
 * @since 2.8.0
 */
class General {

	/**
	 * The ID of this plugin.
	 *
	 * @since  2.8.0

	 * @access  private
	 * @var  string  $plugin_name  The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  2.8.0

	 * @access  private
	 * @var  string  $version  The current version of this plugin.
	 */
	private $version;

	/**
	 * The reference container widget.
	 *
	 * @since  2.8.0
	 *
	 * @var  Widget\Reference_Container  $reference_container_widget  The reference container widget
	 */
	private $reference_container_widget;

	/**
	 * The footnote parser.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 *
	 * @var  Parser  $task  The Plugin task.
	 */
	public $a_obj_task = null;

	/**
	 * Flag for using tooltips.
	 *
	 * @since  2.4.0
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 *
	 * @var  bool  $tooltips_enabled  Whether tooltips are enabled or not.
	 */
	public static $a_bool_tooltips_enabled = false;

	/**
	 * Allows to determine whether alternative tooltips are enabled.
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 *
	 * @var  bool
	 */
	public static $a_bool_alternative_tooltips_enabled = false;

	/**
	 * Allows to determine whether AMP compatibility mode is enabled.
	 *
	 * @since  2.6.0
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 *
	 * @var  bool
	 */
	public static $a_bool_amp_enabled = false;

	/**
	 * Allows to determine the script mode among jQuery or plain JS.
	 *
	 * @since  2.5.6
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 *
	 * @var  string  ‘js’ to use plain JavaScript, ‘jquery’ to use jQuery.
	 */
	public static $a_str_script_mode = 'js';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  2.8.0
	 * @param  string $plugin_name  The name of this plugin.
	 * @param  string $version  The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->load_dependencies();

		// Set conditions re-used for stylesheet enqueuing and in class/task.php.
		self::$a_bool_amp_enabled                  = Includes\Convert::to_bool( Includes\Settings::instance()->get( Includes\Settings::C_STR_FOOTNOTES_AMP_COMPATIBILITY_ENABLE ) );
		self::$a_bool_tooltips_enabled             = Includes\Convert::to_bool( Includes\Settings::instance()->get( Includes\Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ENABLED ) );
		self::$a_bool_alternative_tooltips_enabled = Includes\Convert::to_bool( Includes\Settings::instance()->get( Includes\Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE ) );
		self::$a_str_script_mode                   = Includes\Settings::instance()->get( Includes\Settings::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE );
	}

	/**
	 * Load the required public-facing dependencies.
	 *
	 * Include the following files that provide the public-facing functionality
	 * of this plugin:
	 *
	 * - {@see Parser}: parses Posts and Pages for footnote shortcodes; and
	 * - {@see Widget\Reference_Container}: defines the Reference Container widget.
	 *
	 * @since  2.8.0
	 */
	private function load_dependencies() {
		// TODO: neaten up and document once placements and names are settled.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-config.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-convert.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-parser.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/widget/class-reference-container.php';

		$this->reference_container_widget = new Widget\Reference_Container( $this->plugin_name );

		$this->a_obj_task = new Parser();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * Enables enqueuing the formatted individual stylesheets if {@see PRODUCTION_ENV}
	 * is `true`.
	 *
	 * @since  1.5.0
	 * @since  2.5.5  Change stylesheet schema.
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 */
	public function enqueue_styles() {
		if ( PRODUCTION_ENV ) {
			// Set tooltip mode for use in stylesheet name.
			if ( self::$a_bool_tooltips_enabled ) {

				if ( self::$a_bool_amp_enabled ) {
					$l_str_tooltip_mode_short = 'ampt';
					$l_str_tooltip_mode_long  = 'amp-tooltips';

				} elseif ( self::$a_bool_alternative_tooltips_enabled ) {
					$l_str_tooltip_mode_short = 'altt';
					$l_str_tooltip_mode_long  = 'alternative-tooltips';

				} else {
					$l_str_tooltip_mode_short = 'jqtt';
					$l_str_tooltip_mode_long  = 'jquery-tooltips';

				}
			} else {
				$l_str_tooltip_mode_short = 'nott';
				$l_str_tooltip_mode_long  = 'no-tooltips';
			}

			// Set basic responsive page layout mode for use in stylesheet name.
			$l_str_page_layout_option = Includes\Settings::instance()->get( Includes\Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT );
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

			// Enqueue the tailored united minified stylesheet.
			wp_enqueue_style(
				"footnotes-{$l_str_tooltip_mode_long}-pagelayout-{$l_str_page_layout_option}",
				plugin_dir_url( __FILE__ ) . "css/footnotes-{$l_str_tooltip_mode_short}brpl{$l_str_layout_mode}.min.css",
				array(),
				( PRODUCTION_ENV ) ? $this->version : filemtime(
					plugin_dir_path(
						dirname( __FILE__ )
					) . "css/footnotes-{$l_str_tooltip_mode_short}brpl{$l_str_layout_mode}.min.css"
				),
				'all'
			);
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since  1.5.0
	 * @since  2.0.0  Add jQueryUI dependency.
	 * @since  2.1.2  Add jQuery Tools dependency.
	 * @since  2.5.6  Add jQuery dependency.
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 */
	public function enqueue_scripts() {
		/*
		 * Enqueues the jQuery library registered by WordPress.
		 *
		 * As jQuery is also used for animated scrolling, it was loaded by default.
		 * The function `wp_enqueue_script()` avoids loading the same library multiple times.
		 * After adding the alternative reference container, jQuery has become optional,
		 * but still enabled by default.
		 */
		if ( ! self::$a_bool_amp_enabled ) {

			if ( 'jquery' === self::$a_str_script_mode || ( self::$a_bool_tooltips_enabled && ! self::$a_bool_alternative_tooltips_enabled ) ) {

				wp_enqueue_script( 'jquery' );

			}

			if ( self::$a_bool_tooltips_enabled && ! self::$a_bool_alternative_tooltips_enabled ) {
				/*
				 * Enqueues the jQuery Tools library shipped with the plugin.
				 *
				 * Redacted `jQuery.browser`, completed minification;
				 * see full header in `public/js/jquery.tools.js`.
				 * No ‘-js’ in the handle, is appended automatically.
				 * Deferring to the footer breaks jQuery tooltip display.
				 */
				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/jquery.tools' . ( ( PRODUCTION_ENV ) ? '.min' : '' ) . '.js', array(), '1.2.7.redacted.2', false );

				/*
				 * Enqueues some jQuery UI libraries registered by WordPress.
				 *
				 * If alternative tooltips are enabled, these libraries are not needed.
				 */
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-widget' );
				wp_enqueue_script( 'jquery-ui-position' );
				wp_enqueue_script( 'jquery-ui-tooltip' );

			}
		}

	}

	/**
	 * Register the widget(s) for the public-facing side of the site.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see Includes\Public}.
	 */
	public function register_widgets() {
		register_widget( $this->reference_container_widget );
	}
}

