<?php
/**
 *
 * @var array $config
 * @var array $fallback_image
 *
 */

use wpAdvancedImagesPlugin\controller\WPAIMP_Image_Controller;
use wpAdvancedImagesPlugin\formatter\WPAIMP_Picture_Element_Formatter;

if ( ! empty( $fallback_image['image']['ID'] ) ) { ?>
    <picture>
        <!--                                smaller size 480px, bigger 660px x 470px-->
        <source srcset="<?= WPAIMP_Picture_Element_Formatter::format_srcset_for_picture_element( $config ); ?>">
        <!--                                lets try to implement webp images-->
        <source srcset="<?= bu( "ui/main-logo.webp" ) ?> 768w, <?= bu( "images/dummy/navi.webp" ) ?>"
                type="image/webp">
        <!--                                img tag for fallback if none of above work-->

        <img src="<? WPAIMP_Image_Controller::get_instance()->get_attachment_image_by_size_name( $fallback_image['image']['ID'], $fallback_image['size_name'] ) ?>"
             alt="<?= $fallback_image['image']['alt']; ?>">
    </picture>
<?php } ?>
