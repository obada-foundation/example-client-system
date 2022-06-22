<h4 class="pt-4">HOW IS USN CALCULATED?</h4>
<table class="table" style="table-layout: fixed; vertical-align: middle;">
    <tbody>
    <tr>
        <td style="width: 50px;"><h3 class="mb-0">1</h3></td>
        <td style="width: 40%;">serial_hash = sha256(serial_number)</td>
        <td>@isset($usn_data) {{ $usn_data->serial_number_hash }} @endisset</td>
    </tr>
    <tr>
        <td><h3 class="mb-0">2</h3></td>
        <td>obit = sha256(manufacturer + part_number + serial_hash)</td>
        <td>@isset($usn_data) {{ $usn_data->did }} @endisset</td>
    </tr>
    <tr>
        <td><h3 class="mb-0">3</h3></td>
        <td>usn_base58 = base58(obit)</td>
        <td>@isset($usn_data) {{ $usn_data->usn_base58 }} @endisset</td>
    </tr>
    <tr>
        <td><h3 class="mb-0">4</h3></td>
        <td>usn = first_eight(usn_base58)</td>
        <td>@isset($usn_data) {{ $usn_data->usn }} @endisset</td>
    </tr>
    </tbody>
</table>
