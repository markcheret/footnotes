<?php // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Widgets: Footnotes_Widget_Reference_Container class
 *
 * The Widget subpackage is composed of the {@see Footnotes_Widget_Base}
 * abstract class, which is extended by the {@see Footnotes_Widget_Reference_Container}
 * sub-class.
 *
 * @package  footnotes\public\widget
 * @since  1.5.0
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widget/class-footnotes-widget-base.php';

/**
 * Registers a Widget to put the Reference Container to the widget area.
 *
 * @package  footnotes\public\widget
 * @since  1.5.0
 * @see  Footnotes_Widget_Base
 * @todo  Review implemenation of Widgets API.
 */
class Footnotes_Widget_Reference_Container extends Footnotes_Widget_Base {

	/**
	 * The ID of this plugin.
	 *
	 * @access  private
	 * @since  2.8.0
	 * @see  Footnotes::$plugin_name
	 * @var  string  $plugin_name  The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since  2.8.0
	 *
	 * @param  string $plugin_name  The name of this plugin.
	 */
	public function __construct( $plugin_name ) {
		parent::__construct();
		$this->plugin_name = $plugin_name;
	}

	/**
	 * Returns an unique ID as string used for the Widget Base ID.
	 *
	 * @see  Footnotes_Widget_Base::get_id()
	 * @since  1.5.0
	 *
	 * @return  string
	 */
	protected function get_id() {
		return 'footnotes_widget';
	}

	/**
	 * Returns the Public name of the Widget to be displayed in the Configuration page.
	 *
	 * @see  Footnotes_Widget_Base::get_name()
	 * @since  1.5.0
	 *
	 * @return  string
	 */
	protected function get_name() {
		return $this->plugin_name;
	}

	/**
	 * Returns the Description of the child widget.
	 *
	 * @see  Footnotes_Widget_Base::get_description()
	 * @since  1.5.0
	 *
	 * @return  string
	 */
	protected function get_description() {
		return __( 'The widget defines the position of the reference container if set to &ldquo;widget area&rdquo;.', 'footnotes' );
	}

	/**
	 * Outputs the Settings of the Widget.
	 *
	 * @link  https://developer.wordpress.org/reference/classes/wp_widget/form/ `WP_Widget::form()`
	 * @since  1.5.0
	 *
	 * @param  mixed $instance  The instance of the widget.
	 */
	public function form( $instance ) {
		echo __( 'The widget defines the position of the reference container if set to &ldquo;widget area&rdquo;.', 'footnotes' );
	}

	/**
	 * Outputs the Content of the Widget.
	 *
	 * @link  https://developer.wordpress.org/reference/classes/wp_widget/widget/ `WP_Widget::widget()`
	 * @since  1.5.0
	 *
	 * @param  mixed $args  The widget's arguments.
	 * @param  mixed $instance  The instance of the widget.
	 */
	public function widget( $args, $instance ) {
		global $footnotes;
		// Reference container positioning is set to "widget area".
		if ( 'widget' === Footnotes_Settings::instance()->get( Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION ) ) {
			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $footnotes->a_obj_task->reference_container();
			// phpcs:enable
		}
	}
}
