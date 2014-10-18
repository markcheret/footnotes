<?php
/**
 * Includes the main Class of the Plugin.
 *
 * @filesource
 * @author Stefan Herndler
 * @since 1.5.0 12.09.14 10:56
 */


/**
 * Entry point of the Plugin. Loads the Dashboard and executes the Task.
 *
 * @author Stefan Herndler
 * @since 1.5.0
 */
class MCI_Footnotes {

	/**
	 * Reference to the Plugin Task object.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 * @var null|MCI_Footnotes_Task
	 */
	public $a_obj_Task = null;

	/**
	 * Executes the Plugin.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function run() {
		// register language
		MCI_Footnotes_Language::registerHooks();
		// register Button hooks
		MCI_Footnotes_WYSIWYG::registerHooks();
		// register general hooks
		MCI_Footnotes_Hooks::registerHooks();
		// register all Widgets of the Plugin.
		$this->initializeWidgets();
		// initialize the Plugin Dashboard
		$this->initializeDashboard();
		// initialize the Plugin Task
		$this->initializeTask();

		// Register all Public Stylesheets and Scripts
		add_action('init', array($this, 'registerPublic'));
		// Enqueue all Public Stylesheets and Scripts
		add_action('wp_enqueue_scripts', array($this, 'registerPublic'));
	}

	/**
	 * Initializes all Widgets of the Plugin.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function initializeWidgets() {
		add_action('widgets_init', create_function('', 'return register_widget("MCI_Footnotes_Widget_ReferenceContainer");'));
	}

	/**
	 * Initializes the Dashboard of the Plugin and loads them.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function initializeDashboard() {
		new MCI_Footnotes_Layout_Init();
	}

	/**
	 * Initializes the Plugin Task and registers the Task hooks.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	private function initializeTask() {
		$this->a_obj_Task = new MCI_Footnotes_Task();
		$this->a_obj_Task->registerHooks();
	}

	/**
	 * Registers and enqueue scripts and stylesheets to the public pages.
	 *
	 * @author Stefan Herndler
	 * @since 1.5.0
	 */
	public function registerPublic() {
		wp_enqueue_style('mci-footnotes-css-public', plugins_url('../css/public.css', __FILE__));
		// add the jQuery plugin (already registered by WordPress)
		wp_enqueue_script('jquery');
		wp_enqueue_script('mci-footnotes-js-jquery-tools', plugins_url('../js/jquery.tools.min.js', __FILE__));
	}
}