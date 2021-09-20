<table>
    <thead>
    <tr>
        <th>Delivery Date</th>
        <th>HWB Number</th>
        <th>Job Number</th>
        <th>Service Code</th>
        <th>Customer Name</th>
        <th>Customer Account</th>
        <th>Shipper</th>
        <th>City</th>
        <th>Country</th>
        <th>Consignee</th>
        <th>City</th>
        <th>Country</th>
        <th>Pieces</th>
        <th>Weight, kg</th>
        <th>Volume Weight, kg</th>
        <th>Dimensions, cm</th>
        <th>Temperature conditions, C</th>
        @can('SuperUser','OPS','Manager','Agent')
        <th>Driver 1</th>
        <th>Driver 2</th>
        <th>Agent 1</th>
        <th>Agent 2</th>
        @endcan
        <th>Price</th>
    </tr>
    </thead>
{{--    @dd($orders)--}}
{{--    @dd($orders->first()->tracker->where('position',2)->first())--}}
    <tbody>
{{--    @dd($orders);--}}
@canany('SuperUser','OPS','Manager','Agent')
    @foreach($orders as $order)
        @foreach($order->cargo as $item)
            <tr>
                <td>{{$order->tracker->where('position',2)->first()->end_time}}</td>
                <td>@php echo str_pad($order->invoice_number, 6, "0", STR_PAD_LEFT);  @endphp</td>
                <td>{{$order->id}}</td>
                <td></td>
                <td>{{$order->payer->customer_name}}</td>
                <td>{{$order->payer->customer_account_number}}</td>
                <td>{{$order->shipper}}</td>
                <td>{{$order->tracker->where('position',0)->first()->cargolocation->city}}</td>
                <td>UKR</td>
                <td>{{$order->consignee}}</td>
                <td>{{$order->tracker->where('position',2)->first()->cargolocation->city}}</td>
                <td>UKR</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->actual_weight}}</td>
                <td>{{$item->volume_weight}}</td>
                <td>{{$item->сargo_dimensions_length}}x{{$item->сargo_dimensions_width}}x{{$item->сargo_dimensions_height}}</td>
                <td>{{$item->temperature_conditions}}</td>
                <td>{{$order->tracker->first()->user->fullname ?? ''}}</td>
                <td></td>
                <td>{{$order->agent->fullname ?? ''}}</td>
                <td></td>
                <td>...$</td>
            </tr>
        @endforeach
    @endforeach
@elsecanany('Client')
    @foreach($orders as $order)
        @can('manage-client-exel',$order)
            @foreach($order->cargo as $item)
                <tr>
                    <td>{{$order->tracker->where('position',2)->first()->end_time}}</td>
                    <td>@php echo str_pad($order->invoice_number, 6, "0", STR_PAD_LEFT);  @endphp</td>
                    <td>{{$order->id}}</td>
                    <td></td>
                    <td>{{$order->payer->customer_name}}</td>
                    <td>{{$order->payer->customer_account_number}}</td>
                    <td>{{$order->shipper}}</td>
                    <td>{{$order->tracker->where('position',0)->first()->cargolocation->city}}</td>
                    <td>UKR</td>
                    <td>{{$order->consignee}}</td>
                    <td>{{$order->tracker->where('position',2)->first()->cargolocation->city}}</td>
                    <td>UKR</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->actual_weight}}</td>
                    <td>{{$item->volume_weight}}</td>
                    <td>{{$item->сargo_dimensions_height}}x{{$item->сargo_dimensions_length}}x{{$item->сargo_dimensions_width}}</td>
                    <td>{{$item->temperature_conditions}}</td>
                    <td>...$</td>
                </tr>
            @endforeach
        @endcan
    @endforeach
@endcanany
    </tbody>
</table>
