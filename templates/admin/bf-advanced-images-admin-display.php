<?php

use bfAdvancedImages\core\BFConstants;
use bfAdvancedImages\core\BFImagesDirectoryOptions;
use bfAdvancedImages\providers\BFAdminOptionsHTMLProvider;
use bfAdvancedImages\providers\BFAdminOptionsProvider;

$bf_image_directory_options     = new BFImagesDirectoryOptions();
$bf_admin_options_html_provider = new BFAdminOptionsHTMLProvider();
$bf_admin_options_provider      = new BFAdminOptionsProvider();
$deleted_images                 = $bf_admin_options_provider->delete_cached_images( $_POST, $bf_image_directory_options );
$removed_image_sizes            = $bf_admin_options_provider->remove_image_sizes( $_POST );
$unset_images                   = ! empty( get_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION ) ) ? json_decode( get_option( BFConstants::BFAI_UNSET_IMAGE_SIZES_OPTION ) ) : array();
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
                   name="bfai_delete_all_cached_images" class="button button-primary button-large">
			<?php if ( ! empty( $deleted_images ) ) { ?>
                <p><?php esc_html_e( 'Images deleted', BFConstants::DOMAIN_NAME_ADMIN ); ?></p>
			<?php } ?>
        </form>
    </div>

    <div>
		<?php
		$default_image_sizes = get_intermediate_image_sizes();

		if ( ! empty( $default_image_sizes ) ) { ?>
            <h2><?php esc_html_e( 'Remove default image sizes', BFConstants::DOMAIN_NAME_ADMIN ); ?></h2>
            <form action="" method="post">
                <input type="checkbox" id="bfai_toggle_all"
                       name="bfai_unset_image_sizes[]" <?php echo in_array( 'bfai_toggle_all', $unset_images ) ? esc_attr( 'checked' ) : ''; ?>
                       value="bfai_toggle_all" onClick="bfaiToggleAll(this)">
                <label for="bfai_toggle_all">Toggle All</label>
				<?php foreach ( $default_image_sizes as $image_size ) { ?>
                    <div>
                        <input type="checkbox" name="bfai_unset_image_sizes[]"
                               id="<?php echo esc_attr( $image_size ); ?>"
                               value="<?php echo esc_attr( $image_size ); ?>" <?php echo in_array( $image_size, $unset_images ) ? esc_attr( 'checked' ) : ''; ?>>
                        <label for="<?php echo esc_attr( $image_size ); ?>">Unset
                            <b><?php echo esc_html( $image_size ); ?></b>
                            size</label>
                    </div>
				<?php } ?>

                <input type="submit" name="bfai_unset_image_sizes_submit" style="margin-top: 20px;"
                       value="<?php esc_html_e( 'Save changes', BFConstants::DOMAIN_NAME_ADMIN ); ?>"
                       class="button button-primary button-large">
            </form>
		<?php } ?>
    </div>
</div> <!-- .wrap -->
