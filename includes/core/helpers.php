<?php

use wpAdvancedImagesPlugin\controller\WPAIMP_Image_Controller;

if ( ! function_exists( 'fly_add_image_size' ) ) {
	/**
	 * Add image sizes to the JB\FlyImages\Core class.
	 *
	 * @param string $size_name
	 * @param integer $width
	 * @param integer $height
	 * @param boolean $crop
	 *
	 * @return boolean
	 */
	function fly_add_image_size( $size_name = '', $width = 0, $height = 0, $crop = false ) {
		$image_sizes_controller = WPAIMP_Image_Controller::get_instance();

		return $image_sizes_controller->add_image_size( $size_name, $width, $height, $crop );
	}
}

if ( ! function_exists( 'fly_get_attachment_image_src' ) ) {
	/**
	 * Get a dynamically generated image URL from the JB\FlyImages\Core class.
	 *
	 * @param integer $attachment_id
	 * @param mixed $size
	 * @param boolean $crop
	 *
	 * @return array
	 */
	function fly_get_attachment_image_src( $attachment_id = 0, $size = '', $crop = false ) {
		$image_sizes_controller = WPAIMP_Image_Controller::get_instance();

		return $image_sizes_controller->get_attachment_image_src( $attachment_id, $size, $crop );
	}
}

if ( ! function_exists( 'fly_get_image_size' ) ) {
	/**
	 * Get a previously declared image size from the JB\FlyImages\Core class.
	 *
	 * @param string $size_name
	 *
	 * @return array
	 */
	function fly_get_image_size( $size_name = '' ) {
		$image_sizes_controller = WPAIMP_Image_Controller::get_instance();

		return $image_sizes_controller->get_image_size( $size_name );
	}
}

if ( ! function_exists( 'fly_get_all_image_sizes' ) ) {
	/**
	 * Get all declared images sizes from the JB\FlyImages\Core class.
	 *
	 * @return array
	 */
	function fly_get_all_image_sizes() {
		$image_sizes_controller = WPAIMP_Image_Controller::get_instance();

		return $image_sizes_controller->get_all_image_sizes();
	}
}
