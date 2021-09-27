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
                    <h5 class="my-1 mr-5 text-dark font-weight-bold">Show Shipment</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
@endsection
@section('content')
    <style>
        label {
            font-weight: bold !important;
        }

        .select2-container {
            display: block !important;
        }
    </style>
    <form class="form-horizontal" action="" id="kt_form_1" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p>
                        <b>Number Order:</b>
                        {{$orders->id}}
                    </p>
                </div>
                <div class="col-md-4">
                    <p>
                        <b>HWB Number:</b>
                        @php
                            echo str_pad($orders->invoice_number, 6, "0", STR_PAD_LEFT);
                        @endphp
                    </p>
                </div>
                <div class="col-md-4">
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
                                <label>Shipper’s company name</label>
                                <input type="text" placeholder="Shipper’s company name" disabled class="form-control"
                                       value="{{$orders->company_shipper}}"/>
                            </div>
                        </div>
                        @cannot('Client')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Shipper Phone')}}:</label>
                                    <input type="text" placeholder="{{ ('Shipper Phone')}}" disabled
                                           class="form-control" value="{{$orders->phone_shipper}}"/>
                                </div>
                            </div>
                        @endcannot
                        @can('Client')
                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ ('Shipper Phone')}}:</label>
                                        <input type="text" placeholder="{{ ('Shipper Phone')}}" disabled
                                               class="form-control" value="{{$orders->phone_shipper}}"/>
                                    </div>
                                </div>
                            @endif
                        @endcan

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Address')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Address')}}"
                                       disabled class="form-control" value="{{$tracker_start->address}}"/>
                            </div>
                        </div>

                        @cannot('Client')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Post code:</label>
                                    <input type="text" placeholder="Post code" class="form-control" disabled
                                           value="{{$tracker_start->post_code}}"/>
                                </div>
                            </div>
                        @endcannot

                        @can('Client')
                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="red-star">Post code:</label>
                                        <input type="text" placeholder="Post code" class="form-control" disabled
                                               value="{{$tracker_start->post_code}}"/>
                                    </div>
                                </div>
                            @endif
                        @endcan

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Shipper Name')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Name')}}" disabled class="form-control"
                                       value="{{$orders->shipper}}"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Number order:</label>
                                <input type="text" placeholder="Number order" disabled class="form-control"
                                       value="{{$orders->id}}"/>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>HWB number:</label>
                                <input type="text" placeholder="HWB number" disabled class="form-control"
                                       value="@php echo str_pad($orders->invoice_number, 6, "0", STR_PAD_LEFT);
                                       @endphp
                                           "/>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Consignee’s company name</label>
                                <input type="text" placeholder="Consignee’s company name" disabled class="form-control"
                                       value="{{ $orders->company_consignee }}"/>
                            </div>
                        </div>
                        @cannot('Client')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Consignee Phone')}}:</label>
                                    <input type="text" placeholder="{{ ('Consignee Phone')}}" disabled
                                           class="form-control"
                                           value="{{$orders->phone_consignee}}"/>
                                </div>
                            </div>
                        @endcannot
                        @can('Client')
                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ ('Consignee Phone')}}:</label>
                                        <input type="text" placeholder="{{ ('Consignee Phone')}}" disabled
                                               class="form-control"
                                               value="{{$orders->phone_consignee}}"/>
                                    </div>
                                </div>
                            @endif
                        @endcan
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee Address')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Address')}}"
                                       disabled class="form-control" value="{{$tracker_end->address}}"/>
                            </div>
                        </div>

                        @cannot('Client')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Post code:</label>
                                    <input type="text" placeholder="Post code" class="form-control" disabled
                                           value="{{$tracker_end->post_code}}"/>
                                </div>
                            </div>
                        @endcannot

                        @can('Client')
                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="red-star">Post code:</label>
                                        <input type="text" placeholder="Post code" class="form-control" disabled
                                               value="{{$tracker_end->post_code}}"/>
                                    </div>
                                </div>
                            @endif
                        @endcan
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Consignee Name')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Name')}}" disabled class="form-control"
                                       value="{{$orders->consignee}}"/>
                            </div>
                        </div>


                        @cannot('Client')
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ ('Shipment description')}}:</label>
                                    <textarea class="form-control"
                                              disabled>{{ $orders->shipment_description }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pick-up Instruction</label>
                                    <textarea class="form-control" disabled>{{ $orders->comment }}</textarea>
                                </div>
                            </div>
                        @endcannot

                        @can('Client')
                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ ('Shipment description')}}:</label>
                                        <textarea class="form-control"
                                                  disabled>{{ $orders->shipment_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Pick-up Instruction</label>
                                        <textarea class="form-control" disabled>{{ $orders->comment }}</textarea>
                                    </div>
                                </div>
                            @endif
                        @endcan


                        <div class="col-md-6">
                            <div class="form-group fv-plugins-icon-container">
                                <label>Shipping Date:</label>
                                <div class="input-group date">
                                    <input type="text" placeholder="Sending Date" value="{{ $orders->sending_time }}"
                                           disabled autocomplete="off" class="form-control" id="kt_datepicker_3">
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                    </div>
                                </div>
                                <i data-field="sending_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group fv-plugins-icon-container">
                                <label>Delivery Date:</label>
                                <div class="input-group date">
                                    <input type="text" placeholder="Delivery Date" value="{{ $orders->delivery_time }}"
                                           disabled autocomplete="off" class="form-control" id="kt_datepicker_4">
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                    </div>
                                </div>
                                <i data-field="delivery_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <hr>
                <div class="col-lg-12">
                    <div id="kt_repeater_1">
                        <div class="" id="">
                            <h2 class="text-left">{{ ('Package Info')}}:</h2>
                            <div data-repeater-list="Package" class="col-lg-12">
                                @foreach($orders->cargo as $item)
                                    <div data-repeater-item class="row align-items-center"
                                         style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">


                                        @cannot('Client')
                                            <div class="col-md-3">
                                                <label>{{ ('Type')}}:</label>
                                                <input type="text" placeholder="{{ ('type')}}" class="form-control"
                                                       disabled
                                                       value="{{$item['type']}}">
                                                <input type="hidden" name="id" value="{{$item['id']}}">
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                        @endcannot

                                        @can('Client')
                                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)

                                                <div class="col-md-3">
                                                    <label>{{ ('Type')}}:</label>
                                                    <input type="text" placeholder="{{ ('type')}}" class="form-control"
                                                           disabled
                                                           value="{{$item['type']}}">
                                                    <input type="hidden" name="id" value="{{$item['id']}}">
                                                    <div class="mb-2 d-md-none"></div>
                                                </div>
                                            @endif
                                        @endcan

                                        <div class="col-md-3">
                                            <label>Actual weight (kg):</label>
                                            <input placeholder="Actual weight" type="number"
                                                   min="1" step="0.1" disabled class="form-control"
                                                   value="{{$item['actual_weight']}}"/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{ ('Quantity')}}:</label>
                                            <input class="kt_touchspin_qty" placeholder="{{ ('Quantity')}}"
                                                   type="number" min="1" disabled class="form-control"
                                                   value="{{$item['quantity']}}"/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>

                                        @cannot('Client')
                                            <div class="col-md-3">
                                                <label>Serial number box:</label>
                                                <input type="text" placeholder="Serial number" disabled
                                                       class="form-control " value="{{$item['serial_number']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Serial number sensor:</label>
                                                <input type="text" placeholder="Serial number sensor" disabled
                                                       class="form-control  "
                                                       value="{{$item['serial_number_sensor']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>UN number:</label>
                                                <input type="text" placeholder="UN number" disabled
                                                       class="form-control  "
                                                       value="{{$item['un_number']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                        @endcannot

                                        @can('Client')
                                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                                <div class="col-md-3">
                                                    <label>Serial number box:</label>
                                                    <input type="text" placeholder="Serial number" disabled
                                                           class="form-control " value="{{$item['serial_number']}}"/>
                                                    <div class="mb-2 d-md-none"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Serial number sensor:</label>
                                                    <input type="text" placeholder="Serial number sensor" disabled
                                                           class="form-control  "
                                                           value="{{$item['serial_number_sensor']}}"/>
                                                    <div class="mb-2 d-md-none"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>UN number:</label>
                                                    <input type="text" placeholder="UN number" disabled
                                                           class="form-control  "
                                                           value="{{$item['un_number']}}"/>
                                                    <div class="mb-2 d-md-none"></div>
                                                </div>
                                            @endif
                                        @endcan
                                        <div class="col-md-3">
                                            <label>Temperature conditions:</label>
                                            <input type="text" placeholder="Temperature conditions" disabled
                                                   class="form-control  " value="{{$item['temperature_conditions']}}"/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>


                                        @cannot('Client')
                                            <div class="col-md-3">
                                                <label>Volume weight:</label>
                                                <input type="text" placeholder="Volume weight" name="volume_weight"
                                                       disabled
                                                       class="form-control  " value="{{$item['volume_weight']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-12" style="margin-top: 10px;">
                                                <label>{{ ('Dimensions [Length x Width x Height] (cm):')}}:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="dimensions_r" type="number" min="1" class="form-control"
                                                       placeholder="{{ ('Length')}}" disabled
                                                       value="{{$item['сargo_dimensions_length']}}"/>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="dimensions_r" type="number" min="1" class="form-control"
                                                       placeholder="{{ ('Width')}}" disabled
                                                       value="{{$item['сargo_dimensions_width']}}"/>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="dimensions_r" type="number" min="1" class="form-control "
                                                       placeholder="{{ ('Height')}}" disabled
                                                       value="{{$item['сargo_dimensions_height']}}"/>
                                            </div>
                                        @endcannot

                                        @can('Client')
                                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                                <div class="col-md-3">
                                                    <label>Volume weight:</label>
                                                    <input type="text" placeholder="Volume weight" name="volume_weight"
                                                           disabled
                                                           class="form-control  " value="{{$item['volume_weight']}}"/>
                                                    <div class="mb-2 d-md-none"></div>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 10px;">
                                                    <label>{{ ('Dimensions [Length x Width x Height] (cm):')}}:</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="dimensions_r" type="number" min="1"
                                                           class="form-control"
                                                           placeholder="{{ ('Length')}}" disabled
                                                           value="{{$item['сargo_dimensions_length']}}"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="dimensions_r" type="number" min="1"
                                                           class="form-control"
                                                           placeholder="{{ ('Width')}}" disabled
                                                           value="{{$item['сargo_dimensions_width']}}"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input class="dimensions_r" type="number" min="1"
                                                           class="form-control "
                                                           placeholder="{{ ('Height')}}" disabled
                                                           value="{{$item['сargo_dimensions_height']}}"/>
                                                </div>
                                            @endif
                                        @endcan

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="">

                            @cannot('Client')
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" disabled
                                           @if($orders->sensor_for_rent == 'on') checked @endif>
                                    <label class="form-check-label" for="inlineCheckbox1">Sensor for rent</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" disabled
                                           @if($orders->container == 'on') checked @endif>
                                    <label class="form-check-label" for="inlineCheckbox2">Container</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" disabled
                                           @if($orders->return_sensor == 'on') checked @endif>
                                    <label class="form-check-label" for="inlineCheckbox3">Returning the sensor</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" disabled
                                           @if($orders->return_container == 'on') checked @endif>
                                    <label class="form-check-label" for="inlineCheckbox4">Returning a shipping
                                        container</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5" disabled
                                           @if($orders->notifications == 'on') checked @endif>
                                    <label class="form-check-label" for="inlineCheckbox5">Receive notifications</label>
                                </div>
                            @endcannot

                            @can('Client')
                                @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" disabled
                                               @if($orders->sensor_for_rent == 'on') checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">Sensor for rent</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" disabled
                                               @if($orders->container == 'on') checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox2">Container</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" disabled
                                               @if($orders->return_sensor == 'on') checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox3">Returning the
                                            sensor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox4" disabled
                                               @if($orders->return_container == 'on') checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox4">Returning a shipping
                                            container</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox5" disabled
                                               @if($orders->notifications == 'on') checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox5">Receive
                                            notifications</label>
                                    </div>
                                    <div class="form-check">
                                        <label for="inlineCheckbox11"></label><input class="form-check-input"
                                                                                     style="width: 350px;"
                                                                                     placeholder="myemail@mail.com,myemail2@mail.com"
                                                                                     type="text" id="inlineCheckbox11"
                                                                                     disabled
                                                                                     value="{{$orders->email}}">
                                    </div>
                                @endif
                            @endcan
                        </div>

                        @cannot('Client')
                            <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Delivery comment</label>
                                    <textarea class="form-control" disabled>{{$orders->delivery_comment}}</textarea>
                                </div>
                            </div>
                        @endcannot

                        @can('Client')
                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)
                                <hr>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Delivery comment</label>
                                        <textarea class="form-control" disabled>{{$orders->delivery_comment}}</textarea>
                                    </div>
                                </div>
                            @endif
                        @endcan
                        <hr>
                        <div class="">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Shipping Payer:</label>
                                    <input type="text" placeholder="Shipping Payer" class="form-control" disabled
                                           value="{{ $orders->user }}"/>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Status:</label>
                                <input type="text" placeholder="status" class="form-control" disabled
                                       value="{{$orders->status->name }}"/>
                            </div>
                        </div>

                        {{--                        @cannot('Client')--}}
                        {{--                            <hr>--}}
                        {{--                            <div class="">--}}
                        {{--                                <div class="col-md-6" data-select2-id="66">--}}
                        {{--                                    <label>Cargo location:</label>--}}
                        {{--                                    <input type="text" placeholder="Cargo location" class="form-control" disabled--}}
                        {{--                                           value="{{$orders->cargolocation->name }}"/>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        @endcannot--}}

                        {{--                        @can('Client')--}}
                        {{--                            @if($orders->status_id != 6 && $orders->status_id != 7 && $orders->status_id != 9)--}}
                        {{--                                <hr>--}}
                        {{--                                <div class="">--}}
                        {{--                                    <div class="col-md-6" data-select2-id="66">--}}
                        {{--                                        <label>Cargo location:</label>--}}
                        {{--                                        <input type="text" placeholder="Cargo location" class="form-control" disabled--}}
                        {{--                                               value="{{$orders->cargolocation->name }}"/>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            @endif--}}
                        {{--                        @endcan--}}
                        <hr>
                        @cannot('Client')
                            <hr>
                            <div class="">
                                <div class="col-md-6" data-select2-id="66">
                                    <label>Agent:</label>
                                    <input type="text" placeholder="Agent" class="form-control" disabled
                                           value="@php if(isset($orders->agent)){ echo $orders->agent->fullname;} @endphp"/>
                                </div>
                            </div>
                            <hr>
                        @endcan

                        @cannot('Driver')
                            <div class="form-group ">
                                <div class="">
                                    <label class="text-right col-form-label">Print HWB</label>
                                    <div>
                                        <a href="{!! route('admin.download_pdf', $orders->id) !!}"
                                           class="btn btn-sm font-weight-bolder btn-light-primary clear-value-datatime">
                                            HWB
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="">
        <div class="card-body">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-sm font-weight-bolder btn-light-primary">Back</a>
            </div>
        </div>
    </div>
    @canany(['SuperUser','OPS','Manager','Security Officer'],Auth::user())
        <hr>
        <div class="card-body">
            <div>
                <button id="logging" class="btn btn-sm font-weight-bolder btn-light-primary">Logging</button>
            </div>
        </div>
        <div class="">
            <div id="hider" class="col-md-12" data-select2-id="66" hidden>
                <label>Logging:</label>
                @php

                @endphp
                @foreach($logs as $log)
                    @php
                        $change_fields = (array)$change_fields = json_decode($log->properties);
                        if(isset($change_fields['old'])){
                            $old = (array)$change_fields['old'];
                        }
                        if(isset($change_fields['attributes'])){
                            $new = (array)$change_fields['attributes'];

                        }
                    @endphp

                    @if(isset($new))
                        @for($i = 0,$iMax = count($new); $i < $iMax; $i++)

                            <p>{{$log->updated_at->format('d.m.Y - H:i:s') }} -
                                User {{$log->user->name}} {{$log->description}} {{__('activitylog.'.key($new))}} -
                                @if(isset($old))
                                    @php
                                     $shift_old = array_shift($old);
                                    @endphp
                                    @if ($shift_old == null)
                                        Null
                                    @else
                                        {{$shift_old}}
                                    @endif
                                     -
                                @endif  new {{array_shift($new) ?? 'null'}}  </p>
                        @endfor
                    @endif
                    @if($log->description === "deleted" )
                        <b>{{$log->updated_at->format('d.m.Y - H:s:i') }} -
                            User {{$log->user->name}} {{$log->description}} - {{$log->log_name}}  </b>
                    @endif

                @endforeach
            </div>
        </div>
        <hr>
    @endcanany


@endsection
@section('script')
    <script src="{{ static_asset('assets/dashboard/js/geocomplete/jquery.geocomplete.js') }}"></script>
    {{--<script src="//maps.googleapis.com/maps/api/js?libraries=places&key={{$checked_google_map->key}}"></script>--}}
    <script type="text/javascript">
        document.getElementById('logging').onclick = function() {
            if(document.getElementById('hider').hidden == true){
                document.getElementById('hider').hidden = false;
            }
            else
            {
                document.getElementById('hider').hidden = true;
            }
        }

        // Map Address For Receiver
        $('.address-receiver').each(function () {
            var address = $(this);
            address.geocomplete({
                map: ".map_canvas.map-receiver",
                mapOptions: {
                    zoom: 8,
                    center: {lat: -34.397, lng: 150.644},
                },
                markerOptions: {
                    draggable: true
                },
                details: ".location-receiver",
                detailsAttribute: 'data-receiver',
                autoselect: true,
                restoreValueAfterBlur: true,
            });
            address.bind("geocode:dragged", function (event, latLng) {
                $("input[data-receiver=lat]").val(latLng.lat());
                $("input[data-receiver=lng]").val(latLng.lng());
            });
        });
        // Map Address For Client
        $('document').ready(function () {

            if ($('#inlineCheckbox5').is(':checked')) {
                $('#inlineCheckbox11').show(100);
            } else {
                $('#inlineCheckbox11').hide(100);
            }

            $('#inlineCheckbox5').on('click', function () {
                $('p.aletr-email').remove();
                if ($(this).is(':checked')) {
                    $('#inlineCheckbox11').show(100);
                } else {
                    $('#inlineCheckbox11').hide(100);
                }

                var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,7}$/i;

                $('#inlineCheckbox11').blur(function () {
                    $('p.aletr-email').remove();

                    var mail = $('#inlineCheckbox11').val();
                    var mailPattern = pattern.test(mail);
                    var testSeparator = mail.indexOf(',');
                    var mailArray = mail.split(',');

                    console.log(mailArray);
                    console.log(testSeparator);

                    if (mailPattern === false && testSeparator === -1) {
                        $('#inlineCheckbox11').after('<p class="alert alert-danger aletr-email">Вы не поставили запятую между Email</p>');
                    } else {
                        $(mailArray).each(function (index, item) {
                            if (pattern.test(item.trim()) === false) {
                                console.log(pattern.test(item[index].trim()));
                                $('#inlineCheckbox11').after('<p class="alert alert-danger aletr-email">Вы не правильно ввели Email или не поставили запятую между Email</p>');
                            }
                        });
                    }

                });

            });

        });

        // Get Addressess After Select Client
        function selectIsTriggered() {
            getAdressess(document.getElementById("client-id").value);
        }

        function openAddressDiv() {
            $("#show_address_div").slideDown("slow", function () {
                // Animation complete.
            });
        }

        function closeAddressDiv() {
            $("#show_address_div").slideUp("slow", function () {
                // Animation complete.
            });
        }

        var inputs = document.getElementsByTagName('input');
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type.toLowerCase() == 'number') {
                inputs[i].onkeydown = function (e) {
                    if (!((e.keyCode > 95 && e.keyCode < 106) ||
                        (e.keyCode > 47 && e.keyCode < 58) ||
                        e.keyCode == 8)) {
                        return false;
                    }
                }
            }
        }
        $('.select-client').change(function () {
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
                if (select_packages[index].value) {
                    package_ids[index] = new Object();
                    package_ids[index]["package_id"] = select_packages[index].value;
                } else {
                    AIZ.plugins.notify('danger', '{{  ('Please select package type') }} ' + (index + 1));
                    return 0;
                }
            }
            var request_data = {
                _token: '{{ csrf_token() }}',
                package_ids: package_ids,
                total_weight: total_weight,
                from_country_id: from_country_id,
                to_country_id: to_country_id,
                from_state_id: from_state_id,
                to_state_id: to_state_id,
                from_area_id: from_area_id,
                to_area_id: to_area_id,
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
            elements.map(function () {
                sumWeight += parseInt($(this).val());
                console.log(sumWeight);
            }).get();
            $('.total-weight').val(sumWeight);
        }

        function deleteCargo(elem, deleteElement) {
            var cargo_id = $(elem).find('input[type="hidden"]').val();
            var order_id = $("#order").val();
            if (confirm('Удалять?')) {
                $.ajax({
                    url: '/admin/orders/remove-cargo',
                    type: "POST",
                    data: {
                        cargo: cargo_id,
                        order: order_id
                    },
                    success: function (response) {
                        $(this).slideUp(deleteElement);
                    }
                })
            }
        }

        function deleteTracker(elem, deleteElement) {
            var tracker_id = $(elem).find('input[type="hidden"]').val();
            // var order_id = $("#order").val();
            if (confirm('Удалять?')) {
                console.log(tracker_id);
                $.ajax({
                    url: '/admin/tracker/remove-tracker',
                    type: "POST",
                    data: {
                        tracker: tracker_id,
                    },
                    success: function (response) {
                        $(this).slideUp(deleteElement);
                    }
                })
            }
        }

        $(document).ready(function () {

            $('#select1').change(function () {
                var val = $(this).val();
                // console.log(val);
                //если элемент с id равным значению #select1 существует
                if (val == '3') {
                    $('#step2 select').hide();
                    $('#' + val).show();
                    $('#3').removeAttr('name').attr('name', 'substatus_id');
                    $('#4').removeAttr('name')
                } else if (val == '4') {
                    $('#step2 select').hide();
                    $('#' + val).show();
                    $('#4').removeAttr('name').attr('name', 'substatus_id');
                    $('#3').removeAttr('name')
                } else if (val != 'select2_1' || val != 'select2_2') {
                    $('#step2 select').hide();
                }
                if ($('#select1').val() == 4) {
                    $('.tracker_append').append($('<label>Signed:</label><input placeholder="Signed" type="text" name="signed" class="form-control " value="{{$tracker_end->signed}}"/><div class="mb-2 d-md-none"></div>'));
                }

            })
            if ($('#select1 :selected').val() == 3) {
                $('#3').show();
                $('#4').removeAttr('name')
            }
            if ($('#select1 :selected').val() == 4) {
                $('#4').show();
                $('#3').removeAttr('name');
            }


            if ($('#select1').val() == 4) {
                $('.tracker_append').append($('<label>Signed:</label><input placeholder="Signed" type="text" name="signed" class="form-control" value="{{$tracker_end->signed}}"/><div class="mb-2 d-md-none"></div>'));
            }
            $('#select2').change(function () {

                let option2 = $('option:selected', this).attr('data-id');
                $('#city').val(option2);
            })

            $('#actual_time').on('input', function () {
                $('#actual_time_start input').attr("required", "required");
            })
            $('#actual-time-end').on('input', function () {
                $('#actual-time-end-signed input').attr("required", "required");
            })

            $('.select-country').select2({
                placeholder: "Select country",
                language: {
                    noResults: function () {
                        {{--                @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                        {{--                    return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.shipments.covered_countries')}}?redirect=admin.shipments.create"--}}
                        {{--                    class="btn btn-primary" >Manage {{ ('Countries')}}</a>--}}
                        {{--                    </li>`;--}}
                        {{--                @else--}}
                        {{--                    return ``;--}}
                        {{--                @endif--}}
                    },
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
            });
            $('.select-state').select2({
                placeholder: "Select state",
                language: {
                    noResults: function () {
                        {{--                @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                        {{--                    return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.shipments.covered_countries')}}?redirect=admin.shipments.create"--}}
                        {{--                    class="btn btn-primary" >Manage {{ ('States')}}</a>--}}
                        {{--                    </li>`;--}}
                        {{--                @else--}}
                        {{--                    return ``;--}}
                        {{--                @endif--}}
                    },
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
            });
            $('.select-address').select2({
                placeholder: "Select Client First",
            })
            $('.select-area').select2({
                placeholder: "Select Area",
                language: {
                    noResults: function () {
                        {{--                @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                        {{--                    return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.areas.create')}}?redirect=admin.shipments.create"--}}
                        {{--                    class="btn btn-primary" >Manage {{ ('Areas')}}</a>--}}
                        {{--                    </li>`;--}}
                        {{--                @else--}}
                        {{--                    return ``;--}}
                        {{--                @endif--}}
                    },
                },
                escapeMarkup: function (markup) {
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
            $(document).ready(function () {
                $('.package-type-select').select2({
                    placeholder: "Package Type",
                    language: {
                        noResults: function () {
                            {{--                    @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                            {{--                        return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.packages.create')}}?redirect=admin.shipments.create"--}}
                            {{--                        class="btn btn-primary" >Manage {{ ('Packages')}}</a>--}}
                            {{--                        </li>`;--}}
                            {{--                    @else--}}
                            {{--                        return ``;--}}
                            {{--                    @endif--}}
                        },
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                });
            });
            //Package Types Repeater
            $('#kt_repeater_1').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                    $('.package-type-select').select2({
                        placeholder: "Package Type",
                        language: {
                            noResults: function () {
                                {{--                        @if($user_type == 'admin' || in_array('1105', $staff_permission) )--}}
                                {{--                            return `<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.packages.create')}}?redirect=admin.shipments.create"--}}
                                {{--                            class="btn btn-primary" >Manage {{ ('Packages')}}</a>--}}
                                {{--                            </li>`;--}}
                                {{--                        @else--}}
                                {{--                            return ``;--}}
                                {{--                        @endif--}}
                            },
                        },
                        escapeMarkup: function (markup) {
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
                        min: 0.1,
                        max: 1000000000,
                        stepinterval: 50,
                        maxboostedstep: 10000000,
                        step: 0.1,
                    });
                    $('.kt_touchspin_qty').TouchSpin({
                        buttondown_class: 'btn btn-secondary',
                        buttonup_class: 'btn btn-secondary',
                        min: 0.1,
                        max: 1000000000,
                        stepinterval: 50,
                        maxboostedstep: 10000000,
                        initval: 0.1,
                    });
                    calcTotalWeight();
                },
                hide: function (deleteElement) {
                    deleteCargo(this, deleteElement);
                }
            });


            $('#kt_repeater_12').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                },
                hide: function (deleteElement) {
                    deleteTracker(this, deleteElement);
                }
            });
            $('.tracker-block-delete').remove();

            $('body').on('click', '.delete_item', function () {
                $('.total-weight').val("{{ ('Calculated...')}}");
                setTimeout(function () {
                    calcTotalWeight();
                }, 500);
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
                min: 0.1,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                initval: 0.1,
                step: 0.1,
            });
            $('.kt_touchspin_qty').TouchSpin({
                buttondown_class: 'btn btn-secondary',
                buttonup_class: 'btn btn-secondary',
                min: 0.1,
                max: 1000000000,
                stepinterval: 50,
                maxboostedstep: 10000000,
                initval: 0.1,
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
        });
    </script>
@endsection
