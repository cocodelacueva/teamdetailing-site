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
define('AUTH_KEY', 'oA$q?pM-GiU**Rdt:$hwK7U-,xn*dcG `fV*OHgSSR4Y75qccOUD/u}-jx;h-e>F'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', 'ujTd:{12]n{`DyMvqEaXy[rF,V=|f@qj*u6/-C-:fSKZ_l5vpY+z87-_<y5i3*L5'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', 't_72)m_}A~oq4Phq<;f18#moHv0M]+1U a#$6]KjL@wkRM3CWG5ns@Hd=|xw1G[q'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'I8pYel|bcV}Q{OgB@2N?KpaW>RVt2m;A?31[EiZc38.Ei{kpzmHTN_% IO#5-&io'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', 'U+gd!%9V*sVby3<h)[<Pz],6SsnA5+s%Sq~ B<yRTzdXn~(CR@)o~?KV|u=U*#9I'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'kzb4y@EI&InOo+-$|vl*o(NyA+9hMW4Jncp+-PStXI_Mlqe TMkJ% %A>%gVZcA/'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', 'EUa-2KT{o-0Q~/*N+:M]qOB_D,RL@`n+l:zt-9%)9*~+*7pM9q%+#!ESmgm&_2Zd'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'P+?}8_|ghqy2%fc|fJ7?n[:Z@||~c nq)r%q Up7g_ZssDmw03Ak+Ybr}W= @+z='); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

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

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

