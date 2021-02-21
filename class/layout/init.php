<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Includes the Plugin settings menu.
 *
 * @filesource
 * @package footnotes
 * @author Stefan Herndler
 * @since  1.5.0 12.09.14 10:26
 */

/**
 * Handles the Settings interface of the Plugin.
 *
 * @author Stefan Herndler
 * @since  1.5.0
 */
class MCI_Footnotes_Layout_Init {

	/**
	 * Slug for the Plugin main menu.
	 *
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_MAIN_MENU_SLUG = 'mfmmf';

	/**
	 * Plugin main menu name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_MAIN_MENU_TITLE = 'ManFisher';

	/**
	 * Contains layout engine sub classes.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	private $a_arr_sub_page_classes = array();

	/**
	 * Class Constructor. Initializes all WordPress hooks for the Plugin Settings.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 */
	public function __construct() {
		// iterate through each class define in the current script.
		foreach ( get_declared_classes() as $l_str_class_name ) {
			// accept only child classes of the layout engine.
			if ( is_subclass_of( $l_str_class_name, 'MCI_Footnotes_Layout_Engine' ) ) {
				$l_obj_class = new $l_str_class_name();
				// append new instance of the layout engine sub class.
				$this->a_arr_sub_page_classes[ $l_obj_class->getPriority() ] = $l_obj_class;
			}
		}
		ksort( $this->a_arr_sub_page_classes );

		// register hooks/actions.
		add_action( 'admin_init', array( $this, 'initialize_settings' ) );
		add_action( 'admin_menu', array( $this, 'register_main_menu' ) );
		// register AJAX callbacks for Plugin information.
		add_action( 'wp_ajax_nopriv_footnotes_getPluginInfo', array( $this, 'get_plugin_meta_information' ) );
		add_action( 'wp_ajax_footnotes_getPluginInfo', array( $this, 'get_plugin_meta_information' ) );
	}

	/**
	 * Initializes all sub pages and registers the settings.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 */
	public function initialize_settings() {
		MCI_Footnotes_Settings::instance()->RegisterSettings();
		// iterate though each sub class of the layout engine and register their sections.
		foreach ( $this->a_arr_sub_page_classes as $l_obj_layout_engine_sub_class ) {
			$l_obj_layout_engine_sub_class->registerSections();
		}
	}

	/**
	 * Registers the new main menu for the WordPress dashboard.
	 * Registers all sub menu pages for the new main menu.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @see http://codex.wordpress.org/Function_Reference/add_menu_page
	 */
	public function register_main_menu() {
		global $menu;
		// iterate through each main menu.
		foreach ( $menu as $l_arr_main_menu ) {
			// iterate through each main menu attribute.
			foreach ( $l_arr_main_menu as $l_str_attribute ) {
				// main menu already added, append sub pages and stop.
				if ( self::C_STR_MAIN_MENU_SLUG === $l_str_attribute ) {
					$this->register_sub_pages();
					return;
				}
			}
		}

		// add a new main menu page to the WordPress dashboard.
		add_menu_page(
			self::C_STR_MAIN_MENU_TITLE, // page title.
			self::C_STR_MAIN_MENU_TITLE, // menu title.
			'manage_options', // capability.
			self::C_STR_MAIN_MENU_SLUG, // menu slug.
			array( $this, 'display_other_plugins' ), // function.
			plugins_url( 'footnotes/img/main-menu.png' ), // icon url.
			null // position.
		);
		$this->register_sub_pages();
	}

	/**
	 * Registers all SubPages for this Plugin.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function register_sub_pages() {
		// first registered sub menu page MUST NOT contain a unique slug suffix.
		// iterate though each sub class of the layout engine and register their sub page.
		foreach ( $this->a_arr_sub_page_classes as $l_obj_layout_engine_sub_class ) {
			$l_obj_layout_engine_sub_class->register_sub_page();
		}
	}

	/**
	 * Displays other Plugins from the developers.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function display_other_plugins() {
		printf( '<br/><br/>' );
		// load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'manfisher' );
		echo wp_kses_post( $l_obj_template->getContent() );

		printf( '<em>visit <a href="https://cheret.de/plugins/footnotes-2/" target="_blank">Mark Cheret</a></em>' );
		printf( '<br/><br/>' );

		printf( '</div>' );
	}

	/**
	 * AJAX call. returns a JSON string containing meta information about a specific WordPress Plugin.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function get_plugin_meta_information() {
		// TODO: add nonce verification.

		// get plugin internal name from POST data.
		if ( isset( $_POST['plugin'] ) && 'true' === $_POST['plugin'] ) {
			$l_str_plugin_name = wp_kses_post( wp_unslash( $_POST['plugin'] ) );
		}

		if ( empty( $l_str_plugin_name ) ) {
			echo wp_json_encode( array( 'error' => 'Plugin name invalid.' ) );
			exit;
		}
		$l_str_url = 'https://api.wordpress.org/plugins/info/1.0/' . $l_str_plugin_name . '.json';
		// call URL and collect data.
		$l_arr_response = wp_remote_get( $l_str_url );
		// check if response is valid.
		if ( is_wp_error( $l_arr_response ) ) {
			echo wp_json_encode( array( 'error' => 'Error receiving Plugin Information from WordPress.' ) );
			exit;
		}
		if ( ! array_key_exists( 'body', $l_arr_response ) ) {
			echo wp_json_encode( array( 'error' => 'Error reading WordPress API response message.' ) );
			exit;
		}
		// get the body of the response.
		$l_str_response = $l_arr_response['body'];
		// get plugin object.
		$l_arr_plugin = json_decode( $l_str_response, true );
		if ( empty( $l_arr_plugin ) ) {
			echo wp_json_encode( array( 'error' => 'Error reading Plugin meta information.<br/>URL: ' . $l_str_url . '<br/>Response: ' . $l_str_response ) );
			exit;
		}

		$l_int_num_ratings = array_key_exists( 'num_ratings', $l_arr_plugin ) ? intval( $l_arr_plugin['num_ratings'] ) : 0;
		$l_int_rating      = array_key_exists( 'rating', $l_arr_plugin ) ? floatval( $l_arr_plugin['rating'] ) : 0.0;
		$l_int_stars       = round( 5 * $l_int_rating / 100.0, 1 );

		// return Plugin information as JSON encoded string.
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
}
