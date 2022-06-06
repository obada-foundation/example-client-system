<template>
    <form>
        <div class="text-left">
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

            <div class="form-group">
                <label for="">Metadata URI</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           v-bind:class="{'is-normal':deviceForm.metadata_uri.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                           v-model="deviceForm.metadata_uri.value"
                           @focus="handleFocus(deviceForm.metadata_uri)"
                           @blur="handleBlur(deviceForm.metadata_uri)"
                           placeholder="Metadata URI">
                </div>
            </div>

            <div class="form-group">
                <label>Metadata URI Hash</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           v-bind:class="{'is-normal':deviceForm.metadata_uri_hash.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                           v-model="deviceForm.metadata_uri_hash.value"
                           @focus="handleFocus(deviceForm.metadata_uri_hash)"
                           @blur="handleBlur(deviceForm.metadata_uri_hash)"
                           placeholder="Metadata URI Hash">
                </div>
            </div>

            <div class="form-group">
                <label>Physical Asset Owner ID</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           v-bind:class="{'is-normal':deviceForm.trust_anchor_token.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                           v-model="deviceForm.trust_anchor_token.value"
                           @focus="handleFocus(deviceForm.trust_anchor_token)"
                           @blur="handleBlur(deviceForm.trust_anchor_token)"
                           placeholder="Physical Asset Owner ID">
                </div>
            </div>

            <div v-if="checksum_data.checksum.length > 0">
                <p><strong>Checksum:</strong> {{ checksum_data.checksum }}</p>
                <p><strong>Compute Log:</strong> {{ checksum_data.compute_log }}</p>
            </div>

            <div class="text-right">
                <button v-if="checksum_data != null" class="btn btn-outline-primary btn-round" @click="clearRequest">Clear</button>
                <button class="btn btn-primary btn-round" v-on:click="submitRequest">Generate</button>
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
            checksum_data: {
                checksum: "",
                compute_log: ""
            },
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
                metadata_uri: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: []
                },
                metadata_uri_hash: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: []
                },
                trust_anchor_token: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: []
                }
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
        isValid: function(set) {
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
            this.clearForm(this.deviceForm);
            this.checksum_data.checksum = "";
            this.checksum_data.compute_log = "";
        },
        submitRequest: function(e){
            e.preventDefault()

            if(this.isValid(this.deviceForm)) {
                axios(this.submitUrl, {
                    method:'post',
                    data: {
                        manufacturer: this.deviceForm.manufacturer.value,
                        part_number: this.deviceForm.part_number.value,
                        serial_number: this.deviceForm.serial_number.value,
                        metadata_uri: this.deviceForm.metadata_uri.value,
                        metadata_uri_hash: this.deviceForm.metadata_uri_hash.value,
                        trust_anchor_token: this.deviceForm.trust_anchor_token.value
                    },
                    responseType: 'json',
                })
                .then((response) => {
                    this.checksum_data = response.data;
                })
                .catch((e) => {
                    console.log(e.response);
                    if(e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "Unable to generate Checksum", "error");
                    }
                });
            }
        },
    }
}
</script>
