@extends('backend.layouts.app')

@section('content')

    <div class="mx-auto col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{  ('Import Addresses')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.import-address') }}" id="kt_form_1" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <p>To import addresses from excel, create an xls file and add a column with the Address column to it. Add addresses one at a time in the cell (line)</p>
                    </div>
                    <div class="form-group">
                        <label>Import xls,xlsx:</label>
                        <input type="file" id="search" class="form-control" name="file" required>
                        <div class="hint_search">
                        </div>

                        @error('file')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group ">
                        <div class="">
                            <div>
                                <input type="submit" class="btn btn-sm font-weight-bolder btn-light-primary" value="Save">
                                <a class="btn btn-sm font-weight-bolder btn-light-primary"
                                   href="{{route('admin.download-template')}}">Import template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection
