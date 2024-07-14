<?php

namespace App\Mylib;

use App\Helper\Mycurl;
use App\Helper\Request;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;


class Users
{
    const TIME_OUT = 120;

    private $user = [];
    private $permissions = [];

    public function __construct()
    {

    }

    public function checklogin()
    {
        try {
            $access_token = session()->get('access_token');
            $email = session()->get('email');
            $url_api = env('HOCMAI_API_V2').'/api/v1/login-google';
            $params = ['email' => $email];
            $params['email'] = Crypt::encryptString($params['email']);
            $content = Mycurl::get($url_api,$params);

            if ($content['user']['id']) {
                $this->user = $content['user'];
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }

    }

    public function getuser()
    {
        return $this->user;
    }

    public function loginGoogle($params)
    {
        $url_api = env('HOCMAI_API_V2').'/api/v1/login-google';
        $params['email'] = Crypt::encryptString($params['email']);
        $content = Mycurl::get($url_api,$params);
        if (!$content['user']) {
            return null;
        } else {
            if ( $content['user']['owner']== 'no' && $content['user']['landing_page']) {
                $datasLdp = [];
                foreach ($content['user']['landing_page'] as $key => $data) {
                        $datasLdp[$key] = $data['id'];
                }
                $content['user']['landing_page'] = $datasLdp;
            }
            if ( $content['user']['owner'] != "") {
                $datasGroup = [];
                foreach ($content['user']['groups'] as $key => $data) {
                    $datasGroup[$key] = $data['id'];
                }
                $content['user']['groups'] = $datasGroup;
            }

            return $content;
        }
    }
}
