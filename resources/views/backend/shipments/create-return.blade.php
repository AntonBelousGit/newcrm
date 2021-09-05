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


    <form class="form-horizontal" action="{{route('admin.orders.store-return-job')}}" id="kt_form_1" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">

                    <hr>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">Shipper’s company name</label>
                                <input type="text" placeholder="Shipper’s company name" name="company_consignee" class="form-control" required value="{{old('company_shipper')}}" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Phone')}}" name="phone_consignee" class="form-control" required value="{{old('phone_shipper')}}"/>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Address')}}:</label>
                                <input type="text" placeholder="City, street, " name="address_consignee" class="form-control" required value="{{old('address_shipper')}}" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper City')}}:</label>
                                <select class="form-control kt-select2 delivery-time" id="consignee_address" name="shipper_address_id" required>
                                    @foreach($cargo_location as $location)
                                        <option value="{{$location->id}}">{{ $location->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">Post code:</label>
                                <input type="text" placeholder="Post code" name="consignee_postcode" class="form-control" required value="{{old('consignee_postcode')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Name')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Name')}}" name="consignee" class="form-control" required value="{{old('shipper')}}" />
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">Consignee’s company name</label>
                                <input type="text" placeholder="Consignee’s company name" name="company_shipper" class="form-control" required value="{{old('company_consignee')}}" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Phone')}}" name="phone_shipper" class="form-control" required value="{{old('phone_consignee')}}" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee Address')}}:</label>
                                <input type="text" placeholder="City, street" name="address_shipper" class="form-control" required value="{{old('address_consignee')}}"  />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee City')}}:</label>
                                <select class="form-control kt-select2 delivery-time" id="shipper_address" name="consignee_address_id" required>
                                    @foreach($cargo_location as $location)
                                        <option value="{{$location->id}}">{{ $location->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">Post code:</label>
                                <input type="text" placeholder="Post code" name="shipper_postcode" class="form-control" required value="{{old('shipper_postcode')}}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee Name')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Name')}}" name="shipper" class="form-control" required value="{{old('consignee')}}" />

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Shipment description')}}:</label>
                                <textarea class="form-control" name="shipment_description">{{old('shipment_description')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pick-up Instruction</label>
                                <textarea class="form-control" name="comment">{{old('comment')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="red-star">Parent order HWB</label>
                                <select class="form-control kt-select2 delivery-time" id="shipper_address" name="parent_id" required>
                                    @foreach($parentOrder as $item)
                                        <option value="{{$item->id}}">
                                            @php
                                                echo str_pad($item->invoice_number, 6, "0", STR_PAD_LEFT);
                                            @endphp
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="red-star">Client</label>
                                <select class="form-control kt-select2 delivery-time" id="shipper_address" name="client_id" required>
                                    @foreach($users as $item)
                                        <option value="{{$item->id}}">{{ $item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="red-star">Shipping Payer:</label>
                                {{--                                    @dd(Auth::user()->roles->first()->id)--}}
                                <select id="change-country-to" name="payer_id" class="form-control  kt-select2 delivery-time"   >

                                    @if ( Auth::user()->roles->first()->id == 8)
                                        @foreach(Auth::user()->payer as $item)
                                            <option value="{{$item->id}}" >{{$item->customer_name}}</option>
                                        @endforeach
                                    @else
                                        @foreach($payers as $item)
                                            <option value="{{$item->id}}" >{{$item->customer_name}}</option>
                                        @endforeach
                                    @endif
                                </select>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group fv-plugins-icon-container">
                                <label class="red-star">Shipping Date:</label>
                                <div class="input-group date">
                                    <input  placeholder="Start time" type="datetime-local" name="sending_time" class="form-control" value=""/>
                                </div><i data-field="sending_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div>
                                <div class="input-group date">
                                    <input  placeholder="Start time" type="datetime-local" name="sending_time_stop" class="form-control" value=""/>
                                </div><i data-field="sending_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group fv-plugins-icon-container">
                                <label class="red-star">Delivery Date:</label>
                                <div class="input-group date">
                                    <input  placeholder="Start time" type="datetime-local" name="delivery_time" class="form-control" value=""/>
                                </div>
                                <i data-field="delivery_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div>
                                <div class="input-group date">
                                    <input  placeholder="Start time" type="datetime-local" name="delivery_time_stop" class="form-control" value=""/>
                                </div><i data-field="delivery_time" class="fv-plugins-icon"></i>
                                <div class="fv-plugins-message-container"></div>
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>

                <hr>
                <div class="col-lg-12">
                    <div id="kt_repeater_1">
                        <div class="" >
                            <h2 class="text-left">{{ ('Package Info')}}:</h2>
                            <div data-repeater-list="Package" class="col-lg-12">
                                <div data-repeater-item class="row align-items-center" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">



                                    <div class="col-md-3">
                                        <label class="red-star">{{ ('Type')}}:</label>
                                        <input type="text" placeholder="{{ ('type')}}" class="form-control" name="type" required>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="red-star">Actual weight (kg):</label>
                                        <input class="kt_touchspin_qty" placeholder="Actual weight" type="number" min="1" step="0.1" name="actual_weight" class="form-control" value="1"  required/>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="red-star">{{ ('Quantity')}}:</label>
                                        <input class="kt_touchspin_qty" placeholder="{{ ('Quantity')}}" type="number" min="1 " name="quantity" class="form-control" value="1" required/>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>

                                    <div class="col-md-3">

                                        <label>Serial number box:</label>

                                        <input type="text"  placeholder="Serial number" name="serial_number" class="form-control "  value="" />
                                        <div class="mb-2 d-md-none"></div>

                                    </div>
                                    <div class="col-md-3">

                                        <label>Serial number sensor:</label>

                                        <input type="text"  placeholder="Serial number sensor" name="serial_number_sensor" class="form-control  "  value="" />
                                        <div class="mb-2 d-md-none"></div>

                                    </div>
                                    <div class="col-md-3">

                                        <label>UN number:</label>

                                        <input type="text"  placeholder="UN number" name="un_number" class="form-control  "  value="" />
                                        <div class="mb-2 d-md-none"></div>

                                    </div>
                                    <div class="col-md-3">

                                        <label class="red-star">Temperature conditions:</label>

                                        <input type="text"  placeholder="Temperature conditions" required name="temperature_conditions" class="form-control  "  value="1" />
                                        <div class="mb-2 d-md-none"></div>

                                    </div>

                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <label class="red-star">Dimensions [Length x Width x Height] (cm):</label>
                                    </div>
                                    <div class="col-md-3">

                                        <input class="dimensions_r" type="number" min="1" class="form-control" required placeholder="{{ ('Length')}}" name="сargo_dimensions_length" value="1" />

                                    </div>
                                    <div class="col-md-3">

                                        <input class="dimensions_r" type="number" min="1" class="form-control" required placeholder="{{ ('Width')}}" name="сargo_dimensions_width" value="1" />

                                    </div>
                                    <div class="col-md-3">

                                        <input class="dimensions_r" type="number" min="1" class="form-control " required placeholder="{{ ('Height')}}" name="сargo_dimensions_height" value="1" />

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div>
                                                <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger delete_item">
                                                    <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

                        <hr>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox7" name="my_container">
                                <label class="form-check-label" for="inlineCheckbox7">My container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox6" name="my_sensor">
                                <label class="form-check-label" for="inlineCheckbox6">My sensor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="sensor_for_rent">
                                <label class="form-check-label" for="inlineCheckbox1">Sensor for rent</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="container">
                                <label class="form-check-label" for="inlineCheckbox2">Container for rent</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="notifications">
                                <label class="form-check-label" for="inlineCheckbox5">Receive notifications</label>
                            </div>
                            <div class="form-check">
                                <label for="inlineCheckbox11"></label><input class="form-check-input" type="email" placeholder="myemail@mail.com,myemail2@mail.com"  id="inlineCheckbox11" name="email">
                            </div>
                            <div class="form-check"></div>
                            <div class="form-check"></div>
                            <div class="form-check"></div>
                            <div class="form-check"></div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Delivery Instruction</label>
                                <textarea class="form-control" name="delivery_comment"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            {{--                            <div class="col-md-6" data-select2-id="66">--}}
                            {{--                                    <label>Shipping Payer:</label>--}}
                            {{--                                    <select id="change-country-to" name="user_id" class="form-control " required>--}}
                            {{--                                        <option value="">----</option>--}}
                            {{--                                        @foreach($user as $item)--}}
                            {{--                                        <option value="{{$item->id}}">{{$item->email}}</option>--}}
                            {{--                                        @endforeach--}}
                            {{--                                    </select>--}}
                            {{--                            </div>--}}

                        </div>

                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-md-6">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label>{{ ('Delivery Time')}}:</label>--}}
                        {{--                                    <select class="form-control kt-select2 delivery-time" id="delivery_time" name="Shipment[delivery_time]">--}}
                        {{--                                            @foreach($deliveryTimes as $deliveryTime)--}}
                        {{--                                                <option value="{{$deliveryTime->name}}">{{ ($deliveryTime->name)}}</option>--}}
                        {{--                                            @endforeach--}}
                        {{--                                    </select>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-6">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label>{{ ('Total Weight')}}:</label>--}}
                        {{--                                    <input id="kt_touchspin_4" placeholder="{{ ('Total Weight')}}" type="text" min="1" class="form-control total-weight" value="1" name="Shipment[total_weight]" />--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="form-group ">
                            <div class="">
                                <div>
                                    <input type="submit" class="btn btn-sm font-weight-bolder btn-light-primary" value="Save">
                                </div>
                            </div>
                        </div>
                        {{--                    </div>--}}
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
        $('document').ready(function(){

            if($('#inlineCheckbox5').is(':checked')){
                $('#inlineCheckbox11').show(100);
            }else{
                $('#inlineCheckbox11').hide(100);
            }

            $('#inlineCheckbox5').on('click', function(){
                $('p.aletr-email').remove();
                if ($(this).is(':checked')){
                    $('#inlineCheckbox11').show(100);
                } else {
                    $('#inlineCheckbox11').hide(100);
                }

                var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,7}$/i;

                $('#inlineCheckbox11').blur(function(){
                    $('p.aletr-email').remove();

                    var mail = $('#inlineCheckbox11').val();
                    var mailPattern = pattern.test(mail);
                    var testSeparator = mail.indexOf(',');
                    var mailArray = mail.split(',');

                    console.log(mailArray);
                    console.log(testSeparator);

                    if(mailPattern === false && testSeparator === -1){
                        $('#inlineCheckbox11').after('<p class="alert alert-danger aletr-email">Вы не поставили запятую между Email</p>');
                    }else{
                        $(mailArray).each(function(index,item){
                            if(pattern.test(item.trim()) === false){
                                console.log(pattern.test(item[index].trim()));
                                $('#inlineCheckbox11').after('<p class="alert alert-danger aletr-email">Вы не правильно ввели Email или не поставили запятую между Email</p>');
                            }
                        });
                    }

                });

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

        {{--$('.select-client').select2({--}}
        {{--        placeholder: "Select Client",--}}
        {{--    })--}}
        {{--@if($user_type == 'admin' || in_array('1005', $staff_permission) )--}}
        {{--    .on('select2:open', () => {--}}
        {{--        $(".select2-results:not(:has(a))").append(`<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{route('admin.clients.create')}}?redirect=admin.shipments.create"--}}
        {{--            class="btn btn-primary" >+ {{ ('Add New Client')}}</a>--}}
        {{--            </li>`);--}}
        {{--    });--}}
        {{--@endif--}}

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
                    $(this).slideUp(deleteElement);
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
        });
    </script>
@endsection
