<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also app all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           BF Advanced Images
 *
 * @wordpress-plugin
 * Plugin Name:       BF Advanced Images
 * Plugin URI:        https://github.com/bornfight/bf-advanced-images
 * Description:       Creating images on demand, image optimization
 * Version:           1.0.0
 * Author:            Bornfight
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

use bfAdvancedImages\core\BFCore;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Local Path
define( 'BFAI_LOCAL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BFAI_LOCAL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BFAI_PLUGIN_SLUG', 'bf-advanced-images' );
define( 'BFAI_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( 'BFAI_PLUGIN_PATH', __DIR__ );

require_once __DIR__ . '/vendor/autoload.php';

$bf_core = new BFCore();
$bf_core->init();