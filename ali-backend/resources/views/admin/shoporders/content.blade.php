@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Shop's Orders Of {{$shop->name}}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Id</th>
                                <th class="text-center">Khách hàng</th>
                                <th class="text-center">Tổng giá</th>
                                <th class="text-center">Đặt cọc</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Phương thức chuyển khoản</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            @foreach($shopOrders as $shopOrder)
                                <tbody>
                                    <tr>
                                        <td class="text-center text-muted">SVO{{$shopOrder->id}}</td>
                                        <td class="text-center text-muted">{{$shopOrder->username}}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                {{$shopOrder->sum_price + $shopOrder->charge}}VND
                                                <div class="dropdown-content">
                                                    <a>Giá sản phẩm: {{$shopOrder->sum_price}}VND</a>
                                                    <a>Phí: {{$shopOrder->charge}}VND</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-max="{{$shopOrder->sum_price + $shopOrder->charge}}" class="text-center">{{$shopOrder->deposit}}VND</td>
                                        <td class="text-center">
                                            @if($shopOrder->status == 1) Đang xử lý
                                            @elseif($shopOrder->status == 2) Đã xác nhận
                                            @elseif($shopOrder->status == 3) Đã đặt cọc
                                            @elseif($shopOrder->status == 4) Gom đủ hàng
                                            @elseif($shopOrder->status == 5) Đang vận chuyển
                                            @elseif($shopOrder->status == 6) Hoàn thành đơn hàng
                                            @elseif($shopOrder->status == 7) Từ chối đơn hàng
                                            @elseif($shopOrder->status == 8) Đơn hàng bị hủy
                                            @elseif($shopOrder->status == 9) Các vấn đề khác
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($shopOrder->payment == 0) Chuyển khoản trực tiếp
                                            @elseif($shopOrder->payment == 1) Chuyển từ ngân hàng hệ thống
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($shop->deleted_at == null)
                                                <button type="button" data-position="{{$shopOrder->id}}" class="disable_shoporder btn btn-primary btn-sm">@if($shopOrder->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
                                            @else
                                                <button disabled type="button" data-position="{{$shopOrder->id}}" class="disable_shoporder btn btn-primary btn-sm">Kích hoạt</button>
                                            @endif
                                            <button type="button" data-position="{{$shopOrder->id}}" class="view_detail btn btn-primary btn-sm">Xem chi tiết</button>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            <ul class="pagination">
                                @if ($shopOrders->onFirstPage())
                                    <li class="page-item" id="page-search-pre"><span class="page-link">&laquo;</span></li>
                                @else
                                    <li class="page-item" id="page-search-pre"><a  href="{{$shopOrders->previousPageUrl()}}&shop_id={{$shop->id}}" class="page-link" >&laquo;</a></li>
                                @endif
                                <li class="page-item active"><span id="page-search-current" class="page-link">{{$shopOrders->currentPage()}}</span></li>
                                @if ($shopOrders->hasMorePages())
                                    <li class="page-item" id="page-search-next"><a class="page-link" href="{{$shopOrders->nextPageUrl()}}&shop_id={{$shop->id}}">&raquo;</a></li>
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
    <div id="dialog-detail-order" class="modal" style="z-index: 10000">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="dialog-detail-info">
                <div class="spinner"></div>
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
                $('.disable_shoporder').each(function (index) {
                    $(this).click(function () {
                        var shoporder_id = $(this).attr('data-position');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('disableShopOrder') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'shoporder_id': shoporder_id},
                            success: function (data) {
                                if(data.success) {
                                    if(data.deleted_at == null) {
                                        $('.disable_shoporder').each(function () {
                                            if ($(this).attr('data-position') === shoporder_id) {
                                                $(this).html("Kích hoạt");
                                            }
                                        });
                                    }
                                    else {
                                        $('.disable_shoporder').each(function () {
                                            if ($(this).attr('data-position') === shoporder_id) {
                                                $(this).html("Vô hiệu hóa");
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    })
                });
                var dialog_detail = document.getElementById('dialog-detail-order');
                var spinner1 = $('#dialog-detail-info').html();
                $('.view_detail').each(function () {
                    $(this).click(function () {
                        dialog_detail.style.display = "block";
                        var order_id = $(this).attr('data-position');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('viewDetailOrder') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'order_id': order_id},
                            success: function (data) {
                                console.log(data);
                                $('#dialog-detail-info').html(data.detail);
                            }
                        });
                    })
                });
                var span = document.getElementsByClassName("close")[0];
                span.onclick = function() {
                    dialog_detail.style.display = "none";
                    $('#dialog-detail-info').html(spinner1);
                };
                window.onclick = function(event) {
                    if (event.target === dialog_detail) {
                        dialog_detail.style.display = "none";
                        $('#dialog-detail-info').html(spinner1);
                    }
                };
            }
        })
    </script>
@endsection
