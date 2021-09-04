<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notification</title>
</head>
<body>
<p>
    HWB number:
    @php
        echo str_pad($orders->invoice_number, 6, "0", STR_PAD_LEFT);
    @endphp
</p>
<p>Shipper city:{{$orders->shipper_city->city}}</p>
<p>Consignee city:{{$orders->consignee_city->city}}</p>
<p>Pick up date and time:
    @php

        if($orders->status_id < 6) {
            echo  $orders->tracker->where('position',0)->first()->end_time ?? $tracker->end_time;
        }
        else{
            echo $orders->tracker->where('position',2)->first()->end_time ?? $tracker->end_time;
        }
    @endphp
</p>
@if($orders->status_id == 6)
    <p>Signed: {{$tracker->signed}}</p>

@endif
<p><a href="{{route('admin.index')}}/admin/orders/{{$orders->id}}">Link</a></p>
</body>
</html>
