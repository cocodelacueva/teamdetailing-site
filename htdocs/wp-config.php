<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'teamdetailing');

/** MySQL database username */
define('DB_USER', 'wp');

/** MySQL database password */
define('DB_PASSWORD', 'wp');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|Zys|)O53LVt,2_).8m!HB,|R5p] #5(N)z 7!$d87SfOy2QnGE0Dp-P+=cqP.[G');
define('SECURE_AUTH_KEY',  ' IQ- p-)?j.@ QxHF8y`+8J]N?=RYAp|UVzrcPjul->F#:!AYJM>lNS>lejlE%$<');
define('LOGGED_IN_KEY',    '-Hm;9u+;aC>QcD_L)@q!K?xu`~:=|~IfCK3%p*F!:1/k=x?=uB_-Q?Oa7)SNs-ID');
define('NONCE_KEY',        ';O=dc>-x._bmSgb|^P8:8oVgmM1>kH%DcNVimAm7>IO;aI+u9O3vADyb89gZjR*W');
define('AUTH_SALT',        'MH(zA~L#--=a<*$V,>13%7`TQo+t%+?=G0-*1n._1ndT&;jmO4+:+MQaCKZ6gV+[');
define('SECURE_AUTH_SALT', 'AJ&;#U#Y)|sZ-M4ANQyY76hvKyp5gj1zUk4YT$u={i(bXP#l;q;#<6I$yGL#+-Je');
define('LOGGED_IN_SALT',   '(-[GpVh1J:!)&WKY,e#e^$Bnh547JP4mEisP%t)d+).B!+f#&27OW2fB#56+!V~+');
define('NONCE_SALT',       '7iUPUW`D4d&E-9[:t4Ih|:)|jdeg|ggq-M&Z+(!%2dW2eYrqN-MEB4$?qCf.Z^)4');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


if ( isset( $_SERVER['HTTP_HOST'] ) && preg_match('/^(teamdetailing.)\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(.xip.io)\z/', $_SERVER['HTTP_HOST'] ) ) {
define( 'WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );
define( 'WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] );
}


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
