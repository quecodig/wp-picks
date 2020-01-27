<?php
	// Register Custom Post Type
	add_action( 'init', 'apostadores_post', 0 );

	function apostadores_post() {

		$labels = array(
			'name'                  => _x( 'Apuestas', 'Post Type General Name', 'quecodig_apostador' ),
			'singular_name'         => _x( 'Apuesta', 'Post Type Singular Name', 'quecodig_apostador' ),
			'menu_name'             => __( 'Apuestas', 'quecodig_apostador' ),
			'name_admin_bar'        => __( 'Apuestas', 'quecodig_apostador' ),
			'archives'              => __( 'Todas las Apuestas', 'quecodig_apostador' ),
			'attributes'            => __( 'Item Attributes', 'quecodig_apostador' ),
			'parent_item_colon'     => __( 'Parent Item:', 'quecodig_apostador' ),
			'all_items'             => __( 'Todas las apuestas', 'quecodig_apostador' ),
			'add_new_item'          => __( 'Añadir nueva apuesta', 'quecodig_apostador' ),
			'add_new'               => __( 'Añadir nuevo', 'quecodig_apostador' ),
			'new_item'              => __( 'Nueva apuesta', 'quecodig_apostador' ),
			'edit_item'             => __( 'Editar apuesta', 'quecodig_apostador' ),
			'update_item'           => __( 'Actualizar apuesta', 'quecodig_apostador' ),
			'view_item'             => __( 'Ver apuesta', 'quecodig_apostador' ),
			'view_items'            => __( 'Ver apuestas', 'quecodig_apostador' ),
			'search_items'          => __( 'Buscar apuesta', 'quecodig_apostador' ),
			'not_found'             => __( 'No encontrado', 'quecodig_apostador' ),
			'not_found_in_trash'    => __( 'No hay apuestas en papelera', 'quecodig_apostador' ),
			'featured_image'        => __( 'Imagen destacada', 'quecodig_apostador' ),
			'set_featured_image'    => __( 'Establecer imagen destacada', 'quecodig_apostador' ),
			'remove_featured_image' => __( 'Eliminar imagen destacada', 'quecodig_apostador' ),
			'use_featured_image'    => __( 'Usar como imagen destacada', 'quecodig_apostador' ),
			'insert_into_item'      => __( 'Insertar en elemento', 'quecodig_apostador' ),
			'uploaded_to_this_item' => __( 'Subido a este artículo', 'quecodig_apostador' ),
			'items_list'            => __( 'Lista de apuestas', 'quecodig_apostador' ),
			'items_list_navigation' => __( 'Lista de artículos de navegación', 'quecodig_apostador' ),
			'filter_items_list'     => __( 'Filtrar apuesta en la lista', 'quecodig_apostador' ),
		);
		$rewrite = array(
			'slug'                  => 'pronosticos',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Apuesta', 'quecodig_apostador' ),
			'description'           => __( 'Apuestas deportivas', 'quecodig_apostador' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail'),
			'taxonomies'            => array( 'apuesta', ' post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-welcome-add-page',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',
		);
		register_post_type( 'apostadores', $args );

	}

	// Añadimos los metaboxes
	add_action( 'add_meta_boxes', 'apostadores_metabox' );
	function apostadores_metabox() {
		add_meta_box( 'events-metabox', 'Boletín', 'apostadores_eventos', 'apostadores', 'normal', 'high' );
	}

	function apostadores_eventos($post) {
		//si existen se recuperan los valores de los metadatos
		$event_state = get_post_meta( $post->ID, 'event_state', true );
		$event_type = get_post_meta( $post->ID, 'event_type', true );
		$event_depo = get_post_meta( $post->ID, 'event_depo', true );
		$event_desc = get_post_meta( $post->ID, 'event_desc', true );
		$event_price = get_post_meta( $post->ID, 'event_price', true );
		$event_date = get_post_meta( $post->ID, 'event_date', true );
		$event_aprx = get_post_meta( $post->ID, 'event_aprx', true );
		$event_stake = get_post_meta( $post->ID, 'event_stake', true );
		$event_anali = get_post_meta( $post->ID, 'event_anali', true );
		// Se añade un campo nonce para probarlo más adelante cuando validemos
		wp_nonce_field( 'apostadores_eventos_metabox', 'apostadores_eventos_metabox_nonce' );
		include APOSTADORES_PLUGIN_PATH."/admin/custom_post.php";
	}

	include APOSTADORES_PLUGIN_PATH."/core/save_post.php";
	add_action( 'save_post', 'apostadores_eventos_save_data' );

	add_filter( 'manage_apostadores_posts_columns', 'apostadores_custom_edit_eventos_columns' );
	add_action( 'manage_apostadores_posts_custom_column' , 'apostadores_eventos_column', 10, 2 );

	function apostadores_custom_edit_eventos_columns($columns) {
		$new = array();
		foreach($columns as $key => $value) {
			$new[$key] = $value; // se imprimen las columnas en el nuevo arreglo
			if($key == 'title') { // se busca una columna que ya exista
				$new['boleto'] = __( 'Boleto');
				$new['state'] = __( 'Estado');
				$new['stake'] = __( 'Stake');
			}
		}

		return $new;
	}

	function apostadores_eventos_column( $column, $post_id ) {
		switch ( $column ) {

			case 'boleto' :
			$post_thumbnail_id = get_post_thumbnail_id($post_id);
			if ($post_thumbnail_id) {
				$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, array(1024,1024));
				if($post_thumbnail_img[0]){
					echo '<img id="myImg'.$post_thumbnail_id.'" style="max-width:100px;" src="' . $post_thumbnail_img[0] . '" alt="<?php echo get_post_meta( $post_id , \'event_name\' , true ); ?>"/>';
				}
			}
			?>
			<!-- The Modal -->
			<div id="myModal<?php echo $post_thumbnail_id; ?>" class="modal">

				<!-- The Close Button -->
				<span class="close<?php echo $post_thumbnail_id; ?>">&times;</span>

				<!-- Modal Content (The Image) -->
				<img class="modal-content" id="img<?php echo $post_thumbnail_id; ?>">

				<!-- Modal Caption (Image Text) -->
				<div id="caption<?php echo $post_thumbnail_id; ?>"></div>
			</div>
			<style>
				/* Style the Image Used to Trigger the Modal */
				#myImg<?php echo $post_thumbnail_id; ?> {
					border-radius: 5px;
					cursor: pointer;
					transition: 0.3s;
				}

				#myImg<?php echo $post_thumbnail_id; ?>:hover {opacity: 0.7;}

				/* The Modal (background) */
				.modal {
					display: none; /* Hidden by default */
					position: fixed; /* Stay in place */
					z-index: 20; /* Sit on top */
					padding-top: 100px; /* Location of the box */
					left: 0;
					top: 0;
					width: 100%; /* Full width */
					height: 100%; /* Full height */
					overflow: auto; /* Enable scroll if needed */
					background-color: rgb(0,0,0); /* Fallback color */
					background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
				}

				/* Modal Content (Image) */
				.modal-content {
					margin: auto;
					display: block;
					width: 80%;
					max-width: 700px;
				}

				/* Caption of Modal Image (Image Text) - Same Width as the Image */
				#caption<?php echo $post_thumbnail_id; ?> {
					margin: auto;
					display: block;
					width: 80%;
					max-width: 700px;
					text-align: center;
					color: #ccc;
					padding: 10px 0;
					height: 150px;
				}

				/* Add Animation - Zoom in the Modal */
				.modal-content, #caption<?php echo $post_thumbnail_id; ?> {
					animation-name: zoom;
					animation-duration: 0.6s;
				}

				@keyframes zoom {
					from {transform:scale(0)}
					to {transform:scale(1)}
				}

				/* The Close Button */
				.close<?php echo $post_thumbnail_id; ?> {
					position: absolute;
					top: 55px;
					right: 35px;
					color: #f1f1f1;
					font-size: 40px;
					font-weight: bold;
					transition: 0.3s;
				}

				.close<?php echo $post_thumbnail_id; ?>:hover,
				.close<?php echo $post_thumbnail_id; ?>:focus {
					color: #bbb;
					text-decoration: none;
					cursor: pointer;
				}

				/* 100% Image Width on Smaller Screens */
				@media only screen and (max-width: 700px){
					.modal-content {
						width: 100%;
					}
				} 
			</style>
			<script>
				// Get the modal
				var modal<?php echo $post_thumbnail_id; ?> = document.getElementById("myModal<?php echo $post_thumbnail_id; ?>");

				// Get the image and insert it inside the modal - use its "alt" text as a caption
				var img<?php echo $post_thumbnail_id; ?> = document.getElementById("myImg<?php echo $post_thumbnail_id; ?>");
				var modalImg<?php echo $post_thumbnail_id; ?> = document.getElementById("img<?php echo $post_thumbnail_id; ?>");
				var captionText<?php echo $post_thumbnail_id; ?> = document.getElementById("caption<?php echo $post_thumbnail_id; ?>");
				img<?php echo $post_thumbnail_id; ?>.onclick = function(){
					modal<?php echo $post_thumbnail_id; ?>.style.display = "block";
					modalImg<?php echo $post_thumbnail_id; ?>.src = this.src;
					captionText<?php echo $post_thumbnail_id; ?>.innerHTML = this.alt;
				}

				// Get the <span> element that closes the modal
				var span<?php echo $post_thumbnail_id; ?> = document.getElementsByClassName("close<?php echo $post_thumbnail_id; ?>")[0];

				// When the user clicks on <span> (x), close the modal
				span<?php echo $post_thumbnail_id; ?>.onclick = function() {
					modal<?php echo $post_thumbnail_id; ?>.style.display = "none";
				}
			</script>
			<?php
			break;
			case 'state' :
			$state = get_post_meta( $post_id , 'event_state' , true );
			if($state === "0"){
				echo "<div style='background:#f8dda7;display: inline-flex;line-height: 2.5em;border-radius: 4px;margin: -.25em 0;'>";
				$code = "En espera";
			}
			else if($state === "1"){
				echo "<div style='background:#eba3a3;display: inline-flex;line-height: 2.5em;border-radius: 4px;margin: -.25em 0;'>";
				$code = "Perdida";
			}
			else if($state === "2"){
				echo "<div style='background:#e5e5e5;display: inline-flex;line-height: 2.5em;border-radius: 4px;margin: -.25em 0;'>";
				$code = "Reembolsado";
			}
			else if($state === "3"){
				echo "<div style='background:#20b422;display: inline-flex;line-height: 2.5em;border-radius: 4px;margin: -.25em 0;'>";
				$code = "Ganada";
			}
			else{
				echo "<div style='background:#e4e4e4;display: inline-flex;line-height: 2.5em;border-radius: 4px;margin: -.25em 0;'>";
				$code = "No hay estado";
			}
			echo "<span style='margin: 0 1em;color:#FFFFFF;'>".$code."</span></div>";
			break;

			case 'stake' :
			echo "<div style='background:#c8d7e1;display: inline-flex;line-height: 2.5em;border-radius: 4px;margin: -.25em 0;'><span style='margin: 0 1em;color:#FFFFFF;'>".get_post_meta($post_id , 'event_stake' , true )."</span></div>";
			break;

		}
	}