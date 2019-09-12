<?php
    // Load Frontend Scripts + Styles
	function inv_cookie_notice_styles() {
		wp_register_style( 'cookie-notice-front-styles', plugins_url('assets/css/inv-cookie-notice.css', APOSTADORES_PLUGIN_FILE) );
		wp_enqueue_style( 'cookie-notice-front-styles' );
		wp_register_style( 'cookie-notice-front-styles-alignment', plugins_url('assets/css/inv-cookie-notice-right.css', APOSTADORES_PLUGIN_FILE) );
		wp_enqueue_style( 'cookie-notice-front-styles-alignment' );
		wp_register_script( 'js-cookie', plugins_url('assets/js/js.cookie.js', APOSTADORES_PLUGIN_FILE), array('jquery') );
		wp_enqueue_script( 'js-cookie' );
		// Register the script
		wp_register_script( 'cookienotice', plugins_url('assets/js/inv-cookie-notice.js', APOSTADORES_PLUGIN_FILE), array('jquery') );
		// Localize the script with new data
		$invcookienoticeoptions = array(
			'domain' => 'Los Apostadores',
			'privacylink' => 'Link',
			'privacylinktext' => 'Politicas de Privacidad',
			'cookietext' => 'utiliza cookies para mejorar su experiencia de usuario.',
			'cookietextcolor' => '#FFFFFF',
			'buttontext' => 'Aceptar',
			'buttontextcolor' => '#FFFFFF',
			'buttoncolor' => '#07A6D0',
			'buttonradius' => '5px',
			'layerradius' => '5px 5px 5px 5px',
			'backgroundcolor' => '#222222',
			'backgroundcolor1' => '#222222',
			'backgroundcolor2' => '#222222',
			'backgroundcolor3' => '#222222',
			'cookieduration' => '365',
		);
		wp_localize_script( 'cookienotice', 'invcookienoticeoptions', $invcookienoticeoptions );
	        // Enqueued script with localized data.
		wp_enqueue_script( 'cookienotice' );
	}
	add_action( 'wp_enqueue_scripts', 'inv_cookie_notice_styles');