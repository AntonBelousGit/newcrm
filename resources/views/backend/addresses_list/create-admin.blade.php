@extends('backend.layouts.app')

@section('content')

    <div class="mx-auto col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{  ('Addresses')}}</h5>
            </div>

            <form class="form-horizontal" action="{{ route('admin.addresses-list.store') }}" id="kt_form_1" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group supper-input">
                        <label>Addresses:</label>
                        <input type="text" id="search" class="form-control" placeholder="Address" name="address" required value="{{old('address')}}">
                        <div class="hint_search">
                        </div>

                        @error('address')
                        <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>User:</label>
                        <select class="form-control "  name="user_id">
                            <option></option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <div class="">
                            <div>
                                <input type="submit" class="btn btn-sm font-weight-bolder btn-light-primary" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            let count;

            $('#search').keyup(function(){
                count = $(this).val().length;
                if(count >= 2) {
                    $('.hint_search').slideDown(300);

                    $search = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: '{{route('admin.search')}}',
                        data: {'search': $search},
                        success: function(data){
                            $('.hint_search').text('').append($(data));
                        }

                    });

                } else {
                    $('.hint_search').slideUp(300);
                }
            });

            $(document).mouseup(function (e) {
                if (!$('.supper-input').is(e.target) // если клик был не по нашему блоку
                    && $('.supper-input').has(e.target).length === 0) { // и не по его дочерним элементам
                    $('.hint_search').slideUp(500);
                }
            });

        });

        function clickItem(elem) {
            $(elem).parent('ul').parent('.hint_search').parent('.supper-input').find('#search').val($(elem).html());
            $('.hint_search').slideUp(500);
        }
    </script>
@endsection
