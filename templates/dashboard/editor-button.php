<?php ?>
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

        <?php
        /**
         * adds a new button to the plain text editor
        */
        function load_footnotes_quicktag_inline() {

            /**
             * Adds a check to ensure the quicktags script is available
             * preventing undefined error if no quicktags script
             * @author Erica Franz
            */
            if ( wp_script_is( 'quicktags' ) ) { ?>

                // And now the footnotes button
                QTags.addButton('MCI_Footnotes_QuickTag_button', 'footnotes', MCI_Footnotes_text_editor_callback);

                <?php }

        }

        add_action( 'admin_print_footer_scripts', 'load_footnotes_quicktag_inline' );

        ?>

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
                    action: 'footnotes_getTags'
                },
                success: function (data, textStatus, XMLHttpRequest) {
                    var l_arr_Tags = JSON.parse(data);
                    MCI_Footnotes_wrapText("content", l_arr_Tags['start'], l_arr_Tags['end']);
                },
                error: function (MLHttpRequest, textStatus, errorThrown) {}
            });
        }
    </script>
    <?php ?>
