@extends('backend.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/sweetalert/sweetalert.css')}}">
@endsection
@if(!isset($dashboard))
@section('subheader')
    <!--begin::Subheader-->
    <div class="py-2 subheader py-lg-6 subheader-solid" id="kt_subheader">
        <div class="flex-wrap container-fluid d-flex align-items-center justify-content-between flex-sm-nowrap">
            <!--begin::Info-->
            <div class="flex-wrap mr-1 d-flex align-items-center">
                <!--begin::Page Heading-->
                <div class="flex-wrap mr-5 d-flex align-items-baseline">
                    <!--begin::Page Title-->
                    <h5 class="my-1 mr-5 text-dark font-weight-bold">{{ ('Shipments')}}</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="p-0 my-2 mr-5 breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.index')}}" class="text-muted">{{ ('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">{{  ('Shipments') }}</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                    <a href="{{ route('admin.orders.create') }}"
                       class="btn btn-light-primary font-weight-bolder btn-sm"><i
                            class="flaticon2-add-1"></i> {{ ('Add New Shipment')}}</a>
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
@endsection
@endif
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
        <div class="abs">
            <select id="multiViber" name="loh">
                <option value="0">
                    Choose action
                </option>
                <option value="1">
                    Print List of Jobs
                </option>
            </select>
            <button id="appForm" type="button">Submit</button>
            <div id="outputField"></div>
        </div>
        <form id="tableForm">
            @csrf()
            <div class="wrap_table dnon-h2" id="fixAdaptiv">
                <table id="table_id" class="">
                    <thead>
                    <tr>
                        <th></th>
                        <th>№</th>
                        <th>Shipper's company name</th>
                        <th>Consignee's company name</th>
                        <th>Client HWB</th>
                        <th>HWB number</th>
                        <th>Status</th>
                        <th>Next Routing Point</th>
                        <th>Created at</th>
                        <th>Mission</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @can('Agent')
                        @foreach($orders as $key=>$shipment)
                            @can('manage-agent',$shipment)
                                <tr>
                                    <td><input class="checkbox" type="checkbox"/></td>
                                    <td class='idTable'>{{$shipment->id}}</td>
                                    <td>
                                        <div class="text_table">
                                            {{$shipment->company_shipper}}
                                            <div class="display_none_text">
                                                {{$shipment->shipper}}<br>
                                                {{$shipment->phone_shipper}}<br>
                                                {{$shipment->tracker->where('position','0')->first()->address}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text_table">
                                            {{$shipment->company_consignee}}
                                            <div class="display_none_text">
                                                {{$shipment->consignee}}<br>
                                                {{$shipment->phone_consignee}}<br>
                                                {{$shipment->tracker->where('position','2')->first()->address}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{$shipment->client_hwb}}
                                    </td>
                                    <td>
                                        @php
                                            echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                        @endphp
                                    </td>


                                    @php
                                        if ($shipment->status_id == 8)
                                        {
                                            if ($shipment->tracker->where('position','1')->count() == 1){
                                                echo '<th>'.$shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                            }
                                            else{
                                                echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.'</th>';
                                            }
                                        }
                                        elseif ($shipment->status_id == 3){
                                           echo '<th>'.$shipment->status->name.' ->'. $shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                        }
                                        elseif ($shipment->status_id == 4){
                                            $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
                                            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';                                        }
                                        else
                                        {
                                           echo '<th>'.$shipment->status->name.'</th>';
                                        }
                                    @endphp
                                    <td></td>
                                    <td>{{$shipment->created_at}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                            <i class="las la-eye"></i>
                                        </a>

                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.edit-agent', $shipment->id)}}"
                                           title="{{  ('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{!! route('admin.download_pdf', $shipment->id) !!}"
                                           title="Print">
                                            <i class="las la-print"></i>
                                        </a>
                                    </td>
                                    <td class="details-control">
                                        <input type="hidden" value="{{$shipment->id}}">
                                        <div class="btn_arr">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                    </td>
                                </tr>
                            @endcan
                        @endforeach
                    @elsecan('Driver')
                        @foreach($orders as $key=>$shipment)
                            @can('manage-driver',$shipment)
                                <tr>
                                    <td><input class="checkbox" type="checkbox"/></td>
                                    <td class='idTable'>{{$shipment->id}}</td>
                                    <td>
                                        <div class="text_table">
                                            {{$shipment->company_shipper}}
                                            <div class="display_none_text">
                                                {{$shipment->shipper}}<br>
                                                {{$shipment->phone_shipper}}<br>
                                                {{$shipment->tracker->where('position','0')->first()->address}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text_table">
                                            {{$shipment->company_consignee}}
                                            <div class="display_none_text">
                                                {{$shipment->consignee}}<br>
                                                {{$shipment->phone_consignee}}<br>
                                                {{$shipment->tracker->where('position','2')->first()->address}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                        @endphp
                                    </td>
                                    <td>
                                        {{$shipment->client_hwb}}
                                    </td>

                                    @php
                                        if ($shipment->status_id == 8)
                                        {
                                            if ($shipment->tracker->where('position','1')->count() == 1){
                                                echo '<th>'.$shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                            }
                                            else{
                                                echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.'</th>';
                                            }
                                        }
                                        elseif ($shipment->status_id == 3){
                                           echo '<th>'.$shipment->status->name.' ->'. $shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                        }
                                        elseif ($shipment->status_id == 4){
                                            $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
                                            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
                                        }
                                        else
                                        {
                                           echo '<th>'.$shipment->status->name.'</th>';
                                        }
                                    @endphp
                                    <td></td>
                                    <td>{{$shipment->created_at}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                            <i class="las la-eye"></i>
                                        </a>

                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.edit-driver', $shipment->id)}}"
                                           title="{{  ('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{!! route('admin.download_pdf', $shipment->id) !!}"
                                           title="Print">
                                            <i class="las la-print"></i>
                                        </a>
                                    </td>
                                    <td class="details-control">
                                        <input type="hidden" value="{{$shipment->id}}">
                                        <div class="btn_arr">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                    </td>
                                </tr>

                            @endcan
                        @endforeach
                    @elsecan('Client')
                        @foreach($orders as $key=>$shipment)
                            @can('manage-client',$shipment)

                                <tr>
                                    <td><input class="checkbox" type="checkbox"/></td>
                                    <td class='idTable'>{{$shipment->id}}</td>
                                    <td>
                                        <div class="text_table">
                                            {{$shipment->company_shipper}}
                                            <div class="display_none_text">
                                                {{$shipment->shipper}}<br>
                                                {{$shipment->phone_shipper}}<br>
                                                {{$shipment->tracker->where('position','0')->first()->address}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text_table">
                                            {{$shipment->company_consignee}}
                                            <div class="display_none_text">
                                                {{$shipment->consignee}}<br>
                                                {{$shipment->phone_consignee}}<br>
                                                {{$shipment->tracker->where('position','2')->first()->address}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{$shipment->client_hwb}}
                                    </td>
                                    <td>
                                        @php
                                            echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                        @endphp
                                    </td>


                                    @php
                                        if ($shipment->status_id == 8)
                                        {
                                            if ($shipment->tracker->where('position','1')->count() == 1){
                                                echo '<th>'.$shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                            }
                                            else{
                                                echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.'</th>';
                                            }
                                        }
                                        elseif ($shipment->status_id == 3){
                                           echo '<th>'.$shipment->status->name.' ->'. $shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                        }
                                        elseif ($shipment->status_id == 4){
                                            $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
                                            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
                                        }
                                        else
                                        {
                                           echo '<th>'.$shipment->status->name.'</th>';
                                        }
                                    @endphp
                                    <td></td>
                                    <td>{{$shipment->created_at}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{!! route('admin.download_pdf', $shipment->id) !!}"
                                           title="Print">
                                            <i class="las la-print"></i>
                                        </a>
                                    </td>

                                    <td class="details-control">
                                        <input type="hidden" value="{{$shipment->id}}">
                                        <div class="btn_arr">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                    </td>

                                </tr>
                            @endcan
                        @endforeach
                    @else
                        @foreach($orders as $key=>$shipment)
                            <tr>
                                <td><input class="checkbox" type="checkbox"/></td>
                                <td class='idTable'>{{$shipment->id}}</td>
                                <td>
                                    <div class="text_table">
                                        {{$shipment->company_shipper}}
                                        <div class="display_none_text">
                                            {{$shipment->shipper}}<br>
                                            {{$shipment->phone_shipper}}<br>
                                            {{$shipment->tracker->where('position','0')->first()->address}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text_table">
                                        {{$shipment->company_consignee}}
                                        <div class="display_none_text">
                                            {{$shipment->consignee}}<br>
                                            {{$shipment->phone_consignee}}<br>
                                            {{$shipment->tracker->where('position','2')->first()->address}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{$shipment->client_hwb}}
                                </td>
                                <td>
                                    @php
                                        echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                    @endphp
                                </td>


                                @php
                                    if ($shipment->status_id == 8)
                                    {
                                        if ($shipment->tracker->where('position','1')->count() == 1){
                                            echo '<th>'.$shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                            $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
                                            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
                                        }
                                        else{
                                            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.'</th>';
                                            $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
                                            echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
                                        }
                                    }
                                    elseif ($shipment->status_id == 3){
                                       echo '<th>'.$shipment->status->name.' ->'. $shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                       echo '<th>'.$shipment->tracker->where('position','1')->pluck('cargolocation')->first()->name.'</th>';
                                    }
                                    elseif ($shipment->status_id == 4){
                                        $location_name=!is_null($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first())?$shipment->tracker->where('position','1')->where('status','Awaiting arrival')->first()->cargolocation->name:$shipment->tracker->where('position','2')->where('status','Awaiting arrival')->first()->cargolocation->name;
                                         if($shipment->tracker->where('position','1')->where('status','Awaiting arrival')->count() === 0)
                                        {
                                          echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'+POD Pending</th>';
                                        }
                                        else
                                        {
                                           echo '<th>'.$shipment->tracker->where('position','1')->where('status','Arrived')->last()->cargolocation->name.' ->'. $location_name .'</th>';
                                        }
                                        echo '<th>'.$statuses[$shipment->status_id + 1]->name.'</th>';
                                    }
                                    elseif ($shipment->status_id == 5){
                                        echo '<th>'. $shipment->tracker->where('position','0')->first()->cargolocation->name .'->'. $shipment->tracker->where('position','2')->first()->cargolocation->name .'+'.$shipment->status->name.'</th>';
                                        echo '<th>'.$statuses[$shipment->status_id]->name.'</th>';
                                    }
                                    else
                                    {
                                       echo '<th>'.$shipment->status->name.'</th>';
                                       echo '<th>'.$statuses[$shipment->status_id]->name.'</th>';
                                    }
                                @endphp
                                {{--                                <th>{{$statuses[$shipment->status_id]->name}}</th>--}}
                                <td>{{$shipment->created_at}}</td>
                                <td class="text-center">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                       href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                       href="{{route('admin.orders.duplicate', $shipment->id)}}" title="Duplicate">
                                        <i class="far fa-copy"></i>
                                    </a>
                                    @canany(['SuperUser','Manager','OPS'], Auth::user())
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.edit', $shipment->id)}}" title="{{  ('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{!! route('admin.download_pdf', $shipment->id) !!}"
                                           title="Print">
                                            <i class="las la-print"></i>
                                        </a>
                                        <form action="{{route('admin.orders.destroy',$shipment->id)}}"
                                              class="d-inline-block" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <a data-toggle="tooltip" title="delete" data-id="{{$shipment->id}}"
                                               class="dltBtn btn btn-soft-primary btn-icon btn-circle btn-sm"
                                               data-placement="bottom" data-original-title="canceled">
                                                <i class="far fa-trash-alt"></i> </a>
                                        </form>
                                    @endcanany
                                </td>
                                <td class="details-control">
                                    <input type="hidden" value="{{$shipment->id}}">
                                    <div class="btn_arr">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endcan

                    </tbody>
                </table>
            </div>
        </form>
    </div>
    </div>
@endsection
@section('modal')
    {{--@include('modals.delete_modal')--}}
@endsection
@section('script')
    <script src="{{asset('assets/sweetalert/sweetalert.min.js')}}"></script>

    <script>


//         let option = document.getElementById('multiViber').addEventListener('change', function() {
//             return this.value;
//         });
            $('#multiViber').on('change', function () {
                option = this.value;
            });


            let arrayId = [];

            function removeVal(arr, val) {
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i] == val)
                        arr.splice(i, 1);
                }
            };
            const myCount = function () {
                $('#outputField').html($('.checkbox:checked').length + ' чекбоксов выбрано вами.');
                let boxes = $('.checkbox:checked');
                let boxLang = $('.checkbox:checked').length;
                idItem = $(this).parent().siblings('.idTable').text();
                if ($(this).prop('checked')) {
                    arrayId.push(idItem);
                } else {
                    removeVal(arrayId, idItem);
                }
            };
            myCount();

            $(function () {
                $('.checkbox').on('click', myCount);
                $('#appForm').click(function () {
                    formes();
                });
            })

            function formes() {
                $.ajax({
                    url: "{{route('admin.selected_orders')}}",
                    method: "POST",
                    data: {
                        order_id: arrayId,
                        option: option,
                    },
                    success: function (res) {
                    },
                    error: function (res) {
                    }
                });
            }

    </script>
    <script>
        $(document).ready(function () {
            //Setup - add a text input to each footer cell
            $('#table_id thead tr')
                .clone(true)
                .addClass('filters')
                .appendTo('#table_id thead');

            var table = $('#table_id').DataTable({
                stateSave: true,
                stateSaveCallback: function (settings, data) {
                    localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
                },
                stateLoadCallback: function (settings) {
                    return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
                },
                orderCellsTop: true,
                fixedHeader: true,
                initComplete: function () {
                    var api = this.api();

                    // For each column
                    api
                        .columns([5, 6])
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $('.filters th').eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            $(cell).html('<input type="text" placeholder="' + title + '" />');

                            // On every keypress in this input
                            $('input', $('.filters th').eq($(api.column(colIdx).header()).index()))
                                .off('keyup change')
                                .on('keyup change', function (e) {
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

                                    // ��� �� ����� ����� ������ ','
                                    if (this.value.indexOf(',') >= 0) {
                                        var ex = this.value.split(',');

                                        var vals = '';

                                        for (zz = 0; zz < ex.length; zz++) {
                                            if (vals != '') {
                                                vals += '|';
                                            }
                                            vals += ex[zz];
                                        }

                                        if (vals != '') {
                                            api.column(colIdx).search(
                                                this.value != '' ? regexr.replace('{search}', '(((' + vals + ')))') : '',
                                                this.value != '',
                                                this.value == ''
                                            ).draw();

                                        }
                                    }
                                    // ����� ���� �� ����� ����� ������ ','

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(cursorPosition, cursorPosition);
                                });
                        });
                },

            });
            $('#table_id tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var id = $(this).find('input[type="hidden"]').val();
                var row = table.row(tr);


                $.post('{{route('admin.orders.children')}}', {data: id})
                    .done(function (response) {
                        // var result = JSON.parse(response);

                        if (row.child.isShown()) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass('shown');
                        } else {
                            // Open this row
                            row.child(format(response)).show();
                            tr.addClass('shown');
                        }
                    })
                    .fail(function (error) {
                        alert(error.responseJSON.message);
                    })


            });
        });
    </script>
    <script type="text/javascript">

        @can('Client')
        function format(d) {
            // `d` is the original data object for the row
            var str_start_head = '<table class="table_custom"><thead><tr><th></th>';
            var str_end_head = '</tr></thead>';
            var str_start_body = '<tbody>';
            var str_start_body_row1 = '<tr><td>Estimated time:</td>';
            var str_end_body_row1 = '</tr>'

            var str_start_body_row2 = '<tr><td>Actual time:</td>';
            var str_end_body_row2 = '</tr>'

            var str_end_body = '</tbody></table>';

            // d.forEach(function(item, i, arr) {
            //     alert( i + ": " + item + " (массив:" + arr + ")" );
            // });

            for (i = 0; i < d.data.length; i++) {

                chototam = d.data[i].alert;
                var fez = ' ';
                gdetotam = d.data[i].status;
                if (gdetotam === 'Arrived') {
                    var pupa = '<i class="fas fa-check"></i>';
                } else {
                    var pupa = '';
                }

                str_start_head = str_start_head + '<th>' + d.data[i].cargolocation.name + '(' + d.data[i].cargolocation.city + ')' + '<div class="wrap_custom_check"><label for="check1" class="custom_check">' + pupa + '</label></div></th>';

                str_start_body_row1 = str_start_body_row1 + '<td >' + d.data[i].start_hour + '<span>(' + d.data[i].start_date + ')</span></td>';

                str_start_body_row2 = str_start_body_row2 + '<td >' + d.data[i].end_hour + '<br><span class="table_alert">' + fez + '</span></td>';
            }

            str_start_head = str_start_head + str_end_head + str_start_body + str_start_body_row1 + str_end_body_row1 + str_start_body_row2 + str_end_body_row2 + str_end_body;

            return str_start_head;
        }
        @else
        function format(d) {
            console.log(d);
            // `d` is the original data object for the row
            var str_start_head = '<table class="table_custom"><thead><tr><th></th>';
            var str_end_head = '</tr></thead>';
            var str_start_body = '<tbody>';
            var str_start_body_row1 = '<tr><td>Estimated time:</td>';
            var str_end_body_row1 = '</tr>'

            var str_start_body_row2 = '<tr><td>Actual time:</td>';
            var str_end_body_row2 = '</tr>'

            var str_end_body = '</tbody></table>';

            // d.forEach(function(item, i, arr) {
            //     alert( i + ": " + item + " (массив:" + arr + ")" );
            // });

            for (i = 0; i < d.data.length; i++) {

                chototam = d.data[i].alert;
                if (chototam === 'bad') {
                    var fez = '<i class="fas fa-exclamation-triangle"></i>';
                } else {
                    var fez = ' ';
                }
                gdetotam = d.data[i].status;
                if (gdetotam === 'Arrived') {
                    var pupa = '<i class="fas fa-check"></i>';
                } else {
                    var pupa = '';
                }

                str_start_head = str_start_head + '<th>' + d.data[i].cargolocation.name + '(' + d.data[i].cargolocation.city + ')' + '<div class="wrap_custom_check"><label for="check1" class="custom_check">' + pupa + '</label></div></th>';

                str_start_body_row1 = str_start_body_row1 + '<td >' + d.data[i].start_hour + '<span>(' + d.data[i].start_date + ')</span></td>';

                str_start_body_row2 = str_start_body_row2 + '<td >' + d.data[i].end_hour + '<br><span class="table_alert">' + fez + '</span></td>';
            }

            str_start_head = str_start_head + str_end_head + str_start_body + str_start_body_row1 + str_end_body_row1 + str_start_body_row2 + str_end_body_row2 + str_end_body;

            return str_start_head;
        }

        @endcan
    </script>
    <script type="text/javascript">
        $(document).on('click', '#submit_transfer', function () {
            $('#tableForm').submit();
        });
        $('#reset_search').click(function (e) {
            e.preventDefault();
            $('#search_form')[0].reset();
        });

        function openCaptainModel(element, e) {
            var selected = [];
            var selected_payment_method = [];
            var count_payment_method = 0;
            var selected_address_sender = [];
            var selected_address = [];
            var selected_branch_hidden = [];
            var mission_id = [];
            $('.sh-check:checked').each(function () {
                selected.push($(this).data('clientid'));
                selected_payment_method.push($(this).data('paymentmethodid'));
                selected_address_sender.push($(this).data('clientaddresssender'));
                selected_address.push($(this).data('clientaddress'));
                selected_branch_hidden.push($(this).data('branchid'));
                mission_id.push($(this).data('missionid'));
            });
            console.log(selected_payment_method);
            if (selected.length != 0) {
                if (mission_id[0] == "") {
                    var sum = selected.reduce(function (acc, val) {
                        return acc + val;
                    }, 0);
                    var check_sum = selected[0] * selected.length;
                    if (selected.length == 1 || sum == check_sum) {
                        selected_payment_method.forEach((element, index) => {
                            if (selected_payment_method[0] == selected_payment_method[index]) {
                                count_payment_method++;
                            }
                        });
                        if (selected_payment_method.length == count_payment_method) {
                            $('#tableForm').attr('action', $(element).data('url'));
                            $('#tableForm').attr('method', $(element).data('method'));
                            $('#pick_up_address').val(selected_address_sender[0]);
                            $('#assign-to-captain-modal').modal('toggle');
                            $('#supply_address').val(selected_address_sender[0]);
                            $('#pick_up_client_id').val(selected[0]);
                            $('#pick_up_client_id_hidden').val(selected[0]);
                            $('.branch_hidden').val(selected_branch_hidden[0]);
                        } else {
                            Swal.fire("{{ ('Select shipments of the same payment method')}}", "", "error");
                        }
                    } else if (selected.length == 0) {
                        Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
                    } else {
                        Swal.fire("{{ ('Select shipments of the same client to Assign')}}", "", "error");
                    }
                } else {
                    Swal.fire("{{ ('This Shipment Already In Mission')}}", "", "error");
                }
            } else {
                Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
            }
        }

        function openAssignShipmentCaptainModel(element, e) {
            var selected = [];
            var selected_payment_method = [];
            var count_payment_method = 0;
            var selected_address = [];
            var selected_name = [];
            var selected_state = [];
            var selected_state_hidden = [];
            var selected_area = [];
            var selected_area_hidden = [];
            var selected_branch_hidden = [];
            var mission_id = [];
            $('.sh-check:checked').each(function () {
                selected.push($(this).data('clientid'));
                selected_payment_method.push($(this).data('paymentmethodid'));
                selected_address.push($(this).data('clientaddress'));
                selected_name.push($(this).data('clientname'));
                selected_state.push($(this).data('clientstate'));
                selected_state_hidden.push($(this).data('clientstatehidden'));
                selected_area.push($(this).data('clientarea'));
                selected_area_hidden.push($(this).data('clientareahidden'));
                selected_branch_hidden.push($(this).data('branchid'));
                mission_id.push($(this).data('missionid'));
            });
            if (selected.length != 0) {
                if (mission_id[0] == "") {
                    var sum = selected.reduce(function (acc, val) {
                        return acc + val;
                    }, 0);
                    var check_sum = selected[0] * selected.length;
                    if (selected.length == 1 || sum == check_sum) {
                        selected_payment_method.forEach((element, index) => {
                            if (selected_payment_method[0] == selected_payment_method[index]) {
                                count_payment_method++;
                            }
                        });
                        if (selected_payment_method.length == count_payment_method) {
                            $('#tableForm').attr('action', $(element).data('url'));
                            $('#tableForm').attr('method', $(element).data('method'));
                            $('#assign-to-captain-modal').modal('toggle');
                            $('#delivery_address').val(selected_address[0]);
                            $('#delivery_name').val(selected_name[0]);
                            $('#delivery_state').val(selected_state[0]);
                            $('#delivery_state_hidden').val(selected_state_hidden[0]);
                            $('#delivery_area').val(selected_area[0]);
                            $('#delivery_area_hidden').val(selected_area_hidden[0]);
                            $('.branch_hidden').val(selected_branch_hidden[0]);
                            $('#pick_up_client_id').val(selected[0]);
                            $('#pick_up_client_id_hidden').val(selected[0]);
                        } else {
                            Swal.fire("{{ ('Select shipments of the same payment method')}}", "", "error");
                        }
                    } else if (selected.length == 0) {
                        Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
                    } else {
                        Swal.fire("{{ ('Select shipments of the same client to Assign')}}", "", "error");
                    }
                } else {
                    Swal.fire("{{ ('This Shipment Already In Mission')}}", "", "error");
                }
            } else {
                Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
            }
        }

        function openTransferShipmentCaptainModel(element, e) {
            var selected = [];
            var branchId = '';
            var branchName = '';
            var mission_id = [];
            var selected_payment_method = [];
            var count_payment_method = 0;
            $('#to_branch_id option').css("display", "block");
            $('.sh-check:checked').each(function () {
                selected_payment_method.push($(this).data('paymentmethodid'));
                selected.push($(this).data('clientid'));
                branchId = $(this).data('branchid');
                branchName = $(this).data('branchname');
                mission_id.push($(this).data('missionid'));
            });
            if (selected.length != 0) {
                if (mission_id[0] == "") {
                    var sum = selected.reduce(function (acc, val) {
                        return acc + val;
                    }, 0);
                    var check_sum = selected[0] * selected.length;
                    if (selected.length == 1 || sum == check_sum) {
                        selected_payment_method.forEach((element, index) => {
                            if (selected_payment_method[0] == selected_payment_method[index]) {
                                count_payment_method++;
                            }
                        });
                        if (selected_payment_method.length == count_payment_method) {
                            $('#assign-to-captain-modal').remove();
                            $('#tableForm').attr('action', $(element).data('url'));
                            $('#tableForm').attr('method', $(element).data('method'));
                            document.getElementById("from_branch_transfer").value = branchName;
                            $('#to_branch_id option[value=' + branchId + ']').css("display", "none");
                            $('#to_branch_id option[value=' + branchId + ']').find('option:selected').remove();
                            $('#transfer-to-branch-modal').modal('toggle');
                        } else {
                            Swal.fire("{{ ('Select shipments of the same payment method')}}", "", "error");
                        }
                    } else if (selected.length == 0) {
                        Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
                    } else {
                        Swal.fire("{{ ('Select shipments of the same client to Assign')}}", "", "error");
                    }
                } else {
                    Swal.fire("{{ ('This Shipment Already In Mission')}}", "", "error");
                }
            } else {
                Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
            }
        }

        function check_client(parent_checkbox, client_id) {
            // if(parent_checkbox.checked){
            //     console.log("checked");
            // }
            checkboxs = document.getElementsByClassName("checkbox-client-id-" + client_id);
            for (let index = 0; index < checkboxs.length; index++) {
                checkboxs[index].checked = parent_checkbox.checked;
            }
        }

        $(document).ready(function () {

            $('.action-caller').on('click', function (e) {
                e.preventDefault();
                var selected = [];
                $('.sh-check:checked').each(function () {
                    selected.push($(this).data('clientid'));
                });
                if (selected.length > 0) {
                    $('#tableForm').attr('action', $(this).data('url'));
                    $('#tableForm').attr('method', $(this).data('method'));
                    $('#tableForm').submit();
                } else if (selected.length == 0) {
                    Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
                }
            });
        });
    </script>

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function (e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once canceled, you will not be able to recover this Order",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                        swal("Poof! Your Order has been canceled!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your Order is safe!");
                    }
                });

        });
    </script>
@endsection
