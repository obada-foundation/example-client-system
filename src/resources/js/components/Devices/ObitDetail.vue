<template>
    <div>
        <ul v-if="obit != null" class="device-information-list">
            <device-row :bold_title="true"  :title="'Universal Serial Number'" :value="obit.usn"></device-row>
            <device-row :bold_title="true"  :title="'ObitDID'" :value="obit.obitDID"></device-row>
            <device-row :bold_title="true" :title="'Manufacturer'" :value="obit.manufacturer"></device-row>
            <device-row :bold_title="true"  :title="'Part Number'" :value="obit.part_number"></device-row>
            <device-row :bold_title="true"  :title="'Serial Number Hash'" :value="obit.serial_number_hash"></device-row>

            <device-row :bold_title="true"  :title="'Metadata'" :value="''"></device-row>
            <li class="data-row">
                <ul class="sub-list">
                    <li v-if="obit.metadata.length === 0">
                        <p class="text-center">There are no additional data related to this device</p>
                    </li>
                    <device-row key="index" v-for="(data,mindex) in obit.metadata" :bold_title="false" :title="getKey(data)" :value="getValue(data)"></device-row>

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
            <device-row key="index" v-for="(data,sindex) in obit.structured_data" :bold_title="false" :title="getKey(data)" :value="getValue(data)"></device-row>

        </ul>

        <div v-if="obit != null" class="text-center mt-5">
            <button v-show="obit.root_hash != obit.obada_hash" class="btn btn-primary btn-round" @click="syncData">SYNC WITH BLOCKCHAIN</button>
            <button v-show="obit.root_hash != obit.obada_hash" class="btn btn-primary btn-round" @click="downloadObit">DOWNLOAD FROM BLOCKCHAIN</button>
            <button class="btn btn-primary btn-round" @click="mapData">UPDTAE IN INVENTORY</button>

            <!--
            <button v-show="device.synced_with_client_obits == 1 && device.synced_with_obada == 0" class="btn btn-primary btn-round" @click="syncData">SYNC</button>
            -->
        </div>

    </div>
</template>

<script src="./js/obitdetail.js"></script>
