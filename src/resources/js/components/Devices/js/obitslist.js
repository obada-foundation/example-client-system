export default {
    props:['is_mobile','events'],
    data: function () {
        return {
            isLoading: true,
            obitsList: null,
        };
    },
    mounted: function () {
        $(document).ready(() => {

            $(document).on('click', '.btn-map', (event)=>{
                var $btn=$(event.currentTarget);
                var sid = $btn.attr('data-id');
                var $tr=$('.dev-'+sid);
                var dataTableRow=this.obitsList.row($tr[0]); // get the DT row so we can use the API on it
                var rowData=dataTableRow.data();
                this.mapObit(rowData);
            });


            this.obitsList = $('#obitsList').DataTable({
                "language": {
                    "emptyTable": "There is no client obit data to show at the moment"
                },
                ajax: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/api/data/obits',
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
                            return '<a href="/obits/'+full.usn+'"><b>'+full.usn+'</b></a>';
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
                        className: "dt-center",
                        "render": function (data, type, full, meta) {
                            if(full.is_mapped) {
                                return '<button class="btn btn-fab btn-success btn-round btn-sm text-center m-auto"><i class="fa fa-check"></i></button>'
                            }else {
                                return '<button class="btn btn-warning btn-round btn-sm text-center m-auto btn-map" data-id="'+full.id+'"><i class="fa fa-exclamation-triangle"></i> Click To Map</button>'
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
        mapObit: function(clientObit){
            console.log(clientObit);
            this.isLoading = true;
            axios('/api/internal/obit/device', {
                method:'post',
                data: {
                    usn: clientObit.usn
                },
                responseType: 'json',
            })
            .then((response) => {
                this.isLoading = false;
                this.obitsList.ajax.reload()
                swal("Done!", "Data has been successfully retrieved from Obada", "success");
            })
            .catch((e) => {
                console.log(e);
                this.isLoading = false;
                if(e.response && e.response.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.data.errorMessage, "error");
                } else {
                    swal("Error!", "Unable to map Obit to Inventory", "error");
                }
            });
        }
    }
}
