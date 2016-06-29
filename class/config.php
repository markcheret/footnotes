<?php
/**
 * Includes the Plugin Constants class to load all Plugin constant vars like Plugin name, etc.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 12.09.14 10:56
 */


/**
 * Contains all Plugin Constants. Contains no Method or Property.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Config {

	/**
	 * Internal Plugin name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_PLUGIN_NAME = "footnotes";

	/**
	 * Public Plugin name.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_PLUGIN_PUBLIC_NAME = '<span class="footnote_tag_styling footnote_tag_styling_1">foot</span><span class="footnote_tag_styling footnote_tag_styling_2">notes</span>';

	/**
	 * Html tag for the LOVE symbol.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_LOVE_SYMBOL = '<span style="color:#ff6d3b; font-weight:bold;">&hearts;</span>';

	/**
	 * Short code to DON'T display the 'LOVE ME' slug on certain pages.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_NO_LOVE_SLUG = '[[no footnotes: love]]';
}