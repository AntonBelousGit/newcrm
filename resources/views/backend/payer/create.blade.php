{{--@php--}}
{{--    $checked_google_map = \App\BusinessSetting::where('type', 'google_map')->first();--}}
{{--    $is_def_mile_or_fees = \App\ShipmentSetting::getVal('is_def_mile_or_fees');--}}
{{--    $countries = \App\Country::where('covered',1)->get();--}}
{{--    $user_type = Auth::user()->user_type;--}}
{{--@endphp--}}

@extends('backend.layouts.app')

@section('content')

    <div class="mx-auto col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{  ('Payer create')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.payer.store') }}" id="kt_form_1" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer account number:</label>
                                <input type="number" class="form-control"   name="customer_account_number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer name:</label>
                                <input type="text" class="form-control" placeholder="Customer name" name="customer_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer address:</label>
                                <input type="text" class="form-control" placeholder="Customer address" name="customer_address" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" class="form-control"    placeholder="City" name="city" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Zip code:</label>
                                <input type="text" class="form-control" placeholder="Zip code" name="zip_code" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Country:</label>
                                <input type="text" class="form-control" placeholder="Country" name="country" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Contact name:</label>
                                <input type="text" class="form-control" placeholder="Contact name" name="contact_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="text" class="form-control"    placeholder="Phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" class="form-control" placeholder="Email" name="email" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Billing frequency:</label>
                                <input type="text" class="form-control" placeholder="Billing" name="billing" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Special requirements:</label>
                                <input type="text" class="form-control"  placeholder="Special" name="special" >
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
            </form>

        </div>
    </div>

@endsection

@section('script')

@endsection
