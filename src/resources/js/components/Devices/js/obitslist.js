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

            this.obitsList = $('#obitsList').DataTable({
                "language": {
                    "emptyTable": "There is no client obit data to show at the moment",
                    search: '',
                    searchPlaceholder: 'Search USN, Serial #, Part #, Manufacturer or Owner',
                    lengthMenu: ''
                },
                pageLength: 250,
                ajax: {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: '/api/data/obits',
                    dataSrc: (data) => {
                        console.log(data);
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

                            var lastFour = full.usn.substr(full.usn.length - 4);
                            var firstFour = full.usn.substr(0,4);
                            return type === 'display'?'<a href="/obits/'+full.usn+'"><b>'+firstFour+'-'+lastFour+'</b></a> &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.usn+'"><i class="fa fa-copy"></i></button>':full.usn;

                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            var lastFour = full.serial_number_hash.substr(full.serial_number_hash.length - 8);
                            return type === 'display'?'...'+lastFour+' &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.serial_number_hash+'"><i class="fa fa-copy"></i></button>':full.serial_number_hash;

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

                            var lastFour = full.root_hash.substr(full.root_hash.length - 8);
                            return type === 'display'?'...'+lastFour+' &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.root_hash+'"><i class="fa fa-copy"></i></button>':full.root_hash;

                        }
                    },
                    {
                        sortable: true,
                        "render": function (data, type, full, meta) {
                            if(full.obada_hash === '') {
                                return '-';
                            }
                            var lastFour = full.obada_hash.substr(full.obada_hash.length - 8);
                            return type === 'display'?'...'+lastFour+' &nbsp; <button class="btn btn-outline-primary btn-fab btn-round btn-sm btn-clipboard" data-value="'+full.obada_hash+'"><i class="fa fa-copy"></i></button>':full.obada_hash;

                        }
                    },
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
