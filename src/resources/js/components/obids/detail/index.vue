<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>

        <h2>Owner Information</h2>
        <div class="card mb-5">
            <div class="card-body">
                <ul v-if="localObit != null" class="list-group list-group-flush mt-3 mb-2">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Owner</strong>
                            </div>
                            <div class="col-md-8">
                                {{ localObit.owner }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


        <h2>Device Identification</h2>
        <div class="card mb-5">
            <div class="card-body">
                <ul v-if="localObit != null" class="list-group list-group-flush mt-3 mb-2">
                    <device-row :bold_title="true" :title="'Universal Serial Number'" :value="localObit.usn"></device-row>
                    <device-row :bold_title="true" :classes="{'lower':true}"  :title="'DID'" :value="localObit.did"></device-row>
                    <device-row :bold_title="true" :title="'Serial Number Hash'" :value="localObit.serial_number_hash"></device-row>
                    <device-row :bold_title="true" :title="'Manufacturer'" :value="localObit.manufacturer"></device-row>
                    <device-row :bold_title="true" :title="'Part Number'" :value="localObit.part_number"></device-row>
                </ul>
            </div>
        </div>


        <h2>Device Data & Information</h2>
        <div class="card mb-5">
            <div class="card-body">
                <ul v-if="localObit != null" class="list-group list-group-flush mt-3 mb-2">
                    <device-row v-show="localObit.trust_anchor_token.length" :bold_title="true" :title="'Trust Anchor Token'" :value="localObit.trust_anchor_token"></device-row>
                    <device-row :bold_title="true" :title="'Local Checksum'" :value="localObit.checksum"></device-row>
                    <device-row :bold_title="true" :title="'Blockchain Checksum'" :value="blockchainObit.checksum"></device-row>
                </ul>

                <hr>

                <h4>Documents</h4>
                <ul v-if="localObit != null" class="list-group list-group-flush mt-3 mb-2">
                    <li class="list-group-item" v-if="localObit.documents.length === 0">
                        <p class="text-center">There are no documents attached to this device</p>
                    </li>
                    <device-row v-bind:key="'doc'+key" v-for="(value,key) in localObit.documents" :classes="{lower: true}" :bold_title="false" :title="key" :value="value"></device-row>
                </ul>

                <hr>

                <div v-if="localObit !== null && blockchainObit !== null">
                    <div v-if="blockchainObit.checksum !== null && blockchainObit.checksum.length > 0" class="d-flex justify-content-between">
                        <h4 class="text-success">Exists on Blockchain</h4>
                        <a v-bind:href="'https://gateway.obada.io/obits/'+localObit.obitDID" class="btn btn-outline-primary">View</a>
                    </div>

                    <div v-if="localObit.device != null" class="d-flex justify-content-between">
                        <h4 class="text-success">Exists In Inventory</h4>
                        <a v-bind:href="'/devices/'+localObit.device.id" class="btn btn-outline-primary">View</a>
                    </div>

                    <p v-if="blockchainObit.checksum === null || localObit.checksum != blockchainObit.checksum" class="text-end">
                        <button class="btn btn-primary" @click="syncData">Upload to Blockchain</button>
                    </p>
                </div>

                <p class="text-end mt-2">
                    <button class="btn btn-primary" @click="mapData">Update in Inventory</button>
                </p>
            </div>
        </div>

    </div>
</template>

<script src="./index.js"></script>
