<?php
/**
 * Includes: Core class
 *
 * `footnotes\includes` consists of functionality that is shared across both
 * the admin- and the public-facing sides of the plugin.
 *
 * The primary entry point is {@see Footnotes}, which uses {@see Loader}
 * to initialise {@see i18n} for internationalization, {@see Admin} for
 * admin-specific functionality and {@see General} for public-facing
 * functionality.
 *
 * It also includes various utility classes:
 *
 * - {@see Activator}: defines plugin activation behaviour, called in
 *   {@see activate_footnotes()};
 * - {@see Deactivator}: defines plugin deactivation behaviour, called in
 *   {@see deactivate_footnotes()};
 * - {@see Config}: defines plugin constants;
 * - {@see Convert}: provides data conversion methods;
 * - {@see Settings}: defines configurable plugin settings; and
 * - {@see Template}: handles template rendering.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed file from `init.php` to `class-core.php`.
 *              Renamed parent `class/` directory to `includes/`.
 */

declare(strict_types=1);

namespace footnotes\includes;

use footnotes\admin\Admin;
use footnotes\general\General;

/**
 * Class providing core plugin functionality.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.

 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed class from `Footnotes` to `Core`.
 *              Moved under `footnotes\includes` namespace.
 */
class Core {
	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power the plugin.
	 *
	 * @since 2.8.0
	 *
	 * @var Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected Loader $loader;

	/**
	 * The unique identifier of this plugin
	 *
	 * @since 2.8.0
	 *
	 * @var string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected string $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 2.8.0
	 * @see PLUGIN_VERSION
	 *
	 * @var string $version The current version of the plugin.
	 */
	protected string $version;

	/**
	 * Builds the core of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the
	 * plugin. Load the dependencies, define the locale, and set the hooks for
	 * the admin area and the public-facing side of the site.
	 *
	 * @since 1.0.0
	 * @global string PLUGIN_VERSION
	 *
	 * @return void
	 */
	public function __construct() {
		$this->version     = defined( 'PLUGIN_VERSION' ) ? PLUGIN_VERSION : '0.0.0';
		$this->plugin_name = 'footnotes';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Runs the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.5.0
	 *
	 * @return void
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * Gets the name of the plugin used to uniquely identify it within the
	 * context of WordPress and to define internationalization functionality.
	 *
	 * @since 2.8.0
	 */
	public function get_plugin_name(bool $html = false): string {
	  if ( ! $html ) return $this->plugin_name;
	  else return '<span class="footnotes_logo footnotes_logo_part1">foot</span><span class="footnotes_logo footnotes_logo_part2">notes</span>';
	}

	/**
	 * Returns a reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since 2.8.0
	 */
	public function get_loader(): Loader {
		return $this->loader;
	}

	/**
	 * Gets the version number of the plugin.
	 *
	 * @since 2.8.0
	 */
	public function get_version(): string {
		return $this->version;
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Includes the following files that make up the plugin:
	 *
	 * - {@see Loader}: orchestrates the hooks of the plugin;
	 * - {@see i18n}: defines internationalization functionality;
	 * - {@see Config}: defines plugin details;
	 * - {@see Convert}: provides conversion methods;
	 * - {@see Settings}: defines customisable plugin settings;
	 * - {@see Template}: handles template rendering;
	 * - {@see Admin}: defines all hooks for the admin area; and
	 * - {@see General}: defines all hooks for the public side of the site.
	 *
	 * Creates an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since 2.8.0
	 *
	 * @return void
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-settings.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-i18n.php';

		/**
		 * The various utility classes.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-config.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-convert.php';
		require_once plugin_dir_path( __DIR__ ) . 'includes/class-template.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'public/class-general.php';

		$this->loader = new Loader();

	}
	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses {@see i18n} in order to set the domain and to
	 * register the hook with WordPress.
	 *
	 * @since 2.8.0
	 * @uses i18n Handles initialization functions.
	 *
	 * @return void
	 */
	private function set_locale() {

		$i18n = new i18n();

		$this->loader->add_action( 'plugins_loaded', $i18n, 'load_plugin_textdomain' );

	}
	/**
	 * Register all of the hooks related to the admin area functionality of the
	 * plugin.
	 *
	 * @since 1.5.0
	 * @since 2.8.0 Moved hook registrations from various classes into `Admin`.
	 * @see Admin Defines admin functionality.
	 *
	 * @return void
	 */
	private function define_admin_hooks() {

		$admin = new Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );

		$this->loader->add_filter( 'plugin_action_links_footnotes/footnotes.php', $admin, 'action_links' );

		$this->loader->add_filter( 'mce_buttons', $admin->wysiwyg, 'new_visual_editor_button' );
		$this->loader->add_action( 'admin_print_footer_scripts', $admin->wysiwyg, 'new_plain_text_editor_button' );

		$this->loader->add_filter( 'mce_external_plugins', $admin->wysiwyg, 'include_scripts' );

		// phpcs:disable
		// 'footnotes_getTags' must match its instance in wysiwyg-editor.js.
		// 'footnotes_getTags' must match its instance in editor-button.html.
		$this->loader->add_action( 'wp_ajax_nopriv_footnotes_getTags', $admin->wysiwyg, 'ajax_callback' );
		$this->loader->add_action( 'wp_ajax_footnotes_getTags', $admin->wysiwyg, 'ajax_callback' );
		// phpcs:enable
	}
	/**
	 * Register all of the hooks related to the public-facing functionality of
	 * the plugin.
	 *
	 * @since 2.8.0
	 * @see General Defines public-facing functionality.
	 *
	 * @return void
	 */
	private function define_public_hooks() {

		$general = new General( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $general, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $general, 'enqueue_scripts' );

		$this->loader->add_action( 'widgets_init', $general, 'register_widgets' );
	}
}
