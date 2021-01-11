<?php


namespace wpAdvancedImagesPlugin\controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Configuration_Controller {
	public function register_custom_image_sizes( array $image_sizes = array() ): bool {
		if ( empty( $image_sizes ) ) {
			return false;
		}

		$image_controller = WPAIMP_Image_Controller::get_instance();

		foreach ( $image_sizes as $size_name => $image_size ) {
			$image_controller->add_image_size( $size_name, $image_size );
		}

		return true;
	}

	public function register_custom_image_srcset( array $image_srcsets = array() ): bool {
		if ( empty( $image_srcsets ) ) {
			return false;
		}

		$image_controller = WPAIMP_Image_Controller::get_instance();

		foreach ( $image_srcsets as $srcset_name => $image_srcset ) {
			$image_controller->add_image_srcset( $srcset_name, $image_srcset );
		}

		return true;
	}
}
