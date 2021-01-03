<?php
/**
 * Includes the Template Engine to load and handle all Template files of the Plugin.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 10:58
 *
 * Last modified: 2021-01-02T2352+0100
 *
 * Edited:
 * @since 2.0.3  prettify reference container template
 * @since 2.0.3  further minify template content
 * @since 2.0.4  regex to delete multiple spaces
 * @since 2.0.6  prettify other templates (footnote, tooltip script, ref container row)
 * @since 2.2.6  delete a space before a closing pointy bracket
 * @since 2.2.6  support for custom templates in fixed location, while failing to add filter thanks to @misfist   2020-12-19T0606+0100
 * @see <https://wordpress.org/support/topic/template-override-filter/>
 * @since 2.4.0  templates may be in active theme, thanks to @misfist
 * @see <https://wordpress.org/support/topic/template-override-filter/#post-13846598>
 */


/**
 * Handles each Template file for the Plugin Frontend (e.g. Settings Dashboard, Public pages, ...).
 * Loads a template file, replaces all Placeholders and returns the replaced file content.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Template {

    /**
     * Directory name for dashboard templates.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @var string
     */
    const C_STR_DASHBOARD = "dashboard";

    /**
     * Directory name for public templates.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @var string
     */
    const C_STR_PUBLIC = "public";

    /**
     * Contains the content of the template after initialize.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @var string
     */
    private $a_str_OriginalContent = "";

    /**
     * Contains the content of the template after initialize with replaced place holders.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @var string
     */
    private $a_str_ReplacedContent = "";

    /**
     * Class Constructor. Reads and loads the template file without replace any placeholder.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_FileType Template file type (take a look on the Class constants).
     * @param string $p_str_FileName Template file name inside the Template directory without the file extension.
     * @param string $p_str_Extension Optional Template file extension (default: html)
     *
     * Edited:
     * @since 2.0.3  further minify template content
     * @since 2.0.4  regex to delete multiple spaces
     *
     * @since 2.2.6  support for custom templates   2020-12-19T0606+0100
     * @see <https://wordpress.org/support/topic/template-override-filter/>
     *
     * @since 2.2.6  delete a space before a closing pointy bracket
     * 
     * @since 2.4.0  look for custom template in the active theme first, thanks to @misfist
     * @see <https://wordpress.org/support/topic/template-override-filter/#post-13846598>
     */
    public function __construct($p_str_FileType, $p_str_FileName, $p_str_Extension = "html") {
        // no template file type and/or file name set
        if (empty($p_str_FileType) || empty($p_str_FileName)) {
            return;
        }

        // First try to load the template from the active theme in 'templates/footnotes/':
        $l_str_TemplateFile  = dirname(__FILE__) . "/../../../themes/";
        // get active theme dir name (parent theme unlikely to contain custom templates):
        // see <https://wordpress.stackexchange.com/questions/220942/how-to-get-the-active-themes-slug>
        // returns the stylesheet’s folder name, not the actual style sheet:
        $l_str_TemplateFile .= get_stylesheet();
        $l_str_TemplateFile .= "/templates/footnotes/" . $p_str_FileName . "." . $p_str_Extension;

        // else look for a custom template in a 'footnotes-custom' sibling folder:
        if (!file_exists($l_str_TemplateFile)) {

            $l_str_TemplateFile = dirname(__FILE__) . "/../../footnotes-custom/templates/" . $p_str_FileType . "/" . $p_str_FileName . "." . $p_str_Extension;

            // else load internal template:
            if (!file_exists($l_str_TemplateFile)) {

                // get absolute path to the specified template file
                $l_str_TemplateFile = dirname(__FILE__) . "/../templates/" . $p_str_FileType . "/" . $p_str_FileName . "." . $p_str_Extension;

                // do nothing if template file does not exist:
                if (!file_exists($l_str_TemplateFile)) {
                    return;
                }
            }
        }

        // minify template content to some extent:
        // get Template file content
        $this->a_str_OriginalContent = str_replace("\n", "", file_get_contents($l_str_TemplateFile));
        $this->a_str_OriginalContent = str_replace("\r", "", $this->a_str_OriginalContent);
        $this->a_str_OriginalContent = str_replace("\t", " ", $this->a_str_OriginalContent);
        $this->a_str_OriginalContent = preg_replace('# +#', " ", $this->a_str_OriginalContent);
        $this->a_str_OriginalContent = str_replace(" >", ">", $this->a_str_OriginalContent);
        $this->reload();
    }

    /**
     * Replace all placeholders specified in array.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @param array $p_arr_Placeholders Placeholders (key = placeholder, value = value).
     * @return bool True on Success, False if Placeholders invalid.
     */
    public function replace($p_arr_Placeholders) {
        // no placeholders set
        if (empty($p_arr_Placeholders)) {
            return false;
        }
        // template content is empty
        if (empty($this->a_str_ReplacedContent)) {
            return false;
        }
        // iterate through each placeholder and replace it with its value
        foreach($p_arr_Placeholders as $l_str_Placeholder => $l_str_Value) {
            $this->a_str_ReplacedContent = str_replace("[[" . $l_str_Placeholder . "]]", $l_str_Value, $this->a_str_ReplacedContent);
        }
        // success
        return true;
    }

    /**
     * Reloads the original content of the template file.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     */
    public function reload() {
        $this->a_str_ReplacedContent = $this->a_str_OriginalContent;
    }

    /**
     * Returns the content of the template file with replaced placeholders.
     *
     * @author Stefan Herndler
     * @since  1.5.0
     * @return string Template content with replaced placeholders.
     */
    public function getContent() {
        return $this->a_str_ReplacedContent;
    }

} // end of class
