<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Includes the Plugin Class to display Diagnostics.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 * @date 14.09.14 14:47
 */

/**
 * Displays Diagnostics of the web server, PHP and WordPress.
 *
 * @since 1.5.0
 */
class MCI_Footnotes_Layout_Diagnostics extends MCI_Footnotes_Layout_Engine {

	/**
	 * Returns a Priority index. Lower numbers have a higher Priority.
	 *
	 * @since 1.5.0
	 * @return int
	 */
	public function get_priority() {
		return 999;
	}

	/**
	 * Returns the unique slug of the sub page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	protected function get_sub_page_slug() {
		return '-diagnostics';
	}

	/**
	 * Returns the title of the sub page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	protected function get_sub_page_title() {
		return __( 'Diagnostics', 'footnotes' );
	}

	/**
	 * Returns an array of all registered sections for the sub page.
	 *
	 * @since  1.5.0
	 * @return array
	 */
	protected function get_sections() {
		return array(
			$this->add_section( 'diagnostics', __( 'Diagnostics', 'footnotes' ), null, false ),
		);
	}

	/**
	 * Returns an array of all registered meta boxes for each section of the sub page.
	 *
	 * @since  1.5.0
	 * @return array
	 */
	protected function get_meta_boxes() {
		return array(
			$this->add_meta_box( 'diagnostics', 'diagnostics', __( 'Displays information about the web server, PHP and WordPress', 'footnotes' ), 'Diagnostics' ),
		);
	}

	/**
	 * Displays a diagnostics about the web server, php and WordPress.
	 *
	 * @since 1.5.0
	 */
	public function Diagnostics() {
		global $wp_version;
		$l_str_php_extensions = '';
		// Iterate through each PHP extension.
		foreach ( get_loaded_extensions() as $l_int_index => $l_str_extension ) {
			if ( $l_int_index > 0 ) {
				$l_str_php_extensions .= ' | ';
			}
			$l_str_php_extensions .= $l_str_extension . ' ' . phpversion( $l_str_extension );
		}

		$l_obj_current_theme = wp_get_theme();

		$l_str_wordpress_plugins = '';
		// Iterate through each installed WordPress Plugin.
		foreach ( get_plugins() as $l_arr_plugin ) {
			$l_str_wordpress_plugins .= '<tr>';
			$l_str_wordpress_plugins .= '<td>' . $l_arr_plugin['Name'] . '</td>';
			// phpcs:disable Generic.Strings.UnnecessaryStringConcat.Found
			$l_str_wordpress_plugins .= '<td>' . $l_arr_plugin['Version'] . ' [' . $l_arr_plugin['PluginURI'] . ']' . '</td>';
			// phpcs:enable
			$l_str_wordpress_plugins .= '</tr>';
		}
		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'diagnostics' );

		if ( ! isset( $_SERVER['SERVER_NAME'] ) ) {
			die;
		} else {
			$l_str_server_name = sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) );
		}
		if ( ! isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			die;
		} else {
			$l_str_http_user_agent = sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) );
		}

		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-server'             => __( 'Server name', 'footnotes' ),
				'server'                   => $l_str_server_name,

				'label-php'                => __( 'PHP version', 'footnotes' ),
				'php'                      => phpversion(),

				'label-user-agent'         => __( 'User agent', 'footnotes' ),
				'user-agent'               => $l_str_http_user_agent,

				'label-max-execution-time' => __( 'Max execution time', 'footnotes' ),
				'max-execution-time'       => ini_get( 'max_execution_time' ) . ' ' . __( 'seconds', 'footnotes' ),

				'label-memory-limit'       => __( 'Memory limit', 'footnotes' ),
				'memory-limit'             => ini_get( 'memory_limit' ),

				'label-php-extensions'     => __( 'PHP extensions', 'footnotes' ),
				'php-extensions'           => $l_str_php_extensions,

				'label-wordpress'          => __( 'WordPress version', 'footnotes' ),
				'wordpress'                => $wp_version,

				'label-theme'              => __( 'Active Theme', 'footnotes' ),
				'theme'                    => $l_obj_current_theme->get( 'Name' ) . ' ' . $l_obj_current_theme->get( 'Version' ) . ', ' . $l_obj_current_theme->get( 'Author' ) . ' [' . $l_obj_current_theme->get( 'AuthorURI' ) . ']',

				'plugins'                  => $l_str_wordpress_plugins,
			)
		);
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		// Display template with replaced placeholders.
		echo $l_obj_template->get_content();
		// phpcs:enable
	}
}
