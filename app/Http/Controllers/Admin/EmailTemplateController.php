<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BadRequest;
use App\Helper\Mycurl;
use App\Helper\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Email\EmailTemplateRequest;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    const DEFAULT_STATUS_ACTIVE = 'active';
    function __construct()
    {
        $this->api_hm_v2_template_emails = config('api.HOCMAI_API_V2') . "/api/v1/emails-templates";
    }

    public function index(Request $request)
    {
        $params             = $request->all();
        $params['limit']    = $request->limit ?? config('app.limit');
        $listPage           = config('app.listPage');
        try {
            $getListTemplateEmails  = Mycurl::getCurl($this->api_hm_v2_template_emails, $params);
            if (!empty($getListTemplateEmails)) {
                $listTemplateEmail  = $getListTemplateEmails['emailTemplate']['data'];
                $paginate           = $getListTemplateEmails['emailTemplate'];
                return view('main.admin.template-email.index')
                    ->with([
                        'listTemplateEmails' => $listTemplateEmail,
                        'paginate'           => $paginate,
                        'limit'              => $params['limit'],
                        'listPage'           => $listPage,
                        'filter'             => $params,
                    ]);
            } else {
                $listTemplatMessages = [];
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
        return view('main.admin.template-email.index')
            ->with('listTemplatMessages', $listTemplatMessages)
            ->with('error', "không có dữ liệu");
    }

    public function create()
    {
        try {
            return view('main.admin.template-email.create');
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    public function store(EmailTemplateRequest $request)
    {
        if ($request->method() == 'GET'){
            return $this->create();
        }elseif ($request->method() == 'POST') {
            $url_api    = $this->api_hm_v2_template_emails;
            $params     = $request->validated();
            try {
                if ($params) {
                    if ($request->hasfile('attachment_files')) {
                        $path               = 'images/course' . date("/Y/m/d/");
                        $attachment_files   = $params['attachment_files'];
                        $path_thumb_nail    = Upload::uploadImage($attachment_files, $path);
                        $params['attachment_files'] = $path_thumb_nail;
                    } else {
                        $params['attachment_files'] = $params['attachment_files'] ?? '';
                    }
                    $code               = $params['code'];
                    $name               = $params['name'];
                    $subject            = $params['subject'];
                    $content            = $params['content'];
                    $attachment_files   = $params['attachment_files'] ?? '';
                    $description        = $params['description'] ?? '';
                    $status             = $params['status'];
                    $postInput = [
                        "code"              => $code,
                        "name"              => $name,
                        "subject"           => $subject,
                        "content"           => $content,
                        "attachment_files"  => $attachment_files,
                        "description"       => $description,
                        "status"            => $status,
                    ];
                    $addTemplateEmails =  Mycurl::postCurl($url_api, $postInput);
                    if (!empty($addTemplateEmails)) {
                        return redirect()->route('emailTemplate.index')->with(
                            'notification', [
                                'type'      => 'success',
                                'message'   => 'Thêm Email Template thành công',
                            ]
                        );
                    }else{
                        $addTemplateEmails = [];
                    }
                }
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Thêm Email Template thất bại',
                    ]
                );
            } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }

        }
    }

    public function show_contact(Request $request)
    {
        $params = $request->all();
        try {
            $getPreview = Mycurl::getCurl($this->api_hm_v2_template_emails, $params);
                if ($getPreview) {
                    return response()->json([
                        'status' => 200,
                        'data' => $getPreview['emailTemplate']['data']
                    ]);
                } else {
                return response()->json([
                        'status' => 404,
                        'data' => 'fail'
                    ]
                );
            }
        } catch (\Throwable $e) {
                $line = $e->getLine();
                $code = !empty($e->getCode()) ? $e->getCode() : 400;
                return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
            }
    }


    public function edit($id)
    {
        try {
            $templateEmail = Mycurl::getCurl($this->api_hm_v2_template_emails, ['id' => $id]);
            if ($templateEmail) {
                return view('main.admin.template-email.edit')
                    ->with([
                        'templateEmail' => $templateEmail['emailTemplate']['data'][0],
                    ]);
            }else {
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Không có Email Template này',
                    ]
                );
            }
        } catch (\Throwable $e) {
            $line = $e->getLine();
            $code = !empty($e->getCode()) ? $e->getCode() : 400;
            return BadRequest::notificationBadRequest($e->getMessage(), $code, $line);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmailTemplateRequest $request, $id)
    {
        if ($request->method() == 'GET'){
            return $this->edit($id);
        }elseif ($request->method() == 'PUT') {
            $params     = $request->validated();
            $templateEmail = Mycurl::getCurl($this->api_hm_v2_template_emails, ['id' => $id]);
            try {
                if ($params) {
                    if ($request->hasfile('attachment_files')) {
                        $path               = 'images/course' . date("/Y/m/d/");
                        $attachment_files   = $params['attachment_files'];
                        $path_thumb_nail    = Upload::uploadImage($attachment_files, $path);
                        $params['attachment_files'] = $path_thumb_nail;
                    } else {
                        $params['attachment_files'] = $templateEmail['emailTemplate']['data'][0]['attachment_files'] ?? '';
                    }
                    $code               = $params['code'];
                    $name               = $params['name'];
                    $subject            = $params['subject'];
                    $content            = $params['content'];
                    $attachment_files   = $params['attachment_files'];
                    $description        = $params['description'];
                    $status             = $params['status'];
                    $postInput = [
                        "code"              => $code,
                        "name"              => $name,
                        "subject"           => $subject,
                        "content"           => $content,
                        "attachment_files"  => $attachment_files,
                        "description"       => $description,
                        "status"            => $status,
                    ];

                    $editTemplateEmails =  Mycurl::putCurl($this->api_hm_v2_template_emails . '/' . $id, $postInput);
                    if (!empty($editTemplateEmails)) {
                        return redirect()->route('emailTemplate.index')->with(
                            'notification', [
                                'type'      => 'success',
                                'message'   => 'Sửa Email Template thành công',
                            ]
                        );
                    }else{
                        $editTemplateEmails = [];
                    }
                }
                return back()->with(
                    'notification', [
                        'type' => 'fail',
                        'message' => 'Sửa Email Template thất bại',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url_api = $this->api_hm_v2_template_emails . "/" . $id;
        Mycurl::deleteCurl($url_api);
        return redirect()->back()->with(
            'notification', [
                'type' => 'success',
                'message' => 'Xoá dữ liệu thành công',
            ]
        );
    }
}
