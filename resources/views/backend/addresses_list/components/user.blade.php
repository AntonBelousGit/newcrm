<table id="table_id" class="">
    <thead>
    <tr>
        <th>#</th>
        <th>Addresses</th>

        <th width="10%" class="text-center">Options</th>
    </tr>
    </thead>
    <tbody>
    @foreach($addresses as $address)

        <tr>
            <td>{{$address->id}}</td>
            <td>{{$address->address}}</td>
            <td class="text-center">
                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                   href="{{route('admin.addresses-list.edit', $address->id)}}" title="Edit">
                    <i class="las la-edit"></i>
                </a>
                <form action="{{route('admin.agent.destroy', $address->id)}}" class="d-inline"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                            data-toggle="tooltip" data-original-title="Remove"><i class="las la-trash"
                                                                                  aria-hidden="true"></i>
                    </button>
                </form>
            </td>
        </tr>

    @endforeach
    </tbody>
</table>
