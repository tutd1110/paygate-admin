<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PgwPartnerResBankingController extends Controller
{
    protected $api_hm_v2_pgw_partner_resgistri_banking;

    function __construct()
    {
        $this->api_hm_v2_pgw_partner_resgistri_banking = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner-registri-banking";
    }

    public function index()
    {
        $url_api = $this->api_hm_v2_pgw_partner_resgistri_banking;
        $getData = Mycurl::getCurl($url_api);
        if (!empty($getData)) {
            $listPartnerResBank = $getData['pgwPartnerRegistriBanking']['data'];
            return view('main.admin.partnerResgistriBanking.index', compact('listPartnerResBank'));
        } else {
            $listPartnerResBank = [];
        }
        return view('main.admin.partnerResgistriBanking.index')
            ->with('listPartnerResBank', $listPartnerResBank)
            ->with('error', "không có dữ liệu");
    }

    public function store(Request $request)
    {
        $msg = [];
        $url_api_banking = $this->api_hm_v2_pgw_partner_resgistri_banking;
        $postPartnerBank = [
            "code" => $request->banking_code,
            "description" => $request->description,
            "partner_code" => $request->partner_code,
            "owner" => $request->owner,
            "bank_number" => $request->bank_number,
            "branch" => $request->branch,
            "business" => $request->bank_business,
            "type" => $request->type,
            "sort" => $request->sort_bank,
            "banking_list_id" => "2",
        ];
        Mycurl::postCurl($url_api_banking, $postPartnerBank);
//        return $postPartnerBank;
        return response()->json($msg, 200);
    }

    public function update(Request $request, $id)
    {
        $url_api = $this->api_hm_v2_pgw_partner_resgistri_banking . "/" . $id;
        $params = $request->all();

        foreach ($params as $items) {
            $msg = [];
            $postDate = [
                "banking_list_id" => $items['item-banking_id'],
                "code" => $items['item-code-res-bank'],
                "partner_code" => $items['item-partner_code'],
                "owner" => $items['item-owner'],
                "sort" => $items['item-sort_bank'],
                "type" => $items['type'],
                "description" => $items['description_bank'],
                "business" => $items['item-bank_business'],
                "branch" => $items['item-branch'],
                "bank_number" => $items['item-bank_number'],
            ];
            $update = Mycurl::putCurl($url_api, $postDate);
            if (!empty($update)) {;
                $msg['msg'] = 'success';
                $msg['status'] = $update['status'];
            } else {
                $msg['msg'] = 'error';
            }
        }
    }

    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_pgw_partner_resgistri_banking . "/" . $id;

        Mycurl::deleteCurl($url_api);
        return redirect()->back()->with(
            'notification', [
                'type' => 'success',
                'message' => 'Xoá dữ liệu thành công',
            ]
        );
    }
}
