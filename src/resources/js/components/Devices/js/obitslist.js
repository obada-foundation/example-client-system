export default {
    props:['is_mobile','events'],
    data: function () {
        return {
            obitsList: null,
        };
    },
    mounted: function () {
        $(document).ready(() => {

            $(document).on('click', '.btn-delete', (event)=>{
                var $btn=$(event.currentTarget);
                var sid = $btn.attr('data-id');
                var $tr=$('.dev-'+sid);
                var dataTableRow=this.obitsList.row($tr[0]); // get the DT row so we can use the API on it
                var rowData=dataTableRow.data();
                this.removeDevice(rowData);
            });

            this.deviceList = $('#obitsList').DataTable({
                "language": {
                    "emptyTable": "There is no client obit data to show at the moment"
                },
                ajax: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/api/data/obits',
                    dataSrc: function (data) {
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
                            return '<a href="/obits/'+full.id+'"><b>'+full.usn+'</b></a>';
                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            return full.obit;
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

                        }).catch(() => {
                            swal("Unable To Remove Device!", "We could not remove this device.", "error");
                        });

                    }
                });
        }
    }
}
