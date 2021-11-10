<a href="http://www.bornfight.com">
<img width="84px" src="https://www.bornfight.com/wp-content/themes/bornfight-web-2020/static/ui/bf-logo-dark.svg" title="Bornfight" alt="Bornfight">
</a>

## BF Advanced Images

> WordPress plugin for converting pages and post types to modals

## Table of Contents

- [Features](#features)
- [Usage](#usage)
- [License](#license)


## Features

- converting pages to modal
- converting default post type to modal
- converting custom post types to modal
- registering custom modal templates
- custom js events

## Usage

1. Converting Pages to modals

Edit Page -> Is Modal (Yes)

Choose archive page (page that opens in background of modal)


2. Converting Post Types to modal

BF Modal Options -> Choose post type to convert

3. Registering modal templates

Use bfml_register_modal_templates( array $templates ) {}

```
$templates = array('Default Modal Template', 'Test Modal Template');

if ( function_exists( 'bfml_register_modal_templates' ) ) {
    bfml_register_modal_templates( array( 'Default Template', 'Test Modal Template' ) );
 }
```

Name of templates are created with WordPress function sanitize_title_with_dashes()

Example: Default Modal Template -> default-modal-template

4. Opening popups
* add class js-bfml-modal-trigger -> it triggers endpoint to populate modal
* data-post-data-id (required) -> id of post/page to pull content from
* data-return-url(optional) -> returning URL, by default returns to current URL modal is opened from

```
<a href="<?php echo get_permalink( $post_id ); ?>" class="js-bfml-modal-trigger" data-post-data-id="12">
    This is a test post type Link
</a>
```

5Custom JS Events
* bfml:init-modal
* bfml:open-modal
* bfml:close-modal
* bfml:populate-modal
* bfml:after-populate-modal

## License

[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](http://badges.mit-license.org)

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2021 © <a href="https://www.bornfight.com" target="_blank">Bornfight</a>.
