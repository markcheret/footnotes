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
	const C_STR_MAIN_MENU_SLUG = 'footnotes';

	/**
	 * Plugin main menu name.
	 *
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_MAIN_MENU_TITLE = 'ManFisher';

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
			self::C_STR_MAIN_MENU_SLUG,
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
			$l_str_plugin_name = wp_unslash( $_POST['plugin'] );
		}

		if ( empty( $l_str_plugin_name ) ) {
			echo wp_json_encode( array( 'error' => 'Plugin name invalid.' ) );
			exit;
		}
		$l_str_url = 'https://api.wordpress.org/plugins/info/1.0/' . $l_str_plugin_name . '.json';
		// Call URL and collect data.
		$l_arr_response = wp_remote_get( $l_str_url );
		// Check if response is valid.
		if ( is_wp_error( $l_arr_response ) ) {
			echo wp_json_encode( array( 'error' => 'Error receiving Plugin Information from WordPress.' ) );
			exit;
		}
		if ( ! array_key_exists( 'body', $l_arr_response ) ) {
			echo wp_json_encode( array( 'error' => 'Error reading WordPress API response message.' ) );
			exit;
		}
		// Get the body of the response.
		$l_str_response = $l_arr_response['body'];
		// Get plugin object.
		$l_arr_plugin = json_decode( $l_str_response, true );
		if ( empty( $l_arr_plugin ) ) {
			echo wp_json_encode( array( 'error' => 'Error reading Plugin meta information.<br/>URL: ' . $l_str_url . '<br/>Response: ' . $l_str_response ) );
			exit;
		}

		$l_int_num_ratings = array_key_exists( 'num_ratings', $l_arr_plugin ) ? intval( $l_arr_plugin['num_ratings'] ) : 0;
		$l_int_rating      = array_key_exists( 'rating', $l_arr_plugin ) ? floatval( $l_arr_plugin['rating'] ) : 0.0;
		$l_int_stars       = round( 5 * $l_int_rating / 100.0, 1 );

		// Return Plugin information as JSON encoded string.
		echo wp_json_encode(
			array(
				'error'             => '',
				'PluginDescription' => array_key_exists( 'short_description', $l_arr_plugin ) ? html_entity_decode( $l_arr_plugin['short_description'] ) : 'Error reading Plugin information',
				'PluginAuthor'      => array_key_exists( 'author', $l_arr_plugin ) ? html_entity_decode( $l_arr_plugin['author'] ) : 'unknown',
				'PluginRatingText'  => $l_int_stars . ' ' . __( 'rating based on', 'footnotes' ) . ' ' . $l_int_num_ratings . ' ' . __( 'ratings', 'footnotes' ),
				'PluginRating1'     => $l_int_stars >= 0.5 ? 'star-full' : 'star-empty',
				'PluginRating2'     => $l_int_stars >= 1.5 ? 'star-full' : 'star-empty',
				'PluginRating3'     => $l_int_stars >= 2.5 ? 'star-full' : 'star-empty',
				'PluginRating4'     => $l_int_stars >= 3.5 ? 'star-full' : 'star-empty',
				'PluginRating5'     => $l_int_stars >= 4.5 ? 'star-full' : 'star-empty',
				'PluginRating'      => $l_int_num_ratings,
				'PluginLastUpdated' => array_key_exists( 'last_updated', $l_arr_plugin ) ? $l_arr_plugin['last_updated'] : 'unknown',
				'PluginDownloads'   => array_key_exists( 'downloaded', $l_arr_plugin ) ? $l_arr_plugin['downloaded'] : '---',
			)
		);
		exit;
	}
	// phpcs:enable WordPress.Security.NonceVerification.Missing
}
