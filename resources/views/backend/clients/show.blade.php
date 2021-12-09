@extends('backend.layouts.app')

@section('content')

    <div class="mx-auto col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{  ('User Information')}}</h5>
            </div>

            <form class="form-horizontal" action="" id="kt_form_1" method="GET" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label>Full name:</label>
                        <input type="text" id="name" class="form-control" placeholder="Full name" disabled  value="{{$users->fullname}}">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input id="email-field" type="text" class="form-control" placeholder="Email" disabled  value="{{$users->email}}">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" class="form-control" id="owner_name" placeholder="Name" disabled  value="{{$users->name}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nickname:</label>
                                <input type="text" class="form-control" placeholder="Nickname"  disabled value="{{$users->name}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Roles</label>
                                <input type="text" class="form-control" placeholder="Nickname"  disabled value="{{$users->roles()->get()->pluck('name')->first()}}">
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
        </div>
    </div>

@endsection

@section('modal')
{{--@include('modals.delete_modal')--}}
@endsection
