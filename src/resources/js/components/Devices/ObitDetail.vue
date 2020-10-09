<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <h2>Owner Information</h2>
        <ul v-if="obit != null" class="device-information-list py-5">
            <device-row :bold_title="true"  :title="'Owner'" :value="obit.owner"></device-row>
        </ul>

        <h2>Device Identification</h2>
        <ul v-if="obit != null" class="device-information-list py-5">
            <device-row :bold_title="true"  :title="'Universal Serial Number'" :value="obit.usn"></device-row>
            <device-row :bold_title="true"  :title="'ObitDID'" :value="obit.obitDID"></device-row>
            <device-row :bold_title="true" :title="'Manufacturer'" :value="obit.manufacturer"></device-row>
            <device-row :bold_title="true"  :title="'Part Number'" :value="obit.part_number"></device-row>
            <device-row :bold_title="true"  :title="'Serial Number Hash'" :value="obit.serial_number_hash"></device-row>
        </ul>


        <h2>Device Data & Information</h2>
        <ul v-if="obit != null" class="device-information-list py-5">
            <device-row :bold_title="true"  :title="'Metadata'" :value="''"></device-row>
            <li class="data-row">
                <ul class="sub-list">
                    <li v-if="obit.metadata.length === 0">
                        <p class="text-center">There are no additional data related to this device</p>
                    </li>
                    <device-row v-bind:key="mindex" v-for="(data,mindex) in obit.metadata" :bold_title="false" :title="getKey(data)" :value="getValue(data)"></device-row>

                </ul>
            </li>

            <device-row :bold_title="true"  :title="'Documents'" :value="''"></device-row>
            <li class="data-row">
               <ul class="sub-list">
                   <li v-if="obit.documents.length === 0">
                       <p class="text-center">There are no documents attached to this device</p>
                   </li>
               </ul>
            </li>

            <device-row :bold_title="true"  :title="'Structured Data'" :value="''"></device-row>

            <li v-if="obit.structured_data.length === 0" class="data-row">
                <ul class="sub-list">
                    <li >
                        <p class="text-center">There are no Structured Data attached to this device</p>
                    </li>

                </ul>
            </li>
            <device-row v-bind:key="sindex" v-for="(data,sindex) in obit.structured_data" :bold_title="false" :title="getKey(data)" :value="getValue(data)"></device-row>

        </ul>

        <table v-if="obit != null" class="table table-bordered mt-5">
            <tbody>
            <tr  v-show="obit.obada_hash !== ''">
                <td>
                    Exists on Blockchain. <a  v-bind:href="'https://gateway.obada.io/obits/'+obit.obitDID">Click to View.</a>
                </td>
            </tr>
            <tr  v-show="obit.root_hash != obit.obada_hash">
                <td>
                    <button class="btn btn-primary btn-round" @click="syncData">UPLOAD TO BLOCKCHAIN</button>
                    <button v-show="obit.obada_hash != ''" class="btn btn-primary btn-round" @click="downloadObit">DOWNLOAD FROM BLOCKCHAIN</button>
                </td>
            </tr>
            <tr  v-show="obit.device != null">
                <td>
                    Exists In Inventory. <a  v-bind:href="'/devices/'+obit.device.id">Click to View.</a>
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
