<?php

namespace wpAdvancedImagesPlugin\api;

use wpAdvancedImagesPlugin\controller\WPAIMP_Dashboard_Controller;
use wpAdvancedImagesPlugin\core\WPAIMP_Constants;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WPAIMP_Rest_Api_Custom_Routes {
	public function register(): void {
		$this->register_routes();
	}

	private function register_routes(): void {
		add_action( 'rest_api_init', function () {
			register_rest_route(
				WPAIMP_Constants::BASE_PATH,
				WPAIMP_Constants::API_DASH_CONTROLLER,
				array(
					'methods'             => array( 'POST' ),
					'callback'            => array( new WPAIMP_Dashboard_Controller(), 'update_dash_data' ),
					'permission_callback' => '__return_true'
				)
			);
		} );
	}
}
