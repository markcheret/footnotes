<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName, WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Includes the Plugin Widget to put the Reference Container to the Widget area.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 * @date 14.09.14 14:26
 *
 * @since 2.2.0  (TBD)  2020-12-12T2131+0100
 */

/**
 * Registers a Widget to put the Reference Container to the widget area.
 *
 * @since 1.5.0
 */
class MCI_Footnotes_Widget_Reference_Container extends MCI_Footnotes_Widget_Base {

	/**
	 * Returns an unique ID as string used for the Widget Base ID.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	protected function get_id() {
		return 'footnotes_widget';
	}

	/**
	 * Returns the Public name of the Widget to be displayed in the Configuration page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	protected function get_name() {
		return MCI_Footnotes_Config::C_STR_PLUGIN_NAME;
	}

	/**
	 * Returns the Description of the child widget.
	 *
	 * @since 1.5.0
	 * @return string
	 *
	 * Edit: curly quotes 2.2.0  2020-12-12T2130+0100
	 */
	protected function get_description() {
		return __( 'The widget defines the position of the reference container if set to “widget area”.', 'footnotes' );
	}

	/**
	 * Outputs the Settings of the Widget.
	 *
	 * @since 1.5.0
	 * @param mixed $instance The instance of the widget.
	 * @return void
	 *
	 * Edit: curly quotes 2.2.0  2020-12-12T2130+0100
	 */
	public function form( $instance ) {
		echo __( 'The widget defines the position of the reference container if set to “widget area”.', 'footnotes' );
	}

	/**
	 * Outputs the Content of the Widget.
	 *
	 * @since 1.5.0
	 * @param mixed $args The widget's arguments.
	 * @param mixed $instance The instance of the widget.
	 */
	public function widget( $args, $instance ) {
		global $g_obj_mci_footnotes;
		// Reference container positioning is set to "widget area".
		if ( 'widget' === MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION ) ) {
			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $g_obj_mci_footnotes->a_obj_task->Reference_Container();
			// phpcs:enable
		}
	}
}
