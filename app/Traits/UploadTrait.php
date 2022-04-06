<?php

namespace App\Traits;
use Illuminate\Support\Facades\Storage;
use Request;
use Imagify;
trait UploadTrait
{



    public function uploadImg( $file , $directory = 'unknown' ){
        if( \Illuminate\Support\Facades\Request::wantsJson() ) {
            return  $this->uploadBase64($file, $directory);
        }else{
            return  $this->uploadFile($file, $directory);
        }
    }

    public function uploadFile($file, $directory = 'unknown') : string
    {
        $name = time() . rand(1000000, 9999999) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('/images/' . $directory, $name);
        return $name;
    }

    public static function uploadBase64($base64, $path) : string
    {
        $imgName   = uniqid() . '-' . time() . '-' . rand(1111,9999) . '.jpg';
        file_put_contents(base_path().'/storage/app/public/images/' . $path . '/' . $imgName, base64_decode($base64));
        return (string) $imgName;
    }

    public function deleteFile($file_name, $directory = 'unknown') : void
    {
        $image = null;
        if($file_name){
            $link_array = explode('/',$file_name);
            $image = end($link_array);
        }

        if ($image && Storage::exists('images/' . $directory . '/' . $image)) {
            Storage::delete('images/' . $directory . '/' . $image);
        }
    }
}
