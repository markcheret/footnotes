<?php
/**
 * File providing the `Template` class.
 *
 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @since  2.2.6  Add support for custom templates in sibling folder.
 * @since  2.8.0  Rename file from `templates.php` to `class-footnotes-templates.php`,
 *                              rename `class/` sub-directory to `includes/`.
 */

declare(strict_types=1);

namespace footnotes\includes;

/**
 * Class defining template rendering.
 *
 * Loads a template file, replaces all Placeholders and returns the replaced
 * file content.

 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @todo  Refactor templating.
 */
class Template {

	/**
	 * Directory name for dashboard partials.
	 *
	 * @since 1.5.0
	 *
	 * @var string
	 */
	const C_STR_DASHBOARD = 'admin/partials';

	/**
	 * Directory name for public partials.
	 *
	 * @since 1.5.0
	 *
	 * @var string
	 */
	const C_STR_PUBLIC = 'public/partials';

	/**
	 * Contains the content of the template after initialize.
	 *
	 * @since  1.5.0
	 */
	private ?string $a_str_original_content = '';

	/**
	 * Contains the content of the template after initialize with replaced place holders.
	 *
	 * @since  1.5.0
	 */
	private string $a_str_replaced_content = '';

	/**
	 * Plugin Directory
	 *
	 * @since  2.4.0d3
	 */
	public string $plugin_directory;

	/**
	 * Class Constructor. Reads and loads the template file without replace any placeholder.
	 *
	 * @since  1.5.0
	 * @todo  Refactor templating.
	 *
	 * @param  string $p_str_file_type  Template file type.
	 * @param  string $p_str_file_name  Template file name inside the `partials/` directory, without the file extension.
	 * @param  string $p_str_extension  (optional) Template file extension (default: 'html').
	 * @return void
	 */
	public function __construct( string $p_str_file_type, string $p_str_file_name, string $p_str_extension = 'html' ) {
		// No template file type and/or file name set.
		if (empty( $p_str_file_type )) {
			return;
		}
		if (empty( $p_str_file_name )) {
			return;
		}
		$this->plugin_directory = plugin_dir_path( __DIR__ );

		$template = $this->get_template( $p_str_file_type, $p_str_file_name, $p_str_extension );
		if ( $template ) {
			$this->process_template( $template );
		} else {
			return;
		}

	}

	/**
	 * Replace all placeholders specified in array.
	 *
	 * @since  1.5.0
	 * @todo  Refactor templating.
	 *
	 * @param  string[] $p_arr_placeholders  Placeholders (key = placeholder, value = value).
	 * @return  bool  `true` on Success, `false` if placeholders invalid.
	 */
	public function replace( array $p_arr_placeholders ): bool {
		// No placeholders set.
		if ( empty( $p_arr_placeholders ) ) {
			return false;
		}
		// Template content is empty.
		if ( empty( $this->a_str_replaced_content ) ) {
			return false;
		}
		// Iterate through each placeholder and replace it with its value.
		foreach ( $p_arr_placeholders as $l_str_placeholder => $l_str_value ) {
			$this->a_str_replaced_content = str_replace( '[[' . $l_str_placeholder . ']]', (string) $l_str_value, $this->a_str_replaced_content );
		}
		// Success.
		return true;
	}

	/**
	 * Reloads the original content of the template file.
	 *
	 * @since  1.5.0
	 * @todo  Refactor templating.
	 *
	 * @return void
	 */
	public function reload() {
		$this->a_str_replaced_content = $this->a_str_original_content;
	}

	/**
	 * Returns the content of the template file with replaced placeholders.
	 *
	 * @since  1.5.0
	 * @todo  Refactor templating.
	 *
	 * @return  string  Template content with replaced placeholders.
	 */
	public function get_content(): string {
		return $this->a_str_replaced_content;
	}

	/**
	 * Process template file.
	 *
	 * @since  2.4.0d3
	 * @todo  Refactor templating.
	 *
	 * @param  string $template  The template to be processed.
	 * @return  void
	 */
	public function process_template( string $template ) {
		// phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$this->a_str_original_content = preg_replace( '#<!--.+?-->#s', '', file_get_contents( $template ) );
		// phpcs:enable
		$this->a_str_original_content = preg_replace( '#/\*\*.+?\*/#s', '', $this->a_str_original_content );
		$this->a_str_original_content = str_replace( "\n", '', $this->a_str_original_content );
		$this->a_str_original_content = str_replace( "\r", '', $this->a_str_original_content );
		$this->a_str_original_content = str_replace( "\t", ' ', $this->a_str_original_content );
		$this->a_str_original_content = preg_replace( '# +#', ' ', $this->a_str_original_content );
		$this->a_str_original_content = str_replace( ' >', '>', $this->a_str_original_content );
		$this->reload();
	}

	/**
	 * Get the template.
	 *
	 * @since 2.5.0
	 * @todo  Refactor templating.
	 * @todo  Single return type.
	 *
	 * @param  string $p_str_file_type  The file type of the template.
	 * @param  string $p_str_file_name  The file name of the template.
	 * @param  string $p_str_extension  The file extension of the template.
	 * @return  string|bool  `false` or the template path
	 */
	public function get_template( string $p_str_file_type, string $p_str_file_name, string $p_str_extension = 'html' ): string|bool {
		$located = false;

		/*
		 * The directory can be changed.
		 *
		 * To change location of templates to 'template_parts/footnotes/':
		 *     add_filter( 'template_directory', function( $directory ) {
		 *         return 'template_parts/footnotes/';
		 *     } );
		 */
		$template_directory = apply_filters( '', 'footnotes/' );
		$custom_directory   = apply_filters( 'custom_template_directory', 'footnotes-custom/' );
		$template_name      = $p_str_file_type . '/' . $p_str_file_name . '.' . $p_str_extension;

		// Look in active theme.
		if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $template_directory . $template_name ) ) {
			$located = trailingslashit( get_stylesheet_directory() ) . $template_directory . $template_name;

			// Look in parent theme in case active is child.
		} elseif ( file_exists( trailingslashit( get_template_directory() ) . $template_directory . $template_name ) ) {
			$located = trailingslashit( get_template_directory() ) . $template_directory . $template_name;

			// Look in custom plugin directory.
		} elseif ( file_exists( trailingslashit( WP_PLUGIN_DIR ) . $custom_directory . 'templates/' . $template_name ) ) {
			$located = trailingslashit( WP_PLUGIN_DIR ) . $custom_directory . 'templates/' . $template_name;

			// Fall back to the templates shipped with the plugin.
		} elseif ( file_exists( $this->plugin_directory . $template_name ) ) {
			$located = $this->plugin_directory . $template_name;
		}

		return $located;
	}

}
