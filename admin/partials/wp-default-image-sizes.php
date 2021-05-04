<?php

use wpAdvancedImagesPlugin\config\WPAIMP_WordPress_Defaults;

$wordpress_default_image_sizes = WPAIMP_WordPress_Defaults::get_wp_default_image_sizes();
$checked_image_sizes           = get_option( 'wpaimp_image_sizes' );

$checked_toggle = ! empty( $checked_image_sizes['on'] ) ? 'checked' : '';
?>

<input type="checkbox" name="unset_image_sizes" <?= $checked_toggle; ?> onClick="toggle(this)">
<label for="toggle_all">Toggle All</label>

<?php
if ( ! empty( $wordpress_default_image_sizes ) ) {
	foreach ( $wordpress_default_image_sizes as $key => $image_size ) {
		$checked = ! empty( $checked_image_sizes[ $image_size ] ) && $checked_image_sizes[ $image_size ] === $image_size ? 'checked' : '';
		?>
        <div>
            <input type="checkbox" name="unset_image_sizes" id="<?= $image_size; ?>" <?= $checked; ?>
                   value="<?= $image_size; ?>">
            <label for="<?= $image_size; ?>">Unset <b><?= $image_size; ?></b> size</label>
        </div>
	<?php }
}
?>

<div>
    <input class="button js-wpaimp-image-sizes-unset-btn" type="submit" name="some_name"
           value="Save">
</div>

<script>
    function toggle(source) {
        let checkboxes = document.getElementsByName('unset_image_sizes');
        if (checkboxes.length > 0) {
            for (let i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    }
</script>
