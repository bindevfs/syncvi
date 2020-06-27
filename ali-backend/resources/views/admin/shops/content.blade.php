@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Cửa hàng&emsp;
                    <div class="dropdown d-inline-block">
                        <button id="option-role" type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-light">Chọn</button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                            <button data-index="0" type="button" tabindex="0" class="filter-shop dropdown-item">Tất cả</button>
                            <button data-index="1" type="button" tabindex="0" class="filter-shop dropdown-item">Hoạt động</button>
                            <button data-index="2" type="button" tabindex="0" class="filter-shop dropdown-item">Bị vô hiệu hóa</button>
                        </div>
                    </div>
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input search-shop" placeholder="Nhập tên, email hoặc SĐT">
                                <button class="search-icon"><span></span></button>
                            </div>
                            <button class="close"></button>
                        </div>
                    </div>
                </div>
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
                                <th id="sortShopByOrder" style="cursor: pointer" class="text-center dropdown-toggle">Đơn hàng</th>
                                <th id="sortShopByUser" style="cursor: pointer" class="text-center dropdown-toggle">Nhân viên</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            <tbody id="table-shop">
                            @foreach($shops as $shop)
                                <tr>
                                    <td class="text-center text-muted">SVS{{$shop->id}}</td>
                                    <td class="text-center">{{$shop->name}}</td>
                                    <td class="text-center">{{$shop->email}}</td>
                                    <td class="text-center">{{$shop->phone}}</td>
                                    <td class="text-center">{{$shop->address}}</td>
                                    <td class="text-center">
                                        @if($shop->numberOrder === 0)
                                            <button type="button" disabled class="count_ShopOrder btn btn-success" data-content="{{$shop->numberOrder}}">{{$shop->numberOrder}}</button>
                                        @else
                                            <button type="button" class="count_ShopOrder btn btn-success" data-content="{{$shop->numberOrder}}"><a data-pjax href="{{route('manageShopOrder').'?shop_id='.$shop->id}}">{{$shop->numberOrder}}</a></button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($shop->numberShopUser === 0)
                                            <button disabled type="button" class="count_ShopUser btn btn-info">{{$shop->numberShopUser}}</button>
                                        @else
                                            <button type="button" class="count_ShopUser btn btn-info"><a data-pjax href="{{route('manageShopUser').'?shop_id='.$shop->id}}">{{$shop->numberShopUser}}</a></button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" data-position="{{$shop->id}}" class="disable_shop btn btn-primary btn-sm">@if($shop->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$shops->links()}}
                        </div>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-search" style="display: none">
                            <ul class="pagination">
                                <li class="page-item" id="page-search-pre"><span class="page-link">&laquo;</span></li>
                                <li class="page-item active"><span id="page-search-current" class="page-link">0</span></li>
                                <li class="page-item" id="page-search-next"><span class="page-link">&raquo;</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#manashops').addClass('mm-active');
            $('#manaadmins').removeClass('mm-active');
            $('#statistic').removeClass('mm-active');
            $('#manaproducts').removeClass('mm-active');
            $('#manausers').removeClass('mm-active');
            $('#newadmins').removeClass('mm-active');
            $('#newproducts').removeClass('mm-active');
            $('#newshops').removeClass('mm-active');
            $('#newusers').removeClass('mm-active');
        });
    </script>
    <script>
        $(document).ready(function () {
            setNewEvent();
            function setNewEvent() {
                $(document).pjax('[data-pjax] a, a[data-pjax]', '#pagess');
                $(document).on('submit', 'form[data-pjax]', function (event) {
                    $.pjax.submit(event, '#pagess');
                });
                $('.disable_shop').each(function (index) {
                    $(this).click(function () {
                        var shop_id = $(this).attr('data-position');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('disableShop') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'shop_id': shop_id},
                            success: function (data) {
                                console.log(shop_id);
                                if(data.success) {
                                    if(data.deleted_at == null) {
                                        $('.disable_shop').each(function () {
                                            if ($(this).attr('data-position') === shop_id) {
                                                $(this).html("Kích hoạt");
                                            }
                                        });
                                    }
                                    else {
                                        $('.disable_shop').each(function () {
                                            if ($(this).attr('data-position') === shop_id) {
                                                $(this).html("Vô hiệu hóa");
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    })
                });
                $('.search-icon').each(function () {
                    $(this).click(function () {
                        $(this).parent().parent().addClass('active');
                    })
                });
                $('.close').each(function () {
                    $(this).click(function () {
                        $(this).parent().removeClass('active');
                    })
                });
            }
            var all_shop = $('#table-shop').html();
            function delay(callback, ms) {
                var timer = 0;
                return function() {
                    var context = this, args = arguments;
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        callback.apply(context, args);
                    }, ms || 0);
                };
            }
            var role = '0';
            var search = '';
            var sort = '';
            var option ='';
            var count1 = 0;
            var count2 = 0;
            $('.filter-shop').each(function (index) {
                $(this).click(function () {
                    if(role === $(this).attr('data-index')) {
                        return;
                    }
                    option = 'orders';
                    role = $(this).attr('data-index');
                    var role1 = role;
                    if(role === 0 || role === '0') {role1 = '';}
                    $('#paginate-div').hide();
                    $('#paginate-search').show();
                    var choose = $(this).text();
                    $('#option-role').text(choose);
                    if(role === '0' && search === '') {
                        $('#paginate-div').show();
                        $('#paginate-search').hide();
                        $('#table-shop').html(all_shop);
                        setNewEvent();
                        return;
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('filterShop') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'role': role1,
                            'search': search,
                            'sort': sort,
                            'option': option,
                            'perpage': 10,
                            'page': 1},
                        success: function (data) {
                            $('#table-shop').html(data.table_data);
                            $('#page-search-current').html(data.page_current);
                            setNewEvent();
                        }
                    });
                })
            });
            $('.search-shop').each(function (index) {
                $(this).keyup(delay(function (e) {
                    search = ($(this).val()).toString();
                    if(search !== '' || role !== '0') {
                        var role1 = role;
                        if(role === 0 || role === '0') role1 = '';
                        $('#paginate-div').hide();
                        $('#paginate-search').show();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('filterShop') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'role': role1,
                                'search': search,
                                'sort': sort,
                                'option': option,
                                'perpage': 10,
                                'page': 1},
                            success: function (data) {
                                $('#table-shop').html(data.table_data);
                                $('#page-search-current').html(data.page_current);
                                setNewEvent();
                            }
                        })
                    } else {
                        $('#paginate-div').show();
                        $('#paginate-search').hide();
                        $('#table-shop').html(all_shop);
                    }
                    setNewEvent();
                },200));
            });
            $('#sortShopByOrder').click(function () {
                $('#paginate-div').hide();
                $('#paginate-search').show();
                option = 'orders';
                count1++;
                if(count1 % 2 === 0) {sort = 'DESC'}
                else {sort = 'ASC'}
                var role1 = role;
                if(role === 0 || role === '0') role1 = '';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('filterShop') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'role': role1,
                        'search': search,
                        'sort': sort,
                        'option': option,
                        'perpage': 10,
                        'page': 1},
                    success: function (data) {
                        $('#table-shop').html(data.table_data);
                        $('#page-search-current').html(data.page_current);
                        setNewEvent();
                    }
                });
            });
            $('#sortShopByUser').click(function () {
                $('#paginate-div').hide();
                $('#paginate-search').show();
                option = 'shop_users';
                count2++;
                if(count2 % 2 === 0) {sort = 'DESC'}
                else {sort = 'ASC'}
                var role1 = role;
                if(role === 0 || role === '0') role1 = '';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('filterShop') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'role': role1,
                        'search': search,
                        'sort': sort,
                        'option': option,
                        'perpage': 10,
                        'page': 1},
                    success: function (data) {
                        $('#table-shop').html(data.table_data);
                        $('#page-search-current').html(data.page_current);
                        setNewEvent();
                    }
                });
            });
            $('#page-search-pre').click(function(){
                var page = Number($('#page-search-current').html());
                var role1 = role;
                if(role === '0') role1 = '';
                if(page !== 1) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('filterShop') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'role': role1,
                            'search': search,
                            'sort': sort,
                            'option': option,
                            'perpage': 10,
                            'page': page-1},
                        success: function (data) {
                            $('#table-shop').html(data.table_data);
                            $('#page-search-current').html(data.page_current);
                            setNewEvent();
                        }
                    })
                }
            });
            $('#page-search-next').click(function(){
                var check = 0;
                $('.disable_shop').each(function () {
                    check++;
                });
                if(check < 10) return;
                var page = Number($('#page-search-current').html());
                var role1 = role;
                if(role === '0') role1 = '';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('filterShop') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'role': role1,
                        'search': search,
                        'sort': sort,
                        'option': option,
                        'perpage': 10,
                        'page': page+1},
                    success: function (data) {
                        $('#table-shop').html(data.table_data);
                        $('#page-search-current').html(data.page_current);
                        setNewEvent();
                    }
                })
            });
        })
    </script>
@endsection
