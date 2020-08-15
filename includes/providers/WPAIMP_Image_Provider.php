<?php

namespace wpAdvancedImagesPlugin\providers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Image_Provider {
	private static $instance = null;

	private $configs = array();

	private function __construct() {
	}

	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new WPAIMP_Image_Provider();
		}

		return self::$instance;
	}


	/**
	 * Add config
	 *
	 *
	 * @param string $config_name
	 * @param array $srcset
	 *
	 * @return bool
	 *
	 */

// Example: $srcset = array(
//array(
//'breakpoint' => 768w,
//'size_name' => $size_name
//'image_id' => $image_id
//),
// )
	public function add_config( string $config_name, array $srcset = array() ): bool {
		if ( empty( $config_name ) ) {
			return false;
		}

		$this->configs[ $config_name ] = array(
			'srcset' => $srcset
		);

		return true;
	}

	public function get_config( string $config_name ): array {
		if ( empty( $config_name ) ) {
			return array();
		}

		if ( ! empty( $this->configs[ $config_name ] ) ) {
			return $this->configs[ $config_name ];
		}

		return array();
	}

	public function get_configs(): array {
		return $this->configs;
	}

	public function get_picture_element( string $config_name, array $fallback_image ): string {
		if ( empty( $config_name ) ) {
			return '';
		}

		if ( $this->configs[ $config_name ] ) {
			return get_public_wpaimp_partial( 'images/picture-element', array(
				'config'         => $this->configs[ $config_name ],
				'fallback_image' => $fallback_image
			), true );
		}

		return '';
	}
}
