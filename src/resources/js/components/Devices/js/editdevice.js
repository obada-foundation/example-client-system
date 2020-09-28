export default {
    props:['is_mobile','events','device_id'],
    data: function () {
        return {
            device: null,
            isLoading: true,
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
                owner: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                }
            },
            metadata: [],
            documents: [],
            structured_data: [],
            metadata_to_remove: [],
            structured_data_to_remove: []
        };
    },
    mounted: function () {
        if(this.device_id != 0) {
            this.getDevice();
        } else {
            this.isLoading = false;
        }

    },
    watch: {

    },
    methods: {
        addMetadataRow: function() {
            this.metadata.push({
                type: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                type_id: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                data_type: 'text',
                value: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                }
            });
            setTimeout(()=>{
                var i = this.metadata.length - 1;
                $('#datatype-picker'+i).selectpicker('render');
            },1000);
        },
        addStructuredDataRow: function() {
            this.structured_data.push({
                key: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                value: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                }
            });
        },
        addDocument: function() {

        },
        removeStructuredData: function(i) {
            var sdata = this.structured_data[i];
            if(sdata.id) {
                this.structured_data_to_remove.push(sdata.id);
            }
            this.structured_data.splice(i,1);
        },
        removeMetadata: function(i) {
            var mdata = this.metadata[i];
            if(mdata.id) {
                this.metadata_to_remove.push(mdata.id);
            }
            this.metadata.splice(i,1);
        },
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
            this.metadata = [];
            this.structured_data = [];
            this.documents = [];
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
                this.isLoading = false;
                if(response.data.status == 0) {
                    this.device = response.data.device;
                    this.parseDevice()
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
        getMetdataValue: function(metadata){
            if(metadata.data_txt !== null && metadata.data_txt !== null) {
                return {
                    data_type: 'text',
                    value: metadata.data_txt
                };
            } else if (metadata.data_fp !== null && metadata.data_fp !== null) {
                return {
                    data_type: 'float',
                    value: metadata.data_fp
                };
            } else if (metadata.data_int !== null && metadata.data_int !== null) {
                return {
                    data_type: 'int',
                    value: metadata.data_int
                };
            }
        },
        saveDevice: function(){
            if(this.isLoading) return;

            if(this.is_valid(this.deviceForm)) {
                this.isLoading = true;
                var metadata = [];
                this.metadata.forEach((m)=>{
                    var mdata = {
                        metadata_type: m.type.value,
                        metadata_type_id: m.type_id.value
                    };
                    if(m.data_type === 'text') {
                        mdata.data_txt = m.value.value;
                    } else if(m.data_type === 'int') {
                        mdata.data_int = m.value.value;
                    } else if(m.data_type === 'float') {
                        mdata.data_fp = m.value.value;
                    }

                    if(m.id) {
                        mdata.id = m.id;
                    }
                    metadata.push(mdata)
                });

                var structured_data = [];
                this.structured_data.forEach((s)=>{
                    var sdata = {
                        structured_data_type: s.key.value,
                        structured_data_type_id: 1
                    };

                    sdata.data_array = {};
                    sdata.data_array[s.key.value] = s.value.value;
                    sdata.data_array = JSON.stringify(sdata.data_array);

                    if(s.id) {
                        sdata.id = s.id;
                    }
                    structured_data.push(sdata)
                });

                var data = {
                    device_id: parseInt(this.device_id),
                    manufacturer: this.deviceForm.manufacturer.value,
                    serial_number: this.deviceForm.serial_number.value,
                    part_number: this.deviceForm.part_number.value,
                    owner: this.deviceForm.owner.value,
                    metadata: metadata,
                    structured_data: structured_data,
                    structured_data_to_remove: this.structured_data_to_remove,
                    metadata_to_remove: this.metadata_to_remove
                };

                console.log(data);
                axios('/api/internal/device', {
                    method:'post',
                    data: data,
                    responseType: 'json',
                })
                    .then((response) => {
                        this.isLoading = false;
                        this.clearForm(this.deviceForm);
                        window.location = '/devices/'+response.data.device.id;
                    })
                    .catch((e) => {
                        this.isLoading = false;
                        if(e.response.hasOwnProperty('errorMessage')) {
                            swal("Error!", e.data.errorMessage, "error");
                        } else {
                            swal("Error!", "Something went wrong trying to save the device", "error");
                        }
                    });



            }
        },
        parseDevice: function(){
            var keys = Object.keys(this.device);
            keys.forEach((k)=>{
                if(this.deviceForm.hasOwnProperty(k) && typeof this.device[k] !== 'object' &&  typeof this.device[k] !== 'array') {
                    this.deviceForm[k].value = this.device[k];
                }
            });

            this.metadata = [];
            if(this.device.hasOwnProperty('metadata')) {
                if(this.device.metadata.length > 0) {
                    this.device.metadata.forEach((m)=>{
                        var metadataValue = this.getMetdataValue(m);
                        this.metadata.push({
                            id: m.id,
                            type: {
                                value: m.metadata_type,
                                isValid: true,
                                isClean: true,
                                validations: ['required']
                            },
                            type_id: {
                                value: m.metadata_type_id,
                                isValid: true,
                                isClean: true,
                                validations: ['required']
                            },
                            data_type: metadataValue.data_type,
                            value: {
                                value: metadataValue.value,
                                isValid: true,
                                isClean: true,
                                validations: ['required']
                            }
                        });
                        setTimeout(()=>{
                            var i = this.metadata.length - 1;
                            $('#datatype-picker'+i).selectpicker('render');
                        },1000);
                    });
                }
            }

            this.structured_data = [];
            if(this.device.hasOwnProperty('structured_data')) {
                this.device.structured_data.forEach((s)=>{
                    var dataObject = JSON.parse(s.data_array);
                    var dataKeys = Object.keys(dataObject);
                    dataKeys.forEach((k)=>{
                        this.structured_data.push({
                            id: s.id,
                            key: {
                                value: k,
                                isValid: true,
                                isClean: true,
                                validations: ['required']
                            },
                            value: {
                                value: dataObject[k],
                                isValid: true,
                                isClean: true,
                                validations: ['required']
                            }
                        });
                    });
                });
            }
        }
    }
}