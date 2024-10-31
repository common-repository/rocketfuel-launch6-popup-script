<?php
/**
 * Plugin Name: Rocketfuel - Launch6 Popup Script Include
 * Plugin URI: http://www.launch6.com
 * Description: This plugin allows you to insert javascript for your Launch6 popups.
 * Version: 1.0.2
 * Author: Launch6
 * Author URI: http://www.launch6.com
 *
 * @package WordPress
 */

define( 'L6_PLUGIN_FILE', __FILE__ );
define( 'L6_PLUGIN_DIR', dirname( __FILE__ ) . '/' );
define( 'L6_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

/**
 * Outputs footer script (HTML)
 */
function l6_footer_scripts() {
	echo wp_kses( get_option( 'l6-footer-script' ), array(
	    'script' => array(
	    	'src' => array(),
	    	'async' => array(),
	    ),
	));
}
add_action( 'wp_footer', 'l6_footer_scripts' );

/**
 * Saves footer script (HTML)
 */
function l6_ins_scr() {
	if (
	    isset( $_POST['sub'] ) && // Input var okay.
	    isset( $_POST['nonce'] ) && // Input var okay.
	    isset( $_POST['l6-footer'] ) && // Input var okay.
	    wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'l6_nonce_admin_save' ) // Input var okay.
	) {
		add_option( 'l6-footer-script', wp_kses( wp_unslash( $_POST['l6-footer'] ), array( // Input var okay.
		    'script' => array(
		    	'src' => array(),
		    	'async' => array(),
		    ),
		)), '', 'yes' );

		$ft_scr = wp_kses( get_option( 'l6-footer-script' ), array(
		    'script' => array(
		    	'src' => array(),
		    	'async' => array(),
		    ),
		) );

		if ( '' !== $ft_scr || null === $ft_scr ) {
			update_option( 'l6-footer-script', wp_kses( wp_unslash( $_POST['l6-footer'] ), array( // Input var okay.
			    'script' => array(
			    	'src' => array(),
			    	'async' => array(),
			    ),
			)));
		}
	}
}

/**
 * Main Plugin Page
 *
 * @package WordPress
 */
class L6_Popup_Script_Page {

	/**
	 * Constructor
	 */
	function __construct() {
		// setup hooks.
		$this->setup_hooks();
	}

	/**
	 * Registers all the hooks
	 */
	private function setup_hooks() {

		// Actions used globally throughout WP Admin.
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
	}

	/**
	 * Registers admin menu
	 */
	function admin_menu() {
		$settings_page = add_menu_page(
	        'Launch6',
	        'Launch6',
	        'publish_posts',
	        'launch6-options',
	        array(
				$this,
				'settings_page',
			),
	        L6_PLUGIN_URL . 'assets/img/icon.png'
	    );
	}

	/**
	 * Load scripts and stylesheet on MailChimp for WP Admin pages
	 */
	public function load_assets() {
		if ( isset( $_GET['page'] ) && strpos( sanitize_text_field( wp_unslash( $_GET['page'] ) ), 'launch6-options' ) === 0 ) { // Input var okay.

			/*
                L6 Options Page
			*/

			// Styles go here.
			wp_enqueue_style( 'l6-admin-styles', L6_PLUGIN_URL . 'assets/css/admin-styles.css' );
		}
	}

	/**
	 * Renders settings page
	 */
	function settings_page() {
		l6_ins_scr();
		require L6_PLUGIN_DIR . 'admin.options.form.php';
	}
}

new L6_Popup_Script_Page;
