<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <form action="" onsubmit="return false;">
            <h2>Device Identification</h2>
            <div class="text-left pt-3 pb-5">
                <div class="form-group">
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
                    <div class="input-group colored">
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control no-shadow is-normal"
                               v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                               v-model="deviceForm.part_number.value"
                               @focus="handleFocus(deviceForm.part_number)"
                               @blur="handleBlur(deviceForm.part_number)"
                               placeholder="Part Number">
                    </div>
                </div>
            </div>
            <h2>Device Data & Information</h2>
            <div class="text-left pt-3 pb-5">
                <div class="card">
                    <div class="card-header">
                        <label>Documents</label>
                    </div>
                    <div class="card-body">
                        <input type="file" id="upload-file" style="position: absolute; top: -9999999px;" ref="sfile" v-on:change="handleFileUpload">

                        <div v-for="(doc,i) in documents" class="row">
                            <div class="col-4">
                                <div class="input-group colored">
                                    <input type="text" class="form-control no-shadow is-normal"
                                            v-bind:class="{'is-normal':doc.name.isClean,'is-invalid':!doc.name.isClean && !doc.name.isValid,'is-valid':!doc.name.isClean && doc.name.isValid}"
                                            v-model="doc.name.value"
                                            @focus="handleFocus(doc.name)"
                                            @blur="handleBlur(doc.name)"
                                            placeholder="Document Name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-group colored">
                                        <input type="text" class="form-control no-shadow is-normal"
                                               v-bind:class="{'is-normal':doc.url.isClean,'is-invalid':!doc.url.isClean && !doc.url.isValid,'is-valid':!doc.url.isClean && doc.url.isValid}"
                                               v-model="doc.url.value"
                                               @focus="handleFocus(doc.url)"
                                               @blur="handleBlur(doc.url)"
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

                <div class="text-end">
                    <button class="btn btn-primary" @click="saveDevice">SAVE</button>
                </div>

            </div>
        </form>
    </div>
</template>

<script src="./index.js"></script>
