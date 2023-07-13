<template>
    <div class="border">
        <div v-if="showMessage" :class="['p-3', messageClass]">{{ message }}</div>

        <pre v-if="!!code" class="p-4 mb-0 fs-6 bg-dark text-light">{{ code }}</pre>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props:[
        'did',
        'minted'
    ],
    data: function () {
        return {
            message: 'Loading...',
            messageClass: '',
            showMessage: true,
            code: ''
        }
    },
    mounted: function() {
        this.isMinted = parseInt(this.minted) === 1;

        if (!this.isMinted) {
            this.message = 'You need to mint your pNFT first.';
            this.messageClass = 'text-danger';
            return;
        }

        if (!this.did) {
            this.message = 'Incorrect DID.';
            this.messageClass = 'text-danger';
            return;
        }

        axios('https://node.alpha.obada.io/obada-foundation/fullcore/nft/' + encodeURIComponent(encodeURIComponent(this.did)), {
            method: 'get',
            responseType: 'json'
        })
        .then(response => {
            this.showMessage = false;
            this.code = response.data;
        })
        .catch(e => {
            this.message = 'Error trying to retrieve information.';
            this.messageClass = 'text-danger';
        });
    },
}
</script>
