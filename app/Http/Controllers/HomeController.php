<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        
        
        return view('main.home');

    }

    public function listBanner()
    {   
        $curl = curl_init();

        curl_setopt_array(
            $curl, array(
            CURLOPT_URL => 'http://local.api-hocmaiv2.vn/backend/v1/banner/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('desktop_image' => '/media/images/home/desktop/522xx3245day.jpg','image_mobile' => '/media/images/home/mobile/522xx3245day.jpg','description' => 'TRỌN BỘ LỘ TRÌNH LUYỆN THI TOÀN DIỆN CHINH PHỤC ĐẠI HỌC TOP ĐẦU VỚI ĐIỂM SỐ TỐI ĐA','sort' => '10','link' => 'https://hocmai.vn/luyen-thi-dai-hoc/giai-phap-pen-2022','target' => 'none','status' => 'active','created_by' => '1','updated_by' => '1','url_page' => 'https://hocmai.vn/luyen-thi-dai-hoc/giai-phap-pen-2022','orient' => 'landscape','position' => 'top','show_time' => '2022-06-10','hide_time' => '2022-09-05'),
            CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer XY2oQ2aaNsSPc0qNN5wR8MBoeQNR6qH_M5AFkaY-wJo='
            ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);


        return $response;
    }

    public function about()
    {

    }

}
