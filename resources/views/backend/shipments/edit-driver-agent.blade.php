@extends('backend.layouts.app')
@section('subheader')
    <!--begin::Subheader-->
    <div class="py-2 subheader py-lg-6 subheader-solid" id="kt_subheader">
        <div class="flex-wrap container-fluid d-flex align-items-center justify-content-between flex-sm-nowrap">
            <!--begin::Info-->
            <div class="flex-wrap mr-1 d-flex align-items-center">
                <!--begin::Page Heading-->
                <div class="flex-wrap mr-5 d-flex align-items-baseline">
                    <!--begin::Page Title-->
                    <h5 class="my-1 mr-5 text-dark font-weight-bold">Create Shipment</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="p-0 my-2 mr-5 breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.orders.index')}}" class="text-muted">Shipments</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">Create Shipment</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
@endsection
@section('sub_title') Create New Shipment @endsection
@section('content')
    <style>
        label {
            font-weight: bold !important;
        }
        .select2-container {
            display: block !important;
        }
    </style>
    <form class="form-horizontal" action="{{route('admin.orders.agent-driver-tracker',$orders->id)}}" id="kt_form_1" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row" id="qwert">
                <div class="col-md-3">
                    <p>
                        <b>Number Order:</b>
                        {{$orders->id}}
                    </p>
                </div>
                <div class="col-md-3">
                    <p>
                        <b>HWB Number:</b>
                        @php
                            echo str_pad($orders->invoice_number, 6, "0", STR_PAD_LEFT);
                        @endphp
                    </p>
                </div>
                <div class="col-md-3">
                    <p>
                        <label>Client HWB:</label>
                        <input class='form-control' type="text" name="client_hwb" @if(in_array($orders->status_id,[6,7,9,10])) readonly
                               @endif value="{{$orders->client_hwb}}">
                    </p>
                </div>
                <div class="col-md-3">
                    <p>
                        <b>Created ad:</b>
                        {{$orders->created_at->format('d-m-Y H:s:i')}}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ ('Shipper Name')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Name')}}" disabled class="form-control"  value="{{$orders->shipper}}" />
                                <input type="hidden" id="order" value="{{$orders->id}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ ('Shipper Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Phone')}}" disabled class="form-control" value="{{$orders->phone_shipper}}"/>

                            </div>
                        </div>
                        @if($orders->status_id == 2 || $orders->status_id == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Shipper Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Shipper Address')}}" disabled class="form-control" value="{{$tracker_start->address}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Shipper City')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" disabled name="shipper_address_id" required>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}" @if($tracker_start->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Company Shipper')}}:</label>
                                <input type="text" placeholder="{{ ('Company Shipper')}}" disabled class="form-control" value="{{$orders->company_shipper}}" />
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ ('Consignee Name')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Name')}}" disabled class="form-control" value="{{$orders->consignee}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ ('Consignee Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Phone')}}" disabled class="form-control" value="{{$orders->phone_consignee}}" />

                            </div>
                        </div>
                        @if($orders->status_id == 2 || $orders->status_id == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Consignee Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Consignee Address')}}" disabled class="form-control" value="{{$tracker_end->address}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Shipper City')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" id="consignee_address" disabled required>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}" @if($tracker_end->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Company Consignee')}}:</label>
                                <input type="text" placeholder="{{ ('Company Consignee')}}" disabled class="form-control" value="{{ $orders->company_consignee }}" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Shipment description')}}:</label>
                                <textarea class="form-control" disabled >{{ $orders->shipment_description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Comment')}}:</label>
                                <textarea class="form-control" disabled>{{ $orders->comment }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group fv-plugins-icon-container">
                                <label>Shipping Date:</label>
                                <div class="input-group date">
                                    <input type="text" placeholder="Sending Date" value="{{ $orders->sending_time }}" disabled autocomplete="off" class="form-control" id="kt_datepicker_3">
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                    </div>
                                </div><i data-field="sending_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group fv-plugins-icon-container">
                                <label>Delivery Date:</label>
                                <div class="input-group date">
                                    <input type="text" placeholder="Delivery Date" value="{{ $orders->delivery_time }}" disabled autocomplete="off" class="form-control" id="kt_datepicker_4">
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                    </div>
                                </div><i data-field="delivery_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div></div>
                        </div>
                    </div>
                    <hr>
                </div>
                <hr>
                <div class="col-lg-12">
                    <div id="kt_repeater_1">
                        <div class="" id="">
                            <h2 class="text-left">Package Info:</h2>
                            <div data-repeater-list="Package" class="col-lg-12">
                                @foreach($orders->cargo as $item)
                                    <div data-repeater-item class="row align-items-center" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                        <div class="col-md-3">
                                            <label>{{ ('Type')}}:</label>
                                            <input type="text" placeholder="{{ ('type')}}" class="form-control" disabled value="{{$item['type']}}">
                                            <input type="hidden" disabled value="{{$item['id']}}">
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Actual weight  (kg):</label>
                                            <input class="kt_touchspin_qty" placeholder="Actual weight" type="number" min="1" step="0.1" disabled class="form-control" value="{{$item['actual_weight']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ ('Quantity')}}:</label>
                                            <input class="kt_touchspin_qty" placeholder="{{ ('Quantity')}}" type="number" min="1" disabled class="form-control" value="{{$item['quantity']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Serial number:</label>
                                            <input type="text"  placeholder="Serial number" disabled class="form-control "  value="{{$item['serial_number']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Serial number sensor:</label>
                                            <input type="text"  placeholder="Serial number sensor" disabled class="form-control  "  value="{{$item['serial_number_sensor']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>UN number:</label>
                                            <input type="text"  placeholder="UN number" disabled class="form-control  "  value="{{$item['un_number']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Temperature conditions:</label>
                                            <input type="text"  placeholder="Temperature conditions" disabled class="form-control  "  value="{{$item['temperature_conditions']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Volume weight:</label>
                                            <input type="text"  placeholder="Volume weight" name="volume_weight" disabled class="form-control  "  value="{{$item['volume_weight']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <label>{{ ('Dimensions [Length x Width x Height] (cm):')}}:</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r" type="number" min="1" class="form-control" placeholder="{{ ('Length')}}" disabled value="{{$item['сargo_dimensions_length']}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r" type="number" min="1" class="form-control" placeholder="{{ ('Width')}}" disabled value="{{$item['сargo_dimensions_width']}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r" type="number" min="1" class="form-control " placeholder="{{ ('Height')}}" disabled value="{{$item['сargo_dimensions_height']}}" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group ">
                        </div>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox7" name="my_container" disabled @if($orders->my_container == 'on') checked  @endif>
                                <label class="form-check-label" for="inlineCheckbox7">My container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox6" name="my_sensor" disabled @if($orders->my_sensor == 'on') checked  @endif>
                                <label class="form-check-label" for="inlineCheckbox6">My sensor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="sensor_for_rent" disabled @if($orders->sensor_for_rent == 'on') checked  @endif>
                                <label class="form-check-label" for="inlineCheckbox1">Sensor for rent</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="container" disabled @if($orders->container == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox2">Container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="return_sensor" disabled @if($orders->return_sensor == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox3">Returning the sensor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="return_container" disabled @if($orders->return_container == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox4">Returning a shipping container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="notifications" disabled @if($orders->notifications == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox5">Receive notifications</label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Delivery comment</label>
                                <textarea class="form-control" name="delivery_comment" disabled>{{$orders->delivery_comment}}</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            {{--                        <div class="col-md-6" data-select2-id="66">--}}
                            {{--                            <label>Shipping Payer:</label>--}}
                            {{--                            <select id="change-country-to" name="user_id" class="form-control ">--}}
                            {{--                                <option value="">----</option>--}}
                            {{--                                @foreach($user as $item)--}}
                            {{--                                    <option value="{{$item->id}}" @if($item->id == $orders->user_id) selected @endif>{{$item->email}}</option>--}}
                            {{--                                @endforeach--}}
                            {{--                            </select>--}}
                            {{--                        </div>--}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Shipping Payer:</label>
                                    <input type="text" placeholder="Shipping Payer" disabled class="form-control" value="{{ $orders->user }}" />
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Agent:</label>
                                <select id="change-country-to" disabled class="form-control ">
                                    <option value=""></option>
                                    @foreach($user as $item)
                                        @if($item->roles->first()->name == 'Agent')
                                            <option value="{{$item->id}}" @if($item->id == $orders->agent_id) selected @endif >{{$item->nickname}} - {{$item->roles->first()->name}} </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id="kt_repeater_12">
                        <div class="" id="">
                            <h2 class="text-left">Tracker Info:</h2>
                            <div data-repeater-item class="row align-items-center" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                <div class="col-md-3">
                                    <label>Location:</label>
                                    <input  placeholder="Start time" type="text"  disabled class="form-control" value="{{$tracker_start->cargolocation->name}}"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Address:</label>
                                    <input  placeholder="Start time" type="text" disabled  class="form-control" value="{{$tracker_start->address}}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                @php
                                    if (isset($tracker_start->start_time))
                                    {
                                         $start_time = str_replace(' ','T', $tracker_start->start_time);
                                    }
                                    $end_time=is_null($tracker_start->end_time)?'':str_replace(' ','T', $tracker_start->end_time);
                                @endphp
                                <div class="col-md-4">
                                    <label>Estimated time:</label>
                                    <input  placeholder="Start time" type="datetime-local" disabled class="form-control" value="{{ $start_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Pick up Time:</label>
                                    <input  placeholder="Start time" type="datetime-local" name="start[arrived_time]"  class="form-control" value="{{ $end_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3" id="actual_time_start">
                                    <label>Signed:</label><input placeholder="Signed" type="text" name="start[signed]"
                                                                 class="form-control" value="{{$tracker_start->signed}}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="actual_time" name="start[status_arrival]" @if($tracker_start->status == 'Arrived') disabled checked @endif>
                                        <label class="form-check-label" >Arrived</label>

                                    </div>
                                </div>
                            </div>
                            <div data-repeater-list="time" class="col-lg-12">
                                {{--                                @dd($trackers)--}}
                                @if(!$trackers->isEmpty())
                                    @foreach($trackers as $tracker)
                                        <div data-repeater-item class="row align-items-center zakupak" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                            <div class="col-md-3">
                                                <label>Location:</label>
                                                <select  disabled class="form-control ">
                                                    @foreach($cargo_location as $item)
                                                        <option value="{{$item->id}}" @if($item->id == $tracker->cargolocation->id) selected @endif>{{$item->name}}</option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" name="tracker_id" value="{{$tracker->id}}">
                                                <input type="hidden" name="id" value="{{$orders->id}}">
                                                <input type="hidden" name="cargo_location" value="{{$tracker->cargolocation->id}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Address:</label>
                                                <input  placeholder="City, street" type="text" disabled  class="form-control" value="{{$tracker->address}}" required/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-4">
                                                @php
                                                    if (isset($tracker->start_time))
                                                    {
                                                         $start_time = str_replace(' ','T', $tracker->start_time);
                                                    }
                                                    $end_time=is_null($tracker->end_time)?'':str_replace(' ','T', $tracker->end_time);
                                                    $left_the_point=is_null($tracker->left_the_point)?'':str_replace(' ','T', $tracker->left_the_point);
                                                @endphp
                                                <label>Estimated time:</label>
                                                <input  placeholder="Start time" type="datetime-local" disabled class="form-control clear-value-data" value="{{ $start_time }}" required/>
                                                <div class="mb-2 d-md-none"></div>

                                            </div>
                                            <div class="col-md-3">
                                                <label>Arrived Time:</label>
                                                <input  placeholder="Start time" type="datetime-local" name="arrived_time"  class="form-control clear-value-data" value="{{$end_time}}" />
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3 col-md-4">
                                                <label>Left Time:</label>
                                                <input placeholder="Left Time" type="datetime-local" name="left_time"
                                                       autocomplete="off"
                                                       class="form-control clear-value-data" value="{{$left_the_point}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"  name="status_arrival" @if( $tracker->status == 'Arrived') disabled checked @endif>
                                                    <label class="form-check-label" >Arrived</label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="left_time" name="status_left" @if(!empty($tracker->left_the_point)) disabled checked @endif>
                                                    <label class="form-check-label" >Leave</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div data-repeater-item class="row align-items-center" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                <div class="col-md-3">
                                    <label>Location:</label>
                                    <input  placeholder="Start time" type="text"  disabled class="form-control" value="{{$tracker_end->cargolocation->name}}"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Address:</label>
                                    <input  placeholder="Start time" type="text" disabled  class="form-control" value="{{$tracker_end->address}}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                @php
                                    if (isset($tracker_end->start_time))
                                    {
                                         $start_time = str_replace(' ','T', $tracker_end->start_time);
                                    }
                                    $end_time=is_null($tracker_end->end_time)?'':str_replace(' ','T', $tracker_end->end_time);
                                @endphp
                                <div class="col-md-4">
                                    <label>Estimated time:</label>
                                    <input  placeholder="Start time" type="datetime-local" disabled class="form-control" value="{{ $start_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Delivery Time:</label>
                                    <input  placeholder="Start time" type="datetime-local" name="end[arrived_time]" class="form-control" value="{{ $end_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3 tracker_append" id="actual-time-end-signed">
                                    <label>Signed:</label><input placeholder="Signed" type="text" name="end[signed]"
                                                                 class="form-control " value="{{$tracker_end->signed}}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check" id="actual_time_end">
                                        <input class="form-check-input"  type="checkbox"  name="end[status_arrival]" @if($tracker_end->status == 'Arrived') disabled checked @endif>
                                        <label class="form-check-label" >Arrived</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group ">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group ">
                        <div class="">
                            <div>
                                <input type="submit" class="btn btn-sm font-weight-bolder btn-light-primary" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{ static_asset('assets/dashboard/js/geocomplete/jquery.geocomplete.js') }}"></script>
    {{--<script src="//maps.googleapis.com/maps/api/js?libraries=places&key={{$checked_google_map->key}}"></script>--}}

    <script type="text/javascript">

    </script>
    <script type="text/javascript">
        // Map Address For Receiver
        $('.address-receiver').each(function(){
            var address = $(this);
            address.geocomplete({
                map: ".map_canvas.map-receiver",
                mapOptions: {
                    zoom: 8,
                    center: { lat: -34.397, lng: 150.644 },
                },
                markerOptions: {
                    draggable: true
                },
                details: ".location-receiver",
                detailsAttribute: 'data-receiver',
                autoselect: true,
                restoreValueAfterBlur: true,
            });
            address.bind("geocode:dragged", function(event, latLng){
                $("input[data-receiver=lat]").val(latLng.lat());
                $("input[data-receiver=lng]").val(latLng.lng());
            });
        });
        // Map Address For Client
        $('.address-client').each(function(){
            var address = $(this);
            address.geocomplete({
                map: ".map_canvas.map-client",
                mapOptions: {
                    zoom: 8,
                    center: { lat: -34.397, lng: 150.644 },
                },
                markerOptions: {
                    draggable: true
                },
                details: ".location-client",
                detailsAttribute: 'data-client',
                autoselect: true,
                restoreValueAfterBlur: true,
            });
            address.bind("geocode:dragged", function(event, latLng){
                $("input[data-client=lat]").val(latLng.lat());
                $("input[data-client=lng]").val(latLng.lng());
            });
        });
        // Get Addressess After Select Client
        function selectIsTriggered()
        {
            getAdressess(document.getElementById("client-id").value);
        }
        function openAddressDiv()
        {
            $( "#show_address_div" ).slideDown( "slow", function() {
                // Animation complete.
            });
        }
        function closeAddressDiv()
        {
            $( "#show_address_div" ).slideUp( "slow", function() {
                // Animation complete.
            });
        }
        var inputs = document.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type.toLowerCase() == 'number') {
                inputs[i].onkeydown = function(e) {
                    if (!((e.keyCode > 95 && e.keyCode < 106) ||
                        (e.keyCode > 47 && e.keyCode < 58) ||
                        e.keyCode == 8)) {
                        return false;
                    }
                }
            }
        }
        $('.select-client').change(function(){
            var client_phone = $(this).find(':selected').data('phone');
            document.getElementById("client_phone").value = client_phone;
        })
        $('.payment-method').select2({
            placeholder: "Payment Method",
        });
        $('.payment-type').select2({
            placeholder: "Payment Type",
        });
        $('.delivery-time').select2({
            placeholder: "Delivery Time",
        });
        $('.select-branch').select2({
            placeholder: "Select Branch",
        })

        function calcTotalWeight() {
            var elements = $('.weight-listener');
            var sumWeight = 0;
            elements.map(function() {
                sumWeight += parseInt($(this).val());
                console.log(sumWeight);
            }).get();
            $('.total-weight').val(sumWeight);
        }
        function deleteCargo(elem,deleteElement){
            var cargo_id = $(elem).find('input[type="hidden"]').val();
            var order_id = $("#order").val();
            if(confirm('Удалять?')){
                $.ajax({
                    url: '/admin/orders/remove-cargo',
                    type: "POST",
                    data: {
                        cargo: cargo_id,
                        order: order_id
                    },
                    success: function(response){
                        $(this).slideUp(deleteElement);
                    }
                })
            }
        }
        function deleteTracker(elem,deleteElement){
            var tracker_id = $(elem).find('input[type="hidden"]').val();
            // var order_id = $("#order").val();
            if(confirm('Удалять?')){
                console.log(tracker_id);
                $.ajax({
                    url: '/admin/tracker/remove-tracker',
                    type: "POST",
                    data: {
                        tracker: tracker_id,
                    },
                    success: function(response){
                        $(this).slideUp(deleteElement);
                    }
                })
            }
        }
        $(document).ready(function() {
            $('.select-country').select2({
                placeholder: "Select country",
                language: {
                    noResults: function() {
                        {{--                @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                        {{--                    return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.shipments.covered_countries')}}?redirect=admin.shipments.create"--}}
                        {{--                    class="btn btn-primary" >Manage {{ ('Countries')}}</a>--}}
                        {{--                    </li>`;--}}
                        {{--                @else--}}
                        {{--                    return ``;--}}
                        {{--                @endif--}}
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });
            $('.select-state').select2({
                placeholder: "Select state",
                language: {
                    noResults: function() {
                        {{--                @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                        {{--                    return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.shipments.covered_countries')}}?redirect=admin.shipments.create"--}}
                        {{--                    class="btn btn-primary" >Manage {{ ('States')}}</a>--}}
                        {{--                    </li>`;--}}
                        {{--                @else--}}
                        {{--                    return ``;--}}
                        {{--                @endif--}}
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });
            $('.select-address').select2({
                placeholder: "Select Client First",
            })
            $('.select-area').select2({
                placeholder: "Select Area",
                language: {
                    noResults: function() {
                        {{--                @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                        {{--                    return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.areas.create')}}?redirect=admin.shipments.create"--}}
                        {{--                    class="btn btn-primary" >Manage {{ ('Areas')}}</a>--}}
                        {{--                    </li>`;--}}
                        {{--                @else--}}
                        {{--                    return ``;--}}
                        {{--                @endif--}}
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });
            $('.select-country').trigger('change');
            $('.select-state').trigger('change');
            $('#kt_datepicker_3').datepicker({
                orientation: "bottom auto",
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayBtn: true,
                todayHighlight: true,
                startDate: new Date(),
            });
            $('#kt_datepicker_4').datepicker({
                orientation: "bottom auto",
                autoclose: true,
                format: 'yyyy-mm-dd',
                todayBtn: true,
                todayHighlight: true,
                startDate: new Date(),
            });
            $( document ).ready(function() {
                $('.package-type-select').select2({
                    placeholder: "Package Type",
                    language: {
                        noResults: function() {
                            {{--                    @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                            {{--                        return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.packages.create')}}?redirect=admin.shipments.create"--}}
                            {{--                        class="btn btn-primary" >Manage {{ ('Packages')}}</a>--}}
                            {{--                        </li>`;--}}
                            {{--                    @else--}}
                            {{--                        return ``;--}}
                            {{--                    @endif--}}
                        },
                    },
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                });
            });
            //Package Types Repeater
            $('#kt_repeater_1').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                    $('.package-type-select').select2({
                        placeholder: "Package Type",
                        language: {
                            noResults: function() {
                                {{--                        @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                                {{--                            return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.packages.create')}}?redirect=admin.shipments.create"--}}
                                {{--                            class="btn btn-primary" >Manage {{ ('Packages')}}</a>--}}
                                {{--                            </li>`;--}}
                                {{--                        @else--}}
                                {{--                            return ``;--}}
                                {{--                        @endif--}}
                            },
                        },
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                    });
                    $('.dimensions_r').TouchSpin({
                        buttondown_class: 'btn btn-secondary',
                        buttonup_class: 'btn btn-secondary',
                        min: 1,
                        max: 1000000000,
                        stepinterval: 50,
                        maxboostedstep: 10000000,
                        initval: 1,
                    });
                    $('.kt_touchspin_weight').TouchSpin({
                        buttondown_class: 'btn btn-secondary',
                        buttonup_class: 'btn btn-secondary',
                        min: 1,
                        max: 1000000000,
                        stepinterval: 50,
                        maxboostedstep: 10000000,
                        initval: 1,
                        prefix: 'Kg'
                    });
                    $('.kt_touchspin_qty').TouchSpin({
                        buttondown_class: 'btn btn-secondary',
                        buttonup_class: 'btn btn-secondary',
                        min: 1,
                        max: 1000000000,
                        stepinterval: 50,
                        maxboostedstep: 10000000,
                        initval: 1,
                    });
                    calcTotalWeight();
                },
                hide: function(deleteElement) {
                    deleteCargo(this,deleteElement);
                }
            });


            $('#kt_repeater_12').repeater({
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    deleteTracker(this,deleteElement);
                }
            });


            $('body').on('click', '.delete_item', function(){
                $('.total-weight').val("{{ ('Calculated...')}}");
                setTimeout(function(){ calcTotalWeight(); }, 500);
            });
            $('#kt_touchspin_2, #kt_touchspin_2_2').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                min: -1000000000,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                prefix: '%'
            });
            $('#kt_touchspin_3').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                min: 0,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                prefix: ''
            });
            $('#kt_touchspin_4').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                min: 1,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                initval: 1,
                prefix: 'Kg'
            });
            $('.kt_touchspin_weight').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                min: 1,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                initval: 1,
                prefix: 'Kg'
            });
            $('.kt_touchspin_qty').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                min: 1,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                initval: 1,
            });
            $('.dimensions_r').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                min: 1,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                initval: 1,
            });

            $('#actual_time').on('click', function () {
                $('#actual_time_start input').attr("required", "required");
            })
            $('#actual_time_end').on('change', function () {

                $('#actual-time-end-signed input').attr("required", "required");
            })

            $('.clear-value-datatime').click(function (){
                $('.zakupak').last().find('.col-md-4').find('.clear-value-data').removeAttr('value');
            });
        });
    </script>
@endsection
