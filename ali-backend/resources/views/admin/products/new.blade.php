@extends('admin.master')

@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="main-card mb-3 card">
                <div class="card-header "><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>New Products</div>
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
                                <th class="text-center">Hình ảnh</th>
                                <th class="text-center">Mô tả</th>
                                <th class="text-center">Lựa chọn</th>
                            </tr>
                            </thead>
                            @foreach($products as $product)
                                <tbody>
                                <tr>
                                    <td class="text-center text-muted">{{$product->id}}</td>
                                    <td class="text-center text-muted">{{$product->product_key}}</td>
                                    <td class="text-center">{{$product->product_name}}</td>
                                    <td class="text-center">{{$product->resource}}</td>
                                    <td class="text-center"><a href="{{$product->product_url}}">Đi đến trang</a></td>
                                    <td class="text-center"><img style="height: 150px; width: 150px" src="{{$product->thumbnails}}"></td>
                                    <td class="text-center">{{$product->description}}</td>
                                    <td class="text-center">
                                        <button type="button" data-position="{{$product->id}}" class="disable_product btn btn-primary btn-sm">@if($product->deleted_at == null) Vô hiệu hóa @else Kích hoạt @endif</button>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <div class="row">
                        <div data-pjax class="col-md-12 text-center" id="paginate-div">
                            {{$newproducts->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#newproducts').addClass('mm-active');
            $('#manaadmins').removeClass('mm-active');
            $('#statistic').removeClass('mm-active');
            $('#manaproducts').removeClass('mm-active');
            $('#manashops').removeClass('mm-active');
            $('#manausers').removeClass('mm-active');
            $('#newadmins').removeClass('mm-active');
            $('#newshops').removeClass('mm-active');
            $('#newusers').removeClass('mm-active');
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.disable_newproduct').each(function (index) {
                $(this).click(function () {
                    var newproduct_id = $(this).attr('data-index');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('disableProduct') }}',
                        method: 'get',
                        dataType: 'json',
                        data: {'product_id': newproduct_id},
                        success: function (data) {
                            if(data.success) {
                                if(data.deleted_at == null) {
                                    $('.disable_newproduct').each(function () {
                                        if ($(this).attr('data-index') === newproduct_id) {
                                            $(this).html('<button type="button" data-index="{{$newproduct->id}}" class="disable_newproduct btn btn-primary btn-sm">Enable</button>');
                                        }
                                    });
                                }
                                else {
                                    $('.disable_newproduct').each(function () {
                                        if ($(this).attr('data-index') === newproduct_id) {
                                            $(this).html('<button type="button" data-index="{{$newproduct->id}}" class="disable_newproduct btn btn-primary btn-sm">Disable</button>');
                                        }
                                    });
                                }
                            }
                        }
                    });
                })
            })
        })
    </script>
@endsection
