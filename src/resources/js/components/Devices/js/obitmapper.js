export default {
    props:['is_mobile','events'],
    data: function () {
        return {
            isLoading: false,
            client_obit: null,
            deviceStatus: {
                inventory: 0,
                obit: 0,
                obada: 0
            },
            obitForm: {
                obit_did: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
            },
        };
    },
    mounted: function () {

    },
    watch: {

    },
    methods: {
        handleFocus: function(v){
            v.isClean = false;
        },
        handleBlur: function(v) {
            console.log("Blur")
            this.validate(v)
        },
        is_valid: function(set) {
            var keys = Object.keys(set);
            var isValid = true;
            keys.forEach((k)=>{
                if(typeof(set[k]) === 'object') {
                    set[k].isClean = false;
                    this.validate(set[k]);
                    if(!set[k].isValid) {
                        isValid = false;
                    }
                }

            });
            return isValid;
        },
        validate: function(f){

            if(!f.validations) {
                return true;
            }

            if(f.validations.includes('required')) {
                if(f.value === '') {
                    f.isValid = false;
                    return false;
                }
            }
            if(f.validations.includes('email')) {
                if(f.value.trim().match(/^[a-zA-Z0-9+._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/) === null) {
                    f.isValid = false;
                    return false;
                }
            }
            if(f.validations.includes('numeric')) {
                if(isNaN(f.value)) {
                    f.isValid = false;
                    return false;
                }
            }
            f.isValid = true;
        },
        clearForm: function(set) {
            var keys = Object.keys(set);
            var isValid = true;
            keys.forEach((k)=>{
                if(typeof(set[k]) === 'object') {
                    set[k].isClean = true;
                    set[k].value = '';
                }

            });
        },
        clearRequest: function(){
            this.clearForm(this.obitForm);
        },
        submitRequest: function(){
            if(this.is_valid(this.obitForm)) {
                this.isLoading = true;
                axios('/api/internal/obit', {
                    method:'post',
                    data: {
                        obit_did: this.obitForm.obit_did.value
                    },
                    responseType: 'json',
                })
                .then((response) => {
                    this.client_obit = response.data.client_obit;
                    this.deviceStatus.obada = 1;
                    this.deviceStatus.obit = 1;
                    this.mapToDevice();
                })
                .catch((e) => {
                    console.log(e);
                    this.isLoading = false;
                    this.deviceStatus.obit = 2;
                    this.deviceStatus.obada = 2;
                    this.deviceStatus.inventory = 0;
                    if(e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "Unable to retrieve obit", "error");
                    }
                });
            }
        },
        mapToDevice: function(){
            axios('/api/internal/obit/device', {
                method:'post',
                data: {
                    usn: this.client_obit.usn
                },
                responseType: 'json',
            })
            .then((response) => {
                this.isLoading = false;
                this.deviceStatus.inventory = 1;
                swal("Done!", "Data has been successfully retrieved from Obada", "success");
            })
            .catch((e) => {
                console.log(e);
                this.deviceStatus.inventory = 2;
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
