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
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="p-0 my-2 mr-5 breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.driver.index')}}" class="text-muted">Drivers</a>
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
    <form class="form-horizontal" action="{{route('admin.client-payer-update',$users->id)}}" id="kt_form_1" method="POST" enctype="multipart/form-data">
        @csrf
{{--        @method('PUT')--}}
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
{{--                    @dd($users->payer->pluck('id'))--}}
                    <h5 class="my-1 mr-5 text-dark font-weight-bold">{{$users->fullname ?? $users->name}}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Roles</label>
                                <select name="payer[]" class="change-country-client-address form-control select-country" multiple required>
                                    @foreach($payer as $item)
                                        <option value="{{$item->id}}" @if($users->payer->pluck('id')->contains($item->id)) selected @endif>{{$item->customer_name}}</option>
                                    @endforeach
                                </select>
                            </div>
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
    </form>
@endsection
@section('script')

@endsection
