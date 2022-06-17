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
                    <div class="form-group mb-4">
                        <label for="">Manufacturer</label>
                        <div class="input-group colored">
                            <input v-bind:disabled="device_id != 0" type="text" class="form-control no-shadow is-normal"
                                   v-bind:class="{'is-normal':deviceForm.manufacturer.isClean,'is-invalid':!deviceForm.manufacturer.isClean && !deviceForm.manufacturer.isValid,'is-valid':!deviceForm.manufacturer.isClean && deviceForm.manufacturer.isValid}"
                                   v-model="deviceForm.manufacturer.value"
                                   @focus="handleFocus(deviceForm.manufacturer)"
                                   @blur="handleBlur(deviceForm.manufacturer)">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Serial Number</label>
                        <div class="input-group colored">
                            <input v-bind:disabled="device_id != 0" type="text" class="form-control no-shadow is-normal"
                                   v-bind:class="{'is-normal':deviceForm.serial_number.isClean,'is-invalid':!deviceForm.serial_number.isClean && !deviceForm.serial_number.isValid,'is-valid':!deviceForm.serial_number.isClean && deviceForm.serial_number.isValid}"
                                   v-model="deviceForm.serial_number.value"
                                   @focus="handleFocus(deviceForm.serial_number)"
                                   @blur="handleBlur(deviceForm.serial_number)">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Part Number</label>
                        <div class="input-group colored">
                            <input v-bind:disabled="device_id != 0" type="text" class="form-control no-shadow is-normal"
                                   v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                                   v-model="deviceForm.part_number.value"
                                   @focus="handleFocus(deviceForm.part_number)"
                                   @blur="handleBlur(deviceForm.part_number)">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="">Obit ID</label>
                        <input type="text" class="form-control" value="did:obada:2336339182fdb8936ac29bee4f26bd58b3a645564f7c905cd52ab0eb35ff1feb" disabled readonly>
                        <div class="form-helper">Universal Identifier</div>
                    </div>
                    <div class="form-group">
                        <label for="">USN (Universal Serial Number)</label>
                        <input type="text" class="form-control" value="21DJshuv" disabled readonly>
                        <div class="form-helper">Shorter version of obit ID</div>
                    </div>
                    <p class="mt-3"><a href="#">Show Calculations</a></p>
                    <div class="d-none">
                        <h4>HOW IS USN CALCULATED?</h4>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td><h3>1</h3></td>
                                <td>serial_hash = sha256(serial_number)</td>
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
                    </div>
                </div>
            </div>

            <h2 class="mt-5">Step 2: Attach Device Information</h2>
            <div class="card">
                <div class="card-body">
                    <input type="file" id="upload-file" style="position: absolute; top: -9999999px;" ref="sfile" v-on:change="handleFileUpload">

                    <div v-for="(doc,i) in documents" class="row mb-4">
                        <div class="col-3">
                            <label for="" class="form-label">Information Type</label>
                            <select name="document_type" id="" class="form-control">
                                <option value="1">Device Picture</option>
                                <option value="2">Proof of Functionality</option>
                                <option value="3">Proof of Data Destruction</option>
                                <option value="4">Other</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="" class="form-label">Description</label>
                            <div class="input-group colored">
                                <input type="text" class="form-control no-shadow is-normal"
                                        v-bind:class="{'is-normal':doc.name.isClean,'is-invalid':!doc.name.isClean && !doc.name.isValid,'is-valid':!doc.name.isClean && doc.name.isValid}"
                                        v-model="doc.name.value"
                                        @focus="handleFocus(doc.name)"
                                        @blur="handleBlur(doc.name)">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="" class="form-label">URL</label>
                                <div class="input-group colored">
                                    <input type="text" class="form-control no-shadow is-normal"
                                           v-bind:class="{'is-normal':doc.url.isClean,'is-invalid':!doc.url.isClean && !doc.url.isValid,'is-valid':!doc.url.isClean && doc.url.isValid}"
                                           v-model="doc.url.value"
                                           @focus="handleFocus(doc.url)"
                                           @blur="handleBlur(doc.url)">
                                    <div class="input-group-append" @click="uploadDocument(i)">
                                        <span class="fa fa-upload"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-danger btn-floating" @click="removeDocument(i)" style="margin-top: 2rem;"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-outline-info btn-floating" @click="addDocument()"><i class="fa fa-plus"></i></button>
                    </div>

                    <div class="form-group mt-3 d-none">
                        <label for="">pNFT Checksum:</label>
                        <input type="text" class="form-control" value="A87AA0FDAE9DC37C8BFA0276495BCF72BAA4ADA36E3C67380208954B6108349C" disabled readonly>
                    </div>
                    <p class="mt-3 d-none"><a href="#">Show Calculations</a></p>
                    <div class="d-none">
                        <h4>HOW IS USN CALCULATED?</h4>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td><h3>1</h3></td>
                                <td>serial_hash = sha256(serial_number)</td>
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
                    </div>
                </div>
            </div>

            <h2 class="mt-5">Step 3: Prove Ownership of the Device</h2>
            <div class="card">
                <div class="card-body">
                    <p>Tradeloop will attach an anonymous credential to the pNFT that can be used to identify you for legal compliance if necessary.</p>
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
                <button class="btn btn-primary" @click="saveDevice">Mint pNFT</button>
            </div>

            <p class="text-center mt-4">
                <b>Blockchain address:</b><br>
                did:obada:e441d0761cb9500dd9c032f2a51b525f44c65fa08eab653f41ce222aab3823db<br><b>Web Addresses:</b><br>http://nft.tradeloop.com/obada/e441d0761cb9500dd9c032f2a51b525f44c65fa08eab653f41ce222aab3823db<br>http://nft.ascdi.com/obada/e441d0761cb9500dd9c032f2a51b525f44c65fa08eab653f41ce222aab3823db<br>http://nft.thebrokersite.com/obada/e441d0761cb9500dd9c032f2a51b525f44c65fa08eab653f41ce222aab3823db<br>+ many other nodes
            </p>
        </form>
    </div>
</template>

<script src="./index.js"></script>
