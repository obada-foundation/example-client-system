import * as bootstrap from 'bootstrap';
import {copyToClipboard} from "./utils/copyToClipboard";
import {showAlert} from "./utils/showAlert";
import axios from "axios";
require('bootstrap-sweetalert/dist/sweetalert');

const token = document.head.querySelector('meta[name="csrf-token"]');

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-copy-text]').forEach(button => {
        button.addEventListener('click', (event) => {
            copyToClipboard(button.getAttribute('data-copy-text'));
            const tooltip = bootstrap.Tooltip.getOrCreateInstance(event.target, {
                title: 'Copied!',
                trigger: 'manual'
            });
            tooltip.show();
            setTimeout(() => {
                tooltip.dispose();
            }, 3000);
        });
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    document.querySelectorAll('[data-action="delete-account"]').forEach(button => {
        button.addEventListener('click', event => {
            const address = button.getAttribute('data-id');
            const shortAddress = button.getAttribute('data-short-id');
            const url = button.getAttribute('data-delete-url');
            window.swal({
                    title: 'Are you sure you want to delete this account?',
                    text: shortAddress,
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                },
                function() {
                    axios(url, {
                        method: 'post',
                        responseType: 'json'
                    })
                        .then((response) => {
                            document.querySelector('tr[data-id="' + address + '"]').style.display = 'none';
                            bootstrap.Tooltip.getOrCreateInstance('tr[data-id="' + address + '"] [data-bs-toggle="tooltip"  ]').hide();
                            showAlert({
                                message: 'Account <strong>' + shortAddress + '</strong> successfully deleted.',
                                type: 'success'
                            });
                        })
                        .catch((e) => {
                            showAlert({
                                message: 'Could not delete account <strong>' + shortAddress + '</strong>.',
                                type: 'danger'
                            });
                        });
                });
        })
    })
});


