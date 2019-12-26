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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress');

/** MySQL database username */
define( 'DB_USER', 'root');

/** MySQL database password */
define( 'DB_PASSWORD', 'password');

/** MySQL hostname */
define( 'DB_HOST', 'mysql:3306');

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
<<<<<<< HEAD
define( 'AUTH_KEY',         '884c50144bbfce58dab6ba8b9516cbd402a2b765');
define( 'SECURE_AUTH_KEY',  '779f7314c8b376bb99b67422af124905d077ff0e');
define( 'LOGGED_IN_KEY',    'ee9e97d7079e14d650671758362332d40a23a24b');
define( 'NONCE_KEY',        '5d9d6dc1bc41549af05bd5bd2aef4903a71c70b4');
define( 'AUTH_SALT',        '3ab91c724fd2618a87d8d231420ac2374adb3fd7');
define( 'SECURE_AUTH_SALT', '7258b70d56685edd0793f3f7fbe721603013ab03');
define( 'LOGGED_IN_SALT',   '6691c8d664f43f310f68354af91cc984f7288b36');
define( 'NONCE_SALT',       'c886e7812eee39bd39cd938dc7a49ac6aaaaf01c');
=======
define( 'AUTH_KEY',         '17ad980dad84427659db77a7db6bcd36f65bcb6f');
define( 'SECURE_AUTH_KEY',  'd22d7a386a85a3f877a1f6f5e4762a964daeafce');
define( 'LOGGED_IN_KEY',    'bd75bfa195ed7db2a0f5921acd8d2e718a5bd5fe');
define( 'NONCE_KEY',        '6a8bf12581b7a884aa91be417ec192f14e1a3274');
define( 'AUTH_SALT',        'd605b0743c3b77b754fad9e656b00b8b32ac636a');
define( 'SECURE_AUTH_SALT', 'e5ef67b292049016ef485aee82a3c891b8dbee8c');
define( 'LOGGED_IN_SALT',   '2a5bcd815128c1b0dfe15ab6427eef9f8d5fe7e5');
define( 'NONCE_SALT',       '84dbe67dd66abf40fd532bf827f1a692c12d800b');
>>>>>>> bb6500f10a7021d282df80c29c0872a75b57e076

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

// If we're behind a proxy server and using HTTPS, we need to alert Wordpress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
