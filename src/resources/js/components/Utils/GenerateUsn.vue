<template>
    <form action="" onsubmit="return false;">
        <div class="text-left">
            <div class="form-group">
                <label for="">Manufacturer</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
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
                    <input type="text" class="form-control no-shadow is-normal"
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
                    <input type="text" class="form-control no-shadow is-normal"
                           v-bind:class="{'is-normal':deviceForm.part_number.isClean,'is-invalid':!deviceForm.part_number.isClean && !deviceForm.part_number.isValid,'is-valid':!deviceForm.part_number.isClean && deviceForm.part_number.isValid}"
                           v-model="deviceForm.part_number.value"
                           @focus="handleFocus(deviceForm.part_number)"
                           @blur="handleBlur(deviceForm.part_number)"
                           placeholder="Part Number">
                </div>
            </div>



            <div v-if="usn_data != null" class="form-group">
                <label for="">Obit</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           disabled
                           v-model="usn_data.obit_did"
                           placeholder="Obit DID">
                </div>
            </div>
            <div v-if="usn_data != null" class="form-group">
                <label for="">Universal Serial Number</label>
                <div class="input-group colored">
                    <input type="text" class="form-control no-shadow is-normal"
                           disabled
                           v-model="usn_data.usn"
                           placeholder="Universal Serial Number">
                </div>
            </div>

            <h4 v-if="usn_data != null">HOW IS USN CALCULATED?</h4>

            <table v-if="usn_data != null" class="table">
                <tbody>
                <tr>
                    <td><h3>1</h3></td>
                    <td>serial_hash = sha256(serial_number)</td>
                    <td>{{usn_data.serial_hash}}</td>
                </tr>
                <tr>
                    <td><h3>2</h3></td>
                    <td>obit = sha256(manufacturer + part_number + serial_hash)</td>
                    <td>{{usn_data.obit_did}}</td>
                </tr>
                <tr>
                    <td><h3>3</h3></td>
                    <td>usn_base58 = base58(obit)</td>
                    <td>{{usn_data.usn_base58}}</td>
                </tr>
                <tr>
                    <td><h3>4</h3></td>
                    <td>usn = first_eight(usn_base58)</td>
                    <td>{{usn_data.usn}}</td>
                </tr>
                </tbody>
            </table>


            <div class="text-right">
                <button v-if="usn_data != null" class="btn btn-outline-primary btn-round" @click="clearRequest">Clear</button>
                <button class="btn btn-primary btn-round" @click="submitRequest">Generate</button>
            </div>

        </div>
    </form>

</template>
<script src="./js/generateusn.js"></script>
