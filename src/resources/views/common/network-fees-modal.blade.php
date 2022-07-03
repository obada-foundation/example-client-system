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
                        <td><strong>Gas Fee</strong> <br> <small>Pays the validator nodes.</small></td>
                        <td class="text-end" style="width: 150px;">0.001 OBD</td>
                    </tr>
                    <tr class="text-black-40">
                        <td><strong>Storage Charge</strong> <em>(coming soon)</em><br><small>Pays for IPFS document storage.</small></td>
                        <td class="text-end">0.001 OBD</td>
                    </tr>
                    <tr class="text-black-40">
                        <td><strong>Gateway Fee</strong> <em>(coming soon)</em><br><small>[Tradeloop] service charge.</small></td>
                        <td class="text-end">0.001 OBD</td>
                    </tr>
                    <tr id="recyclingIncentiveRow" class="text-black-40">
                        <td>
                            <strong>Stake Asset for Chain of Custody</strong> <em>(optional) (coming soon)</em><br>
                            <small class="d-inline-block lh-sm">Staking the asset enables chain-of-custody tracking. The asset stake acts as a deposit. It's returned upon final disposition (Proof of Recycling or Proof of Reuse) along with a final disposition report. And a new OBD token is minted and distributed in equal amounts to you, the actors in the custody chain, and the recycler. The asset staking system not only acts a recycling incentive, but it's also a network incentive for the use and locking of the OBD token.</small>
                        </td>
                        <td class="text-end">1 OBD</td>
                    </tr>
<!--                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="pay_recycling" checked disabled>
                                <label for="pay_recycling" class="form-check-label"><small>Stake Asset for Chain of Custody report.</small></label>
                            </div>
                        </td>
                    </tr>-->
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="border-0"><strong class="fs-5">Total</strong></td>
                        <td class="border-0 text-end">
                            <strong id="networkFeesModalTotal" class="fs-5">0.001 OBD</strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="modal-footer justify-content-center">
                <div class="text-center">
                    <button id="networkFeesModalSubmit" type="button" class="btn btn-primary btn-lg">Update</button>
                    <br>
                    <small>Accept Fees and Update</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<script>
    document.getElementById('pay_recycling').addEventListener('click', event => {
        document.getElementById('recyclingIncentiveRow').style.display = event.target.checked ? 'table-row' : 'none';
        document.getElementById('networkFeesModalTotal').innerText = event.target.checked ? '1.003 OBD' : '0.003 OBD';
    });
</script>-->
