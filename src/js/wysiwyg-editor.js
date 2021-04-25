/**
 * Created by Stefan on 24.05.14.
 *
 * Edit: be careful to maintain version number near EOF
 */

(function () {
  tinymce.create('tinymce.plugins.Footnotes', {
    /**
     * Initializes the plugin, this will be executed after the plugin has been created.
     * This call is done before the editor instance has finished its initialization so use the onInit event
     * of the editor instance to intercept that event.
     *
     * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
     * @param {string} url Absolute URL to where the plugin is located.
     */
    init: function (ed, url) {
      ed.addButton('footnotes', {
        title: 'footnotes',
        cmd: 'footnotes',
        image: url + '/../img/fn-wysiwyg.png',
      });

      ed.addCommand('footnotes', function () {
        jQuery.ajax({
          type: 'POST',
          url: './admin-ajax.php',
          data: {
            action: 'footnotes_getTags',
          },
          success: function (data, textStatus, XMLHttpRequest) {
            var tags = JSON.parse(data);
            var returnText = tags.start + ed.selection.getContent() + tags.end;
            ed.execCommand('insertHTML', true, returnText);
          },
          error: function (MLHttpRequest, textStatus, errorThrown) {
            console.log('Error: ' + errorThrown);
          },
        });
      });
    },

    /**
     * Creates control instances based on the incoming name. This method is normally not
     * needed since the addButton method of the tinymce.Editor class is an easier way of adding buttons,
     * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
     * method can be used to create those.
     *
     * @param {String} n Name of the control to create.
     * @param {tinymce.ControlManager} cm Control manager to use in order to create new control.
     * @return {tinymce.ui.Control} New control instance or null if no control was created.
     */
    createControl: function (n, cm) {
      return null;
    },

    /**
     * Returns information about the plugin as a name/value array.
     * The current keys are longname, author, authorurl, infourl and version.
     *
     * @return {Object} Name/value array containing information about the plugin.
     *
     * Edit: needs updating the version number manually
     */
    getInfo: function () {
      return {
        longname: 'Inserts the Footnotes short code.',
        author: 'Mark Cheret',
        authorurl: 'https://cheret.org/footnotes/',
        infourl: 'https://wordpress.org/plugins/footnotes/',
        version: '2.7.3d',
      };
    },
  });

  // Register plugin
  tinymce.PluginManager.add('footnotes', tinymce.plugins.Footnotes);
})();
