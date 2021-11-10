function bfaiToggleAll(source) {
    let checkboxes = document.getElementsByName('bfai_unset_image_sizes[]');
    if (checkboxes.length > 0) {
        for (let i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
}