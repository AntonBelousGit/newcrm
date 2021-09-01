<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    .wrap-table {
        width: 1000px;
    }

    .table_first {
        width: 100%;
        border-collapse: collapse;
    }

    .table_first thead th {

        border: 2px solid #12469a;
        /* Граница вокруг ячеек */
        background: #12469a;
        color: #fff;
        text-transform: uppercase;
    }

    .table_first tr {
    }

    .table_first tbody td {
        padding: 0;
        border-collapse: collapse;
        border: 2px solid #12469a;
        /* Граница вокруг ячеек */
    }

    .content_td {
        padding: 5px;
        /* Поля вокруг содержимого ячеек */
        display: flex;
        justify-content: space-between;
        min-height: 48px;
    }

    .content_td div {
        /* width: 33%; */
    }

    .content_td p {
        text-transform: uppercase;
        padding: 0;
        margin: 0;
    }

    .subtable {
        padding: 0;
        border-spacing: 0;
        min-height: 60px;
        width: 100%;
    }

    .subtable tbody td,
    .subtable tbody th {
        border-collapse: collapse;
        border: 1px solid #000;
        /* Граница вокруг ячеек */
    }

    .sqr {
        display: inline-block;
        width: 10px;
        height: 10px;
        border: 1px solid #000;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        width: 1000px;
    }

    .logo {
        font-size: 60px;
        font-weight: bold;
        color: #c00056;
    }

    .logo span {
        color: #1286ad;
    }

    .number span {
        color: #000;
        font-size: 30px;
    }

    .number {
        color: #c00056;
        font-size: 20px;
        font-weight: bold;
    }
</style>

<body>
<div class="header">
    <div class="logo">
        <span>Air</span>express
    </div>
    <div class="number">
        <span>
            @php
                echo str_pad($invoices->invoice_number, 6, "0", STR_PAD_LEFT);
            @endphp
        </span>
    </div>
</div>
<div class="wrap-table">
    <table class="table_first">
        <thead>
        <tr>
            <th>From(Shipper)</th>
            <th>To(consignee)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="content_td">
                    <div>
                        <p>Name</p>
                        <span>{{$invoices->shipper}}</span>
                    </div>
                    <div>
                        <p>Telephone</p>
                        <span>{{$invoices->phone_shipper}}</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="content_td">
                    <div>
                        <p>Name</p>
                        <span>{{$invoices->consignee}}</span>
                    </div>
                    <div>
                        <p>Telephone</p>
                        <span>{{$invoices->phone_consignee}}</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="content_td">
                    <div>
                        <p>Company</p>
                        <span>{{$invoices->company_shipper}}</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="content_td">
                    <div>
                        <p>Company</p>
                        <span>{{$invoices->company_consignee}}</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="content_td">
                    <div>
                        <p>Adress</p>
                        <span>{{$tracker_start->address}}</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="content_td">
                    <div>
                        <p>Adress</p>
                        <span>{{$tracker_end->address}}</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="content_td">
                </div>
            </td>
            <td>
                <div class="content_td">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="content_td">
                    <div>
                        <p>City</p>
                        <span>{{$invoices->shipper_city->city}}</span>
                    </div>
                    <div>
                        <p>State/country</p>
                        <span>Ukraine</span>
                    </div>
                    <div>
                        <p>postcode</p>
                        <span>{{$tracker_start->post_code}}</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="content_td">
                    <div>
                        <p>City</p>
                        <span>{{$invoices->consignee_city->city}}</span>
                    </div>
                    <div>
                        <p>State/country</p>
                        <span>Ukraine</span>
                    </div>
                    <div>
                        <p>postcode</p>
                        <span>{{$tracker_end->post_code}}</span>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="table_first">
        <thead>
        <tr>
            <th colspan="4">Shipment information</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2">
                <div class="content_td">
                    <div>
                        <p>full description of contents</p>
                        <span>{{$invoices->shipment_description}}</span>
                    </div>
                </div>
            </td>
            <td colspan="2">
                <table class="subtable">
                    <tr>
                        <th>
                            №
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Dimensions
                        </th>
                        <th>
                            Serial Number Box
                        </th>
                        <th>
                            Serial Number Sensor
                        </th>
                        <th>
                            Temperature(TT)
                        </th>
                    </tr>
                    @foreach($invoices->cargo as $cargo)
                        <tr>
                            <td>
                                {{$cargo->id}}
                            </td>
                            <td>
                                {{$cargo->type}}
                            </td>
                            <td>
                                {{$cargo->сargo_dimensions_length}}x{{$cargo->сargo_dimensions_width}}
                                x{{$cargo->сargo_dimensions_height}}
                            </td>
                            <td>
                                {{$cargo->serial_number}}
                            </td>
                            <td>{{$cargo->serial_number_sensor}}</td>
                            <td>{{$cargo->temperature_conditions}}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="content_td">
                    <div>
                        <p>#Of PCS quantity</p>
                        <p>{{$invoices->cargo->sum('quantity')}}</p>
                    </div>
                </div>
            </td>
            <td colspan="1">
                <div class="content_td">
                    <div>
                        <p>weight
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
                             kgs</p>
                        <p>Chargeable weight
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
                            kgs
                        </p>
                    </div>
                </div>
            </td>
            <td colspan="2">
                <div class="content_td">
                    <p>Does this shipment contain dangerous goods?</p><br>
                    <p><span class="sqr"></span> no &nbsp; <span class="sqr"></span> yes </p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="content_td">
                    AirExpress liability is limited
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="content_td">
                    SHIPPER'S SECURITY ENDORSEMENT: I certify that this cargo does not contain any unanthorized
                    explosilver,
                    incendiaries, or hazardous matelrials. I consent of this cargo, I am aware that this endorsement and
                    original signature, along with other shipping documents, will be retained on file for at least
                    thirty
                    days.
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="content_td">
                    SIGNATURE OF SHIPPER OR SHIPPER'S AGENT:
                </div>
            </td>
            <td colspan="1">
                <div class="content_td">
                    DATE:
                </div>
            </td>
            <td colspan="1">
                <div class="content_td">
                    PRINT NAME OF CONSIGNEE OR CONSIGNEE'S AGENT
                </div>
            </td>
            <td colspan="1">
                <div class="content_td">
                    DATE
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="1">
                <div class="content_td">
                    SIGNATURE OF SHIPPER OR SHIPPER'S AGENT:
                </div>
            </td>
            <td colspan="1">
                <div class="content_td">
                    DATE
                </div>
            </td>
            <td colspan="1">
                <div class="content_td">
                    PRINT NAME OF CONSIGNEE OR CONSIGNEE'S AGENT
                </div>
            </td>
            <td colspan="1">
                <div class="content_td">
                    DATE
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>

</html>
