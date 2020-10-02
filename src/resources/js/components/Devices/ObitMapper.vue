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
                    <label for="">Obit DID</label>
                    <div class="input-group colored">
                        <input type="text" v-bind:disabled="isLoading" class="form-control no-shadow is-normal"
                               v-bind:class="{'is-normal':obitForm.obit_did.isClean,'is-invalid':!obitForm.obit_did.isClean && !obitForm.obit_did.isValid,'is-valid':!obitForm.obit_did.isClean && obitForm.obit_did.isValid}"
                               v-model="obitForm.obit_did.value"
                               @focus="handleFocus(obitForm.obit_did)"
                               @blur="handleBlur(obitForm.obit_did)"
                               placeholder="Obit DID">
                    </div>
                </div>


                <h4 v-if="isLoading">Retrieving Obit</h4>
                <h4 v-if="!isLoading && client_obit != null"></h4>

                <table class="table">
                    <tbody>
                        <tr v-if="deviceStatus.obada > 0">
                            <td>Found Obit in Obada Blockchain</td>
                            <td>
                                <button v-if="deviceStatus.obada == 1" class="btn btn-fab btn-success btn-round btn-sm text-center m-auto"><i class="fa fa-check"></i></button>
                                <button v-if="deviceStatus.obada == 2" class="btn btn-fab btn-danger btn-round btn-sm text-center m-auto"><i class="fa fa-exclamation-triangle"></i></button>
                            </td>
                        </tr>
                        <tr v-if="deviceStatus.obit > 0">
                            <td>Retrieved Obit Details</td>
                            <td>
                                <button v-if="deviceStatus.obit == 1" class="btn btn-fab btn-success btn-round btn-sm text-center m-auto"><i class="fa fa-check"></i></button>
                                <button v-if="deviceStatus.obit == 2" class="btn btn-fab btn-danger btn-round btn-sm text-center m-auto"><i class="fa fa-exclamation-triangle"></i></button>
                            </td>
                        </tr>
                        <tr v-if="deviceStatus.inventory > 0">
                            <td>Mapped Obit To Inventory</td>
                            <td>
                                <button v-if="deviceStatus.inventory == 1" class="btn btn-fab btn-success btn-round btn-sm text-center m-auto"><i class="fa fa-check"></i></button>
                                <button v-if="deviceStatus.inventory == 2" class="btn btn-fab btn-danger btn-round btn-sm text-center m-auto"><i class="fa fa-exclamation-triangle"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <div class="text-center mt-2">
                    <button class="btn btn-primary btn-round" @click="submitRequest">Retrieve</button>
                </div>

            </div>
        </form>
    </div>
</template>

<script src="./js/obitmapper.js"></script>
