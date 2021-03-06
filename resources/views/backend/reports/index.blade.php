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
                        <input type="text" id="comment" name="comment" placeholder="Comment" class="form-control">
                        <input type="date" id="start" name="start" value="2021-01-01" class="form-control">
                        <input type="date" id="end" name="end" value="{{now()->format('Y-m-d')}}" class="form-control">
                        @cannot('Client',Auth::id())
                            <select name="driver" id="driver" class="form-control">
                                <option value="null">Driver</option>
                                @foreach ($drivers as $item)
                                    <option value="{{$item->id}}">{{$item->fullname}}</option>
                                @endforeach
                            </select>
                            <select name="agent" id="agent" class="form-control">
                                <option value="null">Agent</option>
                                @foreach ($agents as $item)
                                    <option value="{{$item->id}}">{{$item->fullname}}</option>
                                @endforeach
                            </select>
                        @endcannot
                        @can('Client',Auth::id())
                            <input type="hidden" name="driver" value="null">
                            <input type="hidden" name="agent" value="null">
                        @endcan
                        <select name="status" id="status" class="form-control">
                            <option value="null">Status</option>
                            <option value="1">New Order</option>
                            <option value="2">Accepted in work</option>
                            <option value="6">Delivered</option>
                            <option value="9">Invoiced</option>
                            <option value="0">All shipments</option>
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
                    <th>Comment</th>
                    <th>Created at</th>
                    <th>Period</th>
                    @canany(['Administration'],Auth::id())
                    <th>Creator</th>
                    @endcanany
                    <th>Status</th>
                    <th>Mission</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{$report->id}}</td>
                        <td>{{$report->comment}}</td>
                        <td>{{$report->created_at->format('d.m.Y H:i:s')}}</td>
                        <td>({{($report->start)?$report->start->format('d.m.Y'): ''}}
                            - {{($report->end)?$report->end->format('d.m.Y'): ''}})
                        </td>
                        @canany(['Administration'],Auth::id())
                        <td>{{$report->user->name}}-({{$report->user->roles->first()->name}})</td>
                        @endcanany
                        <td>{{$report->status_name}}</td>
                        <td>
                            <a href="{!! route('admin.download', $report->id) !!}">Download</a>
                            <form action="{{route('admin.report.destroy', $report->id)}}" class="d-inline"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                        data-toggle="tooltip"><i class="las la-trash"
                                                                 aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
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
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            // $('#table_id thead tr')
            // .clone(true)
            // .addClass('filters')
            // .appendTo('#table_id thead');

            var table = $('#table_id').DataTable({
                stateSave: true,
                orderCellsTop: true,
                fixedHeader: true,
                // initComplete: function () {
                //     var api = this.api();
                //
                //     // For each column
                //     api
                //         .columns([3, 4])
                //         .eq(0)
                //         .each(function (colIdx) {
                //             // Set the header cell to contain the input element
                //             var cell = $('.filters th').eq(
                //                 $(api.column(colIdx).header()).index()
                //             );
                //             var title = $(cell).text();
                //             $(cell).html('<input type="text" placeholder="' + title + '" />');
                //
                //             // On every keypress in this input
                //             $(
                //                 'input',
                //                 $('.filters th').eq($(api.column(colIdx).header()).index())
                //             )
                //                 .off('keyup change')
                //                 .on('keyup change', function (e) {
                //                     e.stopPropagation();
                //
                //                     // Get the search value
                //
                //                     $(this).attr('title', $(this).val());
                //                     console.log($(this).val());
                //
                //                     var regexr =
                //                         '({search})'; //$(this).parents('th').find('select').val();
                //
                //                     var cursorPosition = this.selectionStart;
                //                     // Search the column for that value
                //                     api
                //                         .column(colIdx)
                //                         .search(
                //                             this.value != '' ? regexr.replace('{search}',
                //                                 '(((' + this.value + ')))') : '',
                //                             this.value != '',
                //                             this.value == ''
                //                         )
                //                         .draw();
                //
                //                     $(this)
                //                         .focus()[0]
                //                         .setSelectionRange(cursorPosition, cursorPosition);
                //                 });
                //         });
                // },
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
        function newReports() {
            // e.preventDefault();
            let comment = $("#comment").val();
            let start = $("#start").val();
            let end = $("#end").val();
            let status = $("#status").val();
            let driver = $("#driver").val();
            let agent = $("#agent").val();
            $.ajax({
                url: '{{route('admin.reports')}}',
                type: "POST",
                data: {
                    comment: comment,
                    start: start,
                    end: end,
                    status: status,
                    driver: driver,
                    agent: agent,
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
