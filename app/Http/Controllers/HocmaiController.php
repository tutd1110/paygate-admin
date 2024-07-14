<?php

namespace App\Http\Controllers;

use App\Helper\BadRequest;
use App\Helper\Mycurl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class HocmaiController extends Controller
{
    public function __construct()
    {
        $this->api_hm_v2_landingPage = config('api.HOCMAI_API_V2') . "/api/v1/landing-pages";
        $this->api_hm_v2_partner = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner";
        $this->api_hm_v2_merchant = config('api.HOCMAI_API_V2') . "/api/v1/pgw-payment-merchant";
        $this->api_hm_v2_banking = config('api.HOCMAI_API_V2') . "/api/v1/pgw-banking-list";
        $this->api_hm_v2_departments = config('api.HOCMAI_API_V2') . "/api/v1/departments";
    }

    /** lấy danh sách các LandingPage */
    public function getLDP($param, $check = true)
    {
        $param['id'] = (session('landing_page') && !empty($check)) ? session('landing_page') : null;
        if ($param['id'] != null) {
            $getListLDP = Mycurl::getCurl($this->api_hm_v2_landingPage, $param);
            $this->reponseLDP = $getListLDP['landingPages'];
        } elseif (empty(Redis::get("Landing_Page"))) {
            $landingPage = Mycurl::getCurl($this->api_hm_v2_landingPage, $param);
            $value = json_encode($landingPage['landingPages']);
            Redis::set('Landing_Page', $value, 'EX', 86400);
            $this->reponseLDP = json_decode(Redis::get("Landing_Page"),true);
        } else {
            $this->reponseLDP = json_decode(Redis::get("Landing_Page"),true);
        }
        $datasLdp = [];
        foreach ($this->reponseLDP as $datas) {
            $data = json_decode(json_encode($datas), true);
            $datasLdp[] = [
                'id' => $data['id'],
                'domain_name' => $data['domain_name'],
            ];
        }
        return $datasLdp;

    }
    // lấy danh sách các department
    public function getDepartment($param)
    {
        if (empty(Redis::get("departments"))) {
            $departments = Mycurl::getCurl($this->api_hm_v2_departments, $param);
            $value = json_encode($departments['departments']);
            Redis::set('departments', $value, 'EX', 43200);
            $this->reponseDPM = json_decode(Redis::get("departments"),true);
        } else {
            $this->reponseDPM = json_decode(Redis::get("departments"),true);
        }
        $datasDPM = [];
        foreach ($this->reponseDPM as $data) {
            $datasDPM[] = [
                'id' => $data['id'],
                'domain_name' => $data['code'],
            ];
        }
        return $datasDPM;
    }
    /** lấy danh sách các Partner */
    public function getPartner($param)
    {
        if (empty(Redis::get("PartNer"))) {
            $reponsePartner = Mycurl::getCurl($this->api_hm_v2_partner, $param);
            $value = json_encode($reponsePartner['pgwPartner']);
            Redis::set('PartNer', $value, 'EX', 43200);
            $this->listPartner = json_decode(Redis::get("PartNer"),true);
        } else {
            $this->listPartner = json_decode(Redis::get("PartNer"),true);
        }
        $datasPartner = [];
        foreach ($this->listPartner as $datas) {
            $data = json_decode(json_encode($datas), true);
            $datasPartner[] = [
                'id' => $data['id'],
                'code' => $data['code'],
            ];
        }
        return $datasPartner;
    }

    /** lấy danh sách các ngân hàng **/
    /**Baking_list */
    public function getBankingList($param = [])
    {
        if (empty(Redis::get("List_Banking"))) {
            $reponseBanking = Mycurl::getCurl($this->api_hm_v2_banking,$param);
            $value = json_encode($reponseBanking['pgwBankingList']);
            Redis::set('List_Banking', $value, 'EX', 43200);
            $this->listBank = json_decode(Redis::get("List_Banking"),true);
        } else {
            $this->listBank = json_decode(Redis::get("List_Banking"),true);
        }
        $datasBanking = [];
        if (!empty($this->listBank)) {
            foreach ($this->listBank as $data) {
                $datasBanking[] = [
                    'id' => $data['id'],
                    'code' => $data['code'],
                ];
            }
            return $datasBanking;
        }
    }

    /** lấy danh sách các cổng thanh toán **/
    /** PaymentMerchant */
    public function getPaymentMerchant($param = [])
    {
        if (empty(Redis::get("Payment_Merchant"))) {
            $reponseMerchant = Mycurl::getCurl($this->api_hm_v2_merchant,$param);
            unset($reponseMerchant['pgwPaymentMerchant']['momo_v3']);
            $value = json_encode($reponseMerchant['pgwPaymentMerchant']);
            Redis::set('Payment_Merchant', $value, 'EX', 86400);
            $this->listMerchant  = json_decode(Redis::get("Payment_Merchant"),true);
        } else {
            $this->listMerchant  = json_decode(Redis::get("Payment_Merchant"),true);
        }
        $datasMerchant = [];
        if (!empty($this->listMerchant)) {
            foreach ($this->listMerchant as $key => $data) {
                $datasMerchant[$key] = [
                    'id' => $data['id'],
                    'code' => $data['code'],
                ];
                if ($data['code'] == 'transfer') {
                    $datasMerchant[$key] = [
                        'id' => $data['id'],
                        'code' => $data['code'],
                        'banking' => $this->getBankingList(['get_all' => true])
                    ];
                }
            }
        }
        return $datasMerchant;
    }
    public function clearCacheRedis(Request $request)
    {
        $paramCache = $request->all();
        try {
            if (empty($paramCache)) {
                Redis::flushDB();
            } else{
                foreach ($paramCache as $key => $value){
                    if ($value == true){
                        Redis::del($key);
                    }
                }
            }
            return back()->with(
                'notification', [
                    'message' => 'Xoá cache thành công',
                    'type' => 'success',]
            );
        }catch (\Throwable $e){
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 500;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }
}
