<?php

namespace App\Http\Controllers\Admin\SYS;

use App\Helper\Mycurl;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SysModulesController extends Controller
{
    protected $api_hm_v2_sys_modules;

    function __construct()
    {
        $this->api_hm_v2_sys_modules = config('api.HOCMAI_API_V2') . "/api/v1/sys-modules";

    }

    public function index(Request $request)
    {
        $params = $request->all();
        $params['limit'] = $request->limit ?? config('app.limit');
        $listPage = config('app.listPage');
        $limit = $params['limit'];
        $url_api = $this->api_hm_v2_sys_modules;
        $getListModules = Mycurl::getCurl($url_api, $params);
        if (!empty($getListModules)) {
            $paginator = $getListModules['sysModule']['data'];
            $paginate = $getListModules['sysModule'];
            return view('main.admin.SYS.SysModules.index', compact('limit', 'listPage', 'paginator', 'paginate'));
        } else {
            $paginator = [];
        }
        return view('main.admin.SYS.SysModules.index')
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $url_api = $this->api_hm_v2_sys_modules;
        $listModules = Mycurl::getCurl($url_api, ['id' => $id]);
        $getListModules = $listModules['sysModule']['data'][0];
        return view('main.admin.SYS.SysModules.edit', compact('getListModules'));
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
            $url_api = $this->api_hm_v2_sys_modules . "/" . $id;
            $url_api_list_modules = $this->api_hm_v2_sys_modules;
            $getData = Mycurl::getCurl($url_api_list_modules, ['get_all' => true]);
            $checkData = Mycurl::getCurl($url_api_list_modules, ['id' => $id]);
            foreach ($getData['sysModule'] as $item) {
                if ($item['module_alias'] == $params['module_alias'] && $item['module_alias'] != $checkData['sysModule']['data'][0]['module_alias']) {
                    return redirect()->back()
                        ->withErrors(['module_alias' => 'Tên modules_alias đã tồn tại'])
                        ->withInput();
                }
            }
            Mycurl::putCurl($url_api, ["module_alias" => $params['module_alias']]);
            return redirect()->route('sys_modules.index')->with(
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
