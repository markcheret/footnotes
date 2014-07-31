<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 24.05.14
 * Time: 13:57
 */

// define class only once
if (!class_exists("MCI_Footnotes_Widget")) :

/**
 * Class MCI_Footnotes_Widget
 * @since 1.0
 */
class MCI_Footnotes_Widget extends WP_Widget {

    /**
     * @constructor
     */
	public function __construct() {
		// set widget class and description
        $l_arr_WidgetMeta = array(
			'classname' => 'Class_FootnotesWidget',
			'description' => __('The widget defines the position of the reference container if set to "widget area".', FOOTNOTES_PLUGIN_NAME)
		);
		// set widget layout information
        $l_arr_WidgetLayout = array(
			'width' => 300,
			'height' => 350,
			'id_base' => 'footnotes_widget'
		);
		// add widget to the list
        $this->WP_Widget('footnotes_widget', FOOTNOTES_PLUGIN_NAME, $l_arr_WidgetMeta, $l_arr_WidgetLayout);
    }

    /**
     * widget form creation
     * @param $instance
	 * @return void
     */
	public function form($instance) {
        echo __('The widget defines the position of the reference container if set to "widget area".', FOOTNOTES_PLUGIN_NAME);
    }

    /**
     * widget update
     * @param $new_instance
     * @param $old_instance
	 * @return mixed
     */
	public function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /**
     * widget display
     * @param $args
     * @param $instance
     */
	public function widget($args, $instance) {
		global $g_obj_MCI_Footnotes;
        // reference container positioning is set to "widget area"
        if ($g_obj_MCI_Footnotes->a_obj_Task->a_arr_Settings[FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE] == "widget") {
            echo $g_obj_MCI_Footnotes->a_obj_Task->ReferenceContainer();
        }
    }
} // class MCI_Footnotes_Widget

endif;