<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\general;
		
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/settings/general/class-reference-container-settings-group.php';

use footnotes\includes\{Footnotes, Convert, Settings};

use const footnotes\includes\settings\general\ReferenceContainerSettingsGroup\{
	FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE,
	FOOTNOTES_PAGE_LAYOUT_SUPPORT
};

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
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  2.8.0

	 * @access  private
	 * @var  string  $version  The current version of this plugin.
	 */
	private string $version;

	/**
	 * The reference container widget.
	 *
	 * @since  2.8.0
	 *
	 * @var  Widget\Reference_Container  $reference_container_widget  The reference container widget
	 */
	private Widget\Reference_Container $reference_container_widget;

	/**
	 * The footnote parser.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 * @todo Review null init.
	 *
	 * @var  Parser  $task  The Plugin task.
	 */
	public ?Parser $task = null;

	/**
	 * Flag for using tooltips.
	 *
	 * @since  2.4.0
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 *
	 * @var  bool  $tooltips_enabled  Whether tooltips are enabled or not.
	 */
	public static $tooltips_enabled = false;

	/**
	 * Allows to determine whether alternative tooltips are enabled.
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 *
	 * @var  bool
	 */
	public static $alternative_tooltips_enabled = false;

	/**
	 * Allows to determine whether AMP compatibility mode is enabled.
	 *
	 * @since  2.6.0
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 *
	 * @var  bool
	 */
	public static $amp_enabled = false;

	/**
	 * Allows to determine the script mode among jQuery or plain JS.
	 *
	 * @since  2.5.6
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 *
	 * @var  string  ‘js’ to use plain JavaScript, ‘jquery’ to use jQuery.
	 */
	public static $script_mode = 'js';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  2.8.0
	 * @param  string $plugin_name  The name of this plugin.
	 * @param  string $version  The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->load_dependencies();

		// Set conditions re-used for stylesheet enqueuing and in class/task.php.
		self::$amp_enabled                  = Convert::to_bool( Settings::instance()->get( Settings::FOOTNOTES_AMP_COMPATIBILITY_ENABLE ) );
		self::$tooltips_enabled             = Convert::to_bool( Settings::instance()->get( Settings::FOOTNOTES_MOUSE_OVER_BOX_ENABLED ) );
		self::$alternative_tooltips_enabled = Convert::to_bool( Settings::instance()->get( Settings::FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE ) );
		self::$script_mode                  = Settings::instance()->get( 'foo'/*FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE*/ );
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
	private function load_dependencies(): void {
		// TODO: neaten up and document once placements and names are settled.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-config.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-convert.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-parser.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/widget/class-reference-container.php';

		$this->reference_container_widget = new Widget\Reference_Container( $this->plugin_name );

		$this->task = new Parser();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * Enables enqueuing the formatted individual stylesheets if {@see PRODUCTION_ENV}
	 * is `true`.
	 *
	 * @since  1.5.0
	 * @since  2.5.5  Change stylesheet schema.
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 */
	public function enqueue_styles(): void {
		if ( PRODUCTION_ENV ) {
			// Set tooltip mode for use in stylesheet name.
			if ( self::$tooltips_enabled ) {

				if ( self::$amp_enabled ) {
					$tooltip_mode_short = 'ampt';
					$tooltip_mode_long  = 'amp-tooltips';

				} elseif ( self::$alternative_tooltips_enabled ) {
					$tooltip_mode_short = 'altt';
					$tooltip_mode_long  = 'alternative-tooltips';

				} else {
					$tooltip_mode_short = 'jqtt';
					$tooltip_mode_long  = 'jquery-tooltips';

				}
			} else {
				$tooltip_mode_short = 'nott';
				$tooltip_mode_long  = 'no-tooltips';
			}

			// Set basic responsive page layout mode for use in stylesheet name.
			$page_layout_option = Settings::instance()->get( FOOTNOTES_PAGE_LAYOUT_SUPPORT );
			switch ( $page_layout_option ) {
				case 'reference-container':
					$layout_mode = '1';
					break;
				case 'entry-content':
					$layout_mode = '2';
					break;
				case 'main-content':
					$layout_mode = '3';
					break;
				case 'none':
				default:
					$layout_mode = '0';
					break;
			}

			// Enqueue the tailored united minified stylesheet.
			wp_enqueue_style(
				"footnotes-{$tooltip_mode_long}-pagelayout-{$page_layout_option}",
				plugin_dir_url( __FILE__ ) . "css/footnotes-{$tooltip_mode_short}brpl{$layout_mode}.min.css",
				array(),
				( PRODUCTION_ENV ) ? $this->version : filemtime(
					plugin_dir_path(
						__FILE__
					) . "css/footnotes-{$tooltip_mode_short}brpl{$layout_mode}.min.css"
				),
				'all'
			);
		} else {
			foreach ( array( 'amp-tooltips', 'common', 'layout-entry-content', 'layout-main-content', 'layout-reference-container', 'tooltips', 'tooltips-alternative' ) as $val ) {
				wp_enqueue_style(
					"footnotes-$val",
					plugin_dir_url( __FILE__ ) . "css/dev-$val.css",
					array(),
					filemtime(
						plugin_dir_path(
							__FILE__
						) . "css/dev-$val.css"
					),
					'all'
				);
			}
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since  1.5.0
	 * @since  2.0.0  Add jQueryUI dependency.
	 * @since  2.1.2  Add jQuery Tools dependency.
	 * @since  2.5.6  Add jQuery dependency.
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 */
	public function enqueue_scripts(): void {
		/*
		 * Enqueues the jQuery library registered by WordPress.
		 *
		 * As jQuery is also used for animated scrolling, it was loaded by default.
		 * The function `wp_enqueue_script()` avoids loading the same library multiple times.
		 * After adding the alternative reference container, jQuery has become optional,
		 * but still enabled by default.
		 */
		if ( ! self::$amp_enabled ) {

			if ( 'jquery' === self::$script_mode || ( self::$tooltips_enabled && ! self::$alternative_tooltips_enabled ) ) {

				wp_enqueue_script( 'jquery' );

			}

			if ( self::$tooltips_enabled && ! self::$alternative_tooltips_enabled ) {
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
	 * @since  2.8.0  Moved from {@see Footnotes} to {@see General}.
	 */
	public function register_widgets(): void {
		register_widget( $this->reference_container_widget );
	}
}

