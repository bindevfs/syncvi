<div class="main-card mb-3 card">
    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Đơn hàng SVO{{$order->id}} &emsp;
        Tổng giá sản phẩm: {{$order->sum_price}}VND &emsp; Phí: {{$order->charge}}VND
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Key</th>
                    <th class="text-center">Tên</th>
                    <th class="text-center">Nguồn</th>
                    <th class="text-center">URL</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-center">Giá</th>
                    <th class="text-center">Hình ảnh</th>
                    <th class="text-center">Mô tả</th>
                </tr>
                </thead>
                @foreach($products as $product)
                    <tbody>
                        <tr>
                            <td class="text-center text-muted">SVP{{$product->id}}</td>
                            <td class="text-center">{{$product->product_key}}</td>
                            <td class="text-center">{{$product->product_name}}</td>
                            <td class="text-center">{{$product->resource}}</td>
                            <td class="text-center"><a href="{{$product->product_url}}">Đi đến trang</a></td>
                            <td class="text-center">{{$product->quality}}</td>
                            <td class="text-center">{{$product->price}}</td>
                            <td class="text-center"><img style="height: 100px; width: 100px" src="{{$product->thumbnails}}"></td>
                            <td class="text-center">{{$product->description}}</td>
                        </tr>
                    </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>
