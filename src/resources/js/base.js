import * as bootstrap from 'bootstrap';
import {copyToClipboard} from "./utils/copyToClipboard";
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
});
