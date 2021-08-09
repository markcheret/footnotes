<?php
/**
 * File providing the `ReferrersSettingsGroup` class.
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
 * Class defining the referrer settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class ReferrersSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'referrers';
	
	/**
	 * Setting group name.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_NAME = 'Referrers';

	/**
	 * Settings container key for the referrer element.
	 *
	 * @var  array
	 *
	 * @since  2.1.1
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS = array(
		'key'           => 'footnotes_inputfield_referrer_superscript_tags',
		'name'          => 'Display Footnote Referrers in Superscript',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);
	
	/**
	 * Settings container key to enable superscript style normalization.
	 *
	 * @var  array
	 *
	 * @since  2.5.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT = array(
		'key'           => 'footnotes_inputfield_referrers_normal_superscript',
		'name'          => 'Normalize Vertical Alignment and Font Size',
		'description'   => 'Most themes don\'t need this fix.',
		'default_value' => 'no',
		'type'          => 'string',
		'input_type'    => 'select',
		'input_options' => array( 
		  'no'  =>  'No',
		  'referrers' => 'Footnote referrers',
		  'all' =>  'All superscript elements'
		),
	);
	
	/**
	 * Settings container key for the string before the footnote referrer.
	 *
	 * The default footnote referrer surroundings should be square brackets, as
	 * in English or US American typesetting, for better UX thanks to a more
	 * button-like appearance, as well as for stylistic consistency with the
	 * expand-collapse button.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_STYLING_BEFORE = array(
		'key'           => 'footnote_inputfield_custom_styling_before',
		'name'          => 'At the Start of the Footnote Referrers',
		'default_value' => '[',
		'type'          => 'string',
		'input_type'    => 'text',
	);
	
	/**
	 * Settings container key for the string after the footnote referrer.
	 *
	 * @var  array
	 *
	 * @since  1.5.0
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 */
	const FOOTNOTES_STYLING_AFTER = array(
		'key'           => 'footnotes_inputfield_referrers_normal_superscript',
		'name'          => 'At the End of the Footnote Referrers',
		'default_value' => ']',
		'type'          => 'string',
		'input_type'    => 'text',
	);
	
	/**
	 * Settings container key
	 *
	 * @var  array
	 *
	 * @since  2.1.4
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const LINK_ELEMENT_ENABLED = array(
		'key'           => 'footnote_inputfield_link_element_enabled',
		'name'          => 'Use the Link Element for Referrers and Backlinks',
		'description'   => 'Please find this setting at the end of the reference container settings. The link element is needed to apply the theme\'s link color.',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);
	
	/**
	 * @see SettingsGroup::add_settings()
	 */
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS['key'] => $this->add_setting( self::FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS ),
			self::FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT['key'] => $this->add_setting( self::FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT ),
			self::FOOTNOTES_STYLING_BEFORE['key'] => $this->add_setting( self::FOOTNOTES_STYLING_BEFORE ),
			self::FOOTNOTES_STYLING_AFTER['key'] => $this->add_setting( self::FOOTNOTES_STYLING_AFTER ),
			self::LINK_ELEMENT_ENABLED['key'] => $this->add_setting( self::LINK_ELEMENT_ENABLED ),
		);

		$this->load_values( $options );
	}
}
