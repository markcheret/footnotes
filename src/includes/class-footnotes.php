<?php // phpcs:disable PEAR.Commenting.FileComment.Missing
/**
 * File providing core `Footnotes` class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @since  2.8.0  Rename file from `init.php` to `class-footnotes.php`.
 */

/**
 * Class providing core plugin functionality.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 
 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @since  2.8.0
 */
class Footnotes {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @access  protected
	 * @var  Footnotes_Loader  $loader  Maintains and registers all hooks for the plugin.
	 *
	 * @since  2.8.0
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin
	 *
	 * @since  2.8.0
	 * @access  protected
	 * @var  string  $plugin_name  The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since  2.8.0
	 * @access  protected
	 * @var  string  $version  The current version of the plugin.
	 */
	protected $version;

	/**
	 * Build the core of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the
	 * plugin. Load the dependencies, define the locale, and set the hooks for 
	 * the admin area and the public-facing side of the site.
	 *
	 * @uses  PLUGIN_VERSION  The plugin version constant.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_VERSION' ) ) {
			$this->version = PLUGIN_VERSION;
		} else {
			$this->version = '0.0.0';
		}
		$this->plugin_name = 'footnotes';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Includes the following files that make up the plugin:
	 *
	 * - `Footnotes_Loader`. Orchestrates the hooks of the plugin.
	 * - `Footnotes_i18n`. Defines internationalization functionality.
	 * - `Footnotes_Config`. Defines plugin details.
	 * - `Footnotes_Convert`. Provides conversion methods.
	 * - `Footnotes_Settings`. Defines customisable plugin settings.
	 * - `Footnotes_Template`. Handles template rendering.
	 * - `Footnotes_Admin`. Defines all hooks for the admin area.
	 * - `Footnotes_Public`. Defines all hooks for the public side of the site.
	 *
	 * Creates an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @access  private
	 * @uses  Footnotes_Loader  Loads plugin dependencies.
	 *
	 * @since  2.8.0
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-footnotes-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-footnotes-i18n.php';

		/**
		 * The various utility classes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-footnotes-config.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-footnotes-convert.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-footnotes-settings.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-footnotes-template.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-footnotes-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-footnotes-public.php';

		$this->loader = new Footnotes_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the {@see Footnotes_i18n} class in order to set the domain and to 
	 * register the hook with WordPress.
	 *
	 * @access  private
	 * @uses  Footnotes_i18n  Handles initialization functions.
	 *
	 * @since  2.8.0
	 */
	private function set_locale() {

		$plugin_i18n = new Footnotes_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality of the 
	 * plugin.
	 *
	 * @access  private
	 * @uses  Footnotes_Admin  Defines admin functionality.
	 *
	 * @since  1.5.0
	 * @since  2.8.0 Moved hook registrations from various classes into `Footnotes_Admin`.
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Footnotes_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'plugin_action_links_footnotes/footnotes.php', $plugin_admin, 'footnotes_action_links' );

		$this->loader->add_filter( 'mce_buttons', $plugin_admin->wysiwyg, 'new_visual_editor_button' );
		$this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin->wysiwyg, 'new_plain_text_editor_button' );

		$this->loader->add_filter( 'mce_external_plugins', $plugin_admin->wysiwyg, 'include_scripts' );

		// phpcs:disable
		// 'footnotes_getTags' must match its instance in wysiwyg-editor.js.
		// 'footnotes_getTags' must match its instance in editor-button.html.
		$this->loader->add_action( 'wp_ajax_nopriv_footnotes_getTags', $plugin_admin->wysiwyg, 'ajax_callback' );
		$this->loader->add_action( 'wp_ajax_footnotes_getTags', $plugin_admin->wysiwyg, 'ajax_callback' );
		// phpcs:enable
	}

	/**
	 * Register all of the hooks related to the public-facing functionality of 
	 * the plugin.
	 *
	 * @access   private
	 * @uses  Footnotes_Admin  Defines public-facing functionality.
	 *
	 * @since  2.8.0
	 */
	private function define_public_hooks() {

		$plugin_public = new Footnotes_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'widgets_init', $plugin_public, 'register_widgets' );
	}

	/**
	 * Runs the loader to execute all of the hooks with WordPress.
	 *
	 * @since  1.5.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Gets the name of the plugin used to uniquely identify it within the 
	 * context of WordPress and to define internationalization functionality.
	 *
	 * @return  string  The name of the plugin.
	 *
	 * @since  2.8.0
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Returns a reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return  Footnotes_Loader  Orchestrates the hooks of the plugin.
	 *
	 * @since  2.8.0
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Gets the version number of the plugin.
	 *
	 * @return  string  The version number of the plugin.
	 *
	 * @since  2.8.0
	 */
	public function get_version() {
		return $this->version;
	}
}
