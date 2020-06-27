@extends('shop.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Products
                    <div class="btn-actions-pane-right" style="text-transform: none">
                        <button style="background-color: rgba(242,198,151,0.38); width: 50px; height: 20px" disabled=""></button>
                        <i style="color: #5c8ed4">{{ trans('shop_content.products_need_check') }}</i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">Id</th>
                                <th class="text-center">Key</th>
                                <th class="text-center">{{ trans('shop_content.name_product') }}</th>
                                <th class="text-center">{{ trans('shop_content.resource') }}</th>
                                <th class="text-center">{{ trans('shop_content.quality') }}</th>
                                <th class="text-center">{{ trans('shop_content.price') }} (max)</th>
                                <th class="text-center">{{ trans('shop_content.description') }}</th>
                                <th class="text-center">{{ trans('shop_content.option') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr id="tr{{$product->id}}" @if(!$product->isChecked) style="background-color: rgba(242,198,151,0.38)" @endif>
                                    <td class="text-center text-muted">SVP{{$product->id}}</td>
                                    <td class="text-center text-muted">{{$product->product_key}}</td>
                                    <td class="text-center">{{$product->product_name}}</td>
                                    <td class="text-center">{{$product->resource}}~><a href="{{$product->product_url}}">{{ trans('shop_content.page') }}</a></td>
                                    <td class="text-center" data-toggle="tooltip" title="{{ trans('shop_content.ok_per_quality') }}" id="td{{$product->id}}">
                                        @if($product->isChecked || $product->quali!=0){{$product->quali}}/@else?/@endif{{$product->quality}}
                                    </td>
                                    <td class="text-center">{{ number_format($product->price) }}	₫</td>
                                    <td class="text-center">{{$product->description}}</td>
                                    <td class="text-center">
                                        <button type="button" data-index="{{$product->id}}" data-name="{{$product->product_name}}" class="detail_product btn btn-primary btn-sm">{{ trans('shop_content.detail') }}</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$products->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dialog-detail" class="modal" style="z-index: 10000">
        <div class="modal-content">
            <span class="close" id="close-detail">&times;</span>
            <div id="dialog-detail-info">
                <div class="spinner"></div>
            </div>
        </div>
    </div>
    <script>
        $('#shop-statistic').removeClass('mm-active');
        $('#mana-orders').removeClass('mm-active');
        $('#mana-setting').removeClass('mm-active');
        $('#mana-repo').addClass('mm-active');
        $('#filter-order-bar').css('display', 'none');
        $('#price-date').css('display', 'none');

        $(document).ready(function(){
            var dialog_detail = document.getElementById('dialog-detail');
            var spinner1 = $('#dialog-detail-info').html();
            document.getElementById('close-detail').onclick = function() {
                dialog_detail.style.display = "none";
                $('#dialog-detail-info').html(spinner1);
            };
            window.onclick = function(event) {
                if (event.target === dialog_detail) {
                    dialog_detail.style.display = "none";
                    $('#dialog-detail-info').html(spinner1);
                }
            };
            $('.detail_product').each(function () {
                $(this).click(function () {
                    var product_id = $(this).attr('data-index');
                    var product_name = $(this).attr('data-name');
                    dialog_detail.style.display = 'block';
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('dialog.detail.repo') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'product_id': product_id},
                        success: function (data) {
                            $('#dialog-detail-info').html(data.detail);
                            eventForDetailDialog(product_id);
                        }
                    });
                });
            });
            function eventForDetailDialog(product_id) {
                $('.dropdown-change-status').each(function () {
                    $(this).hover(function () {
                        var orp_id = $(this).attr('data-id');
                        var orp_status = $(this).attr('data-status');
                        $('#'+orp_id+'status'+orp_status).hide();
                    });
                });
                $('.btn-change-status').each(function () {
                    $(this).click(function () {
                        var temp = $(this).html();
                        var orp_id = $(this).attr('data-id');
                        var status = $(this).attr('data-status');
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('update.orp.status') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'order_product_id': orp_id,
                                    'status': status},
                            success: function (data) {
                                if(data.status) {
                                    var st = $('#status-product'+orp_id).attr('data-status');
                                    $('#status-product'+orp_id).html(temp).attr('data-status', status);
                                    $('#'+orp_id+'status'+st).show();
                                    $(this).hide();
                                    var check = true;
                                    var all = 0;
                                    var ced = 0;
                                    var all_processing = true;
                                    $(".dropdown-change-status").each(function () {
                                        if($(this).attr('data-status') === '1') {
                                            ced += parseInt($(this).attr('data-quality'), 10);
                                        }
                                        if($(this).attr('data-status') === '0') {
                                            check = false;
                                        }
                                        if($(this).attr('data-status') !== '0') {
                                            all_processing = false;
                                        }
                                        all += parseInt($(this).attr('data-quality'), 10);
                                    });
                                    if(check) {
                                        $('#tr'+product_id).css('background-color', '');
                                    } else {
                                        $('#tr'+product_id).css('background-color', 'rgba(242,198,151,0.38)');
                                    }
                                    if(all_processing) {
                                        $('#td'+product_id).html('?/'+all);
                                    } else {
                                        $('#td'+product_id).html(ced+'/'+all);
                                    }

                                }
                            }
                        });
                    });
                });

            }
        });
    </script>
@endsection
