<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="Start Chia is a low-fee Chia pool, we support you with a more stable income when joining the pool.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('assets/css/skins/header/base/light.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/skins/header/menu/light.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/skins/brand/dark.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/skins/aside/dark.css')}}" rel="stylesheet" type="text/css"/>

    <!--Style per page -->
    @yield('style')

    <!--Custom style -->
    <link href="{{asset('css/style.css?v=1.0.5')}}" rel="stylesheet" type="text/css"/>

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body
    class="kt-quick-panel--right
    kt-demo-panel--right
    kt-offcanvas-panel--right kt-header--fixed
     kt-header-mobile--fixed
      kt-subheader--enabled
      kt-subheader--fixed
      kt-subheader--solid
      kt-aside--enabled
      kt-aside--fixed
      kt-page--loading">

<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{url('/')}}">
            <img style="height: 30px;" alt="Logo" src="{{asset('assets/media/bg/Logo-hocmai.png')}}"/>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
            <span></span>
        </button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler">
            <i class="flaticon-more"></i>
        </button>
    </div>
</div>
<!-- end:: Header Mobile -->

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <!-- begin:: Aside -->

        {{--        <button class="kt-aside-close" id="kt_aside_close_btn"><i class="la la-close"></i></button>--}}
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

            <!-- begin:: Aside -->
            <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                <div class="kt-aside__brand-logo">
                    <a href="{{url('/')}}">
                        <img style="height: 30px;" alt="Logo" src="{{asset('assets/media/bg/Logo-hocmai.png')}}"/>
                        <span> Hocmai.vn </span>
                    </a>
                </div>
                <div class="kt-aside__brand-tools">
                    <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
								<span>
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                         viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24"/>
											<path
                                                d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
											<path
                                                d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
										</g>
									</svg>
                                </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24"
                                 version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path
                                            d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                            fill="#000000" fill-rule="nonzero"/>
                                        <path
                                            d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                                            transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
                                    </g>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>

            <!-- end:: Aside -->

            <!-- begin:: Aside Menu -->
        @include('main.layout.menu')

        <!-- end:: Aside Menu -->
        </div>

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

                <!-- begin:: Header Menu -->
                <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">

                </div>
                <!-- end:: Header Menu -->

                <!-- begin:: Header Topbar -->
                <div class="kt-header__topbar">
                    <!--begin: User Bar -->
                    @if(session('id'))
                        <div class="kt-header__topbar-item kt-header__topbar-item--user">
                            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                                <div class="kt-header__topbar-user">
                                    <span class="kt-header__topbar-welcome">Hi,</span>
                                    <span class="kt-header__topbar-username">{{session('name')}}</span>
                                    @if (session('avatar'))
                                        <img alt="Pic" src="{{session('avatar')}}"/>
                                    @else
                                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">
                                            {{\Illuminate\Support\Str::substr(session('name'), 0, 1)}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
                                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                                     style="background-image: url({{asset('assets/media/misc/bg-1.jpg')}})">
                                    <div class="kt-user-card__avatar">
                                        @if (session('avatar'))
                                            <img class="" alt="Pic" src="{{session('avatar')}}"/>
                                        @else
                                            <span
                                                class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">
                                            {{\Illuminate\Support\Str::substr(session('name'), 0, 1)}}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="kt-user-card__name">
                                        {{session('name')}}
                                        ({{session('email')}})
                                    </div>
                                </div>
                                <div class="kt-notification">
{{--                                    <a href="#" class="kt-notification__item">--}}
{{--                                        <div class="kt-notification__item-icon">--}}
{{--                                            <i class="flaticon2-calendar-3 kt-font-success"></i>--}}
{{--                                        </div>--}}
{{--                                        <div class="kt-notification__item-details">--}}
{{--                                            <div class="kt-notification__item-title kt-font-bold">--}}
{{--                                                My Profile--}}
{{--                                            </div>--}}
{{--                                            <div class="kt-notification__item-time">--}}
{{--                                                Account settings and more--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </a>--}}
                                    <div class="kt-notification__custom kt-space-between">
                                        <a onclick="$('#logout-from').submit()" target="_blank" class="btn btn-label btn-label-brand btn-sm btn-bold">
                                            Sign Out
                                        </a>
                                    </div>
                                    <form method="GET" action="{{url('/logout')}}" id="logout-from">
                                        @csrf
                                    </form>
                                </div>

                                <!--end: Navigation -->
                            </div>
                        </div>
                    @else
                        <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper_2">
                            <div id="kt_header_menu_2" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
                                <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown" id="kt_quick_search_toggle">
                                    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
									<span class="kt-header__topbar-icon">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                             viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<rect x="0" y="0" width="24" height="24"></rect>
												<path
                                                    d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
												<path
                                                    d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                    fill="#000000" fill-rule="nonzero"></path>
											</g>
										</svg> </span>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg"
                                         x-placement="bottom-end"
                                         style="position: absolute; transform: translate3d(-266px, 64px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact" id="kt_quick_search_dropdown">
                                            <form method="get" class="kt-quick-search__form">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                                    <div class="input-group-append"><span class="input-group-text"><i
                                                                class="la la-close kt-quick-search__close"></i></span></div>
                                                </div>
                                            </form>
                                            <div class="kt-quick-search__wrapper kt-scroll ps" data-scroll="true" data-height="325" data-mobile-height="200"
                                                 style="height: 325px; overflow: hidden;">
                                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                                </div>
                                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif

                <!--end: User Bar -->
                </div>

                <!-- end:: Header Topbar -->
            </div>

            <!-- end:: Header -->
        @yield('content')


        <!-- begin:: Footer -->
            <div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
                <div class="kt-container  kt-container--fluid ">
                    <div class="kt-footer__copyright">
                        {{date('Y')}} &nbsp;&copy;&nbsp;<a href="{{url('/')}}" target="_blank" class="kt-link">{{config('app.name')}}</a>
                    </div>
                    <div class="kt-footer__menu">
                        <a href="{{'/'}}" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>
                    </div>
                </div>
            </div>

            <!-- end:: Footer -->
        </div>
    </div>
</div>
<!-- end:: Page -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/custom/tinymce/tinymce.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/main.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/custom/tinymce/tinymce.bundle.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/tinymce.js?v=1.0.2') }}" type="text/javascript"></script>
<script src="{{asset('assets/js/custom.js?v=1.0.2')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.table2excel.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/global/MouseMoveTable.js')}}" type="text/javascript"></script>

<script>
    NDBase.init({
        routers: {!! \App\Mylib\MyRouterJs::routerJson([
    ]) !!}
    });
</script>

@yield('script')

<script>
    KTUtil.ready(function () {
        @if (session('notification'))
        NDNotification.{{session('notification')['type']}}('{{session('notification')['message']}}');
        @endif
    });

</script>

<!--end::Global Theme Bundle -->
</body>

<!-- end::Body -->
</html>
