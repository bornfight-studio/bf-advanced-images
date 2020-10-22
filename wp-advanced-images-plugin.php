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

use bornfight\wpHelpers\PluginPartialFinder;
use wpAdvancedImagesPlugin\api\WPAIMP_Rest_Api_Custom_Routes;
use wpAdvancedImagesPlugin\core\WPAIMP_Dashboard_Setup;
use wpAdvancedImagesPlugin\core\WPAIMP_Directory_Options;
use wpAdvancedImagesPlugin\core\WPAIMP_Plugin_Partial_Finder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Local Path
define( 'WPAIMP_LOCAL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'WPAIMP_PLUGIN_PATH', __DIR__ );
//define( 'WPAIMP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once __DIR__ . '/vendor/autoload.php';

if ( ! function_exists( 'get_admin_wpaimp_partial' ) ) {
	function get_admin_wpaimp_partial( string $partial, array $data = null, bool $return = false, $folder = PluginPartialFinder::ADMIN_PARTIAL_FOLDER ) {
		return WPAIMP_Plugin_Partial_Finder::get_instance()->get_partial( $partial, $data, $return, $folder );
	}
}

if ( ! function_exists( 'get_public_wpaimp_partial' ) ) {
	function get_public_wpaimp_partial( string $partial, array $data = null, bool $return = false, $folder = PluginPartialFinder::PUBLIC_PARTIAL_FOLDER ) {
		return WPAIMP_Plugin_Partial_Finder::get_instance()->get_partial( $partial, $data, $return, $folder );
	}
}

add_action( 'admin_enqueue_scripts', function () {
	wp_enqueue_script( 'wp-advanced-images-plugin-admin-js', plugin_dir_url( __FILE__ ) . 'admin/dist/bundle.js', null, microtime(), true );
} );

$dashboard_setup = new WPAIMP_Dashboard_Setup();
$dashboard_setup->init();

$register_rest_api_routes = new WPAIMP_Rest_Api_Custom_Routes();
$register_rest_api_routes->register();

$directory_options = new WPAIMP_Directory_Options();
$directory_options->init();

