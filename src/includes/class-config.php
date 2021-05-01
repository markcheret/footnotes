<?php
/**
 * Includes: Config class
 *
 * `footnotes\includes` consists of functionality that is shared across both
 * the admin- and the public-facing sides of the plugin.
 *
 * The primary entry point is {@see Footnotes}, which uses {@see Loader}
 * to initialise {@see i18n} for internationalization, {@see Admin\Admin} for
 * admin-specific functionality and {@see General\General} for public-facing
 * functionality.
 *
 * It also includes various utility classes:
 *
 * - {@see Activator}: defines plugin activation behaviour, called in
 *   {@see activate_footnotes()};
 * - {@see Deactivator}: defines plugin deactivation behaviour, called in
 *   {@see deactivate_footnotes()};
 * - {@see Config}: defines plugin constants;
 * - {@see Convert}: provides data conversion methods;
 * - {@see Settings}: defines configurable plugin settings; and
 * - {@see Template}: handles template rendering.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed file from `init.php` to `class-config.php`.
 *              Renamed parent `class/` directory to `includes/`.
 * @todo Remove.
 * @deprecated
 */

namespace footnotes\includes;

/**
 * Class defining plugin constants.
 *
 * This class contains no methods of properties.
 *
 * @package footnotes
 * @since 1.5.0
 * @since 2.8.0 Renamed class from `Footnotes_Config` to `Config`.
 *                          Moved under `footnotes\includes` namespace.
 * @todo Remove.
 * @deprecated
 */
class Config {
	/**
	 * Public plugin name.
	 *
	 * @since 1.5.0
	 * @todo Remove.
	 * @deprecated
	 *
	 * @var string
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
	 * @since 2.0.4
	 * @todo Remove.
	 * @deprecated
	 *
	 * @var string
	 */
	const C_STR_PLUGIN_HEADING_NAME = '<span class="footnotes_logo_heading footnotes_logo_part1_heading">foot</span><span class="footnotes_logo_heading footnotes_logo_part2_heading">notes</span>';

	/**
	 * HTML element for the ‘love’ symbol.
	 *
	 * @since 1.5.0
	 * @todo Remove.
	 * @deprecated
	 *
	 * @var string
	 */
	const C_STR_LOVE_SYMBOL = '<span style="color:#ff6d3b; font-weight:bold;">&hearts;</span>';

	/**
	 * HTML element for the ‘love’ symbol used in dashboard heading
	 *
	 * @since 2.0.4
	 * @todo Remove.
	 * @deprecated
	 *
	 * @var string
	 */
	const C_STR_LOVE_SYMBOL_HEADING = '<span class="footnotes_heart_heading">&hearts;</span>';

	/**
	 * Shortcode to NOT display the ‘LOVE ME’ slug on certain pages.
	 *
	 * @since 1.5.0
	 * @todo Remove.
	 * @deprecated
	 *
	 * @var string
	 */
	const C_STR_NO_LOVE_SLUG = '[[no footnotes: love]]';
}
