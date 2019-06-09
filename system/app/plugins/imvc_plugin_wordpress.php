<?php

namespace wordpress;

setTable();
setWordpressConfig();

function setTable()
{
	if (\tmvc::instance()->controller->cache->get(md5_file(__FILE__)) == null) {		
		\tmvc::instance()->controller->cache->set(md5_file(__FILE__), filemtime(__FILE__), 60*60*24);
		$db    = \tmvc::instance()->controller->load->database();
		$check = $db->query("SHOW TABLES LIKE 'wp_users'");
		if ($db->count() === 0) {
			$sql = file(__DIR__ . "/wordpress/dump/wordpress.sql");
			foreach ($sql as $line)
			{
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;
		
				// Add this line to the current segment
				$line = str_replace('mlmsoftware.local', $_SERVER['HTTP_HOST'], $line);
				$line = str_replace('$P$BFR.r5XGQAmEz8CDXAM.qy7v2B1i0a0', md5(uniqid().time()), $line);
				
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';')
				{
					// Perform the query
					$db->query($templine);
					// Reset temp variable to empty
					$templine = '';
				}
			}				
	   }
	}
}

function setWordpressConfig() {
	if(!file_exists("site/wp-config.php")) {
		include "system/app/configs/database.php";
		$salts = file_get_contents('https://api.wordpress.org/secret-key/1.1/salt');
	$content = "<?php
define('DB_NAME', '".$config['default']['name']."');

/** MySQL database username */
define('DB_USER', '".$config['default']['user']."');

/** MySQL database password */
define('DB_PASSWORD', '".$config['default']['pass']."');

/** MySQL hostname */
define('DB_HOST', '".$config['default']['host']."');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
".$salts."

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
\$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');	
	";	
	
	file_put_contents("site/wp-config.php", $content);
	
	}
}




?>