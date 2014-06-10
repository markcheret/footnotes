<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 24.05.14
 * Time: 13:57
 */

class Class_FootnotesWidget extends WP_Widget {

    /**
     * @constructor
     */
    function Class_FootnotesWidget() {
        $widget_ops = array( 'classname' => 'Class_FootnotesWidget', 'description' => __('The widget defines the position of the reference container if set to "widget area".', FOOTNOTES_PLUGIN_NAME) );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'footnotes_widget' );
        $this->WP_Widget( 'footnotes_widget', FOOTNOTES_PLUGIN_NAME, $widget_ops, $control_ops );
    }

    /**
     * widget form creation
     * @param $instance
     */
    function form($instance) {
        echo __('The widget defines the position of the reference container if set to "widget area".', FOOTNOTES_PLUGIN_NAME);
    }

    /**
     * widget update
     * @param $new_instance
     * @param $old_instance
     */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /**
     * widget display
     * @param $args
     * @param $instance
     */
    function widget($args, $instance) {
        /* access to the global settings collection */
        global $g_arr_FootnotesSettings;
        /* get setting for 'display reference container position' */
        $l_str_ReferenceContainerPosition = $g_arr_FootnotesSettings[FOOTNOTE_INPUTFIELD_REFERENCE_CONTAINER_PLACE];
        if ($l_str_ReferenceContainerPosition == "widget") {
            echo footnotes_OutputReferenceContainer();
        }
    }
}