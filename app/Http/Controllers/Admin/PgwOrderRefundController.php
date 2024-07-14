<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BadRequest;
use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HocmaiController;
use App\Http\Requests\PGW\OrderRefundRequest;
use Illuminate\Http\Request;

class PgwOrderRefundController extends HocmaiController
{
    protected $api_hm_v2_pgw_order_refund;

    function __construct()
    {
        $this->api_hm_v2_pgw_order_refund = config('api.HOCMAI_API_V2') . "/api/v1/pgw-order-refund";
        $this->api_hm_v2_order_details = config('api.HOCMAI_API_V2') . "/api/v1/pgw-order-details";
        parent::__construct();
    }

    public function index(Request $request)
    {
        $url_api = $this->api_hm_v2_pgw_order_refund;
        $param = $request->all();
        $param['partner_code'] = $request['partner_code'] ? $request['partner_code'] : session('partner_code');
        $param['landing_page_id'] = $request['landing_page_id'] ? $request['landing_page_id'] : session('landing_page');
        $param['search_submit'] = $request['landing_page_id'] ? true : null;
        $param['order_by'] = ['id'];
        $param['direction'] = ['desc'];
        $param['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        try {
            $getOrderRefund = Mycurl::getCurl($url_api, $param);
            $datasLdp = $this->getLDP(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);
            $datasPartner = $this->getPartner(['order' => 'id', 'direction' => 'desc', 'get_all' => true]);

            if (!empty($getOrderRefund)) {
                $listOrderRefunds = $getOrderRefund['pgwOrderRefund']['data'];
                return view('main.admin.pgwOrderRefund.index')
                    ->with([
                        'listOrderRefunds' => $listOrderRefunds,
                        'dataLDP' => $datasLdp,
                        'dataPartner' => $datasPartner,
                        'filter' => $param,
                        'limit' => $param['limit'],
                        'listPage' => $listPage,
                        'paginate' => $getOrderRefund['pgwOrderRefund'],
                    ]);
            } else {
                $listOrderRefunds = [];
            }

            return view('main.admin.pgwOrderRefund.index')
                ->with('listOrderRefunds', $listOrderRefunds)
                ->with('error', "không có dữ liệu");
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_pgw_order_refund . "/" . $id;
        Mycurl::deleteCurl($url_api);
        return back();
    }

    public function store(OrderRefundRequest $request)
    {
        $arrayOrderDetailId = $request->array_order_detail_id;
        $url_api = $this->api_hm_v2_pgw_order_refund;
        $request->created_by = session('google_id');
        $request->updated_by = session('google_id');
        $params = $request->validated();
        try {

            foreach ($arrayOrderDetailId as $orderDetailId) {
                $getClass = Mycurl::putCurl(
                    $this->api_hm_v2_order_details . "/" . $orderDetailId,
                    [
                        'is_refund' => 'yes',
                        'order_detail_id' => $orderDetailId
                    ]);
            }
            $orderRefunds = Mycurl::postCurl($url_api, $params);
            return $orderRefunds;
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function export(Request $request)
    {
        $param = $request->all();
        $param['export'] = true;
        try {
            $getDataOrderRefund = Mycurl::getCurl($this->api_hm_v2_pgw_order_refund, $param);
            if ($getDataOrderRefund) {
                return $getDataOrderRefund['pgwOrderRefund'];
            }
            return false;
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function statusChange(OrderRefundRequest $request)
    {
        $id = $request->id;
        $status = $request->status;
        try {
            $orderRefunds = Mycurl::putCurl($this->api_hm_v2_pgw_order_refund . '/' . $id, ['status' => $status, 'updated_by' => session('google_id')]);
            return $orderRefunds;
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }
}
