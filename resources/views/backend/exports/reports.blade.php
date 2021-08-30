<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Shipper</th>
    </tr>
    </thead>
    <tbody>
{{--    @dd($orders)--}}
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->shipper }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
