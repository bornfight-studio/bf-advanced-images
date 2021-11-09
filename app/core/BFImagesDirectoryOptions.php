<?php

namespace bfAdvancedImages\core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_Filesystem_Direct;

class BFImagesDirectoryOptions {
	private $images_dir = '';

	public function init(): void {
		$this->create_dir_if_not_exists();
	}

	public function create_dir_if_not_exists(): void {
		if ( ! is_dir( $this->get_bf_images_path() ) ) {
			wp_mkdir_p( $this->get_bf_images_path() );
		}
	}

	public function get_bf_images_path( string $path = '' ): string {
		if ( empty( $this->images_dir ) ) {
			$wp_upload_dir = wp_upload_dir();

			if ( empty( $wp_upload_dir['basedir'] ) ) {
				return '';
			}

			$images_folder_path = $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'bf-advanced-images';

			if ( empty( $path ) ) {
				return trailingslashit( $images_folder_path );
			}

			return trailingslashit( $images_folder_path ) . $path;
		}

		if ( empty( $path ) ) {
			return trailingslashit( $this->images_dir );
		}

		return trailingslashit( $this->images_dir ) . $path;
	}

	public function is_advanced_images_dir_writable(): bool {
		$images_path = $this->get_bf_images_path();

		return is_dir( $images_path ) && wp_is_writable( $images_path );
	}

	public function get_bf_images_file_name( string $file_name, int $width, int $height, bool $crop ): string {
		$file_name_only = pathinfo( $file_name, PATHINFO_FILENAME );
		$file_extension = pathinfo( $file_name, PATHINFO_EXTENSION );

		$crop_extension = '';
		if ( true === $crop ) {
			$crop_extension = '-c';
		}

		return $file_name_only . '-' . $width . 'x' . $height . $crop_extension . '.' . $file_extension;
	}

	public function get_bf_images_full_path( string $absolute_path = '' ) {
		$wp_upload_dir = wp_upload_dir();
		$path          = $wp_upload_dir['baseurl'] . str_replace( $wp_upload_dir['basedir'], '', $absolute_path );

		return str_replace( DIRECTORY_SEPARATOR, '/', $path );
	}

	public function delete_all_bf_images(): bool {
		require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
		require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
		$fileSystemDirect = new WP_Filesystem_Direct( false );

		return $fileSystemDirect->rmdir( $this->get_bf_images_path(), true );
	}
}
