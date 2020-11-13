<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <h3>Root Hash Checker</h3>

                <div class="outer-row">
                    <div class="title-bubble">Local Inventory</div>
                    <p>{{inventoryHash}}</p>
                    <button class="btn btn-sm btn-primary btn-round btn-view" v-if="device !== null" @click="currentView = 'device_view'">View</button>
                </div>
                <div class="action-row text-center">
                    <div class="btn-holder" v-if="localHashMatch">
                        <button data-toggle="tooltip" data-placement="top" title="Root Hashes Synced"  class="btn-fab btn-round btn btn-success"><i class="fa fa-check"></i></button>
                    </div>
                    <div class="btn-holder" v-if="!localHashMatch && obit != null">
                        <button @click="mapData()"  data-toggle="tooltip" data-placement="top" title="Map Obit To Inventory" class="btn-round btn btn-outline-warning"><i class="fa fa-arrow-up"></i> Update Local Inventory</button>
                    </div>
                    <div class="btn-holder" v-if="!localHashMatch && device !== null">
                        <button @click="createObit"  data-toggle="tooltip" data-placement="top" v-bind:title="obit == null?'Create A Local Obit':'Update Local Obit'" class=" btn-round btn btn-outline-warning"><i class="fa fa-arrow-down"></i> {{obit == null?'Create A Local Obit':'Update Local Obit'}}</button>
                    </div>
                </div>
                <div class="outer-row">
                    <div class="title-bubble">Local Obit</div>
                    <p>{{obitHash}}</p>
                    <button class="btn btn-sm btn-primary btn-round btn-view" @click="currentView = 'obit_view'" v-if="hasObitHash">View</button>
                </div>
                <div class="action-row text-center">
                    <div class="btn-holder"  v-if="blockchainHashMatch">
                    <button data-toggle="tooltip" data-placement="top" title="Root Hashes Synced" class="btn-fab btn-round btn btn-success"><i class="fa fa-check"></i></button>
                    </div>
                    <div class="btn-holder" v-if="!blockchainHashMatch && blockChainObit !== null">
                        <button @click="downloadObit()"  data-toggle="tooltip" data-placement="top" title="Download Obit From Blockchain" class="btn-round btn btn-outline-warning"><i class="fa fa-arrow-up"></i> Download From Blockchain</button>
                    </div>
                    <div class="btn-holder" v-if="!blockchainHashMatch && obit !== null" >
                        <button @click="syncData()" data-toggle="tooltip" data-placement="top" title="Upload Obit To Blockchain" class=" btn-round btn btn-outline-warning"><i class="fa fa-arrow-down"></i> Upload To Blockchain</button>
                    </div>
                    <div class="btn-holder" v-if="obit == null && blockChainObit == null" >
                        <button disabled data-toggle="tooltip" data-placement="top" title="Upload Obit To Blockchain" class="btn-fab btn-round btn btn-outline-danger"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="outer-row">
                    <div class="title-bubble">Blockchain</div>
                    <p>{{blockchainHash}}</p>
                    <a v-bind:href="'https://gateway.obada.io/obits/'+blockChainObit.obit_did" class="btn btn-sm btn-primary btn-round btn-view" v-if="hasBlockchainHash">View</a>
                </div>

            </div>
        </div>

        <div v-if="currentView === 'device_view'">

            <h2 class="text-center">Local Inventory View</h2>

            <div v-if="device != null">
                <div v-if="device != null" class="text-center">
                    <a v-bind:href="'/devices/'+device.id+'/edit'" class="btn btn-primary btn-round">EDIT</a>
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
                    <device-row :bold_title="true"  :title="'Status'" :value="device.status"></device-row>
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
                            <device-row v-bind:key="index" v-for="(data,index) in device.documents" :classes="{lower:true}" :bold_title="false" :title="data.doc_type_id" :value="data.doc_path"></device-row>

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
            </div>
            <div v-if="device === null">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>Device does not exist.</p>
                        <button v-if="hasObitHash" class="btn btn-primary">Add Device To Inventory</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="currentView === 'obit_view'">

            <h2 class="text-center">Local Obit View</h2>

            <div v-if="obit !== null">
                <h2>Owner Information</h2>
                <ul v-if="obit != null" class="device-information-list py-5">
                    <device-row :bold_title="true"  :title="'Owner'" :value="obit.owner_did"></device-row>
                </ul>

                <h2>Device Identification</h2>
                <ul v-if="obit != null" class="device-information-list py-5">
                    <device-row :bold_title="true"  :title="'Universal Serial Number'" :value="obit.usn"></device-row>
                    <device-row :bold_title="true" :classes="{'lower':true}"  :title="'ObitDID'" :value="obit.obit_did"></device-row>
                    <device-row :bold_title="true" :title="'Manufacturer'" :value="obit.manufacturer"></device-row>
                    <device-row :bold_title="true"  :title="'Part Number'" :value="obit.part_number"></device-row>
                    <device-row :bold_title="true"  :title="'Serial Number Hash'" :value="obit.serial_number_hash"></device-row>
                    <device-row :bold_title="true"  :title="'Status'" :value="obit.obit_status"></device-row>
                </ul>


                <h2>Device Data & Information</h2>
                <ul v-if="obit != null" class="device-information-list py-5">
                    <device-row :bold_title="true"  :title="'Metadata'" :value="''"></device-row>
                    <li class="data-row">
                        <ul class="sub-list">
                            <li v-if="obit.metadata.length === 0">
                                <p class="text-center">There are no additional data related to this device</p>
                            </li>
                            <device-row v-bind:key="'device'+key" v-for="(value,key) in obit.metadata" :bold_title="false" :title="key" :value="value"></device-row>

                        </ul>
                    </li>

                    <device-row :bold_title="true"  :title="'Documents'" :value="''"></device-row>
                    <li class="data-row">
                        <ul class="sub-list">
                            <li v-if="obit.documents.length === 0">
                                <p class="text-center">There are no documents attached to this device</p>
                            </li>
                            <device-row v-bind:key="'doc'+key" v-for="(value,key) in obit.documents" :classes="{lower: true}" :bold_title="false" :title="key" :value="value"></device-row>

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
                    <structured-data-row v-bind:key="'sd'+key"  v-for="(data,key) in obit.structured_data" :structured_data="{structured_data_type_id: key, data_array: data}"></structured-data-row>
                </ul>
            </div>
        </div>


        <div class="text-center mt-5">

            <!--
            <button v-show="device.synced_with_client_obits == 1 && device.synced_with_obada == 0" class="btn btn-primary btn-round" @click="syncData">SYNC</button>
            -->
        </div>
    </div>
</template>

<script src="./js/deviceobitdetail.js"></script>
