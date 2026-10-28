<?php
/*ocultar version de wordpress*/
remove_action('wp_head', 'wp_generator');

/*function no_wordpress_errors(){ return 'Ups, ha ocurrido algo y no puedes acceder'; } add_filter( 'login_errors', 'no_wordpress_errors' );*/
include('custom-shortcodes.php');
function enqueue_styles_child_theme() {

	$parent_style = 'parent-style';
	$child_style  = 'child-style';

	wp_enqueue_style( $parent_style,
				get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( $child_style,
				get_stylesheet_directory_uri() . '/style.css',
				array( $parent_style ),
				wp_get_theme()->get('Version')
				);
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles_child_theme' );

add_action( 'init', 'create_localizacion_taxonomies', 0 );  

function create_localizacion_taxonomies() {
 
  $labels = array(
    'name'             => _x( 'Localidades', 'taxonomy general name' ),
    'singular_name'    => _x( 'Localidad', 'taxonomy singular name' ),
    'search_items'     =>  __( '' ),
    'all_items'        => __( '' ),
    'parent_item'      =>__( 'Localidad al que Pertenece' ),
    'parent_item_colon'=> __( null ),
    'edit_item'        => __( 'Editar Localidad' ),
    'update_item'      => __( '' ),
    'add_new_item'     => __( 'Nueva Localidad' ),
    'new_item_name'    => __( '' ),
      
  );
   register_taxonomy( 'localidad', array( 'directorio' ), 
    array(
    'hierarchical'       => false,
    'labels'             => $labels,
    'show_ui'            => true,
    'query_var'          => true,
    'rewrite'       =>  array('slug' => 'directorios', 'with_front' => false),   
  ));
 
}


add_action( 'init', 'create_post_types', 0 );
function create_post_types() {
   //Post Type Productos y servicios
    register_post_type( 'portafolio',
      array(
        'labels' => array('name' => __( 'Portafolios' ),'singular_name' => __( 'Portafolio' )),
        'public' => true,
        'rewrite' => array('slug' => 'portafolio','with_front' => false ),
        'show_in_rest' => true,
        'has_archive' => false,
        'taxonomies' => array('post_tag', 'category'),
        'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'excerpt') )  );
     // Post Type Canales de servicios
    register_post_type( 'directorio',
      array( 'labels' => array( 'name' => __( 'Directorios' ),'singular_name' => __( 'Directorio' )),
        'query_var' => true, 
        'public' => true,
        'rewrite' => array('slug' => 'directorio', 'with_front' => false), 
        'show_in_rest' => true, 
        'hierarchical'       => true,
        'taxonomies' => array('localidad', 'category'),
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'has_archive' => false,) );
}


function wpse_modify_taxonomy() {
    // get the arguments of the already-registered taxonomy
    $category_args = get_taxonomy( 'category' ); // returns an object
    // make changes to the args
    // in this example there are three changes
    // again, note that it's an object
  
    $category_args->rewrite['slug'] = 'categoria';
    $category_args->rewrite['with_front'] = true;
    $category_args->rewrite['hierarchical'] = true;

    // re-register the taxonomy
    register_taxonomy( 'category', array('post', 'portafolio', 'page','directorio'), (array) $category_args );
}
// hook it up to 11 so that it overrides the original register_taxonomy function
add_action( 'init', 'wpse_modify_taxonomy', 11 );


function eye_PostViews($post_ID) {
    // Establecer el nombre del campo personalizado de las publicaciones.
    $count_key = 'post_views_count'; 
    // Devuelve los valores del campo personalizado con la clave especificada de la publicación especificada.
    $count = get_post_meta($post_ID, $count_key, true);
     // Si el valor de Publicar campo personalizado está vacío.
    if($count == ''){
        $count = 1; // poner el contador a uno.
        // Eliminar todos los campos personalizados con la clave especificada de la publicación especificada.
        delete_post_meta($post_ID, $count_key);
         // Agregar un campo (meta) personalizado (Nombre / valor) a la publicación especificada.
        add_post_meta($post_ID, $count_key, '1');
        return $count . ' View'; //puede utilizar un separador " / "
    // Si el valor de Publicar campo personalizado no está vacío.
    }else{
        $count++; // incrementa el contador en 1.
       // Actualizar el valor de una meta clave existente (campo personalizado) para la publicación especificada.
        update_post_meta($post_ID, $count_key, $count);
        // Si es una declaración, es solo tener la forma singular 'View' para el valor '1'
        if($count == '1'){
        return $count . ' Vista'; //puede utilizar un separador " / "
        }
      // En todos los demás casos devuelve (cuenta) Vistas
        else {
        return $count . ' Vistas'; //puede utilizar un separador " / "
        }
    }
}

add_filter('upload_mimes', 'allow_custom_mimes');
function allow_custom_mimes ( $existing_mimes=array() ) {
// ' with mime type 'application/vnd.android.package-archive'
$existing_mimes['apk'] = 'application/vnd.android.package-archive';
return $existing_mimes;
}

/**
 * Actualiza el total de sesiones con bloqueo para evitar perder incrementos simultáneos.
 *
 * @param bool $increment Indica si la solicitud inicia una nueva sesión de visita.
 * @return int|false Total de sesiones o false si el archivo no es válido o no está disponible.
 */
function banco_actual_update_visitor_session_count( $increment ) {
	$counter_file = trailingslashit( ABSPATH ) . 'contadorvisitas.txt';
	// El modo c+ crea el archivo si falta; el error se registra sin exponer la advertencia al visitante.
	$counter_handle = @fopen( $counter_file, 'c+' );

	if ( $counter_handle === false ) {
		error_log( 'Banco Actual: no se pudo abrir el archivo del contador de sesiones.' );
		return false;
	}

	if ( ! flock( $counter_handle, LOCK_EX ) ) {
		error_log( 'Banco Actual: no se pudo bloquear el archivo del contador de sesiones.' );
		fclose( $counter_handle );
		return false;
	}

	$contents = stream_get_contents( $counter_handle );
	if ( $contents === false ) {
		error_log( 'Banco Actual: no se pudo leer el archivo del contador de sesiones.' );
		flock( $counter_handle, LOCK_UN );
		fclose( $counter_handle );
		return false;
	}

	$contents = trim( $contents );
	if ( $contents === '' ) {
		$count = 0;
	} elseif ( ! preg_match( '/\A(?:0|[1-9][0-9]*)\z/', $contents ) ) {
		error_log( 'Banco Actual: el archivo del contador de sesiones contiene un valor inválido.' );
		flock( $counter_handle, LOCK_UN );
		fclose( $counter_handle );
		return false;
	} else {
		$count = filter_var( $contents, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 0 ) ) );
		if ( $count === false ) {
			error_log( 'Banco Actual: el valor del contador de sesiones está fuera del rango permitido.' );
			flock( $counter_handle, LOCK_UN );
			fclose( $counter_handle );
			return false;
		}
	}

	if ( $increment ) {
		if ( $count === PHP_INT_MAX ) {
			error_log( 'Banco Actual: el contador de sesiones alcanzó el valor máximo permitido.' );
			flock( $counter_handle, LOCK_UN );
			fclose( $counter_handle );
			return false;
		}
		$count++;
	}

	// La lectura, el incremento y la escritura quedan dentro del mismo bloqueo exclusivo.
	if ( $increment ) {
		$written_contents = (string) $count . PHP_EOL;
		rewind( $counter_handle );
		$write_succeeded = ftruncate( $counter_handle, 0 )
			&& fwrite( $counter_handle, $written_contents ) === strlen( $written_contents )
			&& fflush( $counter_handle );

		if ( ! $write_succeeded ) {
			error_log( 'Banco Actual: no se pudo guardar el contador de sesiones.' );
			flock( $counter_handle, LOCK_UN );
			fclose( $counter_handle );
			return false;
		}
	}

	flock( $counter_handle, LOCK_UN );
	fclose( $counter_handle );

	return $count;
}

/**
 * Cuenta una sesión nueva y actualiza su actividad durante los siguientes 30 minutos.
 */
function banco_actual_track_visitor_session() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	if ( ! function_exists( 'session_status' ) ) {
		error_log( 'Banco Actual: las sesiones de PHP no están disponibles; no se actualizó el contador.' );
		$GLOBALS['banco_actual_visitor_count'] = false;
		return;
	}

	$started_here = false;
	if ( session_status() !== PHP_SESSION_ACTIVE ) {
		if ( headers_sent( $sent_file, $sent_line ) ) {
			error_log( sprintf( 'Banco Actual: no se pudo iniciar la sesión; ya se enviaron encabezados en %s:%d.', $sent_file, $sent_line ) );
			$GLOBALS['banco_actual_visitor_count'] = false;
			return;
		}

		// La cookie dura mientras el navegador permanezca abierto; la inactividad se controla abajo.
		if ( session_name( 'bancoactualsession' ) === false || ! session_set_cookie_params(
			array(
				'lifetime' => 0,
				'path'     => defined( 'COOKIEPATH' ) && COOKIEPATH ? COOKIEPATH : '/',
				'domain'   => defined( 'COOKIE_DOMAIN' ) && COOKIE_DOMAIN ? COOKIE_DOMAIN : '',
				'secure'   => is_ssl(),
				'httponly' => true,
				'samesite' => 'Lax',
			)
		) ) {
			error_log( 'Banco Actual: no se pudo configurar la cookie de sesión del visitante.' );
			$GLOBALS['banco_actual_visitor_count'] = false;
			return;
		}

		if ( ini_set( 'session.gc_maxlifetime', '1800' ) === false ) {
			error_log( 'Banco Actual: no se pudo configurar el tiempo de vida de los datos de sesión PHP.' );
		}

		if ( ! session_start() ) {
			error_log( 'Banco Actual: PHP no pudo iniciar la sesión del visitante.' );
			$GLOBALS['banco_actual_visitor_count'] = false;
			return;
		}
		$started_here = true;
	}

	$now = time();
	$last_activity = isset( $_SESSION['banco_actual_last_activity'] )
		? filter_var( $_SESSION['banco_actual_last_activity'], FILTER_VALIDATE_INT )
		: false;
	$is_new_visit_session = $last_activity === false || $now < $last_activity || ( $now - $last_activity ) >= 1800;

	$count = banco_actual_update_visitor_session_count( $is_new_visit_session );
	$GLOBALS['banco_actual_visitor_count'] = $count;

	// Si falla el primer incremento, no se marca la sesión como contada para permitir reintentar.
	if ( $count !== false ) {
		$_SESSION['banco_actual_last_activity'] = $now;
	}

	// Libera el bloqueo de PHP para no mantenerlo durante el renderizado del resto de WordPress.
	if ( $started_here && ! session_write_close() ) {
		error_log( 'Banco Actual: no se pudo guardar la actividad de la sesión PHP.' );
		$GLOBALS['banco_actual_visitor_count'] = false;
	}
}
add_action( 'init', 'banco_actual_track_visitor_session', 1 );

/**
 * Muestra el contador sin sobrescribir el footer del tema padre.
 */
function banco_actual_render_visitor_counter() {
	$visitor_counter_template = get_stylesheet_directory() . '/custom-visitorcounter.php';

	if ( is_readable( $visitor_counter_template ) ) {
		include $visitor_counter_template;
		return;
	}

	// Conserva el mensaje institucional si el componente no está disponible.
	error_log( 'Banco Actual: no se encontró o no se pudo leer custom-visitorcounter.php.' );
	?>
	<section>
		<div class="visitorcounter-cta">
			<div class="visitorcounter-cta-inner">
				<h3 class="visitorcounter-cta-title">Banco Metropolitano, su banco en la capital.</h3>
				<div class="visitorcounter-cta-text">Conviértete en uno de nuestros clientes.</div>
			</div>
		</div>
	</section>
	<?php
}
add_action( 'neve_after_primary', 'banco_actual_render_visitor_counter' );
