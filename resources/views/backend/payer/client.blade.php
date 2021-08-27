@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">All Payers</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('admin.payer.create') }}" class="btn btn-circle btn-info">
                    <span>Add New Payer</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">Payer</h5>
        </div>
        <div class="card-body">
            <table id="table_id" class="">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Customer name</th>
                    <th>Email</th>

                    <th  width="10%" class="text-center">Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $item)

                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td class="text-center">
                            @canany(['SuperUser','Manager','Security Officer'], Auth::user())
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.client-payer-edit', $item->id)}}" title="Edit">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcanany
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{--            {{ $users->links() }}--}}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    {{--    @include('modals.delete_modal')--}}
@endsection

@section('script')
    <script>
        // $(document).ready(() => {
        //     $('#table_id').DataTable();
        // });
        // $(document).ready( function () {
        //     $('#table_id').DataTable();
        // } );
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
@endsection
