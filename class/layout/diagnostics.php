<?php
/**
 * Includes the Plugin Class to display Diagnostics.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 14:47
 */

/**
 * Displays Diagnostics of the web server, PHP and WordPress.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Layout_Diagnostics extends MCI_Footnotes_Layout_Engine {

	/**
	 * Returns a Priority index. Lower numbers have a higher Priority.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return int
	 */
	public function getPriority() {
		return 999;
	}

	/**
	 * Returns the unique slug of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	protected function getSubPageSlug() {
		return '-diagnostics';
	}

	/**
	 * Returns the title of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	protected function getSubPageTitle() {
		return __( 'Diagnostics', 'footnotes' );
	}

	/**
	 * Returns an array of all registered sections for the sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	protected function getSections() {
		return array(
			$this->addSection( 'diagnostics', __( 'Diagnostics', 'footnotes' ), null, false ),
		);
	}

	/**
	 * Returns an array of all registered meta boxes for each section of the sub page.
	 *
	 * @author Stefan Herndler
	 * @since  1.5.0
	 * @return array
	 */
	protected function getMetaBoxes() {
		return array(
			$this->addMetaBox( 'diagnostics', 'diagnostics', __( 'Displays information about the web server, PHP and WordPress', 'footnotes' ), 'Diagnostics' ),
		);
	}

	/**
	 * Displays a diagnostics about the web server, php and WordPress.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Diagnostics() {
		global $wp_version;
		$l_str_php_extensions = '';
		// iterate through each PHP extension
		foreach ( get_loaded_extensions() as $l_int_index => $l_str_extension ) {
			if ( $l_int_index > 0 ) {
				$l_str_php_extensions .= ' | ';
			}
			$l_str_php_extensions .= $l_str_extension . ' ' . phpversion( $l_str_extension );
		}

		/** @var WP_Theme $l_obj_current_theme */
		$l_obj_current_theme = wp_get_theme();

		$l_str_wordpress_plugins = '';
		// iterate through each installed WordPress Plugin
		foreach ( get_plugins() as $l_arr_plugin ) {
			$l_str_wordpress_plugins .= '<tr>';
			$l_str_wordpress_plugins .= '<td>' . $l_arr_plugin['Name'] . '</td>';
			$l_str_wordpress_plugins .= '<td>' . $l_arr_plugin['Version'] . ' [' . $l_arr_plugin['PluginURI'] . ']' . '</td>';
			$l_str_wordpress_plugins .= '</tr>';
		}
		// load template file
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'diagnostics' );
		// replace all placeholders
		$l_obj_template->replace(
			array(
				'label-server'             => __( 'Server name', 'footnotes' ),
				'server'                   => $_SERVER['SERVER_NAME'],

				'label-php'                => __( 'PHP version', 'footnotes' ),
				'php'                      => phpversion(),

				'label-user-agent'         => __( 'User agent', 'footnotes' ),
				'user-agent'               => $_SERVER['HTTP_USER_AGENT'],

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
		// display template with replaced placeholders
		echo $l_obj_template->getContent();
	}
}
