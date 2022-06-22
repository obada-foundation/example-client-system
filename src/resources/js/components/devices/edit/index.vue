<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <form action="" onsubmit="return false;">
            <h2>Step 1: Generate Universal Identifiers</h2>
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="" class="form-label">Manufacturer</label>
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.manufacturer.isClean,'is-invalid':!deviceForm.manufacturer.isClean && !deviceForm.manufacturer.isValid,'is-valid':!deviceForm.manufacturer.isClean && deviceForm.manufacturer.isValid}"
                               v-model="deviceForm.manufacturer.value"
                               @focus="handleFocus(deviceForm.manufacturer)"
                               @blur="handleBlurForUsnField(deviceForm.manufacturer)">
                    </div>
                    <div class="mb-4">
                        <label for="" class="form-label">Serial Number</label>
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.serial_number.isClean,'is-invalid':!deviceForm.serial_number.isClean && !deviceForm.serial_number.isValid,'is-valid':!deviceForm.serial_number.isClean && deviceForm.serial_number.isValid}"
                               v-model="deviceForm.serial_number.value"
                               @focus="handleFocus(deviceForm.serial_number)"
                               @blur="handleBlurForUsnField(deviceForm.serial_number)">
                    </div>
                    <div class="mb-4">
                        <label for="">Part Number</label>
                        <input v-bind:disabled="device_id != 0" type="text" class="form-control"
                               v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                               v-model="deviceForm.part_number.value"
                               @focus="handleFocus(deviceForm.part_number)"
                               @blur="handleBlurForUsnField(deviceForm.part_number)">
                    </div>
                    <div v-if="usn_data != null" class="form-group mb-4">
                        <label for="" class="form-label">Obit ID</label>
                        <input type="text" class="form-control" v-model="usn_data.did" disabled readonly>
                        <div class="form-text">Universal Identifier</div>
                    </div>
                    <div v-if="usn_data != null" class="form-group">
                        <label for="" class="form-label">USN (Universal Serial Number)</label>
                        <input type="text" class="form-control" v-model="usn_data.usn" disabled readonly>
                        <div class="form-text">Shorter version of obit ID</div>
                    </div>

                    <p v-if="usn_data != null" class="mt-3"><button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#calculations1" aria-expanded="false" aria-controls="calculations1">Show Calculations</button></p>
                    <div v-if="usn_data != null" id="calculations1" class="collapse">
                        <h4>HOW IS USN CALCULATED?</h4>
                        <table class="table" style="table-layout: fixed">
                            <tbody>
                            <tr>
                                <td style="width: 50px;"><h3>1</h3></td>
                                <td style="width: 40%;">serial_hash = sha256(serial_number)</td>
                                <td>{{ usn_data.serial_number_hash }}</td>
                            </tr>
                            <tr>
                                <td><h3>2</h3></td>
                                <td>obit = sha256(manufacturer + part_number + serial_hash)</td>
                                <td>{{ usn_data.did }}</td>
                            </tr>
                            <tr>
                                <td><h3>3</h3></td>
                                <td>usn_base58 = base58(obit)</td>
                                <td>{{ usn_data.usn_base58 }}</td>
                            </tr>
                            <tr>
                                <td><h3>4</h3></td>
                                <td>usn = first_eight(usn_base58)</td>
                                <td>{{ usn_data.usn }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <h2 id="documents" class="mt-5">Step 2: Attach Device Information</h2>
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

                    <!-- TODO: calculate checksum -->
<!--                    <div v-if="documents.length > 0" class="form-group mt-3">
                        <label for="" class="form-label">pNFT Checksum:</label>
                        <input type="text" class="form-control" value="A87AA0FDAE9DC37C8BFA0276495BCF72BAA4ADA36E3C67380208954B6108349C" disabled readonly>
                    </div>

                    <p v-if="documents.length > 0" class="mt-3"><button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#calculations2" aria-expanded="false" aria-controls="calculations2">Show Calculations</button></p>
                    <div v-if="documents.length > 0" id="calculations2" class="collapse">
                        <h4>HOW IS USN CALCULATED?</h4>
                        <table class="table" style="table-layout: fixed">
                            <tbody>
                            <tr>
                                <td style="width: 50px;"><h3>1</h3></td>
                                <td style="width: 40%;">serial_hash = sha256(serial_number)</td>
                                <td>6e712b383180c2ee7fff19b8bb1222c39ca5673ef2547240bfd4021d4f544922</td>
                            </tr>
                            <tr>
                                <td><h3>2</h3></td>
                                <td>obit = sha256(manufacturer + part_number + serial_hash)</td>
                                <td>did:obada:2336339182fdb8936ac29bee4f26bd58b3a645564f7c905cd52ab0eb35ff1feb</td>
                            </tr>
                            <tr>
                                <td><h3>3</h3></td>
                                <td>usn_base58 = base58(obit)</td>
                                <td>21DJshuvoVj4dQ36NCkp6SyAmWAZyDXfZusVgCKdmqkZimqHRoPvm6PJwCaAA4F9Po4RGqpHNNJy7Y91oiQddcNu
                                </td>
                            </tr>
                            <tr>
                                <td><h3>4</h3></td>
                                <td>usn = first_eight(usn_base58)</td>
                                <td>21DJshuv</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>-->
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
                    <h4 class="mt-2">Transaction fee:</h4>
                    <table class="table table-sm table-bordered">
                        <tbody>
                        <tr>
                            <td>Gas Fee (node fee set by the DAO)</td>
                            <td class="text-end">0.001 OBD</td>
                        </tr>
                        <tr>
                            <td>IPFS Storage Charge (file storage fee set by the DAO)</td>
                            <td class="text-end">0.001 OBD</td>
                        </tr>
                        <tr>
                            <td>Service Fee (gateway fee)</td>
                            <td class="text-end">0.001 OBD</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td class="text-end"><strong>0.003 OBD</strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-5 text-center">
                <button class="btn btn-primary btn-lg" @click="saveDevice">Mint pNFT</button>
            </div>
        </form>
    </div>
</template>

<script src="./index.js"></script>
