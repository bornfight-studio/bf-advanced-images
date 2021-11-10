<?php

namespace bfAdvancedImages\providers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFImageProvider {
	private static $instance = null;

	private $image_sizes = array();

	private function __construct() {
	}

	public static function get_instance(): ?BFImageProvider {
		if ( self::$instance === null ) {
			self::$instance = new BFImageProvider();
		}

		return self::$instance;
	}

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

	public function get_image_size( string $size_name = '' ): ?array {
		if ( empty( $size_name ) || ! isset( $this->image_sizes[ $size_name ] ) ) {
			return null;
		}

		return $this->image_sizes[ $size_name ];
	}

	public function get_all_image_sizes(): array {
		return $this->image_sizes;
	}
}
