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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '$*T%Tr;u2*a5ktNR<C>~1&$c]@rgLws<{tCN8Zf;l;[_<9g+5y{4igw7yF#;mL >' );
define( 'SECURE_AUTH_KEY',   'B[JVDXa/La5&{{YCRb}Uyg.kz;A;w0?_(R;G?/{/1.t/Kv3e*3}ZY.1CJ2JX[1H5' );
define( 'LOGGED_IN_KEY',     '>mr{+y,8~Sd`19j6r$$Eu%7dx_UP[^YmwMVaiCb&PCT&~[_&|P(Y5cu[z.AQ%<w^' );
define( 'NONCE_KEY',         ':8uMFbwq:R&alZ).8nwnvze$?p<#9yzy|(CZeQyiCP;[k*>$c8B0C5lHD|Jn<5qc' );
define( 'AUTH_SALT',         '~TM;nTpL{&1mw PqYM=(U>4%XJQ@Zi`Tc#Z[!}$].QcDp9-ERc/#)0JKHn?E%#@x' );
define( 'SECURE_AUTH_SALT',  ' i=O-N9o36|/~NiUs/!VTvrq?<BkM[_mx[^nM/fN9hGrt_q~4!OVwxEU((y9WG<:' );
define( 'LOGGED_IN_SALT',    'T)yP,=:-D.&u{Ww!ZK[`J0rFOzH/,7-87g7PgJz&2v>rjQ18h^ QMgfTw[T|pz$Q' );
define( 'NONCE_SALT',        'RH%=N(Ny[IOo/5x,9}/~PrQJRs$DlvCUfm(r~`snJ:~rUj--~ZOyb7}fWyLg]CvA' );
define( 'WP_CACHE_KEY_SALT', 'OnR>j9h%u*kH?a%%7{IG5A6a#TVQ~ $o2sm)%UKO;eD+lp4I~_8 )V%j!=5r^bAf' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
