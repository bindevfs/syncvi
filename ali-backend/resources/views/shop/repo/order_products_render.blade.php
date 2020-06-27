<div class="card-header "><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>{{ trans("shop_content.order-of") }} {{$product->name}}</div>
<div class="table-responsive" style="padding-bottom: 20px; padding-top: 0px">
    <table class="align-middle mb-0 table table-striped table-hover">
        <thead>
        <tr>
            <th class="text-center">Id</th>
            <th class="text-center">{{ trans('shop_content.order-id') }}</th>
            <th class="text-center">{{ trans('shop_content.quality') }}</th>
            <th class="text-center">{{ trans('shop_content.price') }}</th>
            <th class="text-center">{{ trans('shop_content.type-product') }}</th>
            <th class="text-center">{{ trans('shop_content.date-order') }}</th>
            <th class="text-center">{{ trans('shop_content.status-product') }}</th>
        </tr>
        </thead>
        @foreach($orderProducts as $orderProduct)
            <tbody>
            <tr>
                <td class="text-center text-muted">{{$orderProduct->id}}</td>
                <td class="text-center text-muted">SVOP{{$orderProduct->order_id}}</td>
                <td class="text-center">{{$orderProduct->quality}}</td>
                <td class="text-center">{{number_format($orderProduct->price)}} ₫</td>
                <td class="text-center">{{$orderProduct->description}}</td>
                <td class="text-center">{{$orderProduct->order->created_at}}</td>
                <td class="text-center">
                    <div class="dropdown row" style="width: 110px">
                        <a class="dropbtn dropdown-change-status" id="status-product{{$orderProduct->id}}" style="padding: 0; background-color: white"
                           data-id="{{$orderProduct->id}}" data-status="{{$orderProduct->status}}" data-quality="{{$orderProduct->quality}}">
                            @if($orderProduct->status == 0) <div style="width: 110px" class="badge badge-warning">{{ trans('shop_content.status-product-processing') }}</div>
                            @elseif($orderProduct->status == 1) <div style="width: 110px" class="badge badge-success">{{ trans('shop_content.status-good') }}</div>
                            @elseif($orderProduct->status == 2) <div style="width: 110px" class="badge badge-danger">{{ trans('shop_content.status-bad') }}</div>
                            @elseif($orderProduct->status == 3) <div style="width: 110px" class="badge badge-warning">{{ trans('shop_content.status-bad') }}</div>
                            @endif
                        </a>
                        <div class="dropdown-content" style="background-color: rgba(156, 39, 176, 0);">
                            <a class="btn-change-status" id="{{$orderProduct->id}}status0" data-id="{{$orderProduct->id}}" data-status="0" style="padding: 0; background-color: white">
                                <div style="width: 110px" class="badge badge-warning">{{ trans('shop_content.status-product-processing') }}</div>
                            </a>
                            <a class="btn-change-status" id="{{$orderProduct->id}}status1" data-id="{{$orderProduct->id}}" data-status="1" style="padding: 0; background-color: white">
                                <div style="width: 110px" class="badge badge-success">{{ trans('shop_content.status-good') }}</div>
                            </a>
                            <a class="btn-change-status" id="{{$orderProduct->id}}status2" data-id="{{$orderProduct->id}}" data-status="2" style="padding: 0; background-color: white">
                                <div style="width: 110px" class="badge badge-danger">{{ trans('shop_content.status-bad') }}</div>
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        @endforeach
    </table>
</div>
