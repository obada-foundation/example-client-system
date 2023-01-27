import '../../../base';

import $ from 'jquery';
import "@popperjs/core";
import 'datatables.net';
import 'datatables.net-bs5';
import * as bootstrap from "bootstrap";
import moment from 'moment';
import {formatUSN} from "../../../utils/formatUSN";
import axios from "axios";
import Vue from 'vue';


Vue.component('rename-account', require('../../../components/devices/list/rename.vue').default);
window.Events = new Vue({});
window._app = new Vue({
    el: '#app'
});

$(document).ready(() => {
    document.getElementById('currentTime').innerText = moment(new Date()).format('YYYY-MM-DD, LT');

    $('#deviceList').DataTable({
        order: [[6, 'desc']],
        "language": {
            emptyTable: "There are no devices to show at the moment",
            search: '',
            searchPlaceholder: 'Search Manufacturer, Part # or Serial #',
            lengthMenu: ''
        },
        pageLength: 250,
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: window.devicesLoadUrl,
            dataSrc: (data) => {
                if (data.status === 1) {
                    return [];
                } else {
                    return data.data;
                }
            },
            dataType: 'json'
        },
        rowCallback: function(row, data) {
            $(row).addClass('dev-' + data.id);
        },
        drawCallback: function(settings) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('#deviceList [data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            $('[data-action=mint]').click(function() {
                const me = this;
                const usn = me.getAttribute('data-id');
                const mintNftUrl = window.mintNftUrl.replace('@usn', usn);

                me.setAttribute('disabled', 'disabled');
                $(me).find('.inner-text').addClass('d-none');
                $(me).find('.spinner-border').removeClass('d-none');

                axios(mintNftUrl, {
                    method: 'post',
                    responseType: 'json',
                })
                .then((response) => {
                    swal({
                        title:  "Success!",
                        text:   "NFT was minted",
                        type:   "success"
                    }, function() {
                        setTimeout(function() {
                            window.location.href = window.pageUrl + '?message=success';
                        }, 500);
                    });
                })
                .catch((e) => {
                    swal({
                        title:  "Unable to mint pNFT",
                        text:   e.response.data.hasOwnProperty('errorMessage') ? e.response.data.errorMessage : '',
                        type:   "error"
                    }, function() {
                        me.removeAttribute('disabled');
                        $(me).find('.inner-text').removeClass('d-none');
                        $(me).find('.spinner-border').addClass('d-none');
                    });
                });
            });
        },
        columns: [
            {
                className: 'text-nowrap',
                sortable: false,
                render: function(data, type, full, meta) {
                    // todo: check if blockchain is newer or local is newer or equal
                    if (full.obit_checksum === full.blockchain_checksum) {
                        return '<i class="fas fa-check text-success" data-bs-toggle="tooltip" title="Synchronized with blockchain"></i>';
                    } else {
                        return '<i class="fas fa-sync text-warning align-middle" data-bs-toggle="tooltip" title="Local newer"></i>' +
                            '<button class="btn btn-link p-0 text-decoration-none ms-2 align-middle" data-id="' + full.usn + '" data-action="mint" style="width: 32px;">' +
                            '   <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>' +
                            '   <span class="inner-text">mint</span>' +
                            '</button>';
                    }
                    return '<i class="fas fa-sync text-danger" data-bs-toggle="tooltip" title="Blockchain newer"></i>';
                }
            },
            {
                sortable: true,
                "render": function(data, type, full, meta) {
                    return type === 'display'
                        ? '<a href="/devices/' + full.usn + '/show"><strong>' + formatUSN(full.usn) + '</strong></a>'
                        : full.usn;
                }
            },
            {
                sortable: true,
                "render": function(data, type, full, meta) {
                    return full.manufacturer;
                }
            },
            {
                sortable: true,
                "render": function(data, type, full, meta) {
                    return full.part_number;
                }
            },
            {
                sortable: true,
                "render": function(data, type, full, meta) {
                    return '<span style="white-space: nowrap">' + full.serial_number + '</span>';
                }
            },
            {
                sortable: true,
                "render": function (data, type, full, meta) {
                    return full.documents_count === 0 ? '-' : full.documents_count;
                }
            },
            {
                sortable: true,
                "render": {
                    _: function (data, type, full, meta) {
                        return '<span style="white-space: nowrap">' + moment(full.created_at).format('YYYY-MM-DD, LT') + '</span>';
                    },
                    sort: function(data, type, full, meta) {
                        return full.created_at
                    },
                }
            },
        ]
    });
});
