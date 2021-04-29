<?php

namespace bornfight\wpHelpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Exception;

class PluginPartialFinder {
	/**
	 * @var null|PluginPartialFinder
	 */
	private static $instance = null;

	public const ADMIN_PARTIAL_FOLDER = 'admin/partials';
	public const PUBLIC_PARTIAL_FOLDER = 'public/partials';


	private function __construct() {
	}

	/**
	 * @return PluginPartialFinder|null
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new PluginPartialFinder();
		}

		return self::$instance;
	}

	public function get_partial_path( $partial, $folder ): string {
		$folder_path = $this->get_folder_path( $folder );
		$file_path   = plugin_dir_path( dirname( __FILE__, 4 ) ) . DIRECTORY_SEPARATOR . $folder_path . DIRECTORY_SEPARATOR . $partial . '.php';
		if ( ! file_exists( $file_path ) ) {
			throw new Exception( 'Partial file does not exist: ' . $file_path );
		}

		return $file_path;
	}

	/**
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 * @param $partial
	 * @param null $data
	 * @param bool $return
	 * @param string $folder
	 *
	 * @return false|string
	 * @throws Exception
	 */
	public function get_partial( $partial, $data = null, $return = false, $folder = self::ADMIN_PARTIAL_FOLDER ) {
		$file_path = $this->get_partial_path( $partial, $folder );

		if ( $return ) {
			return $this->get_internal( $file_path, $data );
		}

		$this->render_internal( $file_path, $data );
	}

	// @codingStandardsIgnoreStart
	private function render_internal( string $_view_file_, array $_data_ = null ) {
		// we use special variable names here to avoid conflict when extracting data

		if ( $_data_ !== null ) {
			extract( $_data_, EXTR_OVERWRITE );
		}

		require $_view_file_;
	}

	private function get_internal( $_view_file_, array $_data_ = null ) {
		// we use special variable names here to avoid conflict when extracting data
		if ( $_data_ !== null ) {
			extract( $_data_, EXTR_OVERWRITE );
		}

		ob_start();
		ob_implicit_flush( 0 );
		require $_view_file_;

		return ob_get_clean();
	}

	// @codingStandardsIgnoreEnd

	public function get_folder_path( string $folder = 'admin' ): string {
		switch ( $folder ) {
			case 'admin':
				return self::ADMIN_PARTIAL_FOLDER;
			case 'public':
				return self::PUBLIC_PARTIAL_FOLDER;
		}

		return $folder;
	}
}
