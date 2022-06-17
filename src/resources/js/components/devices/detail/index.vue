<template>
    <div>
        <ul v-if="device != null" class="device-information-list mt-4">

            <device-row :bold_title="true"  :title="'Documents'" :value="''"></device-row>
            <li class="data-row">
               <ul class="sub-list">
                   <li v-if="device.documents.length === 0">
                       <p class="text-center">There are no documents attached to this device</p>
                   </li>
                   <device-row v-bind:key="index" v-for="(data,index) in device.documents" :classes="{lower:true}" :bold_title="false" :title="data.name" :value="data.path"></device-row>
               </ul>
            </li>
        </ul>

        <table v-if="device != null" class="table table-bordered">
            <tbody>
                <tr v-show="device.obit_checksum">
                    <td>
                        Obit Exists. <a v-bind:href="'/obits/'+device.usn">View Obit {{ device.obit }}</a>
                    </td>
                </tr>
                <tr  v-show="device.obit_checksum">
                    <td>
                        <button class="btn btn-primary btn-round" @click="createObit">UPDATE OBIT</button>
                    </td>
                </tr>
                <tr v-show="device.obit_checksum == null">
                    <td class="text-right">
                        Obit Does Not Exist.
                    </td>
                </tr>
                <tr v-show="device.obit_checksum == null">
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

<script src="./index.js"></script>
