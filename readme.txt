=== BF Advanced Images ===
Contributors: jmucak
Donate link: /
Tags: advanced images, images, bf, custom images
Requires at least: 4.7
Tested up to: 5.8
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create images on demand

== Description ==

With this plugin you can create images on demand. You can disable default image sizes so
each image you upload won't be copied multiple times with different size. You can create your sizes for images and
size will be created when you call image and not on upload.

== Installation ==

Upload 'bf-advanced-images' to the '/wp-content/plugins/' directory

Activate the plugin through the 'Plugins' menu in WordPress

= How this plugin works =

1. Removing default image sizes

You can disable default image sizes so when uploading an image only original image will be uploaded

2. Adding new cached image sizes

You can create as many image size you want and only when you use this image size image with this size will be created.

`
if ( function_exists( 'bfai_register_image_sizes' ) ) {
    bfai_register_image_sizes( array(
        'image_200'     => array( 200, 0 ),
        'image_350_200' => array( 350, 200 ),
        'image_150_200' => array( 150, 200 ),
    ) );
}
`

3. Creating image sizes on demand

When image is called it will generate image size for that image

Example 1:

*bfai_get_image_by_size_name( int $attachment_id, string $size_name, bool $crop = false);*

Parameters:
**$attachment_id**
(int)(required)

**$size_name**
(string)(required) -> name of size name registered with bfai_register_image_sizes function

**$crop**
(bool)(optional)

`

$image_url = bfai_get_image_by_size_name( $attachment_id, 'image_200', true);

`

Example 2:

*bfai_get_image_by_custom_size( int $attachment_id, array $sizes, bool $crop = false);*

Parameters:
**$attachment_id**
(int)(required)

**$sizes**
(array)(required) -> Add integer width and height separated with comma

**$crop**
(bool)(optional)

`
$image_url = bfai_get_image_by_custom_size( $attachment_id, array( 200, 0 ), true );

`

== Screenshots ==

== Frequently Asked Questions ==

= What kind of support do you provide? =
Please post your question on plugin support forum

== Upgrade Notice ==
= 1.0.0 =
First Release

== Changelog ==
= 1.0.0 =
*Release Date - 27 October 2021*
First Release