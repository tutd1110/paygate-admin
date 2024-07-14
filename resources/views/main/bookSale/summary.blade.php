@extends('main.layout.master')
@section('title', 'Doanh thu tổng')
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
                            Tổng quan
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


                                            <div class="col-md-2 kt-margin-b-20">
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

                                            <div class="col-md-6 kt-margin-b-20">
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
                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__group">
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
                                            </div>

                                            <div class="col-md-1 kt-margin-b-20">
                                                <div class="kt-form__group">
                                                    <div class="kt-form__label">
                                                        <label></label>
                                                    </div>
                                                    <div class="kt-form__control" style="text-align: right">
                                                        <button style="margin-top: 7px;" class="btn btn-success" type="submit"><i class="flaticon-search-1"></i>
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

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-12 col-lg-10 col-xl-6">
                            <!--begin: Datatable -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>

                                        </th>
                                        <th>
                                            Thành công
                                        </th>
                                        <th>
                                            Pending
                                        </th>
                                        <th>
                                            Tổng
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Doanh thu</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['sumSaleDone'])}}</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['sumSalePending'])}}</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['sumSaleDone'] + $summaryData['sumSalePending']) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Số khách hàng mua sách</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countCustomerDone'])}}</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countCustomerPending'])}}</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countCustomerDone'] + $summaryData['countCustomerPending'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>Tổng số đơn sách trong</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countBillSaleDone'])}}</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countBillSalePending'])}}</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countBillSaleDone'] + $summaryData['countBillSalePending'])}}</td>
                                    </tr>
                                    <tr>
                                        <td>Doanh thu TB/đơn</td>
                                        @if ($summaryData['countBillSaleDone'] != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['sumSaleDone'] / $summaryData['countBillSaleDone'])}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                        @if ($summaryData['countBillSalePending'] != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['sumSalePending'] / $summaryData['countBillSalePending'])}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                        @if (($summaryData['countCustomerDone'] + $summaryData['countCustomerPending']) != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency(($summaryData['sumSaleDone'] + $summaryData['sumSalePending']) / ($summaryData['countCustomerDone'] + $summaryData['countCustomerPending']))}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Số cuốn TB/đơn</td>
                                        @if ($summaryData['countBillSaleDone'] != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countBookSaleDone'] / $summaryData['countBillSaleDone'])}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                        @if ($summaryData['countBillSalePending'] != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['countBookSalePending'] / $summaryData['countBillSalePending'])}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                        @if (($summaryData['countBillSaleDone'] + $summaryData['countBillSalePending']) != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency(($summaryData['countBookSaleDone'] + $summaryData['countBookSalePending']) / ($summaryData['countBillSaleDone'] + $summaryData['countBillSalePending']))}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Doanh thu TB/Khách hàng</td>
                                        @if ($summaryData['countCustomerDone'] != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['sumSaleDone'] / $summaryData['countCustomerDone'])}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                        @if ($summaryData['countCustomerPending'] != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($summaryData['sumSalePending'] / $summaryData['countCustomerPending'])}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                        @if (($summaryData['countCustomerDone'] + $summaryData['countCustomerPending']) != 0)
                                            <td class="number">{{\App\Mylib\NumberFormat::currency(($summaryData['sumSaleDone'] + $summaryData['sumSalePending']) / ($summaryData['countCustomerDone'] + $summaryData['countCustomerPending']))}}</td>
                                        @else
                                            <td> NaN</td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                        </div>


                        <!--end: Datatable -->
                    </div>

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
