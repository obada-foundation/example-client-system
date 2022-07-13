
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

        <div class="modal" id="networkFeesModal" tabindex="-1" aria-labelledby="networkFeesModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center" id="networkFeesModalLabel">Accept Network Fees</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table" style="vertical-align: middle;">
                            <tbody>
                            <tr>
                                <td><strong>Gas Fee</strong> <br> <small>Validator node fee.</small></td>
                                <td class="text-end" style="width: 150px;">~0.001 OBD</td>
                            </tr>
                            <tr>
                                <td><strong>Storage Charge</strong><br><small>File storage costs.</small></td>
                                <td class="text-end">0.001 OBD</td>
                            </tr>
                            <tr>
                                <td><strong>Application Fee</strong><br><small>Gateway usage fee.</small></td>
                                <td class="text-end">0.001 OBD</td>
                            </tr>
                            <tr id="recyclingIncentiveRow">
                                <td>
                                    <strong>Recycling Incentive (pNFT Stake)</strong> <em>(optional)</em><br>
                                    <small>An optional deposit to "stake" the asset, which is returned along with a newly minted token at final disposition.</small>
                                </td>
                                <td class="text-end">1 OBD</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="pay_recycling" checked>
                                        <label for="pay_recycling" class="form-check-label"><small>I want to pay Recycling Incentive</small></label>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td class="border-0"><strong class="fs-5">Total</strong></td>
                                <td class="border-0 text-end">
                                    <strong id="networkFeesModalTotal" class="fs-5">~1.003 OBD</strong>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#twoFaModal">Continue</button>
                    </div>
                </div>
            </div>
        </div>
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
                swal("Error!", "Unable to mint pNFT", "error");
            });
        }
    }
}
</script>
