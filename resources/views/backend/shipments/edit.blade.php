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
    @php
        /*   $auth_user = Auth::user();
           $user_type = Auth::user()->user_type;
           $staff_permission = json_decode(Auth::user()->staff->role->permissions ?? "[]");
           $countries = \App\Country::where('covered',1)->get();
           $packages = \App\Package::all();
           $deliveryTimes = \App\DeliveryTime::all();
           $is_def_mile_or_fees = \App\ShipmentSetting::getVal('is_def_mile_or_fees');
           // is_def_mile_or_fees if result 1 for mile if result 2 for fees
           dd($is_def_mile_or_fees);
           if(!$is_def_mile_or_fees){
               $is_def_mile_or_fees = 0;
           }
           $checked_google_map = \App\BusinessSetting::where('type', 'google_map')->first();
           if($user_type == 'customer')
           {
               $user_client = Auth::user()->userClient->client_id;
           } */
    @endphp
    <style>
        label {
            font-weight: bold !important;
        }
        .select2-container {
            display: block !important;
        }
    </style>
    <form class="form-horizontal" action="{{route('admin.orders.update',$orders->id)}}" id="kt_form_1" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper`s company name')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper company name')}}" name="company_shipper" required class="form-control" value="{{$orders->company_shipper}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Phone')}}" name="phone_shipper" required class="form-control" value="{{$orders->phone_shipper}}"/>

                            </div>
                        </div>
                        @if($orders->status_id == 2 || $orders->status_id == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Shipper Address')}}" name="address_shipper" required class="form-control" value="{{$tracker_start->address}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper City')}}:</label>
                                    <select class="form-control kt-select2 delivery-time"  id="shipper_address" name="shipper_address_id" required>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}" @if($tracker_start->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Shipper Address')}}"  disabled class="form-control" value="{{$tracker_start->address}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper City')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" id="shipper_address" disabled>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}" @if($tracker_start->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Name')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Name')}}" name="shipper"  required class="form-control"  value="{{$orders->shipper}}" />
                                <input type="hidden" id="order" value="{{$orders->id}}">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee`s company name')}}:</label>
                                <input type="text" placeholder="{{ ('Company Consignee')}}" name="company_consignee" required class="form-control" value="{{ $orders->company_consignee }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Phone')}}" required name="phone_consignee" class="form-control" value="{{$orders->phone_consignee}}" />

                            </div>
                        </div>
                        @if($orders->status_id == 2 || $orders->status_id == 1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Consignee Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Consignee Address')}}" name="address_consignee" required class="form-control" value="{{$tracker_end->address}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star" >{{ ('Shipper City')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" id="consignee_address" name="consignee_address_id" required>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}" @if($tracker_end->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Consignee Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Consignee Address')}}"  class="form-control" disabled value="{{$tracker_end->address}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Shipper City')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" id="shipper_address" disabled>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}" @if($tracker_end->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="red-star" >{{ ('Consignee Name')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Name')}}" required name="consignee" class="form-control" value="{{$orders->consignee}}" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Shipment description')}}:</label>
                                <textarea class="form-control" name="shipment_description">{{ $orders->shipment_description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pick-up Instruction</label>
                                <textarea class="form-control" name="comment">{{ $orders->comment }}</textarea>
                            </div>
                        </div>
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group fv-plugins-icon-container">--}}
{{--                                <label>Shipping Date:</label>--}}
{{--                                <div class="input-group date">--}}
{{--                                    <input type="text" placeholder="Sending Date" value="{{ $orders->sending_time }}" name="sending_time" autocomplete="off" class="form-control" id="kt_datepicker_3">--}}
{{--                                    <div class="input-group-append">--}}
{{--                                            <span class="input-group-text">--}}
{{--                                                <i class="la la-calendar"></i>--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                </div><i data-field="sending_time" class="fv-plugins-icon"></i>--}}
{{--                                <div class="fv-plugins-message-container"></div></div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group fv-plugins-icon-container">--}}
{{--                                <label>Delivery Date:</label>--}}
{{--                                <div class="input-group date">--}}
{{--                                    <input type="text" placeholder="Delivery Date" value="{{ $orders->delivery_time }}" name="delivery_time" autocomplete="off" class="form-control" id="kt_datepicker_4">--}}
{{--                                    <div class="input-group-append">--}}
{{--                                            <span class="input-group-text">--}}
{{--                                                <i class="la la-calendar"></i>--}}
{{--                                            </span>--}}
{{--                                    </div>--}}
{{--                                </div><i data-field="delivery_time" class="fv-plugins-icon"></i>--}}
{{--                                <div class="fv-plugins-message-container"></div></div>--}}
{{--                        </div>--}}
{{--                        @php--}}
{{--                            if (isset($orders->sending_time))--}}
{{--                            {--}}
{{--                                 $orders_start_time = str_replace(' ','T', $orders->sending_time);--}}
{{--                            }--}}
{{--                            $orders_end_time=is_null($orders->delivery_time)?'':str_replace(' ','T', $orders->delivery_time);--}}
{{--                        @endphp--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group fv-plugins-icon-container">--}}
{{--                                <label class="red-star">Shipping Date:</label>--}}
{{--                                <div class="input-group date">--}}
{{--                                    <input  placeholder="Start time" type="datetime-local" name="sending_time" required class="form-control" value="{{$orders_start_time}}"/>--}}
{{--                                </div><i data-field="sending_time" class="fv-plugins-icon"></i>--}}

{{--                                <div class="fv-plugins-message-container"></div></div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group fv-plugins-icon-container">--}}
{{--                                <label class="red-star">Delivery Date:</label>--}}
{{--                                <div class="input-group date">--}}
{{--                                    <input  placeholder="Start time" type="datetime-local" name="delivery_time" required class="form-control" value="{{$orders_end_time}}"/>--}}
{{--                                </div><i data-field="delivery_time" class="fv-plugins-icon"></i>--}}

{{--                                <div class="fv-plugins-message-container"></div></div>--}}
{{--                        </div>--}}
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
                                            <label class="red-star">{{ ('Type')}}:</label>
                                            <input type="text" placeholder="{{ ('type')}}" class="form-control" required  name="type" value="{{$item['type']}}">
                                            <input type="hidden" name="id" value="{{$item['id']}}">
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="red-star">Actual weight:</label>
                                            <input class="kt_touchspin_qty" placeholder="Actual weight" type="number" required min="1" name="actual_weight" class="form-control" value="{{$item['actual_weight']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="red-star">{{ ('Quantity')}}:</label>
                                            <input class="kt_touchspin_qty" placeholder="{{ ('Quantity')}}" required type="number" min="1" name="quantity" class="form-control" value="{{$item['quantity']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Serial number box:</label>
                                            <input type="text"  placeholder="Serial number" name="serial_number" class="form-control "  value="{{$item['serial_number']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Serial number sensor:</label>
                                            <input type="text"  placeholder="Serial number sensor" name="serial_number_sensor" class="form-control  "  value="{{$item['serial_number_sensor']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>UN number:</label>
                                            <input type="text"  placeholder="UN number" name="un_number" class="form-control  "  value="{{$item['un_number']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="red-star">Temperature conditions:</label>
                                            <input type="text"  placeholder="Temperature conditions" name="temperature_conditions" required class="form-control  "  value="{{$item['temperature_conditions']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Volume weight:</label>
                                            <input type="text"  placeholder="Temperature conditions" name="volume_weight" disabled class="form-control  "  value="{{$item['volume_weight']}}" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <label class="red-star">{{ ('Dimensions [Length x Width x Height] (cm)')}}:</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r" type="number" min="1" required class="form-control" placeholder="{{ ('Length')}}" name="сargo_dimensions_length" value="{{$item['сargo_dimensions_length']}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r" type="number" min="1" required class="form-control" placeholder="{{ ('Width')}}" name="сargo_dimensions_width" value="{{$item['сargo_dimensions_width']}}" />
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r" type="number" min="1" required class="form-control " placeholder="{{ ('Height')}}" name="сargo_dimensions_height" value="{{$item['сargo_dimensions_height']}}" />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <a href="javascript:;" data-repeater-delete="" onclick="//deleteCargo(this)" class="btn btn-sm font-weight-bolder btn-light-danger delete_item">
                                                        <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="">
                                <label class="text-right col-form-label">{{ ('Add')}}</label>
                                <div>
                                    <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                        <i class="la la-plus"></i>{{ ('Add')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="sensor_for_rent" @if($orders->sensor_for_rent == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox1">Sensor for rent</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="container" @if($orders->container == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox2">Container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="return_sensor" @if($orders->return_sensor == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox3">Returning the sensor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="return_container" @if($orders->return_container == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox4">Returning a shipping container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="notifications" @if($orders->notifications == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox5">Receive notifications</label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Delivery Instruction</label>
                                <textarea class="form-control" name="delivery_comment">{{$orders->delivery_comment}}</textarea>
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
                                    <label class="red-star">Shipping Payer:</label>
                                    <input type="text" placeholder="Shipping Payer" name="user" required class="form-control" value="{{ $orders->user }}" />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
{{--                            <div class="col-md-6" data-select2-id="66">--}}
{{--                                <label>Status:</label>--}}
{{--                                <select id="select1" name="status_id" class="form-control ">--}}
{{--                                    @foreach($status as $item)--}}
{{--                                        <option value="{{$item->id}}" @if($item->id == $orders->status->id) selected @endif >{{$item->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                            </select>--}}
{{--                            </div>--}}

{{--                            <div id="step2">--}}
{{--                                <div class="col-md-6" data-select2-id="66" id="3">--}}
{{--                                    <select  name="substatus_id" class="form-control ">--}}
{{--                                        @foreach($substatus->where('status_id',3) as $item)--}}
{{--                                            <option value="{{$item->id}}" >{{$item->name}}</option>--}}
{{--                                            <option value="{{$item->id}}" @if($item->id == $orders->substatus->id) selected @endif >{{$item->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-6" data-select2-id="66" id="4">--}}
{{--                                    <select name="substatus_id" class="form-control ">--}}
{{--                                        @foreach($substatus->where('status_id',4) as $item)--}}
{{--                                            <option value="{{$item->id}}">{{$item->name}}</option>--}}
{{--                                            <option value="{{$item->id}}" @if($item->id == $orders->substatus->id) selected @endif >{{$item->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}



                            <div class="col-md-6" data-select2-id="66">
                                <label>Status</label>
                                <select id="select1" name="status_id" class="form-control ">
                                    @foreach($status as $item)
                                        <option value="{{$item->id}}" @if($item->id == $orders->status->id) selected @endif >{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div id="step2">
                                    <label></label>

                                    <select id="3" name="substatus_id" class="form-control ">
                                        <option></option>
                                        @foreach($substatus->where('status_id',3) as $item)
{{--                                            <option value="{{$item->id}}" >{{$item->name}}</option>--}}
                                            <option value="{{$item->id}}" @if($item->id == $orders->substatus_id) selected @endif >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <label></label>

                                    <select id="4" name="substatus_id" class="form-control ">
                                        <option></option>
                                        @foreach($substatus->where('status_id',4) as $item)
{{--                                            <option value="{{$item->id}}">{{$item->name}}</option>--}}
                                            <option value="{{$item->id}}" @if($item->id == $orders->substatus_id) selected @endif >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Agent:</label>
                                <select id="change-country-to" name="agent_id" class="form-control ">
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
                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Driver:</label>
                                <select id="change-country-to" name="driver_id" class="form-control ">
                                    <option value=""></option>
                                    @foreach($user as $item)
                                        @if($item->roles->first()->name == 'Driver')
                                            <option value="{{$item->id}}" @if($item->id == $orders->driver_id) selected @endif >{{$item->nickname}} - {{$item->roles->first()->name}}  </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr>
                         <div class="">
                             <div class="col-md-6" data-select2-id="66">
                                 <label>Location:</label>
                                 <select id="select2" name="locations" class="form-control ">
                                     <option></option>
{{--                                         @php--}}
{{--                                             $last_city = '';--}}
{{--                                         @endphp--}}

{{--                                     @foreach($lupa as $city )--}}
{{--                                         @if($last_city != '')--}}
{{--                                            <option value="{{$last_city}}-{{$city['name']}}({{$city['city']}})" @if($last_city.'-'.$city['name'] == $orders->locations ) selected @endif  >{{$last_city}}-{{$city['name']}}({{$city['city']}})</option>--}}
{{--                                         @endif--}}
{{--                                            <option value="{{$city['name']}}({{$city['city']}})" @if($city['name'] == $orders->locations ) selected @endif >{{$city['name']}}({{$city['city']}})</option>--}}
{{--                                         @php--}}
{{--                                             $last_city = $city['name'].'('.$city['city'].')';--}}
{{--                                         @endphp--}}
{{--                                     @endforeach--}}


                    @php
                     $last_city = '';
                    @endphp

                     @foreach($lupa as $key => $city )
                         @php
                             $cur_city = $city['name'].'('.$city['city'].')';
                         @endphp
                             @if($last_city != '')
                                 <option value="{{$last_city}}-{{$city['name']}}({{$city['city']}})" data-id="city_{{$key+20}}" @if('city_' . ($key+20) == $orders->locations_id) selected @endif>{{$last_city}}-{{$cur_city}}</option>
                             @endif

                         <option value="{{$cur_city}}" data-id="city_{{$key+1}}" @if('city_' . ($key+1) == $orders->locations_id ) selected @endif >{{$cur_city}}</option>

                         @php
                             $last_city = $cur_city;
                         @endphp

                    @endforeach



                                 </select>
                                 <input type="hidden" name="city_id"  id="city" value="{{$orders->locations_id}}">
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
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <label>Estimated time:</label>
                                    <input  placeholder="Start time" type="datetime-local" name="start[start_time]" class="form-control" value="{{ $start_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Actual Time:</label>
                                    <input  placeholder="Start time" type="datetime-local" name="start[end_time]" class="form-control" value="{{ $end_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Status:</label>
{{--                                    @dd($tracker_start->status)--}}
                                    <select id="change-country-to" name="start[status]" class="form-control ">
                                            <option value="Awaiting arrival" @if($tracker_start->status == 'Awaiting arrival') selected @endif>Awaiting arrival</option>
                                            <option value="Arrived" @if($tracker_start->status == 'Arrived') selected @endif>Arrived</option>
                                    </select>
                                </div>
                            </div>
                            <div data-repeater-list="time" class="col-lg-12">
                                {{--                                @dd($trackers)--}}
                                @if(!$trackers->isEmpty())
                                    @foreach($trackers as $tracker)
                                        <div data-repeater-item class="row align-items-center zakupak" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                            <div class="col-md-3">
                                                <label>Location:</label>
                                                <select  name="cargo_location" class="form-control ">
                                                    @foreach($cargo_location as $item)
                                                        <option value="{{$item->id}}" @if($item->id == $tracker->cargolocation->id) selected @endif>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="id" value="{{$tracker->id}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Address:</label>
                                                <input  placeholder="City, street, postal code" type="text" name="address"  class="form-control" value="{{$tracker->address}}" required/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-4">
                                                @php
                                                    if (isset($tracker->start_time))
                                                    {
                                                         $start_time = str_replace(' ','T', $tracker->start_time);
                                                    }
                                                    $end_time=is_null($tracker->end_time)?'':str_replace(' ','T', $tracker->end_time);
                                                @endphp
                                                <label>Estimated time:</label>
                                                <input  placeholder="Start time" type="datetime-local" name="start_time" class="form-control clear-value-data" value="{{ $start_time }}" required/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Actual Time:</label>
                                                <input  placeholder="Start time" type="datetime-local" name="end_time" class="form-control clear-value-data" value="{{$end_time}}" />
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Status:</label>
                                                <select id="change-country-to" name="start[status]" class="form-control ">
                                                    <option value="Arrived" @if ($tracker->status == 'Arrived') selected @endif>Arrived</option>
                                                    <option value="Awaiting arrival" @if($tracker->status == 'Awaiting arrival') selected @endif>Awaiting arrival</option>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div>
                                                        <a href="javascript:;" data-repeater-delete="" onclick="//deleteCargo(this)" class="btn btn-sm font-weight-bolder btn-light-danger delete_item_time">
                                                            <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div data-repeater-item class="row align-items-center  tracker-block-delete" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                        <div class="col-md-3">
                                            <label>Location:</label>
                                            <select  name="cargo_location" class="form-control ">
                                                @foreach($cargo_location as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Address:</label>
                                            <input  placeholder="City, street, postal code" type="text" name="address"  class="form-control" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Estimated time:</label>
                                            <input  placeholder="Start time" type="datetime-local" name="start_time" class="form-control clear-value-data"  />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Actual Time:</label>
                                            <input  placeholder="Start time" type="datetime-local" name="end_time" class="form-control clear-value-data" />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Status:</label>
                                            <select id="change-country-to" name="start[status]" class="form-control ">
                                                <option value="Arrived">Arrived</option>
                                                <option value="Awaiting arrival">Awaiting arrival</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <a href="javascript:;" data-repeater-delete="" onclick="//deleteCargo(this)" class="btn btn-sm font-weight-bolder btn-light-danger delete_item_time">
                                                        <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div data-repeater-item class="row align-items-center" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                <div class="col-md-3">
                                    <label>Location:</label>
                                    <input  placeholder="Start time" type="text"  disabled class="form-control" value="{{$tracker_end->cargolocation->name}}"/>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <label>Estimated time:</label>
                                    <input  placeholder="Start time" type="datetime-local" name="end[start_time]" class="form-control" value="{{ $start_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Actual Time:</label>
                                    <input  placeholder="Start time" type="datetime-local" name="end[end_time]" class="form-control" value="{{ $end_time }}"/>
                                    <div class="mb-2 d-md-none"></div>
                                </div>
                                <div class="col-md-3">
                                    <label>Status:</label>
                                    <select id="change-country-to" name="end[status]" class="form-control ">
                                        <option value="Awaiting arrival" @if($tracker_end->status == 'Awaiting arrival') selected @endif>Awaiting arrival</option>
                                        <option value="Arrived" @if($tracker_end->status == 'Arrived') selected @endif>Arrived</option>
                                    </select>
                                </div>
{{--                                <div class="col-md-3">--}}
{{--                                    <label>Signed:</label>--}}
{{--                                    <input  placeholder="Start time" type="text"  disabled class="form-control" value="{{$tracker_end->cargolocation->name}}"/>--}}
{{--                                </div>--}}
                                <div class="col-md-3 tracker_append">

                                </div>
                            </div>

                        </div>
                        <div class="form-group ">
                            <div class="">
                                <label class="text-right col-form-label">{{ ('Add')}}</label>
                                <div>
                                    <a href="javascript:;" data-repeater-create-time="" class="btn btn-sm font-weight-bolder btn-light-primary clear-value-datatime">
                                        <i class="la la-plus"></i>{{ ('Add')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
        function get_estimation_cost() {
            var total_weight = document.getElementById('kt_touchspin_4').value;
            var select_packages = document.getElementsByClassName('package-type-select');
            var from_country_id = document.getElementsByName("Shipment[from_country_id]")[0].value;
            var to_country_id = document.getElementsByName("Shipment[to_country_id]")[0].value;
            var from_state_id = document.getElementsByName("Shipment[from_state_id]")[0].value;
            var to_state_id = document.getElementsByName("Shipment[to_state_id]")[0].value;
            var from_area_id = document.getElementsByName("Shipment[from_area_id]")[0].value;
            var to_area_id = document.getElementsByName("Shipment[to_area_id]")[0].value;
            var package_ids = [];
            for (let index = 0; index < select_packages.length; index++) {
                if(select_packages[index].value){
                    package_ids[index] = new Object();
                    package_ids[index]["package_id"] = select_packages[index].value;
                }else{
                    AIZ.plugins.notify('danger', '{{  ('Please select package type') }} ' + (index+1));
                    return 0;
                }
            }
            var request_data = { _token : '{{ csrf_token() }}',
                package_ids : package_ids,
                total_weight : total_weight,
                from_country_id : from_country_id,
                to_country_id : to_country_id,
                from_state_id : from_state_id,
                to_state_id : to_state_id,
                from_area_id : from_area_id,
                to_area_id : to_area_id,
            };
            {{--$.post('{{ route('admin.shipments.get-estimation-cost') }}', request_data, function(response){--}}
            {{--    if({{$is_def_mile_or_fees}} =='2')--}}
            {{--    {--}}
            {{--        document.getElementById("shipping_cost").innerHTML = response.shipping_cost;--}}
            {{--        document.getElementById("return_cost").innerHTML = response.return_cost;--}}
            {{--    }else if({{$is_def_mile_or_fees}} =='1')--}}
            {{--    {--}}
            {{--        document.getElementById("mile_cost").innerHTML = response.shipping_cost;--}}
            {{--        document.getElementById("return_mile_cost").innerHTML = response.return_cost;--}}
            {{--    }--}}
            {{--    document.getElementById("tax_duty").innerHTML = response.tax;--}}
            {{--    document.getElementById("insurance").innerHTML = response.insurance;--}}
            {{--    document.getElementById("total_cost").innerHTML = response.total_cost;--}}
            {{--    document.getElementById('modal_open').click();--}}
            {{--    console.log(response);--}}
            {{--});--}}
        }
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

            $('#select1').change(function(){
                var val = $(this).val();
                // console.log(val);
                //если элемент с id равным значению #select1 существует
                if(val == '3'){
                    $('#step2 select').hide();
                    $('#' + val).show();
                    $('#3').removeAttr('name').attr('name','substatus_id');
                    $('#4').removeAttr('name')
                }
                else if(val == '4'){
                    $('#step2 select').hide();
                    $('#' + val).show();
                    $('#4').removeAttr('name').attr('name','substatus_id');
                    $('#3').removeAttr('name')
                }
                else if(val != 'select2_1' || val != 'select2_2' ){
                    $('#step2 select').hide();
                }
                if ($('#select1').val() == 4){
                    $('.tracker_append').append($('<label>Signed:</label><input placeholder="Signed" type="text" name="signed" class="form-control " value="{{$tracker_end->signed}}"/><div class="mb-2 d-md-none"></div>'));
                }

            })
            if ($('#select1 :selected').val() == 3){
                $('#3').show();
                $('#4').removeAttr('name')
            }
            if ($('#select1 :selected').val() == 4){
                $('#4').show();
                $('#3').removeAttr('name');
            }


            if ($('#select1').val() == 4){
                $('.tracker_append').append($('<label>Signed:</label><input placeholder="Signed" type="text" name="signed" class="form-control" value="{{$tracker_end->signed}}"/><div class="mb-2 d-md-none"></div>'));
            }
            $('#select2').change(function(){

                let option2 = $('option:selected', this).attr('data-id');
                $('#city').val(option2);
            })

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
            $('.tracker-block-delete').remove();

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
            {{--FormValidation.formValidation(--}}
            {{--    document.getElementById('kt_form_1'), {--}}
            {{--        fields: {--}}
            {{--            "Shipment[type]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[shipping_date]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[branch_id]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[client_id]": {--}}
            {{--                validators: {--}}
            {{--                    callback: {--}}
            {{--                        message: '{{ ("This is required!")}}',--}}
            {{--                        callback: function(input) {--}}
            {{--                            // Get the selected options--}}
            {{--                            if ((input.value !== "")) {--}}
            {{--                                $('.client-select').removeClass('has-errors');--}}
            {{--                            } else {--}}
            {{--                                $('.client-select').addClass('has-errors');--}}
            {{--                            }--}}
            {{--                            return (input.value !== "");--}}
            {{--                        }--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[client_address]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[client_phone]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[payment_type]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[payment_method_id]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[tax]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[insurance]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[shipping_cost]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[delivery_time]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[delivery_time]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[total_weight]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[from_country_id]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[to_country_id]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[reciver_name]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[reciver_phone]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Shipment[reciver_address]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            "Package[0][package_id]": {--}}
            {{--                validators: {--}}
            {{--                    notEmpty: {--}}
            {{--                        message: '{{ ("This is required!")}}'--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            }--}}
            {{--        },--}}
            {{--        plugins: {--}}
            {{--            autoFocus: new FormValidation.plugins.AutoFocus(),--}}
            {{--            trigger: new FormValidation.plugins.Trigger(),--}}
            {{--            // Bootstrap Framework Integration--}}
            {{--            bootstrap: new FormValidation.plugins.Bootstrap(),--}}
            {{--            // Validate fields when clicking the Submit button--}}
            {{--            submitButton: new FormValidation.plugins.SubmitButton(),--}}
            {{--            // Submit the form when all fields are valid--}}
            {{--            defaultSubmit: new FormValidation.plugins.DefaultSubmit(),--}}
            {{--            icon: new FormValidation.plugins.Icon({--}}
            {{--                valid: '',--}}
            {{--                invalid: 'fa fa-times',--}}
            {{--                validating: 'fa fa-refresh',--}}
            {{--            }),--}}
            {{--        }--}}
            {{--    }--}}
            {{--);--}}

            $('.clear-value-datatime').click(function (){
                $('.zakupak').last().find('.col-md-4').find('.clear-value-data').removeAttr('value');
            });
        });
    </script>
@endsection
