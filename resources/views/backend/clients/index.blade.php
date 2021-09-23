@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">All Users</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('admin.users.create') }}" class="btn btn-circle btn-info">
                    <span>Add New Users</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">User</h5>
        </div>
        <div class="card-body">
            <table id="table_id" class="">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Full name</th>
                    <th>Role</th>


                    <th width="10%" class="text-center">Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)

                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->fullname}}</td>
                        <td>{{$user->roles()->get()->pluck('name')->first()}}</td>

                        <td class="text-center">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                               href="{{route('admin.users.show', $user->id)}}" title="Show">
                                <i class="las la-eye"></i>
                            </a>
                            @canany(['SuperUser','Manager','Security Officer'], Auth::user())
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                   href="{{route('admin.users.edit', $user->id)}}" title="Edit">
                                    <i class="las la-edit"></i>
                                </a>
                                {{--                                    <a href="{{route('admin.users.destroy', $user->id)}}" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.users.destroy', $user->id)}}" title="Delete">--}}
                                {{--                                        <i class="las la-trash"></i>--}}
                                {{--                                    </a>--}}
                                <form action="{{route('admin.users.destroy', $user->id)}}" class="d-inline"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                            data-toggle="tooltip" data-original-title="Remove"><i class="las la-trash"
                                                                                                  aria-hidden="true"></i>
                                    </button>
                                </form>
                            @endcanany
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{--            {{ $users->links() }}--}}
            </div>
            @canany('SuperUser','OPS','Manager')
                <hr>
                <div class="">
                    <div class="col-md-12" data-select2-id="66">
                        <label>Logging:</label>
                        @php

                            @endphp
                        @foreach($logs as $log)
                            {{--                        @dd($logs)--}}
                            @php
                                $change_fields = (array)$change_fields = json_decode($log->properties);
                                if(isset($change_fields['status'])){
                                    $status = (array)$change_fields['status'];
                                }
                                if(isset($change_fields['rol'])){
                                    $rol = (array)$change_fields['rol'];

                                }
                                if(isset($change_fields['old'])){
                                    $old = (array)$change_fields['old'];
                                }
                            @endphp
                            {{--                        @dd($status->pluck('name'))--}}

                            <p>{{$log->updated_at->format('d.m.Y - H:i:s') }} -
                                User {{$log->user->name}} {{$log->description}} user {{ $status['name'] ?? $old['name'] }} -
                                role {{$rol[0] ?? $old['roles'][0]->name}} </p>


                        @endforeach
                    </div>
                </div>
                <hr>
            @endcanany
        </div>
    </div>

@endsection


{{--@section('modal')--}}
{{--    @include('modals.delete_modal')--}}
{{--@endsection--}}



@section('script')
    <script>
        // $(document).ready(() => {
        //     $('#table_id').DataTable();
        // });
        // $(document).ready( function () {
        //     $('#table_id').DataTable();
        // } );
        $(document).ready(function () {
            $('#table_id').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
