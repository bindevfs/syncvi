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
                <li class="app-sidebar__heading">Menu</li>
                <li>
                    <a data-pjax href="{{route('shop.home')}}" id="shop-statistic">
                        <i class="metismenu-icon pe-7s-graph2"></i>
                        {{ trans('shop_content.statistic') }}
                    </a>
                </li>
                <li>
                    <a data-pjax href="{{route('manageOrder')}}" id="mana-orders">
                        <i class="metismenu-icon pe-7s-users"></i>
                        {{ trans('shop_content.order') }}
                    </a>
                </li>
                <li>
                    <a data-pjax href="{{route('repo.products')}}" id="mana-repo">
                        <i class="metismenu-icon pe-7s-users"></i>
                        {{ trans('shop_content.requesting_products') }}
                    </a>
                </li>
                <li>
                    <a data-pjax href="" id="mana-setting">
                        <i class="metismenu-icon pe-7s-settings"></i>
                        {{ trans('shop_content.setting') }}
                    </a>
                </li>
            </ul>
            <ul class="vertical-nav-menu" id="filter-order-bar">
                <li class="app-sidebar__heading">{{trans('shop_content.status')}}</li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="0" data-content= "{{$shop->id}}" tabindex="0" id="allorder" class="filter-order form-check-input"> {{ trans('shop_content.all-order') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input id="check-new-order" type="checkbox" data-index="1" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.pending') }}
                                    @if($shop->check == true)
                                        <span class="font-icon-wrapper" id="check-new"><i class="fa fa-fw"></i></span>
                                    @endif
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="2" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.vertify') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="3" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.pay') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="4" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input">{{ trans('shop_content.goods') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="5" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.delivery') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="6" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.complete') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="7" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.reor') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="8" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.cancel') }}
                            </label>
                        </div>
                    </a>
                </li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" data-index="9" data-content= "{{$shop->id}}" tabindex="0" class="status-order filter-order form-check-input"> {{ trans('shop_content.problem') }}
                            </label>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="vertical-nav-menu" id="price-date">
                <li class="app-sidebar__heading">{{trans('shop_content.price')}}</li>
                <li>
                    <a>
                        <div class="position-relative form-check form-check-inline">
                            <input type="number" style="width: 100px ;" id="price1" class="form-control">
                            <h5> : </h5>
                            <input type="number"style="width: 100px ;" id="price2" class="form-control">
                        </div>
                    </a>
                </li>
                <li class="app-sidebar__heading">{{trans('shop_content.time')}}</li>
                <li>
                    <a>
                        <div class="form-row position-relative form-check form-check-inline">
                            <input type="date" style="width: 200px ;" id="date1" class="form-control">
                            <input type="date" style="width: 200px ;" id="date2" class="form-control">
                            <button id="price-order-button" data-order-id="" type="button" class="btn btn-primary">OK</button>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#check-new-order').click(function () {
            $('#check-new').hide();
        });
    });
</script>
