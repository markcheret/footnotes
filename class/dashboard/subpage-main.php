<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName.
/**
 * Includes the Plugin Class to display all Settings.
 *
 * @filesource
 * @since 1.5.0
 * @date 14.09.14 14:47
 *
 * @since 2.0.4  restore arrow settings  2020-11-01T0509+0100
 * @since 2.1.0  read-on button label  2020-11-08T2148+0100
 * @since 2.1.1  options for ref container and alternative tooltips  2020-11-16T2152+0100
 * @since 2.1.1  Referrers: superscript becomes optional, thanks to @cwbayer bug report
 * @since 2.1.2  priority level settings for all other hooks, thanks to @nikelaos
 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13676705
 * @since 2.1.4  settings for ref container, tooltips and scrolling  2020-12-03T0950+0100
 * @since 2.1.6  slight UI reordering   2020-12-09T1114+0100
 * @since 2.1.6  option to disable URL line wrapping   2020-12-09T1604+0100
 * @since 2.1.6  remove expert mode setting as outdated   2020-12-09T2105+0100
 * @since 2.2.0  start/end short codes: more predefined options, thanks to @nikelaos
 * @link https://wordpress.org/support/topic/doesnt-work-with-mailpoet/
 * @since 2.2.0  add options, redistribute, update strings   2020-12-12T2135+0100
 * @since 2.2.0  shortcode for reference container custom position   2020-12-13T2055+0100
 * @since 2.2.2  Custom CSS settings container migration  2020-12-15T0709+0100
 * @since 2.2.4  move backlink symbol selection under previous tab  2020-12-16T1244+0100
 * @since 2.2.5  support for Ibid. notation thanks to @meglio   2020-12-17T2021+0100
 * @link https://wordpress.org/support/topic/add-support-for-ibid-notation/
 * @since 2.2.5  options for label element and label bottom border, thanks to @markhillyer   2020-12-18T1447+0100
 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
 * @since 2.2.10 reference container row border option, thanks to @noobishh   2020-12-25T2316+0100
 * @link https://wordpress.org/support/topic/borders-25/
 * @since 2.3.0  Reference container: convert top padding to margin and make it a setting, thanks to @hamshe
 * @link https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635
 * @since 2.3.0  rename Priority level tab as Scope and priority   2020-12-26T2222+0100
 * @since 2.3.0  swap Custom CSS migration Boolean from 'migration complete' to 'show legacy'  2020-12-27T1243+0100
 * @since 2.3.0  mention op. cit. abbreviation   2020-12-28T2342+0100
 * @since 2.3.0  add settings for hard links, thanks to @psykonevro and @martinneumannat  2020-12-29T1322+0100
 * @link https://wordpress.org/support/topic/making-it-amp-compatible/
 * @link https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/
 * @since 2.4.0  footnote shortcode syntax validation  2021-01-01T0624+0100
 * @since 2.5.0  Shortcode syntax validation: add more information around the setting, thanks to @andreasra
 * @link https://wordpress.org/support/topic/warning-unbalanced-footnote-start-tag-short-code-before/
 */

/**
 * Displays and handles all Settings of the Plugin.
 *
 * @since 1.5.0
 */
class MCI_Footnotes_Layout_Settings extends MCI_Footnotes_Layout_Engine {

	/**
	 * Returns a Priority index. Lower numbers have a higher Priority.
	 *
	 * @since 1.5.0
	 * @return int
	 */
	public function get_priority() {
		return 10;
	}

	/**
	 * Returns the unique slug of the sub page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	protected function get_sub_page_slug() {
		return '-' . MCI_Footnotes_Config::C_STR_PLUGIN_NAME;
	}

	/**
	 * Returns the title of the sub page.
	 *
	 * @since 1.5.0
	 * @return string
	 */
	protected function get_sub_page_title() {
		return MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME;
	}

	/**
	 * Returns an array of all registered sections for the sub page.
	 *
	 * @since  1.5.0
	 * @return array
	 *
	 * Edited:
	 * @since 2.1.6  tabs reordered and renamed
	 * @link https://www.linkedin.com/pulse/20140610191154-4746170-configuration-vs-customization-when-and-why-would-i-implement-each
	 *
	 * @since 2.1.6  removed if statement around expert tab
	 */
	protected function get_sections() {
		$l_arr_tabs = array();

		// Sync tab name with mirror in task.php.
		$l_arr_tabs[] = $this->add_section( 'settings', __( 'General settings', 'footnotes' ), 0, true );

		// Sync tab name with mirror in public function custom_css_migration().
		$l_arr_tabs[] = $this->add_section( 'customize', __( 'Referrers and tooltips', 'footnotes' ), 1, true );

		$l_arr_tabs[] = $this->add_section( 'expert', __( 'Scope and priority', 'footnotes' ), 2, true );
		$l_arr_tabs[] = $this->add_section( 'customcss', __( 'Custom CSS', 'footnotes' ), 3, true );
		$l_arr_tabs[] = $this->add_section( 'how-to', __( 'Quick start guide', 'footnotes' ), null, false );

		return $l_arr_tabs;
	}

	/**
	 * Returns an array of all registered meta boxes for each section of the sub page.
	 *
	 * @since  1.5.0
	 * @return array
	 *
	 * Edited for 2.0.0 and later.
	 *
	 * hyperlink_arrow meta box:
	 * @since 2.0.0 discontinued
	 * @since 2.0.4 restored to meet user demand for arrow symbol semantics
	 * @since 2.1.4 discontinued, content moved to Settings > Reference container > Display a backlink symbol
	 *
	 * @since 2.0.4 to reflect changes in meta box label display since WPv5.5
	 * spans need position:fixed and become unlocalizable
	 * fix: logo is kept only in the label that doesn’t need to be translated:
	 * Change string "%s styling" to "Footnotes styling" to fix layout in WPv5.5
	 * @see details in class/config.php
	 *
	 * @since 2.1.6 / 2.2.0 tabs reordered and renamed
	 */
	protected function get_meta_boxes() {
		$l_arr_meta_boxes = array();

		// Sync box name with mirror in task.php.
		$l_arr_meta_boxes[] = $this->add_meta_box( 'settings', 'start-end', __( 'Footnote start and end short codes', 'footnotes' ), 'start_end' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'settings', 'numbering', __( 'Footnotes numbering', 'footnotes' ), 'Numbering' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'settings', 'scrolling', __( 'Scrolling behavior', 'footnotes' ), 'Scrolling' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'settings', 'reference-container', __( 'Reference container', 'footnotes' ), 'reference_container' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'settings', 'excerpts', __( 'Footnotes in excerpts', 'footnotes' ), 'excerpts' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'settings', 'love', MCI_Footnotes_Config::C_STR_PLUGIN_HEADING_NAME . '&nbsp;' . MCI_Footnotes_Config::C_STR_LOVE_SYMBOL_HEADING, 'Love' );

		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'hyperlink-arrow', __( 'Backlink symbol', 'footnotes' ), 'hyperlink_arrow' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'superscript', __( 'Referrer typesetting and formatting', 'footnotes' ), 'superscript' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box', __( 'Tooltips', 'footnotes' ), 'mouseover_box' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-position', __( 'Tooltip position', 'footnotes' ), 'mouseover_box_position' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-dimensions', __( 'Tooltip dimensions', 'footnotes' ), 'mouseover_box_dimensions' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-timing', __( 'Tooltip timing', 'footnotes' ), 'mouseover_box_timing' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-truncation', __( 'Tooltip truncation', 'footnotes' ), 'mouseover_box_truncation' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-text', __( 'Tooltip text', 'footnotes' ), 'mouseover_box_text' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'mouse-over-box-appearance', __( 'Tooltip appearance', 'footnotes' ), 'mouseover_box_appearance' );
		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_LEGACY_ENABLE ) ) ) {
			$l_arr_meta_boxes[] = $this->add_meta_box( 'customize', 'custom-css', __( 'Your existing Custom CSS code', 'footnotes' ), 'custom_css' );
		}

		$l_arr_meta_boxes[] = $this->add_meta_box( 'expert', 'lookup', __( 'WordPress hooks with priority level', 'footnotes' ), 'lookup_hooks' );

		if ( MCI_Footnotes_Convert::to_bool( MCI_Footnotes_Settings::instance()->get( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_LEGACY_ENABLE ) ) ) {
			$l_arr_meta_boxes[] = $this->add_meta_box( 'customcss', 'custom-css-migration', __( 'Your existing Custom CSS code', 'footnotes' ), 'custom_css_migration' );
		}
		$l_arr_meta_boxes[] = $this->add_meta_box( 'customcss', 'custom-css-new', __( 'Custom CSS', 'footnotes' ), 'custom_css_new' );

		$l_arr_meta_boxes[] = $this->add_meta_box( 'how-to', 'help', __( 'Brief introduction in how to use the plugin', 'footnotes' ), 'help' );
		$l_arr_meta_boxes[] = $this->add_meta_box( 'how-to', 'donate', __( 'Help us to improve our Plugin', 'footnotes' ), 'donate' );

		return $l_arr_meta_boxes;
	}

	/**
	 * Displays all settings for the reference container.
	 *
	 * @since 1.5.0
	 *
	 * Completed:
	 * @since 2.1.4: layout and typography options   2020-11-30T0548+0100
	 * @since 2.2.5  options for label element and label bottom border, thanks to @markhillyer   2020-12-18T1447+0100
	 * @link https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/
	 */
	public function reference_container() {

		// Options for the label element.
		$l_arr_label_element = array(
			'p'  => __( 'paragraph', 'footnotes' ),
			'h2' => __( 'heading 2', 'footnotes' ),
			'h3' => __( 'heading 3', 'footnotes' ),
			'h4' => __( 'heading 4', 'footnotes' ),
			'h5' => __( 'heading 5', 'footnotes' ),
			'h6' => __( 'heading 6', 'footnotes' ),
		);
		// Options for the positioning of the reference container.
		$l_arr_positions = array(
			'post_end' => __( 'at the end of the post', 'footnotes' ),
			'widget'   => __( 'in the widget area', 'footnotes' ),
			'footer'   => __( 'in the footer', 'footnotes' ),
		);
		// Basic responsive page layout options.
		$l_arr_page_layout_options = array(
			'none'                => __( 'No', 'footnotes' ),
			'reference-container' => __( 'to the reference container exclusively', 'footnotes' ),
			'entry-content'       => __( 'to the div element starting below the post title', 'footnotes' ),
			'main-content'        => __( 'to the main element including the post title', 'footnotes' ),
		);
		// Options for the separating punctuation between backlinks.
			$l_arr_separators = array(
				// Unicode character names are conventionally uppercase.
				'comma'     => __( 'COMMA', 'footnotes' ),
				'semicolon' => __( 'SEMICOLON', 'footnotes' ),
				'en_dash'   => __( 'EN DASH', 'footnotes' ),
			);
			// Options for the terminating punctuation after backlinks.
			// The Unicode name of RIGHT PARENTHESIS was originally more accurate because.
			// This character is bidi-mirrored. Let’s use the Unicode 1.0 name.
			// The wrong names were enforced in spite of Unicode, that subsequently scrambled to correct.
			$l_arr_terminators = array(
				'period'      => __( 'FULL STOP', 'footnotes' ),
				// Unicode 1.0 name of RIGHT PARENTHESIS (represented as a left parenthesis in right-to-left scripts).
				'parenthesis' => __( 'CLOSING PARENTHESIS', 'footnotes' ),
				'colon'       => __( 'COLON', 'footnotes' ),
			);
			// Options for the first column width (per cent is a ratio, not a unit).
			$l_arr_width_units = array(
				'%'   => __( 'per cent', 'footnotes' ),
				'px'  => __( 'pixels', 'footnotes' ),
				'rem' => __( 'root em', 'footnotes' ),
				'em'  => __( 'em', 'footnotes' ),
				'vw'  => __( 'viewport width', 'footnotes' ),
			);
			// Options for reference container script mode.
			$l_arr_script_mode = array(
				'jquery' => __( 'jQuery', 'footnotes' ),
				'js'     => __( 'plain JavaScript', 'footnotes' ),
			);
			// Options for Yes/No select box.
			$l_arr_enabled = array(
				'yes' => __( 'Yes', 'footnotes' ),
				'no'  => __( 'No', 'footnotes' ),
			);

			// Load template file.
			$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'settings-reference-container' );
			// Replace all placeholders.
			$l_obj_template->replace(
				array(
					'label-name'           => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME, __( 'Heading:', 'footnotes' ) ),
					'name'                 => $this->add_text_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME ),

					'label-element'        => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT, __( 'Heading’s HTML element:', 'footnotes' ) ),
					'element'              => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT, $l_arr_label_element ),

					'label-border'         => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER, __( 'Border under the heading:', 'footnotes' ) ),
					'border'               => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER, $l_arr_enabled ),

					'label-collapse'       => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_COLLAPSE, __( 'Collapse by default:', 'footnotes' ) ),
					'collapse'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_COLLAPSE, $l_arr_enabled ),

					'label-script'         => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE, __( 'Script mode:', 'footnotes' ) ),
					'script'               => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERENCE_CONTAINER_SCRIPT_MODE, $l_arr_script_mode ),
					'notice-script'        => __( 'The plain JavaScript mode does not support scroll animation and will enable hard links with scroll offset.', 'footnotes' ),

					'label-position'       => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, __( 'Default position:', 'footnotes' ) ),
					'position'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION, $l_arr_positions ),
					// Translators: %s: at the end of the post.
					'notice-position'      => sprintf( __( 'To use the position shortcode, please set the position to: %s', 'footnotes' ), '<span style="font-style: normal;">' . __( 'at the end of the post', 'footnotes' ) . '</span>' ),

					'label-shortcode'      => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE, __( 'Position shortcode:', 'footnotes' ) ),
					'shortcode'            => $this->add_text_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE ),
					'notice-shortcode'     => __( 'If present in the content, any shortcode in this text box will be replaced with the reference container.', 'footnotes' ),

					'label-startpage'      => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_START_PAGE_ENABLE, __( 'Display on start page too:', 'footnotes' ) ),
					'startpage'            => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_START_PAGE_ENABLE, $l_arr_enabled ),

					'label-margin-top'     => $this->add_label( MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN, __( 'Top margin:', 'footnotes' ) ),
					'margin-top'           => $this->add_num_box( MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN, -500, 500 ),
					'notice-margin-top'    => __( 'pixels; may be negative', 'footnotes' ),

					'label-margin-bottom'  => $this->add_label( MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN, __( 'Bottom margin:', 'footnotes' ) ),
					'margin-bottom'        => $this->add_num_box( MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN, -500, 500 ),
					'notice-margin-bottom' => __( 'pixels; may be negative', 'footnotes' ),

					'label-page-layout'    => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT, __( 'Apply basic responsive page layout:', 'footnotes' ) ),
					'page-layout'          => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_PAGE_LAYOUT_SUPPORT, $l_arr_page_layout_options ),
					'notice-page-layout'   => __( 'Most themes don’t need this fix.', 'footnotes' ),

					'label-url-wrap'       => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTE_URL_WRAP_ENABLED, __( 'Allow URLs to line-wrap anywhere:', 'footnotes' ) ),
					'url-wrap'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTE_URL_WRAP_ENABLED, $l_arr_enabled ),
					'notice-url-wrap'      => __( 'Unicode-conformant browsers don’t need this fix.', 'footnotes' ),

					'label-symbol'         => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE, __( 'Display a backlink symbol:', 'footnotes' ) ),
					'symbol-enable'        => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE, $l_arr_enabled ),
					'notice-symbol'        => __( 'Please choose or input the symbol at the top of the next dashboard tab.', 'footnotes' ),

					'label-switch'         => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH, __( 'Symbol appended, not prepended:', 'footnotes' ) ),
					'switch'               => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH, $l_arr_enabled ),

					'label-3column'        => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE, __( 'Backlink symbol in an extra column:', 'footnotes' ) ),
					'3column'              => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE, $l_arr_enabled ),
					'notice-3column'       => __( 'This legacy layout is available if identical footnotes are not combined.', 'footnotes' ),

					'label-row-borders'    => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE, __( 'Borders around the table rows:', 'footnotes' ) ),
					'row-borders'          => $this->add_select_box( MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE, $l_arr_enabled ),

					'label-separator'      => $this->add_label( MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_ENABLED, __( 'Add a separator when enumerating backlinks:', 'footnotes' ) ),
					'separator-enable'     => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_ENABLED, $l_arr_enabled ),
					'separator-options'    => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_OPTION, $l_arr_separators ),
					'separator-custom'     => $this->add_text_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_CUSTOM ),
					'notice-separator'     => __( 'Your input overrides the selection.', 'footnotes' ),

					'label-terminator'     => $this->add_label( MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_ENABLED, __( 'Add a terminal punctuation to backlinks:', 'footnotes' ) ),
					'terminator-enable'    => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_ENABLED, $l_arr_enabled ),
					'terminator-options'   => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_OPTION, $l_arr_terminators ),
					'terminator-custom'    => $this->add_text_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_CUSTOM ),
					'notice-terminator'    => __( 'Your input overrides the selection.', 'footnotes' ),

					'label-width'          => $this->add_label( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_ENABLED, __( 'Set backlinks column width:', 'footnotes' ) ),
					'width-enable'         => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_ENABLED, $l_arr_enabled ),
					'width-scalar'         => $this->add_num_box( MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR, 0, 500, true ),
					'width-unit'           => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT, $l_arr_width_units ),
					'notice-width'         => __( 'Absolute width in pixels doesn’t need to be accurate to the tenth, but relative width in rem or em may.', 'footnotes' ),

					'label-max-width'      => $this->add_label( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED, __( 'Set backlinks column maximum width:', 'footnotes' ) ),
					'max-width-enable'     => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED, $l_arr_enabled ),
					'max-width-scalar'     => $this->add_num_box( MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR, 0, 500, true ),
					'max-width-unit'       => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT, $l_arr_width_units ),
					'notice-max-width'     => __( 'Absolute width in pixels doesn’t need to be accurate to the tenth, but relative width in rem or em may.', 'footnotes' ),

					'label-line-break'     => $this->add_label( MCI_Footnotes_Settings::C_STR_BACKLINKS_LINE_BREAKS_ENABLED, __( 'Stack backlinks when enumerating:', 'footnotes' ) ),
					'line-break'           => $this->add_select_box( MCI_Footnotes_Settings::C_STR_BACKLINKS_LINE_BREAKS_ENABLED, $l_arr_enabled ),
					'notice-line-break'    => __( 'This option adds a line break before each added backlink when identical footnotes are combined.', 'footnotes' ),

					'label-link'           => $this->add_label( MCI_Footnotes_Settings::C_STR_LINK_ELEMENT_ENABLED, __( 'Use the link element for referrers and backlinks:', 'footnotes' ) ),
					'link'                 => $this->add_select_box( MCI_Footnotes_Settings::C_STR_LINK_ELEMENT_ENABLED, $l_arr_enabled ),
					'notice-link'          => __( 'The link element is needed to apply the theme’s link color.', 'footnotes' ),
					'description-link'     => __( 'If the link element is not desired for styling, a simple span is used instead when the above is set to No. The link addresses have been removed. Else footnote clicks are logged in the browsing history and make the back button unusable.', 'footnotes' ),
				)
			);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all options for the footnotes start and end tag short codes.
	 *
	 * @since 1.5.0
	 *
	 * Edited heading  2020-12-12T1412+0100
	 * @since 2.2.0  start/end short codes: more predefined options  2020-12-12T1412+0100
	 * @link https://wordpress.org/support/topic/doesnt-work-with-mailpoet/
	 * @since 2.2.0  3 boxes for clarity  2020-12-12T1422+0100
	 * @since 2.2.5  support for Ibid. notation thanks to @meglio   2020-12-17T2019+0100
	 * @link https://wordpress.org/support/topic/add-support-for-ibid-notation/
	 * @since 2.4.0  added warning about Block Editor escapement disruption  2021-01-02T2324+0100
	 * @since 2.4.0  removed the HTML comment tag option  2021-01-02T2325+0100
	 * @since 2.5.0  Shortcode syntax validation: add more information around the setting, thanks to @andreasra
	 * @link https://wordpress.org/support/topic/warning-unbalanced-footnote-start-tag-short-code-before/
	 */
	public function start_end() {
		// Footnotes start tag short code options.
		$l_arr_shortcode_start = array(
			'(('                        => '((',
			'((('                       => '(((',
			'{{'                        => '{{',
			'{{{'                       => '{{{',
			'[n]'                       => '[n]',
			'[fn]'                      => '[fn]',
			htmlspecialchars( '<fn>' )  => htmlspecialchars( '<fn>' ),
			'[ref]'                     => '[ref]',
			htmlspecialchars( '<ref>' ) => htmlspecialchars( '<ref>' ),
			// Custom (user-defined) start and end tags bracketing the footnote text inline.
			'userdefined'               => __( 'custom short code', 'footnotes' ),
		);
		// Footnotes end tag short code options.
		$l_arr_shortcode_end = array(
			'))'                         => '))',
			')))'                        => ')))',
			'}}'                         => '}}',
			'}}}'                        => '}}}',
			'[/n]'                       => '[/n]',
			'[/fn]'                      => '[/fn]',
			htmlspecialchars( '</fn>' )  => htmlspecialchars( '</fn>' ),
			'[/ref]'                     => '[/ref]',
			htmlspecialchars( '</ref>' ) => htmlspecialchars( '</ref>' ),
			// Custom (user-defined) start and end tags bracketing the footnote text inline.
			'userdefined'                => __( 'custom short code', 'footnotes' ),
		);
		// Options for the syntax validation.
		$l_arr_enable = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'settings-start-end' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'description-escapement'   => __( 'WARNING: Short codes with closing pointy brackets are disabled in the new WordPress Block Editor that disrupts the traditional balanced escapement applied by WordPress Classic Editor.', 'footnotes' ),

				'label-short-code-start'   => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, __( 'Footnote start tag short code:', 'footnotes' ) ),
				'short-code-start'         => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START, $l_arr_shortcode_start ),
				'short-code-start-user'    => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED ),

				'label-short-code-end'     => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, __( 'Footnote end tag short code:', 'footnotes' ) ),
				'short-code-end'           => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END, $l_arr_shortcode_end ),
				'short-code-end-user'      => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED ),

				// For script showing/hiding user defined text boxes.
				'short-code-start-id'      => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START,
				'short-code-end-id'        => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END,
				'short-code-start-user-id' => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED,
				'short-code-end-user-id'   => MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED,

				'description-parentheses'  => __( 'WARNING: Although widespread industry standard, the double parentheses are problematic because they may occur in scripts embedded in the content and be mistaken as a short code.', 'footnotes' ),

				// Option to enable syntax validation, label mirrored in task.php.
				'label-syntax'             => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE, __( 'Check for balanced shortcodes:', 'footnotes' ) ),
				'syntax'                   => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE, $l_arr_enable ),
				'notice-syntax'            => __( 'In the presence of a lone start tag shortcode, a warning displays below the post title.', 'footnotes' ),

				'description-syntax'       => __( 'If the start tag short code is ‘((’ or ‘(((’, it will not be reported as unbalanced if the following string contains braces hinting that it is a script.', 'footnotes' ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all options for the footnotes numbering.
	 *
	 * @since 2.2.0
	 */
	public function numbering() {
		// Define some space for the output.
		$l_str_space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		// Options for the combination of identical footnotes.
		$l_arr_enable = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);
		// Options for the numbering style of the footnotes.
		$l_arr_counter_style = array(
			'arabic_plain'   => __( 'plain Arabic numbers', 'footnotes' ) . $l_str_space . '1, 2, 3, 4, 5, …',
			'arabic_leading' => __( 'zero-padded Arabic numbers', 'footnotes' ) . $l_str_space . '01, 02, 03, 04, 05, …',
			'latin_low'      => __( 'lowercase Latin letters', 'footnotes' ) . $l_str_space . 'a, b, c, d, e, …',
			'latin_high'     => __( 'uppercase Latin letters', 'footnotes' ) . $l_str_space . 'A, B, C, D, E, …',
			'romanic'        => __( 'uppercase Roman numerals', 'footnotes' ) . $l_str_space . 'I, II, III, IV, V, …',
			'roman_low'      => __( 'lowercase Roman numerals', 'footnotes' ) . $l_str_space . 'i, ii, iii, iv, v, …',
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'settings-numbering' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-counter-style'   => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, __( 'Numbering style:', 'footnotes' ) ),
				'counter-style'         => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE, $l_arr_counter_style ),

				// Algorithmically combine identicals.
				'label-identical'       => $this->add_label( MCI_Footnotes_Settings::C_STR_COMBINE_IDENTICAL_FOOTNOTES, __( 'Combine identical footnotes:', 'footnotes' ) ),
				'identical'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_COMBINE_IDENTICAL_FOOTNOTES, $l_arr_enable ),
				'notice-identical'      => __( 'This option may require copy-pasting footnotes in multiple instances.', 'footnotes' ),
				// Support for Ibid. notation added thanks to @meglio in <https://wordpress.org/support/topic/add-support-for-ibid-notation/>.
				'description-identical' => __( 'Even when footnotes are combined, footnote numbers keep incrementing. This avoids suboptimal referrer and backlink disambiguation using a secondary numbering system. The Ibid. notation and the op. cit. abbreviation followed by the current page number avoid repeating the footnote content. For changing sources, shortened citations may be used. Repeating full citations is also an opportunity to add details.', 'footnotes' ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all options for the scrolling behavior.
	 *
	 * @since 2.2.0
	 */
	public function scrolling() {

		// Options for enabling hard links for AMP compat.
		$l_arr_enable = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'settings-scrolling' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'label-scroll-offset'          => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET, __( 'Scroll offset:', 'footnotes' ) ),
				'scroll-offset'                => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET, 0, 100 ),
				'notice-scroll-offset'         => __( 'per cent from the upper edge of the window', 'footnotes' ),

				'label-scroll-duration'        => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION, __( 'Scroll duration:', 'footnotes' ) ),
				'scroll-duration'              => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION, 0, 20000 ),
				'notice-scroll-duration'       => __( 'milliseconds; instantly if hard links are enabled and JavaScript is disabled', 'footnotes' ),

				// Enable hard links for AMP compat.
				'label-hard-links'             => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_HARD_LINKS_ENABLE, __( 'Enable hard links:', 'footnotes' ) ),
				'hard-links'                   => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_HARD_LINKS_ENABLE, $l_arr_enable ),
				'notice-hard-links'            => __( 'Hard links are indispensable for AMP compatibility and allow to link to footnotes.', 'footnotes' ),

				'label-footnote'               => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG, __( 'Fragment identifier slug for footnotes:', 'footnotes' ) ),
				'footnote'                     => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG ),
				'notice-footnote'              => __( 'This will show up in the address bar after clicking on a hard-linked footnote referrer.', 'footnotes' ),

				'label-referrer'               => $this->add_label( MCI_Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG, __( 'Fragment identifier slug for footnote referrers:', 'footnotes' ) ),
				'referrer'                     => $this->add_text_box( MCI_Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG ),
				'notice-referrer'              => __( 'This will show up in the address bar after clicking on a hard-linked backlink.', 'footnotes' ),

				'label-separator'              => $this->add_label( MCI_Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR, __( 'ID separator:', 'footnotes' ) ),
				'separator'                    => $this->add_text_box( MCI_Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR ),
				'notice-separator'             => __( 'May be empty or any string, for example _, - or +, to distinguish post number, container number and footnote number.', 'footnotes' ),

				// Enable backlink tooltips.
				'label-backlink-tooltips'      => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE, __( 'Enable backlink tooltips:', 'footnotes' ) ),
				'backlink-tooltips'            => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_ENABLE, $l_arr_enable ),
				'notice-backlink-tooltips'     => __( 'Hard backlinks get ordinary tooltips hinting to use the backbutton instead.', 'footnotes' ),

				'label-backlink-tooltip-text'  => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT, __( 'Backlink tooltip text:', 'footnotes' ) ),
				'backlink-tooltip-text'        => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_BACKLINK_TOOLTIP_TEXT ),
				'notice-backlink-tooltip-text' => __( 'Default text is the keyboard shortcut, but you may wish to input a descriptive hint in your language.', 'footnotes' ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all settings for 'I love Footnotes'.
	 *
	 * @since 1.5.0
	 *
	 * Edited:
	 * @since 2.2.0  position-sensitive placeholders to support more locales   2020-12-11T0432+0100
	 * @since 2.2.0  more options   2020-12-11T0432+0100
	 */
	public function love() {
		// Options for the acknowledgment display in the footer.
		$l_arr_love = array(
			// Logo only.
			'text-3' => sprintf( '%s', MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME ),
			// Logo followed by heart symbol.
			'text-4' => sprintf( '%s %s', MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL ),
			// Logo preceded by heart symbol.
			'text-5' => sprintf( '%s %s', MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME ),
			// Translators: 2: heart symbol 1: footnotes logogram.
			'text-1' => sprintf( __( 'I %2$s %1$s', 'footnotes' ), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL ),
			// Translators: %s: Plugin logo.
			'text-6' => sprintf( __( 'This website uses %s.', 'footnotes' ), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME ),
			// Translators: %s: Plugin logo.
			'text-7' => sprintf( __( 'This website uses the %s plugin.', 'footnotes' ), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME ),
			// Translators: %s: Plugin logo.
			'text-2' => sprintf( __( 'This website uses the awesome %s plugin.', 'footnotes' ), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME ),
			'random' => __( 'randomly determined display of either mention', 'footnotes' ),
			// Translators: 1: Plugin logo.2: heart symbol.
			'no'     => sprintf( __( 'no display of any “%1$s %2$s” mention in the footer', 'footnotes' ), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'settings-love' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				// Translators: %s: Plugin logo.
				'label-love'    => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, sprintf( __( 'Tell the world you’re using %s:', 'footnotes' ), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME ) ),
				'love'          => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE, $l_arr_love ),
				// Translators: %s: Plugin logo.
				'label-no-love' => $this->add_text( sprintf( __( 'Shortcode to inhibit the display of the %s mention on specific pages:', 'footnotes' ), MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME ) ),
				'no-love'       => $this->add_text( MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays the excerpt setting.
	 *
	 * @since 1.5.0
	 *
	 * Edited heading   2020-12-12T1453+0100
	 * @since 2.1.1   more settings and notices, thanks to @nikelaos
	 * @link https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13687068
	 * @link https://wordpress.org/support/topic/jquery-comes-up-in-feed-content/#post-13110879
	 * @since 2.2.0   dedicated to the excerpt setting and its notices   2020-12-12T1454+0100
	 */
	public function excerpts() {
		// Options for Yes/No select box.
		$l_arr_enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'settings-excerpts' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-excerpts'       => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_IN_EXCERPT, __( 'Display footnotes in excerpts:', 'footnotes' ) ),
				'excerpts'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_IN_EXCERPT, $l_arr_enabled ),
				'notice-excerpts'      => __( 'The recommended value is No.', 'footnotes' ),
				// Translators: %s: link to the Advanced Excerpt Plugin.
				'description-excerpts' => sprintf( __( 'In some themes, the %s plugin is indispensable to display footnotes in excerpts. Footnotes cannot be disabled in excerpts. A workaround is to avoid footnotes in the first 55&nbsp;words.', 'footnotes' ), '<a href="https://wordpress.org/plugins/advanced-excerpt/" target="_blank">Advanced Excerpt</a>' ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all settings for the footnote referrers.
	 *
	 * @since 1.5.0
	 *
	 * Edited heading   2020-12-12T1513+0100
	 * @since 2.1.1  option for superscript (optionally baseline referrers)
	 * @since 2.2.0  option for link element moved here   2020-12-12T1514+0100
	 */
	public function superscript() {
		// Options for Yes/No select box.
		$l_arr_enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);
		// Options for superscript normalize scope.
		$l_arr_normalize_superscript = array(
			'no'        => __( 'No', 'footnotes' ),
			'referrers' => __( 'Footnote referrers', 'footnotes' ),
			'all'       => __( 'All superscript elements', 'footnotes' ),
		);
		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'customize-superscript' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-superscript' => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS, __( 'Display footnote referrers in superscript:', 'footnotes' ) ),
				'superscript'       => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS, $l_arr_enabled ),

				'label-before'      => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE, __( 'At the start of the footnote referrers:', 'footnotes' ) ),
				'before'            => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE ),

				'label-after'       => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER, __( 'At the end of the footnote referrers:', 'footnotes' ) ),
				'after'             => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER ),

				'label-link'        => $this->add_label( MCI_Footnotes_Settings::C_STR_LINK_ELEMENT_ENABLED, __( 'Use the link element for referrers and backlinks:', 'footnotes' ) ),
				'notice-link'       => __( 'Please find this setting at the end of the reference container settings. The link element is needed to apply the theme’s link color.', 'footnotes' ),

				'label-normalize'   => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT, __( 'Normalize vertical alignment and font size:', 'footnotes' ) ),
				'normalize'         => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTE_REFERRERS_NORMAL_SUPERSCRIPT, $l_arr_normalize_superscript ),
				'notice-normalize'  => __( 'Most themes don’t need this fix.', 'footnotes' ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays enabled status for the footnotes mouse-over box.
	 *
	 * @since 1.5.2
	 *
	 * Edited:
	 * @since 2.2.0   5 parts to address increased settings number
	 * @since 2.2.5   position settings for alternative tooltips
	 */
	public function mouseover_box() {
		// Options for Yes/No select box.
		$l_arr_enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'mouse-over-box-display' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'label-enable'            => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ENABLED, __( 'Display tooltips:', 'footnotes' ) ),
				'enable'                  => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ENABLED, $l_arr_enabled ),
				'notice-enable'           => __( 'Formatted text boxes allowing hyperlinks, displayed on mouse-over or tap and hold.', 'footnotes' ),

				'label-alternative'       => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE, __( 'Display alternative tooltips:', 'footnotes' ) ),
				'alternative'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE, $l_arr_enabled ),
				'notice-alternative'      => __( 'Intended to work around a configuration-related tooltip outage.', 'footnotes' ),
				// Translators: %s: Plugin logo.
				'description-alternative' => sprintf( __( 'These alternative tooltips work around a website related jQuery UI outage. They are low-script but use the AMP incompatible onmouseover and onmouseout arguments, along with CSS transitions for fade-in/out. The very small script is inserted after Footnotes’ internal stylesheet. When this option is enabled, %s does not load jQuery&nbsp;UI nor jQuery&nbsp;Tools.', 'footnotes' ), '<span style="font-style: normal;">' . MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME . '</span>' ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays position settings for the footnotes mouse-over box.
	 *
	 * @since 2.2.0
	 */
	public function mouseover_box_position() {

		// Options for the Mouse-over box position.
		$l_arr_position = array(
			'top left'      => __( 'top left', 'footnotes' ),
			'top center'    => __( 'top center', 'footnotes' ),
			'top right'     => __( 'top right', 'footnotes' ),
			'center right'  => __( 'center right', 'footnotes' ),
			'bottom right'  => __( 'bottom right', 'footnotes' ),
			'bottom center' => __( 'bottom center', 'footnotes' ),
			'bottom left'   => __( 'bottom left', 'footnotes' ),
			'center left'   => __( 'center left', 'footnotes' ),
		);
		// Options for the alternative Mouse-over box position.
		$l_arr_alternative_position = array(
			'top left'     => __( 'top left', 'footnotes' ),
			'top right'    => __( 'top right', 'footnotes' ),
			'bottom right' => __( 'bottom right', 'footnotes' ),
			'bottom left'  => __( 'bottom left', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'mouse-over-box-position' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'label-position'       => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION, __( 'Position:', 'footnotes' ) ),
				'position'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION, $l_arr_position ),
				'position-alternative' => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION, $l_arr_alternative_position ),
				'notice-position'      => __( 'The second column of settings boxes is for the alternative tooltips.', 'footnotes' ),

				'label-offset-x'       => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X, __( 'Horizontal offset:', 'footnotes' ) ),
				'offset-x'             => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X, -500, 500 ),
				'offset-x-alternative' => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X, -500, 500 ),
				'notice-offset-x'      => __( 'pixels; negative value for a leftwards offset; alternative tooltips: direction depends on position', 'footnotes' ),

				'label-offset-y'       => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y, __( 'Vertical offset:', 'footnotes' ) ),
				'offset-y'             => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y, -500, 500 ),
				'offset-y-alternative' => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y, -500, 500 ),
				'notice-offset-y'      => __( 'pixels; negative value for an upwards offset; alternative tooltips: direction depends on position', 'footnotes' ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays dimensions setting for the footnotes mouse-over box.
	 *
	 * @since 2.2.0
	 */
	public function mouseover_box_dimensions() {

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'mouse-over-box-dimensions' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'label-max-width'  => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH, __( 'Maximum width:', 'footnotes' ) ),
				'max-width'        => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH, 0, 1280 ),
				'width'            => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH, 0, 1280 ),
				'notice-max-width' => __( 'pixels; set to 0 for jQuery tooltips without max width; alternative tooltips are given the value in the second box as fixed width.', 'footnotes' ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays timing settings for the footnotes mouse-over box.
	 *
	 * @since 2.2.0
	 */
	public function mouseover_box_timing() {

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'mouse-over-box-timing' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'label-fade-in-delay'      => $this->add_label( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY, __( 'Fade-in delay:', 'footnotes' ) ),
				'fade-in-delay'            => $this->add_num_box( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY, 0, 20000 ),
				'notice-fade-in-delay'     => __( 'milliseconds', 'footnotes' ),

				'label-fade-in-duration'   => $this->add_label( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION, __( 'Fade-in duration:', 'footnotes' ) ),
				'fade-in-duration'         => $this->add_num_box( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION, 0, 20000 ),
				'notice-fade-in-duration'  => __( 'milliseconds', 'footnotes' ),

				'label-fade-out-delay'     => $this->add_label( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY, __( 'Fade-out delay:', 'footnotes' ) ),
				'fade-out-delay'           => $this->add_num_box( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY, 0, 20000 ),
				'notice-fade-out-delay'    => __( 'milliseconds', 'footnotes' ),

				'label-fade-out-duration'  => $this->add_label( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION, __( 'Fade-out duration:', 'footnotes' ) ),
				'fade-out-duration'        => $this->add_num_box( MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION, 0, 20000 ),
				'notice-fade-out-duration' => __( 'milliseconds', 'footnotes' ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays truncation settings for the footnotes mouse-over box.
	 *
	 * @since 2.2.0
	 */
	public function mouseover_box_truncation() {
		// Options for Yes/No select box.
		$l_arr_enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'mouse-over-box-truncation' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'label-truncation'  => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED, __( 'Truncate the note in the tooltip:', 'footnotes' ) ),
				'truncation'        => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED, $l_arr_enabled ),

				'label-max-length'  => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH, __( 'Maximum number of characters in the tooltip:', 'footnotes' ) ),
				'max-length'        => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH, 3, 10000 ),
				// The feature trims back until the last full word.
				'notice-max-length' => __( 'No weird cuts.', 'footnotes' ),

				'label-readon'      => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL, __( '‘Read on’ button label:', 'footnotes' ) ),
				'readon'            => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays dedicated tooltip text settings for the footnotes mouse-over box.
	 *
	 * @since 2.2.0
	 */
	public function mouseover_box_text() {
		// Options for Yes/No select box.
		$l_arr_enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'mouse-over-box-text' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'description-delimiter' => __( 'Tooltips can display another content than the footnote entry in the reference container. The trigger is a shortcode in the footnote text separating the tooltip text from the note. That is consistent with what WordPress does for excerpts.', 'footnotes' ),

				'label-delimiter'       => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER, __( 'Delimiter for dedicated tooltip text:', 'footnotes' ) ),
				'delimiter'             => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_DELIMITER ),
				'notice-delimiter'      => __( 'If the delimiter shortcode is present, the tooltip text will be the part before it.', 'footnotes' ),

				'label-mirror'          => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE, __( 'Mirror the tooltip in the reference container:', 'footnotes' ) ),
				'mirror'                => $this->add_select_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_ENABLE, $l_arr_enabled ),
				'notice-mirror'         => __( 'Tooltips may be harder to use on mobiles. This option allows to read it in the reference container.', 'footnotes' ),

				'label-separator'       => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR, __( 'Separator between tooltip text and footnote text:', 'footnotes' ) ),
				'separator'             => $this->add_text_box( MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_EXCERPT_MIRROR_SEPARATOR ),
				'notice-separator'      => __( 'May be a simple space, or a line break &lt;br /&gt;, or any string in your language.', 'footnotes' ),

				'description-mirror'    => __( 'Tooltips, even jQuery-driven, may be hard to consult on mobiles. This option allows to read the tooltip content in the reference container too.', 'footnotes' ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays style settings for the footnotes mouse-over box.
	 *
	 * @since 2.2.0
	 */
	public function mouseover_box_appearance() {
		// Options for Yes/No select box.
		$l_arr_enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);
		// Options for the font size unit.
		$l_arr_font_size_units = array(
			'em'  => __( 'em', 'footnotes' ),
			'rem' => __( 'rem', 'footnotes' ),
			'px'  => __( 'pixels', 'footnotes' ),
			'pt'  => __( 'points', 'footnotes' ),
			'pc'  => __( 'picas', 'footnotes' ),
			'mm'  => __( 'millimeters', 'footnotes' ),
			'%'   => __( 'per cent', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'mouse-over-box-appearance' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(

				'label-font-size'         => $this->add_label( MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_ENABLED, __( 'Set font size:', 'footnotes' ) ),
				'font-size-enable'        => $this->add_select_box( MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_ENABLED, $l_arr_enabled ),
				'font-size-scalar'        => $this->add_num_box( MCI_Footnotes_Settings::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR, 0, 50, true ),
				'font-size-unit'          => $this->add_select_box( MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT, $l_arr_font_size_units ),
				'notice-font-size'        => __( 'By default, the font size is set to equal the surrounding text.', 'footnotes' ),

				'label-color'             => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR, __( 'Text color:', 'footnotes' ) ),
				'color'                   => $this->add_color_selection( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR ),
				// Translators: %s: Clear or leave empty.
				'notice-color'            => sprintf( __( 'To use the current theme’s default text color: %s', 'footnotes' ), __( 'Clear or leave empty.', 'footnotes' ) ),

				'label-background'        => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND, __( 'Background color:', 'footnotes' ) ),
				'background'              => $this->add_color_selection( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND ),
				// Translators: %s: Clear or leave empty.
				'notice-background'       => sprintf( __( 'To use the current theme’s default background color: %s', 'footnotes' ), __( 'Clear or leave empty.', 'footnotes' ) ),

				'label-border-width'      => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH, __( 'Border width:', 'footnotes' ) ),
				'border-width'            => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH, 0, 4, true ),
				'notice-border-width'     => __( 'pixels; 0 for borderless', 'footnotes' ),

				'label-border-color'      => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR, __( 'Border color:', 'footnotes' ) ),
				'border-color'            => $this->add_color_selection( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR ),
				// Translators: %s: Clear or leave empty.
				'notice-border-color'     => sprintf( __( 'To use the current theme’s default border color: %s', 'footnotes' ), __( 'Clear or leave empty.', 'footnotes' ) ),

				'label-border-radius'     => $this->add_label( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS, __( 'Rounded corner radius:', 'footnotes' ) ),
				'border-radius'           => $this->add_num_box( MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS, 0, 500 ),
				'notice-border-radius'    => __( 'pixels; 0 for sharp corners', 'footnotes' ),

				'label-box-shadow-color'  => $this->add_label( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR, __( 'Box shadow color:', 'footnotes' ) ),
				'box-shadow-color'        => $this->add_color_selection( MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR ),
				// Translators: %s: Clear or leave empty.
				'notice-box-shadow-color' => sprintf( __( 'To use the current theme’s default box shadow color: %s', 'footnotes' ), __( 'Clear or leave empty.', 'footnotes' ) ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all settings for the backlink symbol.
	 *
	 * @since 1.5.0
	 *
	 * Edited heading for v2.0.4
	 *
	 * The former 'hyperlink arrow', incompatible with combined identical footnotes,
	 * became 'prepended arrow' in v2.0.3 after a user complaint about missing backlinking semantics
	 * of the footnote number.
	 *
	 * @since 2.1.4  moved to Settings > Reference container > Display a backlink symbol
	 * @since 2.2.1 and 2.2.4  back here
	 */
	public function hyperlink_arrow() {
		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'customize-hyperlink-arrow' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-symbol'       => $this->add_label( MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW, __( 'Select or input the backlink symbol:', 'footnotes' ) ),
				'symbol-options'     => $this->add_select_box( MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW, MCI_Footnotes_Convert::get_arrow() ),
				'symbol-custom'      => $this->add_text_box( MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED ),
				'notice-symbol'      => __( 'Your input overrides the selection.', 'footnotes' ),
				'description-symbol' => __( 'This symbol is used in the reference container. But this setting pre-existed under this tab and cannot be moved to another one.', 'footnotes' ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays the Custom CSS box.
	 *
	 * @since 1.5.0
	 *
	 * Edited:
	 * @since 2.1.6  drop localized notices for CSS classes as the number increased to 16
	 *        list directly in the template, as CSS is in English anyway
	 * @see templates/dashboard/customize-css.html
	 *         2020-12-09T1113+0100
	 *
	 * @since 2.2.2  migrate Custom CSS to a dedicated tab   2020-12-15T0506+0100
	 * @since 2.3.0  say 'copy-paste' instead of 'cut and paste' since cutting is not needed  2020-12-27T1257+0100
	 * @since 2.5.1  mention validity while visible, thanks to @rkupadhya bug report
	 */
	public function custom_css() {
		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'customize-css' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-css'       => $this->add_label( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS, __( 'Your existing Custom CSS code:', 'footnotes' ) ),
				'css'             => $this->add_textarea( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS ),
				'description-css' => __( 'Custom CSS migrates to a dedicated tab. This text area is intended to keep your data safe, and the code remains valid while visible. Please copy-paste the content into the new text area under the new tab.', 'footnotes' ),

				// phpcs:disable Squiz.PHP.CommentedOutCode.Found
				// CSS classes are listed in the template.
				// Localized notices are dropped to ease translators’ task.

				// "label-class-1" => ".footnote_plugin_tooltip_text",.
				// "class-1" => $this->add_text(__("superscript, Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),.

				// "label-class-2" => ".footnote_tooltip",.
				// "class-2" => $this->add_text(__("mouse-over box, tooltip for each superscript", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),.

				// "label-class-3" => ".footnote_plugin_index",.
				// "class-3" => $this->add_text(__("1st column of the Reference Container, Footnotes index", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)),.

				// "label-class-4" => ".footnote_plugin_text",.
				// "class-4" => $this->add_text(__("2nd column of the Reference Container, Footnote text", MCI_Footnotes_Config::C_STR_PLUGIN_NAME)).
				// phpcs:enable
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays transitional legacy Custom CSS box.
	 *
	 * @since 2.2.2
	 */
	public function custom_css_migration() {

		// Options for Yes/No select box.
		$l_arr_enabled = array(
			'yes' => __( 'Yes', 'footnotes' ),
			'no'  => __( 'No', 'footnotes' ),
		);

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'customize-css-migration' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-css'               => $this->add_label( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS, __( 'Your existing Custom CSS code:', 'footnotes' ) ),
				'css'                     => $this->add_textarea( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS ),
				'description-css'         => __( 'Custom CSS migrates to a dedicated tab. This text area is intended to keep your data safe, and the code remains valid while visible. Please copy-paste the content into the new text area below. Set Show legacy to No. Save twice.', 'footnotes' ),

				'label-show-legacy'       => $this->add_label( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_LEGACY_ENABLE, 'Show legacy Custom CSS settings containers:' ),
				'show-legacy'             => $this->add_select_box( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_LEGACY_ENABLE, $l_arr_enabled ),
				'notice-show-legacy'      => __( 'Please set to No when you are done migrating, for the legacy Custom CSS containers to disappear.', 'footnotes' ),
				// Translators: %s: Referres and tooltips.
				'description-show-legacy' => sprintf( __( 'The legacy Custom CSS under the %s tab and its mirror here are emptied, and the select box saved as No, when the settings tab is saved while the settings container is not displayed.', 'footnotes' ), __( 'Referrers and tooltips', 'footnotes' ) ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays the new Custom CSS box.
	 *
	 * @since 2.2.2
	 */
	public function custom_css_new() {
		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'customize-css-new' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'css'      => $this->add_textarea( MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_NEW ),

				'headline' => $this->add_text( __( 'Recommended CSS classes:', 'footnotes' ) ),

			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays available Hooks to look for Footnote short codes.
	 *
	 * @since 1.5.5
	 *
	 * Edited:
	 * @since 2.1.1  priority level setting for the_content  2020-11-16T2152+0100
	 * @since 2.1.4  priority level settings for the other hooks   2020-11-19T1421+0100
	 *
	 * priority level was initially hard-coded default
	 * shows "9223372036854775807" in the numbox
	 * empty should be interpreted as PHP_INT_MAX,
	 * but a numbox cannot be set to empty: <https://github.com/Modernizr/Modernizr/issues/171>
	 * define -1 as PHP_INT_MAX instead
	 *
	 * @since 2.2.9  removed the warning about the widget text hook  2020-12-25T0348+0100
	 * @since 2.2.9  added guidance for the widget text hook  2020-12-25T0353+0100
	 */
	public function lookup_hooks() {
		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'expert-lookup' );

		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'description-1'         => __( 'The priority level determines whether Footnotes is executed timely before other plugins, and how the reference container is positioned relative to other features.', 'footnotes' ),
				// Translators: 1: 99; 2: 1200.
				'description-2'         => sprintf( __( 'For the_content, this figure must be lower than %1$d so that certain strings added by a plugin running at %1$d may not be mistaken as a footnote. This makes also sure that the reference container displays above a feature inserted by a plugin running at %2$d.', 'footnotes' ), 99, 1200 ),
				// Translators: 1: PHP_INT_MAX; 2: 0; 3: -1; 4: 'PHP_INT_MAX'.
				'description-3'         => sprintf( __( '%1$d is lowest priority, %2$d is highest. To set priority level to lowest, set it to %3$d, interpreted as %1$d, the constant %4$s.', 'footnotes' ), PHP_INT_MAX, 0, -1, 'PHP_INT_MAX' ),
				'description-4'         => __( 'The widget_text hook must be enabled either when footnotes are present in theme text widgets, or when Elementor accordions or toggles shall have a reference container per section. If they should not, this hook must be disabled.', 'footnotes' ),

				'head-hook'             => __( 'WordPress hook function name', 'footnotes' ),
				'head-checkbox'         => __( 'Activate', 'footnotes' ),
				'head-numbox'           => __( 'Priority level', 'footnotes' ),
				'head-url'              => __( 'WordPress documentation', 'footnotes' ),

				'label-the-title'       => $this->add_label( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_TITLE, 'the_title' ),
				'the-title'             => $this->add_checkbox( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_TITLE ),
				'priority-the-title'    => $this->add_num_box( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-the-title'         => 'https://developer.wordpress.org/reference/hooks/the_title/',

				'label-the-content'     => $this->add_label( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_CONTENT, 'the_content' ),
				'the-content'           => $this->add_checkbox( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_CONTENT ),
				'priority-the-content'  => $this->add_num_box( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-the-content'       => 'https://developer.wordpress.org/reference/hooks/the_content/',

				'label-the-excerpt'     => $this->add_label( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_EXCERPT, 'the_excerpt' ),
				'the-excerpt'           => $this->add_checkbox( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_THE_EXCERPT ),
				'priority-the-excerpt'  => $this->add_num_box( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-the-excerpt'       => 'https://developer.wordpress.org/reference/functions/the_excerpt/',

				'label-widget-title'    => $this->add_label( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TITLE, 'widget_title' ),
				'widget-title'          => $this->add_checkbox( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TITLE ),
				'priority-widget-title' => $this->add_num_box( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-widget-title'      => 'https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_title',

				'label-widget-text'     => $this->add_label( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TEXT, 'widget_text' ),
				'widget-text'           => $this->add_checkbox( MCI_Footnotes_Settings::C_STR_EXPERT_LOOKUP_WIDGET_TEXT ),
				'priority-widget-text'  => $this->add_num_box( MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL, -1, PHP_INT_MAX ),
				'url-widget-text'       => 'https://codex.wordpress.org/Plugin_API/Filter_Reference/widget_text',
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays a short introduction of the Plugin.
	 *
	 * @since 1.5.0
	 */
	public function Help() {
		global $g_obj_mci_footnotes;
		// Load footnotes starting and end tag.
		$l_arr_footnote_starting_tag = $this->load_setting( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START );
		$l_arr_footnote_ending_tag   = $this->load_setting( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END );

		if ( 'userdefined' === $l_arr_footnote_starting_tag['value'] || 'userdefined' === $l_arr_footnote_ending_tag['value'] ) {
			// Load user defined starting and end tag.
			$l_arr_footnote_starting_tag = $this->load_setting( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED );
			$l_arr_footnote_ending_tag   = $this->load_setting( MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED );
		}
		$l_str_example = 'Hello' . $l_arr_footnote_starting_tag['value'] .
											'Lorem ipsum dolor sit amet, consetetur sadipscing ' .
											'elitr, sed diam nonumy eirmod tempor invidunt ut ' .
											'labore et dolore magna aliquyam erat, sed diam ' .
											'voluptua. At vero eos et accusam et justo duo dolores ' .
											'et ea rebum. Stet clita kasd gubergren, no sea ' .
											'takimata sanctus est Lorem ipsum dolor sit amet. ' .
											'Lorem ipsum dolor sit amet, consetetur sadipscing ' .
											'elitr, sed diam nonumy eirmod tempor invidunt ut ' .
											'labore et dolore magna aliquyam erat, sed diam ' .
											'voluptua. At vero eos et accusam et justo duo ' .
											'dolores et ea rebum. Stet clita kasd gubergren, no ' .
											'sea takimata sanctus est Lorem ipsum dolor sit amet.' .
											$l_arr_footnote_ending_tag['value'] . ' World!';

		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'how-to-help' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'label-start'    => __( 'Start your footnote with the following short code:', 'footnotes' ),
				'start'          => $l_arr_footnote_starting_tag['value'],
				'label-end'      => __( '…and end your footnote with this short code:', 'footnotes' ),
				'end'            => $l_arr_footnote_ending_tag['value'],
				'example-code'   => $l_str_example,
				'example-string' => '<br/>' . __( 'will be displayed as:', 'footnotes' ),
				'example'        => $g_obj_mci_footnotes->a_obj_task->exec( $l_str_example, true ),
				// Translators: 1: <a>; 2: </a>.
				'information'    => sprintf( __( 'For further information please check out our %1$ssupport forum%2$s on WordPress.org.', 'footnotes' ), '<a href="http://wordpress.org/support/plugin/footnotes" target="_blank" class="footnote_plugin">', '</a>' ),
			)
		);
		// Call wp_head function to get the Styling of the mouse-over box.
		$g_obj_mci_footnotes->a_obj_task->wp_head();
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}

	/**
	 * Displays all Donate button to support the developers.
	 *
	 * @since 1.5.0
	 */
	public function donate() {
		// Load template file.
		$l_obj_template = new MCI_Footnotes_Template( MCI_Footnotes_Template::C_STR_DASHBOARD, 'how-to-donate' );
		// Replace all placeholders.
		$l_obj_template->replace(
			array(
				'caption' => __( 'Donate now', 'footnotes' ),
			)
		);
		// Display template with replaced placeholders.
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $l_obj_template->get_content();
		// phpcs:enable
	}
}
