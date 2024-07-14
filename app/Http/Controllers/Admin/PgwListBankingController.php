<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Mycurl;
use App\Helper\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\PGW\BankingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PgwListBankingController extends Controller
{
    protected $api_hm_v2_pgw_list_banking;

    function __construct()
    {

        $this->api_hm_v2_pgw_list_banking = config('api.HOCMAI_API_V2') . "/api/v1/pgw-banking-list";
    }

    public function index()
    {
        $url_api = $this->api_hm_v2_pgw_list_banking;
        $getBanking = Mycurl::getCurl($url_api);
        if (!empty($getBanking)) {
            $listBanking = $getBanking['pgwBankingList']['data'];
            return view('main.admin.pgwListBanking.index')
                ->with('listBanking', $listBanking);
        } else {
            $listBanking = [];
        }
        return view('main.admin.pgwPaymentMerchant.index')
            ->with('listBanking', $listBanking)
            ->with('error', "không có dữ liệu");
    }

    public function create()
    {
        return view('main.admin.pgwListBanking.create');
    }

    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_pgw_list_banking . "/" . $id;

        Mycurl::deleteCurl($url_api);

        return redirect()->route('pgw_listbanking.index')->with(
            'notification', [
                'type' => 'success',
                'message' => 'Xoá dữ liệu thành công',
            ]
        );
    }

    public function store(BankingRequest $req)
    {
        if ($req->method() == 'GET') {
            return $this->create();
        } elseif ($req->method() == 'POST') {
            $url_api = $this->api_hm_v2_pgw_list_banking;
            $getBanking = Mycurl::getCurl($url_api);
            $params = $req->all();
            if ($req->hasfile('thumb_path')) {
                $path = 'images/course' . date("/Y/m/d/");
                $thumb_path = $params['thumb_path'];
                $path_thumb_nail = Upload::uploadImage($thumb_path, $path);
                $params['thumb_path'] = $path_thumb_nail;
            } else {
                $params['thumb_path'] = $params['thumb_path_input'];
            }
            foreach ($getBanking['pgwBankingList']['data'] as $getBanking) {
                if (strtolower($getBanking['code']) == strtolower($params['code'])) {
                    return redirect()->back()
                        ->withErrors(['code' => 'Mã ngân hàng đã tồn tại'])
                        ->withInput();
                }
            }
            $name = $params['name'];
            $code = $params['code'];
            $thumb_path = $params['thumb_path'];
            $status = $params['status'];
            $postInput = [
                "name" => $name,
                "code" => $code,
                "thumb_path" => $thumb_path,
                "status" => $status,
            ];
            Mycurl::postCurl($url_api, $postInput);
            return redirect()->route('pgw_listbanking.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Thêm ngân hàng thành công',
                ]
            );
        }
    }

    public function edit($id)
    {
        $item = $this->findID($id);
        if (!$item) {
            return redirect()->route('pgw_listbanking.index')->with(
                'notification', [
                    'type' => 'error',
                    'message' => 'Không tìm thây dữ liệu',
                ]
            );
        }
        return view('main.admin.pgwListBanking.edit', compact('item'));

    }

    public function update(Request $req, $id)
    {
        if ($req->method() == 'GET') {
            return $this->edit($id);
        } elseif ($req->method() == 'PUT') {
            $url_api = $this->api_hm_v2_pgw_list_banking . "/" . $id;
            $url_api_list_banking = $this->api_hm_v2_pgw_list_banking;
            $getData = Mycurl::getCurl($url_api_list_banking);
            $checkData = Mycurl::getCurl($url_api_list_banking, ['id' => $id]);
            $params = $req->all();

            if ($req->hasfile('thumb_path')) {
                $path = 'images/course' . date("/Y/m/d/");
                $thumb_path = $params['thumb_path'];
                $path_thumb_nail = Upload::uploadImage($thumb_path, $path);

                $params['thumb_path'] = $path_thumb_nail;
            } else {
                $params['thumb_path'] = $params['thumb_path_input'];
            }
            $rule = new BankingRequest();
            $validator = Validator::make($params, $rule->rules(), $rule->messages());
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($params);
            }
            foreach ($getData['pgwBankingList']['data'] as $item) {
                if ($item['code'] == $params['code'] && $item['code'] != $checkData['pgwBankingList']['data'][0]['code']) {
                    return redirect()->back()
                        ->withErrors(['code' => 'Mã ngân hàng đã tồn tại'])
                        ->withInput();
                }
                if ($item['name'] == $params['name'] && $item['name'] != $checkData['pgwBankingList']['data'][0]['name']) {
                    return redirect()->back()
                        ->withErrors(['name' => 'Tên ngân hàng đã tồn tại'])
                        ->withInput();
                }
            }
            $name = $params['name'];
            $code = $params['code'];
            $thumb_path = $params['thumb_path'];
            $status = $params['status'];

            $postInput = [
                "name" => $name,
                "code" => $code,
                "thumb_path" => $thumb_path,
                "status" => $status,
            ];

            Mycurl::putCurl($url_api, $postInput);
            return redirect()->route('pgw_listbanking.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Cập nhật thành công',
                ]
            );
        }
    }

    public function findID($id)
    {
        $url_api = $this->api_hm_v2_pgw_list_banking;
        $listListBanking = Mycurl::getCurl($url_api, ['id' => $id]);
        $getListBanking = $listListBanking['pgwBankingList']['data'];
        return $getListBanking;
    }
}
