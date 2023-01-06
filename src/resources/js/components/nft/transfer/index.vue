<template>
     <div>
        <h2>Step 1: Specify Asset Recipient</h2>
        <div class="card">
            <div class="card-body">
                <div class="mt-3 mb-3">
                    <label for="" class="form-label">Transfer to</label>
                    <input
                        type="text"
                        placeholder="OBADA Address"
                        v-model="recepientAddress"
                        class="form-control"
                    >
                    <div v-show="!isValid" class="form-helper text-danger">Please enter valid bech32 formatted OBADA address. Example: obada1dve4yjtvsudrdn98cxz4gtchrfnfz97jv6zgnx.</div>
                    <div class="form-text">The receiver must provide you OBADA address.</div>
                </div>
            </div>
        </div>

        <h2 class="mt-5">Step 2: Accept Legal Agreement</h2>
        <div class="card">
            <div class="card-body">
                <div class="mt-3 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" v-model="legalAgreement" id="legal_agreement">
                        <label for="legal_agreement" class="form-check-label">Legal agreement. <br>I attest that I legally own the physical asset represented by this pNFT. I understand that transferring this pNFT also represents a transfer in legal ownership of the physical asset.</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <button
                :disabled="!canPreview"
                class="btn btn-primary btn-lg"
                data-bs-toggle="modal"
                data-bs-target="#networkFeesModal">
                Preview
            </button>
            <p class="mt-3">Authorization code will be send to your phone for verification.</p>
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
                        <button :disabled="proccessingTransfer" v-on:click="sendNFT" type="button" class="btn btn-primary btn-lg">
                            <span v-show="proccessingTransfer" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Confirm Transfer
                        </button>
                    </div>
                </div>
            </div>
        </div>

         <network-fees-modal></network-fees-modal>

     </div>
</template>

<script>
import { fromBech32 } from '@cosmjs/encoding'
import axios from 'axios';

export default {
    props:['sendNftUrl', 'devicesOverviewUrl', 'usn'],
    data: function () {
        return {
            recepientAddress: "",
            legalAgreement: false,
            proccessingTransfer: false
        }
    },
    methods: {
        sendNFT: function() {
            this.proccessingTransfer = true

            axios(this.sendNftUrl, {
                    method: 'post',
                    data: {
                        recipient: this.recepientAddress
                    }
                }
            )
            .then((response) => {
                this.proccessingTransfer = false;
                this.$refs.CloseTwoFa.click();
                swal("Transfer completed!", `You are not owner of ${this.usn} anymore`, "success");
                window.location.href = this.devicesOverviewUrl
            })
            .catch((e) => {
                this.proccessingTransfer = false;
                this.$refs.CloseTwoFa.click();

                if (! e.response) {
                    swal("Unable to transfer pNFT", "", "error");
                    return
                }

                swal("Unable to transfer pNFT", "", "error");
            });
        }
    },
    computed: {
        canPreview() {
            return this.legalAgreement && this.isValid && this.recepientAddress.length > 0
        },
        isValid() {
            // When recepient address is empty, no need for bep32 validation
            if (this.recepientAddress.length === 0) {
                return true
            }

            // Confirm that address has obada prefix
            if (! this.recepientAddress.startsWith('obada1')) {
                return false
            }

            try {
                return !!fromBech32(this.recepientAddress)
            } catch {
                return false
            }
        }
    }
}
</script>
