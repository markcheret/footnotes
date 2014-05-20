<?php
/**
 * User: she
 * Date: 30.04.14
 * Time: 16:44
 */


/**
 * reads a option field, filters the values and returns the filtered option array
 * @param string $p_str_OptionsField
 * @return array
 */
function footnote_filter_options($p_str_OptionsField)
{
	$l_arr_Options = get_option($p_str_OptionsField);
	/* loop through all keys in the array and filters them */
	foreach ($l_arr_Options as $l_str_Key => $l_str_Value) {
		$l_arr_Options[$l_str_Key] = stripcslashes($l_str_Value);
	}
	/* returns the filtered array */
	return $l_arr_Options;
}

/**
 * reads the wordpress langauge and returns only the language code lowercase
 * removes the localization code
 * @return string (only the "en" from "en_US")
 */
function footnotes_getLanguageCode()
{
	/* read current wordpress langauge */
	$l_str_locale = apply_filters('plugin_locale', get_locale(), FOOTNOTES_PLUGIN_NAME);
	/* check if wordpress language has a localization (e.g. "en_US" or "de_AT") */
	if (strpos($l_str_locale, "_") !== false) {
		/* remove localization code */
		$l_arr_languageCode = explode("_", $l_str_locale);
		$l_str_languageCode = $l_arr_languageCode[0];
		return $l_str_languageCode;
	}
	/* return language code lowercase */
	return strtolower($l_str_locale);
}

/**
 * loads the langauge file including localization if exists
 * otherwise loads the langauge file without localization information
 */
function footnotes_load_language()
{
	/* read current wordpress langauge */
	$l_str_locale = apply_filters('plugin_locale', get_locale(), FOOTNOTES_PLUGIN_NAME);
	/* get only language code (removed localization code) */
	$l_str_languageCode = footnotes_getLanguageCode();

	/* language file with localization exists */
	if ($l_bool_loaded = load_textdomain(FOOTNOTES_PLUGIN_NAME, dirname(__FILE__) . '/languages/' . FOOTNOTES_PLUGIN_NAME . '-' . $l_str_locale . '.mo')) {

	/* language file without localization exists */
	} else if ($l_bool_loaded = load_textdomain(FOOTNOTES_PLUGIN_NAME, dirname(__FILE__) . '/languages/' . FOOTNOTES_PLUGIN_NAME . '-' . $l_str_languageCode . '.mo')) {

	/* load default language file, nothing will happen: default language will be used (=english) */
	} else {
		load_textdomain(FOOTNOTES_PLUGIN_NAME, dirname(__FILE__) . '/languages/' . FOOTNOTES_PLUGIN_NAME . '-en.mo');
	}
}

/**
 * register and add a stylesheet to the public pages
 */
function footnotes_public_page_scripts() {
	/* register stylesheet for the public page */
	wp_register_style('footnote_public_style', plugins_url('css/footnote.css', __FILE__));
	/* add stylesheet to the public page */
	wp_enqueue_style('footnote_public_style');
}

/**
 * @param string $p_str_FootnoteText
 * @return string
 */
function footnote_example_replacer($p_str_FootnoteText) {
	$l_int_FootnoteIndex = 1;
	$l_str_FootnoteTemplate = file_get_contents(dirname(__FILE__) . "/templates/footnote.html");
	$l_str_ReplaceText = str_replace("[[FOOTNOTE INDEX]]", $l_int_FootnoteIndex, $l_str_FootnoteTemplate);
	$l_str_ReplaceText = str_replace("[[FOOTNOTE TEXT]]", $p_str_FootnoteText, $l_str_ReplaceText);
	return $l_str_ReplaceText;
}

/**
 * replace the /forms.contact placeholders in the current public page
 * @param string $p_str_Content
 * @return string
 */
function footnotes_replace_public_placeholders($p_str_Content)
{
	/* read settings */
	$l_arr_Options = footnote_filter_options(FOOTNOTE_SETTINGS_CONTAINER);
	/* get setting for combine identical footnotes */
	$l_str_CombineIdentical = $l_arr_Options[FOOTNOTE_INPUT_COMBINE_IDENTICAL_NAME];
	/* get setting for preferences label */
	$l_str_ReferencesLabel = $l_arr_Options[FOOTNOTE_INPUT_REFERENCES_NAME];
	/* convert it from string to boolean */
	$l_bool_CombineIdentical = false;
	if ($l_str_CombineIdentical == "yes") {
		$l_bool_CombineIdentical = true;
	}

	/* contains the index for the next footnote on this page */
	$l_int_FootnoteIndex = 1;
	/* contains the inner text for the footnotes */
	$l_str_FootnoteBody = array();
	/* contains the starting position for the lookup of a footnote */
	$l_int_PosStart = 0;
	/* contains the footnote template */
	$l_str_FootnoteTemplate = file_get_contents(dirname(__FILE__) . "/templates/footnote.html");

	/* check for a footnote placeholder in the current page */
	do {
		/* get first occurence of a footnote starting tag */
		$l_int_PosStart = strpos($p_str_Content, FOOTNOTE_PLACEHOLDER_START, $l_int_PosStart);
		/* tag found */
		if ($l_int_PosStart !== false) {
			/* get first occurence of a footnote ending tag after the starting tag */
			$l_int_PosEnd = strpos($p_str_Content, FOOTNOTE_PLACEHOLDER_END, $l_int_PosStart);
			/* tag found */
			if ($l_int_PosEnd !== false) {
				/* get length of footnote text */
				$l_int_Length = $l_int_PosEnd - $l_int_PosStart;
				/* get text inside footnote */
				$l_str_FootnoteText = substr($p_str_Content, $l_int_PosStart + strlen(FOOTNOTE_PLACEHOLDER_START), $l_int_Length - strlen(FOOTNOTE_PLACEHOLDER_START));
				/* set replacer for the footnote */
				$l_str_ReplaceText = str_replace("[[FOOTNOTE INDEX]]", $l_int_FootnoteIndex, $l_str_FootnoteTemplate);
				$l_str_ReplaceText = str_replace("[[FOOTNOTE TEXT]]", $l_str_FootnoteText, $l_str_ReplaceText);
				/* replace footnote in content */
				$p_str_Content = substr_replace($p_str_Content, $l_str_ReplaceText, $l_int_PosStart, $l_int_Length + strlen(FOOTNOTE_PLACEHOLDER_END));
				/* set footnote to the output box at the end */
				$l_str_FootnoteBody[] = $l_str_FootnoteText;
				/* increase footnote index */
				$l_int_FootnoteIndex++;
				/* add offset to the new starting position */
				$l_int_PosStart += ($l_int_PosEnd - $l_int_PosStart);
			/* no ending tag found */
			} else {
				$l_int_PosStart++;
			}
		/* no starting tag found */
		} else {
			break;
		}
	} while (true);

	/* no footnotes has been replaced on this page */
	if (count($l_str_FootnoteBody) == 0) {
		/* return content */
		return $p_str_Content;
	}

	/* contains the footnote template */
	$l_str_FootnoteTemplate = file_get_contents(dirname(__FILE__) . "/templates/container.html");

	/* loop through all footnotes found in the page */
	for($l_str_Index = 0; $l_str_Index < count($l_str_FootnoteBody); $l_str_Index++) {
		/* get footnote text */
		$l_str_Footnote = $l_str_FootnoteBody[$l_str_Index];
		/* if fottnote is empty, get to the next one */
		if (empty($l_str_Footnote)) {
			continue;
		}
		/* get footnote index */
		$l_str_FirstFootnoteIndex = ($l_str_Index+1);
		$l_str_FootnoteIndex = ($l_str_Index+1);

		/* check if it isn't the last footnote in the array */
		if ($l_str_Index+1 < count($l_str_FootnoteBody) && $l_bool_CombineIdentical) {
			/* get all footnotes that I haven't passed yet */
			for ($l_str_CheckIndex = $l_str_Index + 1; $l_str_CheckIndex < count($l_str_FootnoteBody); $l_str_CheckIndex++) {
				/* check if a further footnote is the same as the actual one */
				if ($l_str_Footnote == $l_str_FootnoteBody[$l_str_CheckIndex]) {
					/* set the further footnote as empty so it won't be displayed later */
					$l_str_FootnoteBody[$l_str_CheckIndex] = "";
					/* add the footnote index to the actual index */
					$l_str_FootnoteIndex .= ", " . ($l_str_CheckIndex + 1);
				}
			}
		}

		/* add a headline to the footer container in the bottom, but only once */
		if ($l_str_Index == 0) {
			$p_str_Content = $p_str_Content . '<div class="footnote_container_prepare"><p><span>' . $l_str_ReferencesLabel . '</span></p></div>';
		}

		/* add the footnote to the output box */
		$l_str_ReplaceText = str_replace("[[FOOTNOTE INDEX SHORT]]", $l_str_FirstFootnoteIndex, $l_str_FootnoteTemplate);
		$l_str_ReplaceText = str_replace("[[FOOTNOTE INDEX]]", $l_str_FootnoteIndex, $l_str_ReplaceText);
		$l_str_ReplaceText = str_replace("[[FOOTNOTE TEXT]]", $l_str_Footnote, $l_str_ReplaceText);
		/* add the footnote container to the output */
		$p_str_Content = $p_str_Content . $l_str_ReplaceText;
	}

	/* return content */
	return $p_str_Content;
}

/**
 * add short links to the plugin main page
 * @param array $links
 * @param mixed $file
 * @return array
 */
function footnotes_plugin_settings_link($links, $file)
{
	/* add link to the /forms.contact plugin's settings page */
	$settings_link = '<a href="' . admin_url('options-general.php?page=' . FOOTNOTES_SETTINGS_PAGE_ID) . '">' . __('Settings', FOOTNOTES_PLUGIN_NAME) . '</a>';
	array_unshift($links, $settings_link);

	/* return new links */
	return $links;
}