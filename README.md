## BF Advanced Images

> WordPress plugin for caching images, creating images on demand, removing registered image sizes

## Table of Contents

- [Features](#features)
- [Usage](#usage)
- [License](#license)

## Features

- removing default image sizes
- adding new cached image sizes
- creating image sizes on demand

## Usage

1. Removing default image sizes

You can disable default image sizes so when uploading an image only original image will be uploaded

2. Adding new cached image sizes

You can create as many image size you want and only when you use this image size image with this size will be created.

```
if ( function_exists( 'bfai_register_image_sizes' ) ) {
    bfai_register_image_sizes( array(
        'image_200'     => array( 200, 0 ),
        'image_350_200' => array( 350, 200 ),
        'image_150_200' => array( 150, 200 ),
    ) );
}
```

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

```

$image_url = bfai_get_image_by_size_name( $attachment_id, 'image_200', true);

```

Example 2:

*bfai_get_image_by_custom_size( int $attachment_id, array $sizes, bool $crop = false);*

Parameters:
**$attachment_id**
(int)(required)

**$sizes**
(array)(required) -> Add integer width and height separated with comma

**$crop**
(bool)(optional)

```
$image_url = bfai_get_image_by_custom_size( $attachment_id, array( 200, 0 ), true );

```

## Support

Reach out to us:

- email <a href="mailto: wpadmin@bornfight.com" target="_blank">`wpadmin@bornfight.com`</a>

## License

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2021 © <a href="https://www.bornfight.com" target="_blank">Bornfight</a>.
