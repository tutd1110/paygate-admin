<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RandomGiftsExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper\Mycurl;
use App\Helper\BadRequest;
use Maatwebsite\Excel\Facades\Excel;


class RandomGiftContactController extends Controller
{
    protected $api_hm_v2_randomGiftContact;
    protected $api_hm_v2_giftInfo;
    protected $ldp_id;

    function __construct()
    {
        $this->api_hm_v2_randomGiftContact = config('api.HOCMAI_API_V2') . "/api/v1/wheels/gift-random-contact";
        $this->api_hm_v2_giftInfo = config('api.HOCMAI_API_V2') . "/api/v1/wheels/infos";
        $this->ldp_id = 104;
    }

    public function index(Request $request)
    {
        $param = $request->all();
        $param['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        $param['gift'] = !empty($param['export']) ? null : true;
        $param['contact'] = !empty($param['export']) ? null : true;
        $param['ticket'] = !empty($param['export']) ? null : true;
        $param['order_by'] = ['id'];
        $param['direction'] = ['desc'];
        $param['landing_page_id'] = $this->ldp_id;
        $url_api = $this->api_hm_v2_randomGiftContact;
        $url_api_gift = $this->api_hm_v2_giftInfo;
        try {
            $getrandomGiftContacts = Mycurl::getCurl($url_api, $param);
            if ($getrandomGiftContacts['listRandomGiftContact'] && !empty($param['export'])) {
                if (empty($getrandomGiftContacts['listRandomGiftContact'])) {
                    return BadRequest::notificationBadRequest('Không có dữ liệu để Export', 500, null);
                }
                $name = "Export_RandomGift_" . Carbon::now()->format('Y-m-d');
                return Excel::download(new RandomGiftsExport($getrandomGiftContacts['listRandomGiftContact']), $name . '.xlsx');
            }
            $giftInfo = Mycurl::getCurl($url_api_gift,$param);
            if (!empty($getrandomGiftContacts)) {
                $getrandomGiftContact = $getrandomGiftContacts['listRandomGiftContact']['data'];
                return view('main.admin.randomGift.index')->with([
                    'listRandomGiftContact' => $getrandomGiftContact,
                    'filter' => $param,
                    'limit' => $param['limit'],
                    'listPage' => $listPage,
                    'paginate' => $getrandomGiftContacts['listRandomGiftContact'],
                    'listGiftInfo' => $giftInfo['gift'],
                    'countRandomGiftContact' => $getrandomGiftContacts['listRandomGiftContact']['total']
                ]);
            }else {
                $getrandomGiftContacts = [];
            }
        }catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }

    }

    public function export(Request $request)
    {
        $param = $request->all();
        $param['get_all'] = true;
        $param['export'] = true;
        $param['contact'] = true;
        $param['ticket'] = true;
        $param['gift'] = true;
        $param['landing_page_id'] = $this->ldp_id;
        try {
            $getDataRandomGift = Mycurl::getCurl($this->api_hm_v2_randomGiftContact, $param);
            if ($getDataRandomGift) {
//                return $getDataRandomGift['listRandomGiftContact'];
                $name = "Export_RandomGift_" . Carbon::now()->format('Y-m-d');
                return Excel::download(new RandomGiftsExport($getDataRandomGift['listRandomGiftContact']), $name . '.xlsx');
            }
            return false;
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
