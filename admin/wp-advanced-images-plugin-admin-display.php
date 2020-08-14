<?php

use wpAdvancedImagesPlugin\core\WPAIMP_Constants;
use wpAdvancedImagesPlugin\core\WPAIMP_Directory_Options;

$directory_options = new WPAIMP_Directory_Options();
$nonce             = is_admin() ? wp_create_nonce( 'wpaimp-images' ) : '';
?>
<div class="wrap">

    <h2>Advanced Images</h2>

    <div class="card">
        <h3><?= __( 'Delete Cached Images', 'wpaimp' ); ?></h3>
        <div class="js-wp-advanced-images-plugin"
             data-nonce="<?= $nonce; ?>"
             data-api-url="<?= get_home_url() . '/wp-json/api/v1'; ?>"
             data-url="<?= WPAIMP_Constants::API_DASH_CONTROLLER; ?>">
			<?php get_admin_wpaimp_partial( 'dash-form' ); ?>
        </div>
    </div> <!-- .card -->

</div> <!-- .wrap -->
