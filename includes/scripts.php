<?php
/**
 * Created by Stefan Herndler.
 * User: Stefan
 * Date: 15.05.14
 * Time: 16:21
 * Version: 1.0
 * Since: 1.0
 */


/**
 * register and add the public stylesheet
 * @since 1.0
 */
function footnotes_add_public_stylesheet()
{
    /* register public stylesheet */
    wp_register_style('footnotes_public_style', plugins_url('../css/footnote.css', __FILE__));
    /* add public stylesheet */
    wp_enqueue_style('footnotes_public_style');
	/* add the jQuery plugin (already registered by WP) */
	wp_enqueue_script('jquery');
	/* add jquery tools to public page */
	wp_enqueue_script('footnotes_public_script', plugins_url('../js/jquery.tools.min.js', __FILE__), array());
}

/**
 * register and add the settings stylesheet
 * @since 1.0
 */
function footnotes_add_settings_stylesheet()
{
    /* register settings stylesheet */
    wp_register_style('footnotes_settings_style', plugins_url('../css/settings.css', __FILE__));
    /* add settings stylesheet */
    wp_enqueue_style('footnotes_settings_style');
}