<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BadRequest;
use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HocmaiController;
use App\Http\Requests\SMS\SMSTemplateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MessageTemplateController extends HocmaiController
{
    const DEFAULT_LDP_ID = 0;
    const DEFAULT_PARENT_ID = 0;
    const DEFAULT_STATUS_ACTIVE = 'active';

    function __construct()
    {
        $this->api_hm_v2_template_messages = config('api.HOCMAI_API_V2') . "/api/v1/message-templates";
        parent::__construct();
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        $paramLDP = ['order' => 'id', 'direction' => 'desc', 'get_all' => true];
        $dataLDP = $this->getLDP($paramLDP,false);
//        $params['landing_page_id'] = $request['landing_page_id'] ? $request['landing_page_id'] : session('landing_page');
//        $params['search_submit'] = $request['landing_page_id'] ? true : null;
        try {
            $getListTemplatMessages = Mycurl::getCurl($this->api_hm_v2_template_messages, $params);
            if (!empty($getListTemplatMessages)) {
                $listTemplatMessages = $getListTemplatMessages['messageTemplate']['data'];
                $paginate = $getListTemplatMessages['messageTemplate'];
                return view('main.admin.template-messages.index')
                    ->with([
                        'listTemplatMessages' => $listTemplatMessages,
                        'dataLDP' => $dataLDP,
                        'paginate' => $paginate,
                        'limit' => $params['limit'],
                        'listPage' => $listPage,
                        'filter' => $params,
                    ]);
            } else {
                $listTemplatMessages = [];
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
        return view('main.admin.SYS.SysPermission.index')
            ->with('listTemplatMessages', $listTemplatMessages)
            ->with('error', "không có dữ liệu");

    }

    public function create()
    {
        try {
            $paramLDP = ['order' => 'id', 'direction' => 'desc', 'get_all' => true];
            $datasLdp = $this->getLDP($paramLDP,false);
            return view('main.admin.template-messages.create')->with([
                'dataLDP' => $datasLdp,
            ]);
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function store(SMSTemplateRequest $request)
    {
        if ($request->method() == 'GET') {
            return $this->create();
        } elseif ($request->method() == 'POST') {
            $filter = $request->validated();
            $filter['parent_id'] = self::DEFAULT_PARENT_ID;
            $filter['status'] = self::DEFAULT_STATUS_ACTIVE;
            try {
                if ($filter) {
                    $templateMessages = Mycurl::postCurl($this->api_hm_v2_template_messages, $filter);
                    if ($templateMessages) {
                        return Redirect::route('template_messages.index')->with(
                            'notification', [
                                'type' => 'success',
                                'message' => 'Thêm SMS Template thành công',
                            ]
                        );
                    }
                }
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Thêm SMS Template thất bại',
                    ]
                );
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
        }
        //
    }

    public function edit($id)
    {
        try {
            $paramLDP = ['order' => 'id', 'direction' => 'desc', 'get_all' => true];
            $datasLdp = $this->getLDP($paramLDP,false);
            $templateMessages = Mycurl::getCurl($this->api_hm_v2_template_messages, ['id' => $id]);
            if ($templateMessages) {
                return view('main.admin.template-messages.edit')
                    ->with([
                        'templateMessages' => $templateMessages['messageTemplate']['data'][0],
                        'dataLDP' => $datasLdp,
                    ]);
            }else {
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Không có SMS Template này',
                    ]
                );
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function update(SMSTemplateRequest $request, $id)
    {
        if ($request->method() == 'GET') {
            return $this->edit($id);
        } elseif ($request->method() == 'PUT') {
            $param = $request->validated();
            try {
                if ($param) {
                    $templateMessages = Mycurl::putCurl($this->api_hm_v2_template_messages . '/' . $id, $param);
                    if ($templateMessages) {
                        return Redirect::route('template_messages.index')->with(
                            'notification', [
                                'type' => 'success',
                                'message' => 'Cập nhật SMS Template thành công',
                            ]
                        );
                    }
                }
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Cập nhật SMS Template thất bại',
                    ]
                );
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
        }
    }

    public function statusChange(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        try {
            $templateMessages = Mycurl::putCurl($this->api_hm_v2_template_messages . '/' . $id, ['status' => $status, 'updated_by' => session('google_id')]);
            return $templateMessages;
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function destroy($id)
    {
        try {
            $templateMessages = Mycurl::deleteCurl($this->api_hm_v2_template_messages . '/' . $id);
            return back()->with(
                'notification', [
                'type' => 'success',
                'message' => 'Đã xoá SMS Template',
            ]);
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }
}
