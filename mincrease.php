<?php
	/*
	Plugin Name: MindFY Increase
	Plugin URI: https://www.mindfy.co/
	Description: MindFY Increase functions app
	Version: 1.0
	Author: QuéCódigo, Cristian Álvarez
	Author URI: https://www.mindfy.co
	License: GPL2
	Requires at least: 4.0
	Tested up to: 5.2.2
	Text Domain: mincrease
	Domain Path: /languages/
	*/

	defined( 'ABSPATH' ) or die( 'Error de acceso al plugin' );

	if( ! function_exists('add_filter')){
		header('Status: 403 Forbidden');
		header(' HTTP/1.1 403 Forbidden');
		exit();
	}

	//Init
	if( ! defined( 'MINCREASE_VERSION' ) ){
		define("MINCREASE_VERSION", "1.0");
	}
	// Define "FILE" del plugin
	if ( ! defined( 'MINCREASE_PLUGIN_FILE' ) ) {
		define( 'MINCREASE_PLUGIN_FILE', __FILE__ );
	}
	if( ! defined( 'MINCREASE_PLUGIN_PATH' ) ){
		define('MINCREASE_PLUGIN_PATH', realpath( plugin_dir_path( MINCREASE_PLUGIN_FILE ) ) . '/' );
	}

	// Bail early if attempting to run on non-supported php versions.
	if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
		function mincrease_incompatible_admin_notice() {
			echo '<div class="error"><p>' . __( 'MindFY Increase requires PHP 5.3 (or higher) to function properly. Please upgrade PHP. The Plugin has been auto-deactivated.', 'mincrease' ) . '</p></div>';
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
		function mincrease_deactivate_self() {
			deactivate_plugins( plugin_basename( MINCREASE_PLUGIN_FILE ) );
		}
		add_action( 'admin_notices', 'mincrease_incompatible_admin_notice' );
		add_action( 'admin_init', 'mincrease_deactivate_self' );
		return;
	}

	add_action('plugins_loaded', 'mincrease_plugin_load_textdomain');

	function mincrease_plugin_load_textdomain() {
		$text_domain	= 'mincrease';
		$path_languages = basename(dirname(__FILE__)).'/languages/';
		load_plugin_textdomain($text_domain, false, $path_languages );
	}

	register_activation_hook( __FILE__ , 'mincrease_activate' );

	function mincrease_activate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "mincrease";

		$sql = "CREATE TABLE {$table_name} (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			post_id varchar(55) DEFAULT '' NOT NULL,
			state varchar(55) DEFAULT '' NOT NULL,
			cuota varchar(55) DEFAULT '' NOT NULL,
			stake varchar(55) DEFAULT '' NOT NULL,
			PRIMARY KEY (id)
		);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}

	include MINCREASE_PLUGIN_PATH."/core/custom_post.php";
	//include MINCREASE_PLUGIN_PATH."/core/edd.php";
	include MINCREASE_PLUGIN_PATH."/core/cookie.php";

	// Check if Elementor installed and activated
	if ( did_action( 'elementor/loaded' ) ) {
		include MINCREASE_PLUGIN_PATH."/core/cpt_elementor.php";
	}