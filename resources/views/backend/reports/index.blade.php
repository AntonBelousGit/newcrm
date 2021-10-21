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
                        <option value="1">New Order</option>
                        <option value="2">Accepted in work</option>
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
                    <th>Next Routing Point</th>
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
                        <td></td>
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
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#table_id thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#table_id thead');

            var table = $('#table_id').DataTable({
                stateSave: true,
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function() {
                    var api = this.api();

                    // For each column
                    api
                        .columns([3, 4])
                        .eq(0)
                        .each(function(colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');

                            // On every keypress in this input
                            $(
                                'input',
                                $('.filters th').eq($(api.column(colIdx).header()).index())
                            )
                                .off('keyup change')
                                .on('keyup change', function(e) {
                                    e.stopPropagation();

                                    // Get the search value

                                    $(this).attr('title', $(this).val());
                                    console.log($(this).val());

                                    var regexr =
                                        '({search})'; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api
                                        .column(colIdx)
                                        .search(
                                            this.value != '' ? regexr.replace('{search}',
                                                '(((' + this.value + ')))') : '',
                                            this.value != '',
                                            this.value == ''
                                        )
                                        .draw();

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },
            });
        });
        // $(document).ready(() => {
        //     $('#table_id').DataTable();
        // });
        // $(document).ready( function () {
        //     $('#table_id').DataTable();
        // } );
        // $(document).ready( function () {
        //     $('#table_id').DataTable({
        //         stateSave: true
        //     });
        // } );
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
