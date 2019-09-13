<?php
	// Redirección Automática Hacia Zona de Pago
	add_filter ('woocommerce_add_to_cart_redirect', 'apostadores_to_checkout');

	function apostadores_to_checkout() {
		global $woocommerce;
		$checkout_url = wc_get_checkout_url();
		return $checkout_url;
	}

	// Limitar a Producto Único
	add_filter( 'woocommerce_add_cart_item_data', 'apostadores_one_item_cart', 10, 1 );
	function apostadores_one_item_cart( $cartItemData ) {
		wc_empty_cart();
		return $cartItemData;
	}

	// Eliminar Campos Adicionales de WooCommerce en la Zona de Pago
	add_filter( 'woocommerce_checkout_fields' , 'apostadores_checkout_fields' );

	function apostadores_checkout_fields( $fields ) {
		unset($fields['billing']['billing_address_1']);
		unset($fields['billing']['billing_city']);
		unset($fields['billing']['billing_postcode']);
		unset($fields['billing']['billing_country']);
		unset($fields['billing']['billing_state']);
		return $fields;
	}

	add_filter('woocommerce_enable_order_notes_field', '__return_false');

	//	Personalizar Métodos de Pago
	add_filter ('woocommerce_gateway_icon', function ($contenido, $id) {
		if ('paypal' == $id)
			return '<img src="'.plugins_url('assets/img/paypal.png', APOSTADORES_PLUGIN_FILE ).'" width="51"/>';
		return $contenido;
	}, 10, 2);

	add_filter ('woocommerce_gateway_icon', function ($contenido, $id) {
		if ('epayco' == $id)
			return '<img src="'.plugins_url('assets/img/epayco.png', APOSTADORES_PLUGIN_FILE ).'" width="51"/>';
		return $contenido;
	}, 10, 2);

	add_filter ('woocommerce_gateway_icon', function ($contenido, $id) {
		if ('bacs' == $id)
			return '<img src="'.plugins_url('assets/img/bancolombia.png', APOSTADORES_PLUGIN_FILE ).'" width="51"/><img src="'.plugins_url('assets/img/davivienda.png', APOSTADORES_PLUGIN_FILE ).'" width="51"/>';
		return $contenido;
	}, 10, 2);


	// Personalizar Textos WooCommerce
	add_filter( 'gettext', 'apostadores_woocommerce_text', 20, 3 );

	function apostadores_woocommerce_text( $translated_text, $text, $domain ) {
		switch ( $translated_text ) {
			case 'Detalles de facturación' :
			$translated_text = __( 'Datos básicos', 'woocommerce' );
			break;
			case 'Apellidos' :
			$translated_text = __( 'Apellido', 'woocommerce' );
			break;
			case 'Crear una contraseña para la cuenta' :
			$translated_text = __( 'Contraseña', 'woocommerce' );
			break;
			case 'Tu pedido' :
			$translated_text = __( 'Finalizar compra', 'woocommerce' );
			break;
			case 'Producto' :
			$translated_text = __( 'Plan seleccionado', 'woocommerce' );
			break;
			case 'Ir a PayPal' :
			$translated_text = __( 'Pagar con PayPal', 'woocommerce' );
			break;
			case 'Realizar el pedido' :
			$translated_text = __( 'Continuar Pago', 'woocommerce' );
			break;
			case 'términos y condiciones' :
			$translated_text = __( 'Términos y Condiciones', 'woocommerce' );
			break;
			case 'política de privacidad' :
			$translated_text = __( 'Políticas de Privacidad', 'woocommerce' );
			break;
		}
		return $translated_text;
	}

	// Add a second password field to the checkout page.	
	function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
		global $woocommerce;
		extract( $_POST );
		if ( strcmp( $password, $password2 ) !== 0 ) {
			return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
		}
		return $reg_errors;
	}
	add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);

	// ----- add a confirm password fields match on the registration page
	function wc_register_form_password_repeat() {
		?>
		<p class="form-row form-row-wide">
			<label for="reg_password2"><?php _e( 'Password Repeat', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
		</p>
		<?php
	}
	add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );

	// ----- Validate confirm password field match to the checkout page
	function lit_woocommerce_confirm_password_validation( $posted ) {
		$checkout = WC()->checkout;
		if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
			if ( strcmp( $posted['account_password'], $posted['account_confirm_password'] ) !== 0 ) {
				wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' ); 
			}
		}
	}
	add_action( 'woocommerce_after_checkout_validation', 'lit_woocommerce_confirm_password_validation', 10, 2 );

	// ----- Add a confirm password field to the checkout page
	function lit_woocommerce_confirm_password_checkout( $checkout ) {
		if ( get_option( 'woocommerce_registration_generate_password' ) == 'no' ) {

			$fields = $checkout->get_checkout_fields();

			$fields['account']['account_confirm_password'] = array(
				'type'              => 'password',
				'label'             => __( 'Confirm password', 'woocommerce' ),
				'required'          => true,
				'placeholder'       => _x( 'Confirm Password', 'placeholder', 'woocommerce' )
			);

			$checkout->__set( 'checkout_fields', $fields );
		}
	}
	add_action( 'woocommerce_checkout_init', 'lit_woocommerce_confirm_password_checkout', 10, 1 );