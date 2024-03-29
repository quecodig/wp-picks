<?php
	// Limitar a Producto Único
	add_action( 'edd_pre_add_to_cart', 'mincrease_one_item_checkout', 10, 2 );
	function mincrease_one_item_checkout( $download_id, $options ) {
		if( edd_get_cart_quantity() >= 1 ) {
			edd_empty_cart();
		}
	}

	// Soporte Peso Colombiano
	add_filter('edd_currencies', 'mincrease_edd_currencies');
	function mincrease_edd_currencies( $currencies ) {
		$currencies['COP'] = __('Peso colombiano', 'mincrease_currency');
		return $currencies;
	}

	// Campos Checkout Obligatorios
	add_filter( 'edd_purchase_form_required_fields', 'mincrease_purchase_form_required_fields' );
	function mincrease_purchase_form_required_fields( $required_fields ) {
		$required_fields['edd_last'] = array(   
			'error_id' => 'invalid_last_name',
			'error_message' => __( 'Please enter your last name.', 'edd' )
		);
		return $required_fields;
	}

	// Cambiar SLUGS Predeterminados
	if ( ! defined( 'EDD_SLUG' ) ) {
		define( 'EDD_SLUG', 'producto' );
	}

	// Eliminar Campo Cupón de Descuento
	add_action( 'init', 'mincrease_edd_remove_discount_field' );
	function mincrease_edd_remove_discount_field() {
		remove_action( 'edd_checkout_form_top', 'edd_discount_field', -1 );
	}

	// Eliminar Acciones Rápidas Checkout
	add_filter( 'edd_payment_row_actions', 'mincrease_edd_remove_payment_delete_action', 10, 2 );
	function mincrease_edd_remove_payment_delete_action( $row_actions, $payment ) {
		if ( !current_user_can( 'delete_shop_payment' ) )
			unset( $row_actions['delete'] );

		return $row_actions;
	}

	// Personalizar Textos Easy Digital Downloads
	add_filter( 'gettext', 'mincrease_edd_text', 20, 3 );
	function mincrease_edd_text( $translated_text, $text, $domain ) {
		switch ( $translated_text ) {
			case 'Nombre del artículo' :
			$translated_text = __( 'Plan seleccionado', 'easy-digital-downloads' );
			break;
			case 'Precio del artículo' :
			$translated_text = __( 'Precio', 'easy-digital-downloads' );
			break;
			case 'Información personal' :
			$translated_text = __( 'Datos básicos', 'easy-digital-downloads' );
			break;
			case 'Dirección de correo electrónico' :
			$translated_text = __( 'Correo electrónico', 'easy-digital-downloads' );
			break;
		}
		return $translated_text;
	}

	// Icono de Pago Personalizado
	//add_filter( 'edd_accepted_payment_icons', 'mincrease_edd_payment_icon' );
	//function mincrease_edd_payment_icon( $icons = array() ) {
	//	$icons['https://static.platzi.com/media/flags/CO.png'] = 'Bancolombia';
	//	return $icons;
	//}