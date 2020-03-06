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
define( 'DB_NAME', 'wordpress' );

/** Tu nombre de usuario de MySQL */
define( 'DB_USER', 'root' );

/** Tu contraseña de MySQL */
define( 'DB_PASSWORD', '2asir' );

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define( 'DB_HOST', 'localhost' );

/** Codificación de caracteres para la base de datos. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY', 'mr(w0%_l;GmN-oV#}>t51Yt@_|>dT$3Sfe0,5[Q.<hTf<kB=_oM.j;hn6,4$9Eo;' );
define( 'SECURE_AUTH_KEY', 'KuY`_I0%K_O[FC.W+wrR)x:L5R^W<3:FxgVX`sR2RtF!^Ccs4Nq^dW++bv2P:l,-' );
define( 'LOGGED_IN_KEY', 'k@;|va4JvtK#4U408!Dlo/O8Jm5BiXVKOK~]jMjkQe`Y[GztssO.(jfU=LprX6Se' );
define( 'NONCE_KEY', 'rs;f7La,#Yp)]rKi%vA-Eq7vn}`rNSMg?R=<tu_E,THEq3}{zuuAwi]ttZNQ#r}1' );
define( 'AUTH_SALT', 'kls7/GBz^;:8:uHO>1xINvw+{sx[u$7s^P~7q-0$2J]XWpHyz`4kllx% ACrLv~D' );
define( 'SECURE_AUTH_SALT', 'BQ*8.9&L+&<6)QM}-wBm|mZjSCfPGLyW^AQRFk`*QLn1swfdH0vNKTJIzkH4`+rr' );
define( 'LOGGED_IN_SALT', 'c9f<eJIO`C~lq6WZqFUZ[$4pS#Kk-kI,;alD41|<JFH#maXU))X5xK/Efw|deE6b' );
define( 'NONCE_SALT', '52nNcn@syX$ VFqEq4a^pg*A`Hx3C^+^O$Y9R?o.86P0nQ^:hYjkycp4;~J/7ivN' );

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix = 'rs_';


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

