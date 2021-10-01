@extends('backend.layouts.app')

@section('content')

    <div class="mx-auto col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{  ('Addresses')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.addresses-list.update',$addresses->id) }}" id="kt_form_1" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Addresses:</label>
                        <input type="text" id="name" class="form-control" placeholder="Address" name="address" required value="{{$addresses->address}}">
                    </div>
                    <div class="form-group">
                        <label>User:</label>
                        <select class="form-control "  name="user_id">
                            @foreach($users as $user)
                                <option value="{{$user->id}}" @if($addresses->user->id === $user->id) selected @endif>{{$user->name}}</option>
                            @endforeach
                        </select>
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
