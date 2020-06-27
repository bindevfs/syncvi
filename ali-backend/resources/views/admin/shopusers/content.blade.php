@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Nhân viên cửa hàng {{$shop->name}}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Id</th>
                                <th class="text-center">Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Số điện thoại</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            @foreach($shopUsers as $shopUser)
                                <tbody>
                                <tr>
                                    <td class="text-center text-muted">SVSU{{$shopUser->id}}</td>
                                    <td class="text-center">{{$shopUser->name}}</td>
                                    <td class="text-center">{{$shopUser->email}}</td>
                                    <td class="text-center">{{$shopUser->phone}}</td>
                                    <td class="text-center">
                                        @if($shop->deleted_at == null)
                                        <button type="button" data-position="{{$shopUser->id}}" class="disable_shopuser btn btn-primary btn-sm">@if($shopUser->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
                                        @else
                                        <button disabled type="button" data-position="{{$shopUser->id}}" class="disable_shopuser btn btn-primary btn-sm">Kích hoạt</button>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            <ul class="pagination">
                                @if ($shopUsers->onFirstPage())
                                    <li class="page-item" id="page-search-pre"><span class="page-link">&laquo;</span></li>
                                @else
                                    <li class="page-item" id="page-search-pre"><a  href="{{$shopUsers->previousPageUrl()}}&shop_id={{$shop->id}}" class="page-link" >&laquo;</a></li>
                                @endif
                                <li class="page-item active"><span id="page-search-current" class="page-link">{{$shopUsers->currentPage()}}</span></li>
                                @if ($shopUsers->hasMorePages())
                                    <li class="page-item" id="page-search-next"><a class="page-link" href="{{$shopUsers->nextPageUrl()}}&shop_id={{$shop->id}}">&raquo;</a></li>
                                @else
                                    <li class="page-item" id="page-search-pre"><span class="page-link">&raquo;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            setNewEvent();
            function setNewEvent() {
                $(document).pjax('[data-pjax] a, a[data-pjax]', '#pagess');
                $(document).on('submit', 'form[data-pjax]', function (event) {
                    $.pjax.submit(event, '#pagess');
                });
                $('.disable_shopuser').each(function (index) {
                    $(this).click(function () {
                        var shopuser_id = $(this).attr('data-position');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('disableShopUser') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'shopuser_id': shopuser_id},
                            success: function (data) {
                                if(data.success) {
                                    if(data.deleted_at == null) {
                                        $('.disable_shopuser').each(function () {
                                            if ($(this).attr('data-position') === shopuser_id) {
                                                $(this).html("Kích hoạt");
                                            }
                                        });
                                    }
                                    else {
                                        $('.disable_shopuser').each(function () {
                                            if ($(this).attr('data-position') === shopuser_id) {
                                                $(this).html("Vô hiệu hóa");
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    })
                })
            }
        })
    </script>
@endsection
