<?php


namespace wpAdvancedImagesPlugin\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Directory_Options {
	/**
	 *
	 * Create directory if not exists
	 *
	 */
	public function init() {
		$this->create_dir_if_not_exists();

//		add_action( 'delete_attachment', array( $this, 'delete_attachment_fly_images' ) );
	}

	/**
	 * Get path to advanced images directory
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	public function get_advanced_images_path( $path = '' ) {
		if ( empty( $this->advanced_images_dir ) ) {
			$wp_upload_dir = wp_upload_dir();

			return $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'advanced-images' . ( '' !== $path ? DIRECTORY_SEPARATOR . $path : '' );
		} else {
			return $this->advanced_images_dir . ( '' !== $path ? DIRECTORY_SEPARATOR . $path : '' );
		}
	}

	/**
	 * Create advanced images dir if not exists
	 *
	 */
	public function create_dir_if_not_exists(): void {
		$directory_path = $this->get_advanced_images_path();

		if ( ! is_dir( $directory_path ) ) {
			wp_mkdir_p( $directory_path );
		}
	}

	/**
	 * Check if advanced images dir exists and if is writable
	 *
	 * @return boolean
	 */
	public function is_advanced_images_dir_writable(): bool {
		$directory_path = $this->get_advanced_images_path();

		return is_dir( $directory_path ) && wp_is_writable( $directory_path );
	}

	/**
	 * Get a file name based on parameters.
	 *
	 * @param string $file_name
	 * @param string $width
	 * @param string $height
	 * @param boolean $crop
	 *
	 * @return string
	 */
	public function get_wpaimp_file_name( $file_name, $width, $height, $crop ) {
		$file_name_only = pathinfo( $file_name, PATHINFO_FILENAME );
		$file_extension = pathinfo( $file_name, PATHINFO_EXTENSION );

		$crop_extension = '';
		if ( true === $crop ) {
			$crop_extension = '-c';
		} elseif ( is_array( $crop ) ) {
			$crop_extension = '-' . implode( '', array_map( function ( $position ) {
					return $position[0];
				}, $crop ) );
		}

		/**
		 * Note: intval() for width and height is based on Image_Processor::resize()
		 */
		return $file_name_only . '-' . intval( $width ) . 'x' . intval( $height ) . $crop_extension . '.' . $file_extension;
	}

	/**
	 * Get the full path of an image based on it's absolute path.
	 *
	 * @param string $absolute_path
	 *
	 * @return string
	 */
	public function get_wpaimp_path( $absolute_path = '' ) {
		$wp_upload_dir = wp_upload_dir();
		$path          = $wp_upload_dir['baseurl'] . str_replace( $wp_upload_dir['basedir'], '', $absolute_path );

		return str_replace( DIRECTORY_SEPARATOR, '/', $path );
	}
}
