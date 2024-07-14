<?php

namespace App\Http\Middleware;

use App\Helper\Mycurl;
use App\Mylib\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // echo json_encode(Auth::user()->email);die;
        $master_emails = config('auth.master_emails');
        $email = session()->get('email');
        $params = ['email' => $email];
        $params['email'] = Crypt::encryptString($params['email']);
        $url_api =  $url_api = env('HOCMAI_API_V2').'/api/v1/login-google';

        $user = Mycurl::get($url_api,$params);

        if (empty($user['user']) && !in_array($user['user']['email'], $master_emails)) {
            return response()->view('main.home', [
                'notification' => [
                    'type' => 'warning',
                    'message' => 'Bạn chưa có quyền truy cập trang này, Xin liên hệ quản trị viên!',
                ]
            ]);
        }

        return $next($request);
    }
}
