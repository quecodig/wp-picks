<?php
	function apostadores_eventos_save_data($post_id){
		global $wpdb;

		// Comprobamos si se ha definido el nonce.
		if(!isset($_POST['apostadores_eventos_metabox_nonce'])){
			return $post_id;
		}
		$nonce = $_POST['apostadores_eventos_metabox_nonce']; // Verificamos que el nonce es válido.
		if(!wp_verify_nonce($nonce,'apostadores_eventos_metabox')){
			return $post_id;
		}
		// Si es un autoguardado nuestro formulario no se enviará, ya que aún no queremos hacer nada.
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return $post_id;
		}
		// Comprobamos los permisos de usuario.
		if($_POST['post_type'] == 'page'){
			if(!current_user_can('edit_page', $post_id))
				return $post_id;
		}else{
			if(!current_user_can('edit_post', $post_id))
				return $post_id;
		}
		// Vale, ya es seguro que guardemos los datos.
		// Saneamos lo introducido por el usuario.
		$event_state = sanitize_text_field( $_POST['event_state'] );
		$event_type = sanitize_text_field( $_POST['event_type'] );
		$event_depo = sanitize_text_field( $_POST['event_depo'] );
		$event_desc = esc_textarea( $_POST['event_desc'] );
		$event_price = sanitize_text_field( $_POST['event_price'] );
		$event_date = sanitize_text_field( $_POST['event_date'] );
		$event_aprx = sanitize_text_field( $_POST['event_aprx'] );
		$event_stake = sanitize_text_field( $_POST['event_stake'] );
		$event_anali = esc_textarea( $_POST['event_anali'] );

		//Actualizamos la base de datos al haber cambio de estado
		$table_name = $wpdb->prefix . "apostadores";
		$results = $wpdb->get_results( "SELECT * FROM {$table_name} WHERE post_id = '{$post_id}'", OBJECT );
		if($results){
			$wpdb->update(
				$table_name,
				array(
					'state' => $event_state,// string
				),
				array( 'post_id' =>  $post_id),
				array(
					'%s',// value1
				),
				array( '%d' )
			);
		}else{
			$wpdb->insert(
				$table_name,
				array(
					'post_id' => $post_id,
					'state' => $event_state,
					'stake' => $event_stake,
					'cuota' => $event_price,
					'time' => current_time( 'mysql' ),
				)
			);
		}

		// Si existen entradas antiguas las recuperamos
		$old_event_state = get_post_meta($post_id, 'event_state', true );
		$old_event_type = get_post_meta($post_id, 'event_type', true );
		$old_event_depo = get_post_meta($post_id, 'event_depo', true );
		$old_event_desc = get_post_meta($post_id, 'event_desc', true );
		$old_event_price = get_post_meta($post_id, 'event_price', true );
		$old_event_date = get_post_meta($post_id, 'event_date', true );
		$old_event_aprx = get_post_meta($post_id, 'event_aprx', true );
		$old_event_stake = get_post_meta($post_id, 'event_stake', true );
		$old_event_anali = get_post_meta($post_id, 'event_anali', true );

		// Actualizamos el campo meta en la base de datos.
		update_post_meta($post_id, 'event_state', $event_state, $old_event_state);
		update_post_meta($post_id, 'event_type', $event_type, $old_event_type);
		update_post_meta($post_id, 'event_depo', $event_depo, $old_event_depo);
		update_post_meta($post_id, 'event_desc', $event_desc, $old_event_desc);
		update_post_meta($post_id, 'event_price', $event_price, $old_event_price);
		update_post_meta($post_id, 'event_date', $event_date, $old_event_date);
		update_post_meta($post_id, 'event_aprx', $event_aprx, $old_event_aprx);
		update_post_meta($post_id, 'event_stake', $event_stake, $old_event_stake);
		update_post_meta($post_id, 'event_anali', $event_anali, $old_event_anali);
	}