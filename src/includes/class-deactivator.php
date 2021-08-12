<?php
/**
 * File providing `Deactivator` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes;

/**
 * Class providing action(s) on plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @package footnotes
 * @since 2.8.0
 */
class Deactivator {

	/**
	 * Runs when the plugin is deactivated.
	 *
	 * Currently NOP.
	 *
	 * @since 2.8.0
	 *
	 * @return void
	 */
	public static function deactivate() {
		// Nothing yet.
	}

}
