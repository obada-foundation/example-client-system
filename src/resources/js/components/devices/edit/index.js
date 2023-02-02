import axios from 'axios';
import * as bootstrap from "bootstrap";
import {formatUSN} from "../../../utils/formatUSN";

export default {
    props:[
        'is_mobile',
        'events',
        'device_id',
        'address',
        'loadDeviceUrl',
        'storeDocumentUrl',
        'deviceUrl',
        'storeDeviceUrl',
        'getUsnUrl',
        'mintNftUrl'
    ],
    data: function () {
        return {
            device: null,
            isMinting: false,
            isLoading: true,
            isEdit: false,
            usn_data: {
                usn: '',
                serial_number_hash: '',
                did: '',
                usn_base58: ''
            },
            cmOptions: {
                tabSize: 2,
                mode: 'json',
                theme: 'base16-light',
                lineNumbers: true,
                line: true,
                autoRefresh: true
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
            },
            documents: [],
            documents_to_remove: [],
            legal_agreement: {
                value: true,
                validations: ['required']
            }
        };
    },
    mounted: function () {
        this.isEdit = this.device_id !== 0;

        if (this.isEdit) {
            this.getDevice();
            this.legal_agreement.value = true;
        } else {
            this.isLoading = false;
        }
    },
    methods: {
        addDocument: function() {
            this.documents.push({
                type: {
                    value: '',
                    isValid: true,
                    isClean: true
                },
                name: {
                    value: '',
                    isValid: true,
                    isClean: true
                },
                url: {
                    value: '',
                    isValid: true,
                    isClean: true,
                    validations: ['required']
                },
                encryption: {
                    value: false,
                    isValid: true,
                    isClean: true,
                }
            });
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
            this.validate(v)
        },
        handleKeyPress: function(v) {
            this.updateUsn();
        },
        handleFileUpload: function(event) {
            if(event.target.files.length === 0) {
                swal("Unable To Upload File!", "Your file could not be uploaded. Please try again.", "error");
                return;
            }
            var file = event.target.files[0];

            if(file.size > 500*1024*1024) {
                this.toast("error",'File Too Large',"The file you are uploading is too large");
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
            axios.post(this.storeDocumentUrl, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((response) => {
                this.isLoading = false;
                var url = response.data.url;
                this.documents[this.documentUploadIndex].url.value = url;
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
            document.getElementById('upload-file').dispatchEvent(new MouseEvent("click"));
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
            axios.get(this.loadDeviceUrl, {}).then((response) => {
                this.isLoading = false;
                if(response.data.status == 0) {
                    this.device = response.data.device;
                    this.parseDevice();
                    this.usn_data.usn = formatUSN(this.device.usn);
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
        saveDevice: function(){
            if(this.isLoading) return;

            if(this.is_valid(this.deviceForm)) {
                this.isLoading = true;

                var isDocumentInvalid = true;
                var documents = [];

                // check if we only have 1 or more empty documents
                // if so - remove them

                this.documents.forEach((s)=>{

                    if(this.is_valid(s)) {
                        var docs = {
                            doc_type: s.type.value,
                            doc_name: s.name.value,
                            doc_path: s.url.value,
                            doc_encryption: s.encryption.value
                        };

                        if (s.id) {
                            docs.id = s.id;
                        }

                        documents.push(docs);
                    } else {
                        isDocumentInvalid = false;
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
                    documents: documents,
                    documents_to_remove: this.documents_to_remove,
                    address: this.address,
                };

                axios(this.storeDeviceUrl, {
                    method:'post',
                    data: data,
                    responseType: 'json',
                })
                    .then((response) => {
                        this.isLoading = false;
                        swal("Success!", "Device successfully saved!", "success");
                        window.location.href = '/devices/' + response.data.device.usn + '/show';
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
                swal("Error!", "Something went wrong trying to save the device", "error");
            }
        },
        parseDevice: function(){
            var keys = Object.keys(this.device);
            keys.forEach((k)=>{
                if(this.deviceForm.hasOwnProperty(k) && typeof this.device[k] !== 'object' &&  typeof this.device[k] !== 'array') {
                    this.deviceForm[k].value = this.device[k];
                }
            });

            this.documents = [];
            if(this.device.hasOwnProperty('documents') && this.device.documents.length > 0) {
                this.device.documents.forEach((s)=>{
                    this.documents.push({
                        id: s.id,
                        name: {
                            value: s.name,
                            isValid: true,
                            isClean: true,
                            validations: ['required']
                        },
                        url: {
                            value: s.path,
                            isValid: true,
                            isClean: true,
                            validations: ['required']
                        },
                        type: {
                            value: "1",
                            isValid: true,
                            isClean: true,
                        },
                        encryption: {
                            value: s.encryption,
                            isValid: true,
                            isClean: true
                        }
                    });
                });
            }
        },
        updateUsn: function() {
            const keys = Object.keys(this.deviceForm);
            let isValid = true;
            keys.forEach((k)=> {
                if(typeof(this.deviceForm[k]) === 'object') {
                    this.validate(this.deviceForm[k]);
                    if(!this.deviceForm[k].isValid) {
                        isValid = false;
                    }
                }
            });

            if (isValid) {
                axios(this.getUsnUrl, {
                    method: 'post',
                    data: {
                        manufacturer: this.deviceForm.manufacturer.value,
                        part_number: this.deviceForm.part_number.value,
                        serial_number: this.deviceForm.serial_number.value
                    },
                    responseType: 'json',
                })
                .then((response) => {
                    this.usn_data = response.data;
                    this.usn_data.usn = formatUSN(response.data.usn);
                })
                .catch((e) => {
                    if (e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "Unable to generate USN", "error");
                    }
                });
            }
        },
        mintpNFT: function() {
            const modalEl = document.getElementById('networkFeesModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            document.getElementById('networkFeesModalSubmit').addEventListener('click', event => {
                axios(this.mintNftUrl, {
                    method: 'post',
                    responseType: 'json',
                })
                .then((response) => {
                    modal.hide();
                    swal("Success!", "NFT was minted", "success");
                    window.location.href = this.deviceUrl
                })
                .catch((e) => {
                    modal.hide();
                    if (e.response.hasOwnProperty('errorMessage')) {
                        swal("Error!", e.data.errorMessage, "error");
                    } else {
                        swal("Error!", "Unable to generate USN", "error");
                    }
                });
            });
        }
    }
}
