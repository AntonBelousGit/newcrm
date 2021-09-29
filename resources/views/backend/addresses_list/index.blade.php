@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">All Addresses</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('admin.addresses-list.create') }}" class="btn btn-circle btn-info">
                    <span>Add New Addresses</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">User</h5>
        </div>
        <div class="card-body">
            @can('Client', Auth::user())
                @include('backend.addresses_list.components.user')
            @else
                @include('backend.addresses_list.components.administration')
            @endcan
        </div>
    </div>

@endsection


@section('script')
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
