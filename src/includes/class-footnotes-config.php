<?php
/**
 * File providing the `Footnotes_Config` class.
 *
 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @since  2.8.0  Rename file from `config.php` to `class-footnotes-config.php`,
 *                              rename `class/` sub-directory to `includes/`.
 * @todo  Remove.
 * @deprecated
 */

/**
 * Class defining plugin constants.
 *
 * This class contains no methods of properties.
 *
 * @package  footnotes
 * @subpackage  includes
 *
 * @since  1.5.0
 * @todo  Remove.
 * @deprecated
 */
class Footnotes_Config {
	/**
	 * Public plugin name.
	 *
	 * @var string
	 *
	 * @since  1.5.0
	 * @todo  Remove.
	 * @deprecated
	 */
	const C_STR_PLUGIN_PUBLIC_NAME = '<span class="footnotes_logo footnotes_logo_part1">foot</span><span class="footnotes_logo footnotes_logo_part2">notes</span>';

	/**
	 * Public plugin name for use as a dashboard heading.
	 *
	 * After properly displaying in dashboard headings until WPv5.4, the above started
	 * in WP 5.5 being torn apart as if the headline was `text-align:justify` and not
	 * the last line. That ugly display bug badly affected the plugin's communication.
	 * The only working solution found so far is using `position:fixed` in one heading
	 * that isn't translated, and dropping the logo in another, translatable heading.
	 *
	 * @var  string
	 *
	 * @since  2.0.4
	 * @todo  Remove.
	 * @deprecated
	 */
	const C_STR_PLUGIN_HEADING_NAME = '<span class="footnotes_logo_heading footnotes_logo_part1_heading">foot</span><span class="footnotes_logo_heading footnotes_logo_part2_heading">notes</span>';

	/**
	 * HTML element for the ‘love’ symbol.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 * @todo  Remove.
	 * @deprecated
	 */
	const C_STR_LOVE_SYMBOL = '<span style="color:#ff6d3b; font-weight:bold;">&hearts;</span>';

	/**
	 * HTML element for the ‘love’ symbol used in dashboard heading
	 *
	 * @var  string
	 *
	 * @since  2.0.4
	 * @todo  Remove.
	 * @deprecated
	 */
	const C_STR_LOVE_SYMBOL_HEADING = '<span class="footnotes_heart_heading">&hearts;</span>';

	/**
	 * Shortcode to NOT display the ‘LOVE ME’ slug on certain pages.
	 *
	 * @var  string
	 *
	 * @since  1.5.0
	 * @todo  Remove.
	 * @deprecated
	 */
	const C_STR_NO_LOVE_SLUG = '[[no footnotes: love]]';
}
