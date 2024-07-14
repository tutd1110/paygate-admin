<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Mycurl;
use App\Helper\Upload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HocmaiController;


class PgwPaymentRequestController extends HocmaiController
{
    protected $api_hm_v2_pgw_payment_request;
    protected $api_hm_v2_pgw_list_banking;
    protected $api_hm_v2_pgw_payment_merchant;
    protected $api_hm_v2_partner;

    function __construct()
    {
        $this->api_hm_v2_partner = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner";
        $this->api_hm_v2_pgw_payment_request = config('api.HOCMAI_API_V2') . "/api/v1/pgw-payment-request";
        $this->api_hm_v2_pgw_list_banking = config('api.HOCMAI_API_V2') . "/api/v1/pgw-banking-list";
        $this->api_hm_v2_pgw_payment_merchant = config('api.HOCMAI_API_V2') . "/api/v1/pgw-payment-merchant";
        return parent::__construct();

    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        $url_api = $this->api_hm_v2_pgw_payment_request;
        /* get list banking */
        $listBanking = $this->getBankingList();
        /* get list merchant */

        $listPaymentMerchant = $this->getPaymentMerchant();
        /* get list partner */
        $listPartner = $this->getPartner(['get_all' => true]);
        $getPaymentRequest = Mycurl::getCurl($url_api,$params);
        if (!empty($getPaymentRequest)) {
            $paginator = $getPaymentRequest['pgwPaymentRequest']['data'];
            $paginate = $getPaymentRequest['pgwPaymentRequest'];
            return view('main.admin.pgwPaymentRequest.index')
                ->with([
                    'paginator' => $paginator,
                    'paginate' => $paginate,
                    'limit' => $params['limit'],
                    'listPage' => $listPage,
                    'listBanking' => $listBanking,
                    'listPartner' => $listPartner,
                    'listPaymentMerchant' => $listPaymentMerchant,
                    'filter' => $params,
                ]);
        } else {
            $paginator = [];
        }
        return view('main.admin.pgwPaymentRequest.index')
            ->with('paginator', $paginator)
            ->with('error', "không có dữ liệu");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
