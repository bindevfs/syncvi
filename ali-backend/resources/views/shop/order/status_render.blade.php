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
        <td class="text-center order-status" data-index="{{$order->id}}" data-status="{{$order->status}}">
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
