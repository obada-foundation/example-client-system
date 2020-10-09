<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <div v-if="device != null" class="text-center">
            <a v-bind:href="'/devices/'+device_id+'/edit'" class="btn btn-primary btn-round">EDIT</a>
        </div>
        <h2>Owner Information</h2>
        <ul v-if="device != null" class="device-information-list py-5">
            <device-row :bold_title="true"  :title="'Owner'" :value="device.owner"></device-row>
        </ul>
        <h2>Device Identification</h2>
        <ul v-if="device != null" class="device-information-list py-5">
            <device-row :bold_title="true"  :title="'Serial Number'" :value="device.serial_number"></device-row>
            <device-row :bold_title="true" :title="'Manufacturer'" :value="device.manufacturer"></device-row>
            <device-row :bold_title="true"  :title="'Part Number'" :value="device.part_number"></device-row>
        </ul>


        <h2>Device Data & Information</h2>
        <ul v-if="device != null" class="device-information-list py-5">
            <device-row :bold_title="true"  :title="'Metadata'" :value="''"></device-row>
            <li class="data-row">
                <ul class="sub-list">
                    <li v-if="device.metadata.length === 0">
                        <p class="text-center">There are no additional data related to this device</p>
                    </li>
                    <device-row v-bind:key="index" v-for="(data,index) in device.metadata" :bold_title="false" :title="data.metadata_type_id" :value="getMetadataValue(data)"></device-row>

                </ul>
            </li>

            <device-row :bold_title="true"  :title="'Documents'" :value="''"></device-row>
            <li class="data-row">
               <ul class="sub-list">
                   <li v-if="device.documents.length === 0">
                       <p class="text-center">There are no documents attached to this device</p>
                   </li>
               </ul>
            </li>

            <device-row :bold_title="true"  :title="'Structured Data'" :value="''"></device-row>

            <li v-if="device.structured_data.length === 0" class="data-row">
                <ul class="sub-list">
                    <li >
                        <p class="text-center">There are no Structured Data attached to this device</p>
                    </li>

                </ul>
            </li>
            <structured-data-row v-bind:key="index"  v-for="(data,index) in device.structured_data" :structured_data="getStructuredData(data)"></structured-data-row>

        </ul>
        <table v-if="device != null" class="table table-bordered">
            <tbody>
                <tr  v-show="device.obit !== null">
                    <td>
                        Obit Exists. <a v-bind:href="'/obits/'+device.usn">View Obit</a>
                    </td>
                </tr>
                <tr  v-show="device.obit !== null">
                    <td>
                        <button class="btn btn-primary btn-round" @click="createObit">UPDATE OBIT</button>
                    </td>
                </tr>
                <tr v-show="device.obit === null">
                    <td class="text-right">
                        Obit Does Not Exist.
                    </td>
                </tr>
                <tr v-show="device.obit === null">
                    <td class="text-right">
                        <button class="btn btn-primary btn-round" @click="createObit">CREATE OBIT</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center mt-5">

            <!--
            <button v-show="device.synced_with_client_obits == 1 && device.synced_with_obada == 0" class="btn btn-primary btn-round" @click="syncData">SYNC</button>
            -->
        </div>
    </div>
</template>

<script src="./js/devicedetail.js"></script>
