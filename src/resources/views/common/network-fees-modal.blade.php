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
                        <td class="text-end" style="width: 150px;">0.001 OBD</td>
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
                            <strong id="networkFeesModalTotal" class="fs-5">1.003 OBD</strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="modal-footer justify-content-center">
                <button id="networkFeesModalSubmit" type="button" class="btn btn-primary btn-lg">Continue</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('pay_recycling').addEventListener('click', event => {
        // document.getElementById('recyclingIncentiveRow').style.display = event.target.checked ? 'table-row' : 'none';
        document.getElementById('networkFeesModalTotal').innerText = event.target.checked ? '1.003 OBD' : '0.003 OBD';
    });
</script>
