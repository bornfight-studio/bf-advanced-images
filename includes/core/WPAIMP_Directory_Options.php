<?php


namespace wpAdvancedImagesPlugin\core;


class WPAIMP_Directory_Options {
	public function init(): void {

	}

	public function create_upload_dir( string $path = '' ): string {
		$wp_upload_dir = wp_upload_dir();

		if ( ! empty( $wp_upload_dir ) ) {
			return $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'advanced-images' . ( '' !== $path ? DIRECTORY_SEPARATOR . $path : '' );
		}

		return '';
	}
}
