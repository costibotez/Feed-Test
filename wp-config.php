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
define( 'DB_NAME', 'wp_feed_test' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '-ptm+L1^_S9q1+tO#([>ymq%;2WE~]C;*#90!M-lr($dhbO$+HG|3<sEh`@)]6`l' );
define( 'SECURE_AUTH_KEY',  ').*gM? !BlUAW_]*gQYBw-~$IRPY9V p%b|[TGw,coOBICYrvk(ET&T4l+8n5g:*' );
define( 'LOGGED_IN_KEY',    '6;5}YcoyA6sE=LuUZb/(+:m9m74a?x}}m;OhiT5`._ae}8zNqJCN:IS_&5@{1Swo' );
define( 'NONCE_KEY',        '<1N6`^6<wL;2E0:`c*RPCYfQq$Z&s25nBoWCU2K0F^*sS:VgmvsEZlwTN~B$);(|' );
define( 'AUTH_SALT',        '>4S|DIECko[a6jOjUoha9{X}ilm;,[H;*8nY,6:@[Fd0DRLE{R&mD~]G:eiczV7/' );
define( 'SECURE_AUTH_SALT', 'y94(Az5.NB$Pt]l{$S8,3M%T,>F@;u7356W,KM.oVh6*B(P#ZF!VPm^Z-Pc$*h86' );
define( 'LOGGED_IN_SALT',   'm} e]4^>HW5xGD[U~E>)P5bC%<[Sgrm!N@H&Aik< b;OjpDDguYq.N@COzdf}qyd' );
define( 'NONCE_SALT',       '6SFoZ(j7fZsMn%,kC=)fIny~`sHT /um+ZL$8P K-ve3s6sXYfpo:-MDR1}/xo.O' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
