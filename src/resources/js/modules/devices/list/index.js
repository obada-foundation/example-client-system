import '../../../base';

import $ from 'jquery';
import "@popperjs/core";
import 'datatables.net';
import 'datatables.net-bs5';
// import axios from 'axios';
import * as bootstrap from "bootstrap";

$(document).ready(() => {

    $('#deviceList').DataTable({
        order: [[1, 'asc']],
        "language": {
            emptyTable: "There are no devices to show at the moment",
            search: '',
            searchPlaceholder: 'Search Manufacturer, Part # or Serial #',
            lengthMenu: ''
        },
        pageLength: 250,
        ajax: {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
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
            })
        },
        columns: [
            {
                sortable: false,
                render: function(data, type, full, meta) {
                    // todo: check if blockchain is newer or local is newer or equal
                    if (full.obit_checksum) {
                        return '<span class="bt btn-sm btn-icon"><i class="fas fa-check text-success" data-bs-toggle="tooltip" title="Synchronized with blockchain"></i></span>';
                    } else {
                        return '<button class="btn btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#networkFeesModal"><i class="fas fa-sync text-warning" data-bs-toggle="tooltip" title="Local version is newer. Click to synchronize."></i></button>';
                    }
                    return '<button class="btn btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#networkFeesModal"><i class="fas fa-sync text-danger" data-bs-toggle="tooltip" title="Blockchain version is newer. Click to synchronize."></i></button>';
                }
            },
            {
                sortable: true,
                "render": function(data, type, full, meta) {
                    return type === 'display'
                        ? '<a href="/devices/' + full.usn + '"><strong>' + full.usn + '</strong></a>'
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
                    return full.serial_number;
                }
            },
            {
                sortable: true,
                "render": function (data, type, full, meta) {
                    return full.documents_count === 0 ? '-' : full.documents_count;
                }
            },
        ]
    });

    /*$(document).on('click', '.btn-delete', (event) => {
        var $btn = $(event.currentTarget);
        var sid = $btn.attr('data-id');
        var $tr = $('.dev-' + sid);
        var dataTableRow = this.deviceList.row($tr[0]); // get the DT row so we can use the API on it
        var rowData = dataTableRow.data();
        removeDevice(rowData);
    });*/

    /*function removeDevice(device) {
        swal({
                title: "Are you sure?",
                text: "This device will be removed completely.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove it!",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            },
            (isConfirm) => {
                if (isConfirm) {

                    axios.delete('/api/internal/device/' + device.id, {}).then((response) => {
                        if (response.data.status === 0) {
                            swal("Deleted!", "The Device has been removed", "success");
                            this.userList.ajax.reload()
                        } else {
                            swal("Unable To Remove Device!", response.data.errorMessage, "error");
                        }

                    }).catch((e) => {
                        if (e.response.data.hasOwnProperty('errorMessage')) {
                            swal("Error!", e.response.data.errorMessage, "error");
                        } else {
                            swal("Error!", "We could not delete the device", "error");
                        }
                    });

                }
            });
    }*/
});