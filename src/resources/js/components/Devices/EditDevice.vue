<template>
    <div>
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

                <div class="text-right">
                    <button class="btn btn-primary btn-round">SAVE</button>
                </div>

            </div>
        </form>
    </div>
</template>

<script src="./js/editdevice.js"></script>
