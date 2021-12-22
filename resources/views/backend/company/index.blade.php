@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">All Companies</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('admin.company.create') }}" class="btn btn-circle btn-info">
                    <span>Add New Company</span>
                </a>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <h4>{{session('success')}}</h4>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <table id="table_id" class="">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Phone</th>


                    <th width="10%" class="text-center">Options</th>
                </tr>
                </thead>
                <tbody>
                @if (count($companies) > 0)
                    @foreach($companies as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->location->city}}</td>
                            <td>{{$item->phone}}</td>

                            <td class="text-center">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                   href="{{route('admin.company.show', $item->id)}}" title="Show">
                                    <i class="las la-eye"></i>
                                </a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                   href="{{route('admin.company.edit', $item->id)}}" title="Edit">
                                    <i class="las la-edit"></i>
                                </a>
                                <form action="{{route('admin.company.destroy', $item->id)}}" class="d-inline"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                            data-toggle="tooltip" data-original-title="Remove">
                                        <i class="las la-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @endforeach
                @else
                    <tr>
                        <td>Nothing found</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{--            {{ $users->links() }}--}}
            </div>
        </div>
    </div>

@endsection


{{--@section('modal')--}}
{{--    @include('modals.delete_modal')--}}
{{--@endsection--}}



@section('script')
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
