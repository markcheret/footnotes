<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 24.05.14
 * Time: 14:47
 * Version: 1.2.0
 * Since: 1.2.0
 */

// add new button to the WYSIWYG - editor
add_filter("mce_buttons", "MCI_Footnotes_wysiwyg_editor_functions");
add_filter("mce_external_plugins", "MCI_Footnotes_wysiwyg_editor_buttons");
// add new button to the plain text editor
add_action("admin_print_footer_scripts", "MCI_Footnotes_text_editor_buttons");

// defines the callback function for the editor buttons
add_action("wp_ajax_nopriv_footnotes_getTags", "MCI_Footnotes_wysiwyg_ajax_callback");
add_action("wp_ajax_footnotes_getTags", "MCI_Footnotes_wysiwyg_ajax_callback");


/**
 * adds a new button to the WYSIWYG editor for pages and posts
 * @param array $buttons
 * @return array
 * @since 1.2.0
 */
function MCI_Footnotes_wysiwyg_editor_functions($buttons) {
    array_push($buttons, FOOTNOTES_PLUGIN_NAME);
    return $buttons;
}

/**
 * includes a javascript file to have a on-click function for the new button in the WYSIWYG editor
 * @param array $plugin_array
 * @return array
 * @since 1.2.0
 */
function MCI_Footnotes_wysiwyg_editor_buttons($plugin_array) {
    $plugin_array[FOOTNOTES_PLUGIN_NAME] = plugins_url('/../js/wysiwyg-editor.js', __FILE__);
    return $plugin_array;
}

/**
 * adds a new button to the plain text editor for pages and posts
 * @since 1.2.0
 */
function MCI_Footnotes_text_editor_buttons() {
    ?>
    <script type="text/javascript">
        /**
         * adds a tag in at the beginning and at the end of a selected text in the specific text area
         * @param string elementID
         * @param string openTag
         * @param string closeTag
         */
        function MCI_Footnotes_wrapText(elementID, openTag, closeTag) {
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
        QTags.addButton( 'MCI_Footnotes_QuickTag_button', 'footnotes', MCI_Footnotes_text_editor_callback );
        /**
         * callback function when the button is clicked
         * executes a ajax call to get the start and end tag for the footnotes and
         * adds them in before and after the selected text
         */
        function MCI_Footnotes_text_editor_callback() {
            jQuery.ajax({
                type: 'POST',
                url: '/wp-admin/admin-ajax.php',
                data: {
                    action: 'footnotes_getTags',
                    data: ''
                },
                success: function(data, textStatus, XMLHttpRequest){
                    var l_arr_Tags = JSON.parse(data);
					MCI_Footnotes_wrapText("content", l_arr_Tags['start'], l_arr_Tags['end']);
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
function MCI_Footnotes_wysiwyg_ajax_callback() {
	require_once(dirname(__FILE__) . "/defines.php");
    require_once(dirname(__FILE__) . '/plugin-settings.php');
	require_once(dirname(__FILE__) . '/../classes/admin.php');

    /* load footnote settings */
    $g_arr_FootnotesSettings = MCI_Footnotes_getOptions(true);

    /* get footnote starting tag */
    $l_str_StartingTag = $g_arr_FootnotesSettings[FOOTNOTES_INPUT_PLACEHOLDER_START];
    /*get footnote ending tag */
    $l_str_EndingTag = $g_arr_FootnotesSettings[FOOTNOTES_INPUT_PLACEHOLDER_END];

    if ($l_str_StartingTag == "userdefined" || $l_str_EndingTag == "userdefined") {
        /* get user defined footnote starting tag */
        $l_str_StartingTag = $g_arr_FootnotesSettings[FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED];
        /*get user defined footnote ending tag */
        $l_str_EndingTag = $g_arr_FootnotesSettings[FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED];
    }

    echo json_encode(array("start" => $l_str_StartingTag, "end" => $l_str_EndingTag));
    exit;
}