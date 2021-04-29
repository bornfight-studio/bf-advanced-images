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
			case 'unset_default_images':
				$this->save_unset_default_images_values( $query_params['data'] ?? null );
				break;
		}

		return true;
	}

	public function save_unset_default_images_values( ?array $data ): void {
		$update_data = array();

		if ( ! empty( $data ) ) {
			foreach ( $data as $data_value ) {
				$update_data[ $data_value ] = $data_value;
			}
		}

		update_option( 'wpaimp_image_sizes', $update_data );
	}
}
