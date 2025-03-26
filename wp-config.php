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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         '&3Yd=Jqo;]fS0X?}dHzp<GuUd@@CP{!Pp093{n>jQ-QkrZ/K8I3D&wL_;J6yp<9+' );
define( 'SECURE_AUTH_KEY',  'hUv_vgPL_#5IIxpVc3PUe&%o$3}jm#<M:(jiLmn(!G^w} K]0f2xw:=]o{Z#DArt' );
define( 'LOGGED_IN_KEY',    '@[fgv(#`R?N{vKs/m-mH_ QLV#G|no[hae9p_ixOOXDX|Z!2(LoU`{vCfCFCb9eg' );
define( 'NONCE_KEY',        'h9BLIcCkbb0Pp&%Gqb.>iD{4)4lq6JKQ^P,*OWc&c0^<NuV_Yk%03q;!6vMAt~~u' );
define( 'AUTH_SALT',        'qEUmP)Gt.gq/E2+/Hx+|tKGq27]D~TS)`fpDwuQm|{ZPt00qp9LB.hfw`L16Ja1J' );
define( 'SECURE_AUTH_SALT', 'Aj,*)9;>|lIvSDLB*P|B,>SoEgjp)a<Cz+4DYV*yuxt;;iHEUTsd(7>i>t=7#cr$' );
define( 'LOGGED_IN_SALT',   '.wK@mQ18wTB43nmQf(3]K{}]0Is;T+vt0R8D+pb:AqYi28v?;`(Ds| 5%84Vky!2' );
define( 'NONCE_SALT',       'Bk]w%89]T4!bEyt%jlI8gPl=ZHG?(E7a #bv_Od[/Cw![=9y=n`3,.B@qcUEiCw|' );

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
