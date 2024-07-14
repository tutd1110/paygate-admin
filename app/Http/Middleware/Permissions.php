<?php

namespace App\Http\Middleware;

use App\Helper\BadRequest;
use App\Helper\Mycurl;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;

class Permissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (env('PERMISSION_TEST') == true) {
                return $next($request);
            } else {
                if (session('partner_code') == '' && session('owner') == 'yes') {
                    return $next($request);
                } else {
                    $routerName = $request->route()->getActionName();
                    $redis = Redis::connection();
                    $arrGroup = json_encode(session('group'));
                    if (empty($arrGroup)) {
                        return response()->view('main.home', [
                            'notification' => [
                                'type' => 'warning',
                                'message' => 'Bạn chưa có quyền truy cập trang này, Xin liên hệ quản trị viên!',
                            ]
                        ]);
                    } else {
                        if (empty($redis->get(session('partner_code') . "_" . $arrGroup))) {
                            $value = json_encode(session('route'));
                            $redis->set(session('partner_code') . "_" . $arrGroup, $value);
                        }
                        if (in_array($routerName, json_decode($redis->get(session('partner_code') . "_" . $arrGroup),true))) {
                            return $next($request);
                        } else {
                            return response()->view('main.home', [
                                'notification' => [
                                    'type' => 'warning',
                                    'message' => 'Bạn chưa có quyền truy cập trang này, Xin liên hệ quản trị viên!',
                                ]
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }
}
