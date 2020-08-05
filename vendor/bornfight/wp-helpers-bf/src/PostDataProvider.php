<?php


namespace bornfight\wpHelpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class PostDataProvider {
	public function get_post_data( string $post_type = 'post', int $posts_per_page = - 1, int $paged = null ): array {

		$args = [
			'post_type'      => $post_type,
			'posts_per_page' => $posts_per_page,
			'post_status'    => 'publish'
		];

		if ( ! empty( $paged ) ) {
			$args['paged'] = $paged;
		}

		$query = new \WP_Query( $args );

		$response['max_pages'] = $query->max_num_pages;
		$response['posts']     = $query->get_posts();

		return $response;
	}
}
