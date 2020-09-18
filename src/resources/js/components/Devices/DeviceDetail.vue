<template>
    <div>
        <ul v-if="device != null" class="device-information-list">
            <device-row :bold_title="true"  :title="'Serial Number'" :value="device.serial_number"></device-row>
            <device-row :bold_title="true" :title="'Manufacturer'" :value="device.manufacturer"></device-row>
            <device-row :bold_title="true"  :title="'Part Number'" :value="device.part_number"></device-row>

            <device-row :bold_title="true"  :title="'Metadata'" :value="''"></device-row>
            <li class="data-row">
                <ul class="sub-list">
                    <li v-if="device.metadata.length === 0">
                        <p class="text-center">There are no additional data related to this device</p>
                    </li>
                    <device-row key="index" v-for="(data,index) in device.metadata" :bold_title="false" :title="data.metadata_type" :value="getMetadataValue(data)"></device-row>

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
            <structured-data-row key="index"  v-for="(data,index) in device.structured_data" :structured_data="getStructuredData(data.data_array)"></structured-data-row>

        </ul>
        <div class="text-center mt-5">
            <a v-bind:href="'/devices/'+device.id+'/edit'" class="btn btn-primary btn-round">EDIT</a>
        </div>
    </div>
</template>

<script src="./js/devicedetail.js"></script>
