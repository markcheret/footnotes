<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 30.07.14 12:07
 * Version: 1.0
 * Since: 1.3
 */

// define class only once
if (!class_exists("MCI_Footnotes_Task")) :

/**
 * Class MCI_Footnotes_Task
 * @since 1.3
 */
class MCI_Footnotes_Task {

	// array containing the settings
	public $a_arr_Settings = array();
	// bool admin allows the Love Me slug
	public static $a_bool_AllowLoveMe = true;
	// array containing all found footnotes
	public static $a_arr_Footnotes = array();

	/**
	 * @constructor
	 * @since 1.3
	 */
	public function __construct() {
		require_once(dirname( __FILE__ ) . "/admin.php");
		// load footnote settings
		$this->a_arr_Settings = MCI_Footnotes_getOptions(false);
	}

	/**
	 * add WordPress hooks
	 * @since 1.3
	 */
	public function Register() {
		// adds the custom css to the header
		add_action('wp_head', array($this, "Header"));
		// stops listening to the output and replaces the footnotes
		add_action('get_footer', array($this, "Footer"));
		// adds the love and share me slug to the footer
		add_action('wp_footer', array($this, "Love"));

		// moves these contents through the replacement function
		add_filter('the_content', array($this, "Content"));
		add_filter('the_excerpt', array($this, "Excerpt"));
		add_filter('widget_title', array($this, "WidgetTitle"));
		add_filter('widget_text', array($this, "WidgetText"));
	}

	/**
	 * outputs the custom css to the header
	 * @since 1.3
	 */
	public function Header() {
		?>
		<style type="text/css" media="screen"><?php echo $this->a_arr_Settings[FOOTNOTES_INPUT_CUSTOM_CSS]; ?></style>
		<?php
	}

	/**
	 * replaces footnotes tags in the post content
	 * @since 1.3
	 * @param string $p_str_Content
	 * @return string
	 */
	public function Content($p_str_Content) {
		// returns content
		return $this->exec($p_str_Content, $this->a_arr_Settings[FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE] == "post_end" ? true : false);
	}

	/**
	 * replaces footnotes tags in the post excerpt
	 * @since 1.3
	 * @param string $p_str_Content
	 * @return string
	 */
	public function Excerpt($p_str_Content) {
		require_once(dirname( __FILE__ ) . "/convert.php");
		// search in the excerpt only if activated
		if (MCI_Footnotes_Convert::toBool($this->a_arr_Settings[FOOTNOTES_INPUT_SEARCH_IN_EXCERPT])) {
			return $this->exec($p_str_Content, false);
		}
		// returns content
		return $p_str_Content;
	}

	/**
	 * replaces footnotes tags in the widget title
	 * @since 1.3
	 * @param string $p_str_Content
	 * @return string
	 */
	public function WidgetTitle($p_str_Content) {
		// returns content
		return $p_str_Content;
	}

	/**
	 * replaces footnotes tags in the widget text
	 * @since 1.3
	 * @param string $p_str_Content
	 * @return string
	 */
	public function WidgetText($p_str_Content) {
		// returns content
		return $this->exec( $p_str_Content, $this->a_arr_Settings[FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE] == "post_end" ? true : false);
	}

	/**
	 * outputs the reference container to the footer
	 * @since 1.3
	 */
	public function Footer() {
		if ($this->a_arr_Settings[FOOTNOTES_INPUT_REFERENCE_CONTAINER_PLACE] == "footer") {
			echo $this->ReferenceContainer();
		}
	}

	/**
	 * output the love me slug in the footer
	 * @since 1.3
	 */
	public function Love() {
		// get setting for love and share this plugin and convert it to boolean
		$l_str_LoveMeText = $this->a_arr_Settings[FOOTNOTES_INPUT_LOVE];
		// check if the admin allows to add a link to the footer
		if (empty($l_str_LoveMeText) || strtolower($l_str_LoveMeText) == "no" || !self::$a_bool_AllowLoveMe) {
			return;
		}
		// get random love me text
		if (strtolower($l_str_LoveMeText) == "random") {
			$l_str_LoveMeText = "text-" . rand(1,3);
		}
		switch ($l_str_LoveMeText) {
			case "text-1":
				$l_str_LoveMeText = sprintf(__('I %s %s', FOOTNOTES_PLUGIN_NAME), FOOTNOTES_LOVE_SYMBOL, FOOTNOTES_PLUGIN_PUBLIC_NAME_LINKED);
				break;
			case "text-2":
				$l_str_LoveMeText = sprintf(__('this site uses the awesome %s Plugin', FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME_LINKED);
				break;
			case "text-3":
			default:
				$l_str_LoveMeText = sprintf(__('extra smooth %s', FOOTNOTES_PLUGIN_NAME), FOOTNOTES_PLUGIN_PUBLIC_NAME_LINKED);
				break;
		}
		echo '<div style="text-align:center; color:#acacac;">' . $l_str_LoveMeText . '</div>';
	}


	/**
	 * replaces all footnotes in the given content
	 * loading settings if not happened yet since 1.0-gamma
	 * @since 1.0
	 * @param string $p_str_Content
	 * @param bool $p_bool_OutputReferences [default: true]
	 * @return string
	 */
	public function exec($p_str_Content, $p_bool_OutputReferences = true) {
		// replace all footnotes in the content
		$p_str_Content = $this->Lookup($p_str_Content, true);
		$p_str_Content = $this->Lookup($p_str_Content, false);

		// add the reference list if set
		if ($p_bool_OutputReferences) {
			$p_str_Content = $p_str_Content . $this->ReferenceContainer();
		}
		// checks if the user doesn't want to have a 'love me' on current page
		// @since 1.1.1
		if (strpos($p_str_Content, FOOTNOTES_NO_SLUGME_PLUG) !== false) {
			self::$a_bool_AllowLoveMe = false;
			$p_str_Content = str_replace(FOOTNOTES_NO_SLUGME_PLUG, "", $p_str_Content);
		}
		// return the replaced content
		return $p_str_Content;
	}

	/**
	 * replace all footnotes in the given string and adds them to an array
	 * using a personal starting and ending tag for the footnotes since 1.0-gamma
	 * @since 1.0
	 * @param string $p_str_Content
	 * @param bool $p_bool_ConvertHtmlChars
	 * @return string
	 */
	public function Lookup($p_str_Content, $p_bool_ConvertHtmlChars = true) {
		require_once(dirname( __FILE__ ) . "/convert.php");
		// contains the index for the next footnote on this page
		$l_int_FootnoteIndex = count(self::$a_arr_Footnotes) + 1;
		// contains the starting position for the lookup of a footnote
		$l_int_PosStart = 0;
		// contains the footnote template
		$l_str_FootnoteTemplate = file_get_contents(FOOTNOTES_TEMPLATES_DIR . "footnote.html");
		// get footnote starting tag
		$l_str_StartingTag = $this->a_arr_Settings[FOOTNOTES_INPUT_PLACEHOLDER_START];
		// get footnote ending tag
		$l_str_EndingTag = $this->a_arr_Settings[FOOTNOTES_INPUT_PLACEHOLDER_END];
		// get footnote counter style
		$l_str_CounterStyle = $this->a_arr_Settings[FOOTNOTES_INPUT_COUNTER_STYLE];
		// get footnote layout before index
		$l_str_BeforeIndex = $this->a_arr_Settings[FOOTNOTES_INPUT_CUSTOM_STYLING_BEFORE];
		// get footnote layout after index
		$l_str_AfterIndex = $this->a_arr_Settings[FOOTNOTES_INPUT_CUSTOM_STYLING_AFTER];

		if ($l_str_StartingTag == "userdefined" || $l_str_EndingTag == "userdefined") {
			// get user defined footnote starting tag
			$l_str_StartingTag = $this->a_arr_Settings[FOOTNOTES_INPUT_PLACEHOLDER_START_USERDEFINED];
			// get user defined footnote ending tag
			$l_str_EndingTag = $this->a_arr_Settings[FOOTNOTES_INPUT_PLACEHOLDER_END_USERDEFINED];
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

		// check for a footnote placeholder in the current page
		do {
			// get first occurrence of a footnote starting tag
			$l_int_PosStart = strpos($p_str_Content, $l_str_StartingTag, $l_int_PosStart);
			// tag not found
			if ($l_int_PosStart === false) {
				break;
			}
			// get first occurrence of a footnote ending tag after the starting tag
			$l_int_PosEnd = strpos($p_str_Content, $l_str_EndingTag, $l_int_PosStart);
			// tag not found
			if ($l_int_PosEnd === false) {
				$l_int_PosStart++;
				continue;
			}
			// get length of footnote text
			$l_int_Length = $l_int_PosEnd - $l_int_PosStart;
			// get text inside footnote
			$l_str_FootnoteText = substr($p_str_Content, $l_int_PosStart + strlen($l_str_StartingTag), $l_int_Length - strlen($l_str_StartingTag));
			// set replacing string for the footnote
			$l_str_ReplaceText = str_replace("[[FOOTNOTE INDEX]]", MCI_Footnotes_Convert::Index($l_int_FootnoteIndex, $l_str_CounterStyle), $l_str_FootnoteTemplate);
			$l_str_ReplaceText = str_replace("[[FOOTNOTE TEXT]]", $l_str_FootnoteText, $l_str_ReplaceText);
			$l_str_ReplaceText = str_replace("[[FOOTNOTE BEFORE]]", $l_str_BeforeIndex, $l_str_ReplaceText);
			$l_str_ReplaceText = str_replace("[[FOOTNOTE AFTER]]", $l_str_AfterIndex, $l_str_ReplaceText);
			$l_str_ReplaceText = preg_replace('@[\s]{2,}@',' ',$l_str_ReplaceText);
			// replace footnote in content
			$p_str_Content = substr_replace($p_str_Content, $l_str_ReplaceText, $l_int_PosStart, $l_int_Length + strlen($l_str_EndingTag));
			// set footnote to the output box at the end
			self::$a_arr_Footnotes[] = $l_str_FootnoteText;
			// increase footnote index
			$l_int_FootnoteIndex++;
			// add offset to the new starting position
			$l_int_PosStart += ($l_int_PosEnd - $l_int_PosStart);
		} while (true);

		// return content
		return $p_str_Content;
	}

	/**
	 * looks through all footnotes that has been replaced in the current content and
	 * adds a reference to the footnote at the end of the content
	 * function to collapse the reference container since 1.0-beta
	 * @since 1.0
	 * @return string
	 */
	public function ReferenceContainer() {
		// no footnotes has been replaced on this page
		if (empty(self::$a_arr_Footnotes)) {
			return "";
		}
		require_once(dirname( __FILE__ ) . "/convert.php");

		// get setting for combine identical footnotes and convert it to boolean
		$l_bool_CombineIdentical = MCI_Footnotes_Convert::toBool($this->a_arr_Settings[FOOTNOTES_INPUT_COMBINE_IDENTICAL]);
		// get setting for preferences label
		$l_str_ReferencesLabel = $this->a_arr_Settings[FOOTNOTES_INPUT_REFERENCES_LABEL];
		// get setting for collapse reference footnotes and convert it to boolean
		$l_bool_CollapseReference = MCI_Footnotes_Convert::toBool($this->a_arr_Settings[FOOTNOTES_INPUT_COLLAPSE_REFERENCES]);
		// get footnote counter style
		$l_str_CounterStyle = $this->a_arr_Settings[FOOTNOTES_INPUT_COUNTER_STYLE];

		// add expand/collapse buttons to the reference label if collapsed by default
		// @since 1.2.2
		$l_str_CollapseButtons = "";
		if ($l_bool_CollapseReference) {
			$l_str_CollapseButtons = '&nbsp;&nbsp;&nbsp;[ <a id="footnote_reference_container_collapse_button" style="cursor:pointer;" onclick="footnote_expand_collapse_reference_container();">+</a> ]';
		}

		// output string, prepare it with the reference label as headline
		$l_str_Output = '<div class="footnote_container_prepare"><p><span onclick="footnote_expand_reference_container();">' . $l_str_ReferencesLabel . '</span><span>' .$l_str_CollapseButtons . '</span></p></div>';
		// add a box around the footnotes
		$l_str_Output .= '<div id="' . FOOTNOTES_REFERENCES_CONTAINER_ID . '"';
		// add class to hide the references by default, if the user wants it
		if ($l_bool_CollapseReference) {
			$l_str_Output .= ' class="footnote_hide_box"';
		}
		$l_str_Output .= '>';

		// contains the footnote template
		$l_str_FootnoteTemplate = file_get_contents(FOOTNOTES_TEMPLATES_DIR . "container.html");

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
			$l_str_FootnoteIndex = MCI_Footnotes_Convert::Index(($l_str_Index + 1), $l_str_CounterStyle);

			// check if it isn't the last footnote in the array
			if ($l_str_FirstFootnoteIndex < count(self::$a_arr_Footnotes) && $l_bool_CombineIdentical) {
				// get all footnotes that I haven't passed yet
				for ($l_str_CheckIndex = $l_str_FirstFootnoteIndex; $l_str_CheckIndex < count(self::$a_arr_Footnotes); $l_str_CheckIndex++) {
					// check if a further footnote is the same as the actual one
					if ($l_str_FootnoteText == self::$a_arr_Footnotes[$l_str_CheckIndex] && !empty($g_arr_Footnotes[$l_str_CheckIndex])) {
						// set the further footnote as empty so it won't be displayed later
						$g_arr_Footnotes[$l_str_CheckIndex] = "";
						// add the footnote index to the actual index
						$l_str_FootnoteIndex .= ", " . MCI_Footnotes_Convert::Index(($l_str_CheckIndex + 1), $l_str_CounterStyle);
					}
				}
			}

			// add the footnote to the output box
			// added function to convert the counter style in the reference container (bugfix for the link to the footnote) in version 1.0.6
			$l_str_ReplaceText = str_replace("[[FOOTNOTE INDEX SHORT]]", MCI_Footnotes_Convert::Index($l_str_FirstFootnoteIndex, $l_str_CounterStyle), $l_str_FootnoteTemplate);
			$l_str_ReplaceText = str_replace("[[FOOTNOTE INDEX]]", $l_str_FootnoteIndex, $l_str_ReplaceText);
			$l_str_ReplaceText = str_replace("[[FOOTNOTE TEXT]]", $l_str_FootnoteText, $l_str_ReplaceText);
			$l_str_ReplaceText = preg_replace('@[\s]{2,}@',' ',$l_str_ReplaceText);
			// add the footnote container to the output
			$l_str_Output = $l_str_Output . $l_str_ReplaceText;
		}
		// add closing tag for the div of the references container
		$l_str_Output = $l_str_Output . '</div>';
		// add a javascript to expand the reference container when clicking on a footnote or the reference label
		$l_str_Output .= '
			<script type="text/javascript">
				function footnote_expand_reference_container(p_str_ID) {
					jQuery("#' . FOOTNOTES_REFERENCES_CONTAINER_ID . '").show();
					if (p_str_ID.length > 0) {
						jQuery(p_str_ID).focus();
					}
				}
				function footnote_expand_collapse_reference_container() {
					var l_obj_ReferenceContainer = jQuery("#' . FOOTNOTES_REFERENCES_CONTAINER_ID . '");
					if (l_obj_ReferenceContainer.is(":hidden")) {
						l_obj_ReferenceContainer.show();
						jQuery("#footnote_reference_container_collapse_button").text("-");
					} else {
						l_obj_ReferenceContainer.hide();
						jQuery("#footnote_reference_container_collapse_button").text("+");
					}
				}
			</script>
		';

		// free all found footnotes if reference container will be displayed
		self::$a_arr_Footnotes = array();
		// return the output string
		return $l_str_Output;
	}

} // class MCI_Footnotes_Task

endif;