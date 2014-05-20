<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0.6
 * Since: 1.0
 */

/**
 * Class Class_FootnotesSettings
 * @since 1.0
 */
class Class_FootnotesSettings
{
	/*
	 * attribute for default settings value
	 * updated default value for 'FOOTNOTE_INPUTFIELD_LOVE' to default: 'no' in version 1.0.6
	 * @since 1.0
	 */
	public static $a_arr_Default_Settings = array(
		FOOTNOTE_INPUTFIELD_COMBINE_IDENTICAL => 'yes',
		FOOTNOTE_INPUTFIELD_REFERENCES_LABEL  => 'References',
		FOOTNOTE_INPUTFIELD_COLLAPSE_REFERENCES => '',
		FOOTNOTE_INPUTFIELD_PLACEHOLDER_START => '((',
		FOOTNOTE_INPUTFIELD_PLACEHOLDER_END => '))',
		FOOTNOTE_INPUTFIELD_SEARCH_IN_EXCERPT => 'yes',
		FOOTNOTE_INPUTFIELD_LOVE => 'no',
		FOOTNOTE_INPUTFIELD_COUNTER_STYLE => 'arabic_plain'
	);
	/*
	 * resulting pagehook for adding a new sub menu page to the settings
	 * @since 1.0
	 */
	var $a_str_Pagehook;
	/*
	 * collection of settings values for this plugin
	 * @since 1.0
	 */
	var $a_arr_Options;
	/*
	 * collection of tabs for the settings page of this plugin
	 * @since 1.0
	 */
	private $a_arr_SettingsTabs = array();

	/**
	 * @constructor
	 * @since 1.0
	 */
	function __construct()
	{
		/* loads and filters the settings for this plugin */
		$this->a_arr_Options = footnotes_filter_options( FOOTNOTE_SETTINGS_CONTAINER, self::$a_arr_Default_Settings, true );

		/* execute class includes on action-even: init, admin_init and admin_menu */
		add_action( 'init', array( $this, 'LoadScriptsAndStylesheets' ) );
		add_action( 'admin_init', array( $this, 'RegisterSettings' ) );

		add_action( 'admin_init', array( $this, 'RegisterTab_General' ) );
		add_action( 'admin_init', array( $this, 'RegisterTab_HowTo' ) );

		add_action( 'admin_menu', array( $this, 'AddSettingsMenuPanel' ) );
	}

	/**
	 * initialize settings page, loads scripts and stylesheets needed for the layout
	 * called in class constructor @ init
	 * @since 1.0
	 */
	function LoadScriptsAndStylesheets()
	{
		/* add the jQuery plugin (already registered by WP) */
		wp_enqueue_script( 'jquery' );
		/* register public stylesheet */
		wp_register_style( 'footnote_public_style', plugins_url( '../css/footnote.css', __FILE__ ) );
		/* add public stylesheet */
		wp_enqueue_style( 'footnote_public_style' );
		/* register settings stylesheet */
		wp_register_style( 'footnote_settings_style', plugins_url( '../css/settings.css', __FILE__ ) );
		/* add settings stylesheet */
		wp_enqueue_style( 'footnote_settings_style' );
	}

	/**
	 * register the settings field in the database for the "save" function
	 * called in class constructor @ admin_init
	 * @since 1.0
	 */
	function RegisterSettings()
	{
		register_setting( FOOTNOTE_SETTINGS_LABEL_GENERAL, FOOTNOTE_SETTINGS_CONTAINER );
	}

	/**
	 * sets the plugin's title for the admins settings menu
	 * called in class constructor @ admin_menu
	 * @since 1.0
	 */
	function AddSettingsMenuPanel()
	{
		/* current user needs the permission to update plugins for further access */
		if ( !current_user_can( 'update_plugins' ) ) {
			return;
		}
		/* submenu page title */
		$l_str_PageTitle = '<span style="color: #2bb975; ">foot</span><span style="color: #545f5a; ">notes</span>';
		/* submenu title */
		$l_str_MenuTitle = '<span style="color: #2bb975; ">foot</span><span style="color: #545f5a; ">notes</span>';
		/* Add a new submenu to the standard Settings panel */
		$this->a_str_Pagehook = add_options_page( $l_str_PageTitle, $l_str_MenuTitle, 'administrator', FOOTNOTES_SETTINGS_PAGE_ID, array( $this, 'OutputSettingsPage' ) );
	}

	/**
	 * Plugin Options page rendering goes here, checks
	 * for active tab and replaces key with the related
	 * settings key. Uses the plugin_options_tabs method
	 * to render the tabs.
	 * @since 1.0
	 */
	function OutputSettingsPage()
	{
		/* gets active tag, or if nothing set the "general" tab will be set to active */
		$l_str_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : FOOTNOTE_SETTINGS_LABEL_GENERAL;
		/* outputs all tabs */
		echo '<div class="wrap">';
		$this->OutputSettingsPageTabs();
		/* outputs a form with the content of the current active tab */
		echo '<form method="post" action="options.php">';
		wp_nonce_field( 'update-options' );
		settings_fields( $l_str_tab );
		/* outputs the settings field of the current active tab */
		do_settings_sections( $l_str_tab );
		/* adds a submit button to the current page */
		submit_button();
		echo '</form>';
		echo '</div>';
	}

	/**
	 * Renders our tabs in the plugin options page,
	 * walks through the object's tabs array and prints
	 * them one by one. Provides the heading for the
	 * plugin_options_page method.
	 * @since 1.0
	 */
	function OutputSettingsPageTabs()
	{
		/* gets active tag, or if nothing set the "general" tab will be set to active */
		$l_str_CurrentTab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : FOOTNOTE_SETTINGS_LABEL_GENERAL;
		screen_icon();
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->a_arr_SettingsTabs as $l_str_TabKey => $l_str_TabCaption ) {
			$active = $l_str_CurrentTab == $l_str_TabKey ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . FOOTNOTES_SETTINGS_PAGE_ID . '&tab=' . $l_str_TabKey . '">' . $l_str_TabCaption . '</a>';
		}
		echo '</h2>';
	}

	/**
	 * loads specific setting and returns an array with the keys [id, name, value]
	 * @since 1.0
	 * @param $p_str_FieldID
	 * @return array
	 */
	protected function LoadSetting( $p_str_FieldID )
	{
		$p_arr_Return = array();
		$p_arr_Return[ "id" ] = $this->getFieldID( $p_str_FieldID );
		$p_arr_Return[ "name" ] = $this->getFieldName( $p_str_FieldID );
		$p_arr_Return[ "value" ] = esc_attr( $this->getFieldValue( $p_str_FieldID ) );
		return $p_arr_Return;
	}

	/**
	 * access settings field by name
	 * @since 1.0
	 * @param string $p_str_FieldName
	 * @return string
	 */
	protected function getFieldName( $p_str_FieldName )
	{
		return sprintf( '%s[%s]', FOOTNOTE_SETTINGS_CONTAINER, $p_str_FieldName );
		//return sprintf( '%s', $p_str_FieldName );
	}

	/**
	 * access settings field by id
	 * @since 1.0
	 * @param string $p_str_FieldID
	 * @return string
	 */
	protected function getFieldID( $p_str_FieldID )
	{
		return sprintf( '%s[%s]', FOOTNOTE_SETTINGS_CONTAINER, $p_str_FieldID );
		//return sprintf( '%s', $p_str_FieldID );
	}

	/**
	 * get settings field value
	 * @since 1.0
	 * @param string $p_str_Key
	 * @return string
	 */
	protected function getFieldValue( $p_str_Key )
	{
		return $this->a_arr_Options[ $p_str_Key ];
	}

	/**
	 * outputs a input type=text
	 * @param string $p_str_SettingsID [id of the settings field]
	 * @param string $p_str_ClassName [css class name]
	 * @param int $p_str_MaxLength [max length for the input value]
	 * @param string $p_str_Label [label text]
	 * @since 1.0-beta
	 */
	function AddTextbox($p_str_SettingsID, $p_str_ClassName="", $p_str_MaxLength=0, $p_str_Label="")
	{
		/* collect data for given settings field */
		$l_arr_Data = $this->LoadSetting( $p_str_SettingsID );

		/* if input shall have a css class, add the style tag for it */
		if (!empty($p_str_ClassName)) {
			$p_str_ClassName = 'class="' . $p_str_ClassName . '"';
		}
		/* optional add a maxlength to the input field */
		if (!empty($p_str_MaxLength)) {
			$p_str_MaxLength = ' maxlength="'.$p_str_MaxLength.'"';
		}
		/* optional add a label in front of the input field */
		if (!empty($p_str_Label)) {
			echo '<label for="'.$l_arr_Data[ "id" ].'">'.$p_str_Label.'</label>';
		}

		/* outputs an input field type TEXT */
		echo '<input type="text" '.$p_str_ClassName.$p_str_MaxLength.' name="'.$l_arr_Data[ "name" ].'" id="'.$l_arr_Data[ "id" ].'" value="'.$l_arr_Data[ "value" ].'"/>';
	}

	/**
	 * outputs a input type=checkbox
	 * @param string $p_str_SettingsID [id of the settings field]
	 * @param string $p_str_ClassName [optional css class name]
	 * @since 1.0-beta
	 */
	function AddCheckbox($p_str_SettingsID, $p_str_ClassName="")
	{
		/* collect data for given settings field */
		$l_arr_Data = $this->LoadSetting( $p_str_SettingsID );

		/* if input shall have a css class, add the style tag for it */
		if (!empty($p_str_ClassName)) {
			$p_str_ClassName = 'class="' . $p_str_ClassName . '"';
		}

		/* lookup if the checkbox shall be pre-checked */
		$l_str_Checked = "";
		if (footnotes_ConvertToBool($l_arr_Data["value"])) {
			$l_str_Checked = 'checked="checked"';
		}

		/* outputs an input field type CHECKBOX */
		echo sprintf('<input type="checkbox" '.$p_str_ClassName.' name="'.$l_arr_Data[ "name" ].'" id="'.$l_arr_Data[ "id" ].'" %s/>', $l_str_Checked);
	}

	/**
	 * outputs a select box
	 * @param string $p_str_SettingsID [id of the settings field]
	 * @param array $p_arr_Options [array with options]
	 * @param string $p_str_ClassName [optional css class name]
	 * @since 1.0-beta
	 */
	function AddSelectbox($p_str_SettingsID, $p_arr_Options, $p_str_ClassName="")
	{
		/* collect data for given settings field */
		$l_arr_Data = $this->LoadSetting( $p_str_SettingsID );

		/* if input shall have a css class, add the style tag for it */
		if (!empty($p_str_ClassName)) {
			$p_str_ClassName = 'class="' . $p_str_ClassName . '"';
		}

		/* select starting tag */
		$l_str_Output = '<select ' . $p_str_ClassName . ' name="'.$l_arr_Data[ "name" ].'" id="'.$l_arr_Data[ "id" ].'">';
		/* loop through all array keys */
		foreach($p_arr_Options as $l_str_Value => $l_str_Caption) {
			/* add key as option value */
			$l_str_Output .= '<option value="'.$l_str_Value.'"';
			/* check if option value is set and has to be pre-selected */
			if ($l_arr_Data["value"] == $l_str_Value) {
				$l_str_Output .= ' selected';
			}
			/* write option caption and close option tag */
			$l_str_Output .= '>' . $l_str_Caption . '</option>';
		}
		/* close select */
		$l_str_Output .= '</select>';
		/* outputs the SELECT field */
		echo $l_str_Output;
	}

	/**
	 * initialize general settings tab
	 * called in class constructor @ admin_init
	 * @since 1.0
	 */
	function RegisterTab_General()
	{
		$l_str_SectionName = "Footnote_Secion_Settings_General";
		/* add tab to the tab array */
		$this->a_arr_SettingsTabs[ FOOTNOTE_SETTINGS_LABEL_GENERAL ] = __( "General", FOOTNOTES_PLUGIN_NAME );
		/* register settings tab */
		add_settings_section( $l_str_SectionName, sprintf(__( "%s Settings", FOOTNOTES_PLUGIN_NAME ), '<span style="color: #2bb975; ">foot</span><span style="color: #545f5a; ">notes</span>'), array( $this, 'RegisterTab_General_Description' ), FOOTNOTE_SETTINGS_LABEL_GENERAL );
		add_settings_field( 'Register_References_Label', __( "References label:", FOOTNOTES_PLUGIN_NAME ), array( $this, 'Register_References_Label' ), FOOTNOTE_SETTINGS_LABEL_GENERAL, $l_str_SectionName );
		add_settings_field( 'Register_Collapse_References', __( "Collapse references by default:", FOOTNOTES_PLUGIN_NAME ), array( $this, 'Register_Collapse_References' ), FOOTNOTE_SETTINGS_LABEL_GENERAL, $l_str_SectionName );
		add_settings_field( 'Register_Combine_Identical', __( "Combine identical footnotes:", FOOTNOTES_PLUGIN_NAME ), array( $this, 'Register_Combine_Identical' ), FOOTNOTE_SETTINGS_LABEL_GENERAL, $l_str_SectionName );
		add_settings_field( 'Register_Placeholder_Tags', __( "Footnote tag:", FOOTNOTES_PLUGIN_NAME ), array( $this, 'Register_Placeholder_Tags' ), FOOTNOTE_SETTINGS_LABEL_GENERAL, $l_str_SectionName );
		add_settings_field( 'Register_CounterStyle', __( "Counter style:", FOOTNOTES_PLUGIN_NAME ), array( $this, 'Register_CounterStyle' ), FOOTNOTE_SETTINGS_LABEL_GENERAL, $l_str_SectionName );
		add_settings_field( 'Register_SearchExcerpt', __( "Allow footnotes on Summarized Posts:", FOOTNOTES_PLUGIN_NAME ), array( $this, 'Register_SearchExcerpt' ), FOOTNOTE_SETTINGS_LABEL_GENERAL, $l_str_SectionName );
		add_settings_field( 'Register_LoveAndShare', sprintf(__( "Tell the world you're using %sfoot%snotes%s:", FOOTNOTES_PLUGIN_NAME ), '<span style="color: #2bb975; ">', '</span><span style="color: #545f5a; ">', '</span>'), array( $this, 'Register_LoveAndShare' ), FOOTNOTE_SETTINGS_LABEL_GENERAL, $l_str_SectionName );
	}

	/**
	 * adds a desciption to the general settings tab
	 * called in RegisterTab_General
	 * @since 1.0
	 */
	function RegisterTab_General_Description()
	{
		// unused description
	}

	/**
	 * outputs the settings field for the "references label"
	 * @since 1.0
	 */
	function Register_References_Label()
	{
		/* add a textbox to the output */
		$this->AddTextbox(FOOTNOTE_INPUTFIELD_REFERENCES_LABEL, "footnote_plugin_50");
	}

	/**
	 * outputs the settings field for the "references label"
	 * @since 1.0-beta
	 */
	function Register_Collapse_References()
	{
		/* add a checkbox to the output */
		$this->AddCheckbox(FOOTNOTE_INPUTFIELD_COLLAPSE_REFERENCES);
	}

	/**
	 * outputs the settings field for the "combine identical footnotes"
	 * @since 1.0
	 */
	function Register_Combine_Identical()
	{
		/* get array with option elements */
		$l_arr_Options = array(
			"yes" => __( "Yes", FOOTNOTES_PLUGIN_NAME ),
			"no" => __( "No", FOOTNOTES_PLUGIN_NAME )
		);
		/* add a select box to the output */
		$this->AddSelectbox(FOOTNOTE_INPUTFIELD_COMBINE_IDENTICAL, $l_arr_Options, "footnote_plugin_25");
	}

	/**
	 * outputs the settings fields for the footnote starting and ending tag
	 * @since 1.0-gamma
	 */
	function Register_Placeholder_Tags()
	{
		/* add a textbox to the output */
		$this->AddTextbox(FOOTNOTE_INPUTFIELD_PLACEHOLDER_START, "", 14,  __( "starts with:", FOOTNOTES_PLUGIN_NAME ));
		/* small space between the two input fields */
		echo '&nbsp;&nbsp;&nbsp;';
		/* add a textbox to the output */
		$this->AddTextbox(FOOTNOTE_INPUTFIELD_PLACEHOLDER_END, "", 14,  __( "ends with:", FOOTNOTES_PLUGIN_NAME ));
	}

	/**
	 * outouts the settings field for the counter style
	 * @since 1.0-gamma
	 */
	function Register_CounterStyle()
	{
		$l_str_Space = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		/* get array with option elements */
		$l_arr_Options = array(
			"arabic_plain" => __( "Arabic Numbers - Plain", FOOTNOTES_PLUGIN_NAME ) .$l_str_Space. "1, 2, 3, 4, 5, ...",
			"arabic_leading" => __( "Arabic Numbers - Leading 0", FOOTNOTES_PLUGIN_NAME ) .$l_str_Space. "01, 02, 03, 04, 05, ...",
			"latin_low" => __( "Latin Character - lower case", FOOTNOTES_PLUGIN_NAME ) .$l_str_Space. "a, b, c, d, e, ...",
			"latin_high" => __( "Latin Character - upper case", FOOTNOTES_PLUGIN_NAME ) .$l_str_Space. "A, B, C, D, E, ...",
			"romanic" => __( "Roman Numerals", FOOTNOTES_PLUGIN_NAME ) .$l_str_Space. "I, II, III, IV, V, ..."
		);
		/* add a select box to the output */
		$this->AddSelectbox(FOOTNOTE_INPUTFIELD_COUNTER_STYLE, $l_arr_Options, "footnote_plugin_50");
	}

	/**
	 * outputs the settings field for "allow searching in summarized posts"
	 * @since 1.0-gamma
	 */
	function Register_SearchExcerpt()
	{
		/* get array with option elements */
		$l_arr_Options = array(
			"yes" => __( "Yes", FOOTNOTES_PLUGIN_NAME ),
			"no" => __( "No", FOOTNOTES_PLUGIN_NAME )
		);
		/* add a select box to the output */
		$this->AddSelectbox(FOOTNOTE_INPUTFIELD_SEARCH_IN_EXCERPT, $l_arr_Options, "footnote_plugin_25");
	}

	/**
	 * outputs the settings field for "love and share this plugin"
	 * @since 1.0-gamma
	 */
	function Register_LoveAndShare()
	{
		/* get array with option elements */
		$l_arr_Options = array(
			"yes" => __( "Yes", FOOTNOTES_PLUGIN_NAME ),
			"no" => __( "No", FOOTNOTES_PLUGIN_NAME )
		);
		/* add a select box to the output */
		$this->AddSelectbox(FOOTNOTE_INPUTFIELD_LOVE, $l_arr_Options, "footnote_plugin_25");
	}

	/**
	 * initialize howto settings tab
	 * called in class constructor @ admin_init
	 * @since 1.0
	 */
	function RegisterTab_HowTo()
	{
		$l_str_SectionName = "Footnote_Secion_Settings_Howto";
		/* add tab to the tab array */
		$this->a_arr_SettingsTabs[ FOOTNOTE_SETTINGS_LABEL_HOWTO ] = __( "HowTo", FOOTNOTES_PLUGIN_NAME );
		/* register settings tab */
		add_settings_section( $l_str_SectionName, __( "HowTo", FOOTNOTES_PLUGIN_NAME ), array( $this, 'RegisterTab_HowTo_Description' ), FOOTNOTE_SETTINGS_LABEL_HOWTO );
		add_settings_field( 'Register_Howto_Box', "", array( $this, 'Register_Howto_Box' ), FOOTNOTE_SETTINGS_LABEL_HOWTO, $l_str_SectionName );
	}

	/**
	 * adds a descrption to the HowTo settings tab
	 * called int RegisterTab_HowTo
	 * @since 1.0
	 */
	function RegisterTab_HowTo_Description()
	{
		echo __( "This is a brief introduction in how to use the plugin.", FOOTNOTES_PLUGIN_NAME );
	}

	/**
	 * outputs the content of the HowTo settings tab
	 * @since 1.0
	 */
	function Register_Howto_Box()
	{
		$l_arr_Footnote_StartingTag = $this->LoadSetting(FOOTNOTE_INPUTFIELD_PLACEHOLDER_START);
		$l_arr_Footnote_EndingTag = $this->LoadSetting(FOOTNOTE_INPUTFIELD_PLACEHOLDER_END);
		?>
		<div style="text-align:center;">
			<div class="footnote_placeholder_box_container">
				<p>
					<?php echo __( "Start your footnote with the following shortcode:", FOOTNOTES_PLUGIN_NAME ); ?>
					<span class="footnote_highlight_placeholder"><?php echo $l_arr_Footnote_StartingTag["value"]; ?></span>
				</p>

				<p>
					<?php echo __( "...and end your footnote with this shortcode:", FOOTNOTES_PLUGIN_NAME ); ?>
					<span class="footnote_highlight_placeholder"><?php echo $l_arr_Footnote_EndingTag["value"]; ?></span>
				</p>

				<div class="footnote_placeholder_box_example">
					<p>
						<span class="footnote_highlight_placeholder"><?php echo $l_arr_Footnote_StartingTag["value"] . __( "example string", FOOTNOTES_PLUGIN_NAME ) . $l_arr_Footnote_EndingTag["value"]; ?></span>
						<?php echo __( "will be displayed as:", FOOTNOTES_PLUGIN_NAME ); ?>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo footnotes_replaceFootnotes( $l_arr_Footnote_StartingTag["value"] . __( "example string", FOOTNOTES_PLUGIN_NAME ) . $l_arr_Footnote_EndingTag["value"], true, true ); ?>
					</p>
				</div>

				<p>
					<?php echo sprintf( __( "If you have any questions, please don't hesitate to %se-mail%s us.", FOOTNOTES_PLUGIN_NAME ), '<a href="mailto:mci@cheret.co.uk" class="footnote_plugin">', '</a>' ); ?>
				</p>
			</div>
		</div>
	<?php
	}
} /* Class Class_FootnotesSettings */