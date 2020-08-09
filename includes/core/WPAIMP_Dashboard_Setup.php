<?php

namespace wpAdvancedImagesPlugin\core;

use wpAdvancedImagesPlugin\controller\WPAIMP_Image_Controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPAIMP_Dashboard_Setup {
	public $capability = 'manage_options';

	public function init(): void {
		add_action( 'admin_menu', array( $this, 'register_options_submenu_page' ) );
		add_filter( 'media_row_actions', array( $this, 'media_row_action' ), 10, 2 );
	}


	public function register_options_submenu_page(): void {
		add_submenu_page(
			'tools.php',
			'WP Advanced Images Options',
			'WP Advanced Images Options',
			'manage_options',
			'wp-advanced-images-plugin',
			array( $this, 'get_options_menu_page_html' )
		);
	}

	/**
	 * Options page.
	 */
	public function get_options_menu_page_html(): void {
		if ( ! current_user_can( $this->capability ) ) {
			exit;
		}
		$image_controller = WPAIMP_Image_Controller::get_instance();

		// Check for actions
		if (
			isset( $_POST['fly_nonce'] ) // Input var okay.
			&& wp_verify_nonce( sanitize_key( $_POST['fly_nonce'] ), 'delete_all_fly_images' ) // Input var okay.
		) {
			// Delete all fly images.
			$image_controller->delete_all_advanced_images();
			echo '<div class="updated"><p>' . esc_html__( 'All cached images created on the fly have been deleted.', 'fly-images' ) . '</p></div>';
		} elseif (
			isset( $_GET['delete-fly-image'], $_GET['ids'], $_GET['fly_nonce'] ) // Input var okay.
			&& wp_verify_nonce( sanitize_key( $_GET['fly_nonce'] ), 'delete_fly_image' ) // Input var okay.
		) {
			// Delete all fly images for certain attachments.
			$ids = array_map( 'intval', array_map( 'trim', explode( ',', sanitize_key( $_GET['ids'] ) ) ) ); // Input var okay.
			if ( ! empty( $ids ) ) {
				foreach ( $ids as $id ) {
					$image_controller->delete_attachment_fly_images( $id );
				}
				echo '<div class="updated"><p>' . esc_html__( 'Deleted all fly images for this image.', 'fly-images' ) . '</p></div>';
			}
		}

		// Show the template
		load_template( WPAIMP_PLUGIN_PATH . '/admin/wp-advanced-images-plugin-admin-display.php' );
	}

	/**
	 * Add a new row action to media library items.
	 *
	 * @param array $actions
	 * @param object $post
	 *
	 * @return array
	 */
	public function media_row_action( $actions, $post ) {
		if ( 'image/' !== substr( $post->post_mime_type, 0, 6 ) || ! current_user_can( $this->capability ) ) {
			return $actions;
		}

		$url                         = wp_nonce_url( admin_url( 'tools.php?page=fly-images&delete-fly-image&ids=' . $post->ID ), 'delete_fly_image', 'fly_nonce' );
		$actions['fly-image-delete'] = '<a href="' . esc_url( $url ) . '" title="' . esc_attr( __( 'Delete all cached image sizes for this image', 'fly-images' ) ) . '">' . __( 'Delete Fly Images', 'fly-images' ) . '</a>';

		return $actions;
	}
}
