<template>
    <div>
        <div v-if="isLoading" class="loader d-flex justify-content-center align-items-center">
            <div class="card text-center">
                <div class="card-body p-4">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="" onsubmit="return false;">
            <h2>Step 1: Generate USN (Universal Serial Number)</h2>
            <p>Use information from firmware. If not available, use information from device markings.</p>
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="" class="form-label">Manufacturer</label>
                        <input v-bind:disabled="isEdit" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.manufacturer.isClean,'is-invalid':!deviceForm.manufacturer.isClean && !deviceForm.manufacturer.isValid,'is-valid':!deviceForm.manufacturer.isClean && deviceForm.manufacturer.isValid}"
                               v-model="deviceForm.manufacturer.value"
                               @keyup="handleKeyPress(deviceForm.manufacturer)"
                               @focus="handleFocus(deviceForm.manufacturer)"
                               @blur="handleBlur(deviceForm.manufacturer)">
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Part Number</label>
                        <input v-bind:disabled="isEdit" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                               v-model="deviceForm.part_number.value"
                               @keyup="handleKeyPress(deviceForm.part_number)"
                               @focus="handleFocus(deviceForm.part_number)"
                               @blur="handleBlur(deviceForm.part_number)">
                        <div class="form-text">Use model if no part number is available</div>
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Serial Number</label>
                        <input v-bind:disabled="isEdit" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.serial_number.isClean,'is-invalid':!deviceForm.serial_number.isClean && !deviceForm.serial_number.isValid,'is-valid':!deviceForm.serial_number.isClean && deviceForm.serial_number.isValid}"
                               v-model="deviceForm.serial_number.value"
                               @keyup="handleKeyPress(deviceForm.serial_number)"
                               @focus="handleFocus(deviceForm.serial_number)"
                               @blur="handleBlur(deviceForm.serial_number)">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label fs-4">USN: </label>
                        <input type="text" class="form-control-plaintext fs-4 fw-bold text-success d-inline-block w-auto" v-model="usn_data.usn" disabled readonly>
                    </div>

                    <div v-if="!isEdit && usn_data.usn !== ''">
                        <p><button class="btn btn-link" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#calculations1"
                                                aria-expanded="true" aria-controls="calculations1"
                                                style="margin-left: -0.75rem;">Hide Calculations</button></p>

                        <div id="calculations1" class="collapse show">
                            <!-- TODO: copied from calculations-table.blade.php -->
                            <h4>HOW IS USN CALCULATED?</h4>
                            <table class="table" style="table-layout: fixed; vertical-align: middle;">
                                <tbody>
                                <tr>
                                    <td style="width: 50px;"><h3 class="mb-0">1</h3></td>
                                    <td><strong>SHA-256 hash of serial number</strong><br>{{ usn_data.serial_number_hash }}</td>
                                </tr>
                                <tr>
                                    <td><h3 class="mb-0">2</h3></td>
                                    <td><strong>obit DID = SHA-256(manufacturer + part number + hash from above)</strong><br>{{ usn_data.did }}</td>
                                </tr>
                                <tr>
                                    <td><h3 class="mb-0">3</h3></td>
                                    <td><strong>base58 of obit DID</strong><br>{{ usn_data.usn_base58 }}</td>
                                </tr>
                                <tr>
                                    <td><h3 class="mb-0">4</h3></td>
                                    <td><strong>USN = first eight characters of base58 above</strong><br><strong class="text-success">{{ usn_data.usn }}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <h2 id="documents" class="mt-5">Step 2: Attach Device Data & Information</h2>
            <div class="card">
                <div class="card-body">
                    <input type="file" id="upload-file" style="position: absolute; top: -9999999px;" ref="sfile" v-on:change="handleFileUpload">

                    <div v-if="documents.length > 0" class="table-responsive p-2">
                        <table class="table table-striped" style="vertical-align: middle;">
                            <thead>
                            <tr>
                                <th>Attach</th>
                                <th>Encrypt</th>
                                <th>Data Object Types</th>
                                <th>Description</th>
                                <th style="width: 50%;">Link to File</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(doc,i) in documents">
                                <td>
                                    <button class="btn btn-secondary w-100" @click="uploadDocument(i)">
                                        <span class="fas fa-paperclip"></span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" v-model="doc.encryption.value">
                                </td>
                                <td>
                                    <select class="form-select" v-model="doc.type.value">
                                        <option value="1">image - An image of the asset.</option>
                                        <option value="2">mainImage - Main image to be used for the asset.</option>
                                        <option value="3">functionalityReport - Used to prove repair.</option>
                                        <option value="4">dataSanitizationReport - Report of data destruction by either digital erasure of physical destruction of device.</option>
                                        <option value="5">dispositionReport - A report showing a claim the asset entered reuse or was recycled.</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control"
                                           v-bind:class="{'is-normal':doc.name.isClean,'is-invalid':!doc.name.isClean && !doc.name.isValid,'is-valid':!doc.name.isClean && doc.name.isValid}"
                                           v-model="doc.name.value"
                                           @focus="handleFocus(doc.name)"
                                           @blur="handleBlur(doc.name)">
                                </td>
                                <td>
                                    <input type="text" disabled class="form-control"
                                           v-bind:class="{'is-normal':doc.url.isClean,'is-invalid':!doc.url.isClean && !doc.url.isValid,'is-valid':!doc.url.isClean && doc.url.isValid}"
                                           v-model="doc.url.value"
                                           @focus="handleFocus(doc.url)"
                                           @blur="handleBlur(doc.url)">
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-floating" @click="removeDocument(i)"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="documents.length > 0" class="text-center">
                        <button class="btn btn-outline-info btn-floating" @click="addDocument()"><i class="fa fa-plus"></i></button>
                    </div>

                    <div v-if="documents.length === 0" class="text-center">
                        <button class="btn btn-outline-info btn-floating" @click="addDocument()"><i class="fa fa-plus"></i> Add Data Object</button>
                    </div>
                </div>
            </div>

            <h2 class="mt-5">Step 3: Prove Ownership of the Device</h2>
            <div class="card">
                <div class="card-body">
                    <p>An anonymous credential that can be used to identify you for legal compliance if necessary will be attached to the pNFT.</p>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" v-model="legal_agreement.value">
                        <label for="" class="form-check-label"><strong>Legal agreement.</strong> <br> I attest that I legally own this asset and I agree that this pNFT represents the ownership of this asset.</label>
                    </div>
                </div>
            </div>

            <h2 class="mt-5">Step 4: Prepay for ITAD Services <small><em class="text-muted">(coming soon)</em></small></h2>
            <div class="card">
                <div class="card-body">
                    <div class="form-check mt-2 mb-4">
                        <input type="checkbox" class="form-check-input" id="proof_of_data_destruction" disabled>
                        <label for="proof_of_data_destruction" class="form-check-label"><strong>Proof of Data Destruction</strong></label>
                        <p class="opacity-50">Attach  <input type="text" class="form-control d-inline-block text-end" style="width: 50px;" value="1" disabled>  OBD to the pNFT which can only be released with Proof of Data Destruction.</p>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="proof_of_recycling" disabled>
                        <label for="proof_of_recycling" class="form-check-label"><strong>Proof of Recycling</strong></label>
                        <p class="opacity-50">Attach  <input type="text" class="form-control d-inline-block text-end" style="width: 50px;" value="1" disabled>  OBD to the pNFT which can only be released with Proof of Recycling.</p>
                    </div>

                    <div class="mt-4 opacity-50">
                        <label for="prepay_total" class="form-label"><strong>Total Service Fees:</strong></label>
                        <input disabled readonly type="text" class="form-control-plaintext d-inline-block w-auto" id="prepay_total" value="0 OBD">
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <button :disabled="isLoading || !legal_agreement.value" class="btn btn-primary btn-lg" v-on:click="saveDevice">
                    <span
                        v-show="isLoading"
                        class="spinner-border spinner-border-sm"
                        role="status"
                        aria-hidden="true"></span>
                    Update Local Database
                </button>

                <p><small>Saves to the local database and the Client Helper.</small></p>

                <p v-if="!isEdit && usn_data.usn !== ''" class="mt-3">
                    Minting registers your pNFT.<br>
                    USN: <strong>{{ usn_data.usn }}</strong><br>
                    Obit DID: <strong>{{ usn_data.did }}</strong>
                </p>
            </div>
        </form>
    </div>
</template>

<script src="./index.js"></script>
