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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ed_multisite' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'qpNUXTKPYX3/7mqp(mrx#bc`9W=$)%S~p!ksc6/~rWY!zqwo+6K?IU]^A.ZiH `f' );
define( 'SECURE_AUTH_KEY',  'HoP4BCROO,::uUJL]~kE3:~|`2Qqu@.;;f:4g.m=*.rN~i[.&t$]Pb0i=p4(1&P1' );
define( 'LOGGED_IN_KEY',    '}ay*AEvAI#:I*b5ztbywy/SA-q2Ou7k(t>^5q?y6>Pc?a9!kNN=A4Kx*b]t,BJe&' );
define( 'NONCE_KEY',        '+.~N[T1NnQBucVS790M-,]ugCCYQ&F5lXAm>5fGjv$E%4zwT,zh`7$e_(X73cVYm' );
define( 'AUTH_SALT',        'Txr{3>Jp,&iT/i7X,ri3:q|y}L_[5S%U_y8!i@eM9<JQMjZv3@voKUuLkj(QJ79(' );
define( 'SECURE_AUTH_SALT', '6xn_dp%wNFxIFEQyALL^ b>{$)S_-7zt8muOM/<9dJ_B,b9]UDuJ(Ew[rdHyL4/}' );
define( 'LOGGED_IN_SALT',   'C/AT0v`<m/H;3JA4/io8u.%l)rj2~S`M?z>H8;X]U!)-}]6q;AZ,T=rJ@@+FsS+4' );
define( 'NONCE_SALT',       'QhTncU&S%eX$X*o)-L<ok7ExFv|y@iM;7w-<wr=x}^N<1{%wIr4RdxkOZO0*:@ZQ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'oet_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
