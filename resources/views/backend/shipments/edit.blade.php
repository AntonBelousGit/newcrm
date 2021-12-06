@extends('backend.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://api.visicom.ua/apps/visicom-autocomplete.min.css">
@endsection
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
@section('content')
    <style>
        label {
            font-weight: bold !important;
        }

        .select2-container {
            display: block !important;
        }
    </style>
    <form class="form-horizontal" action="{{route('admin.orders.update',$orders->id)}}" autocomplete="off"
          id="kt_form_1" method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row" id="qwert">
                <div class="col-md-2">
                    <p>
                        <b>Number Order:</b>
                        {{$orders->id}}
                    </p>
                </div>
                <div class="col-md-2">
                    <p>
                        <b>HWB Number:</b>
                        @php
                            echo str_pad($orders->invoice_number, 6, "0", STR_PAD_LEFT);
                        @endphp
                    </p>
                </div>
                <div class="col-md-2">
                    <p>
                        <label>Client HWB:</label>
                        <input class="form-control" type="text" name="client_hwb"
                               @if(in_array($orders->status_id,[6,7,9,10])) readonly
                               @endif value="{{$orders->client_hwb}}">
                    </p>
                </div>
                <div class="col-md-2">
                    <p>
                        <b>Status:</b>
                        @include('backend.shipments.components.edit.status')
                    </p>
                </div>
                <div class="col-md-2">
                    <p>
                        <b>Next Routing Point:</b>
                        @include('backend.shipments.components.edit.next_point')
                    </p>
                </div>
                <div class="col-md-2">
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
                                <label class="red-star">{{ ('Shipper`s company name')}}:</label>
                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                       @endif placeholder="{{ ('Shipper company name')}}" name="company_shipper"
                                       autocomplete="off"
                                       required class="form-control" value="{{$orders->company_shipper}}"/>
                            </div>
                        </div>
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <table id="table_id">
                                            <thead>
                                            <tr>
                                                <th>Shipper Address</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($addresses as $address)
                                                <tr>
                                                    <td class="item-table">{{$address->address}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog"
                             aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <table id="table_id2">
                                            <thead>
                                            <tr>
                                                <th>Consignee Address</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($addresses as $address)
                                                <tr>
                                                    <td class="item-table2">{{$address->address}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Phone')}}" autocomplete="off"
                                       @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                       @endif  name="phone_shipper" required
                                       class="form-control" value="{{$orders->phone_shipper}}"/>

                            </div>
                        </div>

                        @if(!in_array($orders->status_id,[6,7,9,10]))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper Address')}}:</label>
                                    <div class="marker">
                                        <div class="visicom-autocomplete" id="visicom-autocomplete">
                                            <a href="https://api.visicom.ua/" target="_blank">© Visicom</a>
                                        </div>
                                        <button type="button" class='btn-marker' data-toggle="modal"
                                                data-target=".bd-example-modal-lg">
										<span class="btn-marker-text">
											Address
										</span>
                                            <i class="fas fa-map-marked-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper APC')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" autocomplete="off"
                                            id="shipper_address" name="shipper_address_id" required>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}"
                                                    @if($tracker_start->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Post code:</label>
                                    <input type="text" placeholder="Post code" id="postal_code" name="shipper_postcode"
                                           autocomplete="off" class="form-control" required
                                           value="{{$tracker_start->post_code}}"/>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Shipper Address')}}" id="autocomplete" disabled
                                           autocomplete="off" class="form-control" value="{{$tracker_start->address}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Shipper APC')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" id="shipper_address" disabled
                                            autocomplete="off">
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}"
                                                    @if($tracker_start->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Post code:</label>
                                    <input type="text" placeholder="Post code" id="postal_code" class="form-control"
                                           disabled
                                           autocomplete="off"
                                           value="{{$tracker_start->post_code}}"/>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Shipper Name')}}:</label>
                                <input type="text" placeholder="{{ ('Shipper Name')}}" name="shipper" autocomplete="off"
                                       @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif   required
                                       class="form-control" value="{{$orders->shipper}}"/>
                                <input type="hidden" id="order" value="{{$orders->id}}">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="direct_to_person_shipper"
                                       @if($addInfo->direct_to_person_shipper === 'on') checked
                                       @endif  @if(in_array($orders->status_id,[6,7,9,10])) disabled @endif>
                                <label>Direct to person:</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site Number :</label>
                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                       @endif  name="site_shipper"
                                       autocomplete="off"
                                       class="form-control" value="{{$orders->site_shipper}}"/>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Additional shipper contact:</label>
                                <textarea type="text" name="additional_shipper_contact" class="form-control"
                                          autocomplete="off"
                                          @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif>{{$addInfo->additional_shipper_contact}}</textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee`s company name')}}:</label>
                                <input type="text" placeholder="{{ ('Company Consignee')}}"
                                       @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                       @endif name="company_consignee"
                                       autocomplete="off"
                                       required class="form-control" value="{{ $orders->company_consignee }}"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee Phone')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Phone')}}" required
                                       @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif
                                       name="phone_consignee" class="form-control" autocomplete="off"
                                       value="{{$orders->phone_consignee}}"/>

                            </div>
                        </div>
                        @if(!in_array($orders->status_id,[6,7,9,10]))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">{{ ('Consignee Address')}}:</label>
                                    <div class="marker">
                                        <div class="visicom-autocomplete2" id="visicom-autocomplete2">
                                            <a href="https://api.visicom.ua/" target="_blank">© Visicom</a>
                                        </div>
                                        <button type="button" class='btn-marker' data-toggle="modal"
                                                data-target=".bd-example-modal-lg2">
										<span class="btn-marker-text">
											Address
										</span>
                                            <i class="fas fa-map-marked-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Consignee APC:</label>
                                    <select class="form-control kt-select2 delivery-time" autocomplete="off"
                                            id="consignee_address"
                                            name="consignee_address_id" required>
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}"
                                                    @if($tracker_end->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Post code:</label>
                                    <input type="text" placeholder="Post code" id="postal_code2"
                                           name="consignee_postcode"
                                           autocomplete="off"
                                           class="form-control" required value="{{$tracker_end->post_code}}"/>
                                </div>
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Consignee Address')}}:</label>
                                    <input type="text" placeholder="{{ ('Consignee Address')}}" id="autocomplete2"
                                           class="form-control"
                                           autocomplete="off"
                                           disabled value="{{$tracker_end->address}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ ('Shipper APC')}}:</label>
                                    <select class="form-control kt-select2 delivery-time" id="shipper_address" disabled
                                            autocomplete="off">
                                        @foreach($cargo_location as $location)
                                            <option value="{{$location->id}}"
                                                    @if($tracker_end->location_id == $location->id) selected @endif>{{ $location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Post code:</label>
                                    <input type="text" placeholder="Post code" class="form-control" id="postal_code2"
                                           disabled
                                           autocomplete="off"
                                           value="{{$tracker_end->post_code}}"/>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="red-star">{{ ('Consignee Name')}}:</label>
                                <input type="text" placeholder="{{ ('Consignee Name')}}"
                                       @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif  required
                                       name="consignee"
                                       autocomplete="off"
                                       class="form-control" value="{{$orders->consignee}}"/>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="direct_to_person_consignee"
                                       @if($addInfo->direct_to_person_consignee === 'on') checked
                                       @endif  @if(in_array($orders->status_id,[6,7,9,10])) disabled @endif>
                                <label>Direct to person:</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site Number :</label>
                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                       @endif  name="site_consignee"
                                       autocomplete="off"
                                       class="form-control" value="{{$orders->site_consignee}}"/>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Additional consignee contact:</label>
                                <textarea type="text" name="additional_consignee_contact" class="form-control"
                                          autocomplete="off"
                                          @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif>{{$addInfo->additional_consignee_contact}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ ('Shipment description')}}:</label>
                                <textarea class="form-control" @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                          @endif
                                          name="shipment_description"
                                          autocomplete="off">{{ $orders->shipment_description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pick-up Instruction</label>
                                <textarea class="form-control" @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                          @endif  name="comment" autocomplete="off">{{ $orders->comment }}</textarea>
                            </div>
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
                                @if (count($orders->cargo)>0)
                                    @foreach($orders->cargo as $item)
                                        <div data-repeater-item class="row align-items-center"
                                             style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                            <div class="col-md-3">
                                                <label class="red-star">{{ ('Type')}}:</label>
                                                <input type="text" placeholder="{{ ('type')}}" class="form-control"
                                                       required
                                                       autocomplete="off"
                                                       name="type" @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif  value="{{$item['type']}}">
                                                <input type="hidden" name="id"
                                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif value="{{$item['id']}}">
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="red-star">Actual weight (kg):</label>
                                                <input
                                                    {{--                                                class="kt_touchspin_weight"--}}
                                                    placeholder="Actual weight" type="number"
                                                    required @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                    @endif  min="1"
                                                    step="0.1"
                                                    name="actual_weight" class="form-control" autocomplete="off"
                                                    value="{{$item['actual_weight']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="red-star">{{ ('Quantity')}}:</label>
                                                <input class="kt_touchspin_qty" placeholder="{{ ('Quantity')}}" required
                                                       type="number"
                                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif  min="1"
                                                       name="quantity" class="form-control" autocomplete="off"
                                                       value="{{$item['quantity']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Serial number box:</label>
                                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif  placeholder="Serial number" name="serial_number"
                                                       autocomplete="off"
                                                       class="form-control " value="{{$item['serial_number']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Serial number sensor:</label>
                                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif  placeholder="Serial number sensor" autocomplete="off"
                                                       name="serial_number_sensor" class="form-control  "
                                                       value="{{$item['serial_number_sensor']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>UN number:</label>
                                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif  placeholder="UN number" name="un_number"
                                                       autocomplete="off"
                                                       class="form-control  " value="{{$item['un_number']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="red-star">Temperature conditions:</label>
                                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif  placeholder="Temperature conditions"
                                                       name="temperature_conditions" required class="form-control  "
                                                       autocomplete="off"
                                                       value="{{$item['temperature_conditions']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Volume weight:</label>
                                                <input type="text" @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       @endif  placeholder="Volume weight" name="volume_weight"
                                                       autocomplete="off"
                                                       disabled class="form-control  "
                                                       value="{{$item['volume_weight']}}"/>
                                                <div class="mb-2 d-md-none"></div>
                                            </div>
                                            <div class="col-md-12" style="margin-top: 10px;">
                                                <label
                                                    class="red-star">{{ ('Dimensions [Length x Width x Height] (cm)')}}
                                                    :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="dimensions_r"
                                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       autocomplete="off"
                                                       @endif  type="number" min="1" required
                                                       class="form-control" placeholder="{{ ('Length')}}"
                                                       name="сargo_dimensions_length"
                                                       value="{{$item['сargo_dimensions_length']}}"/>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="dimensions_r"
                                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       autocomplete="off"
                                                       @endif  type="number" min="1" required
                                                       class="form-control" placeholder="{{ ('Width')}}"
                                                       name="сargo_dimensions_width"
                                                       value="{{$item['сargo_dimensions_width']}}"/>
                                            </div>
                                            <div class="col-md-3">
                                                <input class="dimensions_r"
                                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                                       autocomplete="off"
                                                       @endif  type="number" min="1" required
                                                       class="form-control " placeholder="{{ ('Height')}}"
                                                       name="сargo_dimensions_height"
                                                       value="{{$item['сargo_dimensions_height']}}"/>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div>
                                                        <a href="javascript:;" data-repeater-delete=""
                                                           onclick="//deleteCargo(this)"
                                                           class="btn btn-sm font-weight-bolder btn-light-danger delete_item">
                                                            <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div data-repeater-item class="row align-items-center tracker-block-delete"
                                         style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                        <div class="col-md-3">
                                            <label class="red-star">{{ ('Type')}}:</label>
                                            <input type="text" placeholder="{{ ('type')}}" class="form-control"
                                                   required
                                                   autocomplete="off"
                                                   name="type" >
                                            <input type="hidden" name="id">
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="red-star">Actual weight (kg):</label>
                                            <input
                                                {{--                                                class="kt_touchspin_weight"--}}
                                                placeholder="Actual weight" type="number"
                                                required  min="1"
                                                step="0.1"
                                                name="actual_weight" class="form-control" autocomplete="off"
                                            />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="red-star">{{ ('Quantity')}}:</label>
                                            <input class="kt_touchspin_qty" placeholder="{{ ('Quantity')}}" required
                                                   type="number"
                                                    min="1"
                                                   name="quantity" class="form-control" autocomplete="off"
                                                   />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Serial number box:</label>
                                            <input type="text"   placeholder="Serial number" name="serial_number"
                                                   autocomplete="off"
                                                   class="form-control " />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Serial number sensor:</label>
                                            <input type="text" placeholder="Serial number sensor" autocomplete="off"
                                                   name="serial_number_sensor" class="form-control  "
                                                   />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>UN number:</label>
                                            <input type="text"  placeholder="UN number" name="un_number"
                                                   autocomplete="off"
                                                   class="form-control  " value=""/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="red-star">Temperature conditions:</label>
                                            <input type="text"  placeholder="Temperature conditions"
                                                   name="temperature_conditions" required class="form-control  "
                                                   autocomplete="off"
                                                   />
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Volume weight:</label>
                                            <input type="text" placeholder="Volume weight" name="volume_weight"
                                                   autocomplete="off"
                                                   disabled class="form-control  "
                                                   value=""/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 10px;">
                                            <label
                                                class="red-star">{{ ('Dimensions [Length x Width x Height] (cm)')}}
                                                :</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r"
                                                   type="number" min="1" required
                                                   class="form-control" placeholder="{{ ('Length')}}"
                                                   name="сargo_dimensions_length"
                                                   />
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r"
                                                    type="number" min="1" required
                                                   class="form-control" placeholder="{{ ('Width')}}"
                                                   name="сargo_dimensions_width"
                                                   />
                                        </div>
                                        <div class="col-md-3">
                                            <input class="dimensions_r"
                                                     type="number" min="1" required
                                                   class="form-control " placeholder="{{ ('Height')}}"
                                                   name="сargo_dimensions_height"
                                                  />
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <a href="javascript:;" data-repeater-delete=""
                                                       onclick="//deleteCargo(this)"
                                                       class="btn btn-sm font-weight-bolder btn-light-danger delete_item">
                                                        <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="">
                                <label class="text-right col-form-label">{{ ('Add')}}</label>
                                <div>
                                    <a href="javascript:;" data-repeater-create=""
                                       class="btn btn-sm font-weight-bolder btn-light-primary">
                                        <i class="la la-plus"></i>{{ ('Add')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox7" autocomplete="off"
                                       name="my_container"
                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled @endif
                                       @if($orders->my_container == 'on') checked @endif
                                >
                                <label class="form-check-label" for="inlineCheckbox7">My container</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox6" name="my_sensor"
                                       autocomplete="off"
                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled @endif
                                       @if($orders->my_sensor == 'on') checked @endif
                                >
                                <label class="form-check-label" for="inlineCheckbox6">My sensor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" autocomplete="off"
                                       name="sensor_for_rent"
                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled @endif
                                       @if($orders->sensor_for_rent == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox1">Sensor for rent</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="container"
                                       autocomplete="off"
                                       @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                       @endif      @if($orders->container == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox2">Container for rent</label>
                            </div>
                            {{--                            <div class="form-check">--}}
                            {{--                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="return_sensor" @if($orders->return_sensor == 'on') checked @endif>--}}
                            {{--                                <label class="form-check-label" for="inlineCheckbox3">Returning the sensor</label>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="form-check">--}}
                            {{--                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="return_container" @if($orders->return_container == 'on') checked @endif>--}}
                            {{--                                <label class="form-check-label" for="inlineCheckbox4">Returning a shipping container</label>--}}
                            {{--                            </div>--}}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="inlineCheckbox5" autocomplete="off"
                                       name="notifications" @if(in_array($orders->status_id,[6,7,9,10])) disabled
                                       @endif   @if($orders->notifications == 'on') checked @endif>
                                <label class="form-check-label" for="inlineCheckbox5">Receive notifications</label>
                            </div>
                            <div class="form-check">
                                <label for="inlineCheckbox11"></label><input class="form-check-input"
                                                                             style="width: 350px;" autocomplete="off"
                                                                             placeholder="myemail@mail.com,myemail2@mail.com"
                                                                             type="text" id="inlineCheckbox11"
                                                                             name="email" value="{{$orders->email}}">
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Delivery Instruction</label>
                                <textarea class="form-control"
                                          name="delivery_comment"
                                          @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif >{{$orders->delivery_comment}}</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="red-star">Shipping Payer:</label>
                                    <select name="payer_id" @if(in_array($orders->status_id,[6,7,9,10])) readonly
                                            autocomplete="off"
                                            @endif  class="form-control ">

                                        @if ( Auth::user()->roles->first()->id == 8)
                                            @foreach(Auth::user()->payer as $item)
                                                <option value="{{$item->id}}"
                                                        @if($item->id == $orders->payer_id) selected @endif>{{$item->customer_name}}</option>
                                            @endforeach
                                        @else
                                            @foreach($payers as $item)
                                                <option value="{{$item->id}}"
                                                        @if($item->id == $orders->payer_id) selected @endif >{{$item->customer_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none">
                            <div class="col-md-6" data-select2-id="66">
                                <label>Status</label>
                                @if($orders->status_id < 2)
                                    <select id="select1" name="status_id" class="form-control " autocomplete="off"
                                            @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif >
                                        @foreach($status as $item)
                                            @if($item->id > 2)
                                                @break
                                            @endif
                                            <option value="{{$item->id}}"
                                                    @if($item->id == $orders->status_id) selected @endif >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" disabled class="form-control" autocomplete="off"
                                           value="{{ $orders->status->name }}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        @php
                            if (isset($tracker_start->start_time))
                            {
                                $start_time = str_replace(' ','T', $tracker_start->start_time);
                                $start_time_stop = str_replace(' ','T', $tracker_start->start_time_stop);
                            }
                            if (isset($tracker_end->start_time))
                            {
                                $end_time = str_replace(' ','T', $tracker_end->start_time);
                                $end_time_stop = str_replace(' ','T', $tracker_end->start_time_stop);
                            }
                        @endphp
                    </div>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group fv-plugins-icon-container">
                        <label class="red-star">Shipping Date:</label>
                        <div><span>From</span></div>
                        <div class="input-group date">
                            <input placeholder="Start time" type="datetime-local" name="start[start_time]"
                                   autocomplete="off"
                                   class="form-control" required value="{{$start_time ?? ''}}"/>
                        </div>
                        <i data-field="sending_time" class="fv-plugins-icon"></i>
                        <div class="fv-plugins-message-container"></div>
                        <div><span>To</span></div>
                        <div class="input-group date">
                            <input placeholder="Start time" type="datetime-local" required name="start[start_time_stop]"
                                   autocomplete="off"
                                   class="form-control" value="{{$start_time_stop ?? ''}}"/>
                        </div>
                        <i data-field="sending_time" class="fv-plugins-icon"></i>
                        <div class="fv-plugins-message-container"></div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group fv-plugins-icon-container">
                        <label class="red-star">Delivery Date:</label>
                        <div><span>From</span></div>
                        <div class="input-group date">
                            <input placeholder="Start time" type="datetime-local" name="end[start_time]"
                                   autocomplete="off"
                                   class="form-control" required value="{{$end_time ?? ''}}"/>
                        </div>
                        <i data-field="delivery_time" class="fv-plugins-icon"></i>
                        <div class="fv-plugins-message-container"></div>
                        <div><span>To</span></div>
                        <div class="input-group date">
                            <input placeholder="Start time" type="datetime-local" name="end[start_time_stop]"
                                   autocomplete="off"
                                   class="form-control" required value="{{$end_time_stop ?? ''}}"/>
                        </div>
                        <i data-field="delivery_time" class="fv-plugins-icon"></i>
                        <div class="fv-plugins-message-container"></div>
                    </div>
                </div>

                @php
                    $alert_marker = 1;
                @endphp
                <div id="kt_repeater_12">
                    <div class="" id="">
                        <h2 class="text-left">Tracker Info:</h2>
                        <div data-repeater-item class="row align-items-center"
                             style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                            @php
                                if (isset($tracker_start->start_time))
                                {
                                     $start_time = str_replace(' ','T', $tracker_start->start_time);
                                     $start_time_stop = str_replace(' ','T', $tracker_start->start_time_stop);
                                }
                                $end_time=is_null($tracker_start->end_time)?'':str_replace(' ','T', $tracker_start->end_time);
                                $left_the_point=is_null($tracker_start->left_the_point)?'':str_replace(' ','T', $tracker_start->left_the_point);
                            @endphp
                            <div class="col-md-3">
                                <label>Location:</label>
                                <input placeholder="Start time" type="text" disabled class="form-control"
                                       autocomplete="off"
                                       value="{{$tracker_start->cargolocation->name}}"/>
                            </div>
                            <div class="col-md-3">
                                <label>Address:</label>
                                <input placeholder="Start time" type="text" disabled class="form-control"
                                       autocomplete="off"
                                       value="{{$tracker_start->address}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>
                            <div class="col-md-3">
                                <label>Driver:</label>
                                <select name="start[driver_id]"
                                        class="form-control @if (empty($end_time) && !isset($tracker_start->driver_id) && !isset($tracker_start->agent_id)) border-danger  @endif"
                                        autocomplete="off"
                                        @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif >
                                    <option value=""></option>
                                    @foreach($user as $item)
                                        @if($item->roles->first()->name == 'Driver')
                                            <option value="{{$item->id}}"
                                                    @if($item->id == $tracker_start->driver_id) selected @endif >{{$item->nickname}}
                                                - {{$item->roles->first()->name}}  </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-3">
                                <label>Agent:</label>
                                <select id="change-country-to" name="start[agent_id]"
                                        class="form-control @if (empty($end_time) && !isset($tracker_start->agent_id) && !isset($tracker_start->driver_id)) border-danger @endif"
                                        autocomplete="off"
                                        @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif >
                                    <option value=""></option>
                                    @foreach($user as $item)
                                        @if($item->roles->first()->name == 'Agent')
                                            <option value="{{$item->id}}"
                                                    @if($item->id == $tracker_start->agent_id) selected @endif >{{$item->nickname}}
                                                - {{$item->roles->first()->name}} </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-3 col-md-4">
                                <label>Estimated time:</label>
                                <input placeholder="Start time FROM" type="datetime-local" disabled
                                       autocomplete="off"
                                       class="form-control" value="{{ $start_time ?? ''}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>
                            <div class="col-md-3 col-md-4" id="actual_time">
                                <label>Arrived Time:</label>
                                <input placeholder="Start time" type="datetime-local" name="start[arrived_time]"
                                       autocomplete="off"
                                       class="form-control @if (empty($end_time)) border-danger @php $alert_marker = 0; @endphp @endif"
                                       value="{{ $end_time ?? ''}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>
                            <div class="col-md-3" id="actual_time_start">
                                <label>Signed:</label>
                                <input placeholder="Signed" type="text" name="start[signed]"
                                       autocomplete="off"
                                       class="form-control @if (empty($end_time) && !isset($tracker_start->signed)) border-danger  @endif"
                                       value="{{$tracker_start->signed}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="actual_status"
                                           autocomplete="off"
                                           name="start[status_arrival]"
                                           @if( $tracker_start->status == 'Arrived') disabled checked @endif>
                                    <label class="form-check-label">Arrived</label>
                                </div>
                            </div>
                        </div>
                        <div data-repeater-list="time" class="col-lg-12">
                            {{--                                @dd($trackers)--}}
                            @if(!$trackers->isEmpty())
                                @foreach($trackers as $tracker)
                                    <div data-repeater-item class="row align-items-center zakupak"
                                         style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                        @php
                                            if (isset($tracker->start_time))
                                            {
                                                 $start_time = str_replace(' ','T', $tracker->start_time);
                                            }
                                            $end_time=is_null($tracker->end_time)?'':str_replace(' ','T', $tracker->end_time);
                                            $left_the_point=is_null($tracker->left_the_point)?'':str_replace(' ','T', $tracker->left_the_point);
                                        @endphp
                                        <div class="col-md-3">
                                            <label>Location:</label>
                                            <select name="cargo_location"
                                                    class="form-control @if (!isset($tracker->cargolocation->id) && $alert_marker === 1) border-danger @endif">
                                                @foreach($cargo_location as $item)
                                                    <option value="{{$item->id}}"
                                                            @if($item->id == $tracker->cargolocation->id) selected @endif>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id" value="{{$tracker->id}}" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Address:</label>
                                            <input placeholder="City, street" type="text" name="address"
                                                   autocomplete="off"
                                                   class="form-control"
                                                   value="{{$tracker->address}}" required/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Driver:</label>
                                            <select name="driver_id"
                                                    class="form-control @if (empty($end_time) && !isset($tracker->driver_id) && !isset($tracker->agent_id) && $alert_marker === 1) border-danger  @endif"
                                                    @if($orders->status_id > 2) readonly @endif >
                                                <option value=""></option>
                                                @foreach($user as $item)
                                                    @if($item->roles->first()->name == 'Driver')
                                                        <option value="{{$item->id}}"
                                                                @if($item->id == $tracker->driver_id) selected @endif >{{$item->nickname}}
                                                            - {{$item->roles->first()->name}}  </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label>Agent:</label>
                                            <select name="agent_id"
                                                    class="form-control @if (empty($end_time) && !isset($tracker->agent_id) && !isset($tracker->driver_id)  && $alert_marker === 1) border-danger @endif"
                                                    @if($orders->status_id > 2) readonly @endif >
                                                <option value=""></option>
                                                @foreach($user as $item)
                                                    @if($item->roles->first()->name == 'Agent')
                                                        <option value="{{$item->id}}"
                                                                @if($item->id == $tracker->agent_id) selected @endif >{{$item->nickname}}
                                                            - {{$item->roles->first()->name}}  </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-md-4">

                                            <label>Estimated time:</label>
                                            <input placeholder="Start time" type="datetime-local" name="start_time"
                                                   autocomplete="off"
                                                   class="form-control clear-value-data "
                                                   value="{{ $start_time }}"
                                                   required/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3 col-md-4">
                                            <label>Arrived Time:</label>
                                            <input placeholder="Start time" type="datetime-local" name="arrived_time"
                                                   autocomplete="off"
                                                   class="form-control clear-value-data @if (empty($end_time)  && $alert_marker === 1) border-danger  @php $alert_marker = 0; @endphp @endif"
                                                   value="{{$end_time}}"/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3 col-md-4">
                                            <label>Left Time:</label>
                                            <input placeholder="Left Time" type="datetime-local" name="left_time"
                                                   autocomplete="off"
                                                   class="form-control clear-value-data @if (!empty($end_time) && empty($left_the_point) ) border-danger @php $alert_marker = 0; @endphp @endif"
                                                   value="{{$left_the_point}}"/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Signed:</label>
                                            <input placeholder="Signed" type="text" name="signed"
                                                   autocomplete="off"
                                                   class="form-control @if ( !empty($end_time) && empty($left_the_point) && !isset($tracker->signed) ) border-danger @endif"
                                                   value="{{$tracker->signed}}"/>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="status_arrival"
                                                       @if( $tracker->status == 'Arrived') disabled checked @endif>
                                                <label class="form-check-label">Arrived</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="left_time"
                                                       autocomplete="off"
                                                       name="status_left" @if(!empty($tracker->left_the_point)) disabled
                                                       checked @endif>
                                                <label class="form-check-label">Leave</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <a href="javascript:;" data-repeater-delete=""
                                                       onclick="//deleteCargo(this)"
                                                       class="btn btn-sm font-weight-bolder btn-light-danger delete_item_time">
                                                        <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div data-repeater-item class="row align-items-center  tracker-block-delete"
                                     style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                                    <div class="col-md-3">
                                        <label>Location:</label>
                                        <select name="cargo_location" class="form-control ">
                                            @foreach($cargo_location as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Address:</label>
                                        <input placeholder="City, street, " type="text" name="address"
                                               autocomplete="off"
                                               class="form-control"/>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Signed:</label>
                                        <input placeholder="Signed" type="text" name="signed"
                                               autocomplete="off"
                                               class="form-control"/>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Driver:</label>
                                        <select name="driver_id" class="form-control "
                                                @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif >
                                            <option value=""></option>
                                            @foreach($user as $item)
                                                @if($item->roles->first()->name == 'Driver')
                                                    <option value="{{$item->id}}">{{$item->nickname}}
                                                        - {{$item->roles->first()->name}}  </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Agent:</label>
                                        <select name="agent_id" class="form-control "
                                                @if(in_array($orders->status_id,[6,7,9,10])) readonly @endif >
                                            <option value=""></option>
                                            @foreach($user as $item)
                                                @if($item->roles->first()->name == 'Agent')
                                                    <option value="{{$item->id}}">{{$item->nickname}}
                                                        - {{$item->roles->first()->name}}  </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-md-4">
                                        <label>Estimated time:</label>
                                        <input placeholder="Start time" type="datetime-local" name="start_time"
                                               autocomplete="off"
                                               class="form-control clear-value-data"/>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>
                                    <div class="col-md-3 col-md-4">
                                        <label>Arrived Time:</label>
                                        <input placeholder="Start time" type="datetime-local" name="arrived_time"
                                               autocomplete="off"
                                               class="form-control clear-value-data"/>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Left Time:</label>
                                        <input placeholder="Left Time" type="datetime-local" name="left_time"
                                               autocomplete="off"
                                               class="form-control clear-value-data"/>
                                        <div class="mb-2 d-md-none"></div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="status_arrival">
                                            <label class="form-check-label">Arrived</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="left_time"
                                                   autocomplete="off"
                                                   name="status_left">
                                            <label class="form-check-label">Leave</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div>
                                                <a href="javascript:;" data-repeater-delete=""
                                                   onclick="//deleteCargo(this)"
                                                   class="btn btn-sm font-weight-bolder btn-light-danger delete_item_time">
                                                    <i class="la la-trash-o"></i>{{ ('Delete')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div data-repeater-item class="row align-items-center"
                             style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">
                            <div class="col-md-3">
                                <label>Location:</label>
                                <input placeholder="Start time" type="text" disabled
                                       class="form-control @if (!isset($tracker_end->cargolocation->name) && $alert_marker === 1) border-danger @php $alert_marker = 0; @endphp @endif"
                                       autocomplete="off"
                                       value="{{$tracker_end->cargolocation->name}}"/>
                            </div>
                            <div class="col-md-3">
                                <label>Address:</label>
                                <input placeholder="Start time" type="text" disabled
                                       class="form-control @if (!isset($tracker_end->address) && $alert_marker === 1) border-danger @php $alert_marker = 0; @endphp @endif"
                                       autocomplete="off"
                                       value="{{$tracker_end->address}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>
                            @php
                                if (isset($tracker_end->start_time))
                                {
                                     $start_time_end = str_replace(' ','T', $tracker_end->start_time);
                                     $start_time_stop = str_replace(' ','T', $tracker_end->start_time_stop);
                                }
                                $end_time=is_null($tracker_end->end_time)?'':str_replace(' ','T', $tracker_end->end_time);
                            @endphp
                            <div class="col-md-3 col-md-4">
                                <label>Estimated time:</label>
                                <input placeholder="Start time FROM" type="datetime-local" disabled
                                       autocomplete="off"
                                       class="form-control @if (!isset($start_time_end) && $alert_marker === 1) border-danger @php $alert_marker = 0; @endphp @endif"
                                       value="{{ $start_time_end ?? ''}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>
                            <div class="col-md-3 col-md-4" id="actual-time-end">
                                <label>Arrived Time:</label>
                                <input placeholder="Start time" type="datetime-local" name="end[arrived_time]"
                                       autocomplete="off"
                                       class="form-control @if (empty($end_time) && $alert_marker === 1) border-danger @endif"
                                       value="{{ $end_time ?? ''}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>
                            <div class="col-md-3 tracker_append" id="actual-time-end-signed">
                                <label>Signed:</label>
                                <input placeholder="Signed" type="text" name="end[signed]"
                                       autocomplete="off"
                                       class="form-control @if (empty($tracker_end->signed) && empty($end_time) && $alert_marker === 1) border-danger @php $alert_marker = 0; @endphp @endif"
                                       value="{{$tracker_end->signed}}"/>
                                <div class="mb-2 d-md-none"></div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="end[status_arrival]"
                                           autocomplete="off"
                                           @if( $tracker_end->status == 'Arrived') disabled checked @endif>
                                    <label class="form-check-label">Arrived</label>
                                </div>
                            </div>

                        </div>

                    </div>
                    @if($orders->status_id == 6 || $orders->status_id == 7 || $orders->status_id == 9)
                        <br>
                        <div class="">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="red-star">Invoice number:</label>
                                    <input type="text" placeholder="Invoice number" name="checkout_number" required
                                           autocomplete="off"
                                           class="form-control" value="{{ $orders->checkout_number }}"/>
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--                    @if($orders->status_id < 2)--}}
                    <div class="form-group ">
                        <div class="">
                            <label class="text-right col-form-label">{{ ('Add')}}</label>
                            <div>
                                <a href="javascript:;" data-repeater-create-time=""
                                   class="btn btn-sm font-weight-bolder btn-light-primary clear-value-datatime">
                                    <i class="la la-plus"></i>{{ ('Add')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    {{--                    @endif--}}
                    @canany(['SuperUser', 'Manager', 'OPS', 'Client'], Auth::user())
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
                    @endcanany
                </div>

                <div class="form-group ">
                    <div class="">
                        <div class="form-group">
                            <input type="submit" name="submitted"
                                   class="btn btn-sm font-weight-bolder btn-light-primary" value="Save">
                        </div>
                        <div>
                            <input type="submit" name="submitted"
                                   class="btn btn-sm font-weight-bolder btn-light-primary" value="Save and back">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="https://api.visicom.ua/apps/visicom-autocomplete.min.js"></script>
    <script type="text/javascript">
        let ac = new visicomAutoComplete({
            selector: '.visicom-autocomplete2',
            apiKey: 'c703b0f96cb9bd605ba41cb9fdf44e10',
            placeholder: 'City, street',
            minCahrs: 6,
            lang: 'en',
        });
        let ab = new visicomAutoComplete({
            selector: '.visicom-autocomplete',
            apiKey: 'c703b0f96cb9bd605ba41cb9fdf44e10',
            placeholder: 'City, street',
            minCahrs: 6,
            lang: 'en',
        });
    </script>
    <script>

        let valueAddress2 = "{!! $tracker_end->address !!}";
        $("#visicom-autocomplete2 input").val(valueAddress2);
        var valueAddress = "{!! $tracker_start->address !!}";
        $("#visicom-autocomplete input").val(valueAddress);
    </script>
    <script type="text/javascript">
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
        $('.address-client').each(function () {
            var address = $(this);
            address.geocomplete({
                map: ".map_canvas.map-client",
                mapOptions: {
                    zoom: 8,
                    center: {lat: -34.397, lng: 150.644},
                },
                markerOptions: {
                    draggable: true
                },
                details: ".location-client",
                detailsAttribute: 'data-client',
                autoselect: true,
                restoreValueAfterBlur: true,
            });
            address.bind("geocode:dragged", function (event, latLng) {
                $("input[data-client=lat]").val(latLng.lat());
                $("input[data-client=lng]").val(latLng.lng());
            });
        });

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

            $('#actual_status').on('change', function () {
                if (document.getElementById('actual_status').checked) {
                    $('#actual_time_start input').attr("required", "required");
                } else {
                    $('#actual_time_start input').removeAttr("required");
                }
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

            $('.clear-value-datatime').click(function () {
                $('.zakupak').last().find('.col-md-3').find('.clear-value-data').removeAttr('value');
            });
        });
    </script>


    <script>
        $("#visicom-autocomplete input").attr('name', 'address_shipper');

        function searchPostal(data) {
            let postalCode2 = data;
            let postalArray = data.features;
            if (Array.isArray(postalArray)) {
                postalCode2 = data.features[0].properties.postal_code;
            } else {
                postalCode2 = data.properties.postal_code;
            }
            document.getElementById('postal_code').value = postalCode2;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#visicom-autocomplete input").change(function () {
            getData(this.value);
        });

        async function getData(value) {
            const response = await fetch('https://api.visicom.ua/data-api/5.0/en/geocode.json?text=' + value + '&key=c703b0f96cb9bd605ba41cb9fdf44e10');
            const data = await response.json();
            searchPostal(data);
        }
    </script>
    <script>
        $("#visicom-autocomplete2 input").attr('name', 'address_consignee');

        function searchPostal2(data) {
            let postalCode2 = data;
            let postalArray = data.features;
            if (Array.isArray(postalArray)) {
                postalCode2 = data.features[0].properties.postal_code;
            } else {
                postalCode2 = data.properties.postal_code;
            }
            document.getElementById('postal_code2').value = postalCode2;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#visicom-autocomplete2 input").change(function () {
            getData2(this.value);
        });

        async function getData2(value) {
            const response2 = await fetch('https://api.visicom.ua/data-api/5.0/en/geocode.json?text=' + value + '&key=c703b0f96cb9bd605ba41cb9fdf44e10')
            const data2 = await response2.json();
            searchPostal2(data2);
        }
    </script>
    <script>
        $('#table_id').DataTable({
            "ordering": false,
        });
        $('#table_id2').DataTable({
            "ordering": false,
        });
    </script>
    <script>
        let item = document.querySelectorAll('.item-table');
        for (let i = 0; i < item.length; i++) {
            $(item[i]).click(function () {
                let text = $(this).text();
                $('#autocomplete').val(text);
                $('.modal').modal('hide');
            });
        }
    </script>
    <script>
        let item2 = document.querySelectorAll('.item-table2');
        for (let i = 0; i < item2.length; i++) {
            $(item2[i]).click(function () {
                let text = $(this).text();
                $('#autocomplete2').val(text);
                $('.modal').modal('hide');
            });
        }
    </script>
@endsection
