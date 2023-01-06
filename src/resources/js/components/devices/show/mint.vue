<template>
    <div>
        <div class="alert alert-warning mb-5" role="alert">
            This pNFT has not been minted yet.
        </div>

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
                        <button :disabled="isMinting" v-on:click="mintpNFT" type="button" class="btn btn-primary btn-lg">
                            <span v-show="isMinting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Confirm pNFT minting
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
        'mintNftUrl',
        'deviceUrl'
    ],
    data: function () {
        return {
            isMinting: false
        }
    },
    methods: {
        stopMinting: function(el) {
            el.isMinting = false
            el.$refs.CloseTwoFa.click();
        },
        mintpNFT: function() {
            this.isMinting = true
            axios(this.mintNftUrl, {
                method: 'post',
                responseType: 'json',
            })
            .then((response) => {
                this.stopMinting(this)
                swal("Success!", "NFT was minted", "success");
                window.location.href = this.deviceUrl
            })
            .catch((e) => {
                this.stopMinting(this)

                if (! e.response) {
                    swal("Unable to mint pNFT", "", "error");
                    return
                }

                swal("Unable to mint pNFT", e.response.data.errorMessage, "error");
            });
        }
    }
}
</script>
