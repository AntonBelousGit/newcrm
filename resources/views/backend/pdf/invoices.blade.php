<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead tr th,
    table tbody tr th {
        background: #12469a;
        color: #fff;
        text-transform: uppercase;
        padding: 0;
        border: 2px solid #12469a;
        vertical-align: baseline;
    }

    table thead tr th div,
    table tbody tr th div {
        padding: 5px;
    }

    table thead tr td,
    table tbody tr td {
        padding: 0;
        border: 2px solid #12469a;
        vertical-align: baseline;
    }

    table thead tr td div,
    table tbody tr td div {
        padding: 5px;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10px;
        padding: 7mm 14mm 0 7mm;
    }

    p {
        margin: 2px 0;
    }

    html,
    body {
        height: 297mm;
        width: 197mm;
        margin: 0px;
    }

    .sqr {
        display: inline-block;
        border: 1px solid black;
        width: 12px;
        height: 12px;
        background-color: white;
        position: relative;
    }

    .row {
        padding: 5px 0 0 0;
    }

    .row div {
        padding: 5px;
        display: inline-block;
    }
    .whiteTT {
        border-top: 2px solid #12469a ;
        margin-top: -2px;
    }
    .white {
        color: white;
        border-top: 2px solid transparent;
    }

    .whiteL {
        border: 2px solid transparent;
        border-bottom: 2px solid #12469a;
    }

    .whiteB {
        border-bottom: 2px solid transparent;
    }

    img {
        margin-top: 20px;
        width: 300px;
    }

    .logo {
        float: left;
        height: 100px;
    }

    .code {
        height: 100px;
        float: right;
        font-size: 30px;
    }

    .clearfix {
        clear: both;
    }

    .whiteRR {
        border-right: 2px solid #12469a;
    }

    .whiteR {
        border-right: 2px solid transparent;
    }

    .whiteT {
        border-top: none;
    }

    .code {
    }

    .ebala {
        padding: 0 10px;
        margin: 0;
        font-size: 6px;
    }

    .ebala p {
        margin: 0;
    }
    td .last:last-child {
        border-bottom: 2px solid #12469a;
    }
</style>

<body>

<div>
    <div>
        <div class='logo'>
            <img src="data:image/png;base64,{{ $image }}" alt=""/>
        </div>
        <div class='code'>
            <div>
                <div>
                    @php
                        $hwb = str_pad($invoices->invoice_number, 6, "0", STR_PAD_LEFT);
                        echo $hwb;
                    @endphp
                </div>
                <div>
                    {!! DNS1D::getBarcodeHTML( $hwb, 'C128') !!}
                </div>
            </div>
        </div>
    </div>
    <div class='white'>
        SHIPPER'S SECURITY ENDORSEMENT: I CERTIFY THAT THIS CARGO DOES NOT CONTAIN ANY UNANTHORIZED
        SHIPPER'S SECURITY ENDORSEMENT: I CERTIFY THAT THIS CARGO DOES NOT CONTAIN ANY UNANTHORIZED
    </div>
    <div class='clearfix'>
        <table>
            <thead>
            <tr>
                <th colspan=''>
                    <div>FROM(SHIPPER)</div>
                </th>
                <th colspan=''>
                    <div>TO(CONSIGNEE)</div>
                </th>
            </tr>
            <tr>
                <td colspan=''>
                    <div class='row'>
                        <div>
                            <p>NAME</p>
                            <p>{{$invoices->shipper}}</p>
                        </div>
                        <div>
                            <p>TELEPHONE</p>
                            <p>{{$invoices->phone_shipper}}</p>
                        </div>
                    </div>
                </td>
                <td colspan=''>
                    <div class='row'>
                        <div>
                            <p>NAME</p>
                            <p>{{$invoices->consignee}}</p>
                        </div>
                        <div>
                            <p>TELEPHONE</p>
                            <p>{{$invoices->phone_consignee}}</p>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=''>
                    <div>
                        <p>COMPANY</p>
                        <p>{{$invoices->company_shipper}}</p>
                    </div>
                </td>
                <td colspan=''>
                    <div>
                        <p>COMPANY</p>
                        <p>{{$invoices->company_consignee}}</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=''>
                    <div>
                        <p>ADDRESS</p>
                        <p>{{$tracker_start->address}}</p>
                    </div>
                </td>
                <td colspan=''>
                    <div>
                        <p>ADDRESS</p>
                        <p>{{$tracker_end->address}}</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=''>
                    <div class='row'>
                        <div>
                            <p>APC</p>
                            <p>{{$invoices->shipper_city->city}}</p>
                        </div>
                        <div>
                            <p>STATE/COUNTRY</p>
                            <p>Ukraine</p>
                        </div>
                        <div>
                            <p>POSTCODE</p>
                            <p>{{$tracker_start->post_code}}</p>
                        </div>
                    </div>
                </td>
                <td colspan=''>
                    <div class='row'>
                        <div>
                            <p>APC</p>
                            <p>{{$invoices->consignee_city->city}}</p>
                        </div>
                        <div>
                            <p>STATE/COUNTRY</p>
                            <p>Ukraine</p>
                        </div>
                        <div>
                            <p>POSTCODE</p>
                            <p>{{$tracker_end->post_code}}</p>
                        </div>
                    </div>
                </td>
            </tr>
            </thead>
        </table>
        <table>
            <tbody>
            <tr>
                <th colspan='24'>
                    <div>SHIPMENT INFORMATION</div>
                </th>
            </tr>
            <tr>

                <td colspan='12' rowspan='{{1+ count($invoices->cargo)}}' class='whiteR whiteT'>
                    <div>
                        <p>FULL DESCRIPTION OF CONTENTS </p>
                        <p class="white">DESCRIPTIONOFCONTEDESCRIPTIONSNTS</p>
                        <p>{{$invoices->shipment_description}}</p>
                    </div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">13212</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteRR whiteT'>
                    <div class="white">12222</div>
                </td>
                <td class='whiteT'>
                    <div>№</div>
                </td>
                <td class='whiteT'>
                    <div>Type</div>
                </td>
                <td class='whiteT'>
                    <div>Dimensions</div>
                </td>
                <td class='whiteT'>
                    <div>Serial Number Box</div>
                </td>
                <td class='whiteT'>
                    <div>Serial Number Sensor</div>
                </td>
                <td class='whiteT'>
                    <div>Tempe- rature (TT)</div>
                </td>
            </tr>
            @foreach($invoices->cargo as $cargo)
                <tr>
                  <td class='whiteL whiteB whiteT'>
                    <div class="white">13212</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteT'>
                    <div class="white">1</div>
                </td>
                <td class='whiteL whiteB whiteRR whiteT'>
                    <div class="white">12222</div>
                </td>
                    <td>
                        <div>{{$loop->iteration}}</div>
                    </td>
                    <td>
                        <div>{{$cargo->type}}</div>
                    </td>
                    <td>
                        <div>{{$cargo->сargo_dimensions_length}} x {{$cargo->сargo_dimensions_width}}
                            x {{$cargo->сargo_dimensions_height}}</div>
                    </td>
                    <td>
                        <div>{{$cargo->serial_number}}</div>
                    </td>
                    <td>
                        <div>{{$cargo->serial_number_sensor}}</div>
                    </td>
                    <td>
                        <div>{{$cargo->temperature_conditions}}</div>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan='12'>
                    <div>
                        <p>#OF   PCS  </p>
                        <p>{{$invoices->cargo->sum('quantity')}}</p>
                    </div>
                </td>
                <td colspan='6'>
                    <div class="whiteTT">
                        <p>WEIGHT
                            @php
                                $actual_weight = 0;
                            @endphp
                            @foreach($invoices->cargo as $item)
                                @for ($i = 0; $i < $item->quantity; $i++)
                                    @php
                                        $actual_weight += $item->actual_weight;
                                    @endphp
                                @endfor
                            @endforeach
                            @php
                                echo $actual_weight;
                            @endphp
                            KGS</p>
                        <p>CHARGEABLE WEIGHT
                            @php
                                $weight = 0;
                            @endphp
                            @foreach($invoices->cargo as $item)
                                @for ($i = 0; $i < $item->quantity; $i++)
                                    @php
                                        $weight += $item->volume_weight;
                                    @endphp
                                @endfor
                            @endforeach
                            @php
                                echo $weight;
                            @endphp
                            KGS</p>
                    </div>
                </td>
                <td colspan='6'>
                    <div>
                        <p>DOES THIS SHIPMENT CONTAIN DANGEROUS GOODS?</p>
                        <p>
                            <span class='sqr'></span> NO <span class='sqr'></span> YES
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan='24'>
                    <div>
                        AIR EXPRESS LIABILITY IS LIMITED
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan='24'>
                    <div>
                        SHIPPER'S SECURITY ENDORSEMENT: I CERTIFY THAT THIS CARGO DOES NOT CONTAIN ANY
                        UNANTHORIZED
                        EXPLOSILVER,
                        INCENDIARIES, OR HAZARDOUS MATELRIALS. I CONSENT OF THIS CARGO, I AM AWARE THAT THIS
                        ENDORSEMENT AND
                        ORIGINAL SIGNATURE, ALONG WITH OTHER SHIPPING DOCUMENTS, WILL BE RETAINED ON FILE FOR AT
                        LEAST
                        THIRTY
                        DAYS.
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <table>
            <tbody>
            <tr>
                <td class='whiteB'>
                    <div>
                        <p>PRINT NAME OF SHIPPER OR SHIPPER'S AGENT:</p>
                    </div>
                </td>
                <td class='whiteB'>
                    <div>
                        <p>DATE:</p>
                        <p class="white">CONSI</p>
                    </div>
                </td>
                <td class='whiteB'>
                    <div>
                        <p>PRINT NAME OF CONSIGNEE OR CONSIGNEE'S AGENT:</p>
                    </div>
                </td>
                <td class='whiteB'>
                    <div>
                        <p>DATE:</p>
                        <p class="white">CONSI</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td class='white'>
                    <div class='white ebala'>
                        <p>SIGNATURE OF CONSIGNEE OR CONSIGN</p>
                        <p></p>
                    </div>
                </td>
                <td class='white'>
                    <div class='white ebala'>
                        <p>CONрSI::::::::</p>
                    </div>
                </td>
                <td class='white'>
                    <div class='white ebala'>
                        <p>SIGNATURE OF CONSIGNEE OR CONSIGN</p>

                    </div>
                </td>
                <td class='white'>
                    <div class='white ebala'>
                        <p>CONрSI::::::::</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td class='whiteB'>
                    <div>
                        <p>SIGNATURE OF SHIPPER OR SHIPPER'S AGENT:</p>
                    </div>
                </td>
                <td class='whiteB'>
                    <div>
                        <p>TIME:</p>
                    </div>
                </td>
                <td class='whiteB'>
                    <div>
                        <p>SIGNATURE OF CONSIGNEE OR CONSIGNEE'S AGENT:</p>
                    </div>

                </td>
                <td class='whiteB'>
                    <div>
                        <p>TIME:</p>
                        <p class="white">CONSI</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td class='white'>
                    <div class='white ebala'>
                        <p>SIGNATURE OF CONSIGNEE OR CONSIGN</p>
                    </div>
                </td>
                <td class='white'>
                    <div class='white ebala'>
                        <p>CONSI::::::::</p>
                    </div>
                </td>
                <td class='white'>
                    <div class='white ebala'>
                        <p>SIGNATURE OF CONSIGNEE OR CONSIGN</p>
                    </div>
                </td>
                <td class='white'>
                    <div class='white ebala'>
                        <p>CONSI::::::::</p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
