<?php
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// If plugin is uninstalled delete added options
if ( get_option( 'bfai_unset_image_sizes' ) ) {
	delete_option( 'bfai_unset_image_sizes' );
}