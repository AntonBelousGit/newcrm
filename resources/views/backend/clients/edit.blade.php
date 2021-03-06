@extends('backend.layouts.app')

@section('content')

    <div class="mx-auto col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{  ('User Information')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.users.update',$user->id) }}" id="kt_form_1"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Contact Name(APC+First/Last Name):</label>
                        <input type="text" id="name" class="form-control" placeholder="Full name" name="fullname"
                               required value="{{$user->fullname}}">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input id="email-field" type="text" class="form-control" placeholder="Email" name="email"
                               required value="{{$user->email}}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                       name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password:</label>
                                <input type="password" class="form-control" placeholder="Confirm Password"
                                       name="confirm_password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" class="form-control" id="owner_name" placeholder="Name" name="name"
                                       required value="{{$user->name}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nickname:</label>
                                <input type="text" class="form-control" placeholder="Nickname" name="nickname" required
                                       value="{{$user->nickname}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Company</label>
                                <select name="company_id"
                                        class="change-country-client-address form-control select-country">
                                    <option value=""></option>
                                    @foreach($companies as $item)
                                        <option value="{{$item->id}}" @if($item->id == $user->company()->get()->pluck('id')->first()) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Roles</label>
                                <select name="roles" class="change-country-client-address form-control select-country"
                                        required>
                                    @foreach($roles as $item)
                                        <option value="{{$item->id}}"
                                                @if($item->id == $user->roles()->get()->pluck('id')->first()) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="">
                            <div>
                                <input type="submit" class="btn btn-sm font-weight-bolder btn-light-primary"
                                       value="Save">
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">

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

        $('.how-know-us').select2({
            placeholder: "Client Source",
        });

        //Address Types Repeater

        $('#kt_repeater_1').repeater({
            initEmpty: false,

            show: function () {
                var repeater_item = $(this);


                $(this).slideDown();

                changeCountry();
                changeState();
                selectPlaceholder();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            },

            isFirstItemUndeletable: true
        });


        $(document).ready(function () {

            FormValidation.formValidation(
                document.getElementById('kt_form_1'), {
                    fields: {
                        "Client[name]": {
                            validators: {
                                notEmpty: {
                                    message: '{{  ("This is required!")}}'
                                }
                            }
                        },
                        "Client[email]": {
                            validators: {
                                notEmpty: {
                                    message: '{{  ("This is required!")}}'
                                },
                                emailAddress: {
                                    message: '{{  ("This is should be valid email!")}}'
                                },
                                remote: {
                                    data: {
                                        type: 'Client',
                                    },
                                    message: 'The email is already exist',
                                    method: 'GET',
                                    {{--url: '{{ route("user.checkEmail") }}',--}}
                                }
                            }
                        },
                        "password": {
                            validators: {
                                notEmpty: {
                                    message: '{{  ("This is required!")}}'
                                }
                            }
                        },
                        "confirm_password": {
                            validators: {
                                notEmpty: {
                                    message: '{{  ("This is required!")}}'
                                },
                                identical: {
                                    compare: function () {
                                        return document.getElementById('kt_form_1').querySelector('[name="password"]').value;
                                    },
                                    message: 'The password and its confirm are not the same'
                                }
                            }
                        },
                        "Client[responsible_name]": {
                            validators: {
                                notEmpty: {
                                    message: '{{  ("This is required!")}}'
                                }
                            }
                        },
                        "Client[responsible_mobile]": {
                            validators: {
                                notEmpty: {
                                    message: '{{  ("This is required!")}}'
                                }
                            }
                        },
                        "address": {
                            validators: {
                                notEmpty: {
                                    message: '{{  ("This is required!")}}'
                                }
                            }
                        }


                    },


                    plugins: {
                        autoFocus: new FormValidation.plugins.AutoFocus(),
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap(),
                        // Validate fields when clicking the Submit button
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        // Submit the form when all fields are valid
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                        icon: new FormValidation.plugins.Icon({
                            valid: 'fa fa-check',
                            invalid: 'fa fa-times',
                            validating: 'fa fa-refresh',
                        }),
                    }
                }
            );
        });
    </script>
@endsection
