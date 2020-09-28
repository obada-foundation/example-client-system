export default {
    props:['is_mobile','events'],
    data: function () {
        return {
            device: null,
            isLoading: true,
            usn_data: null,
            deviceForm: {
                manufacturer: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                serial_number: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                part_number: {
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
        getDevice: function(){
            axios.get('/api/internal/device/'+this.device_id, {}).then((response) => {
                console.log(response);
                if(response.data.status == 0) {
                    this.device = response.data.device;
                    this.parseDevice()
                }
            }).catch(() => {
                swal("Unable To Get Device!", "We could not find this device in the database.", "error");
            });
        },
        parseDevice: function(){
            var keys = Object.keys(this.device);
            keys.forEach((k)=>{
                if(this.deviceForm.hasOwnProperty(k) && typeof this.device[k] !== 'object' &&  typeof this.device[k] !== 'array') {
                    this.deviceForm[k].value = this.device[k];
                }
            });
        },
        clearRequest: function(){
            this.clearForm(this.deviceForm);
            this.usn_data = null;
        },
        submitRequest: function(){
            if(this.is_valid(this.deviceForm)) {

                axios('/api/internal/usn', {
                    method:'post',
                    data: {
                        manufacturer: this.deviceForm.manufacturer.value,
                        part_number: this.deviceForm.part_number.value,
                        serial_number: this.deviceForm.serial_number.value
                    },
                    responseType: 'json',
                })
                .then((response) => {
                    this.usn_data = response.data.usn;
                })
                .catch((e) => {
                    if(e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "Unable to generate USN", "error");
                    }
                });
            }
        },
    }
}
