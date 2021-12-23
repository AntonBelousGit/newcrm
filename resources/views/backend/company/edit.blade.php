@extends('backend.layouts.app')

@section('content')

    <div class="mx-auto col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Company information</h5>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    <h4>{{$errors->first()}}</h4>
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <h4>{{session('success')}}</h4>
                </div>
            @endif
            <form class="form-horizontal" action="{{ route('admin.company.update',$company->id) }}" id="kt_form_1" method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="red-star">Company Name:</label>
                                <input type="text" id="name" class="form-control" name="name" required value="{{$company->name}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone:</label>
                                <input id="email-field" type="text" class="form-control" name="phone" value="{{$company->phone}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="red-star">Location:</label>
                                <select name="location_id" required class="form-control ">
                                    @foreach($locations as $item)
                                        <option value="{{$item->id}}" {{$company->location_id == $item->id ? 'selected':'' }}>{{$item->city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="red-star">Agents:</label>
                                <select name="agent_id[]" required class="form-control " multiple>
                                    @foreach($without_agent_company as $item)
                                        <option value="{{$item->id}}" {{in_array($item->id, $company_agent ?: []) ? "selected": ""}} >{{$item->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="red-star">Drivers:</label>
                                <select name="driver_id[]" required class="form-control " multiple>
                                    @foreach($without_driver_company as $item)
                                        <option value="{{$item->id}}" {{in_array($item->id, $company_driver ?: []) ? "selected": ""}} >{{$item->fullname}}</option>
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

    </script>
@endsection
