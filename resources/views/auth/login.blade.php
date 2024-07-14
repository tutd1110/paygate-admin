@section('title', 'Login')
<head>
    <!--begin::Global Theme Styles(used by all pages) -->
{{--    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
</head>

@if(isset($notification))
<div id="notification" style="text-align: center" class="alert alert-{{$notification['type']}} fade show" role="alert">
    <div class="alert-text" style="font-size: 20px">
        <i id="icon_warning" class="flaticon-warning"></i>{{$notification['message']}}
    </div>
</div>
@endif

<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

    <!-- tắt login thông thường -->
        @if (false)
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-jet-label for="email" value="{{ __('Email') }}"/>
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus/>
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}"/>
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password"/>
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember"/>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-jet-button class="ml-4">
                        {{ __('Log in') }}
                    </x-jet-button>
                </div>
            </form>
        @endif
        <p style="text-align: center;">
            <a href="{{route('google.start.login')}}" style="display: inline-block;"><img
                    src="https://developers.google.com/identity/images/btn_google_signin_light_normal_web.png"></a>
        </p>
    </x-jet-authentication-card>
</x-guest-layout>

<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
@if(isset($notification))
    <script>
        setTimeout(function() {
            $("#notification").attr('hidden',true);
        }, 5000);
    </script>
@endif
