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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'website_portdox' );

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

define('WP_HOME','https://localhost/portdox.com');
define('WP_SITEURL','https://localhost/portdox.com');
define('FS_METHOD', 'direct');

define('FORCE_SSL_ADMIN', true);

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $_SERVER['HTTPS'] = 'on';
}

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
define( 'AUTH_KEY',         'F&V_&HPLniji?Soc/}vtU+Gk8<fyhWmagns&WyKiikC@,u|Mn<}1TVE.j}2$gW =' );
define( 'SECURE_AUTH_KEY',  '&Ybt>}Gg/oUd.Evi7~-e:*0B]m/TTLvw/Pe1 $LKaW_U>gm%^e1;q,O%IPx8m|dH' );
define( 'LOGGED_IN_KEY',    '5ANySKK&+xwY=+g1A5t,:d|{o57.t68!sz`V{We9OS!?U:t42D_?L?Y0hGlh&^fh' );
define( 'NONCE_KEY',        'tuc8N+:x9g/i.m1D*ZG8$2Dp}n@{bdSiQ3?Fyf;GV2~zba*$_RC2#@8-SGJ18}Og' );
define( 'AUTH_SALT',        'dGf2*l%^+nsa-ZmEsyX`q@u0/h:t6U:7[{Dq2A..P1Hf87?x#c{`fEuDW.kj}qsn' );
define( 'SECURE_AUTH_SALT', '^g&=MWuN-HQy%z]?j4RQV5f_v1ABG#=M,s:>H</2jt_{eBU[Lx6s+bzPkN+=`NV+' );
define( 'LOGGED_IN_SALT',   'wYpwkO-D->v$/s8}]VEmtC;yeHqOTPP,kdspi4AF#(&Ml^rC?1fcYmWQoyEa,UVJ' );
define( 'NONCE_SALT',       'sBh(By~&~nJ<oV[bPZP372X4^47v!r,/kI 7&T{s6P8 S>wkuz/;f`N[vD,6iw }' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'pr_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
