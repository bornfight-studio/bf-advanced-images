<?php


namespace bornfight\wpHelpers;


use Exception;
use WP_Post;

class ImageProvider {
	
	public const PICTURE_CONFIG_NORMAL = '1000x1001';
	
	public const SMALL_1x = 'small_1x';
	public const SMALL_2x = 'small_2x';
	public const LARGE_1x = 'large_1x';
	public const LARGE_2x = 'large_2x';
	
	/**
	 * @var array
	 */
	private static $config;
	
	/**
	 * @var null
	 */
	private static $instance = null;
	
	/**
	 * ImageProvider constructor.
	 */
	private function __construct() {
	}
	
	/**
	 * @return ImageProvider
	 */
	public static function getInstance() {
		if ( self::$instance === null ) {
			self::register_image_sizes();
			self::$instance = new ImageProvider();
		}
		
		return self::$instance;
	}
	
	private static function add_picture_element_configs(): void {
		self::$config[ self::PICTURE_CONFIG_NORMAL ] = [
			'small'        => 1000,
			'large'        => 1001,
			self::SMALL_1x => 'small_picture_element_1x',
			self::SMALL_2x => 'small_picture_element_2x',
			self::LARGE_1x => 'large_picture_element_1x',
			self::LARGE_2x => 'large_picture_element_2x',
		];
	}
	
	public static function register_image_sizes(): void {
		
		self::add_picture_element_configs();
		
		if ( function_exists( 'fly_add_image_size' ) ) {
			fly_add_image_size( 'thumbnail', 100, 100, true );
			fly_add_image_size( 'normal', 1600, 900, true );
			fly_add_image_size( 'large_picture_element_1x', 1600, 900, false );
			fly_add_image_size( 'large_picture_element_2x', 3200, 1800, false );
			fly_add_image_size( 'small_picture_element_1x', 640, 360, false );
			fly_add_image_size( 'small_picture_element_2x', 960, 540, false );
			
		} else {
			add_action( 'admin_notices', function() {
				?>
				<div class="notice notice-error">
		            <h2>Missing <i>Fly Dynamic Image Resizer plugin </i></h2>
		            <p>
		                <strong>
		                    <a href="https://wordpress.org/plugins/fly-dynamic-image-resizer/">Download</a>
		                </strong>
		            </p>
		        </div>
				<?php
			} );
			
			return;
		}
	}
	
	/**
	 * @param WP_Post|array $data
	 * @param string $config_key
	 * @param string $size
	 * @param bool $lazy_load
	 * @param string $placeholder_size
	 *
	 * @return string
	 * @throws Exception
	 */
	public function get_picture_image_with_placeholder( $data, string $config_key, string $size, bool $lazy_load = true, $placeholder_size = 'thumbnail' ): string {
		
		if ( ! isset( self::$config[ $config_key ] ) ) {
			throw new Exception( 'There is no config for this picture config key. Please add the config' );
		}
		
		$placeholder_image = $this->get_image_data( $data, $placeholder_size );
		$image_data        = $this->get_picture_element_data( $data, $config_key );
		$backup_image      = $this->get_image_data( $data, $size );
		
		return get_partial( 'images/picture/picture-image', [
			'image_data'        => $image_data,
			'backup_image'      => $backup_image,
			'placeholder_image' => $placeholder_image,
			'lazy_load'         => $lazy_load,
			'config'            => self::$config[ $config_key ],
		], true );
	}
	
	/**
	 * @param WP_Post|array $data
	 * @param string $config_key
	 * @param string $size
	 * @param bool $lazy_load
	 *
	 * @return string
	 * @throws Exception
	 */
	public function get_picture_image( $data, string $config_key, string $size, bool $lazy_load = true ): string {
		
		if ( ! isset( self::$config[ $config_key ] ) ) {
			throw new Exception( 'There is no config for this picture config key. Please add the config' );
		}
		
		$image_data   = $this->get_picture_element_data( $data, $config_key );
		$backup_image = $this->get_image_data( $data, $size );
		
		return get_partial( 'images/picture/picture-image', [
			'image_data'   => $image_data,
			'backup_image' => $backup_image,
			'lazy_load'    => $lazy_load,
			'config'       => self::$config[ $config_key ],
		], true );
	}
	
	/**
	 * @param WP_Post|array $data
	 * @param string $size
	 * @param bool $lazy_load
	 *
	 * @return string
	 */
	public function get_background_image( $data, string $size, bool $lazy_load = true ): string {
		
		$image_data = $this->get_image_data( $data, $size );
		
		return get_partial( 'images/background/background-image', [
			'image_data' => $image_data,
			'lazy_load'  => $lazy_load,
		], true );
	}
	
	/**
	 * @param WP_Post|array $data
	 * @param string $size
	 * @param bool $lazy_load
	 * @param string $placeholder_size
	 *
	 * @return string
	 */
	public function get_background_image_with_placeholder( $data, string $size, bool $lazy_load = true, $placeholder_size = 'thumbnail' ): string {
		
		$placeholder_image = $this->get_image_data( $data, $placeholder_size );
		$image_data        = $this->get_image_data( $data, $size );
		
		return get_partial( 'images/background/background-image-with-placeholder', [
			'image_data'        => $image_data,
			'placeholder_image' => $placeholder_image,
			'lazy_load'         => $lazy_load,
		], true );
	}
	
	/**
	 * @param WP_Post|array $data
	 * @param string $size
	 * @param string $caption
	 * @param bool $lazy_load
	 *
	 * @return string
	 */
	public function get_image_tag( $data, string $size, string $caption = '', bool $lazy_load = true ): string {
		
		$image_data = $this->get_image_data( $data, $size );
		
		return get_partial( 'images/tag/tag-image', [
			'image_data' => $image_data,
			'lazy_load'  => $lazy_load,
			'caption'    => $caption,
		], true );
	}
	
	/**
	 * @param WP_Post|array $data
	 * @param string $size
	 * @param string $caption
	 * @param bool $lazy_load
	 * @param string $placeholder_size
	 *
	 * @return string
	 */
	public function get_image_tag_with_placeholder( $data, string $size, string $caption = '', bool $lazy_load = true, $placeholder_size = 'thumbnail' ): string {
		
		$placeholder_image = $this->get_image_data( $data, $placeholder_size );
		$image_data        = $this->get_image_data( $data, $size );
		
		return get_partial( 'images/tag/tag-image-with-placeholder', [
			'image_data'        => $image_data,
			'placeholder_image' => $placeholder_image,
			'lazy_load'         => $lazy_load,
			'caption'           => $caption,
		], true );
	}
	
	/**
	 * @param WP_Post|array $data
	 * @param string $size
	 *
	 * @return array
	 */
	private function get_image_data( $data, string $size ): array {
		if ( is_object( $data ) ) {
			$image_id        = get_post_thumbnail_id( $data );
			$response        = fly_get_attachment_image_src( $image_id, $size );
			$response['alt'] = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			
			return $response;
		}
		
		$response        = fly_get_attachment_image_src( $data['ID'], $size );
		$response['alt'] = $data['alt'];
		
		return $response;
	}
	
	/**
	 * @param $data
	 * @param string $config_key
	 *
	 * @return array
	 */
	private function get_picture_element_data( $data, string $config_key ): array {
		$response[ self::SMALL_1x ] = $this->get_image_data( $data, self::$config[ $config_key ][ self::SMALL_1x ] );
		$response[ self::SMALL_2x ] = $this->get_image_data( $data, self::$config[ $config_key ][ self::SMALL_2x ] );
		$response[ self::LARGE_1x ] = $this->get_image_data( $data, self::$config[ $config_key ][ self::LARGE_1x ] );
		$response[ self::LARGE_2x ] = $this->get_image_data( $data, self::$config[ $config_key ][ self::LARGE_2x ] );
		
		return $response;
	}
}
