@extends('backend.layouts.app')
@php
    $user_type = Auth::user()->user_type;
    $staff_permission = json_decode(Auth::user()->staff->role->permissions ?? "[]");
    $auth_user = Auth::user();
@endphp
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
        <form id="tableForm">
            @csrf()
            <div class="wrap_table">
                <table id="table_id" class="">
                    <thead>
                    <tr>
                        <th>Number order</th>
                        <th>Shipper</th>
                        <th>Phone shipper</th>
                        <th>Consignee</th>
                        <th>Phone consignee</th>
                        <th>NWB number</th>
                        <th>Location</th>
                        <th>Status</th>
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
                                    <th>{{$shipment->id}}</th>
                                    <th>{{$shipment->shipper}}</th>
                                    <th>{{$shipment->phone_shipper}}</th>
                                    <th>{{$shipment->consignee}}</th>
                                    <th>{{$shipment->phone_consignee}}</th>
                                    <th>
                                        @php
                                            echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                        @endphp
                                    </th>

                                    <th>{{$shipment->locations}}</th>

                                    @php
                                        if($shipment->status_id == 3 || $shipment->status_id == 4 )
                                            {
                                                echo '<th>'.$shipment->substatus->name.'</th>';
                                            }
                                        else
                                            {
                                                echo '<th>'.$shipment->status->name.'</th>';
                                            }
                                    @endphp
                                    <th>{{$shipment->created_at}}</th>
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
                                {{--                                <tr>--}}
                                {{--                                    <th>{{$shipment->id}}</th>--}}
                                {{--                                    <th>{{$shipment->shipper}}</th>--}}
                                {{--                                    <th>{{$shipment->phone_shipper}}</th>--}}
                                {{--                                    <th>{{$shipment->consignee}}</th>--}}
                                {{--                                    <th>{{$shipment->phone_consignee}}</th>--}}
                                {{--                                    <th>--}}
                                {{--                                        @php--}}
                                {{--                                            echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);--}}
                                {{--                                        @endphp--}}
                                {{--                                    </th>--}}

                                {{--                                    <th>{{$shipment->cargolocation->name}}</th>--}}

                                {{--                                    <th>{{$shipment->status->name}}</th>--}}
                                {{--                                    <th>{{$shipment->created_at}}</th>--}}
                                {{--                                    <td class="text-center">--}}
                                {{--                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.orders.show', $shipment->id)}}" title="Show">--}}
                                {{--                                            <i class="las la-eye"></i>--}}
                                {{--                                        </a>--}}
                                {{--                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.orders.edit-driver', $shipment->id)}}" title="{{  ('Edit') }}">--}}
                                {{--                                            <i class="las la-edit"></i>--}}
                                {{--                                        </a>--}}
                                {{--                                    </td>--}}

                                {{--                                </tr>--}}
                                <tr>
                                    <th>{{$shipment->id}}</th>
                                    <th>{{$shipment->shipper}}</th>
                                    <th>{{$shipment->phone_shipper}}</th>
                                    <th>{{$shipment->consignee}}</th>
                                    <th>{{$shipment->phone_consignee}}</th>
                                    <th>
                                        @php
                                            echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                        @endphp
                                    </th>

                                    <th>{{$shipment->locations}}</th>

                                    @php
                                        if($shipment->status_id == 3 || $shipment->status_id == 4 )
                                            {
                                                echo '<th>'.$shipment->substatus->name.'</th>';
                                            }
                                        else
                                            {
                                                echo '<th>'.$shipment->status->name.'</th>';
                                            }
                                    @endphp
                                    <th>{{$shipment->created_at}}</th>
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
                                    <th>{{$shipment->id}}</th>
                                    <th>{{$shipment->shipper}}</th>
                                    <th>{{$shipment->phone_shipper}}</th>
                                    <th>{{$shipment->consignee}}</th>
                                    <th>{{$shipment->phone_consignee}}</th>
                                    <th>
                                        @php
                                            echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                        @endphp
                                    </th>

                                    <th>{{$shipment->locations}}</th>

                                    @php
                                        if($shipment->status_id == 3 || $shipment->status_id == 4 )
                                            {
                                                echo '<th>'.$shipment->substatus->name.'</th>';
                                            }
                                        else
                                            {
                                                echo '<th>'.$shipment->status->name.'</th>';
                                            }
                                    @endphp
                                    <th>{{$shipment->created_at}}</th>
                                    <td class="text-center">
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                            <i class="las la-eye"></i>
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
                                <th>{{$shipment->id}}</th>
                                <th>{{$shipment->shipper}}</th>
                                <th>{{$shipment->phone_shipper}}</th>
                                <th>{{$shipment->consignee}}</th>
                                <th>{{$shipment->phone_consignee}}</th>
                                <th>
                                    @php
                                        echo str_pad($shipment->invoice_number, 6, "0", STR_PAD_LEFT);
                                    @endphp
                                </th>

                                <th>{{$shipment->locations}}</th>

                                    @php
                                        if($shipment->status_id == 3 || $shipment->status_id == 4 )
                                            {
                                                echo '<th>'.$shipment->substatus->name.'</th>';
                                            }
                                        else
                                            {
                                                echo '<th>'.$shipment->status->name.'</th>';
                                            }
                                    @endphp
                                <th>{{$shipment->created_at}}</th>
                                <td class="text-center">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                       href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                        <i class="las la-eye"></i>
                                    </a>
                                    @canany(['SuperUser','Manager','OPS'], Auth::user())
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                           href="{{route('admin.orders.edit', $shipment->id)}}" title="{{  ('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
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
    <script type="text/javascript">

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

        $(document).ready(function () {
            var table = $('#table_id').DataTable({});
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
            // FormValidation.formValidation(
            //     document.getElementById('tableForm'), {
            //         fields: {
            //             "Mission[address]": {
            //                 validators: {
            //                     notEmpty: {
            //                         message: '{{ ("This is required!")}}'
            //                     }
            //                 }
            //             },
            //             "Mission[client_id]": {
            //                 validators: {
            //                     notEmpty: {
            //                         message: '{{ ("This is required!")}}'
            //                     }
            //                 }
            //             },
            //             "Mission[to_branch_id]": {
            //                 validators: {
            //                     notEmpty: {
            //                         message: '{{ ("This is required!")}}'
            //                     }
            //                 }
            //             }
            //         },
            //         plugins: {
            //             autoFocus: new FormValidation.plugins.AutoFocus(),
            //             trigger: new FormValidation.plugins.Trigger(),
            //             // Bootstrap Framework Integration
            //             bootstrap: new FormValidation.plugins.Bootstrap(),
            //             // Validate fields when clicking the Submit button
            //             submitButton: new FormValidation.plugins.SubmitButton(),
            //             // Submit the form when all fields are valid
            //             defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            //             icon: new FormValidation.plugins.Icon({
            //                 valid: 'fa fa-check',
            //                 invalid: 'fa fa-times',
            //                 validating: 'fa fa-refresh',
            //             }),
            //         }
            //     }
            // );
        });
    </script>
@endsection
