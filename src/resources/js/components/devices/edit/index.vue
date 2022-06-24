<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <form action="" onsubmit="return false;">
            <h2>Step 1: Generate USN (Universal Serial Number)</h2>
            <p>Use information from firmware. If not available, use information from device markings.</p>
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="" class="form-label">Manufacturer</label>
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.manufacturer.isClean,'is-invalid':!deviceForm.manufacturer.isClean && !deviceForm.manufacturer.isValid,'is-valid':!deviceForm.manufacturer.isClean && deviceForm.manufacturer.isValid}"
                               v-model="deviceForm.manufacturer.value"
                               @keyup="handleKeyPress(deviceForm.manufacturer)"
                               @focus="handleFocus(deviceForm.manufacturer)"
                               @blur="handleBlur(deviceForm.manufacturer)">
                    </div>
                    <div class="mb-4">
                        <label for="">Part Number</label>
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                               v-model="deviceForm.part_number.value"
                               @keyup="handleKeyPress(deviceForm.part_number)"
                               @focus="handleFocus(deviceForm.part_number)"
                               @blur="handleBlur(deviceForm.part_number)">
                        <div class="form-text">Use model if no part number is available</div>
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Serial Number</label>
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control"
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

                    <p><button class="btn btn-link" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#calculations1"
                                            aria-expanded="false" aria-controls="calculations1"
                                            style="margin-left: -0.75rem;">Show Calculations</button></p>

                    <div id="calculations1" class="collapse">
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
                                <td><strong>USN = first eight characters of base58 above</strong><br>{{ usn_data.usn }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h2 id="documents" class="mt-5">Step 2: Attach Device Data & Information</h2>
            <div class="card">
                <div class="card-body">
                    <input type="file" id="upload-file" style="position: absolute; top: -9999999px;" ref="sfile" v-on:change="handleFileUpload">

                    <div v-for="(doc,i) in documents" class="row mb-4">
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="" class="form-label">Information Type</label>
                            <select class="form-select"
                                    v-model="doc.name.type">
                                <option value="1">Device Picture</option>
                                <option value="2">Proof of Functionality</option>
                                <option value="3">Proof of Data Destruction</option>
                                <option value="4">Other</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <label for="" class="form-label">Description</label>
                            <input type="text" class="form-control"
                                    v-bind:class="{'is-normal':doc.name.isClean,'is-invalid':!doc.name.isClean && !doc.name.isValid,'is-valid':!doc.name.isClean && doc.name.isValid}"
                                    v-model="doc.name.value"
                                    @focus="handleFocus(doc.name)"
                                    @blur="handleBlur(doc.name)">
                        </div>
                        <div class="col-10 col-sm-10 col-md-5">
                            <div class="form-group">
                                <label for="" class="form-label">URL</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           v-bind:class="{'is-normal':doc.url.isClean,'is-invalid':!doc.url.isClean && !doc.url.isValid,'is-valid':!doc.url.isClean && doc.url.isValid}"
                                           v-model="doc.url.value"
                                           @focus="handleFocus(doc.url)"
                                           @blur="handleBlur(doc.url)">
                                    <button class="btn btn-secondary" @click="uploadDocument(i)">
                                        <span class="fas fa-upload"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 col-sm-2 col-md-1">
                            <button class="btn btn-danger btn-floating" @click="removeDocument(i)" style="margin-top: 2rem;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-outline-info btn-floating" @click="addDocument()"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>

            <h2 class="mt-5">Step 3: Prove Ownership of the Device</h2>
            <div class="card">
                <div class="card-body">
                    <p>An anonymous credential that can be used to identify you for legal compliance if necessary will be attached to the pNFT.</p>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="1" id="legal_agreement">
                        <label for="legal_agreement" class="form-check-label">Legal agreement. <br> I attest that I legally own this asset and I agree that this pNFT represents the ownership of this asset.</label>
                    </div>
                </div>
            </div>

            <h2 class="mt-5">Step 4: Accept Fees</h2>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-0 col-md-6 d-flex align-items-center">
                            <p>System fees, such as gas, storage and the Recycling Incentive, are set by the DAO and distributed equally to the operating DAO nodes. Third-party applications and off-chain services charge their fees separately.</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <table class="table" style="vertical-align: middle;">
                                <tbody>
                                <tr>
                                    <td><strong>Gas Fee</strong> <br> <small>Validator node fee.</small></td>
                                    <td class="text-end">0.001 OBD</td>
                                </tr>
                                <tr>
                                    <td><strong>Storage Charge</strong><br><small>File storage costs.</small></td>
                                    <td class="text-end">0.001 OBD</td>
                                </tr>
                                <tr>
                                    <td><strong>Application Fee</strong><br><small>Gateway usage fee.</small></td>
                                    <td class="text-end">0.001 OBD</td>
                                </tr>
                                <tr>
                                    <td><strong>Recycling Incentive</strong> <em>(optional)</em><br><small>Will be returned when the device is recycled.</small></td>
                                    <td class="text-end">1 OBD</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td class="border-0"><strong class="fs-5">Total</strong></td>
                                    <td class="border-0 text-end"><strong class="fs-5">0.003 OBD</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <button class="btn btn-primary btn-lg" @click="saveDevice">Mint pNFT</button>
                <p class="mt-3">
                    Minting registers your USN <strong>{{ usn_data.usn }}</strong>. <br>
                    The blockchain address for this pNFT is: <br>
                    <strong>{{ usn_data.did }}</strong>
                </p>
            </div>
        </form>
    </div>
</template>

<script src="./index.js"></script>
