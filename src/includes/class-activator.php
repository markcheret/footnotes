<?php
/**
 * Includes: Activator class
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
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes;

/**
 * Class providing action(s) on plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @package footnotes
 * @since 2.8.0
 */
class Activator {

	/**
	 * Runs when the plugin is deactivated.
	 *
	 * Currently NOP.
	 *
	 * @since 2.8.0
	 *
	 * @return void
	 */
	public static function activate() {
		// Nothing yet.
	}

}
