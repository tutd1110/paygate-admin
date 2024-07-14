<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mylib\HocmaiUser;
use App\Mylib\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Helper\BadRequest;

class LoginGoogleController extends Controller
{
    public function __construct()
    {
        $this->api_hm_v1_login_google = config('api.HOCMAI_API_V2') . '/api/v1/login-google';
    }

    public function start()
    {
        try {

        return Socialite::driver('google')->redirect();
        }catch (\Throwable $e){
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code,$line);
        }
    }

    public function login()
    {
        try {
        $user = Socialite::driver('google')->stateless()->user();
        $params = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'profile_photo_path' => $user->getAvatar(),
            'google_id' => $user->getId(),
            'owner' => 'no',
        ];
        $userLib = new Users();
        $user = $userLib->loginGoogle($params);
            if (isset($user['user'])) {
            $access_token = $user['user']['access_token'];
            session([
                'access_token' => $access_token,
                'id' => $user['user']['id'],
                'name' => $user['user']['name'],
                'email' => $user['user']['email'],
                'avatar' => $user['user']['profile_photo_path'],
                'owner' => $user['user']['owner'],
                'partner_code' =>  $user['user']['partner_code'],
                'landing_page' => !empty($user['user']['landing_page']) ? $user['user']['landing_page'] : null,
                'group' => !empty($user['user']['groups']) ? $user['user']['groups'] : null,
                'route' => !empty($user['user']['permission_group_route']) ? $user['user']['permission_group_route'] : null
            ]);
                return redirect()->route('home');
        }else{
            return response()->view('auth.login', [
                'notification' => [
                    'type' => 'warning',
                    'message' => 'Tài khoản của bạn chưa thể truy cập website này, Xin liên hệ quản trị viên!',
                ]
            ]);
        }
        }catch (\Throwable $e){
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code,$line);
//            $notification = [
//                'type' => 'warning',
//                'message' => 'Bạn chưa có quyền truy cập trang này, Xin liên hệ quản trị viên!',
//            ];
//            return redirect()->route('login', ['notification' =>$notification]);
        }
    }

    public function logout()
    {
        session()->put(
            [
                'access_token' => '',
                'id' => '',
                'name' => '',
                'email' => '',
                'avatar' => '',
                'owner' => '',
                'partner_code' => '',
                'landing_page'=> ''
            ]);

        return redirect()->route('login');
    }
//        dd($token);
    // OAuth 2.0 providers...
    // $token = $user->token;
    // $refreshToken = $user->refreshToken;
    // $expiresIn = $user->expiresIn;

}
