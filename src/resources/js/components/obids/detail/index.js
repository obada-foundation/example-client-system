import axios from 'axios';

export default {
    props:['is_mobile', 'events', 'usn','loadObitUrl', 'toChainObitUrl'],
    data: function () {
        return {
            localObit: null,
            blockchainObit: {},
            isLoading: true
        };
    },
    mounted: function () {
        this.getObit();
        this.getBlockchainNFT();
    },
    watch: {

    },
    methods: {
        getBlockchainNFT: function() {
            axios.get(this.loadObitUrl, {}).then((response) => {
                if(response.data.status == 0) {
                    this.isLoading = false;
                    this.blockchainObit = response.data.obit;
                    this.blockchainObit.documents = [];//JSON.parse(this.obit.documents);
                }
            }).catch((e) => {
                this.isLoading = false;
                if(e.response.data.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.response.data.errorMessage, "error");
                } else {
                    swal("Unable To Get Blockchain NFT!", "We could not find this obit in the database.", "error");
                }
            });
        },
        getObit: function(){
            axios.get(this.loadObitUrl, {}).then((response) => {
                if(response.data.status == 0) {
                    this.isLoading = false;
                    this.localObit = response.data.obit;
                    this.localObit.documents = [];//JSON.parse(this.obit.documents);
                }
            }).catch((e) => {
                this.isLoading = false;
                if(e.response.data.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.response.data.errorMessage, "error");
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
            axios.get(this.toChainObitUrl, {}).then((response) => {
                    this.isLoading = false;
                    swal("Done!", "Obit synched to the blockchain.", "success");
                })
                .catch((e) => {
                    console.log(e.response);
                    this.isLoading = false;
                    if(e.response.data.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.response.data.errorMessage, "error");
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
                    obitDID: this.localObit.obitDID
                },
                responseType: 'json',
            })
            .then((response) => {
                this.localObit = response.data.client_obit;
                this.localObit.metadata = {}; //JSON.parse(this.obit.metadata);
                this.localObit.documents = {}; //JSON.parse(this.obit.documents);
                this.localObit.structured_data = {}; //JSON.parse(this.obit.structured_data);
                swal("Done!", "Obit downloaded form blockchain.", "success");
            })
            .catch((e) => {
                console.log(e);
                this.isLoading = false;
                if(e.response.data.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.response.data.errorMessage, "error");
                } else {
                    swal("Error!", "Unable to retrieve obit", "error");
                }
            });
        },
        mapData: function(){
            axios('/api/internal/obit/device', {
                method:'post',
                data: {
                    usn: this.localObit.usn
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
                    if(e.response.data.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.response.data.errorMessage, "error");
                    } else {
                        swal("Error!", "Unable to map Obit to Inventory", "error");
                    }
                });
        },
    }
}
