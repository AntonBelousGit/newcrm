@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-2">
                <h1 class="h3">All Reports</h1>
            </div>
            <div class="col-md-10">
                <form action="{{route('admin.reports')}}" method="post">
                    @csrf
                    <div class="input-group date">
                    <input type="date" id="start" name="start" value="2021-01-01" class="form-control">
                    <input type="date" id="end" name="end" value="{{now()->format('Y-m-d')}}" class="form-control">
                    <select name="status" id="status" class="form-control">
                        <option value="6">Delivered</option>
                        <option value="9">Invoiced</option>
                        @can('Client')
                        <option value="0">All shipments</option>
                        @endcan
                    </select>
                    <button type="submit" class="btn btn-circle btn-info">
                        <span>New Reports</span>
                    </button>
                    </div>

                </form>

            </div>
{{--            <div class="col-md-2 text-md-right">--}}
{{--                <button onclick="newReports(this)" class="btn btn-circle btn-info">--}}
{{--                    <span>New Reports</span>--}}
{{--                </button>--}}
{{--            </div>--}}
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="table_id" class="">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Created at</th>
                    <th>Period</th>
                    <th>Status</th>
                    <th>Mission</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)

                    <tr>
                        <td>{{$report->id}}</td>
                        <td>{{$report->created_at->format('d.m.Y H:i:s')}}</td>
                        <td>({{$report->start->format('d.m.Y') ?? ''}} - {{$report->end->format('d.m.Y') ?? ''}})</td>
                        <td>{{ $report->status_name }}</td>
                        <td><a href="{!! route('admin.download', $report->id) !!}">Download</a></td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection


@section('modal')
    @include('modals.delete_modal')
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
            $('#table_id').DataTable({
                stateSave: true
            });
        } );
        function newReports(){
            // e.preventDefault();
            let start = $("#start").val();
            let end = $("#end").val();
            let status = $("#status").val();
            $.ajax({
                url: '{{route('admin.reports')}}',
                type: "POST",
                data: {
                    start: start,
                    end: end,
                    status: status
                },
                success: function (response) {
                    $(this).slideUp(deleteElement);
                },
                error: function () {
                    alert('Nothing found');
                }
            })
        }

    </script>
@endsection
