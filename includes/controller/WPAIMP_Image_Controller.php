<?php

namespace wpAdvancedImagesPlugin\controller;

use wpAdvancedImagesPlugin\core\WPAIMP_Directory_Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Image_Controller {
	private static $instance = null;
	private $image_sizes = array();

	private function __construct() {
	}

	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new WPAIMP_Image_Controller();
		}

		return self::$instance;
	}

	/**
	 * Add dynamic image size
	 *
	 * @param string $size_name
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 *
	 * @return bool
	 */
	public function add_image_size( string $size_name = '', array $size = array(), bool $crop = false ): bool {
		if ( empty( $size_name ) || empty( $size[0] || empty( $size[1] ) ) ) {
			return false;
		}

		$this->image_sizes[ $size_name ] = array(
			'size' => array( $size[0], $size[1] ),
			'crop' => $crop
		);

		return true;
	}

	/**
	 * Get image size by size name
	 *
	 * @param string $size_name
	 *
	 * @return array|null
	 */
	public function get_image_size( string $size_name = '' ): ?array {
		if ( empty( $size_name ) || ! isset( $this->image_sizes[ $size_name ] ) ) {
			return null;
		}

		return $this->image_sizes[ $size_name ];
	}

	/**
	 * Get all image sizes
	 *
	 * @return array
	 *
	 */
	public function get_all_image_sizes(): array {
		return $this->image_sizes;
	}

	/**
	 * Get image by size name
	 *
	 * @param int|null $attachment_id
	 * @param string $size_name
	 * @param bool $crop
	 *
	 * @return string
	 */
	public function get_attachment_image_by_size_name( ?int $attachment_id, string $size_name, bool $crop = false ): string {
		if ( empty( $attachment_id ) || empty( $size_name ) ) {
			return '';
		}

		// if size name is equal 'full' it's default original image
		if ( 'full' === $size_name ) {
			$original_image = wp_get_attachment_image_src( $attachment_id, 'full' );

			if ( ! empty( $original_image ) ) {
				return $original_image['src'];
			}

			return '';
		}

		$image_size = $this->get_image_size( $size_name );
		if ( empty( $image_size ) ) {
			return '';
		}
		$width  = $image_size['size'][0];
		$height = $image_size['size'][1];

		$image = $this->get_image( $attachment_id, array( $width, $height ), $crop );

		return $image;
	}

	/**
	 * Get image by custom size
	 *
	 * @param int|null $attachment_id
	 * @param string $size
	 * @param bool $crop
	 *
	 * @return string
	 */
	public function get_attachment_image_by_custom_size( ?int $attachment_id = null, array $size = array(), bool $crop = false ): string {
		if ( empty( $attachment_id ) || empty( $size ) ) {
			return '';
		}

		return $this->get_image( $attachment_id, array( $size[0], $size[1] ), $crop );
	}

	/**
	 * Logic behind getting image
	 *
	 * @param int $attachment_id
	 * @param array $size
	 * @param bool $crop
	 *
	 * @return string
	 */
	public function get_image( int $attachment_id, array $size = array(), bool $crop = false ): string {
		if ( empty( $size[0] ) ) {
			return '';
		}

		$image             = wp_get_attachment_metadata( $attachment_id );
		$directory_options = new WPAIMP_Directory_Options();
		// Get file path
		$fly_dir       = $directory_options->get_advanced_images_path( $attachment_id );
		$fly_file_path = $fly_dir . DIRECTORY_SEPARATOR . $directory_options->get_fly_file_name( basename( $image['file'] ), $size[0], $size[1], $crop );

		// Check if file exsists
		if ( file_exists( $fly_file_path ) ) {
			return $directory_options->get_fly_path( $fly_file_path );
		}

		// Check if images directory is writeable
		if ( ! $directory_options->is_advanced_images_dir_writable() ) {
			return array();
		}

		// Get WP Image Editor Instance
		$image_path   = apply_filters( 'fly_attached_file', get_attached_file( $attachment_id ), $attachment_id, $size, $crop );
		$image_editor = wp_get_image_editor( $image_path );
		if ( ! is_wp_error( $image_editor ) ) {
			// Create new image
			$image_editor->resize( $size[0], $size[1], $crop );
			$image_editor->save( $fly_file_path );

			// Trigger action
			do_action( 'fly_image_created', $attachment_id, $fly_file_path );

			return $directory_options->get_fly_path( $fly_file_path );
		}

		return '';
	}

	// Delete not working TODO
	public function delete_attachment_advanced_images( ?int $attachment_id ) {
		WP_Filesystem();
		global $wp_filesystem;
		$directory_options = new WPAIMP_Directory_Options();

		return $wp_filesystem->rmdir( $directory_options->get_advanced_images_path( $attachment_id ), true );
	}

	public function delete_all_advanced_images() {
		WP_Filesystem();
		global $wp_filesystem;
		$directory_options = new WPAIMP_Directory_Options();

		if ( $wp_filesystem->rmdir( $directory_options->get_advanced_images_path(), true ) ) {
			$directory_options->create_dir_if_not_exists();

			return true;
		}

		return false;
	}
}
