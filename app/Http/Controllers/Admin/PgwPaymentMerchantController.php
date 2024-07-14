<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Mycurl;
use App\Helper\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\PGW\MerchantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PgwPaymentMerchantController extends Controller
{
    protected $api_hm_v2_pgw_payment_merchant;

    function __construct()
    {

        $this->api_hm_v2_pgw_payment_merchant = config('api.HOCMAI_API_V2') . "/api/v1/pgw-payment-merchant";
    }

    public function index()
    {
        $url_api = $this->api_hm_v2_pgw_payment_merchant;
        $getPaymentMerchant = Mycurl::getCurl($url_api);
        if (!empty($getPaymentMerchant)) {
            $listPaymentMerchant = $getPaymentMerchant['pgwPaymentMerchant']['data'];
            return view('main.admin.pgwPaymentMerchant.index')
                ->with('listPaymentMerchant', $listPaymentMerchant);
        } else {
            $listPaymentMerchant = [];
        }
        return view('main.admin.pgwPaymentMerchant.index')
            ->with('listPaymentMerchant', $listPaymentMerchant)
            ->with('error', "không có dữ liệu");
    }

    public function create()
    {
        return view('main.admin.pgwPaymentMerchant.create');
    }

    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_pgw_payment_merchant . "/" . $id;

        Mycurl::deleteCurl($url_api);

        return redirect()->route('pgw_payment_merchant.index')->with(
            'notification', [
                'type' => 'success',
                'message' => 'Xoá dữ liệu thành công',
            ]
        );
    }

    public function store(MerchantRequest $req)
    {
        if ($req->method() == 'GET'){
            return $this->create();
        }elseif ($req->method() == 'POST') {
            $url_api = $this->api_hm_v2_pgw_payment_merchant;
            $getPayments = Mycurl::getCurl($url_api);
            $params = $req->all();
            if ($req->hasfile('thumb_path')) {
                $path = 'images/course' . date("/Y/m/d/");
                $thumb_path = $params['thumb_path'];
                $path_thumb_nail = Upload::uploadImage($thumb_path, $path);
                $params['thumb_path'] = $path_thumb_nail;
            } else {
                $params['thumb_path'] = $params['thumb_path_input'];
            }
            foreach ($getPayments['pgwPaymentMerchant']['data'] as $payment) {
                if (strtolower($payment['code']) == strtolower($params['code'])) {
                    return redirect()->back()
                        ->withErrors(['code' => 'Mã cổng thanh toán đã tồn tại'])
                        ->withInput($params);
                }
            }
            foreach ($getPayments['pgwPaymentMerchant']['data'] as $payment) {
                if ($payment['sort'] == $params['sort']) {
                    return redirect()->back()
                        ->withErrors(['sort' => 'Vị trí đã tồn tại'])
                        ->withInput($params);
                }
            }

            $name = $params['name'];
            $code = $params['code'];
            $thumb_path = $params['thumb_path'];
            $status = $params['status'];
            $sort = $params['sort'];
            $description = $params['description'];

            $postInput = [
                "name" => $name,
                "code" => $code,
                "thumb_path" => $thumb_path,
                "status" => $status,
                "sort" => $sort,
                "description" => $description,
            ];
            Mycurl::postCurl($url_api, $postInput);
            return redirect()->route('pgw_payment_merchant.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Thêm đối tác thành công',
                ]
            );
        }
    }

    public function edit($id)
    {
        $item = $this->findID($id);
        if (!$item) {
            return redirect()->route('pgw_payment_merchant.index')->with(
                'notification', [
                    'type' => 'error',
                    'message' => 'Không tìm thây dữ liệu',
                ]
            );
        }
        return view('main.admin.pgwPaymentMerchant.edit', compact('item'));

    }

    public function update(Request $req, $id)
    {
        if ($req->method() == 'GET') {
            return $this->edit($id);
        } elseif ($req->method() == 'PUT') {
            $url_api = $this->api_hm_v2_pgw_payment_merchant . "/" . $id;
            $url_api_payment_merchant = $this->api_hm_v2_pgw_payment_merchant;
            $getData = Mycurl::getCurl($url_api_payment_merchant);
            $checkData = Mycurl::getCurl($url_api_payment_merchant, ['id' => $id]);
            $params = $req->all();
            if ($req->hasfile('thumb_path')) {
                $path = 'images/course' . date("/Y/m/d/");
                $thumb_path = $params['thumb_path'];
                $path_thumb_nail = Upload::uploadImage($thumb_path, $path);
                $params['thumb_path'] = $path_thumb_nail;
            } else {
                $params['thumb_path'] = $params['thumb_path_input'];
            }
            $rule = new MerchantRequest();
            $validator = Validator::make($params, $rule->rules(), $rule->messages());
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($params);
            }
            foreach ($getData['pgwPaymentMerchant']['data'] as $item) {
                if (strtolower($item['code']) == strtolower($params['code']) && strtolower($item['code']) != strtolower($checkData['pgwPaymentMerchant']['data'][0]['code'])) {
                    return redirect()->back()
                        ->withErrors(['code' => 'Mã cổng thanh toán đã tồn tại'])
                        ->withInput();
                }
            }
            foreach ($getData['pgwPaymentMerchant']['data'] as $item) {
                if ($item['sort'] == $params['sort'] && $item['sort'] != $checkData['pgwPaymentMerchant']['data'][0]['sort']) {
                    return redirect()->back()
                        ->withErrors(['sort' => 'Vị trí đã tồn tại'])
                        ->withInput();
                }
            }
            $name = $params['name'];
            $code = $params['code'];
            $thumb_path = $params['thumb_path'];
            $status = $params['status'];
            $sort = $params['sort'];
            $description = $params['description'];

            $postInput = [
                "name" => $name,
                "code" => $code,
                "thumb_path" => $thumb_path,
                "status" => $status,
                "sort" => $sort,
                "description" => $description,
            ];
            Mycurl::putCurl($url_api, $postInput);
            return redirect()->route('pgw_payment_merchant.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Cập nhật thành công',
                ]
            );
        }
    }

    public function statusChange(Request $req, $id)
    {
        $msg = [];
        if ($id) {
            $url_api = $this->api_hm_v2_pgw_payment_merchant;
            $item = $this->findID($id);
            $item[0]['status'] = $req->status;
            $update = Mycurl::putCurl($url_api . "/" . $id, $item[0]);

            if (!empty($update)) {
                dd($update);
                $msg['msg'] = 'success';
                $msg['status'] = $update['status'];
            } else {
                $msg['msg'] = 'error';
            }
        }

        return response()->json($msg, 200);
    }
    public function findID($id)
    {
        $url_api = $this->api_hm_v2_pgw_payment_merchant;
        $listPaymentMerchant = Mycurl::getCurl($url_api, ['id' => $id]);
        $getPaymentMerchant = $listPaymentMerchant['pgwPaymentMerchant']['data'];
        return $getPaymentMerchant;
    }
}
