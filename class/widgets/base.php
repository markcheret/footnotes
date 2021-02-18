<?php
/**
 * Widget base.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0
 * @date 14.09.14 14:30
 * 
 * @lastmodified 2021-02-18T0306+0100
 * @date 2021-02-18T0240+0100
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
	 * 
	 * - Update: replace deprecated function WP_Widget() with recommended __construct(), thanks to @dartiss code contribution.
	 * 
	 * @since 1.6.4
	 * @contributor @dartiss
	 * @link https://plugins.trac.wordpress.org/browser/footnotes/trunk/class/widgets/base.php?rev=1445720
	 * “The called constructor method for WP_Widget in MCI_Footnotes_Widget_ReferenceContainer is deprecated since version 4.3.0! Use __construct() instead.”
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
