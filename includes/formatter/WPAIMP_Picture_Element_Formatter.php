<?php

namespace wpAdvancedImagesPlugin\formatter;

use wpAdvancedImagesPlugin\controller\WPAIMP_Image_Controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Picture_Element_Formatter {
	public static function format_srcset_for_picture_element( array $config ): string {
		$image_controller = WPAIMP_Image_Controller::get_instance();
		$src              = '';

		if ( ! empty( $config['srcset'] ) ) {
			foreach ( $config['srcset'] as $srcset ) {
				$image = $image_controller->get_attachment_image_by_size_name( $srcset['image_id'], $srcset['size_name'] );
				$src   .= $image . ' ' . $srcset['breakpoint'] . ',';
			}
		}

		return $src;
	}
}
