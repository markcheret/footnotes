<?php // phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
/**
 * Admin. Layouts: Init class
 *
 * The Admin. Layouts subpackage is composed of the {@see Engine}
 * abstract class, which is extended by the {@see Settings}
 * sub-class. The subpackage is initialised at runtime by the {@see
 * Init} class.
 *
 * @package  footnotes
 * @since  1.5.0
 * @since  2.8.0  Rename file from `init.php` to `class-footnotes-layout-init.php`,
 *                              rename `dashboard/` sub-directory to `layout/`.
 */

declare(strict_types=1);

namespace footnotes\admin\layout;

use footnotes\includes as Includes;

/**
 * Class to initialise all defined page layouts.
 *
 * @package  footnotes
 * @since  1.5.0
 */
class Init {

	/**
	 * Slug for the Plugin main menu.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 */
	const MAIN_MENU_SLUG = 'footnotes';

	/**
	 * Contains the settings page.
	 *
	 * @var  Settings
	 *
	 * @since  1.5.0
	 */
	private Settings $settings;

	/**
	 * Initializes all WordPress hooks for the Plugin Settings.
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Added `$plugin_name` parameter.
	 */
	public function __construct(
		/**
		 * The ID of this plugin.
		 *
		 * @access  private
		 * @var  string  $plugin_name  The ID of this plugin.
		 *
		 * @since  2.8.0
		 */
		private string $plugin_name
	) {
		$this->load_dependencies();

		$this->settings = new Settings( $this->plugin_name );

		// Register hooks/actions.
		add_action(
			'admin_menu',
			fn() => $this->register_options_submenu()
		);
		add_action(
			'admin_init',
			fn() => $this->initialize_settings()
		);
		// Register AJAX callbacks for Plugin information.
		add_action(
			'wp_ajax_nopriv_footnotes_get_plugin_info',
			fn() => $this->get_plugin_meta_information()
		);
		add_action(
			'wp_ajax_footnotes_get_plugin_info',
			fn() => $this->get_plugin_meta_information()
		);
	}

	/**
	 * Registers the settings and initialises the settings page.
	 *
	 * @since  1.5.0
	 */
	public function initialize_settings(): void {
		Includes\Settings::instance()->register_settings();
		$this->settings->register_sections();
	}

	/**
	 * Registers the footnotes submenu page.
	 *
	 * @since  1.5.0
	 * @see http://codex.wordpress.org/Function_Reference/add_menu_page
	 */
	public function register_options_submenu(): void {
		add_submenu_page(
			'options-general.php',
			'footnotes Settings',
			\footnotes\includes\Config::PLUGIN_PUBLIC_NAME,
			'manage_options',
			self::MAIN_MENU_SLUG,
			fn() => $this->settings->display_content()
		);
		$this->settings->register_sub_page();
	}

	// phpcs:disable WordPress.Security.NonceVerification.Missing
	/**
	 * AJAX call. returns a JSON string containing meta information about a specific WordPress Plugin.
	 *
	 * @since 1.5.0
	 */
	public function get_plugin_meta_information(): void {
		$plugin_name = null;
		// TODO: add nonce verification?

		// Get plugin internal name from POST data.
		if ( isset( $_POST['plugin'] ) ) {
			$plugin_name = wp_unslash( $_POST['plugin'] );
		}

		if ( empty( $plugin_name ) ) {
			echo wp_json_encode( array( 'error' => 'Plugin name invalid.' ) );
			exit;
		}
		$url = 'https://api.wordpress.org/plugins/info/1.0/' . $plugin_name . '.json';
		// Call URL and collect data.
		$response = wp_remote_get( $url );
		// Check if response is valid.
		if ( is_wp_error( $response ) ) {
			echo wp_json_encode( array( 'error' => 'Error receiving Plugin Information from WordPress.' ) );
			exit;
		}
		if ( ! array_key_exists( 'body', $response ) ) {
			echo wp_json_encode( array( 'error' => 'Error reading WordPress API response message.' ) );
			exit;
		}
		// Get the body of the response.
		$response = $response['body'];
		// Get plugin object.
		$plugin = json_decode( $response, true, 512, JSON_THROW_ON_ERROR );
		if ( empty( $plugin ) ) {
			echo wp_json_encode( array( 'error' => 'Error reading Plugin meta information.<br/>URL: ' . $url . '<br/>Response: ' . $response ) );
			exit;
		}

		$num_ratings = array_key_exists( 'num_ratings', $plugin ) ? (int) $plugin['num_ratings'] : 0;
		$rating      = array_key_exists( 'rating', $plugin ) ? floatval( $plugin['rating'] ) : 0.0;
		$stars       = round( 5 * $rating / 100.0, 1 );

		// Return Plugin information as JSON encoded string.
		echo wp_json_encode(
			array(
				'error'             => '',
				'PluginDescription' => array_key_exists( 'short_description', $plugin ) ? html_entity_decode( $plugin['short_description'] ) : 'Error reading Plugin information',
				'PluginAuthor'      => array_key_exists( 'author', $plugin ) ? html_entity_decode( $plugin['author'] ) : 'unknown',
				'PluginRatingText'  => $stars . ' ' . __( 'rating based on', 'footnotes' ) . ' ' . $num_ratings . ' ' . __( 'ratings', 'footnotes' ),
				'PluginRating1'     => $stars >= 0.5 ? 'star-full' : 'star-empty',
				'PluginRating2'     => $stars >= 1.5 ? 'star-full' : 'star-empty',
				'PluginRating3'     => $stars >= 2.5 ? 'star-full' : 'star-empty',
				'PluginRating4'     => $stars >= 3.5 ? 'star-full' : 'star-empty',
				'PluginRating5'     => $stars >= 4.5 ? 'star-full' : 'star-empty',
				'PluginRating'      => $num_ratings,
				'PluginLastUpdated' => array_key_exists( 'last_updated', $plugin ) ? $plugin['last_updated'] : 'unknown',
				'PluginDownloads'   => array_key_exists( 'downloaded', $plugin ) ? $plugin['downloaded'] : '---',
			)
		);
		exit;
	}
	/**
	 * Load the required dependencies for the layouts pages.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - {@see Includes\Config}: defines plugin constants;
	 * - {@see Includes\Settings}: defines configurable plugin settings; and
	 * - {@see Settings}: defines the plugin settings page.
	 *
	 * @access  private
	 *
	 * @since  2.8.0
	 */
	private function load_dependencies(): void {
		/**
		 * Defines plugin constants.
		 */
		require_once plugin_dir_path( dirname( __FILE__, 2 ) ) . 'includes/class-config.php';

		/**
		 * Defines configurable plugin settings.
		 */
		require_once plugin_dir_path( dirname( __FILE__, 2 ) ) . 'includes/class-settings.php';

		/**
		 * Represents the plugin settings dashboard page.
		 */
		require_once plugin_dir_path( __DIR__ ) . 'layout/class-settings.php';
	}
	// phpcs:enable WordPress.Security.NonceVerification.Missing
}
