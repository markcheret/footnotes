<?php
/**
 * File providing the `WordPressHooksSettingsGroup` class.
 *
 * @package footnotes
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes\settings\scopeandpriority;

require_once plugin_dir_path( __DIR__ ) . 'class-settings-group.php';

use footnotes\includes\Settings;
use footnotes\includes\settings\Setting;
use footnotes\includes\settings\SettingsGroup;

/**
 * Class defining the WordPress hook settings.
 *
 * @package footnotes
 * @since 2.8.0
 */
class WordPressHooksSettingsGroup extends SettingsGroup {
	/**
	 * Setting group ID.
	 *
	 * @var  string
	 *
	 * @since  2.8.0
	 */
	const GROUP_ID = 'wordpress-hooks';

	/**
	 * Settings container key to enable the `the_title` hook.
	 *
	 * These are checkboxes; the keyword `checked` is converted to `true`, whilst
	 * an empty string (the default) is converted to `false`.
	 *
	 * Hooks should all be enabled by default to prevent users from thinking at
	 * first that the feature is broken in post titles (see {@link
	 * https://wordpress.org/support/topic/more-feature-ideas/ here} for more
	 * information).
	 *
	 * @var  array
	 *
	 * @since  1.5.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 * @todo  In titles, footnotes are still buggy, because WordPress uses the
	 *        title string in menus and in the title element, but Footnotes doesn't
	 *        delete footnotes in them.
	 */
	const EXPERT_LOOKUP_THE_TITLE = array(
		'key'           => 'footnote_inputfield_expert_lookup_the_title',
		'name'          => '<code>the_title()</code>',
		'description'   => '<a href="https://developer.wordpress.org/reference/hooks/the_title/" target="_blank">https://developer.wordpress.org/reference/hooks/the_title/</a>',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for `the_title` hook priority level.
	 *
	 * @var  array
	 *
	 * @since  2.1.2
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL = array(
		'key'           => 'footnote_inputfield_expert_lookup_the_title_priority_level',
		'name'          => '<code>the_title()</code> Priority Level',
		'description'   => 'The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features. 9223372036854775807 is lowest priority, 0 is highest. To set priority level to lowest, set it to -1, interpreted as 9223372036854775807, the constant <code>PHP_INT_MAX</code>.',
		'default_value' => PHP_INT_MAX,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => PHP_INT_MAX,
		'input_min'     => -1,
	);

	/**
	 * Settings container key to enable the `the_content` hook.
	 *
	 * @var  array
	 *
	 * @since  1.5.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const EXPERT_LOOKUP_THE_CONTENT = array(
		'key'           => 'footnote_inputfield_expert_lookup_the_content',
		'name'          => '<code>the_content()</code>',
		'description'   => '<a href="https://developer.wordpress.org/reference/hooks/the_content/" target="_blank">https://developer.wordpress.org/reference/hooks/the_content/</a>',
		'default_value' => true,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for `the_content` hook priority level.
	 *
	 * Priority level of `the_content` and of `widget_text` as the only relevant
	 * hooks must be less than 99 because social buttons may yield scripts
	 * that contain the strings ‘((’ and ‘))’ (i.e., the default footnote
	 * start and end shortcodes), which causes issues with fake footnotes.
	 *
	 * Setting `the_content` priority to 10 instead of `PHP_INT_MAX` makes the
	 * footnotes reference container display beneath the post and above other
	 * features added by other plugins, e.g. related post lists and social buttons.
	 *
	 * For the {@link https://wordpress.org/plugins/yet-another-related-posts-plugin/
	 * YARPP} plugin to display related posts below the Footnotes reference container,
	 * priority needs to be at least 1,200.
	 *
	 * `PHP_INT_MAX` cannot be reset by leaving the number box empty, because
	 * WebKit browsers don't allow it, so we must resort to -1.
	 *
	 * @var  array
	 *
	 * @since  2.0.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL = array(
		'key'           => 'footnote_inputfield_expert_lookup_the_content_priority_level',
		'name'          => '<code>the_content()</code> Priority Level',
		'description'   => 'The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features. 9223372036854775807 is lowest priority, 0 is highest. To set priority level to lowest, set it to -1, interpreted as 9223372036854775807, the constant <code>PHP_INT_MAX</code>. For <code>the_content</code>, this figure must be lower than 99 so that certain strings added by a plugin running at 99 may not be mistaken as a footnote. This makes also sure that the reference container displays above a feature inserted by a plugin running at 1200.',
		'default_value' => 98,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => PHP_INT_MAX,
		'input_min'     => -1,
	);


	/**
	 * Settings container key to enable the `the_excerpt` hook.
	 *
	 * @var  array
	 *
	 * @since  1.5.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const EXPERT_LOOKUP_THE_EXCERPT = array(
		'key'           => 'footnote_inputfield_expert_lookup_the_excerpt',
		'name'          => '<code>the_excerpt()</code>',
		'description'   => '<a href="https://developer.wordpress.org/reference/hooks/the_excerpt/" target="_blank">https://developer.wordpress.org/reference/hooks/the_excerpt/</a>',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for `the_excerpt` hook priority level.
	 *
	 * @var  array
	 *
	 * @since  2.1.2
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL = array(
		'key'           => 'footnote_inputfield_expert_lookup_the_excerpt_priority_level',
		'name'          => '<code>the_excerpt()</code> Priority Level',
		'description'   => 'The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features. 9223372036854775807 is lowest priority, 0 is highest. To set priority level to lowest, set it to -1, interpreted as 9223372036854775807, the constant <code>PHP_INT_MAX</code>.',
		'default_value' => PHP_INT_MAX,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => PHP_INT_MAX,
		'input_min'     => -1,
	);
	
	/**
	 * Settings container key to enable the `widget_title` hook.
	 *
	 * @var  array
	 *
	 * @since  1.5.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const EXPERT_LOOKUP_WIDGET_TITLE = array(
		'key'           => 'footnote_inputfield_expert_lookup_widget_title',
		'name'          => '<code>widget_title()</code>',
		'description'   => '<a href="https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_title" target="_blank">https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_title</a>',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for `widget_title` hook priority level.
	 *
	 * @var  array
	 *
	 * @since  2.1.2
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL = array(
		'key'           => 'footnote_inputfield_expert_lookup_widget_title_priority_level',
		'name'          => '<code>widget_title()</code> Priority Level',
		'description'   => 'The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features. 9223372036854775807 is lowest priority, 0 is highest. To set priority level to lowest, set it to -1, interpreted as 9223372036854775807, the constant <code>PHP_INT_MAX</code>.',
		'default_value' => PHP_INT_MAX,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => PHP_INT_MAX,
		'input_min'     => -1,
	);

	/**
	 * Settings container key to enable the `widget_text` hook.
	 *
	 * The `widget_text` hook must be disabled by default, because it causes
	 * multiple reference containers to appear in Elementor accordions, but
	 * it must be enabled if multiple reference containers are desired, as
	 * in Elementor toggles.
	 *
	 * @var  array
	 *
	 * @since  1.5.5
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `string` to `array`.
	 *                Convert setting data type from `string` to `boolean`.
	 */
	const EXPERT_LOOKUP_WIDGET_TEXT = array(
		'key'           => 'footnote_inputfield_expert_lookup_widget_text',
		'name'          => '<code>widget_text()</code>',
		'description'   => '<a href="https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_text" target="_blank">https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_text</a>. The <code>widget_text()</code> hook must be enabled either when footnotes are present in theme text widgets, or when Elementor accordions or toggles shall have a reference container per section. If they should not, this hook must be disabled.',
		'default_value' => false,
		'type'          => 'boolean',
		'input_type'    => 'checkbox',
	);

	/**
	 * Settings container key for `widget_text` hook priority level.
	 *
	 * @var  array
	 *
	 * @since  2.1.2
	 * @since  2.8.0  Move from `Settings` to `ReferenceContainerSettingsGroup`.
	 *                Convert from `int` to `array`.
	 */
	const EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL = array(
		'key'           => 'footnote_inputfield_expert_lookup_widget_text_priority_level',
		'name'          => '<code>widget_text()</code> Priority Level',
		'description'   => 'The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features. 9223372036854775807 is lowest priority, 0 is highest. To set priority level to lowest, set it to -1, interpreted as 9223372036854775807, the constant <code>PHP_INT_MAX</code>.',
		'default_value' => 98,
		'type'          => 'number',
		'input_type'    => 'number',
		'input_max'     => PHP_INT_MAX,
		'input_min'     => -1,
	);
	
	protected function add_settings( array|false $options ): void {
		$this->settings = array(
			self::EXPERT_LOOKUP_THE_TITLE['key'] => $this->add_setting( self::EXPERT_LOOKUP_THE_TITLE ),
			self::EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL['key'] => $this->add_setting( self::EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL ),
			self::EXPERT_LOOKUP_THE_CONTENT['key'] => $this->add_setting( self::EXPERT_LOOKUP_THE_CONTENT ),
			self::EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL['key'] => $this->add_setting( self::EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL ),
			self::EXPERT_LOOKUP_THE_EXCERPT['key'] => $this->add_setting( self::EXPERT_LOOKUP_THE_EXCERPT ),
			self::EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL['key'] => $this->add_setting( self::EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL ),
			self::EXPERT_LOOKUP_WIDGET_TITLE['key'] => $this->add_setting( self::EXPERT_LOOKUP_WIDGET_TITLE ),
			self::EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL['key'] => $this->add_setting( self::EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL ),
			self::EXPERT_LOOKUP_WIDGET_TEXT['key'] => $this->add_setting( self::EXPERT_LOOKUP_WIDGET_TEXT ),
			self::EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL['key'] => $this->add_setting( self::EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL ),
		);

		$this->load_values( $options );
	}
}
