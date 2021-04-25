<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName
/**
 * Includes the Plugin Constants class to load all Plugin constant vars like Plugin name, etc.
 *
 * @filesource
 * @package footnotes
 * @since 1.5.0
 *
 * @since 2.0.4  add Public Plugin name for dashboard heading
 */

/**
 * Contains all Plugin Constants. Contains no Method or Property.
 *
 * @since 1.5.0
 */
class Footnotes_Config {
	/**
	 * Internal Plugin name.
	 *
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_PLUGIN_NAME = 'footnotes';

	/**
	 * Public Plugin name.
	 *
	 * @since 1.5.0
	 * @var string
	 *
	 * edited classes for v2.0.4
	 */
	const C_STR_PLUGIN_PUBLIC_NAME = '<span class="footnotes_logo footnotes_logo_part1">foot</span><span class="footnotes_logo footnotes_logo_part2">notes</span>';

	/**
	 * Public Plugin name for dashboard heading
	 *
	 * After properly displaying in dashboard headings until WPv5.4, the above started
	 * in WPv5.5 being torn apart as if the headline was text-align:justify and not
	 * the last line. That ugly display bug badly affected the plugin’s communication.
	 * The only working solution found so far is using position:fixed in one heading
	 * that isn’t translated, and dropping the logo in another, translatable heading.
	 *
	 * @since 2.0.4
	 * @var string
	 */
	const C_STR_PLUGIN_HEADING_NAME = '<span class="footnotes_logo_heading footnotes_logo_part1_heading">foot</span><span class="footnotes_logo_heading footnotes_logo_part2_heading">notes</span>';

	/**
	 * Html tag for the LOVE symbol.
	 *
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_LOVE_SYMBOL = '<span style="color:#ff6d3b; font-weight:bold;">&hearts;</span>';

	/**
	 * HTML code for the 'love' symbol used in dashboard heading
	 *
	 * @since 2.0.4
	 * @var string
	 */
	const C_STR_LOVE_SYMBOL_HEADING = '<span class="footnotes_heart_heading">&hearts;</span>';

	/**
	 * Short code to DON'T display the 'LOVE ME' slug on certain pages.
	 *
	 * @since 1.5.0
	 * @var string
	 */
	const C_STR_NO_LOVE_SLUG = '[[no footnotes: love]]';
}
