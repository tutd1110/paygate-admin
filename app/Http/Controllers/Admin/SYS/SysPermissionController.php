<?php

namespace App\Http\Controllers\Admin\SYS;

use App\Helper\BadRequest;
use App\Helper\CheckNotify;
use App\Helper\Mycurl;
use App\Helper\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\PGW\BankingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class SysPermissionController extends Controller
{
    protected $api_hm_v2_sys_permission;
    protected $api_hm_v2_sys_modules;
    protected $api_hm_v2_sys_group;
    protected $api_hm_v2_sys_group_permission;
    protected $api_hm_v2_partner;

    function __construct()
    {
        $this->api_hm_v2_sys_permission = config('api.HOCMAI_API_V2') . "/api/v1/sys-permissions";
        $this->api_hm_v2_sys_modules = config('api.HOCMAI_API_V2') . "/api/v1/sys-modules";
        $this->api_hm_v2_sys_group = config('api.HOCMAI_API_V2') . "/api/v1/sys-groups";
        $this->api_hm_v2_group_permission = config('api.HOCMAI_API_V2') . "/api/v1/sys-group-permissions";
        $this->api_hm_v2_partner = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner";

    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        // lấy dữ liệu permiss

        $url_api_permiss = $this->api_hm_v2_sys_permission;
        $url_api_modules = $this->api_hm_v2_sys_modules;
        try {
            $getListModules = Mycurl::getCurl($url_api_modules);
            $getListPermiss = Mycurl::getCurl($url_api_permiss, $params);
            $listModule = $getListModules['sysModule']['data'];
            if (!empty($getListPermiss)) {
                $paginator = $getListPermiss['sysPermission']['data'];
                $paginate = $getListPermiss['sysPermission'];
                return view('main.admin.SYS.SysPermission.index')
                    ->with([
                        'paginator' => $paginator,
                        'paginate' => $paginate,
                        'limit' => $params['limit'],
                        'listPage' => $listPage,
                        'filter' => $params,
                        'listModule' => $listModule,
                    ]);
            } else {
                $paginator = [];
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
        return view('main.admin.SYS.SysPermission.index')
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
        try {
            $url_api_group = $this->api_hm_v2_sys_group;
            $getListGroup = Mycurl::getCurl($url_api_group);
            $listGroup = $getListGroup['sysGroup']['data'];
            // lấy danh sách module
            $url_api_sys_modules = $this->api_hm_v2_sys_modules;
            $getListModules = Mycurl::getCurl($url_api_sys_modules);
            $listModules = $getListModules['sysModule']['data'];
            // lấy danh sách parner
            $url_api_partner = $this->api_hm_v2_partner;
            $getListPartner = Mycurl::getCurl($url_api_partner);
            $listPartner = $getListPartner['pgwPartner']['data'];

        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
        return view('main.admin.SYS.SysGroup-Permission.create', compact('listModules', 'listGroup', 'listPartner'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        if ($request->method() == 'GET') {
            if (!empty($params)) {
                return $this->getnamePermission($params);
            } else {
                return $this->create();
            }
        } elseif ($request->method() == 'POST') {

            $redis = Redis::connection();
            $url_api_sys_group = $this->api_hm_v2_sys_group;
            $url_api_sys_group_permission = $this->api_hm_v2_group_permission;
            try {
                $getlistGroup = Mycurl::getCurl($url_api_sys_group, ['id' => $params['group']]);
                $listGroupPermiss = $getlistGroup['sysGroup']['data']['0']['sys_group_permission']; /* kiểm tra nhóm mới tạo có quyền chưa */

                $arrOldPermis = [];
                foreach ($listGroupPermiss as $items) {
                    $arrOldPermis[] = $items['permission_id'];
                }
                $arrNewPermis = [];
                foreach ($params['list_permission'] as $key => $item) {
                    $arrNewPermis[] = $key;
                }

                $arrDiffentNew = array_diff($arrNewPermis, $arrOldPermis);
                $arrDiffentOld = array_diff($arrOldPermis, $arrNewPermis);

                $permissNew = [];
                if (!empty($arrDiffentNew)) {

                    foreach ($arrDiffentNew as $arrPermisNew) {
                        $postPermissNew = [
                            "group_id" => $params['group'],
                            "permission_id" => $arrPermisNew,
                        ];
                        $permissNew[] = $postPermissNew;
                    }
                    Mycurl::postCurl($url_api_sys_group_permission, ['group_permission' => $permissNew]);
                }
                if (!empty($arrDiffentOld)) {
                    $permissOld = [];
                    foreach ($arrDiffentOld as $arrPermisOld) {
                        $postPermissOld = [
                            "group_id" => $params['group'],
                            "permission_id" => $arrPermisOld,
                        ];
                        $permissOld[] = $postPermissOld;
                    }
                    $url_api_sys_group_permission_id = $this->api_hm_v2_group_permission . "/" . '1';
                    Mycurl::deleteCurl($url_api_sys_group_permission_id, ['group_permission' => $permissOld]);
                }
                if (!empty($listGroupPermiss)) {
                    $arrPermisRedis = $redis->keys("*");
                    if (!empty($arrPermisRedis)) {
                        foreach ($arrPermisRedis as $arr) {
                            $IdGroup = strpos($arr, json_encode($listGroupPermiss['0']['group_id']));
                            if ($IdGroup == true) {
                                $trimmed = str_replace('laravel_database_' . $params['partner'] . "_", '', $arr);
                                $redis->delete($params['partner'] . "_" . $trimmed);
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);

            }
            return redirect()->route('sys_group.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Phân quyền thành công',
                ]
            );
        }
    }

    public function getnamePermission($params)
    {
        $url_api_sys_group = $this->api_hm_v2_sys_group;
        $getListGroup = Mycurl::getCurl($url_api_sys_group, ['id' => $params['id']]);
        $listGroupPermiss = $getListGroup['sysGroup']['data'][0]['sys_group_permission']; // lấy danh sách permis thuộc id group
        $url_api_sys_modules = $this->api_hm_v2_sys_modules;
        $getListModules = Mycurl::getCurl($url_api_sys_modules);
        $listModules = $getListModules['sysModule']['data'];
        return response()->json([
                'status' => 1,
                'listGroupPermiss' => $listGroupPermiss,
                'listModules' => $listModules,
            ]
        );
    }

    public function scanModulePerission()
    {
        try {
            $routeCollection = app()->router->getRoutes();
            $routeCheckFolderAdmin = "App\Http\Controllers\Admin";
            $listRouter = [];
            $nameModules = [];
            foreach ($routeCollection as $value) {
                $checkRoute = substr($value->getActionName(), 0, strlen($routeCheckFolderAdmin));
                if ($checkRoute == $routeCheckFolderAdmin) {
                    $nameModule = preg_replace('/[^A-Za-z0-9\-]/', '-', $value->getActionName());
                    $nameModule = explode('-', $nameModule);
                    $nameModule = explode('Controller', $nameModule[count($nameModule) - 2]);
                    array_push($nameModules, $nameModule[0]);
                    array_push($listRouter, $value->getActionName());
                }
            }
            $param = [
                'listRoutes' => array_unique($listRouter),
                'nameModules' => array_unique($nameModules),
                'session_id' => session('id')
            ];
            $response = Mycurl::postCurl($this->api_hm_v2_sys_permission . '/scan', $param);
            return back()->with(
                'notification', [
                    'message' => $response['message'],
                    'type' => $response['type'],]
            );
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 500;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function edit($id)
    {
        $url_api = $this->api_hm_v2_sys_permission;
        $listPermision = Mycurl::getCurl($url_api, ['id' => $id]);
        $getListPermision = $listPermision['sysPermission']['data'][0];
        return view('main.admin.SYS.SysPermission.edit', compact('getListPermision'));
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
        if ($request->method() == 'GET') {
            return $this->edit($id);
        } elseif ($request->method() == 'PUT') {
            $params = $request->all();
            $url_api = $this->api_hm_v2_sys_permission . "/" . $id;
            $url_api_list_permission = $this->api_hm_v2_sys_permission;
            $getData = Mycurl::getCurl($url_api_list_permission, ['get_all' => true]);
            $checkData = Mycurl::getCurl($url_api_list_permission, ['id' => $id]);
            foreach ($getData['sysPermission'] as $item) {
                if ($item['name_alias'] == $params['name_alias'] && $item['name_alias'] != $checkData['sysPermission']['data'][0]['name_alias']) {
                    return redirect()->back()
                        ->withErrors(['name_alias' => 'Tên quyền đã tồn tại'])
                        ->withInput();
                }

            }
            Mycurl::putCurl($url_api, ["name_alias" => $params['name_alias'],]);
            return redirect()->route('sys_permission.index')->with(
                'notification', [
                    'type' => 'success',
                    'message' => 'Cập nhật thành công',
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
        //
    }
}
