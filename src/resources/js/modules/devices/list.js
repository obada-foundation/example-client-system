import $ from 'jquery';
import 'datatables.net';
import 'datatables.net-bs5';
import axios from 'axios';
import {copyToClipboard} from "../../utils/copyToClipboard";
import {showAlert} from "../../utils/showAlert";

$(document).ready(() => {

    $(document).on('click', '.btn-delete', (event) => {
        var $btn = $(event.currentTarget);
        var sid = $btn.attr('data-id');
        var $tr = $('.dev-' + sid);
        var dataTableRow = this.deviceList.row($tr[0]); // get the DT row so we can use the API on it
        var rowData = dataTableRow.data();
        removeDevice(rowData);
    });

    $(document).on('click', '.btn-clipboard', (event) => {
        var $btn = $(event.currentTarget);
        var sid = $btn.attr('data-value');
        copyToClipboard(sid);
        showAlert({
            message: 'Copied',
            type: 'success',
            autoclose: true
        });
    });

    $('#deviceList').DataTable({
        "language": {
            emptyTable: "There are no devices to show at the moment",
            search: '',
            searchPlaceholder: 'Search Serial #, Part #, Manufacturer or Owner',
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
        columns: [
            {
                sortable: true,
                "render": function(data, type, full, meta) {
                    return type === 'display'
                        ? '<i class="fas fa-sync text-success" title="Synchronized with blockchain" style="margin-left: -1rem; margin-right: 0.5rem;"></i> <a href="/devices/' + full.usn + '"><strong>' + full.usn + '</strong></a>'
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
                    return full.serial_number;
                    // var lastFour = full.serial_number;
                    // var lastFour = full.serial_number.substr(-4);
                    // lastFour = '...' + lastFour;

                    // return type === 'display' ? '<a href="/devices/' + full.usn + '"><b>' + lastFour + '</b></a> &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="' + full.serial_number + '"><i class="fa fa-copy"></i></button>' : full.serial_number;
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
                "render": function (data, type, full, meta) {
                    if (full.obit_checksum === '' || full.obit_checksum === null) {
                        return '-';
                    }

                    const displayString = full.obit_checksum.substr(0, 4) + '...' + full.obit_checksum.substr(-4);

                    return type === 'display' ? displayString + ' &nbsp; <button class="btn btn-outline-primary btn-sm btn-clipboard" data-value="' + full.obit_checksum + '"><i class="fa fa-copy"></i></button>' : displayString;

                }
            },
        ]
    });

    function removeDevice(device) {
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
    }
});
