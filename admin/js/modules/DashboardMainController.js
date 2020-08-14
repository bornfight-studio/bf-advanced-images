import axios from "../../../node_modules/axios";

export default class DashboardMainController {
    init() {
        this.mainPluginDiv = document.querySelector('.js-wp-advanced-images-plugin');
        this.deleteAllCachedImagesButton = document.querySelector('.js-wpaimp-delete-all-images-btn');

        this.deleteAllCachedImages();
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
        }).then(response => {
            console.log(response);
        });
    }
}
