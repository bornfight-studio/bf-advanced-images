<?php

namespace bfAdvancedImages\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use bfAdvancedImages\controller\BFImagesControllerCLI;
use \WP_CLI;

class BFImagesCLI {
	public function init(): void {
		add_action( 'init', array( $this, 'register_cli_commands' ) );
	}

	public function register_cli_commands(): void {
		WP_CLI::add_command( 'bfai-delete-images', array(
			new BFImagesControllerCLI(),
			'delete_images'
		), array(
			'shortdesc' => esc_html( 'Command for deleting cached images' ),
		) );

		WP_CLI::add_command( 'bfai-is-dir-writable', array(
			new BFImagesControllerCLI(),
			'is_dir_writable'
		), array(
			'shortdesc' => esc_html( 'Check if upload directory is writable' ),
		) );

		WP_CLI::add_command( 'bfai-unset-default-image-sizes', array(
			new BFImagesControllerCLI(),
			'unset_default_image_sizes',
		), array(
			'shortdesc' => esc_html( 'Unset default image sizes' ),
		) );

		WP_CLI::add_command( 'bfai-delete-default-image-sizes-option', array(
			new BFImagesControllerCLI(),
			'delete_default_image_sizes_option',
		), array(
			'shortdesc' => esc_html( 'Delete default image sizes option' ),
		) );
	}
}