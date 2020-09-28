export default {
    props:['is_mobile','events'],
    data: function () {
        return {
            deviceList: null,
            isLoading: true
        };
    },
    mounted: function () {
        $(document).ready(() => {

            $(document).on('click', '.btn-delete', (event)=>{
                var $btn=$(event.currentTarget);
                var sid = $btn.attr('data-id');
                var $tr=$('.dev-'+sid);
                var dataTableRow=this.deviceList.row($tr[0]); // get the DT row so we can use the API on it
                var rowData=dataTableRow.data();
                this.removeDevice(rowData);
            });

            this.deviceList = $('#deviceList').DataTable({
                "language": {
                    "emptyTable": "There are no devices to show at the moment"
                },
                ajax: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/api/data/devices',
                    dataSrc: (data) => {
                        this.isLoading = false;
                        if (data.status === 1) {
                            return [];
                        } else {
                            return data.data;
                        }
                    },
                    dataType: 'json'
                },
                rowCallback: function(row, data){
                    $(row).addClass('dev-'+data.id);
                },
                columns: [
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            return '<a href="/devices/'+full.id+'"><b>'+full.serial_number+'</b></a>';
                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            return full.manufacturer;
                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            return full.part_number
                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            return full.owner
                        }
                    },
                    {
                        sortable: true,
                        className: "dt-center",
                        "render": function (data, type, full, meta) {
                            if(full.synced_with_client_obits == 1) {
                                return '<button class="btn btn-fab btn-success btn-round btn-sm text-center m-auto"><i class="fa fa-check"></i></button>'
                            } else {
                                return '<button class="btn btn-fab btn-warning btn-round btn-sm text-center m-auto"><i class="fa fa-exclamation-triangle"></i></button>'
                            }
                        }
                    },
                    {
                        sortable: true,
                        className: "dt-center",
                        "render": function (data, type, full, meta) {
                            if(full.synced_with_obada == 1) {
                                return '<button class="btn btn-fab btn-success btn-round btn-sm text-center m-auto"><i class="fa fa-check"></i></button>'
                            }else {
                                return '<button class="btn btn-fab btn-warning btn-round btn-sm text-center m-auto"><i class="fa fa-exclamation-triangle"></i></button>'
                            }
                        }
                    }
                ]
            });
        })
    },
    watch: {

    },
    methods: {
        removeDevice: function(device) {
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

                        axios.delete('/api/internal/device/'+device.id, {}).then((response) => {
                            if(response.data.status === 0) {
                                swal("Deleted!", "The Device has been removed", "success");
                                this.userList.ajax.reload()
                            } else  {
                                swal("Unable To Remove Device!", response.data.errorMessage, "error");
                            }

                        }).catch((e) => {
                            if(e.response.hasOwnProperty('errorMessage')) {
                                swal("Error!", e.data.errorMessage, "error");
                            } else {
                                swal("Error!", "We could not delete the device", "error");
                            }
                        });

                    }
                });
        }
    }
}