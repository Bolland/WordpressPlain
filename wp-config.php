<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ENTER-DP-NAME-HERE');

/** MySQL database username */
define('DB_USER', 'ENTER-DB-USER-HERE');

/** MySQL database password */
define('DB_PASSWORD', 'ENTER-DB-PASSWORD-HERE');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '#ZPSjFk;|>M*$j3-C>2{}S+e)k+-!4Hx@%Q^b3YKd|Fu9{Y;7GTE+/IVyB96f|f|');
define('SECURE_AUTH_KEY',  'ewY68WO1IVeA-=Js|]g+on$-O[~R5W,3Qqi}F|[_6RS!Lt-?gjx.XFG@w79~zV>j');
define('LOGGED_IN_KEY',    '<<k^|_ _z-?@>1-CKzCIT@63LEI^ V;kn{8~q9v9D09;+$n0~?~JaAYV<0h8}%If');
define('NONCE_KEY',        '7M#|:4-*Oa-?DY-uCy<6J*vIazO|TGP!tW:N[YBLBmtXA(#3 Pzql`$}QnecNc+,');
define('AUTH_SALT',        'PPG7(#U32~6Hl 6ofc)(Tw;d!V,(J3]]+&z;e&L9E<*8yw<Dd+fR*QTq4bvv1+W8');
define('SECURE_AUTH_SALT', 'FG=}cI*R]!y<n@#cV6ICf HuU~0Et#h+Pp.plj|)vkv(NV-EnL=[YUZ>|(!t!lnc');
define('LOGGED_IN_SALT',   'C9UgV+0f iVOf/h]E/cwfXdz#Xg0K!:21$n wCc&~Z3c.!}-Rn0f|S`Ug+|l@3r[');
define('NONCE_SALT',       '?w_fd9+GJY0X<4J!hIZm9*oE.?#a+gP?S.oIzROup1KuO-e`aWnrB&e[c[ez*H2a');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_4jncaro8v4n_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
