@extends('main.layout.master')

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
                            Xin chào!
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body portlet-clock">
                    <style>

                        .portlet-clock {
                            animation-name: clock-animation;
                            animation-iteration-count: infinite;
                            animation-duration: 6s;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            font-size: 20px;
                            font-family: cursive;
                            height: 440px;
                            overflow: scroll;

                        }

                        @keyframes clock-animation {
                        }

                        .clock-container {
                            width: 350px;
                            height: 350px;
                            border: 6px solid purple;
                            border-radius: 50%;
                            position: relative;
                            background: #fff;

                        }

                        .clock-container::after {
                            content: "";
                            position: absolute;
                            width: 15px;
                            height: 15px;
                            background: purple;
                            left: 50%;
                            top: 50%;
                            transform: translate(-50%, -50%);
                            border-radius: 50%;
                        }

                        .clock-number {
                            position: absolute;
                            width: 100%;
                            height: 100%;
                            text-align: center;
                        }

                        .clock-number:after {
                            content: "";
                            position: absolute;
                            height: 13px;
                            width: 3px;
                            top: 13%;
                            background: #000;

                        }

                        .clock-number > div {
                            padding: 12px;
                        }

                        .num1 {
                            transform: rotate(30deg)
                        }

                        .num1 > div {
                            transform: rotate(-30deg)
                        }

                        .num2 {
                            transform: rotate(60deg)
                        }

                        .num2 > div {
                            transform: rotate(-60deg)
                        }

                        .num3 {
                            transform: rotate(90deg)
                        }

                        .num3 > div {
                            transform: rotate(-90deg)
                        }

                        .num4 {
                            transform: rotate(120deg)
                        }

                        .num4 > div {
                            transform: rotate(-120deg)
                        }

                        .num5 {
                            transform: rotate(150deg)
                        }

                        .num5 > div {
                            transform: rotate(-150deg)
                        }

                        .num6 {
                            transform: rotate(180deg)
                        }

                        .num6 > div {
                            transform: rotate(-180deg)
                        }

                        .num7 {
                            transform: rotate(210deg)
                        }

                        .num7 > div {
                            transform: rotate(-210deg)
                        }

                        .num8 {
                            transform: rotate(240deg)
                        }

                        .num8 > div {
                            transform: rotate(-240deg)
                        }

                        .num9 {
                            transform: rotate(270deg)
                        }

                        .num9 > div {
                            transform: rotate(-270deg)
                        }

                        .num10 {
                            transform: rotate(300deg)
                        }

                        .num10 > div {
                            transform: rotate(-300deg)
                        }

                        .num11 {
                            transform: rotate(330deg)
                        }

                        .num11 > div {
                            transform: rotate(-330deg)
                        }

                        .num12 {
                            transform: rotate(360deg)
                        }

                        .num12 > div {
                            transform: rotate(-360deg)
                        }

                        .clock-hand {
                            width: 100%;
                            height: 100%;
                            position: absolute;
                        }

                        .clock-hand > div {
                            left: 50%;
                            bottom: 50%;
                            transform: translateX(-50%);
                            position: absolute;
                            border-radius: 12px;
                        }

                        .second-hand {
                            height: 32%;
                            width: 1px;
                            background: purple;
                            animation-duration: 1s;
                            transition-duration: 1s;
                        }

                        .minute-hand {
                            height: 30%;
                            width: 4px;
                            background: #000;
                        }

                        .hour-hand {
                            height: 20%;
                            width: 8px;
                            background: #000;
                        }

                        .second-hand::after {
                            position: absolute;
                            content: "";
                            border-style: solid;
                            border-width: 4px;
                            border-color: transparent transparent purple transparent;
                            left: 50%;
                            transform: translateX(-50%);
                            top: -6%;
                        }

                        .current-day {
                            position: absolute;
                            font-size: 12px;
                            font-weight: bold;
                            left: 50%;
                            transform: translateX(-50%);
                            top: 25%;
                        }

                        .current-seconds {
                            position: absolute;
                            font-size: 12px;
                            font-weight: bold;
                            left: 50%;
                            transform: translateX(-50%);
                            bottom: 25%;
                            background: purple;
                            color: #fff;
                            padding: 4px;
                        }
                    </style>
                    <div class="clock-container">
                        <div class="current-day">

                        </div>
                        <div class="current-seconds">

                        </div>
                        <div class="current-seconds"></div>
                        <div class="clock-number num1">
                            <div>1</div>
                        </div>
                        <div class="clock-number num2">
                            <div>2</div>
                        </div>
                        <div class="clock-number num3">
                            <div>3</div>
                        </div>
                        <div class="clock-number num4">
                            <div>4</div>
                        </div>
                        <div class="clock-number num5">
                            <div>5</div>
                        </div>
                        <div class="clock-number num6">
                            <div>6</div>
                        </div>
                        <div class="clock-number num7">
                            <div>7</div>
                        </div>
                        <div class="clock-number num8">
                            <div>8</div>
                        </div>
                        <div class="clock-number num9">
                            <div>9</div>
                        </div>
                        <div class="clock-number num10">
                            <div>10</div>
                        </div>
                        <div class="clock-number num11">
                            <div>11</div>
                        </div>
                        <div class="clock-number num12">
                            <div>12</div>
                        </div>
                        <div class="clock-hand" id="sec">
                            <div class="second-hand"></div>
                        </div>
                        <div class="clock-hand" id="min">
                            <div class="minute-hand"></div>
                        </div>
                        <div class="clock-hand" id="hr">
                            <div class="hour-hand"></div>
                        </div>
                    </div>

                    <script>

                        let secondHand = document.querySelector("#sec");
                        let minHand = document.querySelector("#min")
                        let hourHand = document.querySelector("#hr")


                        setInterval(clockRotating, 60)

                        function clockRotating() {
                            var date = new Date();
                            var getMilliSeconds = date.getMilliseconds() / 1000 / 60;
                            var getSeconds = date.getSeconds() / 60;
                            var getMinutes = date.getMinutes() / 60 + getSeconds / 60;
                            var getHours = date.getHours() / 12 + getMinutes / 12;

                            secondHand.style.transform = "rotate(" + (getSeconds + getMilliSeconds) * 360 + "deg)";
                            minHand.style.transform = "rotate(" + getMinutes * 360 + "deg)";
                            hourHand.style.transform = "rotate(" + getHours * 360 + "deg)";

                            document.querySelector(".current-day").innerHTML = date.toDateString();
                            document.querySelector(".current-seconds").innerHTML = date.getSeconds();

                        }
                    </script>
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
