export default {
    props:['is_mobile','events','device_id'],
    data: function () {
        return {
            device: null,
            isLoading: true
        };
    },
    mounted: function () {
        this.getDevice();
    },
    watch: {

    },
    methods: {
        getDevice: function(){
            axios.get('/api/internal/device/'+this.device_id, {}).then((response) => {
                this.isLoading = false;
                console.log(response);
                if(response.data.status == 0) {
                    this.device = response.data.device;
                }
            }).catch((e) => {
                this.isLoading = false;
                if(e.response.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.data.errorMessage, "error");
                } else {
                    swal("Unable To Get Device!", "We could not find this device in the database.", "error");
                }

            });
        },
        getMetadataValue(metadata) {
            if(metadata.data_txt !== null && metadata.data_txt !== '') {
                return metadata.data_txt;
            } else if (metadata.data_fp !== null) {
                return parseFloat(metadata.data_fp);
            } else if (metadata.data_int != null) {
                return parseInt(metadata.data_int);
            }
        },
        getStructuredData(data) {
            if(data.data_array != null) {
                data.data_array = beautifyJS(data.data_array,{indent_size: 2});
                return data;
            }
        },
        createObit: function(){
            if(this.isLoading) return;
            this.isLoading = true;
            axios('/api/internal/device/obit', {
                method:'post',
                data: {
                    device_id: parseInt(this.device_id)
                },
                responseType: 'json',
            })
            .then((response) => {
                this.isLoading = false;
                this.device.synced_with_client_obits = 1;
                swal("Done!", "Obit has been successfully created.", "success");
            })
            .catch((e) => {
                this.isLoading = false;
                if(e.response.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.data.errorMessage, "error");
                } else {
                    swal("Error!", "We could not create the obit.", "error");
                }
            });
        },
        syncData: function(){
            if(this.isLoading) return;
            this.isLoading = true;
            axios('/api/internal/device/sync', {
                method:'post',
                data: {
                    device_id: parseInt(this.device_id)
                },
                responseType: 'json',
            })
                .then((response) => {
                    this.isLoading = false;
                    this.device.synced_with_obada = 1;
                    swal("Done!", "Obit has been successfully synchronized.", "success");
                })
                .catch((e) => {
                    this.isLoading = false;
                    if(e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "We could not synchronize the Obit data", "error");
                    }
                });
        }
    }
}
