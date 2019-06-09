<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://bottr.me
 * @since      1.0.0
 *
 * @package    Wp_Bottr_Connect
 * @subpackage Wp_Bottr_Connect/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Bottr_Connect
 * @subpackage Wp_Bottr_Connect/public
 * @author     Arjun S Kumar <arjun@bottr.me>
 */
class Wp_Bottr_Connect_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function create_bottr_connect_view() {

		$bottr_options = get_option( 'bottr_options' );
		if( is_array( $bottr_options ) ) {
			$bottrId = $bottr_options['bottrId'];
			$content = '<script type="text/javascript">( function () {window.__Bottr = { u: "' . $bottrId . '" };var url = "https://d279m54f1qquet.cloudfront.net/embed/bottr.js?" + Date.now();var element = document.createElement("script");element.id = "bottr-init-js";element.type = "text/javascript";element.dataset.cfasync = "false"; element.src = url;document.getElementsByTagName("body")[0].appendChild(element);})();</script>';
			echo $content;
		}

	}

}
