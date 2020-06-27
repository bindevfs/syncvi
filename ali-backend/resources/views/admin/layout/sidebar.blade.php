<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src" style="height:23px;width:97px;background:url({{asset('admin/images/logo.png')}})"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li>
                    <a data-pjax href="{{route('welcome')}}" id="statistic">
                        <i class="metismenu-icon pe-7s-graph2">
                        </i>Thống kê
                    </a>
                </li>
                <!--<li>
                    <a>
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        New in one month
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a data-pjax href="{{route('manageNewAdmin')}}" id="newadmins">
                                <i class="metismenu-icon"></i>
                                New admins
                            </a>
                        </li>
                        <li>
                            <a data-pjax href="{{route('manageNewUser')}}" id="newusers">
                                <i class="metismenu-icon"></i>
                                New users
                            </a>
                        </li>
                        <li>
                            <a data-pjax href="{{route('manageNewShop')}}" id="newshops">
                                <i class="metismenu-icon"></i>
                                New shops
                            </a>
                        </li>
                        <li>
                            <a data-pjax href="{{route('manageNewProduct')}}" id="newproducts">
                                <i class="metismenu-icon"></i>
                                New products
                            </a>
                        </li>
                    </ul>
                </li>-->
                <li>
                    <a data-pjax href="{{route('manageAdmin')}}" id="manaadmins">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Quản lý quản trị
                    </a>
                </li>
                <li>
                    <a data-pjax href="{{route('manageUser')}}" id="manausers">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Quản lý người dùng
                    </a>
                </li>
                <li>
                    <a data-pjax href="{{route('manageShop')}}" id="manashops">
                        <i class="metismenu-icon pe-7s-diamond"></i>
                        Quản lý cửa hàng
                    </a>
                </li>
                <li>
                    <a data-pjax href="" id="manaproducts">
                        <i class="metismenu-icon pe-7s-settings"></i>
                        Cài đặt
                    </a>
                    <li id="exchange" data-index="1">
                        <a>
                            <label>{{ trans('shop_content.rate') }}(VNĐ)</label>
                            <div class="position-relative form-check form-check-inline">
                                <input style="width: 80px" id="rate" class="form-control" value="{{$setting->value}}">
                                <button id="exchange-button" data-order-id="" type="button" class="btn btn-primary">OK</button>
                            </div>
                        </a>
                    </li>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="dialog-rate" class="modal" style="z-index: 10000;">
    <div class="modal-dialog-centered" style="width: 500px; margin-left: 30%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('shop_content.update') }}</h5>
                <button type="button" class="close" id="close-rate" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div><script>
    $(document).ready(function () {
        var dialog_rate = document.getElementById('dialog-rate');
        document.getElementById('close-rate').onclick = function() {
            dialog_rate.style.display = "none";
        };
        window.onclick = function(event) {
            if (event.target === dialog_rate) {
                dialog_rate.style.display = "none";
            }
        };
        $('#exchange').show();
        var count = 0;
        $('#manaproducts').click(function () {
            count++;
            if (count % 2 === 0) $('#exchange').show();
            else $('#exchange').hide();
        });
        $('#exchange-button').click(function () {
            var rate = $('#rate').val();
            var setting_id = $('#exchange').attr('data-index');
            dialog_rate.style.display = "block";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('setting') }}',
                method: 'get',
                dataType: 'json',
                data: { 'setting_id' : setting_id,
                        'rate' : rate},
                success: function (data) {
                }
            });
        });
    });
</script>
