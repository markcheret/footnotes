<?php
/**
 * Includes the Plugin Widget to put the Reference Container to the Widget area.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 14:26
 * 
 * Edited 2.2.0  2020-12-12T2131+0100
 */


/**
 * Registers a Widget to put the Reference Container to the widget area.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Widget_ReferenceContainer extends MCI_Footnotes_WidgetBase {

    /**
     * Returns an unique ID as string used for the Widget Base ID.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     */
    protected function getID() {
        return "footnotes_widget";
    }

    /**
     * Returns the Public name of the Widget to be displayed in the Configuration page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     */
    protected function getName() {
        return MCI_Footnotes_Config::C_STR_PLUGIN_NAME;
    }

    /**
     * Returns the Description of the child widget.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     * 
     * Edit: curly quotes 2.2.0  2020-12-12T2130+0100
     */
    protected function getDescription() {
        return __('The widget defines the position of the reference container if set to “widget area”.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
    }

    /**
     * Outputs the Settings of the Widget.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param mixed $instance
     * @return void
     * 
     * Edit: curly quotes 2.2.0  2020-12-12T2130+0100
     */
    public function form($instance) {
        echo __('The widget defines the position of the reference container if set to “widget area”.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
    }

    /**
     * Outputs the Content of the Widget.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param mixed $args
     * @param mixed $instance
     */
    public function widget($args, $instance) {
        global $g_obj_MCI_Footnotes;
        // reference container positioning is set to "widget area"
        if (MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "widget") {
            echo $g_obj_MCI_Footnotes->a_obj_Task->ReferenceContainer();
        }
    }
}
