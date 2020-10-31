<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <form action="" onsubmit="return false;">
            <h2>Owner Information</h2>
            <div class="text-left py-5">
                <div class="form-group">
                    <label for="">Owner</label>
                    <div class="input-group colored">
                        <input type="text" class="form-control no-shadow is-normal"
                               v-bind:class="{'is-normal':deviceForm.owner.isClean,'is-invalid':!deviceForm.owner.isClean && !deviceForm.owner.isValid,'is-valid':!deviceForm.owner.isClean && deviceForm.owner.isValid}"
                               v-model="deviceForm.owner.value"
                               @focus="handleFocus(deviceForm.owner)"
                               @blur="handleBlur(deviceForm.owner)"
                               placeholder="Owner">
                    </div>
                </div>

            </div>
            <h2>Device Identification</h2>
            <div class="text-left py-5">
                <div class="form-group">
                    <label for="">Manufacturer</label>
                    <div class="input-group colored">
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control no-shadow is-normal"
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
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control no-shadow is-normal"
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
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control no-shadow is-normal"
                               v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                               v-model="deviceForm.part_number.value"
                               @focus="handleFocus(deviceForm.part_number)"
                               @blur="handleBlur(deviceForm.part_number)"
                               placeholder="Part Number">
                    </div>
                </div>

                <div class="form-group">
                    <label for="status-picker">Status</label>
                    <div class="form-group select-colored">
                        <select class="selectpicker" id="status-picker" data-style="select-with-transition" title="Status" v-model="deviceForm.status.value">
                            <option selected value="FUNCTIONAL">FUNCTIONAL</option>
                            <option value="NON_FUNCTIONAL">NON FUNCTIONAL</option>
                            <option value="DISPOSED">DISPOSED</option>
                            <option value="STOLEN">STOLEN</option>
                            <option value="DISABLED_BY_OWNER">DISABLED BY OWNER</option>
                        </select>
                    </div>
                </div>

            </div>
            <h2>Device Data & Information</h2>
            <div class="text-left py-5">
                <div class="card">
                    <div class="card-header">
                        <label>Metadata</label>
                    </div>
                    <div class="card-body">
                        <div v-for="(mdata,i) in metadata" class="row">
                            <div class="col-2">
                                <div class="form-group select-colored">
                                    <select class="selectpicker" v-bind:id="'type-picker'+i" data-style="select-with-transition" title="Type" v-model="mdata.type_id.value">
                                        <option v-for="type in schema" v-bind:value="type.name">{{type.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group select-colored">
                                    <select class="selectpicker" v-bind:id="'datatype-picker'+i" data-style="select-with-transition" title="Data Type" v-model="mdata.data_type">
                                        <option selected value="text">Text</option>
                                        <option value="float">Float</option>
                                        <option value="int">Integer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="input-group colored">
                                        <input type="text" class="form-control no-shadow is-normal"
                                               v-bind:class="{'is-normal':mdata.value.isClean,'is-invalid':!mdata.value.isClean && !mdata.value.isValid,'is-valid':!mdata.value.isClean && mdata.value.isValid}"
                                               v-model="mdata.value.value"
                                               @focus="handleFocus(mdata.value)"
                                               @blur="handleBlur(mdata.value)"
                                               placeholder="Value">
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-danger btn-sm btn-fab btn-round" @click="removeMetadata(i)"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="btn btn-white" @click="addMetadataRow()"><i class="fa fa-plus"></i> Metadata</button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <label>Documents</label>
                    </div>
                    <div class="card-body">
                        <input type="file" id="upload-file" style="position: absolute; top: -9999999px;" ref="sfile" v-on:change="handleFileUpload">

                        <div v-for="(doc,i) in documents" class="row">
                            <div class="col-4">
                                <div class="form-group select-colored">
                                    <select class="selectpicker" v-bind:id="'doc-type-picker'+i" data-style="select-with-transition" title="Type" v-model="doc.type_id.value">
                                        <option v-for="type in schema" v-bind:value="type.name">{{type.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group colored">
                                        <input type="text" class="form-control no-shadow is-normal"
                                               v-bind:class="{'is-normal':doc.value.isClean,'is-invalid':!doc.value.isClean && !doc.value.isValid,'is-valid':!doc.value.isClean && doc.value.isValid}"
                                               v-model="doc.value.value"
                                               @focus="handleFocus(doc.value)"
                                               @blur="handleBlur(doc.value)"
                                               placeholder="URL">
                                        <div class="input-group-append" @click="uploadDocument(i)">
                                            <span class="fa fa-upload"></span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-danger btn-fab btn-sm btn-round" @click="removeDocument(i)"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="btn btn-white" @click="addDocument()"><i class="fa fa-plus"></i> Document</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <label>Structured Data</label>
                    </div>
                    <div class="card-body">
                        <div v-for="(sdata,i) in structured_data" class="row justify-content-between">
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="form-group select-colored">
                                        <select class="selectpicker" v-bind:id="'schema-type-picker'+i" data-style="select-with-transition" title="Type" v-model="sdata.type_id.value">
                                            <option v-for="type in schema" v-bind:value="type.name">{{type.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-1">
                                <button class="btn btn-danger btn-fab btn-sm btn-round" @click="removeStructuredData(i)"><i class="fa fa-minus"></i></button>
                            </div>
                            <div class="col-12">
                                <codemirror v-model="sdata.value.value" :options="cmOptions"></codemirror>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="btn btn-white" @click="addStructuredDataRow()"><i class="fa fa-plus"></i> Structured Data</button>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="text-right">
                    <button class="btn btn-primary btn-round" @click="saveDevice">SAVE</button>
                </div>

            </div>
        </form>
    </div>
</template>

<script src="./js/editdevice.js"></script>
