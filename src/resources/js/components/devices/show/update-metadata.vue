
<template>
    <div>
        <div class="modal" id="twoFaModal" tabindex="-1" aria-labelledby="twoFaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="exampleModalLabel">2FA Verification</h4>
                        <button ref="CloseTwoFa" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="my-3">
                            <p><strong>A code has been sent to your phone to authorize your identity.</strong></p>
                            <label for="" class="form-label">Enter authorization code</label>
                            <input type="text" class="form-control" value="111111">
                            <div class="form-text">This is just a demo. No code is needed. Just click Confirm Transfer.</div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button :disabled="proccessing" v-on:click="updateMetadata" type="button" class="btn btn-primary btn-lg">
                            <span v-show="proccessing" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Confirm pNFT update
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <network-fees-modal></network-fees-modal>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props:[
        'updateMetadataUrl',
        'deviceUrl'
    ],
    data: function () {
        return {
            proccessing: false
        }
    },
    methods: {
        stopUpdate: function(el) {
            el.proccessing = false
            el.$refs.CloseTwoFa.click();
        },
        updateMetadata: function() {
            this.proccessing = true
            axios(this.updateMetadataUrl, {
                method: 'post',
                responseType: 'json',
            })
            .then((response) => {
                this.stopUpdate(this)
                swal("Success!", "NFT metadata was updated", "success");
                window.location.href = this.deviceUrl
            })
            .catch((e) => {
                this.stopUpdate(this)
                swal("Error!", "Unable to update NFT metadata", "error");
            });
        }
    }
}
</script>
