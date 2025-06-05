<?php

namespace bfAdvancedImages\providers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use bfAdvancedImages\core\BFConstants;
use bfAdvancedImages\core\BFImagesDirectoryOptions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BFAdminOptionsHTMLProvider {
	public function get_is_writable_option_partial( BFImagesDirectoryOptions $bf_images_directory_options ): string {
		if ( $bf_images_directory_options->is_advanced_images_dir_writable() ) {
			return sprintf( '
				<p>%s</p>
			', esc_html( __( 'Directory is writable!', BFConstants::DOMAIN_NAME_ADMIN ) ) );
		}

		return sprintf( '<p>%s</p>', esc_html( __( 'Directory is not writable!', BFConstants::DOMAIN_NAME_ADMIN ) ) );
	}

	public function get_gd_library_status(): string {
		$gd_info = gd_info();
		$status = array();

		// Check if GD is installed
		if ( ! extension_loaded( 'gd' ) ) {
			return sprintf( '<p class="error">%s</p>', 
				esc_html( __( 'PHP GD library is not installed. WebP conversion will not work.', BFConstants::DOMAIN_NAME_ADMIN ) ) 
			);
		}

		// Check WebP support
		if ( ! isset( $gd_info['WebP Support'] ) || ! $gd_info['WebP Support'] ) {
			return sprintf( '<p class="error">%s</p>', 
				esc_html( __( 'PHP GD library is installed but WebP support is not available. WebP conversion will not work.', BFConstants::DOMAIN_NAME_ADMIN ) ) 
			);
		}

		return sprintf( '<p class="success">%s</p>', 
			esc_html( __( 'PHP GD library is installed with WebP support. WebP conversion is available.', BFConstants::DOMAIN_NAME_ADMIN ) ) 
		);
	}

	public function get_webp_debug_info(): string {
		$output = '<div class="webp-debug-info">';
		$output .= '<h3>' . esc_html( __( 'WebP Conversion Debug Info', BFConstants::DOMAIN_NAME_ADMIN ) ) . '</h3>';
		
		// Check if WebP conversion is enabled
		$webp_enabled = get_option( BFConstants::BFAI_WEBP_CONVERSION_OPTION, false );
		$output .= '<p><strong>' . esc_html( __( 'WebP Conversion Enabled:', BFConstants::DOMAIN_NAME_ADMIN ) ) . '</strong> ' . 
			( $webp_enabled ? 'Yes' : 'No' ) . '</p>';

		// Check GD info
		$gd_info = gd_info();
		$output .= '<p><strong>' . esc_html( __( 'GD Version:', BFConstants::DOMAIN_NAME_ADMIN ) ) . '</strong> ' . 
			( isset( $gd_info['GD Version'] ) ? esc_html( $gd_info['GD Version'] ) : 'Unknown' ) . '</p>';
		
		$output .= '<p><strong>' . esc_html( __( 'WebP Support:', BFConstants::DOMAIN_NAME_ADMIN ) ) . '</strong> ' . 
			( isset( $gd_info['WebP Support'] ) && $gd_info['WebP Support'] ? 'Yes' : 'No' ) . '</p>';

		// Check if imagewebp function exists
		$output .= '<p><strong>' . esc_html( __( 'imagewebp() Function:', BFConstants::DOMAIN_NAME_ADMIN ) ) . '</strong> ' . 
			( function_exists( 'imagewebp' ) ? 'Available' : 'Not Available' ) . '</p>';

		// Check upload directory permissions
		$upload_dir = wp_upload_dir();
		$bf_images_dir = $upload_dir['basedir'] . '/bf-advanced-images';
		$output .= '<p><strong>' . esc_html( __( 'BF Images Directory:', BFConstants::DOMAIN_NAME_ADMIN ) ) . '</strong> ' . 
			esc_html( $bf_images_dir ) . '</p>';
		$output .= '<p><strong>' . esc_html( __( 'Directory Writable:', BFConstants::DOMAIN_NAME_ADMIN ) ) . '</strong> ' . 
			( wp_is_writable( $bf_images_dir ) ? 'Yes' : 'No' ) . '</p>';

		$output .= '</div>';
		return $output;
	}
}