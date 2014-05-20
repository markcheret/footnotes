<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0
 * Since: 1.0
 */

/*
 * collection of all footnotes found on the current page
 * @since 1.0
 */
$g_arr_Footnotes = array();

/*
 * collection of all footnotes settings
 * @since 1.0-beta
 */
$g_arr_FootnotesSettings = array();

/**
 * starts listening for footnotes to be replaced
 * output will be buffered and not displayed
 * @since 1.0
 * @param string $p_str_Content
 * @return string
 */
function footnotes_startReplacing( $p_str_Content )
{
	/* access to the global settings collection */
	global $g_arr_FootnotesSettings;
	/* stop the output and move it to a buffer instead, defines a callback function */
	ob_start( "footnotes_replaceFootnotes" );
	/* load footnote settings */
	$g_arr_FootnotesSettings = footnotes_filter_options( FOOTNOTE_SETTINGS_CONTAINER );
	/* return unchanged content */
	return $p_str_Content;
}

/**
 * dummy function to add the content to the buffer instead of output it
 * @since 1.0
 * @param string $p_str_Content
 * @return string
 */
function footnotes_DummyReplacing( $p_str_Content )
{
	/* return unchanged content */
	return $p_str_Content;
}

/**
 * stops buffering the output, automatically calls the ob_start() defined callback function
 * replaces all footnotes in the whole buffer and outputs it
 * @since 1.0
 */
function footnotes_StopReplacing()
{
	/* calls the callback function defined in ob_start(); */
	ob_end_flush();
}

/**
 * replaces all footnotes in the given content
 * @since 1.0
 * @param string $p_str_Content
 * @param bool   $p_bool_OutputReferences [default: true]
 * @return string
 */
function footnotes_replaceFootnotes( $p_str_Content, $p_bool_OutputReferences = true )
{
	/* get access to the global array */
	global $g_arr_Footnotes;

	/* replace all footnotes in the content */
	$p_str_Content = footnotes_getFromString( $p_str_Content );

	/* add the reference list if set */
	if ( $p_bool_OutputReferences ) {
		$p_str_Content = $p_str_Content . footnotes_OutputReferenceContainer();
		/* free all found footnotes if reference container will be displayed */
		$g_arr_Footnotes = array();
	}
	/* return the replaced content */
	return $p_str_Content;
}

/**
 * replace all footnotes in the given string and adds them to an array
 * @since 1.0
 * @param string $p_str_Content
 * @return string
 */
function footnotes_getFromString( $p_str_Content )
{
	/* get access to the global array to store footnotes */
	global $g_arr_Footnotes;
	/* contains the index for the next footnote on this page */
	$l_int_FootnoteIndex = 1;
	/* contains the starting position for the lookup of a footnote */
	$l_int_PosStart = 0;
	/* contains the footnote template */
	$l_str_FootnoteTemplate = file_get_contents( FOOTNOTES_TEMPLATES_DIR . "footnote.html" );

	/* check for a footnote placeholder in the current page */
	do {
		/* get first occurence of a footnote starting tag */
		$l_int_PosStart = strpos( $p_str_Content, FOOTNOTE_PLACEHOLDER_START, $l_int_PosStart );
		/* tag found */
		if ( $l_int_PosStart !== false ) {
			/* get first occurence of a footnote ending tag after the starting tag */
			$l_int_PosEnd = strpos( $p_str_Content, FOOTNOTE_PLACEHOLDER_END, $l_int_PosStart );
			/* tag found */
			if ( $l_int_PosEnd !== false ) {
				/* get length of footnote text */
				$l_int_Length = $l_int_PosEnd - $l_int_PosStart;
				/* get text inside footnote */
				$l_str_FootnoteText = substr( $p_str_Content, $l_int_PosStart + strlen( FOOTNOTE_PLACEHOLDER_START ), $l_int_Length - strlen( FOOTNOTE_PLACEHOLDER_START ) );
				/* set replacer for the footnote */
				$l_str_ReplaceText = str_replace( "[[FOOTNOTE INDEX]]", $l_int_FootnoteIndex, $l_str_FootnoteTemplate );
				$l_str_ReplaceText = str_replace( "[[FOOTNOTE TEXT]]", $l_str_FootnoteText, $l_str_ReplaceText );
				/* replace footnote in content */
				$p_str_Content = substr_replace( $p_str_Content, $l_str_ReplaceText, $l_int_PosStart, $l_int_Length + strlen( FOOTNOTE_PLACEHOLDER_END ) );
				/* set footnote to the output box at the end */
				$g_arr_Footnotes[ ] = $l_str_FootnoteText;
				/* increase footnote index */
				$l_int_FootnoteIndex++;
				/* add offset to the new starting position */
				$l_int_PosStart += ( $l_int_PosEnd - $l_int_PosStart );
				/* no ending tag found */
			} else {
				$l_int_PosStart++;
			}
			/* no starting tag found */
		} else {
			break;
		}
	} while ( true );

	/* return content */
	return $p_str_Content;
}

/**
 * looks through all footnotes that has been replaced in the current content and
 * adds a reference to the footnote at the end of the content
 * function to collapse the reference container since 1.0-beta
 * @since 1.0
 * @return string
 */
function footnotes_OutputReferenceContainer()
{
	/* get access to the global array to read footnotes */
	global $g_arr_Footnotes;
	/* access to the global settings collection */
	global $g_arr_FootnotesSettings;

	/* no footnotes has been replaced on this page */
	if ( empty( $g_arr_Footnotes ) ) {
		/* return empty string */
		return "";
	}

	/* get setting for combine identical footnotes and convert it to boolean */
	$l_bool_CombineIdentical = footnotes_ConvertToBool($g_arr_FootnotesSettings[ FOOTNOTE_INPUTFIELD_COMBINE_IDENTICAL ]);
	/* get setting for preferences label */
	$l_str_ReferencesLabel = $g_arr_FootnotesSettings[ FOOTNOTE_INPUTFIELD_REFERENCES_LABEL ];
	/* get setting for collapse reference footnotes and convert it to boolean */
	$l_bool_CollapseReference = footnotes_ConvertToBool($g_arr_FootnotesSettings[ FOOTNOTE_INPUTFIELD_COLLAPSE_REFERENCES ]);

	/* output string, prepare it with the reference label as headline */
	$l_str_Output = '<div class="footnote_container_prepare"><p><span onclick="footnote_expand_reference_container();">' . $l_str_ReferencesLabel . '</span></p></div>';
	/* add a box around the footnotes */
	$l_str_Output .= '<div id="'.FOOTNOTE_REFERENCES_CONTAINER_ID.'"';
	/* add class to hide the references by default, if the user wants it */
	if ($l_bool_CollapseReference) {
		$l_str_Output .= ' class="footnote_hide_box"';
	}
	$l_str_Output .= '>';

	/* contains the footnote template */
	$l_str_FootnoteTemplate = file_get_contents( FOOTNOTES_TEMPLATES_DIR . "container.html" );

	/* loop through all footnotes found in the page */
	for ( $l_str_Index = 0; $l_str_Index < count( $g_arr_Footnotes ); $l_str_Index++ ) {
		/* get footnote text */
		$l_str_FootnoteText = $g_arr_Footnotes[ $l_str_Index ];
		/* if fottnote is empty, get to the next one */
		if ( empty( $l_str_FootnoteText ) ) {
			continue;
		}
		/* get footnote index */
		$l_str_FirstFootnoteIndex = ( $l_str_Index + 1 );
		$l_str_FootnoteIndex = ( $l_str_Index + 1 );

		/* check if it isn't the last footnote in the array */
		if ( $l_str_FirstFootnoteIndex < count( $g_arr_Footnotes ) && $l_bool_CombineIdentical ) {
			/* get all footnotes that I haven't passed yet */
			for ( $l_str_CheckIndex = $l_str_FirstFootnoteIndex; $l_str_CheckIndex < count( $g_arr_Footnotes ); $l_str_CheckIndex++ ) {
				/* check if a further footnote is the same as the actual one */
				if ( $l_str_FootnoteText == $g_arr_Footnotes[ $l_str_CheckIndex ] ) {
					/* set the further footnote as empty so it won't be displayed later */
					$g_arr_Footnotes[ $l_str_CheckIndex ] = "";
					/* add the footnote index to the actual index */
					$l_str_FootnoteIndex .= ", " . ( $l_str_CheckIndex + 1 );
				}
			}
		}

		/* add the footnote to the output box */
		$l_str_ReplaceText = str_replace( "[[FOOTNOTE INDEX SHORT]]", $l_str_FirstFootnoteIndex, $l_str_FootnoteTemplate );
		$l_str_ReplaceText = str_replace( "[[FOOTNOTE INDEX]]", $l_str_FootnoteIndex, $l_str_ReplaceText );
		$l_str_ReplaceText = str_replace( "[[FOOTNOTE TEXT]]", $l_str_FootnoteText, $l_str_ReplaceText );
		/* add the footnote container to the output */
		$l_str_Output = $l_str_Output . $l_str_ReplaceText;
	}
	/* add closing tag for the div of the references container */
	$l_str_Output = $l_str_Output . '</div>';
	/* add a javascript to expand the reference container when clicking on a footnote or the reference label */
	$l_str_Output .= '
		<script type="text/javascript">
			function footnote_expand_reference_container() {
				jQuery("#'.FOOTNOTE_REFERENCES_CONTAINER_ID.'").show();
			}
		</script>
	';

	/* return the output string */
	return $l_str_Output;
}