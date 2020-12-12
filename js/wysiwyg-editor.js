/**
 * Created by Stefan on 24.05.14.
 * 
 * 
 * Edit: be careful to maintain version number near EOF   2020-12-11T1225+0100
 */

(function() {
    tinymce.create('tinymce.plugins.Footnotes', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished its initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addButton('footnotes', {
                title : 'footnotes',
                cmd : 'footnotes',
                image : url + '/../img/fn-wysiwyg.png'
            });

            ed.addCommand('footnotes', function() {
                jQuery.ajax({
                    type: 'POST',
                    url: './admin-ajax.php',
                    data: {
                        action: 'footnotes_getTags'
                    },
                    success: function(data, textStatus, XMLHttpRequest){
                        var l_arr_Tags = JSON.parse(data);
                        var return_text = l_arr_Tags['start'] + ed.selection.getContent() + l_arr_Tags['end'];
                        ed.execCommand('insertHTML', true, return_text);
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown){
                        console.log("Error: " + errorThrown);
                    }
                });
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
		 * 
		 * Edit: needs update the version number manually   2020-12-11T1224+0100
         */
        getInfo : function() {
            return {
                longname : 'Inserts the Footnotes short code.',
                author : 'Mark Cheret',
                authorurl : 'https://cheret.de',
                infourl : 'https://wordpress.org/plugins/footnotes/',
                version : "2.1.6"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('footnotes', tinymce.plugins.Footnotes);
})();
