<?php

namespace App\Http\Controllers\Admin\SYS;

use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use App\Http\Requests\SYS\SysGroupRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SysGroupController extends Controller
{
    protected $api_hm_v2_partner;
    protected $api_hm_v2_sys_modules;
    protected $api_hm_v2_sys_group;
    protected $api_hm_v2_sys_group_permission;
    protected $api_hm_v2_sys_permission;

    function __construct()
    {
        $this->api_hm_v2_partner = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner";
        $this->api_hm_v2_sys_modules = config('api.HOCMAI_API_V2') . "/api/v1/sys-modules";
        $this->api_hm_v2_sys_group = config('api.HOCMAI_API_V2') . "/api/v1/sys-groups";
        $this->api_hm_v2_group_permission = config('api.HOCMAI_API_V2') . "/api/v1/sys-group-permissions";
        $this->api_hm_v2_permission = config('api.HOCMAI_API_V2') . "/api/v1/sys-permissions";
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        $url_api_parner = $this->api_hm_v2_partner;
        $url_api_group = $this->api_hm_v2_sys_group;
        $getListPartner = Mycurl::getCurl($url_api_parner);
        $listPartner = $getListPartner['pgwPartner']['data'];
        $getListGroup = Mycurl::getCurl($url_api_group, $params);
        $paginator = $getListGroup['sysGroup']['data'];
        $paginate = $getListGroup['sysGroup'];

        return view('main.admin.SYS.SysGroup.index')
            ->with([
                'paginator' => $paginator,
                'paginate' => $paginate,
                'limit' => $params['limit'],
                'listPartner' => $listPartner,
                'filter' => $params,
                'listPage' => $listPage,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $url_api = $this->api_hm_v2_partner;
        $getListPartner = Mycurl::getCurl($url_api);
        $listPartner = $getListPartner['pgwPartner']['data'];
        return view('main.admin.SYS.SysGroup.create', compact('listPartner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SysGroupRequest $request)
    {
        if ($request->method() == 'GET') {
            return $this->create();
        } elseif ($request->method() == 'POST') {
            $params = $request->all();
            $url_api_sys_group = $this->api_hm_v2_sys_group;
            $getGroups = Mycurl::getCurl($url_api_sys_group);
            foreach ($getGroups['sysGroup']['data'] as $getGroup) {
                if (strtolower($getGroup['name']) == strtolower($params['group_name'])) {
                    return redirect()->back()
                        ->withErrors(['group_name' => 'Tên nhóm đã tồn tại'])
                        ->withInput($params);
                }
            }
            $postGroup = [
                'partner_code' => $params['partner_code'],
                'name' => $params['group_name'],
                'status' => $params['status'],
                'description' => $params['description'],
            ];
            Mycurl::postCurl($url_api_sys_group, $postGroup);
            return redirect()->route('sys_group.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Thêm nhóm quyền thành công',
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url_api_sys_group = $this->api_hm_v2_sys_group;
        $getListGroup = Mycurl::getCurl($url_api_sys_group, ['id' => $id]);
        $listGroup = $getListGroup['sysGroup']['data'][0];
        $url_api = $this->api_hm_v2_partner;
        $getListPartner = Mycurl::getCurl($url_api);
        $listPartner = $getListPartner['pgwPartner']['data'];
        return view('main.admin.SYS.SysGroup.edit', compact('listGroup', 'listPartner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SysGroupRequest $request, $id)
    {
        if ($request->method() == 'GET') {
            return $this->edit($id);
        } elseif ($request->method() == 'PUT') {
            $params = $request->all();
            $url_api_sys_group = $this->api_hm_v2_sys_group;
            $url_api_sys_group_id = $this->api_hm_v2_sys_group . "/" . $id;
            $getGroups = Mycurl::getCurl($url_api_sys_group);
            $checkData = Mycurl::getCurl($url_api_sys_group, ['id' => $id]);

            foreach ($getGroups['sysGroup']['data'] as $item) {
                if (strtolower($item['name']) == strtolower($params['group_name']) && strtolower($item['name']) != strtolower($checkData['sysGroup']['data'][0]['name'])) {
                    return redirect()->back()
                        ->withErrors(['group_name' => 'Tên nhóm tồn tại'])
                        ->withInput();
                }
            }
            $postGroup = [
                'partner_code' => $params['partner_code'],
                'name' => $params['group_name'],
                'status' => $params['status'],
                'description' => $params['description'],
                "updated_at" => date("H:i:s d-m-Y", strtotime(Carbon::now())),
            ];
            Mycurl::putCurl($url_api_sys_group_id, $postGroup);
            return redirect()->route('sys_group.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Cập nhật nhóm quyền thành công',
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_sys_group . "/" . $id;

        Mycurl::deleteCurl($url_api);

        return redirect()->route('sys_group.index')->with(
            'notification', [
                'type' => 'success',
                'message' => 'Xoá dữ liệu thành công',
            ]
        );
    }
}
