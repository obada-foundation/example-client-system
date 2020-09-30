<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <form action="" onsubmit="return false;">
            <div class="text-left">
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

                <div class="card">
                    <div class="card-header">
                        <label>Metadata</label>
                    </div>
                    <div class="card-body">
                        <div v-for="(mdata,i) in metadata" class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <div class="input-group colored">
                                        <input type="text" class="form-control no-shadow is-normal"
                                               v-bind:class="{'is-normal':mdata.type.isClean,'is-invalid':!mdata.type.isClean && !mdata.type.isValid,'is-valid':!mdata.type.isClean && mdata.type.isValid}"
                                               v-model="mdata.type.value"
                                               @focus="handleFocus(mdata.type)"
                                               @blur="handleBlur(mdata.type)"
                                               placeholder="Type">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="input-group colored">
                                        <input type="text" class="form-control no-shadow is-normal"
                                               v-bind:class="{'is-normal':mdata.type_id.isClean,'is-invalid':!mdata.type_id.isClean && !mdata.type_id.isValid,'is-valid':!mdata.type_id.isClean && mdata.type_id.isValid}"
                                               v-model="mdata.type_id.value"
                                               @focus="handleFocus(mdata.type_id)"
                                               @blur="handleBlur(mdata.type_id)"
                                               placeholder="Type ID">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group select-colored">
                                    <select class="selectpicker" v-bind:id="'datatype-picker'+i" data-style="select-with-transition" title="Data Type" v-model="mdata.data_type">
                                        <option selected value="text">Text</option>
                                        <option selected value="float">Float</option>
                                        <option selected value="int">Integer</option>
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
                                <button class="btn btn-danger btn-sm btn-round" @click="removeMetadata(i)">x</button>
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
                        <div class="row">
                            <div class="col-12 text-center">
                                <button class="btn btn-white" @click="uploadDocument()"><i class="fa fa-plus"></i> Document</button>
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
                                    <div class="input-group colored">
                                        <input type="text" class="form-control no-shadow is-normal"
                                               v-bind:class="{'is-normal':sdata.type.isClean,'is-invalid':!sdata.type.isClean && !sdata.type.isValid,'is-valid':!sdata.type.isClean && sdata.type.isValid}"
                                               v-model="sdata.type.value"
                                               @focus="handleFocus(sdata.type)"
                                               @blur="handleBlur(sdata.type)"
                                               placeholder="Type">
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="input-group colored">
                                        <input type="text" class="form-control no-shadow is-normal"
                                               v-bind:class="{'is-normal':sdata.type_id.isClean,'is-invalid':!sdata.type_id.isClean && !sdata.type_id.isValid,'is-valid':!sdata.type_id.isClean && sdata.type_id.isValid}"
                                               v-model="sdata.type_id.value"
                                               @focus="handleFocus(sdata.type_id)"
                                               @blur="handleBlur(sdata.type_id)"
                                               placeholder="Type ID">
                                    </div>
                                </div>
                            </div>

                            <div class="col-1">
                                <button class="btn btn-danger btn-sm btn-round" @click="removeStructuredData(i)">x</button>
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
