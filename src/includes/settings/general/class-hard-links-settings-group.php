<?php
/**
 * File providing the `HardLinksSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\general;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the hard links settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class HardLinksSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'hard-links';

	/**
	 * Settings container key to enable hard links.
	 *
	 * When the alternative reference container is enabled, hard links are too.
	 *
	 * @var  array
	 *
	 * @since  2.3.0
	 * @since  2.8.0  Move from `Settings` to `HardLinksSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_HARD_LINKS_ENABLE = array(
		'key'           => 'footnotes_inputfield_hard_links_enable',
		'name'          => 'Enable Hard Links',
		'description'   => 'Hard links disable jQuery delays but have the same scroll offset, and allow to share footnotes (accessed if the list is not collapsed by default).',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for the fragment ID slug in referrers.
	 *
	 * @var  array
	 *
	 * @since  2.3.0
	 * @since  2.8.0  Move from `Settings` to `HardLinksSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const REFERRER_FRAGMENT_ID_SLUG = array(
		'key'           => 'footnotes_inputfield_referrer_fragment_id_slug',
		'name'          => 'Fragment Identifier Slug for Footnote Referrers',
		'description'   => 'This will show up in the address bar after clicking on a hard-linked backlink.',
		'default_value' => 'r',
		'type'          => 'string',
		'input_type'    => 'text',
	);

	/**
	 * Settings container key for the fragment ID slug in footnotes.
	 *
	 * @var  array
	 *
	 * @since  2.3.0
	 * @since  2.8.0  Move from `Settings` to `HardLinksSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTE_FRAGMENT_ID_SLUG = array(
		'key'           => 'footnotes_inputfield_footnote_fragment_id_slug',
		'name'          => 'Fragment Identifier Slug for Footnotes',
		'description'   => 'This will show up in the address bar after clicking on a hard-linked footnote referrer.',
		'default_value' => 'f',
		'type'          => 'string',
		'input_type'    => 'text',
	);

	/**
	 * Settings container key for the ID separator in fragment IDs.
	 *
	 * @var  array
	 *
	 * @since  2.3.0
	 * @since  2.8.0  Move from `Settings` to `HardLinksSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const HARD_LINK_IDS_SEPARATOR = array(
		'key'           => 'footnotes_inputfield_hard_link_ids_separator',
		'name'          => 'ID Separator',
		'description'   => 'May be empty or any string, for example _, - or +, to distinguish post number, container number and footnote number.',
		'default_value' => '+',
		'type'          => 'string',
		'input_type'    => 'text',
	);

	/**
	 * Settings container key to enable backlink tooltips.
	 *
	 * When hard links are enabled, clicks on the backlinks are logged in the
	 * browsing history, along with clicks on the referrers.
	 * This tooltip hints to use the backbutton instead, so the history gets
	 * streamlined again.
	 * See {@link https://wordpress.org/support/topic/making-it-amp-compatible/#post-13837359
	 * here} for more information.
	 *
	 * @var  array
	 *
	 * @since  2.5.4
	 * @since  2.8.0  Move from `Settings` to `HardLinksSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_BACKLINK_TOOLTIP_ENABLE = array(
		'key'           => 'footnotes_inputfield_backlink_tooltip_enable',
		'name'          => 'Enable Backlink Tooltips',
		'description'   => 'Hard backlinks get ordinary tooltips hinting to use the backbutton instead to keep it usable.',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key to configure the backlink tooltip.
	 *
	 * @var  array
	 *
	 * @since  2.5.4
	 * @since  2.8.0  Move from `Settings` to `HardLinksSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_BACKLINK_TOOLTIP_TEXT = array(
		'key'           => 'footnotes_inputfield_backlink_tooltip_text',
		'name'          => 'Backlink Tooltip Text',
		'description'   => 'Default text is the keyboard shortcut; may be a localized descriptive hint.',
		'default_value' => 'Alt + ←',
		'type'          => 'string',
		'input_type'    => 'text',
	);

	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_HARD_LINKS_ENABLE['key'] => $this->add_setting( self::FOOTNOTES_HARD_LINKS_ENABLE ),
			self::REFERRER_FRAGMENT_ID_SLUG['key'] => $this->add_setting( self::REFERRER_FRAGMENT_ID_SLUG ),
			self::FOOTNOTE_FRAGMENT_ID_SLUG['key'] => $this->add_setting( self::FOOTNOTE_FRAGMENT_ID_SLUG ),
			self::HARD_LINK_IDS_SEPARATOR['key'] => $this->add_setting( self::HARD_LINK_IDS_SEPARATOR ),
			self::FOOTNOTES_BACKLINK_TOOLTIP_ENABLE['key'] => $this->add_setting( self::FOOTNOTES_BACKLINK_TOOLTIP_ENABLE ),
			self::FOOTNOTES_BACKLINK_TOOLTIP_TEXT['key'] => $this->add_setting( self::FOOTNOTES_BACKLINK_TOOLTIP_TEXT ),
		);

		$this->load_values( $options );
	}
}
