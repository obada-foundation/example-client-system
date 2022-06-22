import bootstrap from 'bootstrap';
import {copyToClipboard} from "./utils/copyToClipboard";
import {showAlert} from "./utils/showAlert";
require('bootstrap-sweetalert/dist/sweetalert');

const token = document.head.querySelector('meta[name="csrf-token"]');

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-copy-text]').forEach(button => {
        button.addEventListener('click', () => {
            copyToClipboard(button.getAttribute('data-copy-text'));
            showAlert({
                message: 'Copied',
                type: 'success',
                autoclose: true
            });
        });
    })

});
