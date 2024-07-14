<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PgwOrdersExport;
use App\Helper\BadRequest;
use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HocmaiController;
use App\Http\Requests\PGW\pgwOrderRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class PgwOrdersController extends HocmaiController
{
    protected $api_hm_v2_order;
    const ARRAY_STATUS_NOT_REDIRECT = ['paid', 'refund', 'fail', 'cancel', 'expired'];
    const ORDER_CLIENT_STATUS_NOT_PAID = 0;
    const STATUS_PAID = 'paid';
    const TIME_LIMIT_ORDER_STATUS = 100;

    function __construct()
    {
        $this->api_hm_v2_order = config('api.HOCMAI_API_V2') . "/api/v1/pgw-orders";
        $this->api_hm_v1_update_order_paid = config('api.HOCMAI_API_V2') . "/api/v1/pgw-orders-updatePaid";
        $this->api_hm_v1_update_order_status_to_CRM = config('api.HOCMAI_API_V2') . "/api/v1/pgw-orders-updateStatusClient";
        return parent::__construct();
    }

    public function index(Request $request)
    {
        if ($request->method() == 'POST') {
           return $this->show($request->all());
        } else {
            $param = $request->all();
            $param['partner_code'] = $request['partner_code'] ? $request['partner_code'] : session('partner_code');
            $param['landing_page_id'] = $request['landing_page_id'] ? $request['landing_page_id'] : session('landing_page');
            $param['getContact'] = true;
            $param['getOrderDetail'] = true;
            $param['getPaymentRequest'] = true;
            $param['search_submit'] = $request['landing_page_id'] ? true : null;
            $param['limit'] = $request->limit ?? config('app.limit');
            $listPage = config('app.listPage');
            $param['merchant_code'] = [];
            if (isset($param['merchant_banking_code'])) {
                foreach ($param['merchant_banking_code'] as $key => $merchantCode) {
                    $param['merchant_code'][] = $merchantCode;
                    $str = $merchantCode;
                    $sub = 'transfer';
                    if (strpos($str, $sub) !== false) {
                        $code = explode(',', $merchantCode);
                        $param['merchant_code'][$key] = $code[0];
                        $param['banking_code'][] = $code[1];
                    }
                }
            }
            in_array('momo', $param['merchant_code']) ? array_push($param['merchant_code'], 'momo_v3') : '';
            $param['order_by'] = ['id'];
            $param['direction'] = ['desc'];
            $url_api = $this->api_hm_v2_order;
            if (!empty($param['export'])) {
                $param['getLandingPage'] = true;
                $param['getContact'] = true;
                $param['getPaymentRequest'] = true;
            }
            try {
                $getDataOrders = Mycurl::getCurl($url_api, $param);
                if ($getDataOrders && !empty($param['export'])) {
                    $name = "Export_PgwOrders_" . Carbon::now()->format('Y-m-d');
                    return Excel::download(new PgwOrdersExport($getDataOrders['orders']), $name . '.xlsx');
                }
                $datasLdp = $this->getLDP(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
                $datasPartner = $this->getPartner(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
                $datasMerchant = $this->getPaymentMerchant(['get_all' => true]);
                $dataRedis = [
                    'listLDP' => $this->reponseLDP ?? null,
                    'listPartner' => $this->listPartner ?? null,
                    'listBanking' => $this->listBank ?? null,
                    'listMerchant' => $this->listMerchant ?? null,
                ];
                if (!empty($getDataOrders)) {
                    $getListOrders = $getDataOrders['orders']['data'];
                    return view('main.admin.order.index')
                        ->with([
                            'getListOrders' => $getListOrders,
                            'dataRedis' => $dataRedis,
                            'dataLDP' => $datasLdp,
                            'dataPartner' => $datasPartner,
                            'dataMerchant' => $datasMerchant,
                            'filter' => $param,
                            'limit' => $param['limit'],
                            'listPage' => $listPage,
                            'paginate' => $getDataOrders['orders'],
                        ]);
                } else {
                    $getListOrders = [];
                }
                return view('main.admin.order.index')
                    ->with('getListOrders', $getListOrders)
                    ->with('error', "không có dữ liệu");
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
        }
    }

    public function export(Request $request)
    {
        $param = $request->all();
        $param['export'] = true;
        try {
            $getDataOrders = Mycurl::getCurl($this->api_hm_v2_order, $param);
            if ($getDataOrders) {
                return $getDataOrders['orders'];
            }
            return false;
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function show($request)
    {
        $param = $request;
        $url_api = $this->api_hm_v2_order;
        $getDataOrders = Mycurl::getCurl($url_api, $param);
        if ($getDataOrders) {
            return $getDataOrders['orders'];
        } else {
            return false;
        }
    }

    public function updateOrderPaid(Request $request)
    {
        $orderID = $request->id;
        $url_api_update_order_paid = $this->api_hm_v1_update_order_paid;
        $getDataOrders = Mycurl::postCurl($url_api_update_order_paid, ['id' => $orderID]);
        if (!empty($getDataOrders)) {
            return [
                'check' => $getDataOrders['checkUpdateOrderPaid'],
                'message' => $getDataOrders['message']
            ];
        } else {
            return [
                'check' => false,
                'message' => 'Cập nhật thất bại'
            ];
        }
    }

    public function updateOrderStatusToCRM(Request $request)
    {
        $orderID = $request->id;
        $url_update_order_status_to_CRM = $this->api_hm_v1_update_order_status_to_CRM;
        $getDataOrders = Mycurl::postCurl($url_update_order_status_to_CRM, ['id' => intval($orderID)]);
        if (!empty($getDataOrders)) {
            return [
                'check' => $getDataOrders['status'],
                'message' => $getDataOrders['message']
            ];
        } else {
            return [
                'check' => false,
                'message' => 'Gửi thông tin đơn hàng sang CRM thất bại'
            ];
        }
    }

    public function create()
    {
        try {
            $datasLdp = $this->getLDP(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
            $datasPartner = $this->getPartner(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
            return view('main.admin.order.create')->with([
                'dataLDP' => $datasLdp,
                'dataPartner' => $datasPartner,
            ]);
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }

    }

    public function store(pgwOrderRequest $request)
    {
        if ($request->method() == 'GET') {
            return $this->create();
        } elseif ($request->method() == 'POST') {
            $filter = $request->validated();
            $filter['is_api'] = 'yes';
            try {
                if ($filter) {
                    $pgwOrder = Mycurl::postCurl($this->api_hm_v2_order, $filter);
                    session()->flash('url_order', $pgwOrder['redirect_url']);
                    return Redirect::route('pgw_orders.index')->with(
                        'notification', [
                            'type' => 'success',
                            'message' => 'Thêm đơn hàng thành công',
                        ]
                    );
                }
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Thêm đơn hàng thất bại',
                    ]
                );
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
        }
    }

    public function changeStatus(Request $request)
    {
        $params = $request->all();
        $url_api_order_id = $this->api_hm_v2_order . "/" . $params['id'];
        try {
            $changeStatus = Mycurl::putCurl($url_api_order_id, ["status" => "cancel"]);
            if ($changeStatus) {
                return response()->json([
                        'status' => 200,
                        'data' => $changeStatus['order']
                    ]
                );
            } else {
                return response()->json([
                        'status' => 0,
                        'data' => 'fail'
                    ]
                );
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }

    }

    public function statistical(Request $request)
    {
        try {
            $params = $request->all();
            $params = !empty($params) ? $params : ['selectMonth' => 'true', 'month' => Carbon::now()->month];
            $getStatistical = Mycurl::getCurl(config('api.HOCMAI_API_V2') . "/api/v1/pgw-statistical", $params);
            $getStatisticalMerchant = Mycurl::getCurl(config('api.HOCMAI_API_V2') . "/api/v1/pgw-statistical-merchant", $params);
            $getStatisticalRevenue = Mycurl::getCurl(config('api.HOCMAI_API_V2') . "/api/v1/pgw-statistical-revenue", $params);
            $getStatisticalMerchantRevenue = Mycurl::getCurl(config('api.HOCMAI_API_V2') . "/api/v1/pgw-statistical-merchant-revenue", $params);
            for ($date = 1; $date <= count($getStatistical['totalOrder']); $date++) {
                $getStatistical['date'][] = $date;
            }

            $arrMerchant = [];
            $arrMerchantPaid = [];
            $arrMerchantPaidRevenue = [];
            foreach ($getStatisticalMerchant['totalMerchant'] as $key => $value) {
                $arrMerchant[] = $key;
                $arrMerchantPaid[$key] = !empty($getStatisticalMerchant['totalMerchantPaid'][$key]) ? $getStatisticalMerchant['totalMerchantPaid'][$key] : 0;
                $arrMerchantPaidRevenue[$key] = !empty($getStatisticalMerchantRevenue['totalMerchantRevenuePaid'][$key]) ? $getStatisticalMerchantRevenue['totalMerchantRevenuePaid'][$key] : 0;
            }
            if (!empty($params['ajax_form'])) {
                return response()->json([
                        'totalOrder' => $getStatistical['totalOrder'],
                        'totalOrderPaid' => $getStatistical['totalOrderPaid'],
                        'totalMerchant' => $getStatisticalMerchant['totalMerchant'],
                        'totalMerchantPaid' => $arrMerchantPaid,
//                        'totalRevenue' => $getStatisticalRevenue['totalRevenue'],
                        'totalRevenuePaid' => $getStatisticalRevenue['totalRevenuePaid'],
//                        'totalMerchantRevenue' => $getStatisticalMerchantRevenue['totalMerchantRevenue'],
                        'totalMerchantRevenuePaid' => $arrMerchantPaidRevenue,
                        'date' => $getStatistical['date'],
                        'arrMerchant' => $arrMerchant,
                    ]
                );
            }
            return view('main.admin.order.statistical')->with([
                'totalOrder' => json_encode($getStatistical['totalOrder']),
                'totalOrderPaid' => json_encode($getStatistical['totalOrderPaid']),
                'totalMerchant' => json_encode($getStatisticalMerchant['totalMerchant']),
                'totalMerchantPaid' => json_encode($arrMerchantPaid),
//                'totalRevenue' => json_encode($getStatisticalRevenue['totalRevenue']),
                'totalRevenuePaid' => json_encode($getStatisticalRevenue['totalRevenuePaid']),
//                'totalMerchantRevenue' => json_encode($getStatisticalMerchantRevenue['totalMerchantRevenue']),
                'totalMerchantRevenuePaid' => json_encode($arrMerchantPaidRevenue),
                'date' => json_encode($getStatistical['date']),
                'arrMerchant' => json_encode($arrMerchant),

            ]);
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }
}
