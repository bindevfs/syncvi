@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Quản trị mới</div>
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
                            @foreach($newadmins as $newadmin)
                                <tbody>
                                <tr class="deletenewadmin" data-name="{{$newadmin->id}}">
                                    <td class="text-center text-muted">SVA{{$newadmin->id}}</td>
                                    <td class="text-center">{{$newadmin->name}}</td>
                                    <td class="text-center">{{$newadmin->email}}</td>
                                    <td class="text-center">{{$newadmin->phone}}</td>
                                    <td class="text-center">
                                        @if ($newadmin->roles == 1)
                                            <div class="badge badge-danger">SuperAdmin</div>
                                        @elseif ($newadmin->roles == 2)
                                            <div class="badge badge-warning">Admin</div>
                                        @else
                                            <div class="badge badge-success">CO</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(Auth::guard('admin')->user()->roles == 1)
                                            <button type="button" data-index="{{$newadmin->id}}" class="delete_newadmin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                        @elseif(Auth::guard('admin')->user()->roles == 3)
                                            <button disabled type="button" data-index="{{$newadmin->id}}" class="delete_newadmin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                        @elseif(Auth::guard('admin')->user()->roles == 2)
                                            @if($newadmin->roles == 1)
                                                <button disabled type="button" data-index="{{$newadmin->id}}" class="delete_newadmin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                            @elseif($newadmin->roles == 2)
                                                <button disabled type="button" data-index="{{$newadmin->id}}" class="delete_newadmin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                            @else
                                                <button type="button" data-index="{{$newadmin->id}}" class="delete_newadmin btn btn-primary btn-sm show-toastr-example">Xóa</button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$newadmins->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#newadmins').addClass('mm-active');
            $('#manaadmins').removeClass('mm-active');
            $('#statistic').removeClass('mm-active');
            $('#manaproducts').removeClass('mm-active');
            $('#manashops').removeClass('mm-active');
            $('#manausers').removeClass('mm-active');
            $('#newproducts').removeClass('mm-active');
            $('#newshops').removeClass('mm-active');
            $('#newusers').removeClass('mm-active');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.delete_newadmin').each(function (index) {
                $(this).click(function () {
                    var newadmin_id = $(this).attr('data-index');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('deleteAdmin') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'admin_id': newadmin_id},
                        success: function () {
                            $('.deletenewadmin').each(function () {
                                if ($(this).attr('data-name') === newadmin_id) {
                                    $(this).remove();
                                }
                            });
                        }
                    });
                })
            })
        })
    </script>
@endsection

