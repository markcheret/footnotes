<?php
/**
 * Includes the core function of the Plugin - Search and Replace the Footnotes.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0
 *
 * Edited for v2.0.0 and following.
 *
 * Last modified:  2021-01-03T2056+0100
 *
 * @since 2.0.5  Autoload / infinite scroll support added thanks to code from @docteurfitness
 * @see <https://wordpress.org/support/topic/auto-load-post-compatibility-update/>
 *
 * @since 2.0.9  DISABLED the_post HOOK  2020-11-08T1839+0100
 *
 * @since 2.1.0  promote the 'Continue reading' button from localization to configuration  2020-11-08T2146+0100
 * @since 2.1.1  combining identical footnotes: fixed dead links, thanks to @happyches   2020-11-14T2233+0100
 * @see <https://wordpress.org/support/topic/custom-css-for-jumbled-references/>
 * @since 2.1.1  fix start pages by option to hide ref container, thanks to @dragon013
 * @see <https://wordpress.org/support/topic/possible-to-hide-it-from-start-page/>
 * @since 2.1.1  options fixing ref container layout and referrer vertical alignment  2020-11-16T2024+0100
 * @since 2.1.1  priority level option fixing ref container relative position, thanks to june01, @spaceling, @imeson  2020-11-17T0254+0100
 * @see <https://wordpress.org/support/topic/change-the-position-5/>
 * @since 2.1.2  priority level settings for all other hooks, thanks to @nikelaos  2020-11-19T1849+0100
 * @see <https://wordpress.org/support/topic/doesnt-work-any-more-11/#post-13676705>
 * @since 2.1.4  fix line wrapping of URLs based on pattern, not link element  2020-11-25T0837+0100
 * @since 2.1.4  fix issues with link elements by making them optional   2020-11-26T1051+0100
 * @since 2.1.4  support appending arrow when combining identicals is on   2020-11-26T1633+0100
 * @since 2.1.4  disable or select backlink separator and terminator  2020-11-28T1048+0100
 * @since 2.1.4  optional line breaks to stack enumerated backlinks  2020-11-28T1049+0100
 * @since 2.1.4  ref container column width and tooltip font size settings  2020-12-03T0954+0100
 * @since 2.1.4  scroll offset and duration settings  2020-12-05T0538+0100
 * @since 2.1.4  tooltip display duration settings  2020-12-06T1320+0100
 * @since 2.1.5  URL wrap: exclude image source too, thanks to @bjrnet21
 * @see <https://wordpress.org/support/topic/2-1-4-breaks-on-my-site-images-dont-show/>
 * @since 2.1.6  option to disable URL line wrapping   2020-12-09T1606+0100
 * @since 2.1.6  add catch-all exclusion to fix URL line wrapping, thanks to @a223123131   2020-12-09T1921+0100
 * @see <https://wordpress.org/support/topic/broken-layout-starting-version-2-1-4/>
 * @since 2.2.0  support for custom position shortcode for reference container, thanks to @hamshe  2020-12-13T2058+0100
 * @see <https://wordpress.org/support/topic/reference-container-in-elementor/>
 * @since 2.2.3  custom CSS from new setting in header after legacy  2020-12-15T1128+0100
 * @since 2.2.5  connected alternative tooltips to position and timing settings  2020-12-18T1113+0100
 * @since 2.2.5  delete unused position shortcode when ref container in widget or footer, thanks to @hamshe   2020-12-18T1437+0100
 * @see <https://wordpress.org/support/topic/reference-container-in-elementor/#post-13784126>
 * @since 2.2.5  options for label element and label bottom border, thanks to @markhillyer   2020-12-18T1447+0100
 * @see <https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/>
 * @since 2.2.6  URL wrap: make the quotation mark optional in the exclusion regex, thanks to @spiralofhope2   2020-12-23T0409+0100
 * @see <https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/>
 * @since 2.2.7  revert that change in the exclusion regex, thanks to @rjl20, @spaceling, @friedrichnorth, @bernardzit   2020-12-23T1046+0100
 * @see <https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/>
 * @see <https://wordpress.org/support/topic/footnotes-dont-show-after-update-to-2-2-6/>
 * @since 2.2.8  URL wrap: correct lookbehind by duplicating it with and without quotation mark class  2020-12-23T1108+0100
 * @since 2.2.9  URL wrap: account for RFC 2396 allowed characters in parameter names  2020-12-24T1956+0100
 * @see <https://stackoverflow.com/questions/814700/http-url-allowed-characters-in-parameter-names>
 * @since 2.2.9  Reference containers, widget_text hook: support for multiple containers in a page, thanks to @justbecuz   2020-12-25T0338+0100
 * @see <https://wordpress.org/support/topic/reset-footnotes-to-1/#post-13662830>
 * @since 2.2.9  URL wrap: exclude URLs also where the equals sign is preceded by an entity or character reference  2020-12-25T1251+0100
 * @since 2.2.10 URL wrap: support also file transfer protocol URLs  2020-12-25T2220+0100
 * @since 2.2.10 Reference container: add option for table borders to revert 2.0.0/2.0.1 change made on user request, thanks to @noobishh  2020-12-25T2304+0100
 * @see <https://wordpress.org/support/topic/borders-25/>
 * @since 2.3.0  Reference container: convert top padding to margin and make it a setting, thanks to @hamshe
 * @see <https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635>
 * @since 2.3.0  optional hard links in referrers and backlinks for AMP compatibility, thanks to @psykonevro and @martinneumannat
 * @see <https://wordpress.org/support/topic/making-it-amp-compatible/>
 * @see <https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/>
 * @since 2.3.0  swap Custom CSS migration Boolean from 'migration complete' to 'show legacy'  2020-12-27T1243+0100
 * @since 2.4.0  syntax validation for balanced footnote start and end tags  2021-01-01T0227+0100
 * @since 2.4.0  scroll offset to a safety default value 34 right in the properties section  2021-01-03T2056+0100
 */

// If called directly, abort:
defined( 'ABSPATH' ) or die;

/**
 * Looks for Footnotes short codes and replaces them. Also displays the Reference Container.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes_Task {

    /**
     *        PROPERTIES
     */

    /**
     * Contains all footnotes found on current public page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @var array
     */
    public static $a_arr_Footnotes = array();

    /**
     * Flag if the display of 'LOVE FOOTNOTES' is allowed on the current public page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @var bool
     */
    public static $a_bool_AllowLoveMe = true;

    /**
     * Prefix for the Footnote html element ID.
     *
     * @author Stefan Herndler
     * @since 1.5.8
     * @var string
     */
    public static $a_str_Prefix = "";

    /**
     * INFINITE SCROLL / AUTOLOAD, ARCHIVE VIEW
     *
     * Multiple posts are appended to each other, functions and note IDs must be disambiguated.
     *
     * Contribution thankfully received from @docteurfitness
     * @see <https://wordpress.org/support/topic/auto-load-post-compatibility-update/>
     * @since 2.0.5
     * @var int
     *
     * post ID to make everything unique wrt infinite scroll and archive view:
     * (will be filled in by the next possible occasion; PHP seems to prohibit doing so here)
     */
    public static $l_int_PostId = '';

    /**
     * Reference container ID
     *
     * This ID disambiguates multiple reference containers in a page
     * as they may occur when the widget_text hook is active and the page
     * is built with Elementor and has an accordion or similar toggle sections.
     *
     * Is incremented each time after a reference container is inserted.
     *
     * Thanks to @justbecuz
     * @see <https://wordpress.org/support/topic/reset-footnotes-to-1/#post-13662830>
     * @since 2.2.9
     * @var int
     */
    public static $l_int_ReferenceContainerId = 1;

    /**
     * Hard links for AMP
     *
     * Optional hard links in referrers and backlinks for AMP compatibility
     *
     * Thanks to @psykonevro and @martinneumannat
     * @see <https://wordpress.org/support/topic/making-it-amp-compatible/>
     * @see <https://wordpress.org/support/topic/footnotes-is-not-amp-compatible/>
     * @since 2.3.0
     * @var bool|str|int
	 * 
	 * @since 2.4.0  scroll offset to a safety default value 34 right here  2021-01-03T2055+0100
	 *               Some websites are using really high fixed headers not contracting at scroll.
     */
    public static $l_bool_HardLinksEnable        = false;
    public static $l_str_ReferrerLinkSlug        = 'r';
    public static $l_str_FootnoteLinkSlug        = 'f';
    public static $l_str_LinkIdsSeparator        = '+';
    public static $l_str_PostContainerIdCompound = '';
    // scroll offset may now need to get into inline CSS; default:
    public static $l_int_ScrollOffset            = 34;

    /**
     * OPTIONAL LINK ELEMENT FOR FOOTNOTE REFERRERS AND BACKLINKS
     *
     * STYLING:
     * Link color is preferred for referrers and backlinks.
     * Setting a global link color is a common feature in WordPress themes.
     * CSS does not support identifiers for link colors (color: link | hover | active | visited)
     * These are only supported as pseudo-classes of the link element.
     * Hence the link element must be present for styling purposes.
     * But styling these elements with the link color is not universally preferred.
     * If not, the very presence of the link elements may need to be avoided.
     *
     * FUNCTIONALITY:
     * Although widely used for that purpose, hyperlinks are disliked for footnote linking.
     * Browsers may need to be prevented from logging these clicks in the browsing history,
     * as logging compromises the usability of the 'return to previous' button in browsers.
     * For that purpose, and for scroll animation, this linking is performed by JavaScript.
     *
     * Link elements also raise further concerns, so that their useless proliferation needs
     * to be mitigated. By contrast, due to an insufficiency in the CSS standard, real link
     * elements are required to get the link color, as opposed to named colors on the basis
     * of the already supported pseudo-classes :link, :hover, :active and :visited that can
     * still not be used in color names.
     *
     * @since 2.0.0  added the link elements with hard links
     * @since 2.0.4  removed the hard links on user request
     * @see <https://wordpress.org/support/topic/hyperlinked-footnotes-creating-excessive-back-history/>
     * @since 2.1.4  made link elements optional for styling purposes, 2020-11-25T1306+0100
     * @since 2.3.0  this variable keeps its default value if hard links are enabled   2020-12-30T2313+0100
     *
     * @var str
     */
    public static $l_str_LinkSpan = 'span';
    public static $l_str_LinkOpenTag = '';
    public static $l_str_LinkCloseTag = '';

    /**
     * SYNTAX VALIDATION
     *
     * This part of the algorithm first checks for balanced footnote opening and closing tag
     * short codes. The first encountered error triggers the display of a warning below the
     * post title and cancellation of further parsing.
     *
     * Unbalanced short codes have caused significant trouble because they are hard to detect.
     * Any compiler or other tool reports syntax errors in the first place. Footnotes’ exception
     * is considered a design flaw, and the feature is released as a bug fix after overdue 2.3.0
     * released in urgency to provide AMP compat before 2021.
     *
     * @since 2.4.0
     * @var bool
     */
    public static $l_bool_SyntaxErrorFlag = true;



    /**
     *        METHODS
     */

    /**
     * Register WordPress Hooks to replace Footnotes in the content of a public page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited for:
     * @since 2.0.5 through v2.0.7  changes to priority  2020-11-02T0330+0100..2020-11-06T1344+0100
     * @since 2.1.1 add setting for the_content
     * @since 2.1.2 add settings for 4 other hooks  2020-11-19T1248+0100
     *
     * Setting the_content priority to "10" instead of PHP_INT_MAX i.e. 9223372036854775807
     * makes the footnotes reference container display beneath the post and above other
     * features added by other plugins, e.g. related post lists and social buttons.
     * For YARPP to display related posts below the Footnotes reference container,
     * priority needs to be at least 1200.
     * Requested by users: <https://wordpress.org/support/topic/change-the-position-5/>
     * Documentation: <https://codex.wordpress.org/Plugin_API/#Hook_in_your_Filter>
     *
     * Default remains PHP_INT_MAX.
     * PHP_INT_MAX cannot be reset by leaving the number box empty. because browsers
     * (WebKit) don’t allow it, so we must resort to -1.
     */
    public function registerHooks() {

        // get values from settings:
        $p_int_TheTitlePriority    = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_TITLE_PRIORITY_LEVEL));
        $p_int_TheContentPriority  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_CONTENT_PRIORITY_LEVEL));
        $p_int_TheExcerptPriority  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_THE_EXCERPT_PRIORITY_LEVEL));
        $p_int_WidgetTitlePriority = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TITLE_PRIORITY_LEVEL));
        $p_int_WidgetTextPriority  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_EXPERT_LOOKUP_WIDGET_TEXT_PRIORITY_LEVEL));

        // PHP_INT_MAX can be set by -1:
        $p_int_TheTitlePriority    = ($p_int_TheTitlePriority    == -1) ? PHP_INT_MAX : $p_int_TheTitlePriority   ;
        $p_int_TheContentPriority  = ($p_int_TheContentPriority  == -1) ? PHP_INT_MAX : $p_int_TheContentPriority ;
        $p_int_TheExcerptPriority  = ($p_int_TheExcerptPriority  == -1) ? PHP_INT_MAX : $p_int_TheExcerptPriority ;
        $p_int_WidgetTitlePriority = ($p_int_WidgetTitlePriority == -1) ? PHP_INT_MAX : $p_int_WidgetTitlePriority;
        $p_int_WidgetTextPriority  = ($p_int_WidgetTextPriority  == -1) ? PHP_INT_MAX : $p_int_WidgetTextPriority ;


        // append custom css to the header
        add_filter('wp_head', array($this, "wp_head"), PHP_INT_MAX);

        // append the love and share me slug to the footer
        add_filter('wp_footer', array($this, "wp_footer"), PHP_INT_MAX);

        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_TITLE))) {
            add_filter('the_title', array($this, "the_title"), $p_int_TheTitlePriority);
        }

        // custom priority level for reference container relative positioning; default 98:
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_CONTENT))) {
            add_filter('the_content', array($this, "the_content"), $p_int_TheContentPriority);
        }

        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_THE_EXCERPT))) {
             add_filter('the_excerpt', array($this, "the_excerpt"), $p_int_TheExcerptPriority);
        }
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TITLE))) {
            add_filter('widget_title', array($this, "widget_title"), $p_int_WidgetTitlePriority);
        }
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_EXPERT_LOOKUP_WIDGET_TEXT))) {
            add_filter('widget_text', array($this, "widget_text"), $p_int_WidgetTextPriority);
        }


        // REMOVED the_post HOOK  2020-11-08T1839+0100
        //
        //


        // reset stored footnotes when displaying the header
        self::$a_arr_Footnotes = array();
        self::$a_bool_AllowLoveMe = true;
    }

    /**
     * Outputs the custom css to the header of the public page.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited:
     * @since 2.1.1  option to hide ref container from start page
     * @since 2.1.1  script for alternative tooltips
     * @since 2.1.3  raise settings priority to override theme style sheets
     * @since 2.1.4  tootip font size and backlink column width settings
     * @since 2.2.5  options for label element and label bottom border, thanks to @markhillyer   2020-12-18T1447+0100
     * @see <https://wordpress.org/support/topic/how-do-i-eliminate-the-horizontal-line-beneath-the-reference-container-heading/>
     * @since 2.3.0  Reference container: convert top padding to margin and make it a setting, thanks to @hamshe
     * @see <https://wordpress.org/support/topic/reference-container-in-elementor/#post-13786635>
     */
    public function wp_head() {

        // insert start tag without switching out of PHP:
        echo "\r\n<style type=\"text/css\" media=\"all\">\r\n";

        // display ref container on home page:
        if (!MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_START_PAGE_ENABLE))) {
            echo ".home .footnotes_reference_container { display: none; }\r\n";
        }

        // ref container top and bottom margins:
        $l_int_ReferenceContainerTopMargin = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_TOP_MARGIN));
        $l_int_ReferenceContainerBottomMargin = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_REFERENCE_CONTAINER_BOTTOM_MARGIN));
        echo ".footnotes_reference_container {margin-top: ";
        echo empty($l_int_ReferenceContainerTopMargin) ? '0' : $l_int_ReferenceContainerTopMargin;
        echo "px !important; margin-bottom: ";
        echo empty($l_int_ReferenceContainerBottomMargin) ? '0' : $l_int_ReferenceContainerBottomMargin;
        echo "px !important;}\r\n";

        // ref container label bottom border:
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_LABEL_BOTTOM_BORDER))) {
            echo ".footnote_container_prepare > ";
            echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT);
            echo " {border-bottom: 1px solid #aaaaaa !important;}\r\n";
        }

        // ref container table row borders:
        if ( MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_ROW_BORDERS_ENABLE))) {
            echo ".footnotes_table, .footnotes_plugin_reference_row {";
            echo "border: 1px solid #060606;";
            echo " !important;}\r\n";
            // adapt left padding to the presence of a border:
            echo ".footnote_plugin_index, .footnote_plugin_index_combi {";
            echo "padding-left: 6px !important}\r\n";
        }

        // ref container first column width and max-width:
        $l_bool_ColumnWidthEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_WIDTH_ENABLED));
        $l_bool_ColumnMaxWidthEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_COLUMN_MAX_WIDTH_ENABLED));

        if ( $l_bool_ColumnWidthEnabled || $l_bool_ColumnMaxWidthEnabled ) {
            echo ".footnote-reference-container { table-layout: fixed; }";
            echo ".footnote_plugin_index, .footnote_plugin_index_combi {";

            if ( $l_bool_ColumnWidthEnabled ) {

                $l_int_ColumnWidthScalar = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_WIDTH_SCALAR);
                $l_str_ColumnWidthUnit = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_WIDTH_UNIT);

                if (!empty($l_int_ColumnWidthScalar)) {
                    if ($l_str_ColumnWidthUnit == '%') {
                        if ($l_int_ColumnWidthScalar > 100) {
                            $l_int_ColumnWidthScalar = 100;
                        }
                    }
                } else {
                    $l_int_ColumnWidthScalar = 0;
                }

                echo " width: $l_int_ColumnWidthScalar$l_str_ColumnWidthUnit !important;";
            }

            if ( $l_bool_ColumnMaxWidthEnabled ) {

                $l_int_ColumnMaxWidthScalar = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_BACKLINKS_COLUMN_MAX_WIDTH_SCALAR);
                $l_str_ColumnMaxWidthUnit = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_COLUMN_MAX_WIDTH_UNIT);

                if (!empty($l_int_ColumnMaxWidthScalar)) {
                    if ($l_str_ColumnMaxWidthUnit == '%') {
                        if ($l_int_ColumnMaxWidthScalar > 100) {
                            $l_int_ColumnMaxWidthScalar = 100;
                        }
                    }
                } else {
                    $l_int_ColumnMaxWidthScalar = 0;
                }

                echo " max-width: $l_int_ColumnMaxWidthScalar$l_str_ColumnMaxWidthUnit !important;";

            }
        echo "}\r\n";
        }

        // hard links scroll offset:
        self::$l_bool_HardLinksEnable = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_HARD_LINKS_ENABLE));
        self::$l_int_ScrollOffset = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_OFFSET));
        if (self::$l_bool_HardLinksEnable) {
            echo ".footnote_referrer_anchor, .footnote_item_anchor {bottom: ";
            echo self::$l_int_ScrollOffset;
            echo "vh;}\r\n";
        }

        // tooltips:
        $l_bool_TooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED));
        $l_bool_AlternativeTooltipsEnabled = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE));

        if ($l_bool_TooltipsEnabled) {

            echo '.footnote_tooltip {';

            // tooltip appearance:

            // font size:
            echo ' font-size: ';
            if(MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_MOUSE_OVER_BOX_FONT_SIZE_ENABLED))) {
                echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_FLO_MOUSE_OVER_BOX_FONT_SIZE_SCALAR);
                echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_MOUSE_OVER_BOX_FONT_SIZE_UNIT);
            } else {
                echo 'inherit';
            }
            echo ' !important;';

            // text color:
            $l_str_Color = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_COLOR);
            if (!empty($l_str_Color)) {
                printf(" color: %s !important;", $l_str_Color);
            }

            // background color:
            $l_str_Background = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BACKGROUND);
            if (!empty($l_str_Background)) {
                printf(" background-color: %s !important;", $l_str_Background);
            }

            // border width:
            $l_int_BorderWidth = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_WIDTH);
            if (!empty($l_int_BorderWidth) && intval($l_int_BorderWidth) > 0) {
                printf(" border-width: %dpx !important; border-style: solid !important;", $l_int_BorderWidth);
            }

            // border color:
            $l_str_BorderColor = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_BORDER_COLOR);
            if (!empty($l_str_BorderColor)) {
                printf(" border-color: %s !important;", $l_str_BorderColor);
            }

            // corner radius:
            $l_int_BorderRadius = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_BORDER_RADIUS);
            if (!empty($l_int_BorderRadius) && intval($l_int_BorderRadius) > 0) {
                printf(" border-radius: %dpx !important;", $l_int_BorderRadius);
            }

            // shadow color:
            $l_str_BoxShadowColor = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_SHADOW_COLOR);
            if (!empty($l_str_BoxShadowColor)) {
                printf(" -webkit-box-shadow: 2px 2px 11px %s;", $l_str_BoxShadowColor);
                printf(" -moz-box-shadow: 2px 2px 11px %s;", $l_str_BoxShadowColor);
                printf(" box-shadow: 2px 2px 11px %s;", $l_str_BoxShadowColor);
            }

            // alternative tooltips:
            if ( ! $l_bool_AlternativeTooltipsEnabled) {

                // tooltip position:
                $l_int_MaxWidth = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_MAX_WIDTH);
                if (!empty($l_int_MaxWidth) && intval($l_int_MaxWidth) > 0) {
                    printf(" max-width: %dpx !important;", $l_int_MaxWidth);
                }
                echo "}\r\n";

            } else {
                echo "}\r\n";

                // position:
                echo ".footnote_tooltip.position {";
                echo " width: " . intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_WIDTH)) . 'px;';

                $l_str_AlternativePosition = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_POSITION);
                $l_int_OffsetX = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_X));

                if ($l_str_AlternativePosition == 'top left' || $l_str_AlternativePosition == 'bottom left') {
                    echo ' right: ' . ( !empty($l_int_OffsetX) ? $l_int_OffsetX : 0) . 'px;';
                } else {
                    echo ' left: ' . ( !empty($l_int_OffsetX) ? $l_int_OffsetX : 0) . 'px;';
                }

                $l_int_OffsetY = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_ALTERNATIVE_MOUSE_OVER_BOX_OFFSET_Y));

                if ($l_str_AlternativePosition == 'top left' || $l_str_AlternativePosition == 'top right') {
                    echo ' bottom: ' . ( !empty($l_int_OffsetY) ? $l_int_OffsetY : 0) . 'px;';
                } else {
                    echo ' top: ' . ( !empty($l_int_OffsetY) ? $l_int_OffsetY : 0) . 'px;';
                }
                echo "}\r\n";

                // timing:
                // jQuery tooltip timing is in templates/public/tooltip.html, filled in after line 690 below.
                echo ' .footnote_tooltip.shown {';
                $l_int_FadeInDelay     = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY    ));
                $l_int_FadeInDuration  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ));
                $l_int_FadeInDelay     = !empty($l_int_FadeInDelay    ) ? $l_int_FadeInDelay     : '0';
                $l_int_FadeInDuration  = !empty($l_int_FadeInDuration ) ? $l_int_FadeInDuration  : '0';
                echo " transition-delay: $l_int_FadeInDelay" . 'ms;';
                echo " transition-duration: $l_int_FadeInDuration" . 'ms;';

                echo '} .footnote_tooltip.hidden {';
                $l_int_FadeOutDelay    = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY   ));
                $l_int_FadeOutDuration = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION));
                $l_int_FadeOutDelay     = !empty($l_int_FadeOutDelay    ) ? $l_int_FadeOutDelay     : '0';
                $l_int_FadeOutDuration  = !empty($l_int_FadeOutDuration ) ? $l_int_FadeOutDuration  : '0';
                echo " transition-delay: $l_int_FadeOutDelay" . 'ms;';
                echo " transition-duration: $l_int_FadeOutDuration" . 'ms;';

                echo "}\r\n";

            }
        }

        // set custom CSS to override settings, not conversely:
        // Legacy Custom CSS is used until it’s set to disappear after dashboard tab migration:
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_CUSTOM_CSS_LEGACY_ENABLE))) {
            echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS);
        }
        echo MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_CUSTOM_CSS_NEW);

        // insert end tag without switching out of PHP:
        echo "\r\n</style>\r\n";

        // alternative tooltip script printed formatted not minified:
        if ($l_bool_AlternativeTooltipsEnabled) {
            ?>
            <script content="text/javascript">
                function footnoteTooltipShow(footnoteTooltipId) {
                    document.getElementById(footnoteTooltipId).classList.remove('hidden');
                    document.getElementById(footnoteTooltipId).classList.add('shown');
                }
                function footnoteTooltipHide(footnoteTooltipId) {
                    document.getElementById(footnoteTooltipId).classList.remove('shown');
                    document.getElementById(footnoteTooltipId).classList.add('hidden');
                }
            </script>
            <?php
        };
    }

    /**
     * Displays the 'LOVE FOOTNOTES' slug if enabled.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     *
     * Edited:
     * @since 2.2.0  more options  2020-12-11T0506+0100
     */
    public function wp_footer() {
        if (MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "footer") {
            echo $this->ReferenceContainer();
        }
        // get setting for love and share this plugin
        $l_str_LoveMeIndex = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_LOVE);
        // check if the admin allows to add a link to the footer
        if (empty($l_str_LoveMeIndex) || strtolower($l_str_LoveMeIndex) == "no" || !self::$a_bool_AllowLoveMe) {
            return;
        }
        // set a hyperlink to the word "footnotes" in the Love slug
        $l_str_LinkedName = sprintf('<a href="https://wordpress.org/plugins/footnotes/" target="_blank" style="text-decoration:none;">%s</a>', MCI_Footnotes_Config::C_STR_PLUGIN_PUBLIC_NAME);
        // get random love me text
        if (strtolower($l_str_LoveMeIndex) == "random") {
            $l_str_LoveMeIndex = "text-" . rand(1,7);
        }
        switch ($l_str_LoveMeIndex) {
            // options named wrt backcompat, simplest is default:
            case "text-1": $l_str_LoveMeText = sprintf(__('I %2$s %1$s', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL); break;
            case "text-2": $l_str_LoveMeText = sprintf(__('This website uses the awesome %s plugin.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName); break;
            case "text-4": $l_str_LoveMeText = sprintf('%s %s', $l_str_LinkedName, MCI_Footnotes_Config::C_STR_LOVE_SYMBOL); break;
            case "text-5": $l_str_LoveMeText = sprintf('%s %s', MCI_Footnotes_Config::C_STR_LOVE_SYMBOL, $l_str_LinkedName); break;
            case "text-6": $l_str_LoveMeText = sprintf(__('This website uses %s.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName); break;
            case "text-7": $l_str_LoveMeText = sprintf(__('This website uses the %s plugin.', MCI_Footnotes_Config::C_STR_PLUGIN_NAME), $l_str_LinkedName); break;
            case "text-3": default: $l_str_LoveMeText = sprintf('%s', $l_str_LinkedName); break;
        }
        echo sprintf('<div style="text-align:center; color:#acacac;">%s</div>', $l_str_LoveMeText);
    }

    /**
     * Replaces footnotes in the post/page title.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_Content Widget content.
     * @return string Content with replaced footnotes.
     */
    public function the_title($p_str_Content) {
        // appends the reference container if set to "post_end"
        return $this->exec($p_str_Content, false);
    }

    /**
     * Replaces footnotes in the content of the current page/post.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_Content Page/Post content.
     * @return string Content with replaced footnotes.
     */
    public function the_content($p_str_Content) {
        // appends the reference container if set to "post_end"
        return $this->exec($p_str_Content, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "post_end" ? true : false);
    }

    /**
     * Replaces footnotes in the excerpt of the current page/post.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_Content Page/Post content.
     * @return string Content with replaced footnotes.
     */
    public function the_excerpt($p_str_Content) {
        return $this->exec($p_str_Content, false, !MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_IN_EXCERPT)));
    }

    /**
     * Replaces footnotes in the widget title.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_Content Widget content.
     * @return string Content with replaced footnotes.
     */
    public function widget_title($p_str_Content) {
        // appends the reference container if set to "post_end"
        return $this->exec($p_str_Content, false);
    }

    /**
     * Replaces footnotes in the content of the current widget.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_Content Widget content.
     * @return string Content with replaced footnotes.
     */
    public function widget_text($p_str_Content) {
        // appends the reference container if set to "post_end"
        return $this->exec($p_str_Content, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION) == "post_end" ? true : false);
    }

    /**
     * Replaces footnotes in each Content var of the current Post object.
     *
     * @author Stefan Herndler
     * @since 1.5.4
     * @param array|WP_Post $p_mixed_Posts
     */
    public function the_post(&$p_mixed_Posts) {
        // single WP_Post object received
        if (!is_array($p_mixed_Posts)) {
            $p_mixed_Posts = $this->replacePostObject($p_mixed_Posts);
            return;
        }
        // array of WP_Post objects received
        for($l_int_Index = 0; $l_int_Index < count($p_mixed_Posts); $l_int_Index++) {
            $p_mixed_Posts[$l_int_Index] = $this->replacePostObject($p_mixed_Posts[$l_int_Index]);
        }
    }

    /**
     * Replace all Footnotes in a WP_Post object.
     *
     * @author Stefan Herndler
     * @since 1.5.6
     * @param WP_Post $p_obj_Post
     * @return WP_Post
     */
    private function replacePostObject($p_obj_Post) {
        //MCI_Footnotes_Convert::debug($p_obj_Post);
        $p_obj_Post->post_content = $this->exec($p_obj_Post->post_content);
        $p_obj_Post->post_content_filtered = $this->exec($p_obj_Post->post_content_filtered);
        $p_obj_Post->post_excerpt = $this->exec($p_obj_Post->post_excerpt);
        return $p_obj_Post;
    }

    /**
     * Replaces all footnotes that occur in the given content.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_Content Any string that may contain footnotes to be replaced.
     * @param bool $p_bool_OutputReferences Appends the Reference Container to the output if set to true, default true.
     * @param bool $p_bool_HideFootnotesText Hide footnotes found in the string.
     * @return string
     *
     * Edited:
     * @since 2.2.0  insert reference container at shortcode, thanks to @hamshe   2020-12-13T2057+0100
     * @see <https://wordpress.org/support/topic/reference-container-in-elementor/>
     *
     * @since 2.2.5  delete unused position shortcode, when position is widget or footer, thanks to @hamshe   2020-12-18T1434+0100
     * @see <https://wordpress.org/support/topic/reference-container-in-elementor/#post-13784126>
     */
    public function exec($p_str_Content, $p_bool_OutputReferences = false, $p_bool_HideFootnotesText = false) {

        // replace all footnotes in the content, settings are converted to html characters
        $p_str_Content = $this->search($p_str_Content, true, $p_bool_HideFootnotesText);
        // replace all footnotes in the content, settings are NOT converted to html characters
        $p_str_Content = $this->search($p_str_Content, false, $p_bool_HideFootnotesText);

        // append the reference container or insert at shortcode:
        $l_str_ReferenceContainerPositionShortcode = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_POSITION_SHORTCODE);

        if ($p_bool_OutputReferences) {

            if (strpos( $p_str_Content, $l_str_ReferenceContainerPositionShortcode ) !== false ) {

                $p_str_Content = str_replace( $l_str_ReferenceContainerPositionShortcode, $this->ReferenceContainer(), $p_str_Content );

            } else {

                $p_str_Content .= $this->ReferenceContainer();

            }

            // increment the container ID:
            self::$l_int_ReferenceContainerId++;
        }

        // delete position shortcode should any remain e.g. when ref container is in footer, thanks to @hamshe:
        $p_str_Content = str_replace( $l_str_ReferenceContainerPositionShortcode, '', $p_str_Content );

        // take a look if the LOVE ME slug should NOT be displayed on this page/post, remove the short code if found
        if (strpos($p_str_Content, MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG) !== false) {
            self::$a_bool_AllowLoveMe = false;
            $p_str_Content = str_replace(MCI_Footnotes_Config::C_STR_NO_LOVE_SLUG, "", $p_str_Content);
        }
        // return the content with replaced footnotes and optional reference container appended:
        return $p_str_Content;
    }

    /**
     * Replaces all footnotes in the given content and appends them to the static property.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @param string $p_str_Content Content to be searched for footnotes.
     * @param bool $p_bool_ConvertHtmlChars html encode settings, default true.
     * @param bool $p_bool_HideFootnotesText Hide footnotes found in the string.
     * @return string
     *
     * Edited since 2.0.0
     * 
     * @since 2.4.0  footnote shortcode syntax validation
     */
    public function search($p_str_Content, $p_bool_ConvertHtmlChars, $p_bool_HideFootnotesText) {

        // post ID to make everything unique wrt infinite scroll and archive view
        self::$l_int_PostId = get_the_id();

        // contains the index for the next footnote on this page
        $l_int_FootnoteIndex = count(self::$a_arr_Footnotes) + 1;

        // contains the starting position for the lookup of a footnote
        $l_int_PosStart = 0;

        // get start and end tag for the footnotes short code
        $l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START);
        $l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END);
        if ($l_str_StartingTag == "userdefined" || $l_str_EndingTag == "userdefined") {
            $l_str_StartingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_START_USER_DEFINED);
            $l_str_EndingTag = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_SHORT_CODE_END_USER_DEFINED);
        }
        // decode html special chars
        if ($p_bool_ConvertHtmlChars) {
            $l_str_StartingTag = htmlspecialchars($l_str_StartingTag);
            $l_str_EndingTag = htmlspecialchars($l_str_EndingTag);
        }

        // if footnotes short code is empty, return the content without changes
        if (empty($l_str_StartingTag) || empty($l_str_EndingTag)) {
            return $p_str_Content;
        }

        // if footnotes short codes are unbalanced, and syntax validation is not disabled,
        // return content with prepended warning:
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_SHORTCODE_SYNTAX_VALIDATION_ENABLE))) {
            $l_str_StartTagRegex = preg_replace( '#([\(\)\{\}\[\]\*\.\?\!])#', '\\\\$1', $l_str_StartingTag );
            $l_str_EndTagRegex = preg_replace( '#([\(\)\{\}\[\]\*\.\?\!])#', '\\\\$1', $l_str_EndingTag );
            $l_str_ValidationRegex = '#' . $l_str_StartTagRegex . '(((?!' . $l_str_EndTagRegex . ').)*?)(' . $l_str_StartTagRegex . '|$)#s';
            preg_match( $l_str_ValidationRegex, $p_str_Content, $p_arr_ErrorLocation );
            if ( empty( $p_arr_ErrorLocation ) ) {
                self::$l_bool_SyntaxErrorFlag = false;
            }

            // prevent generating and inserting the warning multiple times:
            if ( self::$l_bool_SyntaxErrorFlag ) {
                $l_str_ErrorSpotString = strip_tags($p_arr_ErrorLocation[1]);

                $l_str_SyntaxErrorWarning  = '<div class="footnotes_validation_error"><p>';
                $l_str_SyntaxErrorWarning .= __("WARNING: unbalanced footnote start tag short code before:", MCI_Footnotes_Config::C_STR_PLUGIN_NAME);
                $l_str_SyntaxErrorWarning .= '</p><p>“';
                $l_str_SyntaxErrorWarning .= $l_str_ErrorSpotString;
                $l_str_SyntaxErrorWarning .= '”</p></div>';

                $p_str_Content = $l_str_SyntaxErrorWarning . $p_str_Content;
                self::$l_bool_SyntaxErrorFlag = false;

                return $p_str_Content;
            }
        }

        // load referrer templates if footnotes text not hidden:
        if (!$p_bool_HideFootnotesText) {
            // load two template files:
            if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE))) {
                $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "footnote-alternative");
            } else {
                $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "footnote");
            }
            $l_obj_TemplateTooltip = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "tooltip");
        } else {
            $l_obj_Template = null;
            $l_obj_TemplateTooltip = null;
        }

        // search footnotes short codes in the content
        do {
            // get first occurrence of the footnote start tag short code:
            $i_int_len_Content = strlen($p_str_Content);
            if ($l_int_PosStart > $i_int_len_Content) $l_int_PosStart = $i_int_len_Content;
            $l_int_PosStart = strpos($p_str_Content, $l_str_StartingTag, $l_int_PosStart);
            // no short code found, stop here
            if ($l_int_PosStart === false) {
                break;
            }
            // get first occurrence of the footnote end tag short code:
            $l_int_PosEnd = strpos($p_str_Content, $l_str_EndingTag, $l_int_PosStart);
            // no short code found, stop here
            if ($l_int_PosEnd === false) {
                break;
            }
            // calculate the length of the footnote
            $l_int_Length = $l_int_PosEnd - $l_int_PosStart;

            // get footnote text
            $l_str_FootnoteText = substr($p_str_Content, $l_int_PosStart + strlen($l_str_StartingTag), $l_int_Length - strlen($l_str_StartingTag));


            /**
             * URL line wrap
             *
             * Fix line wrapping of URLs (hyperlinked or not) based on pattern, not link element,
             * to prevent them from hanging out of the tooltip in non-Unicode-compliant user agents.
             * @see public.css
             *
             * spare however values of the href and the src arguments!
             * @since 2.1.5  exclude image source too, thanks to @bjrnet21
             * @see <https://wordpress.org/support/topic/2-1-4-breaks-on-my-site-images-dont-show/>
             *
             * Even ARIA labels may take a URL as value, so use \w=[\'"] as a catch-all    2020-12-10T1005+0100
             * @since 2.1.6  add catch-all exclusion to fix URL line wrapping, thanks to @a223123131   2020-12-09T1921+0100
             * @see <https://wordpress.org/support/topic/broken-layout-starting-version-2-1-4/>
             *
             * @since 2.1.6  option to disable URL line wrapping   2020-12-09T1606+0100
             *
             * URLs may be a query string in a URL:
             * @since 2.2.6  make the quotation mark optional in the exclusion regex, thanks to @spiralofhope2   2020-12-23T0409+0100
             * @see <https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/>
             * @since 2.2.7  revert that change in the exclusion regex, thanks to @rjl20, @spaceling, @friedrichnorth, @bernardzit   2020-12-23T1046+0100
             * @see <https://wordpress.org/support/topic/two-links-now-breaks-footnotes-with-blogtext/>
             * @see <https://wordpress.org/support/topic/footnotes-dont-show-after-update-to-2-2-6/>
             * @since 2.2.8  correct lookbehind by duplicating it with and without quotation mark class  2020-12-23T1107+0100
             *
             * @since 2.2.9  account for RFC 2396 allowed characters in parameter names  2020-12-24T1956+0100
             * @see <https://stackoverflow.com/questions/814700/http-url-allowed-characters-in-parameter-names>
             * @since 2.2.9  exclude URLs also where the equals sign is preceded by an entity or character reference  2020-12-25T1234+0100
             *
             * @since 2.2.10 support also file transfer protocol URLs  2020-12-25T2220+0100
             */
            if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTE_URL_WRAP_ENABLED))) {
                $l_str_FootnoteText = preg_replace( '#(?<![-\w\.!~\*\'\(\);]=[\'"])(?<![-\w\.!~\*\'\(\);]=)((ht|f)tps?://[^\\s<]+)#', '<span class="footnote_url_wrap">$1</span>', $l_str_FootnoteText );
            }

            // Text to be displayed instead of the footnote
            $l_str_FootnoteReplaceText = "";

            // whether hard links are enabled; relevant also below in ReferenceContainer():
            if (self::$l_bool_HardLinksEnable) {

                // get the configurable parts:
                self::$l_str_ReferrerLinkSlug = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERRER_FRAGMENT_ID_SLUG);
                self::$l_str_FootnoteLinkSlug = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTE_FRAGMENT_ID_SLUG);
                self::$l_str_LinkIdsSeparator = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HARD_LINK_IDS_SEPARATOR);

                // streamline ID concatenation:
                self::$l_str_PostContainerIdCompound  = self::$l_str_LinkIdsSeparator;
                self::$l_str_PostContainerIdCompound .= self::$l_int_PostId;
                self::$l_str_PostContainerIdCompound .= self::$l_str_LinkIdsSeparator;
                self::$l_str_PostContainerIdCompound .= self::$l_int_ReferenceContainerId;
                self::$l_str_PostContainerIdCompound .= self::$l_str_LinkIdsSeparator;

            }

            // display the footnote referrers and the tooltips:
            if (!$p_bool_HideFootnotesText) {
                $l_int_Index = MCI_Footnotes_Convert::Index($l_int_FootnoteIndex, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));

                // display only a truncated footnote text if option enabled:
                $l_str_ExcerptText = $l_str_FootnoteText;
                $l_bool_EnableExcerpt = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_ENABLED));
                $l_int_MaxLength = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_EXCERPT_LENGTH));

                if ($l_bool_EnableExcerpt) {
                    $l_str_DummyText = strip_tags($l_str_FootnoteText);
                    if (is_int($l_int_MaxLength) && strlen($l_str_DummyText) > $l_int_MaxLength) {
                        $l_str_ExcerptText  = substr($l_str_DummyText, 0, $l_int_MaxLength);
                        $l_str_ExcerptText  = substr($l_str_ExcerptText, 0, strrpos($l_str_ExcerptText, ' '));
                        $l_str_ExcerptText .= '&nbsp;&#x2026; <';
                        $l_str_ExcerptText .= self::$l_bool_HardLinksEnable ? 'a' : 'span';
                        $l_str_ExcerptText .= ' class="footnote_tooltip_continue" ';
                        $l_str_ExcerptText .= 'onclick="footnote_moveToAnchor_' . self::$l_int_PostId;
                        $l_str_ExcerptText .= '_' . self::$l_int_ReferenceContainerId;
                        $l_str_ExcerptText .= '(\'footnote_plugin_reference_' . self::$l_int_PostId;
                        $l_str_ExcerptText .= '_' . self::$l_int_ReferenceContainerId;
                        $l_str_ExcerptText .= "_$l_int_Index');\"";

                        // if enabled, add the hard link fragment ID:
                        if (self::$l_bool_HardLinksEnable) {

                            $l_str_ExcerptText .= ' href="#';
                            $l_str_ExcerptText .= self::$l_str_FootnoteLinkSlug;
                            $l_str_ExcerptText .= self::$l_str_PostContainerIdCompound;
                            $l_str_ExcerptText .= $l_int_Index;
                            $l_str_ExcerptText .= '"';
                        }

                        $l_str_ExcerptText .= '>';
                        $l_str_ExcerptText .= MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_TOOLTIP_READON_LABEL);
                        $l_str_ExcerptText .= self::$l_bool_HardLinksEnable ? '</a>' : '</span>';
                    }
                }

                // define the HTML element to use for the referrers:
                if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_REFERRER_SUPERSCRIPT_TAGS))) {

                    $l_str_SupSpan = 'sup';

                } else {

                    $l_str_SupSpan = 'span';
                }

                // whether hard links are enabled; relevant also below in ReferenceContainer():
                if (self::$l_bool_HardLinksEnable) {

                    self::$l_str_LinkSpan = 'a';
                    self::$l_str_LinkCloseTag = '</a>';
                    // self::$l_str_LinkOpenTag will be defined as needed

                    // compose hyperlink address (leading space is in template):
                    $l_str_FootnoteLinkArgument  = 'href="#';
                    $l_str_FootnoteLinkArgument .= self::$l_str_FootnoteLinkSlug;
                    $l_str_FootnoteLinkArgument .= self::$l_str_PostContainerIdCompound;
                    $l_str_FootnoteLinkArgument .= $l_int_Index;
                    $l_str_FootnoteLinkArgument .= '" class="footnote_hard_link"';

                    // compose offset anchor, an empty span child of empty span
                    // to prevent browsers from drawing tall dotted rectangles:
                    $l_str_ReferrerAnchorElement  = '<span class="footnote_referrer_base"><span id="';
                    $l_str_ReferrerAnchorElement .= self::$l_str_ReferrerLinkSlug;
                    $l_str_ReferrerAnchorElement .= self::$l_str_PostContainerIdCompound;
                    $l_str_ReferrerAnchorElement .= $l_int_Index;
                    $l_str_ReferrerAnchorElement .= '" class="footnote_referrer_anchor"></span></span>';

                } else {

                    // no hyperlink nor offset anchor needed:
                    $l_str_FootnoteLinkArgument = '';
                    $l_str_ReferrerAnchorElement = '';

                    // whether the link element is used nevertheless for styling:
                    if ( MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_LINK_ELEMENT_ENABLED)) ) {

                        self::$l_str_LinkSpan = 'a';
                        self::$l_str_LinkOpenTag = '<a>';
                        self::$l_str_LinkCloseTag = '</a>';

                    }
                }

                // fill in 'templates/public/footnote.html':
                $l_obj_Template->replace(
                    array(
                        "link-span"      => self::$l_str_LinkSpan,
                        "post_id"        => self::$l_int_PostId,
                        "container_id"   => self::$l_int_ReferenceContainerId,
                        "note_id"        => $l_int_Index,
                        "hard-link"      => $l_str_FootnoteLinkArgument,
                        "sup-span"       => $l_str_SupSpan,
                        "before"         => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_BEFORE),
                        "index"          => $l_int_Index,
                        "after"          => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_STYLING_AFTER),
                        "anchor-element" => $l_str_ReferrerAnchorElement,
                        "text"           => MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED)) ? $l_str_ExcerptText : "",
                    )
                );
                $l_str_FootnoteReplaceText = $l_obj_Template->getContent();

                // reset the template
                $l_obj_Template->reload();

                if (
                    // standard tooltip is enabled:
                    MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ENABLED)) &&
                    !MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_FOOTNOTES_MOUSE_OVER_BOX_ALTERNATIVE))
                ) {
                    $l_int_OffsetY         = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_Y));
                    $l_int_OffsetX         = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_MOUSE_OVER_BOX_OFFSET_X));
                    $l_int_FadeInDelay     = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DELAY    ));
                    $l_int_FadeInDuration  = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_IN_DURATION ));
                    $l_int_FadeOutDelay    = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DELAY   ));
                    $l_int_FadeOutDuration = intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_MOUSE_OVER_BOX_FADE_OUT_DURATION));

                    // fill in 'templates/public/tooltip.html':
                    $l_obj_TemplateTooltip->replace(
                        array(
                            "post_id"           => self::$l_int_PostId,
                            "container_id"      => self::$l_int_ReferenceContainerId,
                            "note_id"           => $l_int_Index,
                            "position"          => MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_MOUSE_OVER_BOX_POSITION),
                            "offset-y"          => !empty($l_int_OffsetY) ? $l_int_OffsetY : 0,
                            "offset-x"          => !empty($l_int_OffsetX) ? $l_int_OffsetX : 0,
                            "fade-in-delay"     => !empty($l_int_FadeInDelay    ) ? $l_int_FadeInDelay     : 0,
                            "fade-in-duration"  => !empty($l_int_FadeInDuration ) ? $l_int_FadeInDuration  : 0,
                            "fade-out-delay"    => !empty($l_int_FadeOutDelay   ) ? $l_int_FadeOutDelay    : 0,
                            "fade-out-duration" => !empty($l_int_FadeOutDuration) ? $l_int_FadeOutDuration : 0,
                        )
                    );
                    $l_str_FootnoteReplaceText .= $l_obj_TemplateTooltip->getContent();
                    $l_obj_TemplateTooltip->reload();
                }
            }
            // replace the footnote with the template
            $p_str_Content = substr_replace($p_str_Content, $l_str_FootnoteReplaceText, $l_int_PosStart, $l_int_Length + strlen($l_str_EndingTag));

            // add footnote only if not empty
            if (!empty($l_str_FootnoteText)) {
                // set footnote to the output box at the end
                self::$a_arr_Footnotes[] = $l_str_FootnoteText;
                // increase footnote index
                $l_int_FootnoteIndex++;
            }
            // add offset to the new starting position
            $l_int_PosStart += $l_int_Length + strlen($l_str_EndingTag);
            $l_int_PosStart = $l_int_Length + strlen($l_str_FootnoteReplaceText);
        } while (true);

        // return content
        return $p_str_Content;
    }

    /**
     * Generates the reference container.
     *
     * @author Stefan Herndler
     * @since 1.5.0
     * @return string
     *
     * Edited for 2.0.6: fixed line breaking behavior in footnote # clusters
     * Edited for 2.1.1: fixed fragment IDs and backlinks with combine identical turned on   2020-11-14T1808+0100
     */
    public function ReferenceContainer() {

        // no footnotes have been replaced on this page:
        if (empty(self::$a_arr_Footnotes)) {
            return "";
        }


        /**
         * FOOTNOTE INDEX BACKLINK SYMBOL
         *
         * @since 2.0.0  removed backlink symbol along with column 2 of the reference container
         * @since 2.0.3  prepended an arrow on user request
         * @since 2.0.4  restored the arrow select & symbol input setting
         * @since 2.1.1  made the symbol optional instead of configuring it to invisible
         */
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_ENABLE))) {

            // get html arrow
            $l_str_Arrow = MCI_Footnotes_Convert::getArrow(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW));
            // set html arrow to the first one if invalid index defined
            if (is_array($l_str_Arrow)) {
                $l_str_Arrow = MCI_Footnotes_Convert::getArrow(0);
            }
            // get user defined arrow
            $l_str_ArrowUserDefined = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_HYPERLINK_ARROW_USER_DEFINED);
            if (!empty($l_str_ArrowUserDefined)) {
                $l_str_Arrow = $l_str_ArrowUserDefined;
            }

            // wrap the arrow in a @media print { display:hidden } span:
            $l_str_FootnoteArrow  = '<span class="footnote_index_arrow">';
            $l_str_FootnoteArrow .= $l_str_Arrow . '</span>';

        } else {

            // if it is not, set arrow to empty:
            $l_str_Arrow = '';
            $l_str_FootnoteArrow = '';

        }


        /**
         * BACKLINK SEPARATOR
         *
         * Initially a comma was appended in this algorithm for enumerations.
         * The comma in enumerations is not generally preferred.
         * @since 2.1.4 the separator is optional, has options, and is configurable:
         */

        // check if it is even enabled:
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_SEPARATOR_ENABLED))) {

            // if so, check if it is freely configured:
            $l_str_Separator = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_CUSTOM);

            if (empty($l_str_Separator)) {

                // if it is not, check which option is on:
                $l_str_SeparatorOption = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_SEPARATOR_OPTION);
                switch ($l_str_SeparatorOption) {
                    case 'comma'    : $l_str_Separator = ',';              break;
                    case 'semicolon': $l_str_Separator = ';';              break;
                    case 'en_dash'  : $l_str_Separator = '&nbsp;&#x2013;'; break;
                }
            }

        } else {

            $l_str_Separator = '';
        }

        /**
         * BACKLINK TERMINATOR
         *
         * Initially a dot was appended in the table row template.
         * @since 2.0.6 a dot after footnote numbers is discarded as not localizable;
         * making it optional was envisaged.
         * @since 2.1.4 the terminator is optional, has options, and is configurable:
         */

        // check if it is even enabled:
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_TERMINATOR_ENABLED))) {

            // if so, check if it is input-configured:
            $l_str_Terminator = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_CUSTOM);

            if (empty($l_str_Terminator)) {

                // if it is not, check which option is on:
                $l_str_TerminatorOption = MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_BACKLINKS_TERMINATOR_OPTION);
                switch ($l_str_TerminatorOption) {
                    case 'period'     : $l_str_Terminator = '.'; break;
                    case 'parenthesis': $l_str_Terminator = ')'; break;
                    case 'colon'      : $l_str_Terminator = ':'; break;
                }
            }

        } else {

            $l_str_Terminator = '';
        }


        /**
         * LINE BREAKS
         *
         * The backlinks of combined footnotes are generally preferred in an enumeration.
         * But when few footnotes are identical, stacking the items in list form is better.
         * Variable number length and proportional character width require explicit line breaks.
         * Otherwise, an ordinary space character offering a line break opportunity is inserted.
         */
        $l_str_LineBreak = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_BACKLINKS_LINE_BREAKS_ENABLED)) ? '<br />' : ' ';

        /**
         * For maintenance and support, table rows in the reference container should be
         * separated by an empty line. So we add these line breaks for source readability.
         * Before the first table row (breaks between rows are ~200 lines below):
         */
        $l_str_Body = "\r\n\r\n";


        // REFERENCE CONTAINER TABLE ROW TEMPLATE LOAD

        // when combining identical footnotes is turned on, another template is needed:
        if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES))) {
            // the combining template allows for backlink clusters and supports cell clicking for single notes:
            $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body-combi");

        } else {

            // when 3-column layout is turned on (only available if combining is turned off):
            if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_3COLUMN_LAYOUT_ENABLE))) {
                $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body-3column");

            } else {

                // when switch symbol and index is turned on, and combining and 3-columns are off:
                if (MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH))) {
                    $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body-switch");

                } else {

                    // default is the standard template:
                    $l_obj_Template = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container-body");

                }
            }
        }

        // whether to switch backlink symbol and footnote number:
        $l_bool_SymbolSwitch = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_BACKLINK_SYMBOL_SWITCH));

        // FILL IN THE TEMPLATE

        // loop through all footnotes found in the page
        for ($l_int_Index = 0; $l_int_Index < count(self::$a_arr_Footnotes); $l_int_Index++) {

            // TEXT COLUMN

            // get footnote text
            $l_str_FootnoteText = self::$a_arr_Footnotes[$l_int_Index];
            // if footnote is empty, get to the next one
            // With combine identical turned on, identicals will be deleted and are skipped:
            if (empty($l_str_FootnoteText)) {
                continue;
            }

            // generate content of footnote index cell
            $l_int_FirstFootnoteIndex = ($l_int_Index + 1);

            // get the footnote index string and
            // keep supporting legacy index placeholder:
            $l_str_FootnoteId  = MCI_Footnotes_Convert::Index(($l_int_Index + 1),  MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));


            // INDEX COLUMN WITH ONE BACKLINK PER TABLE ROW

            // if enabled, and for the case the footnote is single, compose hard link:
            if (self::$l_bool_HardLinksEnable) {

                // compose fragment ID anchor with offset, for use in reference container, an
                // empty span child of empty span to avoid tall dotted rectangles in browser:
                $l_str_FootnoteAnchorElement  = '<span class="footnote_item_base"><span id="';
                $l_str_FootnoteAnchorElement .= self::$l_str_FootnoteLinkSlug;
                $l_str_FootnoteAnchorElement .= self::$l_str_PostContainerIdCompound;
                $l_str_FootnoteAnchorElement .= $l_str_FootnoteId;
                $l_str_FootnoteAnchorElement .= '" class="footnote_item_anchor"></span></span>';

                // compose optional hard link address:
                $l_str_HardLinkAddress  = ' href="#';
                $l_str_HardLinkAddress .= self::$l_str_ReferrerLinkSlug;
                $l_str_HardLinkAddress .= self::$l_str_PostContainerIdCompound;
                $l_str_HardLinkAddress .= $l_str_FootnoteId . '"';

                // compose optional opening link tag with optional hard link, mandatory for instance:
                self::$l_str_LinkOpenTag  = '<a' . $l_str_HardLinkAddress;
                self::$l_str_LinkOpenTag  = ' class="footnote_hard_back_link">';

            } else {
                // define as empty, too:
                $l_str_FootnoteAnchorElement = '';
            }


            // SUPPORT FOR COMBINING IDENTICALS: COMPOSE ENUMERATED BACKLINKS

            // Prepare to have single footnotes, where the click event and
            // optional hard link need to be set to cover the table cell,
            // for better usability and UX.

            // set a flag to check for the combined status of a footnote item:
            $l_bool_FlagCombined = false;

            // set otherwise unused variables as empty to avoid screwing up the placeholder array:
            $l_str_BacklinkEvent     = '';
            $l_str_FootnoteBacklinks = '';
            $l_str_FootnoteReference = '';

            if ( MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_COMBINE_IDENTICAL_FOOTNOTES))) {

                // ID, optional hard link address, and class:
                $l_str_FootnoteReference  = '<' . self::$l_str_LinkSpan;
                $l_str_FootnoteReference .= ' id="footnote_plugin_reference_';
                $l_str_FootnoteReference .= self::$l_int_PostId;
                $l_str_FootnoteReference .= '_' . self::$l_int_ReferenceContainerId;
                $l_str_FootnoteReference .= "_$l_str_FootnoteId\"";
                if (self::$l_bool_HardLinksEnable) {
                    $l_str_FootnoteReference .= ' href="#';
                    $l_str_FootnoteReference .= self::$l_str_ReferrerLinkSlug;
                    $l_str_FootnoteReference .= self::$l_str_PostContainerIdCompound;
                    $l_str_FootnoteReference .= $l_str_FootnoteId . '"';
                }
                $l_str_FootnoteReference .= ' class="footnote_backlink"';

                // the click event goes in the table cell if footnote remains single:
                $l_str_BacklinkEvent  = ' onclick="footnote_moveToAnchor_';
                $l_str_BacklinkEvent .= self::$l_int_PostId;
                $l_str_BacklinkEvent .= '_' . self::$l_int_ReferenceContainerId;
                $l_str_BacklinkEvent .= "('footnote_plugin_tooltip_";
                $l_str_BacklinkEvent .= self::$l_int_PostId;
                $l_str_BacklinkEvent .= '_' . self::$l_int_ReferenceContainerId;
                $l_str_BacklinkEvent .= "_$l_str_FootnoteId');\"";


                // the dedicated template enumerating backlinks uses another variable:
                $l_str_FootnoteBacklinks  = $l_str_FootnoteReference;

                // append the click event right to the backlink item for enumerations;
                // else it goes in the table cell:
                $l_str_FootnoteBacklinks .= $l_str_BacklinkEvent . '>';
                $l_str_FootnoteReference .= '>';

                // append the optional offset anchor for hard links:
                if (self::$l_bool_HardLinksEnable) {
                    $l_str_FootnoteReference .= $l_str_FootnoteAnchorElement;
                    $l_str_FootnoteBacklinks .= $l_str_FootnoteAnchorElement;
                }

                // continue both single note and notes cluster, depending on switch option status:
                if ($l_bool_SymbolSwitch) {

                    $l_str_FootnoteReference .= "$l_str_FootnoteId$l_str_FootnoteArrow";
                    $l_str_FootnoteBacklinks .= "$l_str_FootnoteId$l_str_FootnoteArrow";

                } else {

                    $l_str_FootnoteReference .= "$l_str_FootnoteArrow$l_str_FootnoteId";
                    $l_str_FootnoteBacklinks .= "$l_str_FootnoteArrow$l_str_FootnoteId";

                }

                // If that is the only footnote with this text, we’re almost done.

                // check if it isn't the last footnote in the array:
                if ($l_int_FirstFootnoteIndex < count(self::$a_arr_Footnotes)) {

                    // get all footnotes that haven't passed yet:
                    for ($l_int_CheckIndex = $l_int_FirstFootnoteIndex; $l_int_CheckIndex < count(self::$a_arr_Footnotes); $l_int_CheckIndex++) {

                        // check if a further footnote is the same as the actual one:
                        if ($l_str_FootnoteText == self::$a_arr_Footnotes[$l_int_CheckIndex]) {

                            // if so, set the further footnote as empty so it won't be displayed later:
                            self::$a_arr_Footnotes[$l_int_CheckIndex] = "";

                            // set the flag to true for the combined status:
                            $l_bool_FlagCombined = true;

                            // update the footnote ID:
                            $l_str_FootnoteId = MCI_Footnotes_Convert::Index(($l_int_CheckIndex + 1), MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE));

                            // resume composing the backlinks enumeration:
                            $l_str_FootnoteBacklinks .= "$l_str_Separator</";
                            $l_str_FootnoteBacklinks .= self::$l_str_LinkSpan . '>';
                            $l_str_FootnoteBacklinks .= $l_str_LineBreak;
                            $l_str_FootnoteBacklinks .= '<' . self::$l_str_LinkSpan;
                            $l_str_FootnoteBacklinks .= ' id="footnote_plugin_reference_';
                            $l_str_FootnoteBacklinks .= self::$l_int_PostId;
                            $l_str_FootnoteBacklinks .= '_' . self::$l_int_ReferenceContainerId;
                            $l_str_FootnoteBacklinks .= "_$l_str_FootnoteId\"";
                            // insert the optional hard link address:
                            if (self::$l_bool_HardLinksEnable) {
                                $l_str_FootnoteBacklinks .= ' href="#';
                                $l_str_FootnoteBacklinks .= self::$l_str_ReferrerLinkSlug;
                                $l_str_FootnoteBacklinks .= self::$l_str_PostContainerIdCompound;
                                $l_str_FootnoteBacklinks .= $l_str_FootnoteId . '"';
                            }
                            $l_str_FootnoteBacklinks .= ' class="footnote_backlink"';
                            $l_str_FootnoteBacklinks .= ' onclick="footnote_moveToAnchor_';
                            $l_str_FootnoteBacklinks .= self::$l_int_PostId;
                            $l_str_FootnoteBacklinks .= '_' . self::$l_int_ReferenceContainerId;
                            $l_str_FootnoteBacklinks .= "('footnote_plugin_tooltip_";
                            $l_str_FootnoteBacklinks .= self::$l_int_PostId;
                            $l_str_FootnoteBacklinks .= '_' . self::$l_int_ReferenceContainerId;
                            $l_str_FootnoteBacklinks .= "_$l_str_FootnoteId');\">";
                            // append the offset anchor for optional hard links:
                            if (self::$l_bool_HardLinksEnable) {
                                $l_str_FootnoteBacklinks .= '<span class="footnote_item_base"><span id="';
                                $l_str_FootnoteBacklinks .= self::$l_str_FootnoteLinkSlug;
                                $l_str_FootnoteBacklinks .= self::$l_str_PostContainerIdCompound;
                                $l_str_FootnoteBacklinks .= $l_str_FootnoteId;
                                $l_str_FootnoteBacklinks .= '" class="footnote_item_anchor"></span></span>';
                            }
                            $l_str_FootnoteBacklinks .= $l_bool_SymbolSwitch ? '' : $l_str_FootnoteArrow;
                            $l_str_FootnoteBacklinks .= $l_str_FootnoteId;
                            $l_str_FootnoteBacklinks .= $l_bool_SymbolSwitch ? $l_str_FootnoteArrow : '';

                        }
                    }
                }

                // append terminator and end tag:
                $l_str_FootnoteReference .= $l_str_Terminator . '</' . self::$l_str_LinkSpan . '>';
                $l_str_FootnoteBacklinks .= $l_str_Terminator . '</' . self::$l_str_LinkSpan . '>';

            }

            // line wrapping of URLs already fixed, see above

            // replace all placeholders in 'templates/public/reference-container-body.html'
            // or in 'templates/public/reference-container-body-combi.html'
            // or in 'templates/public/reference-container-body-3column.html'
            // or in 'templates/public/reference-container-body-switch.html'
            $l_obj_Template->replace(
                array(

                    // placeholder used in all templates:
                    "text"            => $l_str_FootnoteText,

                    // used in standard layout W/O COMBINED FOOTNOTES:
                    "post_id"         => self::$l_int_PostId,
                    "container_id"    => self::$l_int_ReferenceContainerId,
                    "note_id"         => MCI_Footnotes_Convert::Index($l_int_FirstFootnoteIndex, MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_FOOTNOTES_COUNTER_STYLE)),
                    "link-start"      => self::$l_str_LinkOpenTag,
                    "link-end"        => self::$l_str_LinkCloseTag,
                    "link-span"       => self::$l_str_LinkSpan,
                    "terminator"      => $l_str_Terminator,
                    "anchor-element"  => $l_str_FootnoteAnchorElement,
                    "hard-link"       => $l_str_HardLinkAddress,

                    // used in standard layout WITH COMBINED IDENTICALS TURNED ON:
                    "pointer"         => $l_bool_FlagCombined ? '' : ' pointer',
                    "event"           => $l_bool_FlagCombined ? '' : $l_str_BacklinkEvent,
                    "backlinks"       => $l_bool_FlagCombined ? $l_str_FootnoteBacklinks : $l_str_FootnoteReference,

                    // Legacy placeholders for use in legacy layout templates:
                    "arrow"           => $l_str_FootnoteArrow,
                    "index"           => $l_str_FootnoteId,
                )
            );

            $l_str_Body .= $l_obj_Template->getContent();

            // extra line breaks for page source readability:
            $l_str_Body .= "\r\n\r\n";

            $l_obj_Template->reload();

        }

        // streamline:
        $l_bool_CollapseDefault = MCI_Footnotes_Convert::toBool(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_BOOL_REFERENCE_CONTAINER_COLLAPSE));

        // load 'templates/public/reference-container.html':
        $l_obj_TemplateContainer = new MCI_Footnotes_Template(MCI_Footnotes_Template::C_STR_PUBLIC, "reference-container");
        $l_obj_TemplateContainer->replace(
            array(
                "post_id"         =>  self::$l_int_PostId,
                "container_id"    =>  self::$l_int_ReferenceContainerId,
                "element"         =>  MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_LABEL_ELEMENT),
                "name"            =>  MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_STR_REFERENCE_CONTAINER_NAME),
                "button-style"    => !$l_bool_CollapseDefault ? 'display: none;' : '',
                "style"           =>  $l_bool_CollapseDefault ? 'display: none;' : '',
                "content"         =>  $l_str_Body,
                "scroll-offset"   =>  (self::$l_int_ScrollOffset / 100),
                "scroll-duration" =>  intval(MCI_Footnotes_Settings::instance()->get(MCI_Footnotes_Settings::C_INT_FOOTNOTES_SCROLL_DURATION)),
            )
        );

        // free all found footnotes if reference container will be displayed
        self::$a_arr_Footnotes = array();

        return $l_obj_TemplateContainer->getContent();
    }
}
