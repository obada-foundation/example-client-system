<h4 class="pt-4">HOW IS USN CALCULATED?</h4>
<table class="table" style="table-layout: fixed; vertical-align: middle;">
    <tbody>
    <tr>
        <td style="width: 50px;"><h3 class="mb-0">1</h3></td>
        <td><strong>SHA-256 hash of serial number</strong><br>@isset($usn_data) {{ $usn_data->serial_number_hash }} @endisset</td>
    </tr>
    <tr>
        <td><h3 class="mb-0">2</h3></td>
        <td><strong>obit DID = SHA-256(manufacturer + part number + hash from above)</strong><br>@isset($usn_data) {{ $usn_data->did }} @endisset</td>
    </tr>
    <tr>
        <td><h3 class="mb-0">3</h3></td>
        <td><strong>base58 of obit DID</strong><br>@isset($usn_data) {{ $usn_data->usn_base58 }} @endisset</td>
    </tr>
    <tr>
        <td><h3 class="mb-0">4</h3></td>
        <td><strong>USN = first eight characters of base58 above</strong><br>@isset($usn_data) <strong class="text-success">{{ $usn_data->usn }}</strong> @endisset</td>
    </tr>
    </tbody>
</table>
