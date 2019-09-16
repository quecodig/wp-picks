<?php
	// Limitar a Producto Único
	function pw_edd_one_item_checkout( $download_id, $options ) {
		if( edd_get_cart_quantity() >= 1 ) {
			edd_empty_cart();
		}
	}

	add_action( 'edd_pre_add_to_cart', 'pw_edd_one_item_checkout', 10, 2 );


	// Soporte Peso Colombiano
	function pippin_extra_edd_currencies( $currencies ) {
		$currencies['COP'] = __('Peso colombiano', 'apostadores_currency');
		return $currencies;
	}

	add_filter('edd_currencies', 'pippin_extra_edd_currencies');


	// Campos Checkout Obligatorios
	function pw_edd_purchase_form_required_fields( $required_fields ) {
    $required_fields['edd_last'] = array(   
        'error_id' => 'invalid_last_name',
        'error_message' => __( 'Please enter your last name.', 'edd' )
    );
    return $required_fields;
	}

	add_filter( 'edd_purchase_form_required_fields', 'pw_edd_purchase_form_required_fields' );


	// Cambiar SLUGS Predeterminados
	if ( ! defined( 'EDD_SLUG' ) ) {
			define( 'EDD_SLUG', 'producto' );
	}


	// Eliminar Acciones Rápidas Checkout
	function apostadores_edd_remove_payment_delete_action( $row_actions, $payment ) {
		if ( !current_user_can( 'delete_shop_payment' ) )
			unset( $row_actions['delete'] );

		return $row_actions;
	}

	add_filter( 'edd_payment_row_actions', 'apostadores_edd_remove_payment_delete_action', 10, 2 );


	// Personalizar Textos Easy Digital Downloads
	add_filter( 'gettext', 'apostadores_edd_text', 20, 3 );

	function apostadores_edd_text( $translated_text, $text, $domain ) {
		switch ( $translated_text ) {
			case 'Nombre del artículo' :
			$translated_text = __( 'Plan seleccionado', 'easy-digital-downloads' );
			break;
			case 'Precio del artículo' :
			$translated_text = __( 'Precio', 'easy-digital-downloads' );
			break;
		}
		return $translated_text;
	}