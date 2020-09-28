export default {
    props:['is_mobile','events'],
    data: function () {
        return {
            obitsList: null,
        };
    },
    mounted: function () {
        $(document).ready(() => {
            this.obitsList = $('#obitsList').DataTable({
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
                    }
                ]
            });
        })
    },
    watch: {

    },
    methods: {

    }
}
