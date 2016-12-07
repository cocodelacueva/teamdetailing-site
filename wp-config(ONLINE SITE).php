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
define('DB_NAME', 'teamdeta_web');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'teamdeta_web');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'dgr3426');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         ':1BL/Ya5xbQz]dd|K4}-=U||gHJVR<xM#,H?d=-tUrr-H d8[~ud};2w}PtL&N;R');
define('SECURE_AUTH_KEY',  'Y]<vcauy(K)g{K=Z;i~jCqygMe+?V)fs.|dq]X,8V3%g|Wl|@-vawmXG<c8[gG+q');
define('LOGGED_IN_KEY',    '6*:YklMTT^=+`cK-hnc+CfLzJ4hzGxVY-FAr3En4>D)7{9/x7[mz2nt$y|M}~K/6');
define('NONCE_KEY',        'b3E$$+)[LE9wn@$k-U$+~_JSt-~W|2/UD/b|^h%ku4v0as%&AdI4g,lpwMia~EUZ');
define('AUTH_SALT',        '0Y!I|&J:^OVbW&R*_iGo-&= |Ck5S,.-ud^_ 7Mme37^W;Q+Dna2r/CgT:?bRHIY');
define('SECURE_AUTH_SALT', 'uj^Uy0nZX{-mEn#QZ]|c@@E^|^s:%~n?E-S/z1X+gaA,8[:HAoWw|)|[|0~T=?XN');
define('LOGGED_IN_SALT',   '_Z:,A6Ei`al+OPva~}etRbh:H*L|E1NUpk{Pa q/3-,RwxP] Iqprl]?ii2+b%Vp');
define('NONCE_SALT',       ':Zi)8@,}NxG;ggK|y2ln[p4,+j?fFN>+go-ppB$w+=>JvO6zkm@<}:p._N+|l={J');
/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'td_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

//desactiva el editor por defecto
define( 'DISALLOW_FILE_EDIT', true);

//quita o enumera la cantidad de revisiones guardadas, en vez de false se puede poner un número
define( 'WP_POST_REVISIONS', false );

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

