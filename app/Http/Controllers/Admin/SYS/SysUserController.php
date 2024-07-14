<?php

namespace App\Http\Controllers\Admin\SYS;

use App\Helper\BadRequest;
use App\Helper\Mycurl;
use App\Helper\checkNotify;
use App\Helper\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\SYS\SysUserRequest;
use Exception;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Predis\ClientException;
use function Sodium\add;


class SysUserController extends Controller
{
    protected $api_hm_v2_partner;
    protected $api_hm_v2_sys_groups;
    protected $api_hm_v2_sys_user;
    protected $api_hm_v2_sys_user_groups;

    function __construct()
    {
        $this->api_hm_v2_partner = config('api.HOCMAI_API_V2') . "/api/v1/pgw-partner";
        $this->api_hm_v2_sys_groups = config('api.HOCMAI_API_V2') . "/api/v1/sys-groups";
        $this->api_hm_v2_sys_user = config('api.HOCMAI_API_V2') . "/api/v1/sys-users";
        $this->api_hm_v2_sys_user_groups = config('api.HOCMAI_API_V2') . "/api/v1/sys-users-groups";
        $this->api_hm_v2_landing_pages = config('api.HOCMAI_API_V2') . "/api/v1/landing-pages";
        $this->api_hm_v2_sys_user_landingpages = config('api.HOCMAI_API_V2') . "/api/v1/sys-users-landingpages";
    }

    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $params['get_landing_page'] = true;
            $params['orderBy'] = true;
            $params['limit'] = $request->limit ?? config('app.limit');
            $params['partner_code'] = $request['partner_code'] ? $request['partner_code'] : session('partner_code');

            $listPage = config('app.listPage');
            // lấy dữ liệu user
            $url_api_user = $this->api_hm_v2_sys_user;
            $getListUser = Mycurl::getCurl($url_api_user, $params);
            if ($getListUser == null) {
                return redirect()->route('home')->with(
                    'notification', [
                        'type' => 'error',
                        'message' => 'Không thể lấy được dữ liệu do lỗi máy chủ. Vui lòng thử lại sau',
                    ]
                );
            }
            // lấy dữ liệu partner
            $url_api_parner = $this->api_hm_v2_partner;
            $getListPartner = Mycurl::getCurl($url_api_parner);
            $listPartner = !empty($getListPartner['pgwPartner']['data']) ? $getListPartner['pgwPartner']['data'] : [];
            // lấy dữ liệu landingpage
            $url_api_landingpage = $this->api_hm_v2_landing_pages;
            $getListLandingPage = Mycurl::getCurl($url_api_landingpage, ['get_all' => true]);
            $listLandingPage = !empty($getListLandingPage['landingPages']) ? $getListLandingPage['landingPages'] : [];

            // lấy dữ liệu group
            $url_api_groups = $this->api_hm_v2_sys_groups;
            $getListGroup = Mycurl::getCurl($url_api_groups);
            $listGroup = !empty($getListGroup['sysGroup']['data']) ? $getListGroup['sysGroup']['data'] : [];

            $arrConstant = [
                'limit' => $params['limit'],
                'listPage' => $listPage,
                'listGroup' => $listGroup,
                'listPartner' => $listPartner,
                'listLandingPage' => $listLandingPage,
                'filter' => $params,
            ];

            if (!empty($getListUser)) {
                $paginator = $getListUser['sysUser']['data'];
                $paginate = $getListUser['sysUser'];

                return view('main.admin.SYS.SysUser.index')
                    ->with([
                        'paginator' => $paginator,
                        'paginate' => $paginate,
                        'arrConstant' => $arrConstant,
                    ]);
            } else {
                $paginator = [];
            }
            return view('main.admin.SYS.SysUser.index')
                ->with('paginator', $paginator)
                ->with('error', "không có dữ liệu");
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $url_api_landing_page = $this->api_hm_v2_landing_pages;
            $getListLangingPages = Mycurl::getCurl($url_api_landing_page, ['get_all' => true]);
            $langingPages = !empty($getListLangingPages['landingPages']) ? $getListLangingPages['landingPages'] : [];
            if (session('partner_code') == null) {
                $url_api = $this->api_hm_v2_partner;
                $getListPartner = Mycurl::getCurl($url_api);
                $listPartner = !empty($getListPartner['pgwPartner']['data']) ? $getListPartner['pgwPartner']['data'] : [];
                return view('main.admin.SYS.SysUser.create', compact('listPartner', 'langingPages'));
            } else {
                return view('main.admin.SYS.SysUser.create', compact('langingPages'));
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->method() == 'GET') {
            return $this->create();
        } elseif ($request->method() == 'POST') {
            $params = $request->all();
            if (session('partner_code') != null && session('owner') == "yes") {
                $params['owner'] = "no";
            }
            $url_api_sys_user = $this->api_hm_v2_sys_user;
            $url_api_sys_user_landingpage = $this->api_hm_v2_sys_user_landingpages;
            $url_api_sys_user_group = $this->api_hm_v2_sys_user_groups;
            $getUsers = Mycurl::getCurl($url_api_sys_user, ['get_all' => true]);
            if ($request->hasfile('thumb_path')) {
                $path = 'images/course' . date("/Y/m/d/");
                $thumb_path = $params['thumb_path'];
                $path_thumb_nail = Upload::uploadImage($thumb_path, $path);
                $params['thumb_path'] = $path_thumb_nail;
            } else {
                $params['thumb_path'] = $params['thumb_path_input'];
            }
            $rule = new SysUserRequest();
            $validator = Validator::make($params, $rule->rules(), $rule->messages());
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($params);
            }

            foreach ($getUsers['sysUser'] as $getUser) {
                if ($getUser['email'] == $params['email']) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withErrors(['email' => ' Email này đã tồn tại trên hệ thống, vui lòng kiểm tra lại'])
                        ->withInput($params);
                }
            }
            $postUser = [
                'partner_code' => $params['partner_code'],
                'name' => $params['fullname'],
                'email' => $params['email'],
                'phone' => $params['phone'],
                'address' => $params['address'],
                'status' => $params['status'],
                'profile_photo_path' => $params['thumb_path'],
            ];
            if (session('partner_code') != null && session('owner') == "no") {
                $postUser['owner'] = "no";
            } else {
                $postUser['owner'] = $params['owner'];
            }
            try {
                Mycurl::postCurl($url_api_sys_user, $postUser);
                $getlistUser = Mycurl::getCurl($url_api_sys_user, ['order_by' => 'id', 'direction' => 'desc']);
                $getfirstUser = $getlistUser['sysUser']['data']['0']['id'];
                $arrGroupUser = [];
                $arrLandingPageUser = [];
                if (isset($params['name_group'])) {
                    foreach ($params['name_group'] as $key => $items) {
                        if (empty($items)) {
                            continue;
                        }
                        $postGroupUser = [
                            "group_id" => intval($items),
                            "user_id" => $getfirstUser,
                        ];
                        $arrGroupUser[] = $postGroupUser;
                    }
                    Mycurl::postCurl($url_api_sys_user_group, ['user_group' => $arrGroupUser]);
                }
                if (isset($params['landing_page'])) {
                    foreach ($params['landing_page'] as $key => $landing_page) {
                        if (empty($landing_page)) {
                            continue;
                        }
                        $postLandingPageUser = [
                            "landing_page_id" => intval($landing_page),
                            "user_id" => $getfirstUser,
                        ];
                        $arrLandingPageUser[] = $postLandingPageUser;
                    }
                    Mycurl::postCurl($url_api_sys_user_landingpage, ['user_landingpage' => $arrLandingPageUser]);
                }
                return redirect()->route('sys_user.index')->with(
                    'notification', [
                        'type' => 'success',
                        'message' => 'Thêm nhóm người dùng thành công',
                    ]
                );
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $url_api_landing_page = $this->api_hm_v2_landing_pages;
            $getListLangingPages = Mycurl::getCurl($url_api_landing_page, ['get_all' => true]);
            $langingPages = !empty($getListLangingPages['landingPages']) ? $getListLangingPages['landingPages'] : [];
            $url_api = $this->api_hm_v2_partner;
            $getListPartner = Mycurl::getCurl($url_api);
            $listPartner = $getListPartner['pgwPartner']['data'];
            $url_api_user = $this->api_hm_v2_sys_user;
            $getListUser = Mycurl::getCurl($url_api_user, ['id' => $id, 'get_landing_page' => true]);
            $listUser = $getListUser['sysUser']['data'];
            $getIdLandingPage = [];
            foreach ($listUser[0]['landing_page'] as $items) {
                $getIdLandingPage[] = $items['id'];
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
        return view('main.admin.SYS.SysUser.edit', compact('listUser', 'listPartner', 'getIdLandingPage', 'langingPages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ($request->method() == 'GET') {
            return $this->edit($id);
        } elseif ($request->method() == 'PUT') {
            $params = $request->all();
            if (session('partner_code') != null && session('owner') == "no") {
                $params['owner'] = "no";
            }
            $url_api_sys_user_group = $this->api_hm_v2_sys_user_groups;
            $url_api_sys_user_landingpage = $this->api_hm_v2_sys_user_landingpages;
            $url_api_sys_user_id = $this->api_hm_v2_sys_user . "/" . $id;
            $url_api_sys_user = $this->api_hm_v2_sys_user;
            try {
                $getUsers = Mycurl::getCurl($url_api_sys_user);
                $checkData = Mycurl::getCurl($url_api_sys_user, ['id' => $id, 'get_landing_page' => true]);

                $rule = new SysUserRequest();
                $validator = Validator::make($params, $rule->rules(), $rule->messages());

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput($params);
                }
                foreach ($getUsers['sysUser']['data'] as $item) {
                    if (strtolower($item['email']) == strtolower($params['email']) && strtolower($item['email']) != strtolower($checkData['sysUser']['data'][0]['email'])) {
                        return redirect()->back()
                            ->withErrors($validator)
                            ->withErrors(['email' => 'Email đã tồn tại'])
                            ->withInput();
                    }
                }
                $getListUser = Mycurl::getCurl($url_api_sys_user, ['id' => $id]);
                $listUser = $getListUser['sysUser']['data'][0];
                $listUserGroup = Mycurl::getCurl($url_api_sys_user_group, ['user_id' => $id]);
                $userGroups = $listUserGroup['sysUserGroup']['data'];
                if ($request->hasfile('thumb_path')) {
                    $path = 'images/course' . date("/Y/m/d/");
                    $thumb_path = $params['thumb_path'];
                    $path_thumb_nail = Upload::uploadImage($thumb_path, $path);
                    $params['thumb_path'] = $path_thumb_nail;
                } else {
                    $params['thumb_path'] = $params['thumb_path_input'];
                }
                if ($params['partner_code'] != $listUser['partner_code'] && $listUser['partner_code'] != null) {
                    $arrOldUserGroup = [];
                    foreach ($listUser['groups'] as $items) {
                        $postGroupUser = [
                            "group_id" => $items['id'],
                            "user_id" => $id,
                        ];
                        $url_api_sys_group_user_id = $this->api_hm_v2_sys_user_groups . "/" . $id;
                        $arrOldUserGroup[] =$postGroupUser;
                    }
                    Mycurl::deleteCurl($url_api_sys_group_user_id, ['user_group' => $arrOldUserGroup]);
                    if (!empty($params['name_group'])){
                        $arrGroupNew = [];
                        foreach ($params['name_group'] as $item) {
                            $postGroupUserNew = [
                                "group_id" => $item,
                                "user_id" => $id,
                            ];
                            $arrGroupNew[] = $postGroupUserNew;
                        }
                        Mycurl::postCurl($url_api_sys_user_group, ['user_group' => $arrGroupNew]);
                    }
                }
                if ($params['partner_code'] == $listUser['partner_code'] || $listUser['partner_code'] == null) {
                    if (isset($params['name_group'])) {
                        $arrOldUserGroup = [];
                        foreach ($listUser['groups'] as $items) {
                            $arrOldUserGroup[] = $items['id'];
                        }
                        $arrNewUserGroup = [];
                        foreach ($params['name_group'] as $key => $item) {
                            $arrNewUserGroup[] = intval($item);
                        }
                        $arrDiffentNew = array_diff($arrNewUserGroup, $arrOldUserGroup);
                        $arrDiffentOld = array_diff($arrOldUserGroup, $arrNewUserGroup);
                        if (!empty($arrDiffentNew)) {
                            $arrGroupNew = [];
                            foreach ($arrDiffentNew as $arrDiffentNew) {
                                $postGroupUserNew = [
                                    "group_id" => $arrDiffentNew,
                                    "user_id" => $id,
                                ];
                                $arrGroupNew[] = $postGroupUserNew;
                            }
                            Mycurl::postCurl($url_api_sys_user_group, ['user_group' => $arrGroupNew]);
                        }
                        if (!empty($arrDiffentOld)) {
                            $arrUserGroups = [];
                            foreach ($arrDiffentOld as $arrDiffentOld) {
                                $postGroupUser = [
                                    "group_id" => $arrDiffentOld,
                                    "user_id" => $id,
                                ];
                                $url_api_sys_group_user_id = $this->api_hm_v2_sys_user_groups . "/" . $id;
                                $arrUserGroups[] = $postGroupUser;
                            }
                            Mycurl::deleteCurl($url_api_sys_group_user_id, ['user_group' => $arrUserGroups]);
                        }
                    }
                }
                $idLandingPage = [];
                foreach ($checkData['sysUser']['data'][0]['landing_page'] as $key => $items) {
                    $idLandingPage[] = $items['id'];
                }
                if (isset($params['landing_page'])) {
                    if ($idLandingPage == null) {
                        foreach ($params['landing_page'] as $key => $landing_page) {
                            if (empty($landing_page)) {
                                continue;
                            }
                            $postLandingPageUser = [
                                "landing_page_id" => intval($landing_page),
                                "user_id" => $checkData['sysUser']['data'][0]['id'],
                            ];
                            $arrLandingPageUser[] = $postLandingPageUser;
                        }
                        Mycurl::postCurl($url_api_sys_user_landingpage, ['user_landingpage' => $arrLandingPageUser]);
                    } else {
                        foreach ($params['landing_page'] as $key => $landing_page) {
                            $idParamLandingPage[] = (int)$landing_page;
                        }
                        $arrIdLandingOld = array_diff($idLandingPage, $idParamLandingPage);
                        $arrIdLandingNew = array_diff($idParamLandingPage, $idLandingPage);
                        if ($arrIdLandingNew != null) {
                            foreach ($arrIdLandingNew as $key => $landing_page) {
                                if (empty($landing_page)) {
                                    continue;
                                }
                                $postLandingPageUser = [
                                    "landing_page_id" => intval($landing_page),
                                    "user_id" => $checkData['sysUser']['data'][0]['id'],
                                ];
                                $arrLandingPage[] = $postLandingPageUser;
                            }
                            Mycurl::postCurl($url_api_sys_user_landingpage, ['user_landingpage' => $arrLandingPage]);
                        }
                        if ($arrIdLandingOld != null) {
                            foreach ($arrIdLandingOld as $arrIdLandingOld) {
                                $postLandingPageUser = [
                                    "landing_page_id" => $arrIdLandingOld,
                                    "user_id" => (int)$id,
                                ];
                                $url_api_hm_v2_sys_user_landingpages_id = $this->api_hm_v2_sys_user_landingpages . "/" . $id;
                                $arrLandingPageUser[] = $postLandingPageUser;
                            }
                            Mycurl::deleteCurl($url_api_hm_v2_sys_user_landingpages_id, ['user_landingpage' => $arrLandingPageUser]);
                        }
                    }

                } else {
                    if ($checkData['sysUser']['data'][0]['landing_page'] != null) {
                        foreach ($checkData['sysUser']['data'][0]['landing_page'] as $key => $items) {
                            $postLandingPageUser = [
                                "landing_page_id" => $items['id'],
                                "user_id" => (int)$id,
                            ];
                            $url_api_hm_v2_sys_user_landingpages_id = $this->api_hm_v2_sys_user_landingpages . "/" . $id;
                            $deleteArrayUserLanding[] = $postLandingPageUser;
                        }
                        Mycurl::deleteCurl($url_api_hm_v2_sys_user_landingpages_id, ['user_landingpage' => $deleteArrayUserLanding]);

                    }

                }
                $putUser = [
                    'partner_code' => isset($params['partner_code']) ? $params['partner_code'] : "",
                    'name' => $params['fullname'],
                    'email' => $params['email'],
                    'phone' => $params['phone'],
                    'address' => $params['address'],
                    'status' => $params['status'],
                    'profile_photo_path' => $params['thumb_path'],
                ];
                if (session('partner_code') != null && session('owner') == "no") {
                    $putUser['owner'] = "no";
                } else {
                    $putUser['owner'] = $params['owner'];
                }
               Mycurl::putCurl($url_api_sys_user_id, $putUser);
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
        }
        return redirect()->route('sys_user.index')->with(
            'notification', [
                'type' => 'success',
                'message' => 'Cập nhật người dùng thành công',
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getnameGroup(Request $request)
    {
        $params = $request->all();
        $url_api = $this->api_hm_v2_sys_groups;
        $getListData = Mycurl::getCurl($url_api, ['partner_code' => $params['partner_code']]);
        $listData = $getListData['sysGroup']['data'];
        if (isset($params['use_id'])) {
            $url_api_user = $this->api_hm_v2_sys_user;
            $getUser = Mycurl::getCurl($url_api_user, ['id' => $params['use_id']]);
            $listUserGroup = $getUser['sysUser']['data'][0]['groups'];
            return response()->json([
                    'status' => 1,
                    'listData' => $listData,
                    'listUserGroup' => $listUserGroup,
                ]
            );
        } else {
            return response()->json([
                    'status' => 1,
                    'listData' => $listData,
                ]
            );
        }

    }

    public function changOwner(Request $request)
    {
        $params = $request->all();
        $url_api_sys_user_id = $this->api_hm_v2_sys_user . "/" . $params['idUser'];
        $putUser['owner'] = "no";
        Mycurl::putCurl($url_api_sys_user_id, $putUser);
        return response()->json([
                'status' => 1
            ]
        );
    }
    public function checkOwner(Request $request)
    {
        $params = $request->all();
        $url_api_sys_user = $this->api_hm_v2_sys_user;
        $getUsers = Mycurl::getCurl($url_api_sys_user,['get_all' => true,'partner_code'=>$params['data']]);
        foreach ($getUsers['sysUser'] as $item) {
                if ($item['owner'] == "yes") {
                    return response()->json([
                            'status' => 1,
                            'nameWithOwner' => $item['name'],
                            'idUser' => $item['id'],
                        ]
                    );
                }
        }
        return response()->json([
                'status' => 2,
            ]
        );

    }
    public function changStatus($id)
    {
        $url_api_user_id = $this->api_hm_v2_sys_user . "/" . $id;
        $url_api_user = $this->api_hm_v2_sys_user;
        $getListUser = Mycurl::getCurl($url_api_user, ['id' => $id]);
        $getStatusUser = $getListUser['sysUser']['data'][0]['status'];
        if ($getStatusUser == "active") {
            Mycurl::putCurl($url_api_user_id, [
                "status" => "inactive"
            ]);
        } else {
            Mycurl::putCurl($url_api_user_id, [
                "status" => "active"
            ]);
        }
        return redirect()->route('sys_user.index')->with(
            'notification', [
                'type' => 'success',
                'message' => 'Đổi trạng thái thành công',
            ]
        );
    }
}
