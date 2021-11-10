<?php

use bfAdvancedImages\controller\BFImageController;
use bfAdvancedImages\providers\BFImageProvider;

function bfai_get_image_by_custom_size( int $image_id, array $sizes, bool $crop = false ): string {
	$image_controller = new BFImageController();

	return $image_controller->get_attachment_image_by_custom_size( $image_id, $sizes, $crop );
}

function bfai_get_image_by_size_name( int $image_id, string $size_name, bool $crop = false ): string {
	$image_controller = new BFImageController();

	return $image_controller->get_attachment_image_by_size_name( $image_id, $size_name, BFImageProvider::get_instance(), $crop );
}

function bfai_register_image_sizes( array $sizes ): void {
	if ( ! empty( $sizes ) ) {
		foreach ( $sizes as $size_name => $size ) {
			if ( is_string( $size_name ) && is_array( $size ) ) {
				BFImageProvider::get_instance()->add_image_size( $size_name, $size );
			}
		}
	}
}