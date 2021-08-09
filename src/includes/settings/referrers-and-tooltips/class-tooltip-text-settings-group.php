<?php
/**
 * File providing the `TooltipTextSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\referrersandtooltips;

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the tooltip position settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class TooltipTextSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'tooltip-text';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Tooltip Text';

	/**
	 * Settings container key to configure the tooltip excerpt delimiter.
	 *
	 * The first implementation used a fixed shortcode provided in the changelog,
	 * but footnotes should have freely-configurable shortcodes.
	 *
	 * Tooltips can display another content than the footnote entry in the
	 * reference container. The trigger is a shortcode in the footnote text
	 * separating the tooltip text from the note. That is consistent with what
	 * WordPress does for excerpts.
	 *
	 * @var  array
	 *
	 * @since  2.5.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER = array(
		'key'           => 'footnotes_inputfield_tooltip_excerpt_delimiter',
		'name'          => 'Delimiter for Dedicated Tooltip Text',
		'description'   => 'Tooltips can display another content than the footnote entry in the reference container. The trigger is a shortcode in the footnote text separating the tooltip text from the note. That is consistent with what WordPress does for excerpts. If the delimiter shortcode is present, the tooltip text will be the part before it.',
		'default_value' => '[[/tooltip]]',
		'type'          => 'string',
		'input_type'    => 'text',
	);

	/**
	 * Settings container key to enable mirroring the tooltip excerpt in the
	 * reference container.
	 *
	 * Tooltips, even jQuery-driven, may be hard to consult on mobiles.
	 * This option allows users to read the tooltip content in the reference
	 * container too. See {@link https://wordpress.org/support/topic/change-tooltip-text/#post-13935050
	 * here} for more information, and {@link https://wordpress.org/support/topic/change-tooltip-text/#post-13935488
	 * here} for why this must not be the default behavior.
	 *
	 * @var  array
	 *
	 * @since  2.5.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE = array(
		'key'           => 'footnotes_inputfield_tooltip_excerpt_mirror_enable',
		'name'          => 'Mirror the Tooltip in the Reference Container',
		'description'   => 'Tooltips may be harder to use on mobiles. This option allows to read it in the reference container. Tooltips, even jQuery-driven, may be hard to consult on mobiles. This option allows to read the tooltip content in the reference container too.',
		'default_value' => 'false',
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key to configure the tooltip excerpt separator in the
	 * reference container.
	 *
	 * @var  array
	 *
	 * @since  2.5.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR = array(
		'key'           => 'footnotes_inputfield_tooltip_excerpt_mirror_separator',
		'name'          => 'Separator Between Tooltip Text and Footnote Text',
		'description'   => 'May be a simple space, or a line break &lt;br /&gt;, or any string in your language.',
		'default_value' => ' — ',
		'type'          => 'string',
		'input_type'    => 'text',
	);
		
	/**
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER['key'] => $this->add_setting( self::FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER ),
			self::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE['key'] => $this->add_setting( self::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE ),
			self::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR['key'] => $this->add_setting( self::FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR ),
		);

		$this->load_values( $options );
	}
}
