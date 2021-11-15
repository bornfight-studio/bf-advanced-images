<?php

namespace bfAdvancedImages\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use bfAdvancedImages\cli\ImagesControllerCLI;
use \WP_CLI;

class BFImagesCLI {
	public function init(): void {
		add_action( 'init', array( $this, 'register_cli_commands' ) );
	}

	public function register_cli_commands(): void {
		WP_CLI::add_command( 'bfai-delete-images', array( new ImagesControllerCLI(), 'delete_images' ) );
	}
}