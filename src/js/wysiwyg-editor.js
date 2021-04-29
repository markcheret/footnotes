/**
 * Created by Stefan on 24.05.14.
 *
 * Edit: be careful to maintain version number near EOF
 */

/*eslint-disable no-undef */
(function () {
  tinymce.create('tinymce.plugins.Footnotes', {
    /*eslint-enable no-undef */
    /*eslint-disable jsdoc/no-undefined-types */
    /**
     * Initializes the plugin, this will be executed after the plugin has been created.
     * This call is done before the editor instance has finished its initialization so use the onInit event
     * of the editor instance to intercept that event.
     *
     * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
     * @param {string} url Absolute URL to where the plugin is located.
     */
    init: (ed, url) => {
      /*eslint-enable jsdoc/no-undefined-types */
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
          success: (data) => {
            const tags = JSON.parse(data);
            const returnText = tags.start + ed.selection.getContent() + tags.end;
            ed.insertContent(returnText);
          },
          /*eslint-disable no-unused-vars */
          error: (XMLHttpRequest, textStatus, errorThrown) => {
            /*eslint-enable no-unused-vars */
            /*eslint-disable no-console */
            console.error('Error: ' + errorThrown);
            /*eslint-enable no-console */
          },
        });
      });
    },

    /**
     * Returns information about the plugin as a name/value array.
     * The current keys are longname, author, authorurl, infourl and version.
     *
     * @return {Object} Information about the Plugin.
     *
     * Edit: needs updating the version number manually
     */
    getInfo: () => {
      return {
        longname: 'footnotes',
        author: 'Mark Cheret',
        authorurl: 'https://cheret.tech/footnotes/',
        infourl: 'https://wordpress.org/plugins/footnotes/',
        version: '2.7.4d',
      };
    },
  });

  /*eslint-disable no-undef */
  // Register plugin
  tinymce.PluginManager.add('footnotes', tinymce.plugins.Footnotes);
  /*eslint-enable no-undef */
})();
