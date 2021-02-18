export default {
    props:['is_mobile','events','device_id','schema'],
    data: function () {
        return {
            device: null,
            isLoading: true,
            cmOptions: {
                // codemirror options
                tabSize: 2,
                mode: 'json',
                theme: 'base16-light',
                lineNumbers: true,
                line: true,
                autoRefresh: true
                // more codemirror options, 更多 codemirror 的高级配置...
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
                owner: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                status: {
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
            structured_data_to_remove: [],
            documents_to_remove: [],
            schema_list: {
                device : [],
                events: [],
                other: []
            }
        };
    },
    mounted: function () {
        if(this.device_id != 0) {
            this.getDevice();
        } else {
            this.isLoading = false;
        }
        this.schema_list = {
            device : [],
            events: [],
            other: []
        };
        this.schema.forEach((schema)=>{
            this.schema_list[schema.category].push(schema);
        })
    },
    watch: {
        schema: function(){
            this.schema_list = {
                device : [],
                    events: [],
                    other: []
            };
            this.schema.forEach((schema)=>{
                this.schema_list[schema.category].push(schema);
            })
        }
    },
    methods: {

        addMetadataRow: function() {
            this.metadata.push({
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
                $('#type-picker'+i).selectpicker('render');
            },1000);
        },
        addStructuredDataRow: function() {
            this.structured_data.push({
                type_id: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                value: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required','json']
                }
            });
            setTimeout(()=>{
                var i = this.structured_data.length - 1;
                $('#schema-type-picker'+i).selectpicker('render');
            },1000);
        },
        addDocument: function() {
            this.documents.push({
                type_id: {
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
            setTimeout(()=>{
                var i = this.documents.length - 1;
                $('#doc-type-picker'+i).selectpicker('render');
            },1000);
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
        removeDocument: function(i) {
            var doc = this.documents[i];
            if(doc.id) {
                this.documents_to_remove.push(doc.id);
            }
            this.documents.splice(i,1);
        },
        handleFocus: function(v){
            v.isClean = false;
        },
        handleBlur: function(v) {
            console.log("Blur")
            this.validate(v)
        },
        handleFileUpload: function(event) {
            if(event.target.files.length === 0) {
                swal("Unable To Upload File!", "Your file could not be uploaded. Please try again.", "error");
                return;
            }
            var file = event.target.files[0];

            if(file.size > 500*1024*1024) {
                this.toast("error",'File Too Large',"The file you are uploading is too large");
                $('#upload-background').val('');
                return;
            }
            this.fileUploading = true;
            var reader = new FileReader();
            this.progressWidth = 0;
            reader.onprogress = (e) => {
                var perc = Math.ceil((e.loaded / e.total) * 100);
                this.progressWidth = perc * 0.5;
            }
            reader.onload = (e) => {
                var d = new Date();
                var n = d.getTime();

                var uid = n;
                var data = {
                    uid: uid,
                    status: 0,
                    uploaded: e.target.result,
                    file: file,
                    file_type: file.type
                };

                this.beginUpload(data);

            }
            reader.readAsDataURL(file);
        },
        beginUpload: function(data){
            this.progressWidth = 50;
            let formData = new FormData();
            formData.append('file', data.file);
            formData.append('file_type', data.file_type);
            formData.append('folder', 'documents');
            this.isLoading = true;
            axios.post( '/api/internal/document/upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                console.log(response);
                this.isLoading = false;
                var url = response.data.url;
                this.documents[this.documentUploadIndex].value.value = url;
                this.progressWidth = 100;
                this.fileUploading = false;
            }).catch(() => {
                swal('Unable to upload file.','','error');
                this.fileUploading = false;
                this.isLoading = false;
            });
        },
        uploadDocument: function(i){
            this.documentUploadIndex = i;
            $('#upload-file').click();
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

            if(f.validations.includes('json')) {
                try {
                    var json = JSON.parse(f.value);
                } catch(e) {
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
            axios.get('/api/internal/device/id/'+this.device_id, {}).then((response) => {
                this.isLoading = false;
                if(response.data.status == 0) {
                    this.device = response.data.device;
                    this.parseDevice()
                }
            }).catch((e) => {
                this.isLoading = false;
                if(e.response.data.hasOwnProperty('errorMessage')) {
                    swal("Error!", e.response.data.errorMessage, "error");
                } else {
                    swal("Unable To Get Device!", "We could not find this device in the database.", "error");
                }
            });
        },
        getMetdataValue: function(metadata){
            if(metadata.data_txt !== null) {
                return {
                    data_type: 'text',
                    value: metadata.data_txt
                };
            } else if (metadata.data_fp !== null) {
                return {
                    data_type: 'float',
                    value: metadata.data_fp
                };
            } else if (metadata.data_int !== null) {
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
                var isMetadataValid = true;
                this.metadata.forEach((m)=>{
                    if(this.is_valid(m)) {
                        var mdata = {
                            metadata_type_id: m.type_id.value
                        };
                        if(m.data_type === 'text') {
                            mdata.data_txt = m.value.value;
                        } else if(m.data_type === 'int') {
                            mdata.data_int = parseInt(m.value.value);
                        } else if(m.data_type === 'float') {
                            mdata.data_fp = parseFloat(m.value.value);
                        }

                        if(m.id) {
                            mdata.id = m.id;
                        }
                        metadata.push(mdata)
                    } else {
                        isMetadataValid = false;
                        return;
                    }

                });

                if(!isMetadataValid) {
                    this.isLoading = false;
                    swal("Error!", "Metadata Type or Value Is Invalid", "error");
                    return;
                }

                var isStructuredDataValid = true;
                var structured_data = [];
                this.structured_data.forEach((s)=>{
                    if(this.is_valid(s)) {
                        var sdata = {
                            structured_data_type_id: s.type_id.value
                        };

                        sdata.data_array = s.value.value;

                        if (s.id) {
                            sdata.id = s.id;
                        }
                        structured_data.push(sdata)
                    } else {
                        isStructuredDataValid = false;
                    }
                });

                if(!isStructuredDataValid) {
                    this.isLoading = false;
                    swal("Error!", "Structured Data Type or Value Is Invalid", "error");
                    return;
                }

                var isDocumentInvalid = true;
                var documents = [];
                this.documents.forEach((s)=>{
                    if(this.is_valid(s)) {
                        var docs = {
                            doc_type_id: s.type_id.value
                        };

                        docs.doc_path = s.value.value;

                        if (s.id) {
                            docs.id = s.id;
                        }
                        documents.push(docs)
                    } else {
                        isDocumentInvalid = false
                    }
                });

                if(!isDocumentInvalid) {
                    this.isLoading = false;
                    swal("Error!", "Document Type or URL Is Invalid", "error");
                    return;
                }

                var data = {
                    device_id: parseInt(this.device_id),
                    manufacturer: this.deviceForm.manufacturer.value,
                    serial_number: this.deviceForm.serial_number.value,
                    part_number: this.deviceForm.part_number.value,
                    owner: this.deviceForm.owner.value,
                    metadata: metadata,
                    structured_data: structured_data,
                    structured_data_to_remove: this.structured_data_to_remove,
                    metadata_to_remove: this.metadata_to_remove,
                    status: this.deviceForm.status.value,
                    documents: documents,
                    documents_to_remove: this.documents_to_remove
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
                        window.location = '/devices/'+response.data.device.obit_did;
                    })
                    .catch((e) => {
                        this.isLoading = false;
                        if(e.response.data.hasOwnProperty('errorMessage')) {
                            swal("Error!", e.response.data.errorMessage, "error");
                        } else {
                            swal("Error!", "Something went wrong trying to save the device", "error");
                        }
                    });



            } else
            {
                console.log(this.deviceForm);
                swal("Error!", "Something went wrong trying to save the device", "error");
            }
        },
        parseDevice: function(){
            console.log(this.device);
            var keys = Object.keys(this.device);
            keys.forEach((k)=>{
                if(this.deviceForm.hasOwnProperty(k) && typeof this.device[k] !== 'object' &&  typeof this.device[k] !== 'array') {
                    this.deviceForm[k].value = this.device[k];
                }
            });

            $('#status-picker').selectpicker('render');
            $('#status-picker').val(this.deviceForm.status.value).trigger('change');

            this.metadata = [];
            if(this.device.hasOwnProperty('metadata')) {
                if(this.device.metadata.length > 0) {
                    this.device.metadata.forEach((m)=>{
                        var metadataValue = this.getMetdataValue(m);
                        this.metadata.push({
                            id: m.id,
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
                        this.triggerPickerChange('metadata',this.metadata.length - 1);
                    });
                }
            }

            this.structured_data = [];
            if(this.device.hasOwnProperty('structured_data') && this.device.structured_data.length > 0) {
                this.device.structured_data.forEach((s)=>{
                    this.structured_data.push({
                        id: s.id,
                        type_id: {
                            value: s.structured_data_type_id,
                            isValid: true,
                            isClean: true,
                            validations: ['required']
                        },
                        value: {
                            value: beautifyJS(s.data_array,{indent_size: 2}),
                            isValid: true,
                            isClean: true,
                            validations: ['required','json']
                        }
                    });
                    this.triggerPickerChange('structured_data',this.structured_data.length - 1);
                });
            }

            this.documents = [];
            if(this.device.hasOwnProperty('documents') && this.device.documents.length > 0) {
                this.device.documents.forEach((s)=>{
                    this.documents.push({
                        id: s.id,
                        type_id: {
                            value: s.doc_type_id,
                            isValid: true,
                            isClean: true,
                            validations: ['required']
                        },
                        value: {
                            value: s.doc_path,
                            isValid: true,
                            isClean: true,
                            validations: ['required']
                        }
                    });
                    this.triggerPickerChange('documents',this.documents.length - 1);
                });

            }

        },
        triggerPickerChange: function (type, i) {
            setTimeout(()=>{
                if(type === 'documents') {
                    $('#doc-type-picker'+i).selectpicker('render');
                    $('#doc-type-picker'+i).val(this.documents[i].type_id.value).trigger('change');
                } else if (type === 'structured_data') {
                    $('#schema-type-picker'+i).selectpicker('render');
                    $('#schema-type-picker'+i).val(this.structured_data[i].type_id.value).trigger('change');
                } else if (type === 'metadata') {
                    $('#type-picker'+i).selectpicker('render');
                    $('#type-picker'+i).val(this.metadata[i].type_id.value).trigger('change');
                }
            },1000);
        }
    }
}
