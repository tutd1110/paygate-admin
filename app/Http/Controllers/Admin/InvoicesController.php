<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helper\BadRequest;
use App\Helper\Mycurl;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\HocmaiController;
use App\Http\Requests\PGW\InvoicesRequest;




class InvoicesController extends HocmaiController
{
    protected $api_hm_v2_invoices;
    protected $api_hm_v_2__invoices;
    protected $api_hm_v2_order;

    function __construct()
    {
        $this->api_hm_v2_invoices = config('api.HOCMAI_API_V2') . "/api/v1/invoices";
        $this->api_hm_v2_order = config('api.HOCMAI_API_V2') . "/api/v1/pgw-order-details";
        $this->api_hm_v_2__invoices = config('api.HOCMAI_API_V2') . "/api/v2/public/payments";
        return parent::__construct();
    }
    public function export(Request $request)
    {
        $param = $request->all();
        $param['export'] = true;
        try {
            $getDataInvoices = Mycurl::getCurl($this->api_hm_v2_invoices, $param);
            if ($getDataInvoices) {
                return $getDataInvoices['invoices'];
            }
            return false;
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function index(Request $request)
    {
        $param = $request->all();
        $param['partner_code'] = $request['partner_code'] ? $request['partner_code'] : session('partner_code');
        $param['landing_page_id'] = $request['landing_page_id'] ? $request['landing_page_id'] : session('landing_page');
        $param['getPaymentMerchant'] = true;
        $param['getDepartment'] = true;
        $param['getInvoiceItem'] = true;
        $param['getLandingPage'] = true;
        $param['getBanking'] = true;
        $param['getOrderDetail'] = true;
        $param['getContact'] = true;
        $param['search_submit'] = $request['landing_page_id'] ? true : null;
        $param['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        $param['order_by'] = ['id'];
        $param['direction'] = ['desc'];
        $url_api = $this->api_hm_v2_invoices;
        try {
            $getDataInvoices = Mycurl::getCurl($url_api, $param);
            $datasLdp = $this->getLDP(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
            $datasPartner = $this->getPartner(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
            $datasMerchant = $this->getPaymentMerchant(['get_all' => true]);
            $datasDepartment = $this->getDepartment(['get_all' => true]);
            $dataRedis = [
                'datasDepartment' => $this->reponseDPM ?? null,
                'listMerchant' => $this->listMerchant ?? null,

            ];
            if (!empty($getDataInvoices)) {
                $getListInvoice = $getDataInvoices['invoices']['data'];
                return view('main.admin.invoice.index')
                    ->with([
                        'getListInvoices' => $getListInvoice,
                        'dataRedis' => $dataRedis,
                        'dataLDP' => $datasLdp,
                        'dataPartner' => $datasPartner,
                        'datasDepartment' => $datasDepartment,
                        'datasMerchant' => $datasMerchant,
                        'filter' => $param,
                        'limit' => $param['limit'],
                        'listPage' => $listPage,
                        'paginate' => $getDataInvoices['invoices']
                    ]);
            } else {
                $getListInvoices = [];
            }
            return view('main.admin.invoice.index')
                ->with('getListInvoices', $getListInvoices)
                ->with('error', "không có dữ liệu");
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function create()
    {
        try {
            $datasLdp = $this->getLDP(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
            $datasPartner = $this->getPartner(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
            return view('main.admin.invoice.create')->with([
                'dataLDP' => $datasLdp,
                'dataPartner' => $datasPartner,
            ]);
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }







    public function store(InvoicesRequest $request)
    {
        if ($request->method() == 'GET') {
            return $this->create();
        } elseif ($request->method() == 'POST') {
            $filter = $request->validated();
            $filter['is_api'] = '1';
            try {
                if ($filter) {
                    $invoices = Mycurl::getCurl($this->api_hm_v_2__invoices, $filter);
                    session()->flash('url_order', $invoices['redirect_url']);
                    return Redirect::route('invoices.index')->with(
                        'notification', [
                        'type' => 'success',
                        'message' => 'Thêm đơn hàng thành công',
                    ]);
                }
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Thêm đơn hàng thất bại',
                    ]
                );
            } catch (\Throwable $e) {
                dd($e);
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $param = $request->all();
        $url_api_invoices = $this->api_hm_v2_invoices;
        // $url_api_order = $this->api_hm_v2_order;



        $getDataInvoices = Mycurl::getCurl($url_api_invoices, $param);
        // if (isset($param['hm_order_id'])) {
        //     $getDataOrder = Mycurl::getCurl($url_api_order, ['order_id' => $param['hm_order_id']]);
        // }
        if ($getDataInvoices) {
            if (isset($param['hm_order_id'])) {
                $data = [
                    'data'=> [
                    'invoices' =>$getDataInvoices['invoices']['data'],
                    ]
                ];
            }else{
                return $getDataInvoices['invoices'];
            }
            return $data;
        } else {
            return false;
        }
    }

}
