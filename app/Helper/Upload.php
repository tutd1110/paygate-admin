<?php
namespace App\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Upload
{
    static function uploadImage($file, $path){
        $path_image = "";
        if($file){
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            Storage::disk('public')->put($path . $fileName, File::get($file));

            $path_image = "storage/".$path.$fileName;
        }

        return $path_image;
    }
}
