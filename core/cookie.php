<?php
    // Load Frontend Scripts + Styles
	if(!class_exists('mincrease_cookie_notice_styles')){
		function mincrease_cookie_notice_styles() {
			wp_register_style( 'cookie-notice-front-styles', plugins_url('assets/css/inv-cookie-notice.css', MINCREASE_PLUGIN_FILE) );
			wp_enqueue_style( 'cookie-notice-front-styles' );
			wp_register_style( 'cookie-notice-front-styles-alignment', plugins_url('assets/css/inv-cookie-notice-left.css', MINCREASE_PLUGIN_FILE) );
			wp_enqueue_style( 'cookie-notice-front-styles-alignment' );
			wp_register_script( 'js-cookie', plugins_url('assets/js/js.cookie.js', MINCREASE_PLUGIN_FILE), array('jquery') );
			wp_enqueue_script( 'js-cookie' );
			// Register the script
			wp_register_script( 'cookienotice', plugins_url('assets/js/inv-cookie-notice.js', MINCREASE_PLUGIN_FILE), array('jquery') );
			// Localize the script with new data
			$privacy = get_post(get_option( 'wp_page_for_privacy_policy'));
			$invcookienoticeoptions = array(
				'domain' => 'MindFY Increase',
				'privacylink' => $privacy->guid,
				'privacylinktext' => __('Read more', 'mincrease'),
				'cookietext' => __('use cookies to improve your experience. If you continue to use the website, you accept our terms and conditions.', 'mincrease'),
				'cookietextcolor' => '#FFFFFF',
				'buttontext' => __('Accept', 'mincrease'),
				'buttontextcolor' => '#FFFFFF',
				'buttoncolor' => '#07A6D0',
				'buttonradius' => '5px',
				'layerradius' => '5px 5px 5px 5px',
				'backgroundcolor' => '#222222',
				'backgroundcolor1' => '#222222',
				'backgroundcolor2' => '#222222',
				'backgroundcolor3' => '#222222',
				'cookieduration' => '90',
			);
			wp_localize_script( 'cookienotice', 'invcookienoticeoptions', $invcookienoticeoptions );
			// Enqueued script with localized data.
			wp_enqueue_script( 'cookienotice' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'mincrease_cookie_notice_styles');