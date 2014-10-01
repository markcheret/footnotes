<?php
/**
 * Includes the Template Engine to load and handle all Template files of the Plugin.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 14.09.14 10:58
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
	 */
	public function __construct($p_str_FileType, $p_str_FileName, $p_str_Extension = "html") {
		// no template file type and/or file name set
		if (empty($p_str_FileType) || empty($p_str_FileName)) {
			return;
		}
		// get absolute path to the specified template file
		$l_str_TemplateFile = dirname(__FILE__) . "/../templates/" . $p_str_FileType . "/" . $p_str_FileName . "." . $p_str_Extension;
		// Template file does not exist
		if (!file_exists($l_str_TemplateFile)) {
			return;
		}
		// get Template file content
		$this->a_str_OriginalContent = str_replace("\n", "", file_get_contents($l_str_TemplateFile));
		$this->a_str_OriginalContent = str_replace("\r", "", $this->a_str_OriginalContent);
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