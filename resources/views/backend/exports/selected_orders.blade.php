<table>
    <thead>
    <tr>
        <th>№</th>
        <th>HWB Number</th>
        <th>Shipper Address</th>
        <th>Shipper City</th>
        <th>Consignee Address</th>
        <th>Consignee City</th>
        <th>Quantity</th>
        <th>Weight, kg</th>
        <th>Temperature conditions, C</th>
    </tr>
    </thead>

    <tbody>
    @foreach($orders as $order)
        @foreach($order->cargo as $item)
            <tr>
                <td>{{ $loop->parent->iteration }}</td>
                <td>@php echo str_pad($order->invoice_number, 6, "0", STR_PAD_LEFT);  @endphp</td>
                <td>{{$order->tracker->where('position',0)->first()->address}}</td>
                <td>{{$order->shipper_city->city}}</td>
                <td>{{$order->tracker->where('position',2)->first()->address}}</td>
                <td>{{$order->consignee_city->city}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->actual_weight}}</td>
                <td>{{$item->temperature_conditions}}</td>
            </tr>
        @endforeach
    @endforeach

    </tbody>
</table>
