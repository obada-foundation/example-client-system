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
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-center" colspan="2">Hashes</th>
            </tr>
            <tr>
                <th>Serial #</th>
                <th>Part #</th>
                <th>Manufacturer</th>
                <th>Owner</th>
                <th>Obit</th>
                <th>Blockchain</th>
            </tr>
            </thead>
        </table>
    </div>
</template>

<script src="./js/devicelist.js"></script>
