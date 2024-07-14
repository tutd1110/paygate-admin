<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Mycurl;
use App\Helper\Upload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PgwPartnerResgistriMerchantController extends Controller
{
    protected $api_hm_v2_pgw_partner_resgistri_merchant;
    protected $api_hm_v2_pgw_payment_merchant;
    protected $api_hm_v2_payment;

    function __construct()
    {

        $this->api_hm_v2_pgw_partner_resgistri_merchant = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner-resgistri-merchant";
        $this->api_hm_v2_pgw_payment_merchant = config('api.HOCMAI_API_V2') . "/api/v1/pgw-payment-merchant";
        $this->api_hm_v2_payment = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner";
    }

    public function index()
    {
        $url_api = $this->api_hm_v2_pgw_partner_resgistri_merchant;
        $getPartnerResMerchant = Mycurl::getCurl($url_api);
        $url_api_merchant = $this->api_hm_v2_pgw_payment_merchant;
        $getListPayMerchant = Mycurl::getCurl($url_api_merchant);
        $ListPayMerchant = $getListPayMerchant['pgwPaymentMerchant']['data'];
        if (!empty($getPartnerResMerchant)) {
            $listPartnerResMerchant = $getPartnerResMerchant['pgwPartnerResgistriMerchant']['data'];
            return view('main.admin.partnerResgistriMerchant.index',compact('listPartnerResMerchant','ListPayMerchant'));
        } else {
            $listPartnerResMerchant = [];
        }
        return view('main.admin.partnerResgistriMerchant.index')
            ->with('listPartnerResMerchant', $listPartnerResMerchant)
            ->with('error', "không có dữ liệu");
    }

    public function create()
    {
        $url_api = $this->api_hm_v2_pgw_payment_merchant;
        $getListPayMerchant = Mycurl::getCurl($url_api);
        $ListPayMerchant = $getListPayMerchant['pgwPaymentMerchant']['data'];
        $url_api_payment = $this->api_hm_v2_payment;
        $getListPayMent = Mycurl::getCurl($url_api_payment);
        $ListPayMent = $getListPayMent['pgwPartner']['data'];
        return view('main.admin.partnerResgistriMerchant.create' ,compact('ListPayMerchant','ListPayMent'));
    }
    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_pgw_partner_resgistri_merchant . "/" . $id;

        Mycurl::deleteCurl($url_api);

        return redirect()->route('pgw_partner_resgistri_merchant.index')->with(
            'notification', [
                'type' => 'success',
                'message' => 'Xoá dữ liệu thành công',
            ]
        );
    }
    public function store(Request $req){
        if ($req->method() == 'GET') {
            return $this->create();
        } elseif ($req->method() == 'POST') {
            $url_api = $this->api_hm_v2_pgw_partner_resgistri_merchant;
            $getListParResMerchant = Mycurl::getCurl($url_api);
            $ListParResMerchant = $getListParResMerchant['pgwPartnerResgistriMerchant']['data'];
            $params = $req->all();
            if ($params['payment_merchant'] == 8) {
                $rules = [
                    'partner_code' => 'required',
                    'payment_merchant' => 'required',
                    'sort' => 'required',
                    'business' => 'required',
                    'code' => 'required',
                    'item-partner_code' => 'required',
                    'owner' => 'required',
                    'branch' => 'required',
                    'name' => 'required',
                    'bank_number' => 'required',
                    'bank_business' => 'required',
                    'sort_bank' => 'required',
                ];
                $messages = [
                    'partner_code.required' => "Chưa chọn đối tác!",
                    'payment_merchant.required' => "Chưa chọn cổng thanh toán!",
                    'sort.required' => 'Vị trí không được trống',
                    'business.required' => 'Mô tả không được trống',
                    'code.required' => 'Mã ngân hàng không được trống',
                    'item-partner_code.required' => 'Mã ngân hàng không được trống',
                    'owner.required' => 'Mã ngân hàng không được trống',
                    'branch.required' => 'Mã ngân hàng không được trống',
                    'name.required' => 'Mã ngân hàng không được trống',
                    'bank_number.required' => 'Mã ngân hàng không được trống',
                    'bank_business.required' => 'Mã ngân hàng không được trống',
                    'sort_bank.required' => 'Mã ngân hàng không được trống',
                ];
            } else {
                $rules = [
                    'partner_code' => 'required',
                    'payment_merchant' => 'required',
                    'sort' => 'required',
                    'business' => 'required',
                ];
                $messages = [
                    'partner_code.required' => "Chưa chọn đối tác!",
                    'payment_merchant.required' => "Chưa chọn cổng thanh toán!",
                    'sort.required' => 'Mô tả không được trống',
                    'business.required' => 'Mô tả không được trống',
                ];
            }
            $validator = Validator::make($params, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $postInput = [
                "partner_code" => $params['partner_code'],
                "payment_merchant_id" => $params['payment_merchant'],
                "sort" => $params['sort'],
                "business" => $params['business'],
            ];
//        if ($params['payment_merchant'] == 8){
//            if ($req->hasfile('thumb_path')) {
//                $path = 'images/course' . date("/Y/m/d/");
//                $thumb_path = $params['thumb_path'];
//                $path_thumb_nail = Upload::uploadImage($thumb_path, $path);
//
//                $params['thumb_path'] = $path_thumb_nail;
//            }
//            $postInputBank = [
//                "code" => $params['code'],
//                "partner_code" => $params['item-partner_code'],
//                "name" => $params['name'],
//                "bank_number" => $params['bank_number'],
//                "business" => $params['bank_business'],
//                "status" => $params['status'],
//                "sort" => $params['item-sort'],
//                "branch" => $params['branch'],
//                "owner" => $params['owner'],
//                "thumb_path" => $params['thumb_path'],
//                "description" => $params['description'],
//
//            ];
//            Mycurl::postCurl($url_api, $postInputBank);
//        }
            Mycurl::postCurl($url_api, $postInput);
            return redirect()->route('pgw_partner_resgistri_merchant.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Thêm đối tác thành công',
                ]
            );
        }
    }
    public function edit($id)
    {

        $url_api = $this->api_hm_v2_pgw_partner_resgistri_merchant;
        $getPartnerResMerchant = Mycurl::getCurl($url_api,['id' => $id]);
        $listPartnerResMerchant = $getPartnerResMerchant['pgwPartnerResgistriMerchant']['data'][0];
        $url_api_merchant = $this->api_hm_v2_pgw_payment_merchant;
        $getListPayMerchant = Mycurl::getCurl($url_api_merchant);
        $ListPayMerchant = $getListPayMerchant['pgwPaymentMerchant']['data'];
        $url_api_payment = $this->api_hm_v2_payment;
        $getListPayMent = Mycurl::getCurl($url_api_payment);
        $ListPayMent = $getListPayMent['pgwPartner']['data'];
        return view('main.admin.partnerResgistriMerchant.edit',compact('listPartnerResMerchant','ListPayMerchant','ListPayMent'));

    }
    public function update(Request $request, $id)
    {
        if ($request->method() == 'GET') {
            return $this->edit($id);
        } elseif ($request->method() == 'PUT') {

            $url_api = $this->api_hm_v2_pgw_partner_resgistri_merchant . "/" . $id;
            $url_api_payment_res_mer = $this->api_hm_v2_pgw_partner_resgistri_merchant;
            $getData = Mycurl::getCurl($url_api_payment_res_mer);
            $checkData = Mycurl::getCurl($url_api_payment_res_mer, ['id' => $id]);
            $params = $request->all();

            $rules = [
                'partner_code' => 'required',
                'payment_merchant' => 'required',
                'sort' => 'required',
                'business' => 'required',
            ];

            $messages = [
                'partner_code.required' => "Tên đối tác không được trống!",
                'payment_merchant.required' => "Mã đối tác không được trống!",
                'sort.required' => 'Mô tả không được trống',
                'business.required' => 'Mô tả không được trống',
            ];
            $validator = Validator::make($params, $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            foreach ($getData['pgwPartnerResgistriMerchant']['data'] as $item) {
                if ($item['partner_code'] == $params['partner_code'] && $item['partner_code'] != $checkData['pgwPartnerResgistriMerchant']['data'][0]['partner_code']) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withErrors(['partner_code' => 'Mã đối tác đã tồn tại'])
                        ->withInput();
                }
            }
            $partner_code = $params['partner_code'];
            $payment_merchant = $params['payment_merchant'];
            $sort = $params['sort'];
            $business = $params['business'];


            $postInput = [
                "partner_code" => $partner_code,
                "payment_merchant_id" => $payment_merchant,
                "sort" => $sort,
                "business" => $business,
            ];

            Mycurl::putCurl($url_api, $postInput);
            return redirect()->route('pgw_partner_resgistri_merchant.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Cập nhật thành công',
                ]
            );
        }
    }
}
