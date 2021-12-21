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
    <style>
        label {
            font-weight: bold !important;
        }
        .select2-container {
            display: block !important;
        }
    </style>

    <form class="form-horizontal" action="{{route('admin.driver.update',$users->id)}}" id="kt_form_1" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="my-1 mr-5 text-dark font-weight-bold">{{$users->fullname ?? ''}}</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">

                            <div class="form-group">
                                <label class="red-star">Сar model:</label>
                                <input type="text" placeholder="Сar model" name="car_model" required class="form-control" value="{{$users->driver['car_model'] ?? ''}}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="red-star">State number of the car:</label>
                                <input type="text" placeholder="State number of the car" name="gos_number_car" required class="form-control" value="{{$users->driver['gos_number_car'] ?? '' }}"/>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone number:</label>
                                <input type="text" name="phone" required class="form-control" value="{{$users->driver['phone'] ?? '' }}"/>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Agent:</label>
                                <select name="agent_user_id" class="form-control">
                                    <option></option>
                                    @foreach($agents as $item)
                                        <option value="{{$item->id}}" @if (isset($users->driver) && $item->id == $users->driver['agent_user_id']) selected @endif>{{$item->agent_company_name}}</option>
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
    <script src="{{ static_asset('assets/dashboard/js/geocomplete/jquery.geocomplete.js') }}"></script>
    {{--<script src="//maps.googleapis.com/maps/api/js?libraries=places&key={{$checked_google_map->key}}"></script>--}}
@endsection
