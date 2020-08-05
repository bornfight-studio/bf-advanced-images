<?php


namespace bornfight\wpHelpers;


class TermsDataProvider {
	public function get_first_taxonomy( int $post_id, string $taxonomy ): ?object {
		$terms = get_the_terms( $post_id, $taxonomy );
		if ( empty( $terms ) ) {
			return null;
		}

		return get_the_terms( $post_id, $taxonomy )[0];
	}

	public function get_taxonomies( string $taxonomy = 'category', bool $hide_empty = false ): array {
		return get_terms( array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => $hide_empty
		) );
	}
}
