<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 24.05.14
 * Time: 14:47
 * Version: 1.2.0
 * Since: 1.2.0
 */

/**
 * adds a new button to the WYSIWYG editor for pages and posts
 * @param array $buttons
 * @return array
 * @since 1.2.0
 */
function footnotes_wysiwyg_editor_functions($buttons) {
    array_push($buttons, FOOTNOTES_PLUGIN_NAME);
    return $buttons;
}

/**
 * includes a javascript file to have a on-click function for the new button in the WYSIWYG editor
 * @param array $plugin_array
 * @return array
 * @since 1.2.0
 */
function footnotes_wysiwyg_editor_buttons($plugin_array) {
    $plugin_array[FOOTNOTES_PLUGIN_NAME] = plugins_url('/../js/wysiwyg-editor.js', __FILE__);
    return $plugin_array;
}

/**
 * adds a new button to the plain text editor for pages and posts
 * @since 1.2.0
 */
function footnotes_text_editor_buttons() {
    ?>
    <script type="text/javascript">
        /**
         * adds a tag in at the beginning and at the end of a selected text in the specific textarea
         * @param string elementID
         * @param string openTag
         * @param string closeTag
         */
        function footnotes_wrapText(elementID, openTag, closeTag) {
            var textArea = jQuery('#' + elementID);
            var len = textArea.val().length;
            var start = textArea[0].selectionStart;
            var end = textArea[0].selectionEnd;
            var selectedText = textArea.val().substring(start, end);
            var replacement = openTag + selectedText + closeTag;
            textArea.val(textArea.val().substring(0, start) + replacement + textArea.val().substring(end, len));
        }
        /**
         * adds a new button to the plain text editor
         */
        QTags.addButton( 'footnotes_quicktag_button', 'footnotes', footnotes_text_editor_callback );
        /**
         * callback function when the button is clicked
         * executes a ajax call to get the start and end tag for the footnotes and
         * adds them in before and after the selected text
         */
        function footnotes_text_editor_callback() {
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'footnotes_getTags',
                    data: ''
                },
                success: function(data, textStatus, XMLHttpRequest){
                    var l_arr_Tags = JSON.parse(data);
                    footnotes_wrapText("content", l_arr_Tags['start'], l_arr_Tags['end']);
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                }
            });
        }
    </script>
    <?php
}

/**
 * callback function for the WYSIWYG editor button and the plain text editor button
 * to get the start and end tag for the footnotes
 * echos the tags as json-string ("start" | "end")
 */
function footnotes_wysiwyg_ajax_callback() {
    require_once(dirname(__FILE__) . '/../includes/defines.php');
    require_once(dirname(__FILE__) . '/../includes/plugin-settings.php');

    /* load footnote settings */
    $g_arr_FootnotesSettings = footnotes_filter_options(FOOTNOTE_SETTINGS_CONTAINER, Class_FootnotesSettings::$a_arr_Default_Settings, false);

    /* get footnote starting tag */
    $l_str_StartingTag = $g_arr_FootnotesSettings[FOOTNOTE_INPUTFIELD_PLACEHOLDER_START];
    /*get footnote ending tag */
    $l_str_EndingTag = $g_arr_FootnotesSettings[FOOTNOTE_INPUTFIELD_PLACEHOLDER_END];

    if ($l_str_StartingTag == "userdefined" || $l_str_EndingTag == "userdefined") {
        /* get user defined footnote starting tag */
        $l_str_StartingTag = $g_arr_FootnotesSettings[FOOTNOTE_INPUTFIELD_PLACEHOLDER_START_USERDEFINED];
        /*get user defined footnote ending tag */
        $l_str_EndingTag = $g_arr_FootnotesSettings[FOOTNOTE_INPUTFIELD_PLACEHOLDER_END_USERDEFINED];
    }

    echo json_encode(array("start" => $l_str_StartingTag, "end" => $l_str_EndingTag));
    exit;
}