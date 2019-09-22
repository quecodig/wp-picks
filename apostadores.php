<?php
	/*
	Plugin Name: Apostadores Plugin
	Plugin URI: https://www.losapostadores.com/
	Description: Apostador versión Custom_post_type
	Version: 1.0
	Author: QuéCódigo, Cristian Álvarez
	Author URI: https://www.losapostadores.com
	License: GPL2
	Requires at least: 4.0
	Tested up to: 5.2.2
	Text Domain: apostadores
	Domain Path: /languages/
	*/

	defined( 'ABSPATH' ) or die( 'Error de acceso al plugin' );

	if( ! function_exists('add_filter')){
		header('Status: 403 Forbidden');
		header(' HTTP/1.1 403 Forbidden');
		exit();
	}

	//Init
	if( ! defined( 'APOSTADORES_VERSION' ) ){
		define("APOSTADORES_VERSION", "1.0");
	}
	// Define "FILE" del plugin
	if ( ! defined( 'APOSTADORES_PLUGIN_FILE' ) ) {
		define( 'APOSTADORES_PLUGIN_FILE', __FILE__ );
	}
	if( ! defined( 'APOSTADORES_PLUGIN_PATH' ) ){
		define('APOSTADORES_PLUGIN_PATH', realpath( plugin_dir_path( APOSTADORES_PLUGIN_FILE ) ) . '/' );
	}

	// Bail early if attempting to run on non-supported php versions.
	if ( version_compare( PHP_VERSION, '5.3', '<' ) ) {
		function apostadores_incompatible_admin_notice() {
			echo '<div class="error"><p>' . __( 'Aposradores requires PHP 5.3 (or higher) to function properly. Please upgrade PHP. The Plugin has been auto-deactivated.', 'apostadores' ) . '</p></div>';
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
		}
		function apostadores_deactivate_self() {
			deactivate_plugins( plugin_basename( APOSTADORES_PLUGIN_FILE ) );
		}
		add_action( 'admin_notices', 'apostadores_incompatible_admin_notice' );
		add_action( 'admin_init', 'apostadores_deactivate_self' );
		return;
	}

	add_action('plugins_loaded', 'apostadores_plugin_load_textdomain');

	function apostadores_plugin_load_textdomain() {
		$text_domain	= 'apostadores';
		$path_languages = basename(dirname(__FILE__)).'/languages/';
		load_plugin_textdomain($text_domain, false, $path_languages );
	}

	register_activation_hook( __FILE__ , 'apostadores_activate' );

	function apostadores_activate(){
		global $wpdb;
		$table_name = $wpdb->prefix . "apostadores";

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

	include APOSTADORES_PLUGIN_PATH."/core/custom_post.php";
	include APOSTADORES_PLUGIN_PATH."/core/edd.php";
	//include APOSTADORES_PLUGIN_PATH."/core/cookie.php";