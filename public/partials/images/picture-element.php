<?php
/**
 *
 * @var array $config
 *
 */

use wpAdvancedImagesPlugin\controller\WPAIMP_Image_Controller;

$image_controller = WPAIMP_Image_Controller::get_instance();
$src           = '';

if ( ! empty( $config['srcset'] ) ) {
	foreach ( $config['srcset'] as $srcset ) {
	    $image = $image_controller->get_attachment_image_by_size_name($srcset['image_id'], $srcset['size_name']);
		$src .= $image . ' ' . $srcset['breakpoint'] . ',';
	}
}

?>

<figure>
    <picture>
        <!--                                smaller size 480px, bigger 660px x 470px-->
        <source srcset="<?= $src; ?>">
        <!--                                lets try to implement webp images-->
        <source srcset="<?= bu( "ui/main-logo.webp" ) ?> 768w, <?= bu( "images/dummy/navi.webp" ) ?>"
                type="image/webp">
        <!--                                img tag for fallback if none of above work-->

        <img src="<? bu( "ui/main-logo.webp" ) ?>" alt="">
    </picture>
</figure>
