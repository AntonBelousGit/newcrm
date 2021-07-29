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
        <table class="table aiz-table mb-0">
            <thead>
                <tr>
                    <th  width="3%">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Full name</th>

                    <th  width="10%" class="text-center">Options</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)

                        <tr>
                            <td width="3%">{{$user->id}}</td>
                            <td width="20%">{{$user->name}}</td>
                            <td width="20%">{{$user->email}}</td>
                            <td width="20%">{{$user->fullname}}</td>
                            <td width="">{{$user->roles()->get()->pluck('name')->first()}}</td>

                            <td class="text-center">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.users.show', $user->id)}}" title="Show">
		                                <i class="las la-eye"></i>
		                            </a>
		                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.users.edit', $user->id)}}" title="Edit">
		                                <i class="las la-edit"></i>
		                            </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('admin.users.destroy', $user->id)}}" title="Delete">
                                        <i class="las la-trash"></i>
                                    </a>

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
    @include('modals.delete_modal')
@endsection
