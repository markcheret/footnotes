<?php
/**
 * Widgets: Footnotes_Widget_Base class
 *
 * The Widget subpackage is composed of the {@see Footnotes_Widget_Base}
 * abstract class, which is extended by the {@see Footnotes_Widget_Reference_Container}
 * sub-class.
 *
 * @package  footnotes\public\widget
 * @since 1.5.0
 */

/**
 * Base class to be extended by all widget sub-classes.
 *
 * Any sub-class must override the appropriate method(s) provided by
 * {@link https://developer.wordpress.org/reference/classes/wp_widget/#description `WP_Widget`}.
 *
 * @abstract
 *
 * @package  footnotes\public\widget
 * @since  1.5.0
 * @todo  Review implemenation of Widgets API.
 */
abstract class Footnotes_Widget_Base extends WP_Widget {

	/**
	 * Returns an unique ID as string used for the Widget Base ID.
	 *
	 * @abstract
	 * @since  1.5.0
	 *
	 * @return  string
	 */
	abstract protected function get_id();

	/**
	 * Returns the Public name of child Widget to be displayed in the Configuration page.
	 *
	 * @abstract
	 * @since  1.5.0
	 *
	 * @return  string
	 */
	abstract protected function get_name();

	/**
	 * Returns the Description of the child widget.
	 *
	 * @abstract
	 * @since  1.5.0
	 *
	 * @return  string
	 */
	abstract protected function get_description();

	/**
	 * Returns the width of the Widget. Default width is 250 pixel.
	 *
	 * @since  1.5.0
	 *
	 * @return  int
	 */
	protected function get_widget_width() {
		return 250;
	}
	
	/**
	 * Registers the child Widget to WordPress.
	 *
	 * @since  1.5.0
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
