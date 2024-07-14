<?php

namespace App\Http\Controllers\Auth;

use App\Helper\Upload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $path_file = '';
        if ($request->hasfile('file')) {
            $path = 'images/static' . date("/Y/m/d/");
            $file = $params['file'];
            $path_file = Upload::uploadImage($file, $path);
        }

        return response()->json([
            'location' => config('api.API_HOCMAI_MEDIA_V2', '') . '/' . $path_file,
        ]);
    }
}
