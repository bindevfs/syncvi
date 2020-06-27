@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Quản trị&emsp;
                    <div class="dropdown d-inline-block">
                        <button id="option-role" type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-light">Chọn</button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu">
                            <button data-index="0" type="button" tabindex="0" class="filter-admin dropdown-item">Tất cả</button>
                            <button data-index="1" type="button" tabindex="0" class="filter-admin dropdown-item">Quản trị</button>
                            <button data-index="2" type="button" tabindex="0" class="filter-admin dropdown-item">Quản trị viên</button>
                            <button data-index="3" type="button" tabindex="0" class="filter-admin dropdown-item">Cộng tác</button>
                        </div>
                    </div>
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input search-admin" placeholder="Nhập tên, email hoạc số điện thoại">
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
                                <th class="text-center">Chức vụ</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            <tbody id="table-admin">
                                @foreach($admins as $admin)
                                    <tr class="deleteadmin" data-title="{{$admin->id}}">
                                    <td class="text-center text-muted">SVA{{$admin->id}}</td>
                                    <td class="text-center">{{$admin->name}}</td>
                                    <td class="text-center">{{$admin->email}}</td>
                                    <td class="text-center">{{$admin->phone}}</td>
                                    <td class="text-center">
                                        @if ($admin->roles == 1)
                                            <div class="badge badge-danger">Quản trị</div>
                                        @elseif ($admin->roles == 2)
                                            <div class="badge badge-warning">Quản trị viên</div>
                                        @else
                                            <div class="badge badge-success">Cộng tác</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::guard('admin')->user()->roles == 1)
                                            <button type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                        @elseif(Auth::guard('admin')->user()->roles == 3)
                                            <button disabled type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                        @elseif(Auth::guard('admin')->user()->roles == 2)
                                            @if($admin->roles == 1)
                                                <button disabled type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                            @elseif($admin->roles == 2)
                                                <button disabled type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                            @else
                                                <button type="button" data-position="{{$admin->id}}" class="delete_admin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$admins->links()}}
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
            $('#manaadmins').addClass('mm-active');
            $('#statistic').removeClass('mm-active');
            $('#manaproducts').removeClass('mm-active');
            $('#manashops').removeClass('mm-active');
            $('#manausers').removeClass('mm-active');
            $('#newadmins').removeClass('mm-active');
            $('#newproducts').removeClass('mm-active');
            $('#newshops').removeClass('mm-active');
            $('#newusers').removeClass('mm-active');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            setNewEvent();
            function setNewEvent() {
                $(document).pjax('[data-pjax] a, a[data-pjax]', '#pagess');
                $(document).on('submit', 'form[data-pjax]', function (event) {
                    $.pjax.submit(event, '#pagess');
                });
                $('.delete_admin').each(function (index) {
                    $(this).click(function () {
                        var admin_id = $(this).attr('data-position');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('deleteAdmin') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'admin_id': admin_id},
                            success: function () {
                                $('.deleteadmin').each(function () {
                                    if ($(this).attr('data-title') === admin_id) {
                                        $(this).remove();
                                    }
                                });
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
            var all_admin = $('#table-admin').html();
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
            $('.filter-admin').each(function (index) {
                $(this).click(function () {
                    if(role === $(this).attr('data-index')) {
                        return;
                    }
                    role = $(this).attr('data-index');
                    var role1 = role;
                    if(role === 0 || role === '0') {
                        role1 = '';
                    }
                    $('#paginate-div').hide();
                    $('#paginate-search').show();
                    var option = $(this).text();
                    $('#option-role').text(option);
                    if(role === '0' && search === '') {
                        $('#paginate-div').show();
                        $('#paginate-search').hide();
                        $('#table-admin').html(all_admin);
                        setNewEvent();
                        return;
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('filterAdmin') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'role': role1,
                            'search': search,
                            'perpage': 10,
                            'page': 1},
                        success: function (data) {
                            $('#table-admin').html(data.table_data);
                            $('#page-search-current').html(data.page_current);
                            setNewEvent();
                        }
                    });
                })
            });
            $('.search-admin').each(function (index) {
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
                            url: '{{ route('filterAdmin') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'search': search,
                                'role': role1,
                                'perpage': 10,
                                'page': 1},
                            success: function (data) {
                                $('#table-admin').html(data.table_data);
                                $('#page-search-current').html(data.page_current);
                                setNewEvent();
                            }
                        })
                    } else {
                        $('#paginate-div').show();
                        $('#paginate-search').hide();
                        $('#table-admin').html(all_admin);
                    }
                    setNewEvent();
                },200));
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
                        url: '{{ route('filterAdmin') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'search': search,
                            'role': role1,
                            'perpage': 10,
                            'page': page - 1},
                        success: function (data) {
                            $('#table-admin').html(data.table_data);
                            $('#page-search-current').html(data.page_current);
                            setNewEvent();
                        }
                    })
                }
            });
            $('#page-search-next').click(function(){
                var check = 0;
                $('.delete_admin').each(function () {
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
                    url: '{{ route('filterAdmin') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'search': search,
                        'role': role1,
                        'perpage': 10,
                        'page': page + 1},
                    success: function (data) {
                        $('#table-admin').html(data.table_data);
                        $('#page-search-current').html(data.page_current);
                        setNewEvent();
                    }
                })
            });
        });
    </script>
@endsection

