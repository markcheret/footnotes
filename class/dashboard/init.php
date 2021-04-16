<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
/**
 * Includes the Plugin settings menu.
 *
 * @filesource
 * @package footnotes
 * @since  1.5.0
 */

/**
 * Handles the Settings interface of the Plugin.
 *
 * @since  1.5.0
 */
class Footnotes_Layout_Init {

	/**
	 * Slug for the Plugin main menu.
	 *
	 * @since 1.5.0
	 * @var string
	 */
	const MAIN_MENU_SLUG = 'footnotes';

	/**
	 * Plugin main menu name.
	 *
	 * @since 1.5.0
	 * @var string
	 */
	const MAIN_MENU_TITLE = 'ManFisher';

	/**
	 * Contains the settings layoutEngine
	 *
	 * @since 1.5.0
	 * @var array
	 */
	private $settings_page;

	/**
	 * Class Constructor. Initializes all WordPress hooks for the Plugin Settings.
	 *
	 * @since  1.5.0
	 */
	public function __construct() {
		$this->settings_page = new Footnotes_Layout_Settings();

		// Register hooks/actions.
		add_action( 'admin_menu', array( $this, 'register_options_submenu' ) );
		add_action( 'admin_init', array( $this, 'initialize_settings' ) );
		// Register AJAX callbacks for Plugin information.
		add_action( 'wp_ajax_nopriv_footnotes_get_plugin_info', array( $this, 'get_plugin_meta_information' ) );
		add_action( 'wp_ajax_footnotes_get_plugin_info', array( $this, 'get_plugin_meta_information' ) );
	}

	/**
	 * Registers the settings and initialises the settings page.
	 *
	 * @since  1.5.0
	 */
	public function initialize_settings() {
		Footnotes_Settings::instance()->register_settings();
		$this->settings_page->register_sections();
	}

	/**
	 * Registers the footnotes submenu page.
	 *
	 * @since  1.5.0
	 * @see http://codex.wordpress.org/Function_Reference/add_menu_page
	 */
	public function register_options_submenu() {
		add_submenu_page(
			'options-general.php',
			'footnotes Settings',
			self::MAIN_MENU_SLUG,
			'manage_options',
			'footnotes',
			array( $this->settings_page, 'display_content' )
		);
		$this->settings_page->register_sub_page();
	}

	// phpcs:disable WordPress.Security.NonceVerification.Missing
	/**
	 * AJAX call. returns a JSON string containing meta information about a specific WordPress Plugin.
	 *
	 * @since 1.5.0
	 */
	public function get_plugin_meta_information() {
		// TODO: add nonce verification.

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
		$plugin = json_decode( $response, true );
		if ( empty( $plugin ) ) {
			echo wp_json_encode( array( 'error' => 'Error reading Plugin meta information.<br/>URL: ' . $url . '<br/>Response: ' . $response ) );
			exit;
		}

		$num_ratings = array_key_exists( 'num_ratings', $plugin ) ? intval( $plugin['num_ratings'] ) : 0;
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
	// phpcs:enable WordPress.Security.NonceVerification.Missing
}
