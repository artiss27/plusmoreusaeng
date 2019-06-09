<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bottr.me
 * @since      1.0.0
 *
 * @package    Wp_Bottr_Connect
 * @subpackage Wp_Bottr_Connect/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Bottr_Connect
 * @subpackage Wp_Bottr_Connect/includes
 * @author     Arjun S Kumar <arjun@bottr.me>
 */
class Wp_Bottr_Connect_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-bottr-connect',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
