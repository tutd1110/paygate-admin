function getDateYearMonth() {
    var year_select = $("#yearpicker option:selected").val();
    var month_select = $("#monthpicker option:selected").val();
    $.ajax({
        url: '/statistical',
        type: 'GET',
        data: {
            ajax_form: true,
            year: year_select,
            month: month_select,
            selectMonth: month_select ? 'true' : '',
        },
        success: function (data) {
            $('#chart_orders').remove();
            $('#chart_merchants').remove();
            $('#chart_revenue').remove();
            $('#chart_merchant_revenue').remove();
            $('#canvas_wallpaper_order').append('<canvas id="chart_orders"><canvas>');
            $('#canvas_wallpaper_merchant').append('<canvas id="chart_merchants"><canvas>');
            $('#canvas_wallpaper_revenue').append('<canvas id="chart_revenue"><canvas>');
            $('#canvas_wallpaper_merchant_revenue').append('<canvas id="chart_merchant_revenue"><canvas>');
            var totalOrderPaid = Object.values(data.totalOrderPaid).map(n => n.toString());
            var totalOrder = Object.values(data.totalOrder).map(n => n.toString());

            var totalRevenuePaid = Object.values(data.totalRevenuePaid).map(n => n.toString());
            var totalMerchantRevenuePaid = Object.values(data.totalMerchantRevenuePaid).map(n => n.toString());

            new Chart(document.getElementById("chart_orders"), {
                type: 'bar',
                data: {
                    labels: data.date,
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
                    labels: data.date,
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
            var totalMerchant = data.totalMerchant;
            var totalMerchantPaid = data.totalMerchantPaid;

            totalMerchant = Object.values(totalMerchant).map(n => n.toString());
            totalMerchantPaid = Object.values(totalMerchantPaid).map(n => n.toString())
            let massPopChart = new Chart(myChart, {
                type: 'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data: {
                    labels: data.arrMerchant,
                    datasets: [{
                        label: 'Thanh toán thành công',
                        data: totalMerchantPaid,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            // 'rgba(255, 159, 64, 0.6)',
                            // 'rgba(255, 99, 132, 0.6)'
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
            });
            new Chart(document.getElementById("chart_merchant_revenue"), {
                type: 'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data: {
                    labels: data.arrMerchant,
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
    });

}
