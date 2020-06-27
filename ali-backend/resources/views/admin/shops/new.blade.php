@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Cửa hàng mới</div>
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
                                <th class="text-center">Đơn hàng</th>
                                <th class="text-center">Nhân viên</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            @foreach($newshops as $newshop)
                                <tbody>
                                <tr>
                                    <td class="text-center text-muted">SVS{{$newshop->id}}</td>
                                    <td class="text-center">{{$newshop->name}}</td>
                                    <td class="text-center">{{$newshop->email}}</td>
                                    <td class="text-center">{{$newshop->phone}}</td>
                                    <td class="text-center">{{$newshop->address}}</td>
                                    <td class="text-center">
                                        <div class="badge badge-warning">{{$newshop->numberOrder}}</div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="count_newShopUser btn btn-info btn-sm"><a href="{{route('manageShopUser').'?shop_id='.$newshop->id}}">{{$newshop->numberShopUser}}</a></button>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" data-index="{{$newshop->id}}" class="disable_newshop btn btn-primary btn-sm">@if($newshop->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$newshops->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#newshops').addClass('mm-active');
            $('#manaadmins').removeClass('mm-active');
            $('#statistic').removeClass('mm-active');
            $('#manaproducts').removeClass('mm-active');
            $('#manashops').removeClass('mm-active');
            $('#manausers').removeClass('mm-active');
            $('#newadmins').removeClass('mm-active');
            $('#newproducts').removeClass('mm-active');
            $('#newusers').removeClass('mm-active');
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.disable_newshop').each(function (index) {
                $(this).click(function () {
                    var newshop_id = $(this).attr('data-index');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('disableShop') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'shop_id': newshop_id},
                        success: function (data) {
                            if(data.success) {
                                if(data.deleted_at == null) {
                                    $('.disable_newshop').each(function () {
                                        if ($(this).attr('data-index') === newshop_id) {
                                            $(this).html('<button type="button" data-index="{{$newshop->id}}" class="disable_newshop btn btn-primary btn-sm">Kích hoạt</button>');
                                        }
                                    });
                                }
                                else {
                                    $('.disable_newshop').each(function () {
                                        if ($(this).attr('data-index') === newshop_id) {
                                            $(this).html('<button type="button" data-index="{{$newshop->id}}" class="disable_newshop btn btn-primary btn-sm">Vô hiệu hóa</button>');
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
