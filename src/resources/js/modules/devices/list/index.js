import '../../../base';

import $ from 'jquery';
import "@popperjs/core";
import 'datatables.net';
import 'datatables.net-bs5';
import * as bootstrap from "bootstrap";
import moment from 'moment';
import {formatUSN} from "../../../utils/formatUSN";

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
        },
        columns: [
            {
                sortable: false,
                render: function(data, type, full, meta) {
                    // todo: check if blockchain is newer or local is newer or equal
                    if (full.obit_checksum === full.blockchain_checksum) {
                        return '<i class="fas fa-check text-success" data-bs-toggle="tooltip" title="Synchronized with blockchain"></i>';
                    } else {
                        return '<i class="fas fa-sync text-warning" data-bs-toggle="tooltip" title="Local newer"></i>';
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
