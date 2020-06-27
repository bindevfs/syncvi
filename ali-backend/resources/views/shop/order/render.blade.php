<div class="main-card mb-3 card">
    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>{{ trans('shop_content.order') }} SVO{{$order->id}}
        <div class="btn-actions-pane-right">
            <div role="group" class="btn-group-sm nav btn-group">
                <label>{{ trans('shop_content.note') }}</label>&emsp;
                @if($order->note == null)
                    <h5 style="display: block; font-size: 14px; text-transform: none; min-width: 100px; cursor: pointer" id="title-note">Nothing</h5>
                @else
                    <h5 style="display: block; font-size: 14px; text-transform: none; min-width: 100px; cursor: pointer" id="title-note">{{$order->note}}</h5>
                @endif
                <input id = "order_note" class="form-control" data-max="" data-order-id="" style="width: 500px; display: none" value="{{$order->note}}" data-detail ="{{$order->id}}">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="main-card mb-3 card">
            <div class="card-body"><h5 class="app-sidebar__heading">{{ trans('shop_content.product') }}</h5> &emsp;
                <h5 class="card-title">{{ trans('shop_content.product-price') }}: {{number_format($order->sum_price)}} VND</h5>
                <div class="table-responsive">
                    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Key</th>
                            <th class="text-center">{{ trans('shop_content.name_product') }}</th>
                            <th class="text-center">{{ trans('shop_content.price') }}</th>
                            <th class="text-center">{{ trans('shop_content.quality') }}</th>
                            <th class="text-center">Url</th>
                            <th class="text-center">{{ trans('shop_content.image') }}</th>
                            <th class="text-center">{{ trans('shop_content.description') }}</th>
                        </tr>
                        </thead>
                        @foreach($products as $product)
                            <tbody>
                            <tr>
                                <td class="text-center text-muted">SVP{{$product->id}}</td>
                                <td class="text-center">{{$product->product_key}}</td>
                                <td class="text-center">{{$product->product_name}}</td>
                                <td class="text-center">{{number_format($product->price)}}</td>
                                <td class="text-center">{{$product->quality}}</td>
                                <td class="text-center"><a href="{{$product->product_url}}" target="_blank">{{ trans('shop_content.page') }}</a></td>
                                <td class="text-center"><img style="height: 50px; width: 50px" src="{{$product->thumbnails}}"></td>
                                <td class="text-center">{{$product->description}}</td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="app-sidebar__heading">{{ trans('shop_content.order-info') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="main-card mb-3">
                                    <form>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="exampleEmail22" class="card-title mr-sm-2">Id</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">SVO{{$order->id}}</label>
                                        </div>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.charge') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">{{number_format($order->charge)}} VND</label>
                                        </div>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.status') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">
                                                @if($order->status == 1) {{ trans('shop_content.pending') }}
                                                @elseif($order->status == 2) {{ trans('shop_content.vertify') }}
                                                @elseif($order->status == 3) {{ trans('shop_content.pay') }}
                                                @elseif($order->status == 4) {{ trans('shop_content.goods') }}
                                                @elseif($order->status == 5) {{ trans('shop_content.delivery') }}
                                                @elseif($order->status == 6) {{ trans('shop_content.complete') }}
                                                @elseif($order->status == 7) {{ trans('shop_content.reor') }}
                                                @elseif($order->status == 8) {{ trans('shop_content.cancel') }}
                                                @elseif($order->status == 9) {{ trans('shop_content.problem') }}
                                                @endif
                                            </label>
                                        </div>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.description') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">{{$order->description}}</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="main-card mb-3">
                                    <form>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="exampleEmail22" class="card-title mr-sm-2">{{ trans('shop_content.deposit') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">{{number_format($order->deposit)}} VND</label>
                                        </div>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.sum-price') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">{{number_format($order->sum_price + $order->charge)}} VND</label>
                                        </div>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.payment') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">
                                                @if($order->payment == 0) {{ trans('shop_content.direct') }}
                                                @elseif($order->payment == 1) {{ trans('shop_content.system') }}
                                                @endif
                                            </label>
                                        </div>
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.note') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">{{$order->note}}</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body"><h5 class="app-sidebar__heading">{{ trans('shop_content.customer-info') }}</h5>
                        <form>
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="exampleEmail22" class="card-title mr-sm-2">{{ trans('shop_content.name') }}</label> &emsp;
                                <label for="exampleEmail22" class="mr-sm-2">{{$user->name}}</label>
                            </div>
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.phone') }}</label> &emsp;
                                <label for="exampleEmail22" class="mr-sm-2">{{$user->phone}}</label>
                            </div>
                            <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group"><label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.address') }}</label> &emsp;
                                <label for="exampleEmail22" class="mr-sm-2">{{$user->address}}</label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="main-card mb-3 card">
                    <div class="card-body"><h5 class="app-sidebar__heading">{{ trans('shop_content.comment') }}</h5>
                        <div id="wrapper">
                            <div id="chatbox">
                                @foreach($comment as $cmt)
                                    @if($cmt->type == 0)
                                        <div class="mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                            <label for="examplePassword22" class="card-title mr-sm-2">{{ trans('shop_content.customer') }}</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">{{$cmt->content}}</label>
                                        </div>
                                    @else
                                        <div class="viewCmtShop mb-2 mr-sm-2 mb-sm-0 position-relative form-group">
                                            <label for="examplePassword22" class="card-title mr-sm-2">Tôi</label> &emsp;
                                            <label for="exampleEmail22" class="mr-sm-2">{{$cmt->content}}</label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <form name="message">
                                <input id="cmtshop" name="cmtshop" type="text" size="80" />
                                <input id="subcmt" name="subcmt" type="button" value="Gửi" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(document).click(function (e) {
            var container = $("#order_note");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                var order_note = $('#order_note').val();
                $('#title-note').html('<h5 style="display: block; font-size: 14px; text-transform: none; min-width: 100px" id="title-note">'+order_note+'</h5>');
                $('#title-note').show();
                container.hide();
            }
        });
        $('#title-note').click(function (event) {
            $(this).hide();
            $('#order_note').show().focus();
            event.stopPropagation();
        });
        $('#order_note').each(function () {
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
        $('#subcmt').click(function () {
           var content = $('#cmtshop').val();
           var order_id = $('#order_note').attr('data-detail');
           if(content !== '') {
               $.ajax({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   url: '{{ route('add.comment') }}',
                   method: 'get',
                   dataType: 'json',
                   data: {'content': content,
                       'order_id': order_id,
                       'type': 1},
                   success: function (data) {
                       $('#cmtshop').val('');
                       $('#chatbox').html($('#chatbox').html() + '<div class="viewCmtShop mb-2 mr-sm-2 mb-sm-0 position-relative form-group">\n' +
                           '                                            <label for="examplePassword22" class="card-title mr-sm-2">Tôi</label> &emsp;\n' +
                           '                                            <label for="exampleEmail22" class="mr-sm-2">'+content+'</label>\n' +
                           '                                        </div>');
                       var temp = document.getElementById("chatbox");
                       temp.scrollTop = temp.scrollHeight;
                   }
               });
           }
        });
        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
            if(e.which === 13) {
                e.preventDefault();
                return false;
            }
        });
    });
</script>
