import '../../base';

import $ from 'jquery';

$(document).ready(function() {
    $('input[name="amount"], input[name="recepient_address"]').keyup(function() {
        if (isValidAmount() && isValidAddress()) {
            $('#wallet_send_form button[type="submit"]').attr('disabled', false);
        } else {
            $('#wallet_send_form button[type="submit"]').attr('disabled', true);
        }
    });

    function isValidAddress() {
        const $me = document.querySelector('input[name="recepient_address"]');

        if ($me.value === '') {
            return false;
        }

        return true;
    }

    function isValidAmount() {
        const $me = document.querySelector('input[name="amount"]');
        const amountToSend = parseFloat($me.value);

        if (isNaN(amountToSend) || amountToSend <= 0 || amountToSend === undefined) {
            return false;
        }

        const gasFee = parseFloat($me.getAttribute('data-gas-fee'));
        const total = parseFloat($me.getAttribute('data-total'));

        if (amountToSend + gasFee > total) {
            return false;
        }

        return true;
    }
});
