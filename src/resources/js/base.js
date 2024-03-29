import * as bootstrap from 'bootstrap';
import {copyToClipboard} from "./utils/copyToClipboard";
import * as Sentry from "@sentry/browser";
import { BrowserTracing } from "@sentry/tracing";

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
                    title: '',
                    text: 'Deleting an account only removes it from the local system. It is not possible to delete an account from the blockchain.<br><strong class="fw-bold">WARNING:</strong> Did you save the private key? If you lose the seed phrase or private key you will lose the account. No recovery is possible.<br><br>Are you sure you want to delete this account?<br><strong class="fw-bold">' + shortAddress + '</strong>',
                    html: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                },
                function() {
                    window.location.href = url
                });
        })
    })
});

Sentry.init({
    dsn: "https://9d59d70efe9949b4812956393002c504@sentry.tradeloopproto.com/4",

    // Alternatively, use `process.env.npm_package_version` for a dynamic release version
    // if your build tool supports it.
    release: "develop",
    integrations: [new BrowserTracing()],

    // Set tracesSampleRate to 1.0 to capture 100%
    // of transactions for performance monitoring.
    // We recommend adjusting this value in production
    tracesSampleRate: 1.0,
});


