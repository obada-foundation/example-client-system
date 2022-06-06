<template>
    <form action="" onsubmit="return false;">
        <div class="text-left">
            <div class="form-group">
                <label for="">Manufacturer</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           v-bind:class="{'is-normal':deviceForm.manufacturer.isClean,'is-invalid':!deviceForm.manufacturer.isClean && !deviceForm.manufacturer.isValid,'is-valid':!deviceForm.manufacturer.isClean && deviceForm.manufacturer.isValid}"
                           v-model="deviceForm.manufacturer.value"
                           @focus="handleFocus(deviceForm.manufacturer)"
                           @blur="handleBlur(deviceForm.manufacturer)"
                           placeholder="Manufacturer">
                </div>
            </div>
            <div class="form-group">
                <label for="">Serial Number</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           v-bind:class="{'is-normal':deviceForm.serial_number.isClean,'is-invalid':!deviceForm.serial_number.isClean && !deviceForm.serial_number.isValid,'is-valid':!deviceForm.serial_number.isClean && deviceForm.serial_number.isValid}"
                           v-model="deviceForm.serial_number.value"
                           @focus="handleFocus(deviceForm.serial_number)"
                           @blur="handleBlur(deviceForm.serial_number)"
                           placeholder="Serial Number">
                </div>
            </div>
            <div class="form-group">
                <label for="">Part Number</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                           v-model="deviceForm.part_number.value"
                           @focus="handleFocus(deviceForm.part_number)"
                           @blur="handleBlur(deviceForm.part_number)"
                           placeholder="Part Number">
                </div>
            </div>

            <div v-if="usn_data != null" class="form-group">
                <label for="">Obit</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           disabled
                           v-model="usn_data.did"
                           placeholder="Obit DID">
                </div>
            </div>
            <div v-if="usn_data != null" class="form-group">
                <label for="">Universal Serial Number</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           disabled
                           v-model="usn_data.usn"
                           placeholder="Universal Serial Number">
                </div>
            </div>

            <h4 v-if="usn_data != null">HOW IS USN CALCULATED?</h4>

            <table v-if="usn_data != null" class="table">
                <tbody>
                <tr>
                    <td><h3>1</h3></td>
                    <td>serial_number_hash = sha256(serial_number)</td>
                    <td>{{usn_data.serial_number_hash}}</td>
                </tr>
                <tr>
                    <td><h3>2</h3></td>
                    <td>obit = sha256(manufacturer + part_number + serial_hash)</td>
                    <td>{{usn_data.did}}</td>
                </tr>
                <tr>
                    <td><h3>3</h3></td>
                    <td>usn_base58 = base58(obit)</td>
                    <td>{{usn_data.usn_base58}}</td>
                </tr>
                <tr>
                    <td><h3>4</h3></td>
                    <td>usn = first_eight(usn_base58)</td>
                    <td>{{usn_data.usn}}</td>
                </tr>
                </tbody>
            </table>


            <div class="text-right">
                <button v-if="usn_data != null" class="btn btn-outline-primary btn-round" @click="clearRequest">Clear</button>
                <button class="btn btn-primary btn-round" @click="submitRequest">Generate</button>
            </div>

        </div>
    </form>

</template>
<script>
export default {
    props:['is_mobile', 'events', 'submitUrl'],
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

                axios(this.submitUrl, {
                    method:'post',
                    data: {
                        manufacturer: this.deviceForm.manufacturer.value,
                        part_number: this.deviceForm.part_number.value,
                        serial_number: this.deviceForm.serial_number.value
                    },
                    responseType: 'json',
                })
                .then((response) => {
                    console.log(response);
                    this.usn_data = response.data;
                })
                .catch((e) => {
                    console.log(e.response);
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
</script>
