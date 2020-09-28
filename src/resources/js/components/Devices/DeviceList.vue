<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <table class="table table-striped" id="deviceList">
            <thead>
            <tr>
                <th>Serial Number</th>
                <th>Part Number</th>
                <th>Manufacturer</th>
                <th>Owner</th>
                <th>Obit Created</th>
                <th>Data Synced</th>
            </tr>
            </thead>
        </table>
    </div>
</template>

<script src="./js/devicelist.js"></script>
