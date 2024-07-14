@extends('main.layout.master')

@section('content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content Head -->
        <div class="kt-subheader  kt-grid__item" id="kt_subheader">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Hoá đơn</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon-home-2"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="{{ route('pgw_orders.statistical') }}" class="kt-subheader__breadcrumbs-link">Thống kê hoá đơn </a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Content Head -->

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            @if (isset($notification))
                <div class="alert alert-warning fade show" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning"></i></div>
                    <div class="alert-text">{{$notification['message']}}</div>
                    <div class="alert-close">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="la la-close"></i></span>
                        </button>
                    </div>
                </div>
            @endif
            <div class="kt-portlet kt-portlet--tab">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <span class="kt-portlet__head-icon kt-hidden">
                            <i class="la la-gear"></i>
                        </span>
                        <h3 class="kt-portlet__head-title">
                            Danh sách thống kê
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-portlet__container">
                        <div class="row mt-table">
                            <div class="col-lg-2">
                                <div style="align-items: center;" class="form-group">
                                    <label for="monthpicker"> Tháng: </label>
                                    <select name="monthpicker" id="monthpicker"
                                            data-value="{{intval(date("m", strtotime('m')))}}"
                                            class="form-control kt-select2"
                                            data-minimum-results-for-search="Infinity"
                                            onchange="getDateYearMonth()">
                                        <option value="">Bỏ chọn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div style="align-items: center;" class="form-group">
                                    <label for="yearpicker"> Năm: </label>
                                    <select name="yearpicker" id="yearpicker" data-value="{{date("Y")}}"
                                            class="form-control kt-select2"
                                            data-minimum-results-for-search="Infinity"
                                            onchange="getDateYearMonth()">\
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="canvas_wallpaper_order" class="col-lg-6" style="width:100%;margin:0 auto;height: 500px !important;">
                                <canvas id="chart_orders"></canvas>
                            </div>
                            <div id="canvas_wallpaper_merchant" class="col-lg-6" style="margin:0 auto;height: 500px !important;">
                                <canvas id="chart_merchants"></canvas>
                            </div>
                        </div>
                        <div class="row"></div>
                        <div class="row">
                            <div id="canvas_wallpaper_revenue" class="col-lg-6"
                                 style="width:100%;margin:0 auto;height: 500px !important;">
                                <canvas id="chart_revenue"></canvas>
                            </div>
                            <div id="canvas_wallpaper_merchant_revenue" class="col-lg-6"
                                 style="margin:0 auto;height: 500px !important;">
                                <canvas id="chart_merchant_revenue"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')

    <script src="{{asset('assets/js/pages/My.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/chartJs/GoogleChart.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/chartJs/Chart.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/statistical.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        window.onload = function () {
            let startYear = 1800;
            let endYear = new Date().getFullYear();
            for (i = endYear; i > startYear; i--) {
                $('#yearpicker').append($('<option />').val(i).html(i));
            }
            let startMonth = 1;
            let endMonth = 12;
            for (i = endMonth; i >= startMonth; i--) {
                $('#monthpicker').append($('<option />').val(i).html('Tháng ' + i));
            }
            var currentYear = $('#yearpicker').attr('data-value');
            var currentMonth = $('#monthpicker').attr('data-value');
            $("#yearpicker option[value=" + currentYear + "]").prop("selected", true);
            $("#monthpicker option[value=" + currentMonth + "]").prop("selected", true);

            var totalOrderPaid = JSON.parse('{!!$totalOrderPaid !!}');
            var totalOrder = JSON.parse('{!!$totalOrder !!}');
            var totalRevenuePaid = JSON.parse('{!!$totalRevenuePaid !!}');

            totalOrderPaid = Object.values(totalOrderPaid).map(n => n.toString());
            totalOrder = Object.values(totalOrder).map(n => n.toString())
            totalRevenuePaid = Object.values(totalRevenuePaid).map(n => n.toString())

            new Chart(document.getElementById("chart_orders"), {
                type: 'bar',
                data: {
                    labels: JSON.parse('{!! $date !!}'),
                    datasets: [
                        {
                            label: "Đơn hàng",
                            backgroundColor: "#118eda",
                            data: totalOrder
                        }, {
                            label: "Đơn hàng thành công",
                            backgroundColor: "#40b718",
                            data: totalOrderPaid
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    showScale: false,
                    title: {
                        display: true,
                        text: 'Thống kê đơn hàng',
                        fontSize: 25
                    },
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#000'
                        }
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            bottom: 0,
                            top: 0
                        }
                    },
                     scales: {
                        yAxes: [
                            {
                                ticks: {
                                    callback: function(label, index, labels) {
                                        return number_format(label);
                                    }
                                },
                            }
                        ]
                    },
                    tooltips: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return number_format(tooltipItem.yLabel);
                            }
                        }
                    },
                }
                //     });
                // }
            });
            new Chart(document.getElementById("chart_revenue"), {
                type: 'bar',
                data: {
                    labels: JSON.parse('{!! $date !!}'),
                    datasets: [
                        {
                            label: "Doanh thu đơn hàng",
                            backgroundColor: "#40b718",
                            data: totalRevenuePaid
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    showScale: false,
                    title: {
                        display: true,
                        text: 'Thống kê đơn hàng',
                        fontSize: 25
                    },
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#000'
                        }
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            bottom: 0,
                            top: 0
                        }
                    },
                     scales: {
                        yAxes: [
                            {
                                ticks: {
                                    callback: function(label, index, labels) {
                                        return number_format(label);
                                    }
                                },
                            }
                        ]
                    },
                    tooltips: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return number_format(tooltipItem.yLabel);
                            }
                        }
                    },
                }
                //     });
                // }
            });
            let myChart = document.getElementById('chart_merchants');
            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Lato';
            Chart.defaults.global.defaultFontSize = 18;
            Chart.defaults.global.defaultFontColor = '#777';
            var totalMerchant = JSON.parse('{!!$totalMerchant !!}');
            var totalMerchantPaid = JSON.parse('{!!$totalMerchantPaid !!}');
            var totalMerchantRevenuePaid = JSON.parse('{!!$totalMerchantRevenuePaid !!}');

            totalMerchant = Object.values(totalMerchant).map(n => n.toString());
            totalMerchantPaid = Object.values(totalMerchantPaid).map(n => n.toString())
            totalMerchantRevenuePaid = Object.values(totalMerchantRevenuePaid).map(n => n.toString())
            let massPopChart = new Chart(myChart, {
                type: 'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data: {
                    labels: JSON.parse('{!! $arrMerchant !!}'),
                    datasets: [{
                        label: 'Thanh toán thành công',
                        data: totalMerchantPaid,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderWidth: 1,
                        borderColor: '#777',
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#000',
                        order: 1
                    },
                        {
                            label: 'Lựa chọn thanh toán',
                            data: totalMerchant,
                            backgroundColor: 'rgb(255,0,0)',
                            borderWidth: 1,
                            borderColor: '#ff0000',
                            hoverBorderWidth: 3,
                            hoverBorderColor: '#000',
                            type: 'line',
                            fill: false,
                            // this dataset is drawn on top
                            order: 2
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    showScale: false,
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Lượt sử dụng cổng thanh toán',
                        fontSize: 25
                    },
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#000'
                        }
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            bottom: 0,
                            top: 0
                        }
                    },
                     scales: {
                        yAxes: [
                            {
                                ticks: {
                                    callback: function(label, index, labels) {
                                        return number_format(label);
                                    }
                                },
                            }
                        ]
                    },
                    tooltips: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return number_format(tooltipItem.yLabel);
                            }
                        }
                    },
                }
            })
            new Chart(document.getElementById("chart_merchant_revenue"), {
                type: 'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data: {
                    labels: JSON.parse('{!! $arrMerchant !!}'),
                    datasets: [{
                        label: 'Doanh thu cổng thanh toán',
                        data: totalMerchantRevenuePaid,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderWidth: 1,
                        borderColor: '#777',
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#000',
                        order: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    showScale: false,
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Doanh thu theo các cổng thanh toán',
                        fontSize: 25
                    },
                    legend: {
                        display: true,
                        labels: {
                            fontColor: '#000'
                        }
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            bottom: 0,
                            top: 0
                        }
                    },
                     scales: {
                        yAxes: [
                            {
                                ticks: {
                                    callback: function(label, index, labels) {
                                        return number_format(label);
                                    }
                                },
                            }
                        ]
                    },
                    tooltips: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return number_format(tooltipItem.yLabel);
                            }
                        }
                    },
                }
            });
        }
        function number_format (number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    </script>
@stop
