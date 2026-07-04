<?php
/**
 * Webuildsites functions and definitions
 *
 * This file must be parseable by PHP 5.2.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wprig_webuildsites
 */

/**
 * Add LiveReload script in development mode.
 */

define( 'WPRIG_WEBUILDSITES_MINIMUM_WP_VERSION', '5.4' );
define( 'WPRIG_WEBUILDSITES_MINIMUM_PHP_VERSION', '8.0' );

// Bail if requirements are not met.
if ( version_compare( $GLOBALS['wp_version'], WPRIG_WEBUILDSITES_MINIMUM_WP_VERSION, '<' ) || version_compare( phpversion(), WPRIG_WEBUILDSITES_MINIMUM_PHP_VERSION, '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

// Include WordPress shims.
require get_template_directory() . '/inc/wordpress-shims.php';

// Setup autoloader (via Composer or custom).
if ( file_exists( get_template_directory() . '/vendor/autoload.php' ) ) {
    require get_template_directory() . '/vendor/autoload.php';
}

/**
 * Custom autoloader function for theme classes.
 */
function _wprig_webuildsites_autoload( $class_name ) {
    $namespace = 'Webuildsites';

    if ( 0 !== strpos( $class_name, $namespace . '\\' ) ) {
        return false;
    }

    $parts = explode( '\\', substr( $class_name, strlen( $namespace . '\\' ) ) );

    $path = get_template_directory() . '/inc';
    foreach ( $parts as $part ) {
        $path .= '/' . $part;
    }
    $path .= '.php';

    if ( ! file_exists( $path ) ) {
        return false;
    }

    require_once $path;

    return true;
}
spl_autoload_register( '_wprig_webuildsites_autoload' );

// Load the `wprig_webuildsites()` entry point function.
require get_template_directory() . '/inc/functions.php';

// Add custom WP CLI commands.
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once get_template_directory() . '/wp-cli/wprig-webuildsites-commands.php';
}

// Initialize the theme.
call_user_func( 'Webuildsites\wprig_webuildsites' );

