<?php
/**
 * User: she
 * Date: 29.04.14
 * Time: 15:01
 */

/**
 * Class footnotes_class_settings
 */
class footnotes_class_settings
{
	/* attribute for default settings value */
	public static $default_settings = array(
		FOOTNOTE_INPUT_COMBINE_IDENTICAL_NAME => 'yes',
		FOOTNOTE_INPUT_REFERENCES_NAME => 'References'
	);
	var $pagehook, $page_id, $settings_field, $options; /* class attributes */

	private $a_arr_CombineIdentical; /* contains the storage value for the "combine identical" setting */
	private $a_arr_References; /* contains the storage value for the references setting */

	/**
	 * @constructor
	 */
	function __construct()
	{
		$this->page_id = FOOTNOTES_SETTINGS_PAGE_ID;
		/* This is the get_options slug used in the database to store our plugin option values. */
		$this->settings_field = FOOTNOTE_SETTINGS_CONTAINER;
		/* read plugin settings from database */
		$this->options = footnote_filter_options($this->settings_field);
		/* execute class functions: admin_init and admin_menu */
		add_action('admin_init', array($this, 'admin_init'), 20);
		add_action('admin_menu', array($this, 'admin_menu'), 20);
	}

	/**
	 * initialize settings page
	 * called in class constructor
	 */
	function admin_init()
	{
		/* add the jQuery plugin to the settings page */
		wp_enqueue_script('jquery');
		/* register stylesheet for the settings page */
		wp_register_style('footnote_settings_style', plugins_url('css/settings.css', __FILE__));
		/* add stylesheet to the settings page */
		wp_enqueue_style('footnote_settings_style');
		/* register stylesheet for the public page */
		wp_register_style('footnote_public_style', plugins_url('css/footnote.css', __FILE__));
		/* add stylesheet to the public page */
		wp_enqueue_style('footnote_public_style');
		/* Needed to allow metabox layout and close functionality */
		wp_enqueue_script('postbox');

		/* register the settings and sanitize the values loaded from database */
		register_setting($this->settings_field, $this->settings_field, array($this, 'sanitize_theme_options'));
		/* adds the values from database to the options array or adds the default values if the database values are invalid */
		add_option($this->settings_field, self::$default_settings);
		/* collect data for "combine identical" */
		$this->a_arr_CombineIdentical = array();
		$this->a_arr_CombineIdentical["id"] = $this->get_field_id(FOOTNOTE_INPUT_COMBINE_IDENTICAL_NAME);
		$this->a_arr_CombineIdentical["name"] = $this->get_field_name(FOOTNOTE_INPUT_COMBINE_IDENTICAL_NAME);
		$this->a_arr_CombineIdentical["value"] = esc_attr($this->get_field_value(FOOTNOTE_INPUT_COMBINE_IDENTICAL_NAME));

		/* collect data for "references" label */
		$this->a_arr_References = array();
		$this->a_arr_References["id"] = $this->get_field_id(FOOTNOTE_INPUT_REFERENCES_NAME);
		$this->a_arr_References["name"] = $this->get_field_name(FOOTNOTE_INPUT_REFERENCES_NAME);
		$this->a_arr_References["value"] = esc_attr($this->get_field_value(FOOTNOTE_INPUT_REFERENCES_NAME));
	}

	/**
	 * add admin menu for plugin settings
	 * called in class constructor
	 */
	function admin_menu()
	{
		/* current user needs the permission to update plugins */
		if (!current_user_can('update_plugins')) {
			return;
		}

		/* submenu page title */
		$l_str_PageTitle = "Footnotes";
		/* submenu title */
		$l_str_MenuTitle = "Footnotes";

		/* Add a new submenu to the standard Settings panel */
		$this->pagehook = $page = add_options_page( $l_str_PageTitle, $l_str_MenuTitle, 'administrator', $this->page_id, array($this, 'render'));

		/* Executed on-load. Add all metaboxes. calls function: metaboxes */
		add_action('load-' . $this->pagehook, array($this, 'metaboxes'));

		/* Include js, css, or header *only* for our settings page, calls function: js_includes */
		add_action("admin_print_scripts-$page", array($this, 'js_includes'));
		/* calls function: admin_head */
		add_action("admin_head-$page", array($this, 'admin_head'));
	}

	/**
	 * called in admin_menu()
	 */
	function admin_head()
	{
	}

	/**
	 * called in admin_menu()
	 */
	function js_includes()
	{
	}

	/**
	 * Sanitize our plugin settings array as needed.
	 * @param array $options
	 * @return array
	 */
	function sanitize_theme_options($options)
	{
		/* loop through all keys in the array and filters them */
		foreach ($options as $l_str_Key => $l_str_Value) {
			$options[$l_str_Key] = stripcslashes($l_str_Value);
		}
		return $options;
	}

	/**
	 * access settings field by name
	 * @param string $name
	 * @return string
	 */
	protected function get_field_name($name)
	{
		return sprintf('%s[%s]', $this->settings_field, $name);
	}

	/**
	 * access settings field by id
	 * @param string $id
	 * @return string
	 */
	protected function get_field_id($id)
	{
		return sprintf('%s[%s]', $this->settings_field, $id);

	}

	/**
	 * get settings field value
	 * @param string $key
	 * @return string
	 */
	protected function get_field_value($key)
	{
		return $this->options[$key];
	}

	/**
	 * Render settings page, display the page container
	 */
	function render()
	{
		global $wp_meta_boxes;
		?>

		<div class="wrap">
			<h2><span class='METHIS'>Footnotes</span> <?php echo __("Settings", FOOTNOTES_PLUGIN_NAME); ?></h2>

			<form method="post" action="options.php">
				<p>
					<input type="submit" class="button button-primary" name="save_options"
						   value="<?php echo __("Save", FOOTNOTES_PLUGIN_NAME); ?>"/>
				</p>

				<div class="metabox-holder">
					<div class="postbox-container" style="width: 99%;">
						<?php
						/* Render metaboxes */
						settings_fields($this->settings_field);
						do_meta_boxes($this->pagehook, 'main', null);
						if (isset($wp_meta_boxes[$this->pagehook]['layout'])) {
							do_meta_boxes($this->pagehook, 'layout', null);
						}
						?>
					</div>
				</div>

				<p>
					<input type="submit" class="button button-primary" name="save_options"
						   value="<?php echo __("Save", FOOTNOTES_PLUGIN_NAME); ?>"/>
				</p>
			</form>
		</div>

		<!-- Needed to allow metabox layout and close functionality. -->
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
			});
		</script>
	<?php
	}

	/**
	 * add containers to the settings page
	 * displayed containers on the settings page
	 */
	function metaboxes()
	{
		add_meta_box('footnote-plugin-settings', __("Settings", FOOTNOTES_PLUGIN_NAME), array($this, 'settings_box'), $this->pagehook, 'main');
		add_meta_box('footnote-plugin-general', __("General Information", FOOTNOTES_PLUGIN_NAME), array($this, 'placeholder_box'), $this->pagehook, 'main');
	}

	function settings_box() {
		?>
		<!-- setting references label -->
		<div class="footnote_plugin_container">
			<label class="footnote_plugin_25" for="<?php echo $this->a_arr_References["id"]; ?>">
				<?php echo __("References label:", FOOTNOTES_PLUGIN_NAME); ?>
			</label>
			<input type="text" class="footnote_plugin_75" name="<?php echo $this->a_arr_References["name"]; ?>" id="<?php echo $this->a_arr_References["id"]; ?>"
				   value="<?php echo $this->a_arr_References["value"]; ?>"/>
		</div>

		<!-- setting combine identical -->
		<div class="footnote_plugin_container">
			<label class="footnote_plugin_25" for="<?php echo $this->a_arr_CombineIdentical["id"]; ?>">
				<?php echo __("Combine identical footnotes:", FOOTNOTES_PLUGIN_NAME); ?>
			</label>
			<select class="footnote_plugin_25" id="<?php echo FOOTNOTE_INPUT_COMBINE_IDENTICAL_NAME; ?>" name="<?php echo $this->a_arr_CombineIdentical["name"]; ?>">
				<option value="yes"><?php echo __("Yes", FOOTNOTES_PLUGIN_NAME); ?></option>
				<option value="no"><?php echo __("No", FOOTNOTES_PLUGIN_NAME); ?></option>
			</select>
			<script type="text/javascript">
				jQuery(document).ready(function () {
					jQuery("#<?php echo FOOTNOTE_INPUT_COMBINE_IDENTICAL_NAME; ?> option[value='<?php echo $this->a_arr_CombineIdentical["value"]; ?>']").prop("selected", true);
				});
			</script>
		</div>
		<?php
	}

	/**
	 * displays the placeholder tag container
	 */
	function placeholder_box() {
		?>
		<div style="text-align:center;">
			<div class="footnote_placeholder_box_container">
				<p>
					<?php echo __("Start your footnote with the following shortcode:", FOOTNOTES_PLUGIN_NAME); ?>
					<span class="footnote_highlight_placeholder"><?php echo FOOTNOTE_PLACEHOLDER_START; ?></span>
				</p>
				<p>
					<?php echo __("...and end your footnote with this shortcode:", FOOTNOTES_PLUGIN_NAME); ?>
					<span class="footnote_highlight_placeholder"><?php echo FOOTNOTE_PLACEHOLDER_END; ?></span>
				</p>

				<p>&nbsp;</p>

				<p>
					<span class="footnote_highlight_placeholder"><?php echo FOOTNOTE_PLACEHOLDER_START . __("example string", FOOTNOTES_PLUGIN_NAME) . FOOTNOTE_PLACEHOLDER_END; ?></span>
					<?php echo __("will be displayed as:", FOOTNOTES_PLUGIN_NAME); ?>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo footnote_example_replacer(__("example string", FOOTNOTES_PLUGIN_NAME)); ?>
				</p>

				<p>&nbsp;</p>

				<p>
					<?php echo sprintf(__("If you have any questions, please don't hesitate to %smail us%s.", FOOTNOTES_PLUGIN_NAME), '<a href="mailto:admin@herndler.org" class="footnote_plugin">', '</a>'); ?>
				</p>
			</div>
		</div>
		<?php
	}
} /* Class footnotes_class_settings */