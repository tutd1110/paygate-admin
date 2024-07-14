@extends('main.layout.master')
@section('title', 'Doanh thu theo lớp')
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
                            Doanh thu theo lớp
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
                                            <div class="col-md-6 kt-margin-b-20">
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
                                                        <label>Loại doanh thu:</label>
                                                    </div>
                                                    <div class="kt-form__control">
                                                        <select class="form-control bootstrap-select" name="payment_status">
                                                            <option value="">All</option>
                                                            @foreach(\App\Business\BookSale\BookSaleFilter::PAYMENT_STATUS as $key => $value)
                                                                <option
                                                                    value="{{$key}}"
                                                                    {!! (($requestData['payment_status'] ?? '') !== '') && (($requestData['payment_status'] ?? '') == $key) ? ' selected' : '' !!}>
                                                                    {{$value}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
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

                                            <div class="col-md-3 kt-margin-b-20">
                                                <div class="kt-form__group">
                                                    <div class="kt-form__label">
                                                        <label></label>
                                                    </div>
                                                    <div class="kt-form__control text-right">
                                                        <button class="btn btn-success" type="submit" style="margin-top: 7px;"><i class="flaticon-search-1"></i>
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
                                            Lớp
                                        </th>
                                        <th>
                                            Doanh thu
                                        </th>
                                        <th>
                                            Số cuốn
                                        </th>
                                    </tr>
                                    <?php
                                    $sum_sum_sale = 0;
                                    $sum_count_book = 0;
                                    ?>
                                    @foreach($reportData as $key => $value)
                                        <?php
                                        $sum_sum_sale += $value['sum_sale'];
                                        $sum_count_book += $value['count_book'];
                                        ?>
                                        <tr>
                                            <td>{{\App\Business\BookSale\BookSaleFilter::getClassName($value['class'])}}</td>
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($value['sum_sale'])}}</td>
                                            <td class="number">{{\App\Mylib\NumberFormat::currency($value['count_book'])}}</td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                    <tr class="table-success">
                                        <td>
                                            Tổng
                                        </td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($sum_sum_sale)}}</td>
                                        <td class="number">{{\App\Mylib\NumberFormat::currency($sum_count_book)}}</td>
                                    </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
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
