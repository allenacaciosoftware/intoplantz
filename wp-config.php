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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_db' );

/** MySQL database username */
define( 'DB_USER', 'wordpress_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'my_password' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '=F0~;vt?vEILN.pBw&x^7u _NR*2yje#P:sWE297t&+;_~ey#U 1/WCb?sm8^/CP' );
define( 'SECURE_AUTH_KEY',  'a{&_a[Kk;%-2s[P3.{AC.FE?[sn)d|EFC&Hj0pIqG.Ma:/LywnY&g7#J{EB+qn&@' );
define( 'LOGGED_IN_KEY',    'bO2z3>:ycX*(e,,B:WF#VukFNQg(vCHD%!I@::+c0p}j)keTe+,(H.d07|xbt!QN' );
define( 'NONCE_KEY',        'UYA@DaLqyn9A2y@>#cXY><^jUH`>f)rh7-()0+j1qKR6k|G~@Fr7=={21V$_Qpz_' );
define( 'AUTH_SALT',        '$7}1kJMQx]f_EdM#C=^Z-5-D``G=JdehD6Cn7]kyL@JRxbyS_1<}6[{_6<rfX=`d' );
define( 'SECURE_AUTH_SALT', ';/ c$,mp6kQoa&@%3&2,x6p#ISfl$qGc/^X@$9dKuLw$8khIC0Mg^7?RJj?=n#4r' );
define( 'LOGGED_IN_SALT',   '1JXGK&+.E[X1TH!?Tjk2JBq.2}V]!+|hNt/C+&=I3P8[E$?gW3bE:tz7VBt`-9[k' );
define( 'NONCE_SALT',       'i7aYwcdf$wzQdH;8b1}Mpu~vQ2Q4!5bR)y^U[[j|AH&V 10=+mi F<BPMdjNel^k' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
//$table_prefix = 'wp_';
$table_prefix  = 'wp_z6b8gq_';

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
