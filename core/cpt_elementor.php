<?php
	// Check for required Elementor version
	if ( ! version_compare( ELEMENTOR_VERSION, '2.0.0', '>=' ) ) {
		add_action( 'admin_notices', 'mincrease_notice_minimum_elementor_version' );
		return;
	}

	function mincrease_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'cpt-magic-tool' ),
			'<strong>' . esc_html__( 'MindFY Increase', 'cpt-magic-tool' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'cpt-magic-tool' ) . '</strong>',
			'2.0.0'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	add_action( 'elementor/widgets/widgets_registered', 'mincrease_widget_init');

	function mincrease_widget_init(){
		include MINCREASE_PLUGIN_PATH."/core/widget_elementor.php";
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_CPT_Widget() );
	}