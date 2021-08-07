<?php
/**
 * File providing the `ReferrersInLabelsSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\referrersandtooltips;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the referrer in labels settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ReferrersInLabelsSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'referrers-in-label';

	/**
	 * Settings container key to set the solution of the input element label issue.
	 *
	 * If hard links are not enabled, clicking a referrer in an input element label
	 * toggles the state of the input element the label is connected to.
	 * Beside hard links, other solutions include moving footnotes off the label and
	 * append them, or disconnecting this label from the input element (discouraged).
	 * See {@link https://wordpress.org/support/topic/compatibility-issue-with-wpforms/#post-14212318
	 * here} for more information.
	 *
	 * @var  array
	 *
	 * @since  2.5.12
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 * @todo  Review, remove?
	 */
	const FOOTNOTES_LABEL_ISSUE_SOLUTION = array(
		'key'           => 'footnotes_inputfield_label_issue_solution',
		'name'          => 'Solve Input Label Issue',
		'description'   => 'Clicking a footnote referrer in an input element label toggles the input except when hard links are enabled. In jQuery mode, the recommended solution is to move footnotes and append them after the label (option A). Option B is discouraged because disconnecting a label from its input element may compromise accessibility. This option is a last resort in case footnotes must absolutely stay inside the label. (Using jQuery \'event.stopPropagation\' failed.',
		'default_value' => 'none',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array( 
		  'none'  =>  '0. No problem or solved otherwise',
		  'move' => 'A. Footnotes are moved out and appended after the label\'s end (recommended)',
		  'disconnect' =>  'B. Labels with footnotes are disconnected from input element (discouraged)'
		),
	);
		
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_LABEL_ISSUE_SOLUTION['key'] => $this->add_setting( self::FOOTNOTES_LABEL_ISSUE_SOLUTION ),
		);

		$this->load_values( $options );
	}
}
