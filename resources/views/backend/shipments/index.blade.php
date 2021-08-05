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
                    <a href="{{ route('admin.orders.create') }}" class="btn btn-light-primary font-weight-bolder btn-sm"><i class="flaticon2-add-1"></i> {{ ('Add New Shipment')}}</a>
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
            <table id="table_id" class="">
                <thead>
                <tr>
                    <th></th>
                    <th>Number order</th>
                    <th>Shipper</th>
                    <th>Phone shipper</th>
                    <th>Consignee</th>
                    <th>Phone consignee</th>
                    <th>Invoice number</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Mission</th>
                </tr>
                </thead>
                <tbody>

                @can('Agent')
                    @foreach($orders as $key=>$shipment)
                        @can('manage-agent',$shipment)
                            <tr>
                                <th></th>
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


                                <th>{{$shipment->status->name}}</th>
                                <th>{{$shipment->created_at}}</th>
                                <td class="text-center">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                        <i class="las la-eye"></i>
                                    </a>
                                </td>

                            </tr>
                        @endcan
                    @endforeach
                @elsecan('Driver')
                    @foreach($orders as $key=>$shipment)

                        @can('manage-driver',$shipment)
                            <tr>
                                <th></th>
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


                                <th>{{$shipment->status->name}}</th>
                                <th>{{$shipment->created_at}}</th>
                                <td class="text-center">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                        <i class="las la-eye"></i>
                                    </a>
                                </td>

                            </tr>
                        @endcan
                    @endforeach
                @else
{{--                    @dd($orders)--}}
                    @foreach($orders as $key=>$shipment)
                        <tr>
                            <th>
                                @php
                                    $start_point = $shipment->tracker->where('position',0)->first();
                                   // $start_hour  = $start_point->start_time->format('Y-m-d H:i:s');
                                    $start_hour  = new DateTime($start_point->start_time);
                                    $end_hour  = new DateTime($start_point->end_time);
                                  //  dd($start_hour->format('H:i'));
                                    $end_point = $shipment->tracker->where('position',2)->first();
                                    $last_start_hour  = new DateTime($end_point->start_time);
                                    $last_end_hour  = new DateTime($end_point->end_time);
                                @endphp
{{--                                @dd($start_point)--}}
                                <label>{{$start_point->cargolocation->name}}({{$start_point->cargolocation->city}})</label>
                                <input type="checkbox" @if($start_point->status == 'Arrived') checked disabled @endif>
                                <p>Estimated time: {{$start_hour->format('H:i')}} ({{$start_hour->format('d.m.Y')}}) </p>
                                <p>Actual time: {{$end_hour->format('H:i')}} </p>
{{--                                    @if($start_point->alert == 'bad')--}}
                                    @if($start_hour->format('H:i') < $end_hour->format('H:i'))
                                        <p style="color: red;">АЛЕРТ</p>
                                    @endif
                                <hr>
                                @foreach($shipment->tracker as $tracker)
                                    @if($tracker->position == 1)
                                        @php
                                            $tracker_start_hour  = new DateTime($tracker->start_time);
                                            $tracker_end_hour  = new DateTime($tracker->end_time);
                                        @endphp
                                        <label>{{$tracker->cargolocation->name}}({{$tracker->cargolocation->city}})</label>
                                        <input type="checkbox" @if($tracker->status == 'Arrived') checked disabled @endif>
                                        <p>{{$tracker_start_hour->format('H:i')}} ({{$tracker_start_hour->format('d.m.Y')}}) </p>
                                        <p>{{$tracker_end_hour->format('H:i')}} </p>
{{--                                        @if($tracker->alert == 'bad')--}}
                                        @if($tracker_start_hour->format('H:i') < $tracker_end_hour->format('H:i'))
                                            <p style="color: red;">АЛЕРТ</p>
                                        @endif
                                    @endif
                                @endforeach
                                <hr>
                                <label>{{$end_point->cargolocation->name}}({{$end_point->cargolocation->city}})</label>
                                <input type="checkbox" @if($end_point->status == 'Arrived') checked disabled @endif>
                                <p>{{$last_start_hour->format('H:i')}} ({{$last_start_hour->format('d.m.Y')}}) </p>
                                <p>{{$last_start_hour->format('H:i')}} </p>
                                @if($end_point->alert == 'bad')
                                    <p style="color: red;">АЛЕРТ</p>
                                @endif


                            </th>
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


                            <th>{{$shipment->status->name}}</th>
                            <th>{{$shipment->created_at}}</th>
                            <td class="text-center">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.orders.show', $shipment->id)}}" title="Show">
                                    <i class="las la-eye"></i>
                                </a>
                                @canany(['SuperUser','Manager','OPS'], Auth::user())
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('admin.orders.edit', $shipment->id)}}" title="{{  ('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                @endcanany
                            </td>

                        </tr>
                    @endforeach
                @endcan

                </tbody>
            </table>











        </form>
    </div>
    </div>
@endsection
@section('modal')
    {{--@include('modals.delete_modal')--}}
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table_id').DataTable();
        } );
    </script>
    <script type="text/javascript">
        $(document).on('click','#submit_transfer',function(){
            $('#tableForm').submit();
        });
        $('#reset_search').click(function(e) {
            e.preventDefault();
            $('#search_form')[0].reset();
        });
        function openCaptainModel(element, e) {
            var selected = [];
            var selected_payment_method = [];
            var count_payment_method = 0 ;
            var selected_address_sender = [];
            var selected_address = [];
            var selected_branch_hidden = [];
            var mission_id = [];
            $('.sh-check:checked').each(function() {
                selected.push($(this).data('clientid'));
                selected_payment_method.push($(this).data('paymentmethodid'));
                selected_address_sender.push($(this).data('clientaddresssender'));
                selected_address.push($(this).data('clientaddress'));
                selected_branch_hidden.push($(this).data('branchid'));
                mission_id.push($(this).data('missionid'));
            });
            console.log(selected_payment_method);
            if (selected.length != 0)
            {
                if(mission_id[0] == ""){
                    var sum = selected.reduce(function(acc, val) { return acc + val; },0);
                    var check_sum = selected[0] * selected.length;
                    if (selected.length == 1 || sum == check_sum) {
                        selected_payment_method.forEach((element, index) => {
                            if(selected_payment_method[0] == selected_payment_method[index]){
                                count_payment_method++;
                            }
                        });
                        if(selected_payment_method.length == count_payment_method)
                        {
                            $('#tableForm').attr('action', $(element).data('url'));
                            $('#tableForm').attr('method', $(element).data('method'));
                            $('#pick_up_address').val(selected_address_sender[0]);
                            $('#assign-to-captain-modal').modal('toggle');
                            $('#supply_address').val(selected_address_sender[0]);
                            $('#pick_up_client_id').val(selected[0]);
                            $('#pick_up_client_id_hidden').val(selected[0]);
                            $('.branch_hidden').val(selected_branch_hidden[0]);
                        }else{
                            Swal.fire("{{ ('Select shipments of the same payment method')}}", "", "error");
                        }
                    } else if (selected.length == 0) {
                        Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
                    }else{
                        Swal.fire("{{ ('Select shipments of the same client to Assign')}}", "", "error");
                    }
                }else{
                    Swal.fire("{{ ('This Shipment Already In Mission')}}", "", "error");
                }
            }else{
                Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
            }
        }
        function openAssignShipmentCaptainModel(element, e) {
            var selected = [];
            var selected_payment_method = [];
            var count_payment_method = 0 ;
            var selected_address = [];
            var selected_name = [];
            var selected_state = [];
            var selected_state_hidden = [];
            var selected_area = [];
            var selected_area_hidden = [];
            var selected_branch_hidden = [];
            var mission_id = [];
            $('.sh-check:checked').each(function() {
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
            if (selected.length != 0)
            {
                if(mission_id[0] == ""){
                    var sum = selected.reduce(function(acc, val) { return acc + val; },0);
                    var check_sum = selected[0] * selected.length;
                    if (selected.length == 1 || sum == check_sum ) {
                        selected_payment_method.forEach((element, index) => {
                            if(selected_payment_method[0] == selected_payment_method[index]){
                                count_payment_method++;
                            }
                        });
                        if(selected_payment_method.length == count_payment_method)
                        {
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
                        }else{
                            Swal.fire("{{ ('Select shipments of the same payment method')}}", "", "error");
                        }
                    } else if (selected.length == 0) {
                        Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
                    }else{
                        Swal.fire("{{ ('Select shipments of the same client to Assign')}}", "", "error");
                    }
                }else{
                    Swal.fire("{{ ('This Shipment Already In Mission')}}", "", "error");
                }
            }else{
                Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
            }
        }
        function openTransferShipmentCaptainModel(element, e) {
            var selected = [];
            var branchId = '';
            var branchName = '';
            var mission_id = [];
            var selected_payment_method = [];
            var count_payment_method = 0 ;
            $('#to_branch_id option').css("display","block");
            $('.sh-check:checked').each(function() {
                selected_payment_method.push($(this).data('paymentmethodid'));
                selected.push($(this).data('clientid'));
                branchId = $(this).data('branchid');
                branchName = $(this).data('branchname');
                mission_id.push($(this).data('missionid'));
            });
            if (selected.length != 0)
            {
                if(mission_id[0] == ""){
                    var sum = selected.reduce(function(acc, val) { return acc + val; },0);
                    var check_sum = selected[0] * selected.length;
                    if (selected.length == 1 || sum == check_sum ) {
                        selected_payment_method.forEach((element, index) => {
                            if(selected_payment_method[0] == selected_payment_method[index]){
                                count_payment_method++;
                            }
                        });
                        if(selected_payment_method.length == count_payment_method)
                        {
                            $('#assign-to-captain-modal').remove();
                            $('#tableForm').attr('action', $(element).data('url'));
                            $('#tableForm').attr('method', $(element).data('method'));
                            document.getElementById("from_branch_transfer").value = branchName;
                            $('#to_branch_id option[value='+ branchId +']').css("display","none");
                            $('#to_branch_id option[value='+ branchId +']').find('option:selected').remove();
                            $('#transfer-to-branch-modal').modal('toggle');
                        }else{
                            Swal.fire("{{ ('Select shipments of the same payment method')}}", "", "error");
                        }
                    } else if (selected.length == 0) {
                        Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
                    }else{
                        Swal.fire("{{ ('Select shipments of the same client to Assign')}}", "", "error");
                    }
                }else{
                    Swal.fire("{{ ('This Shipment Already In Mission')}}", "", "error");
                }
            }else{
                Swal.fire("{{ ('Please Select Shipments')}}", "", "error");
            }
        }
        function check_client(parent_checkbox,client_id) {
            // if(parent_checkbox.checked){
            //     console.log("checked");
            // }
            checkboxs = document.getElementsByClassName("checkbox-client-id-"+client_id);
            for (let index = 0; index < checkboxs.length; index++) {
                checkboxs[index].checked = parent_checkbox.checked;
            }
        }
        $(document).ready(function() {
            $('.action-caller').on('click', function(e) {
                e.preventDefault();
                var selected = [];
                $('.sh-check:checked').each(function() {
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
