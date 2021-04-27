<?php

namespace wpAdvancedImagesPlugin\config;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_WordPress_Defaults {
	public static function get_wp_default_image_sizes(): array {
		return array(
			'thumbnail',
			'medium',
			'large',
			'medium_large',
			'1536x1536',
			'2048x2048',
		);
	}
}
