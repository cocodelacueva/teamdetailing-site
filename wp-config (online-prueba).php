<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'jv000140_teamdet');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'jv000140_teamdet');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'pula17RIwi');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '_R2g!D*]`R-LOd! Mw#!7@eU1KByL+kYne 9@YHTc11(60iL&@:S5z/NpZAM#XKJ');
define('SECURE_AUTH_KEY', 'sg)U.oGF-^`TlEwGE/fB5II&:9x&R^Z(6h4?Dut%vZ<se)@;6AwL@e8+Bh7.~yar');
define('LOGGED_IN_KEY', 'FaQ$@A4-;~^aZOn1ivE6co%I~IgU>EJ]A!#?t()xz_sW>&ab`$tO3DF$6gb|3Pe?');
define('NONCE_KEY', 'Ht-JhgD5};/T@!I#O/N<{e:n5.HfF0y6{+A.@9+B7M&{7/&7pv?#YywNxabIt9n1');
define('AUTH_SALT', 'I )Rp*(,1su^>jbB1,;n~f:r:v37l#lf^&Q DBQAtrd`-*D`sFnvVtpU=zQ<CE;5');
define('SECURE_AUTH_SALT', '6jB-?_kH0wCf)50&F|Q33ZKf9 <Y4kM=](lo*^O4kC*#v$taW`y^= wTZcXTxx+O');
define('LOGGED_IN_SALT', '#JA>R[-y:+|h,_{L$Zj3)]$we!Zm|H`=7J]h#w`sPx.10#1y1/,t]e)@/k%,Yc:?');
define('NONCE_SALT', '.pOYz{E@UG^J^Qt6x>ql4r(.kh%HQ9[t8Xq9cV.hCGKvS=21a,z.}H!)HGzQP.R4');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'td_';

define('WPLANG', 'es_ES');
/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', true);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

