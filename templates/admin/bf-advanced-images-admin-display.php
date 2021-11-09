<?php

use bfAdvancedImages\core\BFConstants;
use bfAdvancedImages\core\BFImagesDirectoryOptions;
use bfAdvancedImages\providers\BFAdminOptionsHTMLProvider;
use bfAdvancedImages\providers\BFAdminOptionsProvider;

$bf_image_directory_options     = new BFImagesDirectoryOptions();
$bf_admin_options_html_provider = new BFAdminOptionsHTMLProvider();
$bf_admin_options_provider      = new BFAdminOptionsProvider();
$deleted_images                 = $bf_admin_options_provider->delete_cached_images( $_POST, $bf_image_directory_options );
?>
<div class="wrap">
    <h2><?php esc_html_e( 'Advanced Images', BFConstants::DOMAIN_NAME_ADMIN ); ?></h2>

    <div>
        <p>
			<?php
			esc_html_e( 'BF Advanced Images Directory: ', BFConstants::DOMAIN_NAME_ADMIN );

			echo esc_html( $bf_image_directory_options->get_bf_images_path() );
			?>
        </p>

		<?php echo wp_kses( $bf_admin_options_html_provider->get_is_writable_option_partial( $bf_image_directory_options ), array( 'p' => array() ) ) ?>
    </div>

    <div>
        <form action="" method="post">
            <input type="submit"
                   value="<?php esc_html_e( 'Delete All Cached Images', BFConstants::DOMAIN_NAME_ADMIN ); ?>"
                   name="delete_all_cached_images" class="button button-primary button-large">
			<?php if ( ! empty( $deleted_images ) ) { ?>
                <p><?php esc_html_e( 'Images deleted', BFConstants::DOMAIN_NAME_ADMIN ); ?></p>
			<?php } ?>
        </form>
    </div>
</div> <!-- .wrap -->
