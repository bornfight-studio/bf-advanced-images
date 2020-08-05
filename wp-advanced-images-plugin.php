<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           WP Advanced Images Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       WP Advanced Images Plugin
 * Plugin URI:        https://github.com/bornfight/wp-advanced-images-plugin
 * Description:       Image optimization
 * Version:           1.0.0
 * Author:            Josip Mucak
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPAIMP_PLUGIN_VERSION', '1.0.0' );
define( 'WPAIMP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once __DIR__ . '/vendor/autoload.php';
