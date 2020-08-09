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
use wpAdvancedImagesPlugin\core\WPAIMP_Dashboard_Setup;
use wpAdvancedImagesPlugin\core\WPAIMP_Directory_Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPAIMP_PLUGIN_PATH', __DIR__ );
//define( 'WPAIMP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

require_once __DIR__ . '/vendor/autoload.php';

if ( ! function_exists( 'get_admin_wpaimp_partial' ) ) {
	function get_admin_wpaimp_partial( string $partial, array $data = null, bool $return = false, $folder = PluginPartialFinder::ADMIN_PARTIAL_FOLDER ) {
		return PluginPartialFinder::get_instance()->get_partial( $partial, $data, $return, $folder );
	}
}

$dashboard_setup = new WPAIMP_Dashboard_Setup();
$dashboard_setup->init();

$directory_options = new WPAIMP_Directory_Options();
$directory_options->init();

