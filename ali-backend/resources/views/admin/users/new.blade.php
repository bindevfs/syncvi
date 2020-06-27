@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Người dùng mới</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Id</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Số điện thoại</th>
                                <th class="text-center">Địa chỉ</th>
                                <th id='sortUser' class="text-center dropdown-toggle">Đơn hàng</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            @foreach($newusers as $newuser)
                                <tbody>
                                <tr>
                                    <td class="text-center text-muted">SVU{{$newuser->id}}</td>
                                    <td class="text-center">{{$newuser->name}}</td>
                                    <td class="text-center">{{$newuser->email}}</td>
                                    <td class="text-center">{{$newuser->phone}}</td>
                                    <td class="text-center">{{$newuser->address}}</td>
                                    <td class="text-center">
                                        <div class="badge badge-warning">{{$newuser->numberOrder}}</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" data-index="{{$newuser->id}}" class="disable_newuser btn btn-primary btn-sm">@if($newuser->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$newusers->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#newusers').addClass('mm-active');
            $('#manaadmins').removeClass('mm-active');
            $('#statistic').removeClass('mm-active');
            $('#manaproducts').removeClass('mm-active');
            $('#manashops').removeClass('mm-active');
            $('#manausers').removeClass('mm-active');
            $('#newadmins').removeClass('mm-active');
            $('#newproducts').removeClass('mm-active');
            $('#newshops').removeClass('mm-active');
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.disable_newuser').each(function (index) {
                $(this).click(function () {
                    var newuser_id = $(this).attr('data-index');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('disableUser') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'user_id': newuser_id},
                        success: function (data) {
                            if(data.success) {
                                if(data.deleted_at == null) {
                                    $('.disable_newuser').each(function () {
                                        if ($(this).attr('data-index') === newuser_id) {
                                            $(this).text('Kích hoạt');
                                        }
                                    });
                                }
                                else {
                                    $('.disable_newuser').each(function () {
                                        if ($(this).attr('data-index') === newuser_id) {
                                            $(this).text('Vô hiệu hóa');
                                        }
                                    });
                                }
                            }
                        }
                    });
                })
            })
        })
    </script>
@endsection
