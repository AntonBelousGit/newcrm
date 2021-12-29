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
                    <h5 class="my-1 mr-5 text-dark font-weight-bold">Agents</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="p-0 my-2 mr-5 breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.index')}}" class="text-muted">{{ ('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">Agents</a>
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
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="flex-wrap py-3 card-header">
            <div class="card-title">
                <h3 class="card-label">
                    {{$title}}
                </h3>
            </div>
        </div>
        <form id="tableForm">
            @csrf()
            <div class="wrap_table">
                <table id="table_id" class="">
                    <thead>
                    <tr>
                        <th>Full name</th>
                        <th>Agent company name</th>
                        <th>Location</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Mission</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            {{--                            @dd($users)--}}
                            <th>{{$user->fullname}}</th>
                            <th>{{$user->company->first()->name ?? ''}}</th>
                            <th>{{$user->agent->location['name'] ?? ''}} - {{$user->agent->location['city'] ?? ''}}</th>
                            <th>{{$user->email}}</th>
                            <th>{{$user->status}}</th>
                            <td class="text-center">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                   href="{{route('admin.user.status', $user->id)}}" title="Status">
                                    <i class="las la-low-vision"></i>
                                </a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                   href="{{route('admin.agent.edit', $user->id)}}" title="{{  ('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection
@section('modal')
    {{--@include('modals.delete_modal')--}}
@endsection
@section('script')
    <script type="text/javascript">


        $(document).ready(function () {
            var table = $('#table_id').DataTable({
                stateSave: true
            });
            $('#table_id tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var id = $(this).find('input[type="hidden"]').val();
                var row = table.row(tr);
            });
        });
    </script>

@endsection
