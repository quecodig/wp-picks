<?php
	// Register Custom Post Type
	add_action( 'init', 'mincrease_post', 0 );

	function mincrease_post() {

		$labels = array(
			'name'                  => _x( 'Apuestas', 'Post Type General Name', 'mincrease' ),
			'singular_name'         => _x( 'Apuesta', 'Post Type Singular Name', 'mincrease' ),
			'menu_name'             => __( 'Apuestas', 'mincrease' ),
			'name_admin_bar'        => __( 'Apuestas', 'mincrease' ),
			'archives'              => __( 'Todas las Apuestas', 'mincrease' ),
			'attributes'            => __( 'Item Attributes', 'mincrease' ),
			'parent_item_colon'     => __( 'Parent Item:', 'mincrease' ),
			'all_items'             => __( 'Todas las apuestas', 'mincrease' ),
			'add_new_item'          => __( 'Añadir nueva apuesta', 'mincrease' ),
			'add_new'               => __( 'Añadir nuevo', 'mincrease' ),
			'new_item'              => __( 'Nueva apuesta', 'mincrease' ),
			'edit_item'             => __( 'Editar apuesta', 'mincrease' ),
			'update_item'           => __( 'Actualizar apuesta', 'mincrease' ),
			'view_item'             => __( 'Ver apuesta', 'mincrease' ),
			'view_items'            => __( 'Ver apuestas', 'mincrease' ),
			'search_items'          => __( 'Buscar apuesta', 'mincrease' ),
			'not_found'             => __( 'No encontrado', 'mincrease' ),
			'not_found_in_trash'    => __( 'No hay apuestas en papelera', 'mincrease' ),
			'featured_image'        => __( 'Imagen destacada', 'mincrease' ),
			'set_featured_image'    => __( 'Establecer imagen destacada', 'mincrease' ),
			'remove_featured_image' => __( 'Eliminar imagen destacada', 'mincrease' ),
			'use_featured_image'    => __( 'Usar como imagen destacada', 'mincrease' ),
			'insert_into_item'      => __( 'Insertar en elemento', 'mincrease' ),
			'uploaded_to_this_item' => __( 'Subido a este artículo', 'mincrease' ),
			'items_list'            => __( 'Lista de apuestas', 'mincrease' ),
			'items_list_navigation' => __( 'Lista de artículos de navegación', 'mincrease' ),
			'filter_items_list'     => __( 'Filtrar apuesta en la lista', 'mincrease' ),
		);
		$rewrite = array(
			'slug'                  => 'pronosticos',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Apuesta', 'mincrease' ),
			'description'           => __( 'Apuestas deportivas', 'mincrease' ),
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
		register_post_type( 'mincrease', $args );
	}

	add_action( 'init', 'mincrease_taxonomies', 0 );

	function mincrease_taxonomies() {
		// Añadimos nueva taxonomía y la hacemos jerárquica (como las categorías por defecto)
		$labels = array(
			'name' => _x('Deportes', 'taxonomy general name' ),
			'singular_name' => _x( 'Deporte', 'taxonomy singular name' ),
			'search_items' =>  __( 'Buscar por deporte' ),
			'all_items' => __( 'Todos los deportes' ),
			'parent_item' => __( 'Deporte padre' ),
			'parent_item_colon' => __( 'Deporte padre:' ),
			'edit_item' => __( 'Editar deporte' ),
			'update_item' => __( 'Actualizar deporte' ),
			'add_new_item' => __( 'Añadir nuevo deporte' ),
			'new_item_name' => __( 'Nombre del nuevo deporte' ),
		); 
		register_taxonomy( 'deporte', array( 'mincrease' ), array(
			'hierarchical' => true,
			'labels' => $labels, /* ADVERTENCIA: Aquí es donde se utiliza la variable $labels */
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'deporte' ),
		));
		// Añado otra taxonomía, esta vez no es jerárquica, como las etiquetas.
		$labels = array(
			'name' => _x('Equipos', 'taxonomy general name' ),
			'singular_name' => _x( 'Equipos/Jugadores', 'taxonomy singular name' ),
			'search_items' =>  __( 'Buscar Equipos/Jugadores' ),
			'popular_items' => __( 'Equipos/Jugadores populares' ),
			'all_items' => __( 'Todos los Equipos/Jugadores' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Editar Equipo/Jugador' ),
			'update_item' => __( 'Actualizar Equipo/Jugador' ),
			'add_new_item' => __( 'Añadir nuevo Equipo/Jugador' ),
			'new_item_name' => __( 'Nombre del nuevo Equipo/Jugador' ),
			'separate_items_with_commas' => __( 'Separar Equipos/Jugadores por comas' ),
			'add_or_remove_items' => __( 'Añadir o eliminar Equipos/Jugadores' ),
			'choose_from_most_used' => __( 'Escoger entre los Equipos/Jugadores más utilizados' )
		);

		register_taxonomy( 'equipo', 'mincrease', array(
			'hierarchical' => false,
			'labels' => $labels, /* ADVERTENCIA: Aquí es donde se utiliza la variable $labels */
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'equipo' ),
		));
	}

	// Añadimos los metaboxes
	add_action( 'add_meta_boxes', 'mincrease_metabox' );
	function mincrease_metabox() {
		add_meta_box( 'events-metabox', 'Boletín', 'mincrease_eventos', 'mincrease', 'normal', 'high' );
	}

	function mincrease_eventos($post) {
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
		wp_nonce_field( 'mincrease_eventos_metabox', 'mincrease_eventos_metabox_nonce' );
		include MINCREASE_PLUGIN_PATH."/admin/custom_post.php";
	}

	include MINCREASE_PLUGIN_PATH."/core/save_post.php";
	add_action( 'save_post', 'mincrease_eventos_save_data' );

	add_filter( 'manage_mincrease_posts_columns', 'mincrease_custom_edit_eventos_columns' );
	add_action( 'manage_mincrease_posts_custom_column' , 'mincrease_eventos_column', 10, 2 );

	function mincrease_custom_edit_eventos_columns($columns) {
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

	function mincrease_eventos_column( $column, $post_id ) {
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