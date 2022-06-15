<template>
    <li class="data-row">
        <p class="value">{{structured_data.structured_data_type_id}}</p>
        <codemirror v-model="structured_data.data_array" :options="cmOptions"></codemirror>
        <!--
        <ul v-if="rows.length > 0" class="sub-list">
            <template v-for="data in rows">
                <li v-if="data.type === 'data-row'" class="data-row" >
                    <div class="row">
                        <div class="col-md-4">
                            <p class="value">{{data.key}}</p>
                        </div>
                        <div class="col-md-8">
                            <p class="value">{{data.value }}</p>
                        </div>
                    </div>
                </li>
            </template>
        </ul>
        -->


    </li>
</template>

<script src="./index.js"></script>

<style scoped></style>
