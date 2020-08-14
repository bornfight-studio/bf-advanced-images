<?php


namespace wpAdvancedImagesPlugin\controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Dashboard_Controller {
	public function update_dash_data( \WP_REST_Request $request ): \WP_REST_Response {
		$query_params = $request->get_json_params();

		$action = $this->dash_action( $query_params );

		$response_data = array(
			'action' => $action
		);

		$response = new \WP_REST_Response( $response_data );

		$response->set_status( 200 );

		return $response;
	}

	public function dash_action( ?array $query_params = array() ): bool {
		if ( empty( $query_params['action'] ) ) {
			return false;
		}

		switch ( $query_params['action'] ) {
			case 'delete_all_cached_images':
				$image_controller = WPAIMP_Image_Controller::get_instance();
				$image_controller->delete_all_advanced_images();
				break;
		}

		return true;
	}
}
