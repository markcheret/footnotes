<?php
/**
 * Includes the core function of the Plugin - Search and Replace the Footnotes.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0
 */


/**
 * Looks for Footnotes short codes and replaces them. Also displays the Reference Container.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Task {

	/**
	 * Contains all footnotes found on current public page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var array
	 */
	public static $a_arr_Footnotes = array();

	/**
	 * Flag if the display of 'LOVE FOOTNOTES' is allowed on the current public page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var bool
	 */
	public static $a_bool_AllowLoveMe = true;

	/**
	 * Register WordPress Hooks to replace Footnotes in the content of a public page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function registerHooks() {
		// append custom css to the header
		add_action('wp_head', array($this, "Header"));

		// append the reference container to the footer if enabled
		if (MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "footer") {
			add_action('get_footer', array($this, "Footer"));
		}

		// append the love and share me slug to the footer
		add_action('wp_footer', array($this, "Love"));

		// replace footnotes in the content of the page/post
		add_filter('the_content', array($this, "Content"), 10);

		// search for footnotes in the excerpt
		add_filter('the_excerpt', array($this, "Excerpt"), 1);
		add_filter('get_the_excerpt', array($this, "Excerpt"), 1);

		// replace footnotes in the content of a widget
		add_filter('widget_text', array($this, "WidgetText"), 99);
	}

	/**
	 * Outputs the custom css to the header of the public page.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Header() {
		?>
		<style type="text/css" media="screen"><?php echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS) ?></style>
		<?php
		// reset stored footnotes when displaying the header
		self::$a_arr_Footnotes = array();
	}

	/**
	 * Displays the Reference Container if set to the footer.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Footer() {
		echo $this->ReferenceContainer();
	}

	/**
	 * Displays the 'LOVE FOOTNOTES' slug if enabled.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function Love() {
		// get setting for love and share this plugin
		$l_str_LoveMeIndex = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE);
		// check if the admin allows to add a link to the footer
		if (empty($l_str_LoveMeIndex) || strtolower($l_str_LoveMeIndex) == "no" || !self::$a_bool_AllowLoveMe) {
			return;
		}
		// set a hyperlink to the word "footnotes" in the Love slug
		$l_str_LinkedName = sprintf('<a href="http://wordpress.org/plugins/footnotes/" target="_blank" style="text-decoration:none;">%s</a>',MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME);
		// get random love me text
		if (strtolower($l_str_LoveMeIndex) == "random") {
			$l_str_LoveMeIndex = "text-" . rand(1,3);
		}
		switch ($l_str_LoveMeIndex) {
			case "text-1":
				$l_str_LoveMeText = sprintf(__('I %s %s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, $l_str_LinkedName);
				break;
			case "text-2":
				$l_str_LoveMeText = sprintf(__('this site uses the awesome %s Plugin', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName);
				break;
			case "text-3":
			default:
				$l_str_LoveMeText = sprintf(__('extra smooth %s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName);
				break;
		}
		echo sprintf('<div style="text-align:center; color:#acacac;">%s</div>', $l_str_LoveMeText);
	}

	/**
	 * Replaces footnotes in the content of the current page/post.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Page/Post content.
	 * @return string Content with replaced footnotes.
	 */
	public function Content($p_str_Content) {
		// appends the reference container if set to "post_end"
		return $this->exec($p_str_Content, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "post_end" ? true : false);
	}

	/**
	 * Replaces footnotes in the excerpt of the current page/post.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Page/Post content.
	 * @return string Content with replaced footnotes.
	 */
	public function Excerpt($p_str_Content) {
		return $this->exec($p_str_Content, false, !MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT)));
	}

	/**
	 * Replaces footnotes in the content of the current widget.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Widget content.
	 * @return string Content with replaced footnotes.
	 */
	public function WidgetText($p_str_Content) {
		// appends the reference container if set to "post_end"
		return $this->exec($p_str_Content, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "post_end" ? true : false);
	}


	/**
	 * Replaces all footnotes that occur in the given content.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Any string that may contain footnotes to be replaced.
	 * @param bool $p_bool_OutputReferences Appends the Reference Container to the output if set to true, default true.
	 * @param bool $p_bool_HideFootnotesText Hide footnotes found in the string.
	 * @return string
	 */
	public function exec($p_str_Content, $p_bool_OutputReferences = true, $p_bool_HideFootnotesText = false) {
		// replace all footnotes in the content, settings are converted to html characters
		$p_str_Content = $this->search($p_str_Content, true, $p_bool_HideFootnotesText);
		// replace all footnotes in the content, settings are NOT converted to html characters
		$p_str_Content = $this->search($p_str_Content, false, $p_bool_HideFootnotesText);

		// append the reference container
		if ($p_bool_OutputReferences) {
			$p_str_Content = $p_str_Content . $this->ReferenceContainer();
		}

		// take a look if the LOVE ME slug should NOT be displayed on this page/post, remove the short code if found
		if (strpos($p_str_Content, MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG) !== false) {
			self::$a_bool_AllowLoveMe = false;
			$p_str_Content = str_replace(MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG, "", $p_str_Content);
		}
		// return the content with replaced footnotes and optional reference container append
		return $p_str_Content;
	}

	/**
	 * Replaces all footnotes in the given content and appends them to the static property.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @param string $p_str_Content Content to be searched for footnotes.
	 * @param bool $p_bool_ConvertHtmlChars html encode settings, default true.
	 * @param bool $p_bool_HideFootnotesText Hide footnotes found in the string.
	 * @return string
	 */
	public function search($p_str_Content, $p_bool_ConvertHtmlChars, $p_bool_HideFootnotesText) {
		// contains the index for the next footnote on this page
		$l_int_FootnoteIndex = count(self::$a_arr_Footnotes) + 1;
		// contains the starting position for the lookup of a footnote
		$l_int_PosStart = 0;
		// get start and end tag for the footnotes short code
		$l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START);
		$l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END);
		if ($l_str_StartingTag == "userdefined" || $l_str_EndingTag == "userdefined") {
			$l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED);
			$l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED);
		}
		// decode html special chars
		if ($p_bool_ConvertHtmlChars) {
			$l_str_StartingTag = htmlspecialchars($l_str_StartingTag);
			$l_str_EndingTag = htmlspecialchars($l_str_EndingTag);
		}
		// if footnotes short code is empty, return the content without changes
		if (empty($l_str_StartingTag) || empty($l_str_EndingTag)) {
			return $p_str_Content;
		}

		if (!$p_bool_HideFootnotesText) {
			// load template file
			$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "footnote");
		} else {
			$l_obj_Template = null;
		}

		// search footnotes short codes in the content
		do {
			// get first occurrence of the footnote short code [start]
			$l_int_PosStart = strpos($p_str_Content, $l_str_StartingTag, $l_int_PosStart);
			// no short code found, stop here
			if ($l_int_PosStart === false) {
				break;
			}
			// get first occurrence of a footnote short code [end]
			$l_int_PosEnd = strpos($p_str_Content, $l_str_EndingTag, $l_int_PosStart);
			// no short code found, stop here
			if ($l_int_PosEnd === false) {
				break;
			}
			// calculate the length of the footnote
			$l_int_Length = $l_int_PosEnd - $l_int_PosStart;
			// get footnote text
			$l_str_FootnoteText = substr($p_str_Content, $l_int_PosStart + strlen($l_str_StartingTag), $l_int_Length - strlen($l_str_StartingTag));
			// Text to be displayed instead of the footnote
			$l_str_FootnoteReplaceText = "";
			// display the footnote as mouse-over box
			if (!$p_bool_HideFootnotesText) {
				// fill the footnotes template
				$l_obj_Template->replace(
					array(
						"index" => MCI_Footnotes_Convert::Index($l_int_FootnoteIndex, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE)),
						"text" => $l_str_FootnoteText,
						"before" => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE),
						"after" => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER)
					)
				);
				$l_str_FootnoteReplaceText = $l_obj_Template->getContent();
				// reset the template
				$l_obj_Template->reload();
			}
			// replace the footnote with the template
			$p_str_Content = substr_replace($p_str_Content, $l_str_FootnoteReplaceText, $l_int_PosStart, $l_int_Length + strlen($l_str_EndingTag));
			// add footnote only if not empty
			if (!empty($l_str_FootnoteText)) {
				// set footnote to the output box at the end
				self::$a_arr_Footnotes[] = $l_str_FootnoteText;
				// increase footnote index
				$l_int_FootnoteIndex++;
			}
			// add offset to the new starting position
			$l_int_PosStart += $l_int_Length + strlen($l_str_EndingTag);
		} while (true);

		// return content
		return $p_str_Content;
	}

	/**
	 * Generates the reference container.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @return string
	 */
	public function ReferenceContainer() {
		// no footnotes has been replaced on this page
		if (empty(self::$a_arr_Footnotes)) {
			return "";
		}
		// get html arrow
		$l_str_Arrow = MCI_Footnotes_Convert::getArrow(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW));
		// set html arrow to the first one if invalid index defined
		if (is_array($l_str_Arrow)) {
			$l_str_Arrow = MCI_Footnotes_Convert::getArrow(0);
		}
		// get user defined arrow
		$l_str_ArrowUserDefined = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED);
		if (!empty($l_str_ArrowUserDefined)) {
			$l_str_Arrow = $l_str_ArrowUserDefined;
		}

		// load template file
		$l_str_Body = "";
		$l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body");

		// loop through all footnotes found in the page
		for ($l_str_Index = 0; $l_str_Index < count(self::$a_arr_Footnotes); $l_str_Index++) {
			// get footnote text
			$l_str_FootnoteText = self::$a_arr_Footnotes[$l_str_Index];
			// if footnote is empty, get to the next one
			if (empty($l_str_FootnoteText)) {
				continue;
			}
			// get footnote index
			$l_str_FirstFootnoteIndex = ($l_str_Index + 1);
			$l_str_FootnoteIndex = MCI_Footnotes_Convert::Index(($l_str_Index + 1),  MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));

			// check if it isn't the last footnote in the array
			if ($l_str_FirstFootnoteIndex < count(self::$a_arr_Footnotes) && MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES))) {
				// get all footnotes that I haven't passed yet
				for ($l_str_CheckIndex = $l_str_FirstFootnoteIndex; $l_str_CheckIndex < count(self::$a_arr_Footnotes); $l_str_CheckIndex++) {
					// check if a further footnote is the same as the actual one
					if ($l_str_FootnoteText == self::$a_arr_Footnotes[$l_str_CheckIndex]) {
						// set the further footnote as empty so it won't be displayed later
						self::$a_arr_Footnotes[$l_str_CheckIndex] = "";
						// add the footnote index to the actual index
						$l_str_FootnoteIndex .= ", " . MCI_Footnotes_Convert::Index(($l_str_CheckIndex + 1), MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));
					}
				}
			}
			// replace all placeholders in the template
			$l_obj_Template->replace(
				array(
					"index" => $l_str_FootnoteIndex,
					"index-int" => MCI_Footnotes_Convert::Index($l_str_FirstFootnoteIndex, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE)),
					"arrow" => $l_str_Arrow,
					"text" => $l_str_FootnoteText
				)
			);
			$l_str_Body .= $l_obj_Template->getContent();
			$l_obj_Template->reload();
		}

		// load template file
		$l_obj_TemplateContainer = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container");
		$l_obj_TemplateContainer->replace(
			array(
				"label" => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME),
				"buttons" => MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE)) ? '&nbsp;&nbsp;&nbsp;[ <a id="footnote_reference_container_collapse_button" style="cursor:pointer;" onclick="footnote_expand_collapse_reference_container();">+</a> ]' : '',
				"id" => "footnote_references_container",
				"class" =>  MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE)) ? 'footnote_hide_box' : '',
				"content" => $l_str_Body
			)
		);

		// free all found footnotes if reference container will be displayed
		self::$a_arr_Footnotes = array();
		return $l_obj_TemplateContainer->getContent();
	}
}