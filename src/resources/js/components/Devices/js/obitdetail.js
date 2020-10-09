export default {
    props:['is_mobile','events','usn'],
    data: function () {
        return {
            obit: null,
            isLoading: true
        };
    },
    mounted: function () {
        this.getObit();
    },
    watch: {

    },
    methods: {
        getObit: function(){
            axios.get('/api/internal/obit/'+this.usn, {}).then((response) => {
                if(response.data.status == 0) {
                    this.isLoading = false;
                    this.obit = response.data.obit;
                    this.obit.metadata = JSON.parse(this.obit.metadata);
                    this.obit.documents = JSON.parse(this.obit.documents);
                    this.obit.structured_data = JSON.parse(this.obit.structured_data);
                }
            }).catch((e) => {
                this.isLoading = false;
                if(e.response.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.data.errorMessage, "error");
                } else {
                    swal("Unable To Get Obit!", "We could not find this obit in the database.", "error");
                }
            });
        },
        getKey: function(data){
            var keys = Object.keys(data);
            if(keys) {
                return keys[0];
            }
            return '';
        },
        getValue: function(data){
            var k = this.getKey(data);
            return data[k];
        },
        syncData: function(){
            if(this.isLoading) return;
            this.isLoading = true;
            axios('/api/internal/obit/sync', {
                method:'post',
                data: {
                    usn: this.obit.usn
                },
                responseType: 'json',
            })
                .then((response) => {
                    this.isLoading = false;
                    swal("Done!", "Obit synched to the blockchain.", "success");
                })
                .catch((e) => {
                    this.isLoading = false;
                    if(e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "We could not synchronize the Obit data", "error");
                    }
                });
        },
        downloadObit: function(){
            this.isLoading = true;
            axios('/api/internal/obit', {
                method:'post',
                data: {
                    obitDID: this.obit.obitDID
                },
                responseType: 'json',
            })
            .then((response) => {
                this.obit = response.data.client_obit;
                this.obit.metadata = JSON.parse(this.obit.metadata);
                this.obit.documents = JSON.parse(this.obit.documents);
                this.obit.structured_data = JSON.parse(this.obit.structured_data);
                swal("Done!", "Obit downloaded form blockchain.", "success");
            })
            .catch((e) => {
                console.log(e);
                this.isLoading = false;
                if(e.response.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.data.errorMessage, "error");
                } else {
                    swal("Error!", "Unable to retrieve obit", "error");
                }
            });
        },
        mapData: function(){
            axios('/api/internal/obit/device', {
                method:'post',
                data: {
                    usn: this.obit.usn
                },
                responseType: 'json',
            })
                .then((response) => {
                    this.isLoading = false;
                    swal("Done!", "Device added to Local Inventory", "success");
                })
                .catch((e) => {
                    console.log(e.response);
                    this.isLoading = false;
                    if(e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "Unable to map Obit to Inventory", "error");
                    }
                });
        },
    }
}
