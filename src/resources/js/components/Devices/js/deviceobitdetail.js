export default {
    props:['is_mobile','events','usn'],
    data: function () {
        return {
            device: null,
            obit: null,
            blockChainObit: null,
            currentView: 'device_view',
            isLoading: true
        };
    },
    mounted: function () {
        this.getDevice();
        this.getObit();
    },
    computed:{
        hasObitHash: function(){
            return !(this.obit === null || !this.obit.hasOwnProperty('root_hash'));
        },
        hasBlockchainHash: function(){
            return !(this.blockChainObit === null || !this.blockChainObit.hasOwnProperty('root_hash'));
        },
        obitHash: function(){
            if(this.obit === null || !this.obit.hasOwnProperty('root_hash')) {
                return 'Obit Does Not Exist';
            } else {
                return this.obit.root_hash;
            }
        },
        inventoryHash: function(){
            if(this.device === null || !this.device.hasOwnProperty('root_hash')) {
                return 'Device Does Not Exist';
            } else {
                return this.device.root_hash;
            }
        },
        blockchainHash: function(){
            if(this.blockChainObit === null || !this.blockChainObit.hasOwnProperty('root_hash')) {
                return 'Obit Does Not Exist In BlockChain';
            } else {
                return this.blockChainObit.root_hash;
            }
        },
        localHashMatch: function(){
            if(this.device === null || !this.device.hasOwnProperty('root_hash')) {
                return false;
            } else if(this.obit === null) {
                return false;
            } else {
                return this.obit.root_hash === this.device.root_hash;
            }
        },
        blockchainHashMatch() {
            if(this.obit === null) {
                return false;
            } else if(this.blockChainObit === null) {
                return false;
            } else {
                return this.obit.root_hash === this.blockChainObit.root_hash;
            }
        }
    },
    watch: {

    },
    methods: {
        getDevice: function(){
            axios.get('/api/internal/device/usn/'+this.usn, {}).then((response) => {
                this.isLoading = false;
                console.log(response);
                if(response.data.status == 0) {
                    this.device = response.data.device;
                    this.device.root_hash = response.data.root_hash;
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
        getObit: function(){
            axios.get('/api/internal/obit/'+this.usn, {}).then((response) => {
                console.log(response);
                if(response.data.status == 0) {
                    this.isLoading = false;
                    this.obit = response.data.obit;
                    this.obit.metadata = JSON.parse(this.obit.metadata);
                    this.obit.documents = JSON.parse(this.obit.documents);
                    this.obit.structured_data = JSON.parse(this.obit.structured_data);

                    this.blockChainObit = response.data.blockchain_obit;
                }
            }).catch((e) => {
                this.isLoading = false;
                this.obit = null;
                this.blockChainObit = null;
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
                    device_id: parseInt(this.device.id)
                },
                responseType: 'json',
            })
            .then((response) => {
                this.isLoading = false;
                this.getDevice();
                this.getObit();
                swal("Done!", "Local Obit saved.", "success");
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
            axios('/api/internal/obit/sync', {
                method:'post',
                data: {
                    usn: this.obit.usn
                },
                responseType: 'json',
            })
                .then((response) => {
                    this.isLoading = false;
                    this.getDevice();
                    this.getObit();
                    swal("Done!", "Obit synched to the blockchain.", "success");
                })
                .catch((e) => {
                    console.log(e.response);
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
                    this.isLoading = false;
                    this.getDevice();
                    this.getObit();
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
                    this.getDevice();
                    this.getObit();
                    swal("Done!", "Obit data added to Local Inventory", "success");

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
        }
    }
}
