<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <h2>Owner Information</h2>
        <ul v-if="localObit != null" class="device-information-list py-5">
            <device-row :bold_title="true"  :title="'Owner'" :value="localObit.owner"></device-row>
        </ul>

        <h2>Device Identification</h2>
        <ul v-if="localObit != null" class="device-information-list py-5">
            <device-row :bold_title="true" :title="'Universal Serial Number'" :value="localObit.usn"></device-row>
            <device-row :bold_title="true" :classes="{'lower':true}"  :title="'DID'" :value="localObit.did"></device-row>
            <device-row :bold_title="true" :title="'Serial Number Hash'" :value="localObit.serial_number_hash"></device-row>
            <device-row :bold_title="true" :title="'Manufacturer'" :value="localObit.manufacturer"></device-row>
            <device-row :bold_title="true" :title="'Part Number'" :value="localObit.part_number"></device-row>
        </ul>


        <h2>Device Data & Information</h2>
        <ul v-if="localObit != null" class="device-information-list py-5">
            <device-row v-show="localObit.trust_anchor_token.length" :bold_title="true" :title="'Trust Anchor Token'" :value="localObit.trust_anchor_token"></device-row>
            <device-row :bold_title="true" :title="'Local Checksum'" :value="localObit.checksum"></device-row>
            <div v-show="blockchainObit.checksum">
                <device-row :bold_title="true" :title="'Blockchain Checksum'" :value="blockchainObit.checksum"></device-row>
            </div>
            <device-row :bold_title="true"  :title="'Documents'" :value="''"></device-row>
            <li class="data-row">
               <ul class="sub-list">
                   <li v-if="localObit.documents.length === 0">
                       <p class="text-center">There are no documents attached to this device</p>
                   </li>
                   <device-row v-bind:key="'doc'+key" v-for="(value,key) in localObit.documents" :classes="{lower: true}" :bold_title="false" :title="key" :value="value"></device-row>

               </ul>
            </li>
        </ul>

        <table v-if="localObit != null" class="table table-bordered mt-5">
            <tbody>
            <tr  v-show="blockchainObit.checksum !== null && blockchainObit.checksum.length > 0">
                <td>
                    Exists on Blockchain. <a  v-bind:href="'https://gateway.obada.io/obits/'+localObit.obitDID">Click to View.</a>
                </td>
            </tr>
            <tr>
                <td>
                    <button v-show="blockchainObit.checksum === null || localObit.checksum != blockchainObit.checksum" class="btn btn-primary btn-round" @click="syncData">UPLOAD TO BLOCKCHAIN</button>
                    <button v-show="blockchainObit.checksum !== null && blockchainObit.checksum != ''" class="btn btn-primary btn-round" @click="downloadObit">DOWNLOAD FROM BLOCKCHAIN</button>
                </td>
            </tr>
            <tr  v-if="localObit.device != null">
                <td>
                    Exists In Inventory. <a  v-bind:href="'/devices/'+localObit.device.id">Click to View.</a>
                </td>
            </tr>
            <tr>
                <td>
                    <button class="btn btn-primary btn-round" @click="mapData">UPDATE IN INVENTORY</button>
                </td>
            </tr>

            </tbody>
        </table>

    </div>
</template>

<script src="./js/obitdetail.js"></script>
