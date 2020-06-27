@foreach($shops as $shop)
    <tr>
        <td class="text-center text-muted">SVS{{$shop->id}}</td>
        <td class="text-center">{{$shop->name}}</td>
        <td class="text-center">{{$shop->email}}</td>
        <td class="text-center">{{$shop->phone}}</td>
        <td class="text-center">{{$shop->address}}</td>
        <td class="text-center">
            @if($shop->numberOrder === 0)
                <button type="button" disabled class="count_ShopOrder btn btn-success" data-content="{{$shop->numberOrder}}"><a data-pjax href="{{route('manageShopOrder').'?shop_id='.$shop->id}}">{{$shop->numberOrder}}</a></button>
            @else
                <button type="button" class="count_ShopOrder btn btn-success" data-content="{{$shop->numberOrder}}"><a data-pjax href="{{route('manageShopOrder').'?shop_id='.$shop->id}}">{{$shop->numberOrder}}</a></button>
            @endif
        </td>
        <td class="text-center">
            @if($shop->numberShopUser === 0)
                <button disabled type="button" class="count_ShopUser btn btn-info"><a data-pjax href="{{route('manageShopUser').'?shop_id='.$shop->id}}">{{$shop->numberShopUser}}</a></button>
            @else
                <button type="button" class="count_ShopUser btn btn-info"><a data-pjax href="{{route('manageShopUser').'?shop_id='.$shop->id}}">{{$shop->numberShopUser}}</a></button>
            @endif
        </td>
        <td class="text-center">
            <button type="button" data-position="{{$shop->id}}" class="disable_shop btn btn-primary btn-sm">@if($shop->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
        </td>
    </tr>
@endforeach
