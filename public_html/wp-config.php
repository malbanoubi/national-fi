<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'national_wp' );

/** Database username */
define( 'DB_USER', 'national_wp' );

/** Database password */
define( 'DB_PASSWORD', '3,GbI;2HfvgZ' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'b^[k,):0Yy)1Q@}eUbGw^2BmSbRyfZ~^|c_dp}!kIe!L|~7g3,a$>Njx|XPm(#@h' );
define( 'SECURE_AUTH_KEY',  'FY5s?EIr>}svwx0cy0Clxb_,-HWOLU$_ZBc*_b9qp4Zy]d(=m0 UI(lWY)}uliG#' );
define( 'LOGGED_IN_KEY',    '(`ZoBBocp4}<n!<J~LpotL/O5n8j7O?D<aG{@+giUnrpY}xuB+$p;xwR34BA3kEd' );
define( 'NONCE_KEY',        ':XjOK!tHXmx)a-EWLT3;]d>y@[P)4R3&>}`6#9,IVR|NU8 4VjL$bZyw],e&`cR,' );
define( 'AUTH_SALT',        '|(mm^PVLyfwEJ&..<srRK/P#Xz|%s,ToDW|1>QzuBLJQc)WT?&BIZUT5X-w}eaw%' );
define( 'SECURE_AUTH_SALT', 'n?[1:Dhl%DB6W_<gee&uSmlM)xd30M8sSav#zOOi4;4=6r~(!hzg*Bc$C]8K?5QP' );
define( 'LOGGED_IN_SALT',   'u?aE.Nl??$Pp!C>iHaK={Kk|.v #ymI{`4~f./TVRXQ)H@yD5uO)I@&Sd0Vjal4x' );
define( 'NONCE_SALT',       '?&1&|w=5_a8IIEOu4JH)tDJLn>x1p~K?gVqHQ}:1iVy),X[N{1D]&hi++UORyLes' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
