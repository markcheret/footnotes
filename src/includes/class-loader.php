<?php
/**
 * File providing the `Loader` class.
 *
 * @package  footnotes
 *
 * @since 2.8.0
 */

declare(strict_types=1);

namespace footnotes\includes;

/**
 * Class defining action/filter registration for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout the plugin, and
 * register them with the WordPress API. Call the run function to execute the
 * list of actions and filters.
 *
 * @package  footnotes
 *
 * @since  2.8.0
 */
class Loader {
	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since  2.8.0
	 * @see  Loader::add()  For more information on the hook array format.
	 *
	 * @var  (string|int|object)[][]  $actions  The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since  2.8.0
	 * @see  Loader::add()  For more information on the hook array format.
	 *
	 * @var  (string|int|object)[][]  $filters  The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since  2.8.0
	 *
	 * @return void
	 */
	public function __construct() {

		$this->actions = array();
		$this->filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since  2.8.0
	 * @see  Loader::add()  For more information on the hook array format.
	 *
	 * @param  string $hook  The name of the WordPress action that is being registered.
	 * @param  object $component  A reference to the instance of the object on which the action is defined.
	 * @param  string $callback  The name of the function definition on the `$component`.
	 * @param  int    $priority  Optional. The priority at which the function should be fired. Default is 10.
	 * @param  int    $accepted_args  Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 * @return void
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since  2.8.0
	 * @see  Loader::add()  For more information on the hook array format.
	 *
	 * @param  string $hook  The name of the WordPress filter that is being registered.
	 * @param  object $component  A reference to the instance of the object on which the filter is defined.
	 * @param  string $callback  The name of the function definition on the `$component`.
	 * @param  int    $priority  Optional. The priority at which the function should be fired. Default is 10.
	 * @param  int    $accepted_args  Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 * @return void
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since  2.8.0
	 *
	 * @param  (string|int|object)[][] $hooks  The collection of hooks that is being registered (that is, actions or filters).
	 * @param  string                  $hook  The name of the WordPress filter that is being registered.
	 * @param  object                  $component  A reference to the instance of the object on which the filter is defined.
	 * @param  string                  $callback  The name of the function definition on the `$component`.
	 * @param  int                     $priority  The priority at which the function should be fired.
	 * @param  int                     $accepted_args The number of arguments that should be passed to the `$callback`.
	 * @return  (string|int|object)[][]  {
	 *     The registered hook(s).
	 *
	 *     @type string $hook The name of the registered WordPress hook.
	 *     @type object $component A reference to the instance of the object on which the hook is defined.
	 *     @type string $callback The name of the function definition on the `$component`.
	 *     @type int $priority The priority at which the function should be fired.
	 *     @type int $accepted_args The number of arguments that should be passed to the `$callback`.
	 * }
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args,
		);

		return $hooks;

	}

	/**
	 * Registers the filters and actions with WordPress.
	 *
	 * @since  2.8.0
	 * @see  Loader::add()  For more information on the hook array format.
	 *
	 * @return void
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
		}

	}

}
