<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
         data-ktmenu-dropdown-timeout="500">
        @if((session("owner") == "yes" && session("partner_code") == "") || !empty(session("route")))
            <ul class="kt-menu__nav ">
                @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && array_intersect(["App\Http\Controllers\Admin\SYS\SysUserController@index","App\Http\Controllers\Admin\PartnerController@index","App\Http\Controllers\Admin\PgwPaymentMerchantController@index",
                                                                                                                                 "App\Http\Controllers\Admin\PgwListBankingController@index","App\Http\Controllers\Admin\MessageTemplateController@index",
                                                                                                                                 "App\Http\Controllers\Admin\SYS\SysGroupController@index","App\Http\Controllers\Admin\SYS\SysModulesController@index","App\Http\Controllers\Admin\SYS\SysPermissionController@index",],session("route")) == true) ))
                    <li class="kt-menu__section">
                        <h4 class="kt-menu__section-text" style="color: white">Hệ thống</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\SYS\SysUserController@index",session("route")))))
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('sys_user')) ? 'active' : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="{{route('sys_user.index')}}"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span class="kt-menu__link-text kt-menu__link-text_global">Quản lý người dùng</span></a>
                        </li>
                    @endif
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && (in_array("App\Http\Controllers\Admin\SYS\SysGroupController@index",session("route")) || in_array("App\Http\Controllers\Admin\SYS\SysModulesController@index",session("route")) ||
                                                                                         in_array("App\Http\Controllers\Admin\SYS\SysPermissionController@index",session("route")) ))))
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__total_{{ (request()->is('sys_group') || request()->is('sys_modules') || request()->is('sys_permission') || request()->is('sys_permission*')) ? 'active kt-menu__item--open'  : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span class="kt-menu__link-text kt-menu__link-text_global">Quản lý nhóm quyền</span>
                                <i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\SYS\SysGroupController@index",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('sys_group')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a href="{{route('sys_group.index')}}"
                                                                    class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Danh sách nhóm quyền </span></a>
                                        </li>
                                    @endif
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\SYS\SysModulesController@index",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('sys_modules')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a href="{{route('sys_modules.index')}}"
                                                                    class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Danh sách Modules</span></a>
                                        </li>
                                    @endif
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\SYS\SysPermissionController@index",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('sys_permission')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a href="{{route('sys_permission.index')}}"
                                                                    class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Danh sách Quyền</span></a>
                                        </li>
                                    @endif
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\SYS\SysPermissionController@create",session("route")))))
                                        <li class="kt-menu__item  kt-menu__item_{{ (request()->is('sys_permission/create*')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a href="{{route('sys_permission.create')}}"
                                                                    class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Phân quyền</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PartnerController@index",session("route")))))
                        <li class="kt-menu__item kt-menu__item--submenu kt-menu__total_{{ (request()->is('pgw_partner') || request()->is('pgw_partner/create*') ) ? 'active kt-menu__item--open' : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span class="kt-menu__link-text kt-menu__link-text_global">Đối tác</span><i
                                    class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_partner')) ? 'active' : '' }}"
                                        aria-haspopup="true"><a href="{{route('pgw_partner.index')}}"
                                                                class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text kt-menu__link-text_element">Danh sách đối tác </span></a>
                                    </li>
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PartnerController@store",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_partner/create*')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a href="{{route('pgw_partner.create')}}"
                                                                    class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Thêm đối tác</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwPaymentMerchantController@index",session("route")))))
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('pgw_payment_merchant') || request()->is('pgw_payment_merchant/create*') ) ? 'active kt-menu__item--open' : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span class="kt-menu__link-text kt-menu__link-text_global"> Cổng thanh toán</span><i
                                    class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_payment_merchant')) ? 'active' : '' }}"
                                        aria-haspopup="true"><a
                                            href="{{route('pgw_payment_merchant.index')}}" class="kt-menu__link "><i
                                                i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text kt-menu__link-text_element">Danh sách các cổng thanh toán</span></a>
                                    </li>
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwPaymentMerchantController@store",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_payment_merchant/create*')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a
                                                href="{{route('pgw_payment_merchant.create')}}"
                                                class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Thêm mới</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwListBankingController@index",session("route")))))
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('pgw_listbanking') || request()->is('pgw_listbanking/create*') ) ? 'active kt-menu__item--open' : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span
                                    class="kt-menu__link-text kt-menu__link-text_global">Danh sách ngân hàng</span><i
                                    class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_listbanking')) ? 'active' : '' }}"
                                        aria-haspopup="true"><a
                                            href="{{route('pgw_listbanking.index')}}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text kt-menu__link-text_element">Danh sách ngân hàng</span></a>
                                    </li>
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwListBankingController@store",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_listbanking/create*')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a href="{{route('pgw_listbanking.create')}}"
                                                                    class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Thêm  mới</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\MessageTemplateController@index",session("route")))) )
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('template_messages')) ? 'active kt-menu__item--open' : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span
                                    class="kt-menu__link-text kt-menu__link-text_global">Quản lý SMS Template</span><i
                                    class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">

                                    <li class="kt-menu__item kt-menu__item_{{ (request()->is('template_messages')) ? 'active' : '' }}"
                                        aria-haspopup="true"><a
                                            href="{{route('template_messages.index')}}" class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text kt-menu__link-text_element">SMS Template</span></a>
                                    </li>
                                    {{-- @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\MessageTemplateController@store",session("route")))))
                                    <li class="kt-menu__item kt-menu__item_{{ (request()->is('create_template_messages')) ? 'active' : '' }}"
                                        aria-haspopup="true"><a href="{{route('template_messages.create')}}"
                                                                class="kt-menu__link "><i
                                                class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                class="kt-menu__link-text kt-menu__link-text_element">Thêm SMS Template</span></a>
                                    </li>
                                    @endif --}}
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\EmailTemplateController@index",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('emailTemplate')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a href="{{route('emailTemplate.index')}}"
                                                                    class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Email Template</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                @endif
                @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && array_intersect(["App\Http\Controllers\Admin\PgwOrdersController@index","App\Http\Controllers\Admin\PgwOrderRefundController@index","App\Http\Controllers\Admin\PgwPaymentRequestController@index"],session("route")) == true) ))
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text" style="color: white">Hoá đơn</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwOrdersController@index",session("route")))) || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwOrderRefundController@index",session("route")))))
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('pgw_orders') || request()->is('pgw_order_refund') ) ? 'active kt-menu__item--open' : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="javascript:;"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span
                                    class="kt-menu__link-text kt-menu__link-text_global">Quản lý đơn hàng</span><i
                                    class="kt-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                                <ul class="kt-menu__subnav">
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwOrdersController@index",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_orders')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a
                                                href="{{route('pgw_orders.index')}}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Danh sách đơn hàng</span></a>
                                        </li>
                                    @endif
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwOrderRefundController@index",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_order_refund')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a
                                                href="{{route('pgw_order_refund.index')}}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Danh sách hoàn trả</span></a>
                                        </li>
                                    @endif
                                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwOrderRefundController@index",session("route")))))
                                        <li class="kt-menu__item kt-menu__item_{{ (request()->is('pgw_orders')) ? 'active' : '' }}"
                                            aria-haspopup="true"><a
                                                href="{{route('pgw_orders.statistical')}}" class="kt-menu__link "><i
                                                    class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span
                                                    class="kt-menu__link-text kt-menu__link-text_element">Thống kê hoá đơn</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                    @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\PgwPaymentRequestController@index",session("route")))))
                        <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('pgw_payment_request')) ? 'active' : '' }}"
                            aria-haspopup="true"
                            data-ktmenu-submenu-toggle="hover"><a href="{{route('pgw_payment_request.index')}}"
                                                                  class="kt-menu__link kt-menu__toggle"><span
                                    class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px"
                                                                    height="24px" viewBox="0 0 24 24" version="1.1"
                                                                    class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span class="kt-menu__link-text kt-menu__link-text_global">Quản lý Payment Request</span></a>
                        </li>

                    @endif
                @endif
                {{-- invoice --}}
                @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\InvoicesController@index",session("route")))))
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text" style="color: white">OTT</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('invoices')) ? 'active' : '' }}"
                        aria-haspopup="true"
                        data-ktmenu-submenu-toggle="hover"><a href="{{route('invoices.index')}}"
                                                              class="kt-menu__link kt-menu__toggle"><span
                                class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1"
                                                                class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span class="kt-menu__link-text kt-menu__link-text_global">Quản lý đơn hàng</span></a>
                    </li>
                @endif
                {{-- rotation luck --}}
                @if((session("owner") == "yes" && session("partner_code") == "") || (!empty(session("group") && in_array("App\Http\Controllers\Admin\RandomGiftContactController@index",session("route")))))
                    <li class="kt-menu__section ">
                        <h4 class="kt-menu__section-text" style="color: white">Vòng Quay</h4>
                        <i class="kt-menu__section-icon flaticon-more-v2"></i>
                    </li>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__total_{{ (request()->is('randomGift')) ? 'active kt-menu__item--open' : '' }}"
                        aria-haspopup="true"
                        data-ktmenu-submenu-toggle="hover">
                        <a href="{{ route('randomGift.index') }}"
                           class="kt-menu__link kt-menu__toggle"><span
                                class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1"
                                                                class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path
                                                        d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                                        fill="#000000" opacity="0.3"/>
													<path
                                                        d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                                        fill="#000000"/>
												</g>
											</svg></span><span
                                class="kt-menu__link-text kt-menu__link-text_global">Danh sách Fahasa</span>
                        </a>
                    </li>
                @endif
                @if(session('partner_code') == '' && session('owner') == 'yes')
                    <form class="kt-menu__section " action="{{route('redis.cache')}}" method="GET">
                        <button type="submit" class="btn-dark" style="color: white;width: 100%">Clear Cache</button>
                    </form>
                @endif
            </ul>
        @endif
    </div>
</div>
