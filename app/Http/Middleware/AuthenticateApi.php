<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateApi
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
        //$params = $request->query();
        $token = $this->genToken2();
        $response = $next($request);
        $response->headers->set('Authorization',"Bearer ".$token);
        $response->headers->set('Content-type','application/json; charset=UTF-8');
        return $response;
    }

    
    // protected function genToken($params)
    // {
    //     $secret = env('API_HOCMAI_V2_SECRET');
    //     if(!empty($params)){
    //         ksort($params); //sort params by key
    //     }
    //     $params = json_encode($params);
    //     $base64_params = base64_encode($params);
    //     $request_sign = hash_hmac('sha256', $base64_params, $secret, true);
    //     return strtr(base64_encode($request_sign), '+/', '-_');
    // }

    protected function genToken2()
    {
        $secret = config('api.API_HOCMAI_V2_SECRET');
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
        $base64_header = base64_encode(json_encode($header));
        $base64_data = base64_encode(json_encode(config('api.API_HOCMAI_RANDOM_DATA')));
        $auth_sign = hash_hmac('sha256', $base64_header . $base64_data, $secret, true);
        $auth_sign = strtr(base64_encode($auth_sign), '+/', '-_');
        return ("$base64_header.$base64_data.$auth_sign");
    }
}
