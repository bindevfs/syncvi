@extends('shop.master')

@section('content')

<div id="pagess" style="width: 100%">
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input search-order" data-content="{{$shop->id}}" placeholder="{{ trans('shop_content.search') }}">
                                <button class="search-icon"><span></span></button>
                            </div>
                            <button class="close"></button>
                        </div>
                    </div>
                    <div class="btn-actions-pane-right">
                        <div role="group" class="btn-group-sm nav btn-group">
                            <a data-toggle="tab" class="btn-shadow active btn btn-alternate">{{ trans('shop_content.orders') }}: {{$count}}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th class="text-center">{{ trans('shop_content.name') }}</th>
                                    <th class="text-center">{{ trans('shop_content.phone') }}</th>
                                    <th style="cursor: pointer" id="sortByPrice" class="text-center dropdown-toggle">{{ trans('shop_content.sum-price') }}</th>
                                    <th class="text-center">{{ trans('shop_content.deposit') }}</th>
                                    <th class="text-center">{{ trans('shop_content.status') }}</th>
                                    <th class="text-center">{{ trans('shop_content.payment') }}</th>
                                </tr>
                            </thead>
                            <tbody id="table-order">
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center text-muted">
                                            @if($order->status == 1 && $order->delivery_date == '')
                                                <span style="cursor: pointer" title="Đơn hàng mới" data-detail="{{$order->id}}" class="detail-order font-icon-wrapper" id="check{{$order->id}}"><i class="fa fa-fw"></i></span>
                                            @endif
                                            SVO{{$order->id}}
                                        </td>
                                        <td class="text-center">{{$order->user->name}}</td>
                                        <td class="text-center">{{$order->user->phone}}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                {{number_format($order->sum_price + $order->charge)}}VND
                                                <div class="dropdown-content">
                                                    <a href="#">{{ trans('shop_content.product-price') }}: {{ number_format($order->sum_price) }}VND</a>
                                                    <a href="#">{{ trans('shop_content.charge') }}: {{ number_format($order->charge) }}VND</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-max="{{$order->sum_price + $order->charge}}" data-min="{{ number_format(($order->sum_price + $order->charge)*0.6) }}"
                                            data-index="{{$order->id}}" data-content="{{$order->deposit}}" style="cursor: pointer" class="text-center order_deposit">
                                            <div class="dropdown" id="deposit-order{{$order->id}}">
                                                {{ number_format($order->deposit) }}VND
                                                <div class="dropdown-content">
                                                    <a>{{ trans('shop_content.min') }}(60%): {{ number_format(($order->sum_price + $order->charge)*0.6) }}VND</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center order-status delete_order" data-index="{{$order->id}}" data-status="{{$order->status}}">
                                            @if($order->status == 1) <div class="badge badge-danger">{{ trans('shop_content.pending') }}</div>
                                            @elseif($order->status == 2) <div class="badge badge-warning">{{ trans('shop_content.vertify') }}</div>
                                            @elseif($order->status == 3) <div class="badge badge-primary">{{ trans('shop_content.pay') }}</div>
                                            @elseif($order->status == 4) <div class="badge badge-info">{{ trans('shop_content.goods') }}</div>
                                            @elseif($order->status == 5) <div class="badge badge-secondary">{{ trans('shop_content.delivery') }}</div>
                                            @elseif($order->status == 6) <div class="badge badge-success">{{ trans('shop_content.complete') }}</div>
                                            @elseif($order->status == 8) <div class="badge badge-dark">{{ trans('shop_content.cancel') }}</div>
                                            @elseif($order->status == 7) <div class="badge badge-dark">{{ trans('shop_content.reor') }}</div>
                                            @elseif($order->status == 9) <div class="badge badge-alternate">{{ trans('shop_content.problem') }}</div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($order->payment == 0) {{ trans('shop_content.direct') }}
                                            @elseif($order->payment == 1) {{ trans('shop_content.system') }}
                                            @endif
                                        </td>
                                        <td class="text-center order-option" data-index="{{$order->id}}">
                                            <nav class="menu">
                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id=""/>
                                                <label class="menu-open-button" for="">
                                                    <span class="hamburgera hamburger-1"></span>
                                                    <span class="hamburgera hamburger-2"></span>
                                                    <span class="hamburgera hamburger-3"></span>
                                                </label>
                                                <a data-detail="{{$order->id}}" class="detail-order menu-item" title="{{ trans('shop_content.detail')}}"> <i class="pe-7s-glasses"></i> </a>
                                                @if($order->status == 1)
                                                    <a data-detail="{{$order->id}}" class="auth-order menu-item" title="{{ trans('shop_content.vertify-button')}}"> <i class="pe-7s-check"></i> </a>
                                                    <a data-detail="{{$order->id}}" class="reject-order menu-item" title="{{ trans('shop_content.reject')}}"> <i class="pe-7s-close-circle"></i> </a>
                                                @elseif($order->status != 8 && $order->status != 6 && $order->status != 9 && $order->status != 7)
                                                    <a data-detail="{{$order->id}}" class="continue-order menu-item" title="{{ trans('shop_content.continue')}}"> <i class="pe-7s-next"></i> </a>
                                                @endif
                                            </nav>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center" id="paginate-div">
                            {{$orders->links()}}
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
</div>
<div id="dialog-detail" class="modal" style="z-index: 10000">
    <div class="modal-content">
        <span class="close" id="close-detail">&times;</span>
        <div id="dialog-detail-info">
            <div class="spinner"></div>
        </div>
    </div>
</div>
<div id="dialog-auth" class="modal" style="z-index: 10000;">
    <div class="modal-dialog-centered" style="width: 500px; margin-left: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('shop_content.vertify-dialog') }}</h5>
                <button type="button" class="close" id="close-auth" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="alert alert-danger" role="alert" style="display: none" id="alert_auth">
                {{ trans('shop_content.not_enough_deposit') }}
            </div>
            <div class="modal-footer">
                <button id="auth-order-button" data-order-id="" type="button" class="btn btn-primary">OK</button>
                <button id="close-dialog-auth" type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('shop_content.cancel-button') }}</button>
            </div>
        </div>
    </div>
</div>
<div id="dialog-reject" class="modal" style="z-index: 10000;">
    <div class="modal-dialog-centered" style="width: 500px; margin-left: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('shop_content.reject-dialog') }}</h5>
                <button type="button" class="close" id="close-reject" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button id="reject-order-button" data-order-id="" type="button" class="btn btn-primary">OK</button>
                <button id="close-dialog-reject" type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('shop_content.cancel-button') }}</button>
            </div>
        </div>
    </div>
</div>
<div id="dialog-continue" class="modal" style="z-index: 10000;">
    <div class="modal-dialog-centered" style="width: 500px; margin-left: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('shop_content.continue-dialog') }}</h5>
                <button type="button" class="close" id="close-continue" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="alert alert-danger" role="alert" style="display: none" id="alert_deposit">
                {{ trans('shop_content.not_enough_deposit') }}
            </div>
            <div class="modal-footer">
                <button id="continue-order-button" data-order-id="" type="button" class="btn btn-primary">OK</button>
                <button id="close-dialog-continue" type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('shop_content.cancel-button') }}</button>
            </div>
        </div>
    </div>
</div>
<div id="dialog-deposit" class="modal" style="z-index: 10000;">
    <div class="modal-dialog-centered" style="width: 550px; margin-left: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="title-deposit" class="modal-title">{{ trans('shop_content.deposit') }} {{ trans('shop_content.min') }}:  VND <br> {{ trans('shop_content.deposit-dialog') }}</h5>
                <button type="button" class="close" id="close-deposit" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-header">
                <input class="form-control" data-max="" id="deposit" data-order-id="" style="width: 200px ;" type="number" value="">
            </div>
            <div class="modal-footer">
                <button id="deposit-order-button" data-order-id="" data-max="" type="button" class="btn btn-primary">OK</button>
                <button id="close-dialog-deposit" type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('shop_content.cancel-button') }}</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#shop-statistic').removeClass('mm-active');
    $('#mana-orders').addClass('mm-active');
    $('#mana-repo').removeClass('mm-active');
    $('#mana-setting').removeClass('mm-active');
    $('#filter-order-bar').css('display', '');
    $('#price-date').css('display', '');
</script>
<script>
    $(document).ready(function () {
        $('#allorder').prop('checked', true);
        var check_all_order = true;
        var button_auth = '';
        var button_reject = '';
        var button_continue = '';
        var button_deposit = '';
        var dialog_detail = document.getElementById('dialog-detail');
        var dialog_auth = document.getElementById('dialog-auth');
        var dialog_reject = document.getElementById('dialog-reject');
        var dialog_continue = document.getElementById('dialog-continue');
        var dialog_deposit = document.getElementById('dialog-deposit');
        var spinner1 = $('#dialog-detail-info').html();

        reset_newblade();
        /**
         * function
         */
        function reset_newblade() {
            $('.menu-open-button').each(function () {
                $(this).hover(function () {
                    $(this).parents().children('input').attr('id','menu-open');
                    $(this).attr('for','menu-open');
                }, function () {
                    $(this).parents().children('input').attr('id','');
                    $(this).attr('for','');
                })
            });
            $('.detail-order').each(function () {
                $(this).click(function () {
                    dialog_detail.style.display = "block";
                    var order_id = $(this).attr('data-detail');
                    var check = '#check' + order_id;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('dialog.detail.order') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'order_id': order_id},
                        success: function (data) {
                            $('#dialog-detail-info').html(data.detail);
                            $(check).hide();
                        }
                    });
                });
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

            $('.auth-order').each(function () {
                $(this).click(function () {
                    button_auth = $(this);
                    button_reject = $('.reject-order');
                    button_continue = $('.continue-order');
                    var order_id = $(this).attr('data-detail');
                    $('#auth-order-button').attr('data-order-id', order_id);
                    dialog_auth.style.display = "block";
                });
            });

            $('.reject-order').each(function () {
                $(this).click(function () {
                    var order_id = $(this).attr('data-detail');
                    if(order_id === '0') return;
                    button_reject = $(this);
                    button_auth = $('.auth-order');
                    button_continue = $('.continue-order');
                    $('#reject-order-button').attr('data-order-id', order_id);
                    dialog_reject.style.display = "block";
                });
            });

            $('.continue-order').each(function () {
                $(this).click(function () {
                    var order_id = $(this).attr('data-detail');
                    if(order_id === '0') return;
                    button_continue = $(this);
                    button_auth = $('.auth-order');
                    button_reject = $('.reject-order');
                    $('#continue-order-button').attr('data-order-id', order_id);
                    dialog_continue.style.display = "block";
                });
            });

            $('.order_deposit').each(function () {
                $(this).click(function () {
                    var order_id = $(this).attr('data-index');
                    var price = $(this).attr('data-max');
                    var pricef = $(this).attr('data-min');
                    var depo = $(this).attr('data-content');
                    $('#title-deposit').html('<h5 id="title-deposit" class="modal-title">{{ trans('shop_content.deposit') }} {{ trans('shop_content.min') }}: '+pricef+' VND <br> {{ trans('shop_content.deposit-dialog') }}</h5>\n');
                    $('#deposit').attr('data-max', price);
                    $('#deposit').attr('value', depo);
                    $('#deposit').attr('data-order-id', order_id);
                    if(order_id === '0') return;
                    button_deposit = $(this);
                    button_auth = $('.auth-order');
                    button_reject = $('.reject-order');
                    $('#deposit-order-button').attr('data-order-id', order_id);
                    dialog_deposit.style.display = "block";
                });
            });

            $('.order_note').each(function () {
                $(this).keyup(delay(function () {
                    var order_id = $(this).attr('data-detail');
                    var value = $(this).val();
                    if(value !== '') {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{ route('update.order') }}',
                            method: 'get',
                            dataType: 'json',
                            data: {'note': value,
                                'order_id': order_id},
                            success: function (data) {
                            }
                        });
                    }
                }, 200));
            });
        }
        /////////////////////////
        $('#auth-order-button').click(function () {
            var order_id = $(this).attr('data-order-id');
            var check = '#check' + order_id;
            var temp = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('authenticate.order') }}',
                method: 'get',
                dataType: 'json',
                data: {'order_id': order_id},
                success: function (data) {
                    if(data.status) {
                        dialog_auth.style.display = "none";
                        button_auth.remove();
                        button_reject.remove();
                        $(check).hide();
                        $('.order-status').each(function () {
                            if($(this).attr('data-index') === order_id) {
                                $('.continue-order').show();
                                $(this).html('<div class="badge badge-warning">{{ trans('shop_content.vertify') }}<//div>');
                                if($(this).attr('data-status') === 1 || $(this).attr('data-status') === '1') {
                                    $(this).html('<div class="badge badge-warning">{{ trans("shop_content.vertify") }}<//div>');
                                    $(this).attr('data-status','2');
                                } else if ($(this).attr('data-status') === 2 || $(this).attr('data-status') === '2') {
                                    $(this).html('<div class="badge badge-primary">{{ trans('shop_content.pay') }}<//div>');
                                    $(this).attr('data-status','3');
                                } else if ($(this).attr('data-status') === 3 || $(this).attr('data-status') === '3') {
                                    $(this).html('<div class="badge badge-info">{{ trans('shop_content.goods') }}<//div>');
                                    $(this).attr('data-status','4');
                                } else if ($(this).attr('data-status') === 4 || $(this).attr('data-status') === '4') {
                                    $(this).html('<div class="badge badge-secondary">{{ trans('shop_content.delivery') }}<//div>');
                                    $(this).attr('data-status','5');
                                } else if ($(this).attr('data-status') === 5 || $(this).attr('data-status') === '5')  {
                                    $(this).html('<div class="badge badge-success">{{ trans('shop_content.complete') }}<//div>');
                                    $(this).attr('data-status','6');
                                    $('.order-option').each(function () {
                                        if($(this).attr('data-index') === order_id) {
                                            $(this).html('<nav class="menu">\n' +
                                                '                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id=""/>\n' +
                                                '                                                <label class="menu-open-button" for="">\n' +
                                                '                                                    <span class="hamburgera hamburger-1"></span>\n' +
                                                '                                                    <span class="hamburgera hamburger-2"></span>\n' +
                                                '                                                    <span class="hamburgera hamburger-3"></span>\n' +
                                                '                                                </label>\n' +
                                                '                                                <a data-detail="'+order_id+'" class="detail-order menu-item" title="{{ trans('shop_content.detail')}}"> <i class="pe-7s-glasses"></i> </a>\n' +
                                                '                                            </nav>');
                                        }
                                    });
                                }
                            }
                        });
                        $('.order-option').each(function () {
                            if($(this).attr('data-index') === order_id) {
                                $(this).html('<nav class="menu">\n' +
                                    '                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id=""/>\n' +
                                    '                                                <label class="menu-open-button" for="">\n' +
                                    '                                                    <span class="hamburgera hamburger-1"></span>\n' +
                                    '                                                    <span class="hamburgera hamburger-2"></span>\n' +
                                    '                                                    <span class="hamburgera hamburger-3"></span>\n' +
                                    '                                                </label>\n' +
                                    '                                                <a data-detail="'+order_id+'" class="detail-order menu-item" title="{{ trans('shop_content.detail')}}"> <i class="pe-7s-glasses"></i> </a>\n' +
                                    '                                                <a data-detail="'+order_id+'" class="continue-order menu-item" title="{{ trans('shop_content.continue')}}"> <i class="pe-7s-next"></i> </a>\n' +
                                    '                                            </nav>');
                            }
                        });
                        reset_newblade();
                    } else {
                        $('#alert_auth').show();
                    }
                }
            });
        });
        $('#reject-order-button').click(function () {
            var order_id = $(this).attr('data-order-id');
            var check = '#check' + order_id;
            var temp = $(this);
            dialog_reject.style.display = "none";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('reject.order') }}',
                method: 'get',
                dataType: 'json',
                data: {'order_id': order_id},
                success: function (data) {
                    if(data.status) {
                        button_auth.remove();
                        button_reject.remove();
                        $(check).hide();
                        $('.order-status').each(function () {
                            if($(this).attr('data-index') === order_id) {
                                $(this).html('<div class="badge badge-dark">{{ trans('shop_content.cancel') }}<//div>');
                            }
                        });
                        reset_newblade();
                    } else {

                    }
                }
            });
        });
        $('#continue-order-button').click(function () {
            var order_id = $(this).attr('data-order-id');
            var temp = $(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('continue.order') }}',
                method: 'get',
                dataType: 'json',
                data: {'order_id': order_id},
                success: function (data) {
                    if(data.status) {
                        dialog_continue.style.display = "none";
                        $('.order-status').each(function () {
                            if($(this).attr('data-index') === order_id) {
                                if($(this).attr('data-status') === 1 || $(this).attr('data-status') === '1') {
                                    $(this).html('<div class="badge badge-warning">{{ trans('shop_content.vertify') }}<//div>');
                                    $(this).attr('data-status','2');
                                } else if ($(this).attr('data-status') === 2 || $(this).attr('data-status') === '2') {
                                    $(this).html('<div class="badge badge-primary">{{ trans('shop_content.pay') }}<//div>');
                                    $(this).attr('data-status','3');
                                } else if ($(this).attr('data-status') === 3 || $(this).attr('data-status') === '3') {
                                    $(this).html('<div class="badge badge-info">{{ trans('shop_content.goods') }}<//div>');
                                    $(this).attr('data-status','4');
                                } else if ($(this).attr('data-status') === 4 || $(this).attr('data-status') === '4') {
                                    $(this).html('<div class="badge badge-secondary">{{ trans('shop_content.delivery') }}<//div>');
                                    $(this).attr('data-status','5');
                                } else if ($(this).attr('data-status') === 5 || $(this).attr('data-status') === '5')  {
                                    $(this).html('<div class="badge badge-success">{{ trans('shop_content.complete') }}<//div>');
                                    $(this).attr('data-status','6');
                                    $('.order-option').each(function () {
                                        if($(this).attr('data-index') === order_id) {
                                            $(this).html('<nav class="menu">\n' +
                                                '                                                <input type="checkbox" href="#" class="menu-open" name="menu-open" id=""/>\n' +
                                                '                                                <label class="menu-open-button" for="">\n' +
                                                '                                                    <span class="hamburgera hamburger-1"></span>\n' +
                                                '                                                    <span class="hamburgera hamburger-2"></span>\n' +
                                                '                                                    <span class="hamburgera hamburger-3"></span>\n' +
                                                '                                                </label>\n' +
                                                '                                                <a data-detail="'+order_id+'" class="detail-order menu-item" title="{{ trans('shop_content.detail')}}"> <i class="pe-7s-glasses"></i> </a>\n' +
                                                '                                            </nav>');                                        }
                                    });
                                }
                            }
                        });
                        reset_newblade()
                    } else {
                        $('#alert_deposit').show();
                    }
                }
            });
        });

        $('#deposit').keyup(delay(function () {
            var order_id = $(this).attr('data-order-id');
            var value = Number($(this).val());
            var temp = Number($(this).attr('data-max'));
            if(value > temp) {
                value = temp;
                $(this).val(value);
            }
        }, 200));

        $('#deposit-order-button').each(function () {
            $(this).click(function () {
                dialog_deposit.style.display = "none";
                var temp = Number($('#deposit').attr('data-max'));
                var order_id = $(this).attr('data-order-id');
                var value = Number($('#deposit').val());
                if(value !== '') {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('update.order') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'deposit': value,
                            'order_id': order_id},
                        success: function (data) {
                            $('#deposit-order'+order_id).html('<div class="dropdown" id="deposit-order">\n' +
                                '                                                '+value+'VND\n' +
                                '                                                <div class="dropdown-content">\n' +
                                '                                                    <a>{{ trans('shop_content.min') }}(60%): '+(temp*0.6)+'VND<//a>\n' +
                                '                                                <//div>\n' +
                                '                                            <//div>');
                            reset_newblade();
                        }
                    });
                }
            });
        });

        //for close modal
        document.getElementById('close-detail').onclick = function() {
            dialog_detail.style.display = "none";
            $('#dialog-detail-info').html(spinner1);
        };
        document.getElementById('close-auth').onclick = function() {
            dialog_auth.style.display = "none";
        };
        document.getElementById('close-reject').onclick = function() {
            dialog_reject.style.display = "none";
        };
        document.getElementById('close-continue').onclick = function() {
            dialog_continue.style.display = "none";
        };
        document.getElementById('close-deposit').onclick = function() {
            dialog_deposit.style.display = "none";
        };
        document.getElementById('close-dialog-auth').onclick = function() {
            dialog_auth.style.display = "none";
        };
        document.getElementById('close-dialog-reject').onclick = function() {
            dialog_reject.style.display = "none";
        };
        document.getElementById('close-dialog-continue').onclick = function() {
            dialog_continue.style.display = "none";
            $('#alert_deposit').hide();
        };
        document.getElementById('close-dialog-deposit').onclick = function() {
            dialog_deposit.style.display = "none";
        };
        window.onclick = function(event) {
            if (event.target === dialog_detail) {
                dialog_detail.style.display = "none";
                $('#dialog-detail-info').html(spinner1);
            }
            if (event.target === dialog_auth) {
                dialog_auth.style.display = "none";
            }
            if (event.target === dialog_reject) {
                dialog_reject.style.display = "none";
            }
            if (event.target === dialog_continue) {
                dialog_continue.style.display = "none";
            }
            if (event.target === dialog_deposit) {
                dialog_deposit.style.display = "none";
            }
        };

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
        var all_order = $('#table-order').html();
        var role = '0';
        var array_role = [];
        var search = '';
        var shop = '';
        var price1 = '';
        var price2= '';
        var date1 = '';
        var date2 = '';
        var count = 0;
        var sort = '';

        function change_filter_order(temp) {
            var check111 = true;
            role = null;
            role = [];
            $('.filter-order').each(function () {
                if($(this).attr('data-index') !== '0') {
                    if(temp === 1) {
                        $(this).prop('checked', false);
                    } else if($(this).prop('checked') === true) {
                        role.push($(this).attr('data-index'));
                        check111 = false;
                    }
                    reset_newblade();
                }
                reset_newblade();
            });
            $('#allorder').prop('checked', check111);
            if (check111 === true) {
                $('#table-order').html(all_order);
                $('#paginate-div').show();
                $('#paginate-search').hide();
                reset_newblade();
            }
            if(temp === 1) {
                role = null;
            }
        }
        shop = $('.filter-order').attr('data-content');

        $('.filter-order').each(function () {
            $(this).click(function (e) {
                if($(this).attr('data-index') === '0') {
                    change_filter_order(1);
                } else change_filter_order(0);
                if( $('#allorder').prop('checked') === true ) {
                    return;
                }
                shop = $(this).attr('data-content');
                var checked = $(this).prop('checked');
                /////
                $('#price1').val('');
                $('#price2').val('');
                $('#date1').val('');
                $('#date2').val('');
                price1 = '';
                price2 = '';
                date1 = '';
                date2 = '';
                search = '';
                $('#paginate-div').hide();
                $('#paginate-search').show();
                var option = $(this).text();
                $('#option-role').text(option);
                if(role === '0' && search === '') {
                    $('#paginate-div').show();
                    $('#paginate-search').hide();
                    $('#table-order').html(all_order);
                    reset_newblade();
                    return;
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('filterOrder') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'role': role,
                        'search': search,
                        'shop': shop,
                        'price1': price1,
                        'price2': price2,
                        'date1': date1,
                        'date2': date2,
                        'sort': sort,
                        'perpage': 10,
                        'page': 1},
                    success: function (data) {
                        $('#table-order').html(data.detail);
                        $('#page-search-current').html(data.page_current);
                        $('#paginate-search').attr('data-number',data.total_data);
                        if(data.total_data === 0) {
                            $('#paginate-div').hide();
                            $('#paginate-search').hide();
                        }
                        reset_newblade();
                    }
                });
                ///
            });
        });

        $('.search-order').each(function (index) {
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
                        url: '{{ route('filterOrder') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'search': search,
                            'role': role1,
                            'shop': shop,
                            'price1': price1,
                            'price2': price2,
                            'date1': date1,
                            'date2': date2,
                            'sort': sort,
                            'perpage': 10,
                            'page': 1},
                        success: function (data) {
                            $('#table-order').html(data.detail);
                            $('#page-search-current').html(data.page_current);
                            $('#paginate-search').attr('data-number',data.total_data);
                            if(data.total_data === 0) {
                                $('#paginate-div').hide();
                                $('#paginate-search').hide();
                            }
                            reset_newblade();
                        }
                    })
                } else {
                    $('#paginate-div').show();
                    $('#paginate-search').hide();
                    $('#table-order').html(all_order);
                }
                reset_newblade();
            },200));
        });

        function compareDate(strDate1, strDate2) {
            var comp1 = strDate1.split('-');
            var d1 = parseInt(comp1[2], 10);
            var m1 = parseInt(comp1[1], 10);
            var y1 = parseInt(comp1[0], 10);
            var comp2 = strDate2.split('-');
            var d2 = parseInt(comp2[2], 10);
            var m2 = parseInt(comp2[1], 10);
            var y2 = parseInt(comp2[0], 10);
            if (y1 > y2 || y1 === y2 && m1 > m2 || y1 === y2 && m1 === m2 && d1 > d2) {
                var temp;
                temp = date1;
                date1 = date2;
                date2 = temp;
            }
        }

        $('#price-order-button').click(function () {
            price1 = Number($('#price1').val());
            price2 = Number($('#price2').val());
            date1 = $('#date1').val();
            date2 = $('#date2').val();
            if(price1 !== '' && price2 !== '')
            if (Number.isNaN(price1) || Number.isNaN(price2) || price1 < 0 || price2 < 0) {
                $('#price1').val('');
                $('#price2').val('');
                return;
            }
            if (price1 > price2) {
                var temp = 0;
                temp = price1;
                price1 = price2;
                price2 = temp;
            }
            compareDate(date1, date2);
            var role1 = role;
            if(role === 0 || role === '0') role1 = '';
            $('#paginate-div').hide();
            $('#paginate-search').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('filterOrder') }}',
                method: 'get',
                dataType: 'json',
                data: {'search': search,
                    'role': role1,
                    'shop': shop,
                    'price1': price1,
                    'price2': price2,
                    'date1': date1,
                    'date2': date2,
                    'sort': sort,
                    'perpage': 10,
                    'page': 1},
                success: function (data) {
                    $('#table-order').html(data.detail);
                    $('#page-search-current').html(data.page_current);
                    $('#paginate-search').attr('data-number',data.total_data);
                    if(data.total_data === 0) {
                        $('#paginate-div').hide();
                        $('#paginate-search').hide();
                    }
                    reset_newblade();
                }
            })
        });

        $('#sortByPrice').click(function () {
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
                url: '{{ route('filterOrder') }}',
                method: 'get',
                dataType: 'json',
                data: {'search': search,
                    'role': role1,
                    'shop': shop,
                    'price1': price1,
                    'price2': price2,
                    'date1': date1,
                    'date2': date2,
                    'sort': sort,
                    'perpage': 10,
                    'page': 1},
                success: function (data) {
                    $('#table-order').html(data.detail);
                    $('#page-search-current').html(data.page_current);
                    $('#paginate-search').attr('data-number',data.total_data);
                    if(data.total_data === 0) {
                        $('#paginate-div').hide();
                        $('#paginate-search').hide();
                    }
                    reset_newblade();
                }
            });
        });

        $('#page-search-pre').click(function(){
            var page = Number($('#page-search-current').html());
            change_filter_order(0);
            var role1 = role;
            if(role === '0') role1 = '';
            if(page !== 1) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('filterOrder') }}',
                    method: 'get',
                    dataType: 'json',
                    data: {'search': search,
                        'role': role1,
                        'shop': shop,
                        'price1': price1,
                        'price2': price2,
                        'date1': date1,
                        'date2': date2,
                        'sort': sort,
                        'perpage': 10,
                        'page': page - 1},
                    success: function (data) {
                        $('#table-order').html(data.detail);
                        $('#page-search-current').html(data.page_current);
                        $('#paginate-search').attr('data-number',data.total_data);
                        if(data.total_data === 0) {
                            $('#paginate-div').hide();
                            $('#paginate-search').hide();
                        }
                        reset_newblade();
                    }
                })
            }
        });

        $('#page-search-next').click(function(){
            var check = 0;
            check = parseInt($('#paginate-search').attr('data-number'));
            if(check < 10) return;
            var page = Number($('#page-search-current').html());
            change_filter_order(0);
            var role1 = role;
            if(role === '0') role1 = '';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('filterOrder') }}',
                method: 'get',
                dataType: 'json',
                data: {'search': search,
                    'role': role1,
                    'shop': shop,
                    'price1': price1,
                    'price2': price2,
                    'date1': date1,
                    'date2': date2,
                    'sort': sort,
                    'perpage': 10,
                    'page': page + 1},
                success: function (data) {
                    $('#table-order').html(data.detail);
                    $('#page-search-current').html(data.page_current);
                    $('#paginate-search').attr('data-number',data.total_data);
                    if(data.total_data === 0) {
                        $('#paginate-div').hide();
                        $('#paginate-search').hide();
                    }
                    reset_newblade();
                }
            })
        });
    });
</script>
@endsection
