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
}