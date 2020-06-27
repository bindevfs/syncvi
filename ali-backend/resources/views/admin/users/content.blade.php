@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Người dùng&emsp;
                    <div class="dropdown d-inline-block">
                        <button id="option-role" type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-light">Chọn</button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                            <button data-index="0" type="button" tabindex="0" class="filter-user dropdown-item">Tất cả</button>
                            <button data-index="1" type="button" tabindex="0" class="filter-user dropdown-item user_active">Hoạt động</button>
                            <button data-index="2" type="button" tabindex="0" class="filter-user dropdown-item user_notactive">Bị vô hiệu hóa</button>
                        </div>
                    </div>
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input search-user" placeholder="Nhập tên, email hoặc SĐT">
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
                                <th id='sortUser' class="text-center dropdown-toggle">Đơn hàng</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            <tbody id="table-user">
                            @foreach($users as $user)
                            <tr>
                                <td class="text-center text-muted">SVU{{$user->id}}</td>
                                <td class="text-center">{{$user->name}}</td>
                                <td class="text-center">{{$user->email}}</td>
                                <td class="text-center">{{$user->phone}}</td>
                                <td class="text-center">{{$user->address}}</td>
                                <td class="text-center">
                                    <div class="badge badge-success">{{$user->numberOrder}}</div>
                                </td>
                                <td class="text-center">
                                    <button type="button" data-position="{{$user->id}}" class="disable_user btn btn-primary btn-sm">@if($user->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$users->links()}}
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
            $('#manausers').addClass('mm-active');
            $('#manaadmins').removeClass('mm-active');
            $('#statistic').removeClass('mm-active');
            $('#manaproducts').removeClass('mm-active');
            $('#manashops').removeClass('mm-active');
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
                $('.disable_user').each(function (index) {
                    $(this).click(function () {
                        var user_id = $(this).attr('data-position');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('disableUser') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'user_id': user_id},
                            success: function (data) {
                                if(data.success) {
                                    if(data.deleted_at == null) {
                                        $('.disable_user').each(function () {
                                            if ($(this).attr('data-position') === user_id) {
                                                $(this).html("Kích hoạt");
                                            }
                                        });
                                    }
                                    else {
                                        $('.disable_user').each(function () {
                                            if ($(this).attr('data-position') === user_id) {
                                                $(this).html("Vô hiệu hóa");
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    })
                })
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
            var all_user = $('#table-user').html();
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
            var count = 0;
            $('.filter-user').each(function (index) {
                $(this).click(function () {
                    if(role === $(this).attr('data-index')) {
                        return;
                    }
                    role = $(this).attr('data-index');
                    var role1 = role;
                    if(role === 0 || role === '0') {role1 = '';}
                    $('#paginate-div').hide();
                    $('#paginate-search').show();
                    var option = $(this).text();
                    $('#option-role').text(option);
                    if(role === '0' && search === '') {
                        $('#paginate-div').show();
                        $('#paginate-search').hide();
                        $('#table-user').html(all_user);
                        setNewEvent();
                        return;
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('filterUser') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'role': role1,
                            'search': search,
                            'sort': sort,
                            'perpage': 10,
                            'page': 1},
                        success: function (data) {
                            $('#table-user').html(data.table_data);
                            $('#page-search-current').html(data.page_current);
                            setNewEvent();
                        }
                    });
                })
            });
            $('.search-user').each(function (index) {
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
                            url: '{{ route('filterUser') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'role': role1,
                                'search': search,
                                'sort': sort,
                                'perpage': 10,
                                'page': 1},
                            success: function (data) {
                                $('#table-user').html(data.table_data);
                                $('#page-search-current').html(data.page_current);
                                setNewEvent();
                            }
                        })
                    } else {
                        $('#paginate-div').show();
                        $('#paginate-search').hide();
                        $('#table-user').html(all_user);
                    }
                    setNewEvent();
                },200));
            });
            $('#sortUser').click(function () {
                $('#paginate-div').hide();
                $('#paginate-search').show();
                count++;
                if(count % 2 === 0) {sort = 'DESC'}
                else {sort = 'ASC'}
                var role1 = role;
                if(role === 0 || role === '0') role1 = '';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('filterUser') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'role': role1,
                        'search': search,
                        'sort': sort,
                        'perpage': 10,
                        'page': 1},
                    success: function (data) {
                        $('#table-user').html(data.table_data);
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
                        url: '{{ route('filterUser') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'role': role1,
                            'search': search,
                            'sort': sort,
                            'perpage': 10,
                            'page': page-1},
                        success: function (data) {
                            $('#table-user').html(data.table_data);
                            $('#page-search-current').html(data.page_current);
                            setNewEvent();
                        }
                    })
                }
            });
            $('#page-search-next').click(function(){
                var check = 0;
                $('.disable_user').each(function () {
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
                    url: '{{ route('filterUser') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'role': role1,
                        'search': search,
                        'sort': sort,
                        'perpage': 10,
                        'page': page+1},
                    success: function (data) {
                        $('#table-user').html(data.table_data);
                        $('#page-search-current').html(data.page_current);
                        setNewEvent();
                    }
                })
            });
        })
    </script>
@endsection
