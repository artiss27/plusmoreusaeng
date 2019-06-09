<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://bottr.me
 * @since      1.0.0
 *
 * @package    Wp_Bottr_Connect
 * @subpackage Wp_Bottr_Connect/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Bottr_Connect
 * @subpackage Wp_Bottr_Connect/admin
 * @author     Arjun S Kumar <arjun@bottr.me>
 */
class Wp_Bottr_Connect_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Bottr_Connect_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Bottr_Connect_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name . '-font', 'https://fonts.googleapis.com/css?family=Montserrat:300,400,600', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-bottr-connect-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Initialize some custom settings
	 */     
	public function init_settings() {
	    // register the settings for this plugin
	    register_setting( 'wp_bottr_connect-group', 'bottr_options', array( $this, 'save_bottr_user' ) );

	}

	/**
	 * Add a menu
	 */     
	public function add_menu() {
	    add_menu_page(
	    	'Bottr Chat bot',
	    	'Bottr Chat bot',
	    	'manage_options',
	    	'wp_bottr_connect',
	    	array(
	    		$this,
	    		'bottr_connect_settings_page'
    		),
    		'https://img.bottr.me/20x20fit/https://d279m54f1qquet.cloudfront.net/common/img/common/icon/v1/64x64.png',
    		6
		);
	}

	/**
	 * Menu Callback
	 */     
	public function bottr_connect_settings_page() {

	    if( !current_user_can('manage_options') ) {
	        wp_die( __( 'You do not have sufficient permissions to access this page.' ));
	    }

	    // Render the settings template
	    include( plugin_dir_path( dirname( __FILE__ ) ) . "admin/partials/wp-bottr-connect-admin-display.php" );
	}

	/**
	 * Function to validate and save the bottrProfile
	 */
	public function save_bottr_user( $input ) {

		$username = $input['username'];
		$response = wp_remote_get( 'https://embed.bottr.me/v1/username/' . $username );
		$body = json_decode( $response['body'], true );

		if( $body['result'] ) {

			$profile = $body['result']['profile'];

			$update_array = array(
				'username' => $username,
				'bottrId' => $profile['bottrId'],
				'name' => $profile['name'],
				'profilePicture' => $profile['profilePicture']
			);

			return $update_array;

		} else {

			add_settings_error( 'bottr_print_notice_identifier', esc_attr( 'settings_updated' ), __( $body['error']['message'] ), 'error' );
	        add_action( 'admin_notices', array( $this, 'print_notices' ) );
	        return null;
		}
	}

	public function print_notices() {
	    
	    settings_errors( 'bottr_print_notice_identifier' );
	
	}

	public function add_settings_page_link( $links ) {

		$settings_link = '<a href="options-general.php?page=wp_bottr_connect">' . __( 'Getting started' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
		
	}

}