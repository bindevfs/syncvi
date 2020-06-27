<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src" style="height:23px;width:97px;background:url({{asset('admin/images/logo-inverse.png')}})"></div>
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
    <div class="app-header__content">
        <div class="app-header-left">
            <h4>{{trans('shop_content.manage')}}: {{$shop->name}}</h4>
            <!--<ul class="header-menu nav">
                <li class="btn-group nav-item">
                    <a href="{{route('shop.home')}}" id="shop-statistic" class="nav-link">
                        <i class="nav-link-icon fa fa-database"> </i>
                        {{ trans('shop_content.statistic') }}
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a href="{{route('manageOrder')}}" id="mana-orders" class="nav-link">
                        <i class="nav-link-icon fa fa-edit"></i>
                        {{ trans('shop_content.order') }}
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a href="{{route('repo.products')}}" id="mana-repo" class="nav-link">
                        <i class="metismenu-icon pe-7s-users"></i>
                        {{ trans('shop_content.requesting_products') }}
                    </a>
                </li>
                <li class="btn-group nav-item">
                    <a data-pjax href="" id="mana-setting" class="nav-link">
                        <i class="nav-link-icon fa fa-cog"></i>
                        {{ trans('shop_content.setting') }}
                    </a>
                </li>
            </ul>-->
        </div>

        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="{{asset('admin/images/avatars/1.jpg')}}" alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                    <a data-pjax href="{{route('shop.home')}}" class="dropdown-item">My profile</a>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <a data-pjax href="{{route('shop.logout')}}" class="dropdown-item">Logout</a>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                {{Auth::guard('web_shop_users')->user()->name}}
                            </div>
                            <div class="widget-subheading">
                                {{trans('shop_content.manager')}}
                            </div>
                        </div>
                        <a href="{{route('shop.change-language', ['en']) }}"><img width="28" src="{{asset('admin/images/english.jpg')}}"></a>
                        <a href="{{route('shop.change-language', ['vi']) }}"><img width="28" src="{{asset('admin/images/vietnam.jpg')}}"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
