<table>
    <thead>
    <tr>
        <th>HWB Number</th>
        <th>Client HWB</th>
        <th>Job Number</th>
        <th>Service code</th>
        <th>Customer name</th>
        <th>Customer account</th>
        <th>Shipper's company name</th>
        <th>Shipper address</th>
        <th>Shipper APC(city)</th>
        <th>Country</th>
        <th>Site Number(shipper)</th>
        <th>Consignee's company name</th>
        <th>Consignee address</th>
        <th>Consignee APC(city)</th>
        <th>Country</th>
        <th>Site number(consignee)</th>
        <th>Shipment description</th>
        <th>Pick up instructions</th>
        <th>Package type</th>
        <th>Actual weight</th>
        <th>Quantity</th>
        <th>Serial number box</th>
        <th>Serial number tt</th>
        <th>Temperature conditions</th>
        <th>Dimensions</th>
        <th>Delivery instructions</th>
        <th>Pick up date and time</th>
        <th>Delivery date and time</th>
        <th>Driver</th>
        <th>Agent</th>
        <th>Price</th>

    </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            @foreach($order->cargo as  $item)
                <tr>
                    <td>@php echo str_pad($order->invoice_number, 6, "0", STR_PAD_LEFT);  @endphp</td>
                    <td>{{$order->client_hwb}}</td>
                    <td>{{$order->id}}</td>
                    <td></td>
                    <td>{{$order->payer->customer_name ?? ''}}</td>
                    <td>{{$order->payer->customer_account_number ?? ''}}</td>
                    <td>{{$order->company_shipper}}</td>
                    <td>{{$order->tracker->where('position',0)->first()->address}}</td>
                    <td>{{$order->tracker->where('position',0)->first()->cargolocation->city}}</td>
                    <td>UKR</td>
                    <td>{{$order->site_shipper}}</td>
                    <td>{{$order->company_consignee}}</td>
                    <td>{{$order->tracker->where('position',2)->first()->address}}</td>
                    <td>{{$order->tracker->where('position',2)->first()->cargolocation->city}}</td>
                    <td>UKR</td>
                    <td>{{$order->site_consignee}}</td>
                    <td>{{$order->shipment_description}}</td>
                    <td>{{$order->comment}}</td>
                    <td>{{$item->type}}</td>
                    <td>{{$item->actual_weight}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->serial_number}}</td>
                    <td>{{$item->serial_number_sensor}}</td>
                    <td>{{$item->temperature_conditions}}</td>
                    <td>{{$item->сargo_dimensions_length}}x{{$item->сargo_dimensions_width}}
                        x{{$item->сargo_dimensions_height}}</td>
                    <td>{{$order->delivery_comment}}</td>
                    <td>{{$order->tracker->where('position',0)->first()->end_time}}</td>
                    <td>{{$order->tracker->where('position',2)->first()->end_time}}</td>
                    <td>

                        @if (isset($driver))
                            @if (!empty($driver))
                                {{$driver->fullname ?? 'Driver dont have fullname'}}
                            @endif
                        @else
                            @php
                                $drivers = array_unique(array_filter($order->tracker->pluck('user')->pluck('fullname')->toArray()));
                                if(count($drivers) > 1){
                                    //var_dump($order->tracker->pluck('user')->pluck('fullname')->toArray());
                                    echo implode(", ", $drivers);
                                }
                                elseif(count($drivers) == 1){
                                    echo array_values($drivers)[0];
                                }
                                else{
                                    echo 'Empty';
                                }
                            @endphp
                        @endif
                    </td>
                    <td>
                        @if (isset($agent))
                            @if (!empty($agent))
                                {{$agent->fullname ?? 'Agent dont have fullname'}}
                            @endif
                        @else
                            @php
                                $agents = array_unique(array_filter($order->tracker->pluck('agent')->pluck('fullname')->toArray()));
                                if(count($agents) > 1){
                                    //var_dump(array_values($order->tracker->pluck('agent')->pluck('fullname')->toArray()));
                                    echo implode(", ", $agents);
                                }
                                elseif(count($agents) == 1){

                                    echo array_values($agents)[0];
                                }
                                else{
                                    echo 'Empty';
                                }
                            @endphp
                        @endif
                        {{--                    {{$order->tracker->first()->agent->fullname ?? ''}}--}}
                    </td>
                    <td>...$</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
