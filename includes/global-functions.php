<?php

use wpAdvancedImagesPlugin\controller\WPAIMP_Image_Controller;

function wpaimp_register_sizes( array $sizes ): void {
	if ( ! empty( $sizes ) ) {
		$image_controller = WPAIMP_Image_Controller::get_instance();

		foreach ( $sizes as $size_name => $size ) {
			$image_controller->add_image_size( $size_name, $size );
		}
	}
}

function get_wpaimp_image_by_custom_size( int $image_id, array $sizes, bool $crop = false ): string {
	$image_controller = WPAIMP_Image_Controller::get_instance();

	return $image_controller->get_attachment_image_by_custom_size( $image_id, $sizes, $crop );
}

function get_wpaimp_image_by_size_name( int $image_id, string $size_name, bool $crop = false ): ?string {
	$image_controller = WPAIMP_Image_Controller::get_instance();

	return $image_controller->get_attachment_image_by_size_name( $image_id, $size_name, $crop );
}

function get_wpaimp_featured_image_by_size_name( int $post_id, string $size_name, bool $crop = false ): array {
	if ( empty( $size_name ) ) {
		return array();
	}
	$featured_image_id = get_post_thumbnail_id( $post_id );

	if ( empty( $featured_image_id ) ) {
		return array();
	}

	return array(
		'url' => get_wpaimp_image_by_size_name( $featured_image_id, $size_name, $crop ),
		'alt' => get_post_meta( $featured_image_id, '_wp_attachment_image_alt', true )
	);
}