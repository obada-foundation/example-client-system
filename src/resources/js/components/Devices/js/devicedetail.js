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
                console.log(response);
                if(response.data.status == 0) {
                    this.device = response.data.device;
                }
            }).catch(() => {
                swal("Unable To Get Device!", "We could not find this device in the database.", "error");
            });
        },
        getMetadataValue(metadata) {
            if(metadata.data_txt !== null && metadata.data_txt !== '') {
                return metadata.data_txt;
            }
        },
        getStructuredData(data) {
            if(typeof data === 'string') {
                return JSON.parse(data);
            }
            return data;
        }
    }
}
