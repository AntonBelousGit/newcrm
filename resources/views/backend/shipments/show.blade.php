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


    <form class="form-horizontal" action="" id="kt_form_1"  enctype="multipart/form-data">
         <div class="card-body">
            <div class="row">
                <div class="col-lg-12">

                    <hr>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ ('Shipper Name')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Name')}}" disabled class="form-control"  value="{{$orders->shipper}}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ ('Shipper Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Phone')}}" disabled class="form-control" value="{{$orders->phone_shipper}}"/>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Shipper Address')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Address')}}" disabled class="form-control" value="{{$orders->address_shipper}}" />

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Company Shipper')}}:</label>
                                <input type="text" placeholder="{{ ('Company Shipper')}}" disabled class="form-control" value="{{$orders->company_shipper}}" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Number order:</label>
                                <input type="text" placeholder="Number order" disabled class="form-control"  value="{{$orders->id}}" />

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ ('Invoce number')}}:</label>
                                <input type="text" placeholder="{{ ('Invoce number')}}" disabled class="form-control" value="@php echo str_pad($orders->invoice_number, 6, "0", STR_PAD_LEFT);
                                @endphp
                                    "/>

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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Consignee Address')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Address')}}" name="address_consignee" disabled class="form-control" value="{{$orders->address_consignee}}"/>

                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Company Consignee')}}:</label>
                                <input type="text" placeholder="{{ ('Company Consignee')}}" disabled class="form-control" value="{{ $orders->company_consignee }}" />

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Shipment description')}}:</label>
                                <textarea class="form-control" disabled>{{ $orders->shipment_description }}</textarea>
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
                            <h2 class="text-left">{{ ('Package Info')}}:</h2>
                            <div data-repeater-list="Package" class="col-lg-12">
                                @foreach($orders->cargo as $item)
                                    <div data-repeater-item class="row align-items-center" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">

                                        <div class="col-md-3">
                                            <label>{{ ('Type')}}:</label>
                                            <input type="text" placeholder="{{ ('type')}}" class="form-control" disabled value="{{$item['type']}}">
                                            <input type="hidden" name="id" value="{{$item['id']}}">
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Actual weight:</label>
                                            <input class="kt_touchspin_qty" placeholder="Actual weight" type="number" min="1" disabled  class="form-control" value="{{$item['actual_weight']}}" />
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
                                            <input type="text"  placeholder="Temperature conditions" name="volume_weight" disabled class="form-control  "  value="{{$item['volume_weight']}}" />
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


                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" disabled @if($orders->sensor_for_rent == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox1">Sensor for rent</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" disabled @if($orders->container == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox2">Container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" disabled @if($orders->return_sensor == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox3">Returning the sensor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" disabled @if($orders->return_container == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox4">Returning a shipping container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" disabled  @if($orders->notifications == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox5">Receive notifications</label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Delivery comment</label>
                                <textarea class="form-control" disabled >{{$orders->delivery_comment}}</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Shipping Payer:</label>
                                    <input type="text" placeholder="Shipping Payer" class="form-control" disabled value="{{ $orders->user }}" />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Status:</label>
                                <input type="text" placeholder="status"  class="form-control" disabled value="{{$orders->status->name }}" />
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Cargo location:</label>
                                <input type="text" placeholder="Cargo location" class="form-control" disabled value="{{$orders->cargolocation->name }}" />
                            </div>
                        </div>
                        <hr>
                        <hr>
                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Agent:</label>
                                <input type="text" placeholder="Cargo location" class="form-control" disabled value="{{$orders->agent->fullname}}" />
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Driver:</label>
                                <input type="text" placeholder="Cargo location" class="form-control" disabled value="{{$orders->driver->fullname}}" />
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>


            </div>
        </div>

    </form>
    <div class="">
        <div class="card-body">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-sm font-weight-bolder btn-light-primary" >Back</a>
            </div>
        </div>
    </div>

@endsection

