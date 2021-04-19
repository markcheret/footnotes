<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Widget base.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 *
 * @since 1.6.4  Update: replace deprecated function WP_Widget() with recommended __construct(), thanks to @dartiss code contribution.
 */

/**
 * Base Class for all Plugin Widgets. Registers each Widget to WordPress.
 * The following Methods MUST be overwritten in each sub class:
 * **public function widget($args, $instance)** -> echo the Widget Content
 * **public function form($instance)** -> echo the Settings of the Widget
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
abstract class Footnotes_Widget_Base extends WP_Widget {

	/**
	 * Returns an unique ID as string used for the Widget Base ID.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function get_id();

	/**
	 * Returns the Public name of child Widget to be displayed in the Configuration page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function get_name();

	/**
	 * Returns the Description of the child widget.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function get_description();

	/**
	 * Returns the width of the Widget. Default width is 250 pixel.
	 *
	 * @since 1.5.0
	 * @return int
	 */
	protected function get_widget_width() {
		return 250;
	}

	/**
	 * Class Constructor. Registers the child Widget to WordPress.
	 *
	 * @since 1.5.0
	 *
	 * - Update: replace deprecated function WP_Widget() with recommended __construct(), thanks to @dartiss code contribution.
	 *
	 * @since 1.6.4
	 * @contributor @dartiss
	 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class/widgets/base.php?rev=1445720
	 * “The called constructor method for WP_Widget in Footnotes_Widget_ReferenceContainer is deprecated since version 4.3.0! Use __construct() instead.”
	 */
	public function __construct() {
		$l_arr_widget_options  = array(
			'classname'   => __CLASS__,
			'description' => $this->get_description(),
		);
		$l_arr_control_options = array(
			'id_base' => strtolower( $this->get_id() ),
			'width'   => $this->get_widget_width(),
		);
		// Registers the Widget.
		parent::__construct(
			strtolower( $this->get_id() ), // Unique ID for the widget, has to be lowercase.
			$this->get_name(), // Plugin name to be displayed.
			$l_arr_widget_options, // Optional Widget Options.
			$l_arr_control_options // Optional Widget Control Options.
		);
	}
}
