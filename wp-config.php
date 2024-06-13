<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
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
define( 'DB_NAME', 'wp2' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'qMXhg%,P-[4QJt$xNeD|&}RzuO`U_L~f3aSa=rPfy.*6#yu)jE%mFo (oMIv4lRi' );
define( 'SECURE_AUTH_KEY',  '>XE7#+/azAXFLX5~wSzK&/Fsu5N LQot|$j4UE<,&U$1;jdPP(:klNK|%h+[#.Bw' );
define( 'LOGGED_IN_KEY',    '9]}ReLvEfs-jxI!%(]1_z+uY#.CPNgpa?b<4j:rR2u]3u?~ufjKX?M/Yp}.g4KdA' );
define( 'NONCE_KEY',        '5acH)oojJ2U44I-3i$>[7GNqW 6!8~L68W7_x6{+]J`bc:S3U%]U1v<m]xiOAik)' );
define( 'AUTH_SALT',        '=LF*~OL6I2F9}!QH3M!/Q.mRe(-tJ4+5LAND67V2EUp)i,v_k2@k{! &kuzdf;z-' );
define( 'SECURE_AUTH_SALT', 'ZXTX*x~QO6Lu&,ctrMVEK#3CrY|Pu-|l?PKI>C^WMgqRaL%>M X/#m-A=Bd9h|0}' );
define( 'LOGGED_IN_SALT',   'DGfu!Mh(*F[6@e :1RZK*Y&j>wnQyxW@6@4l$7Y0K7U;a+;v8e>O1aN@$#3*iXS$' );
define( 'NONCE_SALT',       'GC~)m<<Z}q(k&].5okM3l|1{3x[V,>-@t*o7zQ6^OdZQ(;GlB+UAe2#uI,v5&/Ud' );

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
