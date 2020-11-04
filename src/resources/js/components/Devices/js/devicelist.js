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

            $(document).on('click', '.btn-clipboard', (event)=>{
                var $btn=$(event.currentTarget);
                var sid = $btn.attr('data-value');
                _app.copyToClipboard(sid);
                _app.notify({
                    message: 'Copied',
                    type: 'message',
                    autoclose: true
                })
            });

            this.deviceList = $('#deviceList').DataTable({
                "language": {
                    "emptyTable": "There are no devices to show at the moment",
                    search: '',
                    searchPlaceholder: 'Search Serial #, Part #, Manufacturer or Owner',
                    lengthMenu: ''
                },
                pageLength: 250,
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

                            var lastFour = full.serial_number.substr(full.serial_number.length - 8);
                            lastFour = '...'+lastFour;

                            return type === 'display'?'<a href="/devices/usn/'+full.usn+'"><b>'+lastFour+'</b></a> &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.serial_number+'"><i class="fa fa-copy"></i></button>':full.serial_number;
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
                            return full.manufacturer;
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
                        "render": function (data, type, full, meta) {

                            var displayString = full.local_hash.substr(full.local_hash.length - 8);

                            var displayString = '<span class="'+(full.local_hash != full.root_hash?'text-danger':'')+'">...'+displayString+'</span>'


                            return type === 'display'?displayString+' &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.local_hash+'"><i class="fa fa-copy"></i></button>':full.local_hash;

                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {

                            var displayString = full.root_hash.substr(full.root_hash.length - 8);

                            var displayString = '<span class="'+(full.root_hash != full.obada_hash?'text-danger':'')+'">...'+displayString+'</span>'


                            return type === 'display'?displayString+' &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.root_hash+'"><i class="fa fa-copy"></i></button>':full.root_hash;

                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            if(full.obada_hash === '') {
                                return '-';
                            }
                            var displayString = full.obada_hash.substr(full.obada_hash.length - 8);
                            var displayString = '<span class="'+(full.root_hash != full.obada_hash?'text-danger':'')+'">...'+displayString+'</span>'

                            return type === 'display'?displayString+' &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.obada_hash+'"><i class="fa fa-copy"></i></button>':full.obada_hash;

                        }
                    },
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
