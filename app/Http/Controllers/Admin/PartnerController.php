<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use App\Http\Requests\PGW\PartnerRequest;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    protected $api_hm_v2_partner;
    protected $api_hm_v2_pgw_payment_merchant;
    protected $api_hm_v2_pgw_partner_resgistri_merchant;
    protected $api_hm_v2_pgw_partner_resgistri_banking;
    protected $api_hm_v2_pgw_list_banking;

    public function __construct()
    {
        $this->api_hm_v2_partner = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner";
        $this->api_hm_v2_pgw_payment_merchant = config('api.HOCMAI_API_V2') . "/api/v1/pgw-payment-merchant";
        $this->api_hm_v2_pgw_partner_resgistri_merchant = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner-resgistri-merchant";
        $this->api_hm_v2_pgw_partner_resgistri_banking = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner-registri-banking";
        $this->api_hm_v2_pgw_list_banking = config('api.HOCMAI_API_V2') . "/api/v1/pgw-banking-list";
    }

    public function index(Request $request)
    {
        $param = $request->all();
        $param['order_by'] = true;
        $url_api = $this->api_hm_v2_partner;
        $getPartner = Mycurl::getCurl($url_api, $param);
        $params['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        if (isset($param['value'])) {
            $getnamePartner = Mycurl::getCurl($url_api, ['name' => $param['value']]);
            $getcodePartner = Mycurl::getCurl($url_api, ['code' => $param['value']]);
            if (!empty($getnamePartner['pgwPartner']['data'])) {
                $paginator = $getnamePartner['pgwPartner']['data'];
                $paginate = $getPartner['pgwPartner'];
                return view('main.admin.partner.index')
                    ->with([
                        'paginator' => $paginator,
                        'paginate' => $paginate,
                        'limit' => $params['limit'],
                        'listPage' => $listPage,
                    ]);
            } elseif (!empty($getcodePartner['pgwPartner']['data'])) {
                $paginator = $getcodePartner['pgwPartner']['data'];
                $paginate = $getPartner['pgwPartner'];
                return view('main.admin.partner.index')
                    ->with([
                        'paginator' => $paginator,
                        'paginate' => $paginate,
                        'limit' => $params['limit'],
                        'listPage' => $listPage,
                    ]);
            } else {
                $paginator = [];
                return view('main.admin.partner.index')
                    ->with([
                        'paginator' => $paginator,
                    ])
                    ->with('error', "không có dữ liệu");
            }
        }
        if (!empty($getPartner)) {
            $paginator = $getPartner['pgwPartner']['data'];
            $paginate = $getPartner['pgwPartner'];
            return view('main.admin.partner.index')
                ->with([
                    'paginator' => $paginator,
                    'paginate' => $paginate,
                    'limit' => $params['limit'],
                    'listPage' => $listPage,
                ]);
        } else {
            $paginator = [];
        }
        return view('main.admin.partner.index')
            ->with('paginator', $paginator)
            ->with('error', "không có dữ liệu");
    }

    public function create()
    {
        $url_api = $this->api_hm_v2_pgw_payment_merchant;
        $getPayMerchant = Mycurl::getCurl($url_api);
        $listPayMerchant = $getPayMerchant['pgwPaymentMerchant']['data'];
        $url_api_banks = $this->api_hm_v2_pgw_list_banking;
        $getBanks = Mycurl::getCurl($url_api_banks);
        $listBanks = $getBanks['pgwBankingList']['data'];
        return view('main.admin.partner.create', compact('listPayMerchant', 'listBanks'));
    }

    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_partner . "/" . $id;

        Mycurl::deleteCurl($url_api);

        return redirect()->route('pgw_partner.index')->with(
            'notification', [
                'type' => 'success',
                'message' => 'Xoá dữ liệu thành công',
            ]
        );
    }

    public function store(Request $req)
    {
        if ($req->method() == 'GET') {
            return $this->create();
        } elseif ($req->method() == 'POST') {
            $url_api = $this->api_hm_v2_partner;
            $url_api_payment = $this->api_hm_v2_pgw_partner_resgistri_merchant;
            $url_api_banking = $this->api_hm_v2_pgw_partner_resgistri_banking;
            $url_api_merchant = $this->api_hm_v2_pgw_payment_merchant;
            $getMerchants = Mycurl::getCurl($url_api_merchant);
            $params = $req->all();
            $rules = [];
            $messages = [];
            if (!isset($params['payment_merchant'])) {
                return response()->json([
                    'type' => 'error',
                ]);
            }
            $validator = Validator::make($params, $rules, $messages);
            foreach ($params['payment_merchant'] as $payment_merchant) {
                if (empty($params['payment_merchant_business'][$payment_merchant])) {
                    $validator->errors()->add('payment_merchant_business[' . $payment_merchant . ']', 'Thông tin kết nối đến cổng thanh toán không được để trống!');
                }
                if ($payment_merchant == "transfer" && empty($params['code_res_bank'])){
                    return response()->json([
                        'status' => '3'
                    ]);
                }
            }
            if (!empty($validator->errors()->all())) {
                return response()->json([
                    'status' => '2',
                    'dataError' => $validator->errors()
                ]);
            }
            $postInput = [
                "code" => $params['code'],
                "name" => $params['name'],
                "description" => $params['description'],
                "status" => $params['status'],
                "created_by" => session('id'),
            ];
            $partner = Mycurl::postCurl($url_api, $postInput);
            if ($partner) {
                $dataMerchant = [];
                $dataBusiness = [];
                foreach ($getMerchants['pgwPaymentMerchant']['data'] as $getMerchant) {
                    foreach ($params['payment_merchant_business'] as $key => $items) {
                        if (empty($items)) {
                            continue;
                        }
                        if ($getMerchant['code'] == $key) {
                            $dataMerchant[] = $getMerchant['id'];
                            $dataBusiness[] = $items;
                        }
                    };
                }
                $postListPayment = [
                    "partner_code" => $params['code'],
                    "payment_merchant_id" => $dataMerchant,
                    "business" => $dataBusiness,
                    "created_by" => session('id'),
                ];
                $merchant = Mycurl::postCurl($url_api_payment, $postListPayment);
                if ($merchant && !empty($params['code_res_bank']) && $params['payment_merchant_business']['transfer'] != null) {
                    $code = $params['code_res_bank'];
                    if (isset($params['payment_merchant']['transfer'])) {
                        $max = count($code);
                        for ($i = 0; $i < $max; $i++) {
                            $bankBusiness = str_replace("'", '"', $params['bank_business']);
                            $postPartnerBank = [
                                "code" => $code[$i],
                                "banking_list_id" => $params['banking_code'][$i],
                                "description" => $params['description_bank'][$i],
                                "partner_code" => strtoupper($params['code']),
                                "bank_number" => $params['bank_number'][$i],
                                "owner" => $params['owner'][$i],
                                "branch" => $params['branch'][$i],
                                "business" => $bankBusiness[$i],
                                "type" => $params['type'][$i],
                                "sort" => $params['sort_bank'][$i],
                            ];
                            Mycurl::postCurl($url_api_banking, $postPartnerBank);
                        }
                    }

                }
            }
            return response()->json([
                'type' => 'success',
                'message' => 'Thêm đối tác thành công',
            ], 200);
        }
    }

    public function edit($id)
    {
        $url_api = $this->api_hm_v2_partner;
        $listPartner = Mycurl::getCurl($url_api, ['id' => $id, 'resgistriMerchant' => true]);
        $getPartner = $listPartner['pgwPartner']['data'][0];
        $getMerchant = $listPartner['pgwPartner']['data'][0]['resgistri_merchant'];
        $getIdMerchant = [];
        foreach ($getMerchant as $items) {
            $getIdMerchant[] = $items['payment_merchant_id'];
        }
        $url_api_payment_merchant = $this->api_hm_v2_pgw_payment_merchant;
        $getPayMerchant = Mycurl::getCurl($url_api_payment_merchant);
        $listPayMerchant = $getPayMerchant['pgwPaymentMerchant']['data'];
        $url_api_banks = $this->api_hm_v2_pgw_list_banking;
        $getBanks = Mycurl::getCurl($url_api_banks);
        $listBanks = $getBanks['pgwBankingList']['data'];
        $listPartnerBanking = Mycurl::getCurl($url_api, ['id' => $id, 'registriBanking' => true]);
        $getRegisBanking = $listPartnerBanking['pgwPartner']['data'][0]['registri_banking'];
        return view('main.admin.partner.edit', compact('getPartner', 'listPayMerchant', 'getIdMerchant', 'listBanks', 'getMerchant', 'getRegisBanking'));
    }

    public function update(Request $request, $id)
    {
        if ($request->method() == 'GET') {
            return $this->edit($id);
        } elseif ($request->method() == 'PUT') {
            $params = $request->all();
            $rules = [];
            $messages = [];
            $url_api_part = $this->api_hm_v2_partner . "/" . $id;
            $url_api_payment = $this->api_hm_v2_pgw_partner_resgistri_merchant;
            /* Lấy dữ liệu cổng thanh toán */
            $url_api_merchant = $this->api_hm_v2_pgw_payment_merchant;
            $dataMerchants = Mycurl::getCurl($url_api_merchant);

            /* Lấy dữ liệu cổng ngân hàng */
            $url_api_banking = $this->api_hm_v2_pgw_partner_resgistri_banking;

            /* Lấy dữ liệu đối tác liên kết với cổng thanh toán */
            $url_api = $this->api_hm_v2_partner;
            $listPartner = Mycurl::getCurl($url_api, ['id' => $id, 'resgistriMerchant' => true]);
            $getMerchants = $listPartner['pgwPartner']['data'][0]['resgistri_merchant'];
            if (isset($params['payment_merchant'])) {
                $validator = Validator::make($params, $rules, $messages);
                foreach ($params['payment_merchant'] as $payment_merchant) {
                    if (empty($params['payment_merchant_business'][$payment_merchant])) {
                        $validator->errors()->add('payment_merchant_business[' . $payment_merchant . ']', 'Thông tin kết nối đến cổng thanh toán không được để trống!');
                    }
                }
                if (!empty($validator->errors()->all())) {
                    return response()->json([
                        'status' => '2',
                        'dataError' => $validator->errors()
                    ]);
                }
                $arrAyPaymerchant = [];
                foreach ($getMerchants as $key => $getMerchant) {
                    $arrAyPaymerchant[] = $getMerchant['payment_merchant_list']['code'];
                }
                $arrAyParamPaymerchant = [];
                foreach ($params['payment_merchant'] as $paymentMerchant) {
                    $arrAyParamPaymerchant[] = $paymentMerchant;
                }
                /* cổng thanh toán không sử dụng nữa  */
                $arrMerchantDels = array_diff($arrAyPaymerchant, $arrAyParamPaymerchant);

                $paymentMerchantExistIds = [];
                $dataMerChant = [];
                $dataBusiness = [];
                foreach ($getMerchants as $merchant) {
                    $paymentMerchantExistIds[] = $merchant['payment_merchant_list']['code'];
                    $url_api_payment_id = $this->api_hm_v2_pgw_partner_resgistri_merchant . "/" . $merchant['id'];
                    if (!empty($arrMerchantDels) && in_array("transfer", $arrMerchantDels) == true && $merchant['payment_merchant_list']['code'] == 'transfer') {
                        $url_api_tranfer_id = $this->api_hm_v2_pgw_partner_resgistri_merchant . "/" . $merchant['id'];
                        Mycurl::deleteCurl($url_api_tranfer_id);
                    }
                    if (!empty($params['payment_merchant_business'][$merchant['payment_merchant_list']['code']])) {
                        $postListPayment = [
                            "partner_code" => $params['code'],
                            "payment_merchant_id" => $merchant['payment_merchant_id'],
                            "business" => $params['payment_merchant_business'][$merchant['payment_merchant_list']['code']],
                        ];
                        Mycurl::putCurl($url_api_payment_id, $postListPayment);
                    } else {
                        Mycurl::deleteCurl($url_api_payment_id);
                    }
                }
                foreach ($dataMerchants['pgwPaymentMerchant']['data'] as $dataMerchant) {
                    foreach ($params['payment_merchant_business'] as $key => $paramPaymentBusiness) {
                        if (!in_array($key, $paymentMerchantExistIds) && $paramPaymentBusiness) {
                            if ($dataMerchant['code'] == $key) {
                                $dataMerChant[] = $dataMerchant['id'];
                                $dataBusiness[] = $paramPaymentBusiness;
                            }
                        }
                    }
                }
                if (!empty($dataMerChant) && !empty($dataBusiness)) {
                    $postListPayment = [
                        "partner_code" => $params['code'],
                        "payment_merchant_id" => $dataMerChant,
                        "business" => $dataBusiness,
                        "updated_by" => session('id'),
                    ];
                    Mycurl::postCurl($url_api_payment, $postListPayment);
                }
                $postInput = [
                    "code" => $params['code'],
                    "name" => $params['name'],
                    "description" => $params['description'],
                    "status" => $params['status'],
                    "updated_by" => session('id'),
                    "updated_at" => date("H:i:s d-m-Y", strtotime(Carbon::now())),
                ];
                Mycurl::putCurl($url_api_part, $postInput);
                if (in_array("transfer", $arrAyParamPaymerchant) == true) {
                    if (isset($params['check_id'])) {
                        $max = count($params['check_id']);
                        for ($i = 0; $i < $max; $i++) {
                            $bankBusiness = str_replace("'", '"', $params['bank_business']);
                            $postPartnerBank = [
                                "code" => $params['code_res_bank'][$i],
                                "banking_list_id" => $params['banking_code'][$i],
                                "description" => $params['description_bank'][$i],
                                "partner_code" => $params['code'],
                                "bank_number" => $params['bank_number'][$i],
                                "owner" => $params['owner'][$i],
                                "branch" => $params['branch'][$i],
                                "business" => $bankBusiness[$i],
                                "type" => $params['type'][$i],
                                "sort" => $params['sort_bank'][$i],
                            ];
                            if ($params['check_id'][$i] == "null") {
                                Mycurl::postCurl($url_api_banking, $postPartnerBank);
                            } else {
                                $url_api_banking_id = $this->api_hm_v2_pgw_partner_resgistri_banking . "/" . $params['check_id'][$i];
                                Mycurl::putCurl($url_api_banking_id, $postPartnerBank);
                            }

                        }
                    }
                }
                return response()->json([
                    'type' => 'success',
                    'message' => 'Cập nhật đối tác thành công',
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                ]);
            }
        }
    }

    public function checkValidateParner(Request $request)
    {
        $params = $request->all();
        $url_api = $this->api_hm_v2_partner;
        $getPartner = Mycurl::getCurl($url_api);
        $checkData = Mycurl::getCurl($url_api, ['id' => $params['idPartner']]);
        $rules = [
            'valueCode' => 'required|max:15',
            'valueName' => 'required|max:20',
            'valueDescription' => 'max:2000',
        ];
        $messages = [
            'valueCode.required' => "Mã đối tác không được để trống!",
            'valueCode.max' => "Mã đôi tác không quá 15 ký tự!",
            'valueName.required' => "Tên đối tác không được để trống!",
            'valueName.max' => "Tên đôi tác không quá 20 ký tự!",
            'valueDescription.max' => "Mô tả đôi tác không quá 2000 ký tự!",
        ];
        $validator = Validator::make($params, $rules, $messages);
        foreach ($getPartner['pgwPartner']['data'] as $item) {
            if (strtolower($item['code']) == strtolower($params['valueCode']) && $params['idPartner'] == null) {
                $validator->errors()->add('valueCode', 'Mã đối tác đã tồn tại');
            }
            if (strtolower($item['name']) == strtolower($params['valueName']) && $item['name'] != $checkData['pgwPartner']['data'][0]['name']) {
                $validator->errors()->add('valueName', 'Tên đối tác đã tồn tại');
            } elseif (strtolower($item['name']) == strtolower($params['valueName']) && $params['idPartner'] == null) {
                $validator->errors()->add('valueName', 'Tên đối tác đã tồn tại');
            }
        }
        if (!empty($validator->errors()->all())) {
            return response()->json([
                    'status' => 0,
                    'error' => $validator->errors()
                ]
            );
        }
    }

    public function checkBankingPartner(Request $request)
    {
        $valueForm = $request->all();
        $rules = [
            "banking_code" => "required",
            "owner" => "required|string",
            "branch" => "required",
            "bank_number" => "required",
            "bank_business" => "required",
            "code_res_bank" => "required",
        ];
        $messages = [
            "banking_code.required" => "Mã ngân hàng không được trống",
            "branch.required" => "Chi nhánh ngân hàng không được trống",
            "bank_number.required" => "Chưa nhập số tài khoản",
            "bank_business.required" => "Thông tin kết nối đến ngân hàng không được trống",
            "code_res_bank.required" => "Mã Code không được trống",
            "owner.required" => "Tên chủ tài khoản không được trống",
        ];
        $validator = Validator::make($valueForm, $rules, $messages);
        if (!empty($validator->errors()->all())) {
            return response()->json([
                    'status' => 0,
                    'error' => $validator->errors()
                ]
            );
        } else {
            return response()->json([
                    'status' => 1,
                    'data' => $valueForm
                ]
            );
        }
    }
}
