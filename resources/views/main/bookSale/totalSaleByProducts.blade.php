@extends('main.layout.master')

@section('title', 'Doanh thu theo sản phẩm')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">
                        Home
                    </h3>
                    <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
										<span class="kt-portlet__head-icon">
											<i class="kt-font-brand flaticon2-line-chart"></i>
										</span>
                        <h3 class="kt-portlet__head-title">
                            Doanh thu theo sản phẩm
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-clean btn-icon-sm">
                                <i class="la la-long-arrow-left"></i>
                                Back
                            </a>
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Search Form -->
                    <form action="{{\Illuminate\Support\Facades\URL::current()}}">
                        <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                            <div class="form">
                                <div class="row align-items-center">
                                    <div class="col-xl-12 order-2 order-xl-1">
                                        <div class="row align-items-center">
                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__group">
                                                    <label class="label">
                                                        Từ ngày đến ngày
                                                    </label>
                                                    <input type="text" class="my-daterange form-control" name="date_range"
                                                           value="{{$requestData['date_range'] ?? ''}}">
                                                </div>
                                            </div>


                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__group">
                                                    <div class="kt-form__label">
                                                        <label>Doanh thu theo cấp:</label>
                                                    </div>
                                                    <div class="kt-form__control">
                                                        <select class="form-control bootstrap-select" name="school_level">
                                                            <option value="">All</option>
                                                            @foreach(\App\Business\BookSale\BookSaleFilter::SCHOOL_LEVEL as $key => $value)
                                                                <option
                                                                    value="{{$key}}" {!! ($requestData['school_level'] ?? '') == $key ? ' selected' : '' !!}>{{$value}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__label">
                                                    <label>Tên sách:</label>
                                                </div>
                                                <div class="kt-input-icon kt-input-icon--left">
                                                    <input type="text" class="form-control" placeholder="Search..."
                                                           value="{{$requestData['book_name'] ?? ''}}" name="book_name">
                                                    <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                        <span><i class="la la-search"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 kt-margin-b-20"></div>
                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__label">
                                                    <label>Danh sách combo ID (Cách nhau bằng dấu ,)</label>
                                                </div>
                                                <textarea class="form-control" name="list_combo">{{Request::get('list_combo', '')}}</textarea>
                                            </div>
                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__label">
                                                    <label>Danh sách Package ID (Cách nhau bằng dấu ,)</label>
                                                </div>
                                                <textarea class="form-control" name="list_package">{{Request::get('list_package', '')}}</textarea>
                                            </div>

                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__label">
                                                    <label>Kênh bán:</label>
                                                </div>
                                                <div class="kt-form__control">
                                                    <select class="form-control bootstrap-select" name="sale_channel">
                                                        <option value="">All</option>
                                                        @foreach(\App\Business\BookSale\BookSaleFilter::SALE_CHANNEL as $key => $value)
                                                            <option
                                                                value="{{$key}}" {!! ($requestData['sale_channel'] ?? '') == $key ? ' selected' : '' !!}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__group">
                                                    <div class="kt-form__label">
                                                        <label></label>
                                                    </div>
                                                    <div class="kt-form__control text-right">
                                                        <button class="btn btn-success" style="margin-top: 7px;" type="submit">
                                                            <i class="flaticon-search-1"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>


                    <!--end: Search Form -->
                </div>
                <div class="kt-portlet__body">

                    <!--begin: Datatable -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th rowspan="2">
                                    STT
                                </th>
                                <th rowspan="2">
                                    Tên sách
                                </th>
                                <th rowspan="2">
                                    ID
                                </th>
                                <th rowspan="2">
                                    Loại
                                </th>
                                <th colspan="2" class="btn-outline-success">
                                    Thành công
                                </th>
                                <th colspan="2" class="btn-outline-danger">
                                    Pending
                                </th>
                                <th colspan="2">
                                    Tổng
                                </th>
                            </tr>
                            <tr>
                                <th class="btn-outline-success">
                                    Số cuốn
                                </th>
                                <th class="btn-outline-success">
                                    Doanh thu
                                </th>
                                <th class="btn-outline-danger">
                                    Số cuốn
                                </th>
                                <th class="btn-outline-danger">
                                    Doanh thu
                                </th>
                                <th>
                                    Số cuốn
                                </th>
                                <th>
                                    Doanh thu
                                </th>
                            </tr>
                            </thead>
                            <?php
                            $sum_count_product_done = 0;
                            $sum_sale_done = 0;
                            $sum_count_product_pending = 0;
                            $sum_sale_pending = 0;
                            ?>

                            @foreach($listPackageView as $key => $value)

                                <?php
                                $sum_count_product_done += $value['count_product_done'];
                                $sum_sale_done += $value['sale_done'];
                                $sum_count_product_pending += $value['count_product_pending'];
                                $sum_sale_pending += $value['sale_pending'];
                                ?>

                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$value['name']}}</td>
                                    <td>{{$key}}</td>
                                    <td>Sách lẻ</td>
                                    <td class="number btn-outline-success">
                                        {{\App\Mylib\NumberFormat::currency($value['count_product_done'])}}
                                    </td>
                                    <td class="number btn-outline-success">
                                        {{\App\Mylib\NumberFormat::currency($value['sale_done'])}}
                                    </td>
                                    <td class="number btn-outline-danger">
                                        {{\App\Mylib\NumberFormat::currency($value['count_product_pending'])}}
                                    </td>
                                    <td class="number btn-outline-danger">
                                        {{\App\Mylib\NumberFormat::currency($value['sale_pending'])}}
                                    </td>
                                    <td class="number">
                                        {{\App\Mylib\NumberFormat::currency($value['count_product_done'] + $value['count_product_pending'])}}
                                    </td>
                                    <td class="number">
                                        {{\App\Mylib\NumberFormat::currency($value['sale_done'] + $value['sale_pending'])}}
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($listComboView as $key => $value)
                                <?php
                                $sum_count_product_done += $value['count_product_done'];
                                $sum_sale_done += $value['sale_done'];
                                $sum_count_product_pending += $value['count_product_pending'];
                                $sum_sale_pending += $value['sale_pending'];
                                ?>
                                <tr class="combo">
                                    <td>{{sizeof($listPackageView) + $loop->index + 1}}</td>
                                    <td>{{$value['name']}}</td>
                                    <td>{{$key}}</td>
                                    <td>Combo</td>
                                    <td class="number btn-outline-success">
                                        {{\App\Mylib\NumberFormat::currency($value['count_product_done'])}}
                                    </td>
                                    <td class="number btn-outline-success">
                                        {{\App\Mylib\NumberFormat::currency($value['sale_done'])}}
                                    </td>
                                    <td class="number btn-outline-danger">
                                        {{\App\Mylib\NumberFormat::currency($value['count_product_pending'])}}
                                    </td>
                                    <td class="number btn-outline-danger">
                                        {{\App\Mylib\NumberFormat::currency($value['sale_pending'])}}
                                    </td>
                                    <td class="number">
                                        {{\App\Mylib\NumberFormat::currency($value['count_product_done'] + $value['count_product_pending'])}}
                                    </td>
                                    <td class="number">
                                        {{\App\Mylib\NumberFormat::currency($value['sale_done'] + $value['sale_pending'])}}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="table-success">
                                <td colspan="4">
                                    Tổng
                                </td>
                                <td class="number"> {{\App\Mylib\NumberFormat::currency($sum_count_product_done)}}</td>
                                <td class="number"> {{\App\Mylib\NumberFormat::currency($sum_sale_done)}}</td>
                                <td class="number"> {{\App\Mylib\NumberFormat::currency($sum_count_product_pending)}}</td>
                                <td class="number"> {{\App\Mylib\NumberFormat::currency($sum_sale_pending)}}</td>
                                <td class="number"> {{\App\Mylib\NumberFormat::currency($sum_count_product_done + $sum_count_product_pending)}}</td>
                                <td class="number"> {{\App\Mylib\NumberFormat::currency($sum_sale_done + $sum_sale_pending)}}</td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="4">
                                    Tổng Doanh thu/Cuốn
                                </td>
                                @if ($sum_count_product_done)
                                    <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($sum_sale_done / $sum_count_product_done)}}</td>
                                @else
                                    <td colspan="2">NaN</td>
                                @endif
                                @if ($sum_count_product_pending)
                                    <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($sum_sale_pending / $sum_count_product_pending)}}</td>
                                @else
                                    <td colspan="2">NaN</td>
                                @endif
                                @if (($sum_count_product_done + $sum_count_product_pending))
                                    <td class="number"
                                        colspan="2"> {{\App\Mylib\NumberFormat::currency( ($sum_sale_done + $sum_sale_pending) / ($sum_count_product_done + $sum_count_product_pending))}}</td>
                                @else
                                    <td colspan="2">NaN</td>
                                @endif
                            </tr>

                            <tr class="table-success">
                                <td colspan="4">
                                    Số Đơn hàng
                                </td>
                                <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($countBillSaleDone)}}</td>
                                <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($countBillSalePending)}}</td>
                                <td class="number"
                                    colspan="2"> {{\App\Mylib\NumberFormat::currency($countBillSaleDone + $countBillSalePending)}}</td>
                            </tr>

                            <tr class="table-success">
                                <td colspan="4">
                                    Số khách hàng
                                </td>
                                <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($countCustomerDone)}}</td>
                                <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($countCustomerPending)}}</td>
                                <td class="number" colspan="2">
                                    {{\App\Mylib\NumberFormat::currency($countCustomerDone + $countCustomerPending)}}
                                </td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="4">
                                    Tổng Doanh thu/Đơn hàng
                                </td>
                                @if ($countBillSaleDone)
                                    <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($sum_sale_done / $countBillSaleDone)}}</td>
                                @else
                                    <td colspan="2">
                                        NaN
                                    </td>
                                @endif

                                @if($countBillSalePending)
                                    <td class="number" colspan="2"> {{\App\Mylib\NumberFormat::currency($sum_sale_pending / $countBillSalePending)}}</td>
                                @else
                                    <td colspan="2">NaN</td>
                                @endif

                                @if (($countBillSaleDone + $countBillSalePending))
                                    <td class="number"
                                        colspan="2"> {{\App\Mylib\NumberFormat::currency( ($sum_sale_done + $sum_sale_pending) / ($countBillSaleDone + $countBillSalePending))}}</td>
                                @else
                                    <td colspan="2">
                                        NaN
                                    </td>
                                @endif
                            </tr>

                        </table>
                    </div>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script src="{{asset('assets/js/pages/My.js')}}" type="text/javascript"></script>
    <script>
    </script>
@stop
