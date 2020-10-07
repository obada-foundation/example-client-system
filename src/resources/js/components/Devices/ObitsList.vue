<template>
    <div>
        <div v-if="isLoading" class="loader">
            <div class="loading-card text-center">
                <i class="fa fa-circle-notch fa-spin"></i>
            </div>
        </div>
        <table class="table table-striped" id="obitsList">
            <thead>
            <tr>
                <th>USN</th>
                <th>Part Number</th>
                <th>Manufacturer</th>
                <th>Owner</th>
                <th>Is Mapped</th>
            </tr>
            </thead>
        </table>
    </div>
</template>

<script src="./js/obitslist.js"></script>
