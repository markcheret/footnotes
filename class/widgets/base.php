<?php
/**
 *
 * @filesource
 * @author Stefan Herndler
 * @since x.x.x 14.09.14 14:30
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
abstract class MCI_Footnotes_WidgetBase extends WP_Widget {

	/**
	 * Returns an unique ID as string used for the Widget Base ID.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function getID();

	/**
	 * Returns the Public name of child Widget to be displayed in the Configuration page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function getName();

	/**
	 * Returns the Description of the child widget.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	abstract protected function getDescription();

	/**
	 * Returns the width of the Widget. Default width is 250 pixel.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return int
	 */
	protected function getWidgetWidth() {
		return 250;
	}

	/**
	 * Class Constructor. Registers the child Widget to WordPress.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function __construct() {
		$l_arr_WidgetOptions = array("classname" => __CLASS__, "description" => $this->getDescription());
		$l_arr_ControlOptions = array("id_base" => strtolower($this->getID()), "width" => $this->getWidgetWidth());
		// registers the Widget
		parent::__construct(
			strtolower($this->getID()), // unique ID for the widget, has to be lowercase
			$this->getName(), // Plugin name to be displayed
			$l_arr_WidgetOptions, // Optional Widget Options
			$l_arr_ControlOptions // Optional Widget Control Options
		);	
	}
}
