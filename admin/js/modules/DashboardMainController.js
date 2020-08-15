import axios from "../../../node_modules/axios";

export default class DashboardMainController {
    init() {
        this.mainPluginDiv = document.querySelector('.js-wp-advanced-images-plugin');
        this.deleteAllCachedImagesButton = document.querySelector('.js-wpaimp-delete-all-images-btn');
        this.unsetDefaultImagesButton = document.querySelector('.js-wpaimp-image-sizes-unset-btn');

        this.deleteAllCachedImages();
        this.unsetDefaultImages();
    }

    deleteAllCachedImages() {
        if (this.deleteAllCachedImagesButton) {
            this.deleteAllCachedImagesButton.addEventListener('click', (event) => {
                event.preventDefault();

                let data = {
                    action: 'delete_all_cached_images'
                }

                this.ajaxUpdate(data);
            });
        }
    }

    unsetDefaultImages() {
        if (this.unsetDefaultImagesButton) {
            this.unsetDefaultImagesButton.addEventListener('click', (event) => {
                event.preventDefault();

                // let formData = new FormData(this.wpDefaultImageSizesForm);
                // console.log(formData);

                let formValues = [];
                let formData = document.querySelectorAll('input[type=checkbox][name=unset_image_sizes]:checked')

                if (formData.length > 0) {
                    for (let i = 0; i < formData.length; i++) {
                        formValues.push(formData[i].value);
                    }
                }

                let data = {
                    action: 'unset_default_images',
                    data: formValues
                }

                this.ajaxUpdate(data);
            });
        }
    }

    ajaxUpdate(data = {}) {
        let nonce = '';
        let apiUrl = '';
        let url = '';


        if (this.mainPluginDiv) {
            apiUrl = this.mainPluginDiv.getAttribute('data-api-url');
            nonce = this.mainPluginDiv.getAttribute('data-nonce');
            url = this.mainPluginDiv.getAttribute('data-url');
        }

        let headers = {
            'content-type': 'application/json',
            'X-WP-Nonce': nonce
        }

        axios({
            method: 'post',
            url: apiUrl + '/' + url,
            data: data,
        });
    }
}
