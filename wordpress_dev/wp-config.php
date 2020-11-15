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
define( 'DB_NAME', 'wordpress_dev' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'L#}-1G.%Ra}k.44C!hD:%}vdyo]em%QDU$Aa)a&Tc^iL>5EbxiF<9@.j=bZ2V?G.' );
define( 'SECURE_AUTH_KEY',  'Gla:s;n_;RX#D$D9!Tri]k~TjQS)hJ5N$x]=t#%(NRk,p o=6[Xyz=6iUoD%@[I[' );
define( 'LOGGED_IN_KEY',    'JjQ-[?K1Yxl#yPAv5;w_(IGs]@A 4]PVj{r2#&gA3)0FaAGv_~kFM!N~!FIL,+>k' );
define( 'NONCE_KEY',        'ZAGhTk;%vfj2>3 r})s#{cjJjC1R 8}_ET(6U$j={o8rI#5$`J=O>uuu%3S%5qc-' );
define( 'AUTH_SALT',        'YR|`WvmTPyEb1Io$gxA<Z,3/#4KOWSEROo%3o?d 6N/N}L+i`Lmn$ 2,o Np*I0&' );
define( 'SECURE_AUTH_SALT', 'ufRe7R.)e/%x=kWX#X a!4C?~,;mc^2C;?+Z1 NL!iIe{gJ%/v5Z4IFoh:f*agVI' );
define( 'LOGGED_IN_SALT',   'ZcT!O|?aVuof_,C8ta!p-5,K!8vh;{`AoTc~u.E{w8JMm(XZBd(Npi%Kzl#GHyuP' );
define( 'NONCE_SALT',       '1zG67%[DA?$Si|>0`.Lh@E<:&I$+:iD~Bc$psFDQT;nj^%J)R{sWe>Ps&i=D],K#' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
